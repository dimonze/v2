<?php

class WidgetFormListSortable extends sfWidgetFormChoice
{
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->setOption('multiple', true);
  }


  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if ('[]' != substr($name, -2)) {
      $name .= '[]';
    }

    $li = '';
    foreach ($this->getChoices() as $value => $title) {
      $content = $title;
      $content .= $this->renderTag('input', array('type' => 'hidden', 'name' => $name, 'value' => $value));
      $li .= $this->renderContentTag('li', $content);
    }
    $html = $this->renderContentTag('ul', $li, array_merge($attributes, array('id' => $this->generateId($name))));

    $html .= sprintf(<<<EOF
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('#%s').sortable({ cursor: 'move' });
  });
</script>
EOF
      ,
      $this->generateId($name)
    );

    $html .= sprintf(<<<EOF
<style type="text/css">
  ul#%s {
    margin: 0;
    #width: 470px;
  }
  ul#%s li {
    background-color: #eff2f7;
    border: 1px solid #ccd5e4;
    border-radius: 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    cursor: move;
    display: inline;
    list-style-type: none;
    margin: 5px;
    padding: 7px 5px;
  }
</style>
EOF
      ,
      $this->generateId($name),
      $this->generateId($name)
    );

    return $html;
  }
}