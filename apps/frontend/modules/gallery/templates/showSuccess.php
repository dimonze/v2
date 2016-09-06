<?php use_helper('Text') ?>

<h1><?= $gallery->title ?></h1>
<time class="fs18"><?= format_date($gallery->date) ?></time>
<div class="gal__descr"> 	
  <span class="gal__photographer"><?= is_null($gallery->author) ? '' : $gallery->author != '' ? __('Author') .': '. $gallery->author : ''?></span>
  <?php if ($gallery->Event->exists()): ?>
    <a class="blueBtn" href="<?= url_for('event_show', $gallery->Event) ?>">
      <?= __('Full text') ?> <span class="big">+</span>
    </a>
  <?php elseif ($gallery->News->exists()): ?>
    <a class="blueBtn" href="<?= url_for('news_show', $gallery->News) ?>">
      <?= __('Full text') ?> <span class="big">+</span>
    </a>
  <?php endif ?>
</div>

<ul class="gal__items clearfix">
  <?php foreach ($gallery->Images as $index => $image): ?>
    <?php
      $c = '';
      if (($index+1) % 5 == 0) $c = " gal__item_fifth";
      if (($index+1) % 3 == 0) $c = " gal__item_third";
      if (($index+1) % 15 == 0) $c = " gal__item_third gal__item_fifth";      
    ?>
    <li class="gal__item<?= $c ?>">
      <?= link_to(image_tag_mtime($image->thumb, false), $image->medium, array('class' => 'gal__href', 'rel' => 'gallery-1')) ?>
      <div class="image-description" style="display: none">
        <?php if ($image->title): ?>
          <h4><?= $image->title ?></h4>
        <?php endif ?>
        <?php if ($image->description): ?>
          <?= simple_format_text($image->description) ?>
        <?php endif ?>  
      </div>
    </li>
  <?php endforeach ?>
</ul>

<script>
$(document).ready(function() {
  var thisIndex = 0;
  var hashChangeCount = 0;
  $(".gal__href").fancybox({
    nextEffect: 'fade',
    prevEffect: 'fade',
    padding : 30,
    wrapCSS : 'gal_popup',
    beforeShow : function () {
      thisIndex = this.index;
      window.location.hash = parseInt(this.index) + 1;
      hashChangeCount++;
      var gal__counts = '<div class="gal__counts">Фото ' + (this.index + 1) + ' из ' + this.group.length + '</div>';
      var gal__photoDescr = '<div class="gal__photodescr">' + $(this.element).next().html() + '</div>'
      var gal__soc = '<div class="gal__soclikes"><div class="gal__soclike"><a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-url="' + window.location + '">Tweet</a></div>'
                   + '<div class="gal__soclike gal__soclike_gplus"><div id="gpluslike"></div></div>'
                   + '<div class="gal__soclike gal__soclike_fb"><iframe src="//www.facebook.com/plugins/like.php?href=' + escape(window.location.toString()) + ';width=The+pixel+width+of+the+plugin&amp;height=23&amp;colorscheme=light&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;send=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:The pixel width of the pluginpx; height:23px;" allowTransparency="true"></iframe></div></div>'
      this.title = gal__counts + gal__photoDescr + gal__soc;
    },
    afterShow : function() {
      $('.fancybox-image').click(function(){
        $.fancybox.next();
      })
      twttr.widgets.load();
      gapi.plusone.render('gpluslike',  {"size" : "medium", "href" : escape(window.location.toString())});
    },
    afterClose : function() {
      if ((!!(window.history && history.pushState)) && (navigator.userAgent.indexOf('Opera') == -1)){ // stupid Opera 12 thinks she can
        window.history.go(-hashChangeCount);
        hashChangeCount = 0;
      } else {
      var scrollTop = $(window).scrollTop();
      window.location.replace("#");
      if (typeof window.history.replaceState == 'function') {
        history.replaceState({}, '', window.location.href.slice(0, -1));
      }
        window.scrollTo(0, scrollTop);
      }
    },
    helpers : {
      title : {
        type: 'inside'
      }   
    }  
  });
  
  var urlHash = getHash();
  if (urlHash) {
    $('.gal__href').eq(urlHash - 1).click();
  }
  
  window.onhashchange = function(){
    var h = getHash() - 1;
    if(isNaN(h)){
      thisIndex = 'iamdone';
      $.fancybox.close(true);
    } else if (thisIndex != h){
      if ($('.gal_popup').filter(":visible").length == 0){
        $('.gal__href').eq(h).click();
      } else {
        $.fancybox.jumpto(h);
      }
    }
  };
  
  function getHash(){
    return parseInt(window.location.hash.substring(1));
  }  
});
</script>


<?php include_partial('global/share') ?>
