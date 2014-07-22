<a href="javascript:void(0)" id="directory_create_link"><?php echo __('Create directory') ?></a>

<?php
include_partial('file/formModal', array(
  'form'    => $form,
  'url'     => url_for('directory_create'),
  'title'   => __('Create directory'),
  'widgets' => $form->getRenderWidgetNames(),
  'id'      => 'directory_create_form',
  'trigger' => '#directory_create_link'
));
