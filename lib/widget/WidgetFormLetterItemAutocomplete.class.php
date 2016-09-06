<?php

class WidgetFormLetterItemAutocomplete extends sfWidgetFormJQueryAutocompleter
{
  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('url_add');

    parent::configure($options, $attributes);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $widget_index = intval(str_replace('[%s]', '', $this->getParent()->getNameFormat()));

    $content = '';
    $content .= sfWidgetFormInput::render('autocomplete_'.$name, null, $attributes, $errors);

    $content .= sprintf(<<<EOF
<script type="text/javascript">//<![CDATA[
  jQuery(document).ready(function(){
    initAutocomplete%02d();
  });

  function initAutocomplete%02d() {
    jQuery('#%s')
    .autocomplete('%s', jQuery.extend({ }, {
      dataType: 'json',
      parse:    function(data){
        var parsed = [];
        for (key in data) {
          parsed[parsed.length] = { data: [ data[key], key ], value: data[key], result: data[key] };
        }
        if (!parsed.length) { jQuery('#%s').val(''); }
        return parsed;
      },
      extraParams: { lang: function(){ return jQuery('#%s').val(); } },
      cacheLength: 0,
      max: 20,
      minChars: 3,
    }, %s))
    .result(function (event, data) {
      jQuery.get('%s', { id: data[1], lang: jQuery('#%s').val(), letter_id: jQuery('#%s').val(), index: %d }, function(data){
        if (data) {
          jQuery('#%s').children('tbody').append(data);
        }
      }, 'html');
      jQuery('#%s').val('');
    })
    .keyup(function(){ if (this.value.length == 0) { jQuery('#%s').val(''); } });
  }
//]]></script>
EOF
      ,
      $widget_index,
      $widget_index,
      $this->generateId('autocomplete_'.$name),
      $this->getOption('url'),
      $this->generateId($name),
      $this->generateId(sprintf($this->getParent()->getParent()->getParent()->getNameFormat(), 'lang')),
      $this->getOption('config') ? $this->getOption('config') : sprintf('function(event, data){ jQuery("#%s").val(data[1]); }', $this->generateId($name)),
      $this->getOption('url_add'),
      $this->generateId(sprintf($this->getParent()->getParent()->getParent()->getNameFormat(), 'lang')),
      $this->generateId(sprintf($this->getParent()->getParent()->getParent()->getNameFormat(), 'id')),
      $widget_index,
      $this->generateId(sprintf($this->getParent()->getParent()->getParent()->getNameFormat().'_%d', 'events', $widget_index)),
      $this->generateId('autocomplete_'.$name),
      $this->generateId($name)
    );

    $content .= sprintf(<<<EOF
<script type="text/javascript">//<![CDATA[
  /*jQuery(document).ready(function(){
    jQuery('#events-%d').sortable({
      axis: 'y',
      cursor: 'move',
      items: 'tr.tr-sortable',
      scroll: true,
      revert: 100,
      start: function(e, u) {
        tinyMCE.execCommand('mceRemoveEditor', false, u.item.children('td').eq(1).children('textarea').attr('id'));
      },
      stop: function(e, u) {
        tinyMCE.execCommand('mceAddEditor', true, u.item.children('td').eq(1).children('textarea').attr('id'));
      }
    });
  });*/
//]]></script>
EOF
      ,
      $widget_index
    );

    return $content;
  }

  public function getJavascripts()
  {
    return array_merge(parent::getJavascripts(), array('backend.letters.js'));
  }
}