<?php

/**
 * Logo form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LogoForm extends BaseForm
{
  protected
    $isNew  = true,
    $object = null;


  public function __construct($object = null, $options = array(), $CSRFSecret = null)
  {
    if (!$object) {
      $this->object = new Logo();
    }
    else {
      if (!$object instanceof Logo) {
        throw new sfException(sprintf('The "%s" form only accepts a "Logo" object.', get_class($this)));
      }

      $this->object = $object;
      $this->isNew  = $this->getObject()->isNew();
    }

    parent::__construct(array(), $options, $CSRFSecret);

    $this->updateDefaultsFromObject();
  }

  public function configure()
  {
    $this->setWidget('key', new sfWidgetFormInputHidden());
    $this->setWidget('culture', new sfWidgetFormInputHidden());
    $this->setWidget('link', new sfWidgetFormInputText());
    $this->setWidget('status', new sfWidgetFormInputText());
    $this->setWidget('image', new sfWidgetFormInputFileEditable(array(
      'file_src'    => !$this->isNew() && $this->getObject()->isImageStored() ? $this->getObject()->getImage() : false,
      'is_image'    => true,
      'edit_mode'   => !$this->isNew() && $this->getObject()->isImageStored(),
      'with_delete' => false,
    )));


    $this->setValidator('key', new sfValidatorPass());
    $this->setValidator('culture', new sfValidatorChoice(array(
      'choices'   => sfConfig::get('sf_languages'),
      'required'  => true,
    )));
    $this->setValidator('link', new sfValidatorString(array(
      'required'  => false,
    )));
    $this->setValidator('status', new sfValidatorString(array(
      'required'  => false,
      'max_length' => 25,
    )));
    $this->setValidator('image', new sfValidatorFile(array(
      'mime_types'=> 'web_images',
      'max_size'  => 2097152,
      'required'  => $this->isNew(),
    )));

    $this->getWidgetSchema()->setLabels(array(
      'link'  => 'Ссылка',
      'image' => 'Изображение',
    ));

    $this->getWidgetSchema()->setNameFormat('logo[%s]');

    $this->disableLocalCSRFProtection();
  }

  public function isNew()
  {
    return $this->isNew;
  }

  public function getObject()
  {
    return $this->object;
  }

  public function save()
  {
    $values = $this->getValues();
    $image  = $values['image'];
    $this->getObject()->fromArray($values);
    $this->getObject()->setImage($image);
    $this->getObject()->save();

    return $values;
  }

  protected function updateDefaultsFromObject()
  {
    $defaults = $this->getDefaults();

    if ($this->isNew()) {
      $defaults = $defaults + $this->getObject()->toArray();
    }
    else {
      $defaults = $this->getObject()->toArray() + $defaults;
    }

    $this->setDefaults($defaults);
  }
}
