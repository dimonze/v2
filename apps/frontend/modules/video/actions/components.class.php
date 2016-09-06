<?php

/**
 * book components.
 *
 * @package    garage
 * @subpackage video
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 */
class videoComponents extends sfActions
{
  public function executeVideo(sfWebRequest $request)
  {   
    $this->video = Doctrine::getTable('Video')->createQueryI18N()
      ->limit(1)
      ->execute();
  }
}
