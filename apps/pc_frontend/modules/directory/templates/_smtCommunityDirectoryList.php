<div class="gadget_header span12 row">
<?php echo __('Shared directory') ?>
</div>

<div class="row">

  <?php if ($pager->getNbResults()): ?>
  <div class="row">
    <?php foreach ($pager as $directory): ?>
    <?php if ($directory->isViewable(sfContext::getInstance()->getUser()->getMember())): ?>
    <div class="row" style="margin-left: 15px">
    <?php echo link_to($directory->name, '@directory_show?id='.$directory->id) ?>
    &nbsp;(<?php echo $directory->getMember()->name ?>)
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <div class="btn-group" style="float: right;">
    <?php include_component('directory', 'communityDirectoryCreateModal', array('community' => $community)) ?>
    <?php if ($pager->getNbResults()): ?>
    <a class="btn btn-small" href="<?php echo url_for('@directory_list_community?id='.$community->id) ?>"><?php echo __('More') ?></a>
    <?php echo link_to(__('File list of %1%', array('%1%' => $community->name)), '@file_list_community?id='.$community->id, array('class' => 'btn btn-small')) ?>
    <?php endif; ?>
  </div>


</div>
