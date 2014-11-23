<div class="search-box">
  <form action="<?php echo url_for('@file_index') ?>" method="get" class="form-inline">
    <div class="form-group">
    <?php $params = $sf_request->getParameter('file') ?>
      <input type="text" placeholder="<?php echo __('File name') ?>" name="file[name]" value="<?php echo $params['name'] ?>" />
      <input type="text" placeholder="<?php echo __('note') ?>" name="file[note]" value="<?php echo $params['note'] ?>" />
      <input type="hidden" name="search" value="true">
      <button type="submit" class="btn btn-small">検索</button>
    </div>
  </form>
</div>
