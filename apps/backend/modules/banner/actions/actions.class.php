<?php

/**
 * banner actions.
 *
 * @package    garage
 * @subpackage banner
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bannerActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $banners = sfYaml::load(sfConfig::get('sf_config_dir').'/banners.yml');
    $this->banners = $banners['all']['.array'];
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('key'));
    $this->forward404Unless($request->hasParameter('culture'));

    include sfContext::getInstance()->getConfigCache()->checkConfig('config/banners.yml');

    $this->banner = new Banner($request->getParameter('culture'), $request->getParameter('key'));
    $this->form   = new BannerForm($this->banner);

    if ($request->isMethod(sfWebRequest::POST) && $request->hasParameter($this->form->getName())) {
      $this->processForm($request, $this->form);
    }
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('culture'));

    include sfContext::getInstance()->getConfigCache()->checkConfig('config/banners.yml');

    $this->banner = new Banner($request->getParameter('culture'));
    $this->form = new BannerForm($this->banner);

    if ($request->isMethod(sfWebRequest::POST) && $request->hasParameter($this->form->getName())) {
      $this->processForm($request, $this->form);
    }
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('key'));
    $this->forward404Unless($request->hasParameter('culture'));

    include sfContext::getInstance()->getConfigCache()->checkConfig('config/banners.yml');

    $banner = new Banner($request->getParameter('culture'), $request->getParameter('key'));
    $banner->delete();

    $this->redirect('@default?module=banner&action=index');
  }

  public function executePromote(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('key'));
    $this->forward404Unless($request->hasParameter('culture'));

    include sfContext::getInstance()->getConfigCache()->checkConfig('config/banners.yml');

    $banner = new Banner($request->getParameter('culture'), $request->getParameter('key'));
    $banner->promote();

    $this->redirect('@default?module=banner&action=index');
  }

  public function executeDemote(sfWebRequest $request)
  {
    $this->forward404Unless($request->hasParameter('key'));
    $this->forward404Unless($request->hasParameter('culture'));

    include sfContext::getInstance()->getConfigCache()->checkConfig('config/banners.yml');

    $banner = new Banner($request->getParameter('culture'), $request->getParameter('key'));
    $banner->demote();

    $this->redirect('@default?module=banner&action=index');
  }


  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      try {
        $object = $form->save();
      }
      catch (Doctrine_Validator_Exception $e) {
        $errorStack = $form->getObject()->getErrorStack();

        $message = get_class($form->getObject()).' has '.count($errorStack).' field'.(count($errorStack) > 1 ?  's' : null).' with validation errors: ';
        foreach ($errorStack as $field => $errors) {
          $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');

        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }

      if ($request->hasParameter('_save_and_add')) {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');
        $this->redirect('@default?module=banner&action=new');
      }
      else {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect('@default?module=banner&action=edit&key='.$object['key'].'&culture='.$object['culture']);
      }
    }
    else {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }
}
