<?php

/**
 * file actions.
 *
 * @package    garage
 * @subpackage file
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 */
class fileActions extends sfActions
{
  public function executeUpload(sfWebRequest $request)
  {
    if ($request->isMethod('put') && $request->getContent()) {
      try {
        $tmp = tempnam(sys_get_temp_dir(), 'up');
        file_put_contents($tmp, $request->getContent());

        $file = array(
          'tmp_name' => $tmp,
          'name'     => $request->getHttpHeader('X_FILENAME'),
        );

        $validator = new sfValidatorFile(array(
          'path' => sfConfig::get('sf_web_dir') . '/tmp',
        ));
        $this->fname = $validator->clean($file)->save();

        return sfView::SUCCESS;
      }
      catch (Exception $e) {}
    }

    $this->getResponse()->setStatusCode(400);
    return sfView::ERROR;
  }
}
