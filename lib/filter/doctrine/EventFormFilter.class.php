<?php

/**
 * Event filter form.
 *
 * @package    garage
 * @subpackage filter
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EventFormFilter extends BaseEventFormFilter
{
  public function configure()
  {
    $this->setWidget('title', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setValidator('title', new sfValidatorPass(array('required' => false)));

    $this->getWidget('date_start')->setOption('from_date', new sfWidgetFormI18nDate(array('culture' => 'ru')));
    $this->getWidget('date_start')->setOption('to_date', new sfWidgetFormI18nDate(array('culture' => 'ru')));
    $this->getWidget('date_start')->setOption('template', 'с %from_date% по %to_date%');

    $this->getWidget('date_end')->setOption('from_date', new sfWidgetFormI18nDate(array('culture' => 'ru')));
    $this->getWidget('date_end')->setOption('to_date', new sfWidgetFormI18nDate(array('culture' => 'ru')));
    $this->getWidget('date_end')->setOption('template', 'с %from_date% по %to_date%');

    $this->setWidget('published_at', new sfWidgetFormChoice(array(
      'choices'   => array('' => '', true => 'да', false => 'нет'),
    )));
    $this->setValidator('published_at', new sfValidatorChoice(array(
      'choices'   => array_keys($this->getWidget('published_at')->getOption('choices')),
      'required'  => false,
    )));
  }


  protected function addTitleColumnQuery($q, $element, $value)
  {
    if (!empty($value['text'])) {
      $q->andWhere('t.title LIKE ?', '%'.str_replace(' ', '%', $value['text']).'%');
    }
  }

  protected function addPublishedAtColumnQuery($q, $element, $value)
  {
    if ($value) {
      $q->andWhere($q->getRootAlias().'.published_at IS NOT NULL');
    }
    else {
      $q->andWhere($q->getRootAlias().'.published_at IS NULL');
    }
  }
}
