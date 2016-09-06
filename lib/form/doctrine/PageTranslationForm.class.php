<?php

/**
 * PageTranslation form.
 *
 * @package    garage
 * @subpackage form
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PageTranslationForm extends BasePageTranslationForm
{
  public function configure()
  {
    $this->setWidget('body', new sfWidgetFormTextareaTinyMCE($this->_tinymce_options));
    $this->setWidget('seo_description', new sfWidgetFormTextarea());


    $this->getWidget('title')->setAttribute('style', 'width: 500px;');
    $this->getWidget('h1')->setAttribute('style', 'width: 500px;');
    $this->getWidget('seo_title')->setAttribute('style', 'width: 468px;');
    $this->getWidget('seo_description')->setAttribute('cols', '70');


    $this->getValidator('title')->setOption('trim', true);
    $this->getValidator('h1')->setOption('trim', true);
    $this->getValidator('seo_title')->setOption('trim', true);
    $this->getValidator('seo_description')->setOption('trim', true);

    $this->getValidator('body')->setOption('empty_value', null);
    $this->getValidator('h1')->setOption('empty_value', null);
    $this->getValidator('seo_title')->setOption('empty_value', null);
    $this->getValidator('seo_description')->setOption('empty_value', null);


    $this->getWidgetSchema()->setLabels(array(
      'title'           => 'Наименование',
      'h1'              => 'Заголовок',
      'body'            => 'Текст',
      'seo_title'       => 'SEO Title',
      'seo_description' => 'SEO Description',
    ));
  }
}
