<div class="v-box">
  <h3 class="v-box__h"><?= __('HOURS AND TICKETS') ?></h3>
  <div class="row-fluid">
    <div class="span6">
      <div class="v-box__schedule">
        <div class="v-box__day"><?= __('Monday') ?> – <?= __('Thursday') ?></div>
        <div class="v-box__time">11:00 – 21:00*</div>
      </div>
    </div>
    <div class="span6">
      <div class="v-box__schedule">
        <div class="v-box__day"><?= __('Friday') ?> – <?= __('Sunday') ?></div>
        <div class="v-box__time">11:00 – 22:00*</div>        
      </div>
    </div>    
  </div>
  <div class="v-box__text">
    <p>*<?=  __('Ticket office closes 30 minutes before Museum closing time.') ?></p>
    <p><?=  __('All lectures, concerts and open workshops for kids are free.') ?></p>
    <p><?=  __('Exhibition ticket information:') ?> +7 (495) 645-05-20 </p>
    <p><?= link_to(__('CATEGORIES AND PRICES'), 'page/visit', 'class=uppercase') ?></p>
  </div>
</div>