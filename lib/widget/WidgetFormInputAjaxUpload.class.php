<?php

class WidgetFormInputAjaxUpload extends sfWidgetForm
{
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
    $this->addOption('edit_route');
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $uploaded = '';
    if ($value) {
      foreach ($value as $id => $file) {
        $edit_url = $this->getOption('edit_route') ? $this->getOption('edit_route') . '?id=' . $id : null;
        $uploaded .= sprintf('
          <div data-id="%s">
            <img src="%s" alt="" />
            %s
            <a href="#" class="deleteupload">удалить</a>
          </div>
          ', $id, $file, $edit_url ? link_to('редактировать', $edit_url, 'class=editupload') : ''
        );
      }
    }

    return sprintf(
      '<div class="ajaxupload" data-upload-url="%s" data-name="%s">
        <input type="file" multiple="multiple" />
        <div class="uploaded">%s</div>
      </div>',
      url_for('file/upload'), $name, $uploaded
    );
  }
}