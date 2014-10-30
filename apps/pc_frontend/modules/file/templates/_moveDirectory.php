<?php $root = 'move_directory_'.$file->id ?>
<div id="<?php echo $root ?>" class="hide">
  <span class="form form-inline">
  <?php
    if ('community' === $file->FileDirectory->type)
    {
      $options = array(
        'type'          => 'community_directory',
        'community_id'  => $file->FileDirectory->getConfig()->getCommunityId(),
        'selected'      => $file->FileDirectory->id
      );
    }
    else
    {
      $options = array(
        'type'       => 'member_directory',
        'member_id'  => $sf_user->getMemberId(),
        'selected'   => $file->FileDirectory->id
      );
    }
  ?>
  <?php $widget = new opWidgetFormSelectDirectory($options) ?>
  <?php echo $widget->render('directory') ?>
  <?php echo link_to(
    __("Modify"),
    '@file_move_directory?id='.$file->id.'&directory_id='.$file->FileDirectory->id,
    array('method' => 'put', 'class' => 'btn btn-small btn-primary', 'style' => 'color: #fff')
  ) ?>
  </span>
</div>

<script>
$(document).ready(function(){
  var root = $('#<?php echo $root ?>');
  var trigger = $('<?php echo $trigger ?>');

  var toggle = function(){
    if (root.hasClass('hide')) {
      root.removeClass('hide')
    } else {
      root.addClass('hide')
    }
  }

  trigger.on('click', toggle);

  root.find('select').on('change', function() {
    var value = this.value;

    var a = root.find('a');
    var href = a.attr('href');

    a.attr('href', href.replace(/[0-9]*$/, value));
  });
});
</script>
