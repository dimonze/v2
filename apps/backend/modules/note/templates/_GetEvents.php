<?php
$eArray =null;
foreach ($events as $event)
{  
    $eArray[] = array('id' => $event->id, 'value' => $event->title, 'type' => 'event');
  
}
foreach ($books as $book)
{  
    $eArray[] = array('id' => $book->id, 'value' => $book->book_name, 'type' => 'book');
  
}

echo (json_encode($eArray));

?>