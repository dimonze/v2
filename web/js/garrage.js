$(document).ready(function(){

  $('.nav-auth').click(function(e){
    e.preventDefault();
    $(this).next().slideToggle();
  });

  window.onload = gallery;

  $('.mainPageEvents').each(function(){
    var parent = $(this);
    if ( parent.find('> .span4 > .eventsList').length) {

      var target = parent.find('.row-fluid > .evntTxtWrp');

      function resizeBlocks(){
        var targetImgH = target.parent().find('img').outerHeight();
        var ethalonH = parent.find('.row-fluid > .span6:last').outerHeight();
        target.css('min-height', ethalonH*2 + 10 - targetImgH );
      }
      resizeBlocks();
      setTimeout(function(){
        resizeBlocks();
      }, 100);
      $(window).load(function(){
        resizeBlocks();
      });
      $(window).resize(resizeBlocks);

    }

//    ресайз для блоков на стр событий
    if ($('.eventsRow').length) {

      var rowMaxHeight;

      function eventsRowSize(){
        $('.eventsRow').each(function(){
          var eventsRow = $(this);
          var rowMaxHeight = 0;

          eventsRow.find('.evntTxtWrp').each(function(){
            $(this).css('min-height','0');
            if ( $(this).outerHeight() > rowMaxHeight) {
              rowMaxHeight = $(this).outerHeight();
            }
          });
          eventsRow.find('.evntTxtWrp').css('min-height',rowMaxHeight);
        });
      }
      eventsRowSize();
      setTimeout(function(){
        eventsRowSize();
      },200);

      $(window).load(function(){
        eventsRowSize();
      });

      $(window).resize(eventsRowSize);

    }


  });



//  hover state and tail position/animation in main menu
  $('.headBottomNav').each(function(){
    var parent = $(this);
    var timeoutHoverout;
    var timeoutHoverin;
    var active = parent.find('> nav > ul > .active');
    var item = parent.find('> nav > ul > li')

    if (active.length > 0) {
      parent.find('.no_active').remove();
      active.find('.triangle').css('left', Math.round(active.offset().left - $('.headBottomNav').offset().left + active.width() / 2));
    }

    item.find('> a').mouseover(
      function(event){
        item.find('> a').removeClass('mouseOver');
        $(this).addClass('mouseOver');
        event.stopPropagation();
        var self = $(this).parent();
        if (self.hasClass('timeout')){
          return false;
        } else {
          parent.find('.hovered').removeClass('hovered').find('.triangle').animate({bottom: '90%'},200);
          if ( ! self.hasClass('active')) {
            clearTimeout(timeoutHoverout);
            var left = Math.round(self.offset().left - $('.headBottomNav').offset().left + self.width() / 2);
            self.addClass('hovered').find('.triangle').animate({bottom: '100%', left: left},200);
          }
        }
      })
    item.find('> a').mouseleave(
      function(event){
        $(this).removeClass('mouseOver');
        event.stopPropagation();
        var self = $(this).parent();
        item.addClass('timeout');
        if ( ! self.hasClass('active')) {
          clearTimeout(timeoutHoverout);
          timeoutHoverout = setTimeout(function(){
            self.removeClass('hovered').find('.triangle').animate({bottom: '90%'},200).css('left', '10px');
          }, 3000);
        }
        timeoutHoverin = setTimeout(function(){
          item.removeClass('timeout');
          item.find('.mouseOver').trigger('mouseover');
        }, 300);
      })
  });

  //  function for pop Up windows
  //  just add class .openPopUp for link and id of target window in rel
    $('a.openPopUp').click(function(){
      var popId = $(this).attr('rel');
      if ($.browser.msie && $.browser.version == '7.0' || $.browser.msie && $.browser.version == '8.0' ) {
        $('#'+ popId + ', #overlay').show();
      } else {
        $('#'+ popId + ', #overlay').fadeIn();
      }

      var marginTop = Math.round($('#'+ popId).height() / 2 + 25);
      $('#'+ popId).css('margin-top', '-'+ marginTop +'px');
      return false;
    });

    $('.popUp .close').live('click', function() {
      $(this).closest('.popUp').fadeOut();
      $('#overlay').fadeOut(function(){
        $('body').trigger('click');
      });
    });
    $('#overlay').live('click', function(){
      $('.popUp').fadeOut();
      $(this).fadeOut();
    })
/*
  $('#searchInp').each(function(){
    var self = $(this);
    if (self.val()) {
      $('.searchResult').highlight(self.val());
    }
  });
*/

  $('.clearBtn').click(function(){
    $(this).parent().find('input:text').attr('value','');
  });

/*   $('.mainNav').each(function(){
    var parent = $(this).find('> .nav');

    parent.find('.navIco').click(function(){
      var self = $(this);
      var selfParent = self.parent();

      if (selfParent.children('div').length < 1) return true;
      if (self.hasClass('active')) {
        selfParent.find('.hidden').slideUp(function(){
          self.removeClass('active');
        });
      } else {
        parent.find('.navIco.active').removeClass('active').siblings('.hidden').slideUp();
        self.addClass('active');
        var $item = selfParent.find('.hidden');
        if ($item.is('#insert-map') && '' == $item.html()) {
          $item.html('<iframe id="map" src="https://maps.google.ru/maps/ms?t=m&amp;msa=0&amp;msid=200693181525551188420.0004c370a78cf0b6ed2c5&amp;source=embed&amp;ie=UTF8&amp;ll=55.735495,37.60221&amp;spn=0.011598,0.027466&amp;z=15&amp;iwloc=0004c370aa51afdb6a37a&amp;output=embed" frameborder="0" scrolling="no" height="350" width="100%"></iframe>');
        }
        $item.slideDown();

      }
      return false;
    });

  }); */

  $('.hiddenBlocksList h2').click(function(){
    $(this).siblings('.hidden').slideToggle();
  });

  $('input[placeholder], textarea[placeholder]').placeholder();

  $('.eventsList > li').hover(function(){
    $(this).addClass('hovered');
  }, function(){
    $(this).removeClass('hovered');
  });

  $('.eventsList > li, .allNewsList > li').click(function(){
    document.location.href = $(this).find('h4 a, h3 a').attr('href');
  });

  //ГАЛЕРЕЯ
function gallery() { 

    var
    box = $('.sliderWide'),
    items = box.find('li'),
    carousel = box.find('.sliderListWrp'),
    leftArr = box.find('.arrL'),
    rightArr = box.find('.arrR');

    var crlScroll = (function () {
      carousel.on('jcarousel:scrollend', function (event, gal) {
        carousel.jcarousel('items').removeClass('active');
        carousel.jcarousel('target').addClass('active');
      });
    });

    carousel.on('jcarousel:reload jcarousel:createend', function (event, carousel) {

      var
      visible = carousel.fullyvisible(),
      all = carousel.items();

      if (all.size() <= visible.size()) {
        visible.addClass('active');
      } else{
        crlScroll();
      } 
    });

    carousel.jcarousel({
        wrap: 'circular'
    }); 

    leftArr.jcarouselControl({
        target: '-=1'
    });

    rightArr.jcarouselControl({
        target: '+=1'
    });

    carousel.jcarousel('first').addClass('active');

    return carousel;

};

 


  $('form.authForm').bind('submit', function(){
    var $form = $(this);
    $('em', $form).remove();
    $(':submit', $form).attr('disabled', true);

    $.post($form.attr('action'), $form.serialize(), function(response){
      $(':submit', $form).removeAttr('disabled');
      if (response.success) {
        if (response.message) {
          $form.html(response.message);
        }
        else {
          location.reload(true);
        }
      }
      else if (typeof response.errors != 'undefined') {
        $.each(response.errors, function(k, v){
          if (k == 'global') $form.prepend($('<em>'+ v +'</em>'));
          else $(':input[name=user\\['+ k + '\\]]').before($('<em>'+ v +'</em>'));
        });
      }
    }, 'json');

    return false;
  });

  $('form.requestForm').bind('submit', function(){
    var $form = $(this);
    $('div.errorMsg', $form).remove();
    $(':submit', $form).attr('disabled', true);

    $.post($form.attr('action'), $form.serialize(), function(response){
      $(':submit', $form).removeAttr('disabled');
      if (response.success) {
        if (response.message) {
          $form.parent('div').html(response.message);
        }
        else {
          location.reload(true);
        }
      }
      else if (typeof response.errors != 'undefined') {
        $form.append($('<div/>').addClass('errorMsg').text(response.errors));
        $('#request_captcha').val('');
        $('#request_captcha_kcaptcha').trigger('click');
      }
    }, 'json');

    return false;
  });

  $('a.toggleForms').bind('click', function() {
    $(this).closest('form').siblings('form').andSelf().slideToggle().find('em').remove();
    return false;
  });


  $( "#from" ).datepicker({
    onSelect: function( selectedDate ) {
      $("#to").datepicker( "option", "minDate", selectedDate);
      if ($('#date').val()=='archive') {
          $("#to").datepicker( "option", "maxDate", new Date());
      }
      //selectedDate && '' != $("#to").val() && $('#selectDateHolder .hidden').fadeIn();
      $('#selectDateHolder .hidden').fadeIn();
      setTimeout(function(){
        $( "#to").datepicker( "show" );
      }, 300);
    },
    minDate: ($('#date').val()=='archive' || $('#book_category').val()=='book' ? null : new Date()),
    maxDate: ($('#date').val()=='archive' ? '-1d' : null),
    dateFormat: "dd.mm.yy"
  });

  $( "#to" ).datepicker({
    onSelect: function( selectedDate ) {
      //$("#from").datepicker( "option", "maxDate", selectedDate );
      //selectedDate && '' != $("#from").val() && $('#selectDateHolder .hidden').fadeIn();
      //$('#selectDateHolder .hidden').fadeIn();
      $('#selectDateHolder .hidden').fadeIn();
    },
    minDate: ($('#date').val()=='archive' || $('#book_category').val()=='book' ? null : new Date()),
    maxDate: ($('#date').val()=='archive' ? '-1d' : null),
    dateFormat: "dd.mm.yy"
  });

  $('.selectDate').click(function(){
    $(this).fadeOut(function(){
      $('#selectDateHolder').fadeIn().find('input:first').focus();
    });
  });

  $('#selectDateHolder a.btn').click(function(){
    $(this).closest('form').submit();
    return false;
  });
  $('.submitBtn').click(function(){
    $(this).closest('form').submit();
    return false;
  })


  var cardsResize = function () {
    $('.cards').each(function(){
      var parent = $(this);
      var maxHeight = 0;

      parent.find('>li').each(function(){
        $(this).css('min-height','0');
        if ( $(this).outerHeight() > maxHeight) {
          maxHeight = $(this).outerHeight();
        }
      });
      parent.find('>li').css('min-height',maxHeight);
    });
  }

  cardsResize();
  setTimeout(cardsResize, 200);

  $(window).resize(cardsResize);

  $('.slider').each(function(){
    var self = $(this);
    var ul = self.find('ul.sliderList');
    var lenght = ul.find('> li').length;
    var counter = 0;
    var paginator = self.find('.pagination');
    var circle = self.is('.sliderCircle');
    var timer;

    if (!$('li.active', paginator).length) {
      $('li:first', paginator).addClass('active');
      $('li:first', ul).addClass('active');
    }

    if (lenght == 1) {
      self.find('.arr').fadeOut();
    }
    else {

      var bindTimeout = function() {
        if (self.is('.timed')) {
          window.clearTimeout(timer);
          timer = window.setTimeout(function() {
            self.find('.arrR').trigger('click');
          }, 6000);
        }
      }
      bindTimeout();

      self.find('.arr').click(function(){
        bindTimeout();

        var that = $(this);
        if (that.hasClass('disabled') || ul.find('li.progress').length) {return}

        if( that.hasClass('arrR')) {
          self.find('.arrL.disabled').removeClass('disabled').fadeIn();
          if(ul.find('li.active').index() == lenght - 1 ) {
            ul.find('li.active').animate({left: '100%'},function(){
              $(this).hide().removeClass('active');
            });
            ul.find('li:first').addClass('progress').css('left', 'auto').fadeIn(function(){
              $(this).removeClass('progress').addClass('active');
            });
            counter=0;
          } else {

            ul.find('li.active').next('li').css('left', 'auto').addClass('progress').fadeIn(function(){
              $(this).removeClass('progress').addClass('active');
              if($(this).index() == lenght - 1 && circle != true) {
                that.addClass('disabled').fadeOut();
              }
            });

            self.find('.arrL.disabled').removeClass('disabled').fadeIn();
            ul.find('li.active').animate({left: '-100%'},function(){
              $(this).hide().removeClass('active');
            });
            counter++;
          }

        } else {
          if(ul.find('li.active').index() == 0 ) {
            ul.find('li.active').animate({left: '-100%'},function(){
              $(this).hide().removeClass('active');
            });

            ul.find('li:last').addClass('progress').fadeIn(function(){
              $(this).removeClass('progress').addClass('active');
              ul.find('> li').css('left', 'auto');
            });
            counter = lenght - 1;
          } else {
            ul.find('li.active').prev('li').addClass('progress').fadeIn(function(){
              $(this).removeClass('progress').addClass('active').css('left', 'auto');
              if($(this).index() == 0 && circle != true) {
                that.addClass('disabled').fadeOut();
              }
            });
            self.find('.arrR.disabled').removeClass('disabled').fadeIn();
            ul.find('li.active').animate({left: '100%'},function(){
              $(this).hide().removeClass('active');
            });
            counter--;
          }
        }
        paginator.find('.active').removeClass('active');
        paginator.find('li:eq('+ counter +')').addClass('active');

      });

      self.find('.pagination li').click(function(){
        var liPage = $(this);
        counter = liPage.index();
        if (liPage.hasClass('active') || ul.find('li:animated').length) {
          return
        } else {
          liPage.addClass('active').siblings('li.active').removeClass('active');
          var target = ul.find('li[data-item="'+ liPage.text() +'"]');
          if (target.not('.active')) {
            ul.find('li.active').fadeOut(function(){
              $(this).hide().removeClass('active');
            });
            target.addClass('progress').css('left', 'auto').fadeIn(function(){
              $(this).removeClass('progress').addClass('active');
            });
          }
        }
      });
    }
  });

  var bind_popup_forms = function($target) {
    $('form.ajax-send', $target).bind('submit', function() {
      $('input[type=submit]', this).attr('disabled', true);
      var $popUp = $(this).closest('.popUp');

      $.ajax({
        cache: false,
        type: this.method || 'GET',
        url: this.action,
        data: $(this).serialize(),
        error: function() {alert('Невозможно отправить форму.');},
        success: function(data) {
          $popUp.html($(data).html());
          bind_popup_forms($popUp);
        }
      });

      return false;
    });

  $('#datepicker_date').datepicker( $.datepicker.regional['ru']);
  $('.callendarLink').click(function(){
    $('#datepicker_date').focus();
  });


  //   for callendar in reserve form
    var $myBadDates;
    $('#datepicker_event_date').each(function(){
      var self = $(this);
      var parent = self.parent();
      var min = parent.find('.minDate').val();
      var max = parent.find('.maxDate').val();
      var badDaysInp = parent.find('.badDates');

      $myBadDates = (badDaysInp.val()).split(',');

      $('#datepicker_event_date').datepicker({
          minDate: min,
          maxDate: max,
          dateFormat: 'yy-mm-dd',
          beforeShowDay: checkBadDates
      });


      $('.popUp .icoCall').click(function(){
        $(this).parent().find('input:text').focus();
      });

    });

    $('#ui-datepicker-div').click(function(){
      return false;
    });

  //  check dates for callendar, (disabled dates)
    function checkBadDates(mydate){
      var $return=true;
      var $returnclass ="available";
      $checkdate = $.datepicker.formatDate('dd.mm.yy', mydate);
      for(var i = 0; i < $myBadDates.length; i++)
          {
            if($myBadDates[i] == $checkdate)
                {
              $return = false;
              $returnclass= "unavailable";
              }
          }
      return [$return,$returnclass];
    }
  }
  bind_popup_forms($('.popUp'));


  var feedbackForm = function() {
    $('input[type=submit]', this).attr('disabled', true);
    var $form = $(this);
    $.ajax({
      cache: false,
      type: this.method,
      url: this.action,
      data: $form.serialize(),
      error: function() {alert('Невозможно отправиь форму.');},
      success: function(data) {
        if (1 == $('form', data).length) {
          $form.replaceWith($('form', data).bind('submit', feedbackForm));
        }
        else {
          var w = window.open('', 'signup_popup', 'scrollbars=yes,width=600,height=450');
          w.document.writeln(data);
          $form.remove();
        }
      }
    });
    return false;
  }
  $('form.feedbackForm').bind('submit', feedbackForm);


  $('#worldMap').each(function(){
    var parent = $(this);
    var inner = $('#worldMapInner')

    parent.find('.marker').each(function() {
      $(this)
        .data('city', $(this).text())
        .text('')
        .live('click',function(){
          var self = $(this);
          var selfParent = self.parent();
          var hidden = selfParent.find('.hidden');

          $('body').trigger('click');
          if (selfParent.attr('id')) {$('body').trigger('click');return false}

          selfParent.addClass('active').attr('id','markerActive');
          $(this).text($(this).data('city'));
          hidden.fadeIn();

          $('body').bind('click.status', function(e){
            if ($(e.target).parents('#markerActive').size() == 0 && e.target.id != 'markerActive' ) {
              hidden.next('a.marker').text('');
              hidden.fadeOut(function(){
                selfParent.removeClass('active').removeAttr('id');
              });
              $('body').unbind('click.status');
            }
          });

          return false
        });
    });

    makeScrollable(parent, inner);

    $(window).resize(function(){
      makeScrollable(parent, inner);
    });

  });

  jQuery('#msg__close').click(function(){
    $(this).parent().slideUp(250);
  })

  if(typeof _global_date !== 'undefined'){
    var curDate = new Date(_global_date * 1000),
        curYear = curDate.getFullYear(),
        curMonth = curDate.getMonth() + 1,
        dateSelectForm = $('#date_filter'),
        monthOptions = dateSelectForm.find('#month').find('option');

    if (dateSelectForm.find('#year').val() == curYear){
      monthOptions.slice(curMonth + 1).attr('disabled', 'disabled');
        if (monthOptions.filter(':selected').val() > curMonth){
          monthOptions.eq(curMonth).attr('selected', 'selected');
        }
    } else {
        monthOptions.removeAttr('disabled');
    }
    dateSelectForm.find('#year').change(function(){
      if ($(this).val() == curYear){
        monthOptions.slice(curMonth + 1).attr('disabled', 'disabled');
        if (monthOptions.filter(':selected').val() > curMonth){
          monthOptions.eq(curMonth).attr('selected', 'selected');
        }
      } else {
        monthOptions.removeAttr('disabled');
      }
    })
  };




  //video on home page
  (function() {
    var
    v = $('#video_frame'),
    videoHeight = function() {
      vHeight = v.width() * 0.56;
      v.height(vHeight);
    };

    videoHeight();
    $(window).resize(videoHeight);
  
  })();
  //Обновление флага языка при переключении
  $('ul.menu.lang a').click(function(){
    var now = new Date();
    now.setTime( now.getTime() + (24 * 60 * 60 * 1000) );
    document.cookie = 'last_culture='+ $(this).data('lang') + 
    '; expires=' + now.toUTCString() + '; path=/';
  });
});

function makeScrollable(outer, inner){
  var extra = 800;
  var divWidth = outer.width();
  outer.css({overflow:'hidden'});
  var scrollToTarget = inner.find('img');
  outer.scrollLeft(0);
  var timeout;
  outer.unbind('mousemove').bind('mousemove', function (e) {
    clearTimeout(timeout);
    timeout = setTimeout(function(){
      var containerWidth = scrollToTarget[0].offsetLeft + scrollToTarget.outerWidth() + 2 * extra;
        var left = (e.pageX - outer.offset().left) * (containerWidth - divWidth) / divWidth - extra;
        outer.animate({scrollLeft: left});
    },50)

  });
}

jQuery.fn.highlight = function(pat) {
 function innerHighlight(node, pat) {
  var skip = 0;
  if (node.nodeType == 3) {
   var pos = node.data.toUpperCase().indexOf(pat);
   if (pos >= 0) {
    var spannode = document.createElement('mark');
    spannode.className = 'highlight';
    var middlebit = node.splitText(pos);
    var endbit = middlebit.splitText(pat.length);
    var middleclone = middlebit.cloneNode(true);
    spannode.appendChild(middleclone);
    middlebit.parentNode.replaceChild(spannode, middlebit);
    skip = 1;
   }
  }
  else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
   for (var i = 0; i < node.childNodes.length; ++i) {
    i += innerHighlight(node.childNodes[i], pat);
   }
  }
  return skip;
 }
 return this.each(function() {
  innerHighlight(this, pat.toUpperCase());
 });
};