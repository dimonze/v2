<?php

/**
 * GalleryImage form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GalleryImageForm extends BaseGalleryImageForm
{
  public function configure()
  {
    $this->embedI18n(sfConfig::get('sf_languages'));

    $this->setWidget('file', new sfWidgetFormInputFileEditable(array(
      'file_src'      => !$this->isNew(),
      'edit_mode'     => !$this->isNew(),
      'is_image'      => true,
      'with_delete'   => false,
      'template'      => '%file%<br />%input%',
    )));

    $this->setValidator('file', new sfValidatorFile(array(
      'required'      => false,
      'mime_types'    => 'web_images',
    )));

    unset($this['gallery_id']);
  }
}
