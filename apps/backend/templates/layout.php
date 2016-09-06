<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <?php include_http_metas() ?>
  <?php include_metas() ?>
  <?php include_title() ?>
  <?php include_stylesheets() ?>
  <?php include_javascripts() ?>
</head>
<body>
  <blockquote>
    <?= link_to('События', '@event') ?> -
    <?= link_to('Заметки на главной', '@note') ?> -
    <?= link_to('Видео на главной', '@video') ?> -
    <?= link_to('Книги', '@book') ?> -
    <?= link_to('Новости', '@news') ?> -
    <?= link_to('Галереи', '@gallery') ?> -
    <?= link_to('Страницы', '@page') ?> -
    <?= link_to('Пользователи', '@user') ?> -
    <?= link_to('Баннеры', 'banner/index') ?> -
    <?= link_to('Логотипы', 'logos/index') ?> -
    <?= link_to('Системное сообщение', '@default?module=default&action=msg') ?> -
    <?= link_to('Обратная связь', '@feedback') ?> -
    <?= link_to('Бронирование', '@reservation') ?> -
    <?= link_to('Письма', '@letter') ?>
  </blockquote>

  <?= $sf_content ?>
</body>
</html>
