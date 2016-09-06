<?php

function set_metas($object)
{
  $response = sfContext::getInstance()->getResponse();

  $title = $object->seo_title ? $object->seo_title : $object->title;
  $response->setTitle($title);

  if ($description = $object->seo_description) $response->addMeta('description', $description);
}

function image_tag_mtime($file, $skipsizes = true, $options = array())
{
  $path = sfConfig::get('sf_web_dir') . $file;
  if ($skipsizes) {
    return image_tag($file . '?' . filemtime($path), $options);
  }
  else {
    list($w, $h) = getimagesize($path);
    $options = array_merge($options, array('width' => $w, 'height' => $h));
    return image_tag($file . '?' . filemtime($path), $options);
  }
}



function event_dates($event)
{
  if ($event->date_end) {
    return sprintf('%s / %s', format_date($event->date_start), format_date($event->date_end));
  }
  else {
    return format_date($event->date_start);
  }
}

function event_class($event)
{
  switch ($event->type) {
    case Event::TYPE_EXHIBITION:
    case Event::TYPE_EXHIBITION_OUTER:
    case Event::TYPE_EXHIBITION_SPACE:
      return 'purpurBox';

    case Event::TYPE_CHILDREN:
    case Event::TYPE_CHILDREN_CLASS:
      return 'orangeBox';

    case Event::TYPE_EDUCATION:
    case Event::TYPE_EDUCATION_CLASS:
    case Event::TYPE_EDUCATION_FILM:
    case Event::TYPE_EDUCATION_MUSIC:
    case Event::TYPE_EDUCATION_BOOKS:
      return 'blueBox';
    case Event::TYPE_RESEARCH_PROJECTS:
      return 'grassBox';
    case Event::TYPE_PERFORMANCE:
    case Event::TYPE_PERFORMANCE_PLATFORM:
    case Event::TYPE_PERFORMANCE_EDUCATION:
      return 'redBox';
  }
}

function event_type($event)
{
  switch ($event->type) {
    case Event::TYPE_EXHIBITION:
      return '<h6 class="wiolet">' . __('exhibition') . '</h6>';
    case Event::TYPE_EXHIBITION_OUTER:
      return '<h6 class="wiolet">' . __('project') . '</h6>';
    case Event::TYPE_EXHIBITION_SPACE:
      return '<h6 class="wiolet">' . __('project space') . '</h6>';

    case Event::TYPE_CHILDREN:
    case Event::TYPE_CHILDREN_CLASS:
      return '<h6 class="orange">' . __('Kids') . '</h6>';

    case Event::TYPE_EDUCATION:
      return '<h6 class="biruza">' . __('lecture') . '</h6>';
    case Event::TYPE_EDUCATION_CLASS:
      return '<h6 class="biruza">' . __('course') . '</h6>';
    case Event::TYPE_EDUCATION_FILM:
      return '<h6 class="biruza">' . __('Films') . '</h6>';
    case Event::TYPE_EDUCATION_MUSIC:
      return '<h6 class="biruza">' . __('Music') . '</h6>';
    case Event::TYPE_EDUCATION_BOOKS:
      return '<h6 class="biruza">' . __('publishing') . '</h6>';
    case Event::TYPE_RESEARCH_PROJECTS:
      return '<h6 class="grass">' . __('Research Projects') . '</h6>';
    case Event::TYPE_PERFORMANCE:
      return '<h6 class="red">' . __('Performance') . '</h6>';
    case Event::TYPE_PERFORMANCE_PLATFORM:
      return '<h6 class="red">' . __('Performance') . '</h6>';
    case Event::TYPE_PERFORMANCE_EDUCATION:
      return '<h6 class="red">' . __('Performance') . '</h6>';
  }
}

function render_event_1($event)
{
  $url = url_for('event_show', $event);
  return sprintf('
    <div class="row-fluid %s">
      <div class="evntTxtWrp">
        %s
        <h4>%s</h4>
        <time class="uppercase">%s</time>
        <div class="box__price">%s</div>
      </div>
      <a class="imgEvent" href="%s">
        %s
        <div class="triangle triangle-down"></div>
      </a>
    </div>
  ', event_class($event), event_type($event), link_to($event->title, $url),
     event_dates($event), (int)$event->price == 0 ? '' : (int)$event->price,  $url, image_tag_mtime($event->preview1));
}

function render_event_2($event)
{
  $url = url_for('event_show', $event);
  return sprintf('
    <div class="row-fluid %s">
      <div class="span6">
        <div class="evntTxtWrp">
          %s
          <h4>%s</h4>
          <time class="uppercase">%s</time>
          <div class="box__price">%s</div>
        </div>
      </div>
      <div class="span6">
        <a class="imgEvent" href="%s">
          %s
          <div class="triangle triangle-right"></div>
        </a>
      </div>
    </div>
  ', event_class($event), event_type($event), link_to($event->title, $url),
     event_dates($event), (int)$event->price == 0 ? '' : (int)$event->price, $url, image_tag_mtime($event->preview2));
}

function render_event1($event)
{
  $url = url_for('event_show', $event);
  return sprintf('
    <div class="row-fluid %s">
      <div class="evntTxtWrp">
        %s
        <h4>%s</h4>
        <time class="uppercase">%s</time>
      </div>
      <a class="imgEvent" href="%s">
        %s
        <div class="triangle triangle-down"></div>
      </a>
    </div>
  ', event_class($event), event_type($event), link_to($event->title, $url),
     event_dates($event),  $url, image_tag_mtime($event->preview1));
}

function render_event1_red($event)
{
  $url = url_for('event_show', $event);
  return sprintf('
    <div class="row-fluid %s">
      <div class="evntTxtWrp">
        %s
        <h4>%s</h4>
        <time class="uppercase">%s</time>
      </div>
      <a class="imgEvent" href="%s">
        %s
        <div class="triangle triangle-down"></div>
      </a>
    </div>
  ', 'redBox', event_type($event), link_to($event->title, $url),
     event_dates($event),  $url, image_tag_mtime($event->preview1));
}


function render_event2($event)
{
  $url = url_for('event_show', $event);
  return sprintf('
    <div class="row-fluid %s">
      <div class="span6">
        <div class="evntTxtWrp">
          %s
          <h4>%s</h4>
          <time class="uppercase">%s</time>
        </div>
      </div>
      <div class="span6">
        <a class="imgEvent" href="%s">
          %s
          <div class="triangle triangle-right"></div>
        </a>
      </div>
    </div>
  ', event_class($event), event_type($event), link_to($event->title, $url),
     event_dates($event), $url, image_tag_mtime($event->preview2));
}

function render_book_1($book)
{
  $url = url_for('book_show', $book);
  return sprintf('
    <div class="row-fluid blueBox">
      <div class="evntTxtWrp">
        <h6 class="blue">%s</h6> 
        <h4>%s</h4>
        <time class="uppercase">%s</time>
         <div class="box__price">%s</div>
      </div>     
      <a class="imgEvent" href="%s">
        %s
        <div class="triangle triangle-down"></div>
      </a>
    </div>
  ', __('Books'), link_to($book->book_name, $url),
     $book->publication_date, (int)$book->price == 0 ? '' : (int)$book->price, $url, image_tag_mtime($book->preview1));
}

function render_book_2($book)
{
  $url = url_for('book_show', $book);
  return sprintf('
    <div class="row-fluid blueBox">
      <div class="span6">
        <div class="evntTxtWrp">
        <h6 class="blue">%s</h6>          
          <h4>%s</h4>
          <time class="uppercase">%s</time>
          <div class="box__price">%s</div>
        </div>        
      </div>
      <div class="span6">
        <a class="imgEvent" href="%s">
          %s
          <div class="triangle triangle-right"></div>
        </a>
      </div>
    </div>
  ', __('Books'), link_to($book->book_name, $url),
     $book->publication_date, (int)$book->price == 0 ? '' : (int)$book->price, $url, image_tag_mtime($book->preview2));
}


function render_book1($book)
{
  $url = url_for('book_show', $book);
  return sprintf('
    <div class="row-fluid blueBox">
      <div class="evntTxtWrp">
        <h6 class="blue">%s</h6> 
        <h4>%s</h4>
        <time class="uppercase">%s</time>
      </div>     
      <a class="imgEvent" href="%s">
        %s
        <div class="triangle triangle-down"></div>
      </a>
    </div>
  ', __('Books'), link_to($book->book_name, $url),
     $book->publication_date, $url, image_tag_mtime($book->preview1));
}

function render_book2($book)
{
  $url = url_for('book_show', $book);
  return sprintf('
    <div class="row-fluid blueBox">
      <div class="span6">
        <div class="evntTxtWrp">
        <h6 class="blue">%s</h6>          
          <h4>%s</h4>
          <time class="uppercase">%s</time>
        </div>        
      </div>
      <div class="span6">
        <a class="imgEvent" href="%s">
          %s
          <div class="triangle triangle-right"></div>
        </a>
      </div>
    </div>
  ', __('Books'), link_to($book->book_name, $url),
     $book->publication_date, $url, image_tag_mtime($book->preview2));
}

function render_event3($event)
{
  $url = url_for('event_show', $event);
  return sprintf('
    <div class="row-fluid %s">
      <div class="evntTxtWrp">
        %s
        <h4>%s</h4>
        <time class="uppercase">%s</time>
      </div>
      <a class="imgEvent" href="%s">
        <div class="triangle triangle-down"></div>
        %s
      </a>
    </div>
  ', event_class($event), event_type($event), link_to($event->title, $url),
     event_dates($event), $url, image_tag_mtime($event->preview2));
}

function render_book3($book)
{
  $url = url_for('book_show', $book);
  return sprintf('
    <div class="row-fluid %s">
      <div class="evntTxtWrp">
        <h4>%s</h4>
        <time class="uppercase">%s</time>
      </div>
      <a class="imgEvent" href="%s">
        <div class="triangle triangle-down"></div>
        %s
      </a>
    </div>
  ', 'blueBox', link_to($book->book_name, $url),
     $book->publication_date, $url, image_tag_mtime($book->preview2));
}

function render_event4($event)
{
  $url = url_for('event_show', $event);
  return sprintf('
    <div class="row-fluid %s">
      <div class="span4">
        <div class="evntTxtWrp">
          %s
          <h4>%s</h4>
          <time class="uppercase">%s</time>
          %s
        </div>
      </div>
      <div class="span8">
        <a class="imgEvent" href="%s">
          %s
          <div class="triangle triangle-right"></div>
        </a>
      </div>
    </div>
  ', event_class($event), event_type($event), link_to($event->title, $url),
     event_dates($event), $event->short, $url, image_tag_mtime($event->preview3));
}

function render_event4_red($event)
{
  $url = url_for('event_show', $event);
  return sprintf('
    <div class="row-fluid %s">
      <div class="span4">
        <div class="evntTxtWrp">
          %s
          <h4>%s</h4>
          <time class="uppercase">%s</time>
          %s
        </div>
      </div>
      <div class="span8">
        <a class="imgEvent" href="%s">
          %s
          <div class="triangle triangle-right"></div>
        </a>
      </div>
    </div>
  ', 'redBox', event_type($event), link_to($event->title, $url),
     event_dates($event), $event->short, $url, image_tag_mtime($event->preview3));
}

function render_event_for_today($event)
{
  $url = url_for('event_show', $event);
  return sprintf('
    <article class="release">
      <div class="release__info">
        <h3 class="release__type">%s</h3>
        <h2 class="release__header">%s</h2>
        <time class="release__date" datetime="%s">%s</time>
      </div>
      <div class="release__img-box">
        %s
      </div>
    </article>
  ', strip_tags(event_type($event)), link_to($event->title, $url),
     event_dates($event), event_dates($event), image_tag_mtime($event->preview3, true, array('class' => 'release__img')));
}




function gallery_class($gallery)
{
  if ($gallery->Event->exists()) {
    return event_class($gallery->Event);
  }
  else {
    return 'darkBlueBox';
  }
}

function gallery_type($gallery)
{
  if ($gallery->Event->exists()) {
    return event_type($gallery->Event);
  }
  elseif ($gallery->News->exists()) {
    return '<h6>' . __('event') . '</h6>';
  }
  else {
    return '<h6>' . __('gallery') . '</h6>';
  }
}


function get_record_url($record)
{
  $route = strtolower(get_class($record)) . '_show';
  return url_for($route, $record);
}

function get_record_thumb($record)
{
  switch (get_class($record)) {
    case 'Event':     return $record->preview1;
    case 'News':      return $record->preview_image_thumb;
    case 'Gallery':   return $record->preview_thumb;
  }
}



function event_coords($event)
{
  if (!$event->coords) {
    return false;
  }
  // left: 275px; top: 495px;
  list($left, $top) = Geocoder::getPxByLatLng($event->coords['lat'], $event->coords['lng'], 1.75, false);
  return sprintf('left: %dpx; top: %dpx;', $left - 20, $top - 16 - 15);
}