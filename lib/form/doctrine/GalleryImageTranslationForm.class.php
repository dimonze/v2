<?php

/**
 * GalleryImageTranslation form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GalleryImageTranslationForm extends BaseGalleryImageTranslationForm
{
  public function configure()
  {
    $this->widgetSchema->setLabels(array(
      'title'             => 'Заголовок',
      'description'       => 'Описание',
    ));
  }
}
