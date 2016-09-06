<?php if($video[0]->on_homepage): ?>
<?php
preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video[0]->video_url, $match);
    $video_id = $match[1];
?>
<div class="video-box">
  <h3 class="v-box__h"><?= ($video[0]->title) ?></h3>
  <iframe id="video_frame" width="100%" height="275" src="//www.youtube.com/embed/<?= $video_id ?>" frameborder="0" allowfullscreen></iframe>
</div>
<?php endif; ?>
