<script type="text/javascript">
$(document).ready(function() {
  var fileId = "<?php echo $file->getId() ?>";
  var trigger = $("<?php echo $trigger ?>");

  var toggle = function(td, div, filename) {
    if (!div.hasClass('active')) {
      div.addClass('active');
      td.html(div.html());
    } else {
      div.removeClass('active');
      td.html(filename)
    }
  }

  var
    td = $('.filename_' + fileId),
    filename = td.html();

  trigger.on('click', function() {
    toggle(td, $('#file_edit_name_' + fileId), filename);

    var
      editlink = td.find('a'),
      href = editlink.attr('href');

    td.find('input[type=text]').on('keyup', function() {
      editlink.attr('href', href + '?name=' + this.value);
    });
  });
});
</script>

<div id="file_edit_name_<?php echo $file->getId() ?>" class="hide">
  <span class="form form-inline">
    <input type="text" placeholder="<?php echo $file->getName() ?>" />
    <?php echo link_to(
      '確定',
      '@file_edit_name?id='.$file->getId(),
      array(
        'method'  => 'put',
        'class'   => 'btn btn-small btn-primary',
        'style'   => 'color: #ffffff'
      )
    ) ?>
  </span>
</div>
