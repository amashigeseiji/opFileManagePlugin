<div class="search-box">
  <form action="<?php echo url_for('@file_index') ?>" method="get" class="form-inline">
    <div class="form-group">
    <?php $params = $sf_request->getParameter('file') ?>
      <input type="text" placeholder="ファイル名" name="file[name]" value="<?php echo $params['name'] ?>" />
      <input type="text" placeholder="説明" name="file[note]" value="<?php echo $params['note'] ?>" />
      <input type="hidden" name="search" value="true">
      <button type="submit" class="btn btn-small">検索</button>
    </div>
  </form>
</div>
