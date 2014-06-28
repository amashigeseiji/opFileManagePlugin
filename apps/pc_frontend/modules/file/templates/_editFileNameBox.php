<script type="text/javascript">
$(document).ready(function() {
  var util = {
    create: function(prototype) {
      function f() {}
      f.prototype = prototype;
      return new f;
    },
    bind: function(eventType, trigger, data, event) {
      trigger.bind(eventType, data, event);
    }
  }

  var Editor = {
    isActive: false,
    init: function(selector) {
      util.bind('click', $(selector.trigger), {editor: this}, this.onClick);
      this.root = $(selector.root);
      this.contents = {
        active:   $(selector.activeContents).html(),
        inactive: this.root.html()
      };
    },
    toggle: function() {
      if (this.isActive) {
        this.isActive = false;
        this.root.html(this.contents.inactive)
      } else {
        this.isActive = true;
        this.root.html(this.contents.active);
        util.create(EditorInput).init(this.root);
      }
    },
    onClick: function(event) { event.data.editor.toggle(); }
  };

  var EditorInput = {
    init: function(root) {
      this.link = root.find('a');
      var data = {
        link: this.link,
        href: this.link.attr('href')
      }
      util.bind('keyup', root.find('input[type=text]'), data, this.onChangeText);
    },
    onChangeText: function(event) {
      event.data.link.attr('href', event.data.href + '?name=' + this.value);
    }
  };

  var selector = {
    root:'.filename_<?php echo $file->id ?>',
    activeContents:'#file_edit_name_<?php echo $file->id ?>',
    trigger: '<?php echo $trigger ?>'
  };
  util.create(Editor).init(selector);
});
</script>

<?php
$options = array(
  'method'  => 'put',
  'class'   => 'btn btn-small btn-primary',
  'style'   => 'color: #ffffff'
);
?>
<div id="file_edit_name_<?php echo $file->getId() ?>" class="hide">
  <span class="form form-inline">
    <input type="text" placeholder="<?php echo $file->getName() ?>" />
    <?php echo link_to('確定', '@file_edit_name?id='.$file->getId(), $options) ?>
  </span>
</div>
