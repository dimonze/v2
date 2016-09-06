<?php

/**
 * User form.
 *
 * @package    philips-promo
 * @subpackage form
 * @author     Garin Studio
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BannerForm extends BaseForm
{
  protected
    $isNew  = true,
    $object = null;


  public function __construct($object = null, $options = array(), $CSRFSecret = null)
  {
    if (!$object) {
      $this->object = new Banner();
    }
    else {
      if (!$object instanceof Banner) {
        throw new sfException(sprintf('The "%s" form only accepts a "Banner" object.', get_class($this)));
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
    $this->setWidget('title', new sfWidgetFormInputText());
    $this->setWidget('text', new sfWidgetFormInputText());
    $this->setWidget('link', new sfWidgetFormInputText());
    $this->setWidget('code', new sfWidgetFormTextarea());
    $this->setWidget('file', new sfWidgetFormInputFileEditable(array(
      'file_src'    => !$this->isNew() && $this->getObject()->isFileStored() ? $this->getObject()->getFile() : false,
      'is_image'    => false,
      'edit_mode'   => !$this->isNew() && $this->getObject()->isFileStored(),
      'with_delete' => true,
      'template'    => '%input%<br />%delete% удалить<br/>'.$this->getObject()->code,
    )));


    $this->setValidator('key', new sfValidatorPass());
    $this->setValidator('culture', new sfValidatorChoice(array(
      'choices'   => sfConfig::get('sf_languages'),
      'required'  => true,
    )));
    $this->setValidator('title', new sfValidatorString(array(
      'required'  => true,
    )));
    $this->setValidator('text', new sfValidatorString(array(
      'required'  => false,
    )));
    $this->setValidator('link', new sfValidatorString(array(
      'required'  => false,
    )));
    $this->setValidator('code', new sfValidatorString(array(
      'required'  => false,
    )));
    $this->setValidator('file', new sfValidatorFile(array(
      'mime_types'=> array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif','application/x-shockwave-flash'),
      'max_size'  => 2097152,
      'required'  => false,
    )));
    $this->setValidator('file_delete', new sfValidatorBoolean(array(
      'required'  => false,
    )));


    $this->getWidget('code')->setAttribute('cols', 70);
    $this->getWidget('title')->setAttribute('style', 'width: 350px;');
    $this->getWidget('text')->setAttribute('style', 'width: 350px;');


    $this->getWidgetSchema()->setLabels(array(
      'title' => 'Наименование',
      'text'  => 'Подпись',
      'link'  => 'Ссылка',
      'code'  => 'Сгенерированный код',
      'file'  => 'Файл',
    ));

    $this->getWidgetSchema()->setHelps(array(
      'code'  => 'генерируется при создании',
      'file'  => 'изображение или флэш',
    ));

    $this->getWidgetSchema()->setNameFormat('banner[%s]');

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
    $file = $values['file'];
    $this->getObject()->fromArray($values);
    $this->getObject()->setFile($file);
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
