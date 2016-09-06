<?php

/**
 * Gallery form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GalleryForm extends BaseGalleryForm
{
  public function configure()
  {
    $this->embedI18n(sfConfig::get('sf_languages'));

    $this->widgetSchema['date'] = new sfWidgetFormI18nDate(array('culture' => 'ru'));
    $this->widgetSchema['preview_image'] = new sfWidgetFormInputFileEditable(array(
      'file_src'    => $this->getObject()->preview_image . '?' . filemtime(sfConfig::get('sf_web_dir') . $this->getObject()->preview_image),
      'is_image'    => true,
      'with_delete' => false,
      'edit_mode'   => $this->getObject()->preview_image,
    ));

    $this->validatorSchema['preview_image'] = new sfValidatorFile(array(
      'required' => !$this->getObject()->preview_image,
    ));
    $this->validatorSchema['images_delete'] = new sfValidatorPass();

    $this->embedImagesForm();
  }

  public function updateObjectEmbeddedForms($values, $forms = null)
  {
    if (is_null($forms)) $forms = $this->getEmbeddedForms();
    unset($forms['Images'], $forms['ImagesNew']);

    parent::updateObjectEmbeddedForms($values, $forms);
  }

  public function saveEmbeddedForms($con = null, $forms = null)
  {
    if (is_null($forms)) $forms = $this->getEmbeddedForms();
    unset($forms['Images'], $forms['ImagesNew']);

    parent::saveEmbeddedForms($con, $forms);
  }


  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->updateImages();
    $this->saveImagesNew();
  }

  protected function updateImages()
  {
    $images = $this->getValue('Images');
    $forms  = $this->getEmbeddedForm('Images')->getEmbeddedForms();

    foreach ($images as $i => $image) {
      if ($this->getValue('images_delete') && in_array($image['id'], $this->getValue('images_delete'))) continue;

      if ($image['file']) {
        $forms[$i]->getObject()->file = $image['file'];
      }
      foreach (sfConfig::get('sf_languages') as $lang) {
        foreach (array('title', 'description') as $field) {
          if ($image[$lang][$field] != $forms[$i]->getObject()->Translation[$lang][$field]) {
            $forms[$i]->getObject()->Translation[$lang][$field] = trim($image[$lang][$field]);
            $forms[$i]->getObject()->save();
          }
        }
      }
    }
  }

  protected function saveImagesNew()
  {
    $images = $this->getValue('ImagesNew');
    if (!$images['file']) return;

    foreach ($images['file'] as $fileObject) {
      $image = new GalleryImage();
      $image->file = $fileObject;
      $image->gallery_id = $this->getObject()->id;

      $image->save();
      $image->free();
      unset($image);
    }
  }


  private function embedImagesForm()
  {
    $this->embedForm('Images', new sfForm());
    foreach ($this->getObject()->Images as $i => $o) {
      $gi_form = new GalleryImageForm($o);
      unset($gi_form[self::$CSRFFieldName]);
      $this->getEmbeddedForm('Images')->embeddedForms[$i] = $gi_form;
      $this->validatorSchema['Images'][$i] = $gi_form->getValidatorSchema();

      unset($gi_form);
    }

    $images_new_form = new GalleryImageNewForm();
    $images_new_form->setDefault('gallery_id', $this->getObject()->id);
    $this->embedForm('ImagesNew', $images_new_form);
  }
}
