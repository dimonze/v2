<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_book_name">
  <?php if ('book_name' == $sort[0]): ?>
    <?php echo link_to(__('Название книги', array(), 'messages'), '@book', array('query_string' => 'sort=book_name&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'book_name' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Название книги', array(), 'messages'), '@book', array('query_string' => 'sort=book_name&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_author">
  <?php if ('author' == $sort[0]): ?>
    <?php echo link_to(__('Автор', array(), 'messages'), '@book', array('query_string' => 'sort=author&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'author' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Автор', array(), 'messages'), '@book', array('query_string' => 'sort=author&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_publishing_house">
  <?php if ('publishing_house' == $sort[0]): ?>
    <?php echo link_to(__('Издательство', array(), 'messages'), '@book', array('query_string' => 'sort=publishing_house&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'publishing_house' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Издательство', array(), 'messages'), '@book', array('query_string' => 'sort=publishing_house&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>