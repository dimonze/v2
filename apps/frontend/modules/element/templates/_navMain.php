<nav class="mainNav row">
  <ul class="nav">
    <li>
      <a class="navIco nav-map" href="<?= url_for('@page_show?slug=visit') ?>"></a>
      <address>+7 (495)<strong> 645-05-20</strong></address>
    </li>  
    <!--li>
      < ?php include_partial('element/auth') ?>
    </li-->
    <li>
      <a class="socIco nav-fb" href="http://www.facebook.com/garageccc?ref=nf" target="_blank"></a>
    </li>
    <li>
      <a class="socIco nav-tw" href="http://twitter.com/garage_art/" target="_blank"></a>
    </li>
    <li>
      <a class="socIco nav-ig" href="http://instagram.com/garageccc" target="_blank"></a>
    </li>
    <li>
      <a class="socIco nav-vk" href="http://vk.com/garageccc" target="_blank"></a>
    </li>    
    <li>
      <a class="socIco nav-youtube" href="http://www.youtube.com/garageccc" target="_blank"></a>
    </li>
    <li>
      <a class="socIco nav-ls" href="http://new.livestream.com/garageccclive" target="_blank"></a>
    </li>    
    <li>
      <ul class="menu fl lang">
        <li>
          <?= link_to_if(
            'ru' != $sf_user->getCulture(), 'Рус',
            preg_replace('/(^\/index.php\/en|^\/en)/', '/ru', $_SERVER['REQUEST_URI']),
            array( 'data-lang' => 'ru' )
          ) ?>
        </li>
        <li>/</li>
        <li>
          <?= link_to_if(
            'en' != $sf_user->getCulture(), 'Eng',
            preg_replace('/(^\/index.php\/$|^\/index.php\/ru|^\/ru|^\/$)/', '/en', $_SERVER['REQUEST_URI']),
            array( 'data-lang' => 'en' )
          ) ?>
        </li>
      </ul>
    </li>
  </ul>
  <ul class="search">
    <li>
      <div>
        <form class="search-query" action="<?= url_for('@search') ?>">
          <input type="text" name="query" placeholder="<?= __('Search') ?>"/>
          <input type="submit" value=""/>
        </form>
      </div>
    </li>
  </ul>
</nav>