<?php if (!empty($logos)): ?>
  <div class="span6 sponsors__cont right headerRight">    
    <ul class="menu fr sponsors">
      <?php foreach ($logos as $l): ?>
        <li class="sponsors__item">
          <div class="sponsors__status"><?= $l['status'] ?></div>
          <?php if (!empty($l['link'])): ?><a href="<?= $l['link'] ?>" target="_blank"><?php endif ?>
            <div class="sponsors__img-box">
              <img class="sponsors__img" src="/uploads/logos/<?= $l['image'] ?>" alt=""/>
            </div>
          <?php if (!empty($l['link'])): ?></a><?php endif ?>
        </li>
      <?php endforeach ?>
    </ul>
  </div> 
<?php endif ?>