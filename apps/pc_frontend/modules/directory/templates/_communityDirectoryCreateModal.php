<?php
use_stylesheet('/opFileManagePlugin/css/communityModal');

$form = new FileDirectoryForm();
$form->getWidget('type')->setHidden(true);
$form->getWidget('type')->setDefault('community');
$form->getWidget('community_id')->setHidden(true);
$form->getWidget('community_id')->setDefault($community->id);

include_partial('file/formModal', array(
  'form'    => $form,
  'url'     => url_for('directory_create'),
  'title'   => 'フォルダを追加する',
  'widgets' => $form->getRenderWidgetNames(),
  'id'      => 'directory_create_form',
  'trigger' => $trigger
));
