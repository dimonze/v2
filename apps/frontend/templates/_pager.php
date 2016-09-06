<?php
if (!$pager->haveToPaginate()) {
  return;
}
if (empty($params)) {
  $params = array();
}
else {
  $params = $params->getRawValue();
}
$params['page'] = '';

$qsFilter = function($url, $varname) {
  list($urlpart, $qspart) = array_pad(explode('?', $url), 2, '');
  parse_str($qspart, $qsvars);
  unset($qsvars[$varname]);
  $newqs = http_build_query($qsvars);
  if (empty($newqs)) {
    return $urlpart;
  } else {
    return $urlpart . '?' . $newqs;
  }
};

$route = sfContext::getInstance()->getRequest()->getUri();
$route = $qsFilter($route, 'page');
$route .= (strpos($route, '?') ? '&' : '?') . http_build_query($params);

$pages = range(max($pager->getPage() - 1, 1), min($pager->getPage() + 1, $pager->getLastPage()));
?>
<div class="pagination pagination_bottom pagination-centered">
  <?= link_to_if(
    1 != $pager->getPage(),
    ' ',
    $route . ($pager->getPage() - 1),
    'class=arr arrL'
  ) ?>   
  <?= link_to_if(
    $pager->getLastPage() != $pager->getPage(),
    ' ',
    $route . ($pager->getPage() + 1),
    'class=arr arrR'
  ) ?>
  
  <ul> 
      <?php if ($pager->getPage() > $pager->getFirstPage() + 1): ?>             
      <?= link_to($pager->getFirstPage(), $route . $pager->getFirstPage()) ?>
      <?php endif?>
      
      <?php if ($pager->getPage() > $pager->getFirstPage() + 2): ?>
      <?= link_to(" .. ",$route . ($pager->getPage() - 2)) ?>       
      <?php endif?>
      
      <?php foreach ($pages as $page): ?>
      <li class="<?= $pager->getPage() == $page ? 'active' : '' ?>">
      <?= link_to($page, $route . $page) ?>          
      </li>
      <?php endforeach ?> 
      
      <?php if ($pager->getPage() < $pager->getLastPage() - 1): ?>
      
      <?php if ($pager->getPage() < $pager->getLastPage() - 2): ?>
      <?= link_to(" .. ",$route . ($pager->getPage() + 2)) ?>    
      <?php endif ?>
      
      <?= link_to($pager->getLastPage(), $route . $pager->getLastPage()) ?>
      <?php endif?>      
  </ul>
      <?php if ($pager->getLastPage() > 15): ?>     
        <div class="pagination_target" id="">              
            <input class="targetPage" style="width:20px;"/>
            <input class="blackBtn" type="button" value="<?= __('Jump to', '', 'messages') ?>"/>       
        </div>
      <?php endif?>
      <script>
        $('.pagination_target .blackBtn').click(function(){
          var myVal = $(this).parent().find(".targetPage").val();
          if(myVal > 0){
            document.location.href = '<?php echo $route; ?>' + myVal;
          }
        });      
      </script>
</div>


