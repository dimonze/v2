<!DOCTYPE html>
<!--[if IE 7]><html class="ie7 ie8" lang="<?php echo $sf_user->getCulture() ?>"> <![endif]-->
<!--[if IE 8]><html class="ie8" lang="<?php echo $sf_user->getCulture() ?>"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="<?php echo $sf_user->getCulture() ?>"><!--<![endif]-->
<head>
  <?php include_http_metas() ?>
  <?php include_metas() ?>
  <?php if (has_slot('widgetmeta')): ?><?php include_slot('widgetmeta') ?><?php endif ?>
  <?php include_title() ?>
  <link type="image/x-icon" href="/favicon.ico" rel="icon">
  <?php include_stylesheets() ?>
  <?php include_javascripts() ?>
  <script type="text/javascript">
    window.LANG = '<?= $sf_user->getCulture() ?>';
    $.reject && $(function() {
      $.reject({
        reject: { msi6: true, msie7: true },
        imagePath: '/reject/browsers/',
        header: '<?= __('Did you know that your Internet Browser is out of date?') ?>',
        paragraph1: '<?= __('Your browser is out of date, and may not be compatible with our website. A list of the most popular web browsers can be found below.') ?>',
        paragraph2: '',
        close: true,
        closeMessage: '<?= __('By closing this window you acknowledge that your experience on this website may be degraded') ?>',
        closeLink: '<?= __('Close This Window') ?>'
      });
    });
  </script>
  <!-- Google Counter /-->
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-184157-19']);
    _gaq.push(['_setDomainName', 'garageccc.com']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>
  <!-- End Google Counter /-->
</head>
<body>
  <?php include_component('element', 'msg') ?>
  <div class="wrapper">
    <header>
      <div class="row-fluid">

        <div class="span4 logo">
          <a href="<?php echo url_for2('homepage', array( 'sf_culture' => $sf_user->getCulture() )).( $sf_user->getCulture() == 'ru' ? 'ru' : '' ) ?>">
            <img src="/images/logo.png" alt="<?php echo __('Garage Museum of Contemporary Art') ?>">
          </a>
        </div>

        <div class="span8 nav-block">
          <?php include_partial('element/navMain') ?>          
      </div>

      <div class="headBottomNav linksBlack clearfix">
        <?php include_component('element', 'nav') ?>
      </div>
    </header>

    <div class="content">
      <?= $sf_content ?>
      
      <?php include_component('element', 'banners', array('sf_cache_key' => $sf_user->getCulture())) ?>
    <div class="row-fluid partners">
      <div class="span9">
      <?php include_component('element', 'logos', array('sf_cache_key' => $sf_user->getCulture())) ?> 
      </div>
      <div class="span3 inf-partn__box">
        <div class="inf-partn">
          <p class="inf-partn__text"> <?= __('Informational partner') ?></p><a href="http://interviewrussia.ru/"><img class="inf-partn__img" src="/images/interview-sm.png"></a>
        </div>
      </div>      
    </div>
   </div>

    <footer class="row-fluid">
      <div class="span9">
        <p><strong>© <?= __('Garage Museum of Contemporary Art') ?></strong> <?= date('Y') ?>.</p>

        <?php include_component('element', 'navFooter', array('sf_cache_key' => $sf_user->getCulture())) ?>
      </div>

      <div class="span3 developed formFooter">
        <?php include_component('feedback', 'subscribe') ?>
      </div>
    </footer>

    <div id="overlay"></div>
    <?php include_component('feedback', 'form') ?>
  </div>
</body>
</html>
