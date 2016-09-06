jQuery(document).ready(function(){
  $('#sf_fieldset_______________').on('click', '.sf_admin_form_field_category > div > a.remove', function() {
    $(this).closest('.sf_admin_form_field_category').remove();
    return false;
  });

  $('#sf_fieldset_______________').on('click', '.sf_admin_form_field_add_category > a.add', function() {
    var $a = $(this);
    var index = 0;
    if ($a.parent('div').siblings('div').length) {
      index = $a.parent('div').siblings('div').last().find('input').first().attr('name').match(/\[(\d+)\]/)[1];
    }

    $.get($a.attr('href'), { 'index': ++index }, function(data) {
      $a.parent('div').before(data);
    }, 'html');
    return false;
  });

  $('#sf_fieldset_______________').on('click', 'table.letter-events-list a', function(){
    var $a = $(this);
    var $tr = $a.closest('tr');
    var textarea_id = $tr.children('td').eq(1).children('textarea').attr('id');
    tinyMCE.execCommand('mceRemoveEditor', false, textarea_id);

    switch ($a.attr('class')) {
      case 'promote':
        if ($tr.prev().length) $tr.insertBefore($tr.prev());
        tinyMCE.execCommand('mceAddEditor', true, textarea_id);
        break;
      case 'demote':
        if ($tr.next().length) $tr.insertAfter($tr.next());
        tinyMCE.execCommand('mceAddEditor', true, textarea_id);
        break;
      case 'remove':
        $tr.remove();
        break;
    }
    return false;
  });

});