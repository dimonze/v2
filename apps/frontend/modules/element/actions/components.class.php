<?php

/**
 * element components.
 *
 * @package    garage
 * @subpackage element
 * @author     Garin Studio <eugeniy.b@garin-studio.ru>
 */
class elementComponents extends sfComponents
{
  public function executeNav()
  {
    $i18n = $this->getContext()->getI18N();

    $this->left = array(
      array(
        'title'  => $i18n->__('Exhibitions'),
        'class'  => 'purpur',
        'route'  => 'event/category',
        'params' => array('atype' => Event::TYPE_EXHIBITION),
        'items'  => array(
          array(
            'title'  => $i18n->__('Exhibitions'),
            'route'  => 'event/category',
            'params' => array('type' => Event::TYPE_EXHIBITION, 'date' => 'now'),
          ),
          array(
            'title'  => $i18n->__('Garage Project Space'),
            'route'  => 'event/category',
            'params' => array('type' => Event::TYPE_EXHIBITION_SPACE, 'date' => 'now'),
          ),
          array(
            'title'  => $i18n->__('External Projects'),
            'route'  => 'event/category',
            'params' => array('type' => Event::TYPE_EXHIBITION_OUTER, 'date' => 'now'),
          ),
          array(
            'title'  => $i18n->__('Past'),
            'route'  => 'event/category',
            'params' => array('atype' => Event::TYPE_EXHIBITION, 'date' => 'archive'),
          ),
        )
      ),

      array(
        'title'  => $i18n->__('Kids'),
        'class'  => 'orange',
        'route'  => 'event/category',
        'params' => array('atype' => Event::TYPE_CHILDREN),
        'items'  => array(
          array(
            'title'  => $i18n->__('Events'),
            'route'  => 'event/category',
            'params' => array('type' => Event::TYPE_CHILDREN, 'date' => 'now'),
          ),
          array(
            'title'  => $i18n->__('Workshops'),
            'route'  => 'event/category',
            'params' => array('type' => Event::TYPE_CHILDREN_CLASS, 'date' => 'now'),
          ),
          array(
            'title'  => $i18n->__('Past'),
            'route'  => 'event/category',
            'params' => array('atype' => Event::TYPE_CHILDREN, 'date' => 'archive'),
          ),
        )
      ),

      array(
        'title'  => $i18n->__('Education'),
        'class'  => 'blue',
        'route'  => 'event/category',
        'params' => array('atype' => Event::TYPE_EDUCATION),
        'items'  => array(
          array(
            'title'  => $i18n->__('Lectures'),
            'route'  => 'event/category',
            'params' => array('type' => Event::TYPE_EDUCATION, 'date' => 'now'),
          ),
          array(
            'title'  => $i18n->__('Workshops'),
            'route'  => 'event/category',
            'params' => array('type' => Event::TYPE_EDUCATION_CLASS, 'date' => 'now'),
          ),
          array(
            'title'  => $i18n->__('Films'),
            'route'  => 'event/category',
            'params' => array('type' => Event::TYPE_EDUCATION_FILM, 'date' => 'now'),
          ),
          array(
            'title'  => $i18n->__('Music'),
            'route'  => 'event/category',
            'params' => array('type' => Event::TYPE_EDUCATION_MUSIC, 'date' => 'now'),
          ),
          array(
            'title'  => $i18n->__('Books'),
            'route'  => 'book/index',
          ),
          array(
            'title'  => $i18n->__('Past'),
            'route'  => 'event/category',
            'params' => array('atype' => Event::TYPE_EDUCATION, 'date' => 'archive'),
          ),
        )
      ),
    );


    $this->right = array();
    $pages = Doctrine::getTable('Page')->getTree()->fetchTree();
    $pages_translation = Doctrine::getTable('Page')->getTitlesI18N($pages->getPrimaryKeys(), $i18n->getCulture());
    $pages_iterator = new ArrayIterator($pages->getData());
    while ($pages_iterator->valid()) {
      $page = $pages_iterator->current();

      if ($page->id == Page::RESEARCH_PAGE) {
        $this->left[] = array(
          'title' => $pages_translation[$page->id],
          'class' => 'grass',
          'route' => $this->getContext()->getRouting()->generate('page_show', $page),
          'page'  => $page,
          'items' => array(
            array(
              'title'  => $i18n->__('Research Projects'),
              'route'  => 'event/category',
              'params' => array('type' => Event::TYPE_RESEARCH_PROJECTS, 'date' => 'now'),
            ),
          ),
        );

        $menu_index = count($this->left)-1;
        $pages_iterator->next();
        $page = $pages_iterator->current();
        while ($page && $page->isDescendantOf($this->left[$menu_index]['page'])) {
          $this->left[$menu_index]['items'][] = array(
            'title' => $pages_translation[$page->id],
            'class' => 'grass',
            'route' => $this->getContext()->getRouting()->generate('page_show', $page),
            'page'  => $page,
          );

          $pages_iterator->next();
          $page = $pages_iterator->current();
        }

        continue;
      }
      elseif ($page->id == Page::PERFORMANCE_PAGE) {
        $this->left[] = array(
          'title' => $pages_translation[$page->id],
          'class' => 'red',
          'route'  => 'event/category',
          'params' => array('type' => Event::TYPE_PERFORMANCE_PLATFORM, 'date' => 'now'),
          'page'  => $page,
          'items' => array(),
        );
        $perfPage = $page;
        $menu_index = count($this->left)-1;
        $pages_iterator->next();
        $page = $pages_iterator->current();
        while ($page && $page->isDescendantOf($this->left[$menu_index]['page'])) {
          $this->left[$menu_index]['items'][] = array(
            'title' => $pages_translation[$page->id],
            'route' => $this->getContext()->getRouting()->generate('page_show', $page),
            'page'  => $page,
          );

          $pages_iterator->next();
          $page = $pages_iterator->current();
        }

        $this->left[$menu_index]['items'][] = array(
          'title'  => $i18n->__('Platform'),
          'route' => $this->getContext()->getRouting()->generate('page_show', $perfPage),  
        );
        continue;
      }
      elseif ($page->level == 0 || $page->is_for_research || ($page->is_for_press && !$this->getUser()->is_press)) {
        $pages_iterator->next();
        $page = $pages_iterator->current();
        continue;
      }
      elseif ($page->level == 1) {
        $this->right[] = array(
          'title' => $pages_translation[$page->id],
          'route' => $this->getContext()->getRouting()->generate('page_show', $page),
          'page'  => $page,
        );
      }
      else {
        $this->right[count($this->right)-1]['items'][] = array(
          'title' => $pages_translation[$page->id],
          'route' => $this->getContext()->getRouting()->generate('page_show', $page),
          'page'  => $page,
        );
      }

      //insert Gallery link
      if ($page->id == 9) {
        $this->right[count($this->right)-1]['items'][] = array(
          'title' => $i18n->__('Galleries'),
          'route' => 'gallery/index',
        );
      }
      //insert News link
      if ($page->id == 2) {
        $this->right[count($this->right)-1]['items'][] = array(
          'title' => $i18n->__('News'),
          'route' => 'news/index',
        );
      }

      $pages_iterator->next();
    }


    foreach (array('left', 'right') as $menu) {
      foreach ($this->$menu as &$group) {
        $group['class'] = isset($group['class']) ? $group['class'] : '';

        if (!empty($group['items'])) {
          foreach ($group['items'] as &$item) {
            $item['class'] = isset($item['class']) ? $item['class'] : '';

            if ($this->isMenuActive($item)) {
              $group['class'] .= ' active';
              $item['class']  .= ' active';
            }

            if (isset($item['params'])) {
              $item['route'] .= '?' . http_build_query($item['params']);
            }
          }
        }


        if ($this->isMenuActive($group)) {
          $group['class'] .= ' active';
        }
        if (isset($group['params'])) {
          $group['route'] .= '?' . http_build_query($group['params']);
        }
      }
    }
  }

  public function executeNavFooter()
  {
    $this->pages = Doctrine::getTable('Page')->getFirstLevelPages();
    $this->footer_pages = Doctrine::getTable('Page')->getFooterPages();
  }

  public function executeAbout()
  {

  }

  public function executeContacts()
  {

  }

  public function executeHoursAndTickets()
  {

  }

  public function executeBanners()
  {
    $this->banners = array();
    foreach (sfConfig::get('banner_'.$this->getUser()->getCulture()) as $b) {
      $this->banners[] = $b;
    }

    if (count($this->banners) > 4) {
      shuffle($this->banners);
    }
  }

  public function executeLogos()
  {
    $this->logos = array();
    foreach (sfConfig::get('logo_'.$this->getUser()->getCulture()) as $l) {
      $this->logos[] = $l;
    }
  }

  public function executeMsg()
  {
    if (sfConfig::get('app_msg_enabled')) {
      $this->content = sfConfig::get('app_msg_content_'.$this->getUser()->getCulture());
    }
    else {
      return sfView::NONE;
    }
  }


  private function isMenuActive(array $item)
  {
    $request = $this->getRequest();

    $route = $request->getParameter('module') . '/' .
             $request->getAttribute('menu_route_action', $request->getParameter('action'));

    $route_index = $this->getRequestParameter('module') . '/index';

    $active = false;

    if ($route == $item['route'] || $route_index == $item['route']) {
      $active = true;

      if (isset($item['params'])) {
        foreach ($item['params'] as $pname => $pval) {
          if ($pval != $this->getRequestParameter($pname)) {
            $active = false;
            break;
          }
        }
      }
    }
    elseif (isset($item['page']) && 'page/show' == $route) {
      $active = $this->getRequestParameter('slug') == $item['page']->slug;
    }

    return $active;
  }
}
