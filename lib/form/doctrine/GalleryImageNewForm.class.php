<?php

class GalleryImageNewForm extends GalleryImageForm
{
  public function configure()
  {
    parent::configure();

    $this->setWidget('file', new WidgetFormInputFileMultiple());

    $this->setValidator('file', new sfValidatorCallback(array(
      'callback' => array($this, 'validatorFile'),
      'required' => false,
    )));

    $this->getWidgetSchema()->setLabel('file', 'Файлы');
    $this->getWidgetSchema()->setHelp('file', 'можно выбрать несколько файлов');

    unset($this['ru'], $this['en']);
  }

  public function validatorFile(sfValidatorCallback $validator, $value)
  {
    if (!$value) return;

    $validator_file = new sfValidatorFile(array(
      'required'      => false,
      'mime_types'    => 'web_images',
      'max_size'      => 16 * 1024 * 1024,
    ));


    $files = array();
    foreach ($value as $file) {
      try {
        $files[] = $validator_file->clean($file);
      }
      catch (sfValidatorError $e) {
        throw new sfValidatorError($validator, $e->getMessage());
      }
    }

    return array_filter($files);
  }


  protected function doUpdateObject($values)
  {
    foreach ($values as $value) {
      $this->getObject()->fromArray($value);
    }
  }
}