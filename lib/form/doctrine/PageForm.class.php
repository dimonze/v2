<?php

/**
 * Page form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PageForm extends BasePageForm
{
  private $_parent;


  public function configure()
  {
    unset($this['lft'], $this['rgt'], $this['level']);
    
    $this->setWidget('id', new sfWidgetFormTextarea());
    
    $this->embedI18n(sfConfig::get('sf_languages'));

    $this->setWidget('parent_id', new sfWidgetFormDoctrineChoice(array(
      'model'         => 'Page',
      'table_method'  => 'findTree',
      'method'        => 'getIndentedTitle',
      'add_empty'     => true,
    )));
    $this->widgetSchema['images'] = new WidgetFormInputAjaxUpload();


    $this->setValidator('parent_id', new sfValidatorCallback(array(
      'callback'  => array($this, 'validateParent'),
      'required'  => true,
    )));
    $this->setValidator('slug', new sfValidatorRegex(array(
      'pattern'   => '/^[a-z0-9\-]+$/',
      'required'  => false,
    ), array(
      'invalid'   => 'Может содержать только буквы латинского алфавита, цифры и знак -',
    )));
    $this->validatorSchema['images_delete'] = new sfValidatorPass();
    $this->validatorSchema['images_upload'] = new sfValidatorPass();

    $this->getValidatorSchema()->setPostValidator(new sfValidatorDoctrineUnique(array(
      'model'     => $this->getModelName(),
      'column'    => 'slug',
    )));

    if (!$this->isNew()) {
      if ($this->getObject()->level == 1) {
        $this->setWidget('parent_id', new sfWidgetFormInputHidden());
        $this->getWidget('parent_id')->setDefault(1);
      }
      else {
        $this->getWidget('parent_id')->setDefault($this->getObject()->getNode()->getParent()->id);
      }
    }
  }

  public function validateParent(sfValidatorCallback $validator, $value)
  {
    if (empty($value)) {
      throw new sfValidatorError($validator, 'required');
    }

    $parent = Doctrine::getTable('Page')->find($value);
    if (!$parent || !$parent->getNode()->isValidNode()) {
      throw new sfValidatorError($validator, 'invalid');
    }

    $this->_parent = $parent;

    return $value;
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    if (!empty($taintedValues['slug'])) {
      $taintedValues['slug'] = mb_strtolower($taintedValues['slug']);
    }
    else {
      $taintedValues['slug'] = mb_strtolower($taintedValues['en']['title']);
      $taintedValues['slug'] = preg_replace('/\W+/', '-', $taintedValues['slug']);
      $taintedValues['slug'] = trim($taintedValues['slug'], '-');
    }

    parent::bind($taintedValues, $taintedFiles);
  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    if ($this->_parent) {
      if ($this->isNew()) {
        $this->getObject()->getNode()->insertAsLastChildOf($this->_parent);
      }
      else {
        $node = $this->getObject()->getNode();
        if ($node->getParent()->id != $this->_parent->id) {
          $node->moveAsLastChildOf($this->_parent);
        }
      }
    }
    else {
      Doctrine::getTable('Page')->getTree()->createRoot($this->getObject());
    }
  }
}
