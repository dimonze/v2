<?php

require_once dirname(__FILE__).'/../lib/letterGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/letterGeneratorHelper.class.php';

/**
 * letter actions.
 *
 * @package    garage
 * @subpackage letter
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class letterActions extends autoLetterActions
{
  public function executeShow()
  {
    $letter = $this->getRoute()->getObject();
    $this->forward404Unless($letter);

    return $this->renderPartial('letter/letter-layout', array('letter' => $letter));
  }

  public function executeSource()
  {
    $letter = $this->getRoute()->getObject();
    $this->forward404Unless($letter);

    $this->getResponse()->setContentType('text/plain');
    return $this->renderText($this->getPartial('letter/letter-layout', array('letter' => $letter)));
  }

  public function executeMatch(sfWebRequest $request)
  {
    $q = $request->getParameter('q', '');
    $lang = $request->getParameter('lang', 'ru');
    if (empty($q) || mb_strlen($q) < 3) return $this->renderText(json_encode(array()));

    $query = Doctrine::getTable('Event')->createQuery('e')
            ->innerJoin('e.Translation t with t.title <> "" and t.lang = ?', $lang)
            ->andWhere('t.title LIKE ?', $request->getParameter('q').'%')
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY_SHALLOW);

    $data = array();
    foreach ($query->execute() as $item) {
      $data[$item['id']] = $item['title'];
    }

    return $this->renderText(json_encode($data));
  }

  public function executeAddItem(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $letter_id = $request->getParameter('letter_id');
    $index = $request->getParameter('index');
    $lang = $request->getParameter('lang', 'ru');
    if (!ctype_digit($id) || !ctype_digit($index)) return $this->renderText('');

    $object = $letter_id ? Doctrine::getTable('Letter')->find($letter_id) : null;
    $form = new LetterForm($object);
    $form->addEventsWidget($index);

    $item = Doctrine::getTable('Event')
            ->createQueryI18N('e', $lang)
            ->andWhere('e.id = ?', $id)
            ->fetchOne();

    return $this->renderPartial('letter/event-item', array(
      'item'    => $item,
      'lang'    => $lang,
      'index'   => $index,
      'form'    => $form,
      'options' => array(),
    ));
  }

  public function executeAddWidget(sfWebRequest $request)
  {
    $index = $request->getParameter('index');
    if (!ctype_digit($index)) return $this->renderText('');

    $form = new LetterForm();
    $form->addEventsWidget($index);

    return $this->renderPartial('events-widget',array('widget' => $form['events'][$index], 'form' => $form, 'index' => $index, 'attributes' => array()));
  }


  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      try {
        $letter = $form->save();
      }
      catch (Doctrine_Validator_Exception $e) {
        $errorStack = $form->getObject()->getErrorStack();

        $message = get_class($form->getObject()).' has '.count($errorStack)." field".(count($errorStack) > 1 ? 's' : null)." with validation errors: ";
        foreach ($errorStack as $field => $errors) {
          $message .= "$field (".implode(", ", $errors)."), ";
        }
        $message = trim($message, ', ');

        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $letter)));

      if ($request->hasParameter('_save_and_add')) {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        $this->redirect('@letter_new');
      }
      elseif ($request->hasParameter('_save_and_preview')) {
        $this->redirect(array('sf_route' => 'letter_show', 'sf_subject' => $letter));
      }
      elseif ($request->hasParameter('_save_and_source')) {
        $this->redirect('letter/source?id='.$letter->id);
      }
      else {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect(array('sf_route' => 'letter_edit', 'sf_subject' => $letter));
      }
    }
    else {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }
}
