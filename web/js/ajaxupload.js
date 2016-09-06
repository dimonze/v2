$(function() {
  var uploadFile = function(url, file, callback) {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
      if (4 != xhr.readyState) {
        return;
      }
      if (200 != xhr.status) {
        alert('Ошибка загрузки!');
        return;
      }
      callback(xhr.response);
    };

    xhr.open('PUT', url, true);
    xhr.setRequestHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
    xhr.setRequestHeader('X_FILENAME', file.name);
    xhr.send(file);
  }

  $('div.ajaxupload').each(function() {
    var upload_url = $(this).data('upload-url');
    var upload_name = $(this).data('name').replace(/\[(\w+)\]$/, '[$1_upload][]');
    var $target = $('div.uploaded', this);

    $('input[type=file]', this).bind('change', function(e) {
      $.each(e.target.files || e.dataTransfer.files || [], function(i, file) {
        0 === file.type.indexOf('image/') && uploadFile(upload_url, file, function(response) {
          $target.append(response.replace(/name="upload\[\]"/,  'name="' + upload_name + '"'));
        });
      });
      this.value = null;
    });
  });

  $('a.cancelupload').live('click', function() {
    $(this).parent().remove();
    return false;
  });

  $('a.deleteupload').live('click', function() {
    var $block = $(this).parent();
    var fname = $(this).closest('div.ajaxupload').data('name').replace(/\[(\w+)\]$/, '[$1_delete][]')
    $block.after('<input type="hidden" name="' + fname + '" value="' + $block.data('id') + '" />').remove();
    return false;
  });

  $('a.editupload').fancybox({
    maxWidth: 800,
    maxHeight: 600,
    fitToView: false,
    width: '70%',
    height: '70%',
    autoSize: false,
    closeClick: false,
    openEffect: 'none',
    closeEffect: 'none',
    type: 'iframe'
  });
})