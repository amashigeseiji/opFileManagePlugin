require(['jquery', util], function($, util) {
  define(function() {
    var Editor = {
      init: function(selector) {
        util.bind('click', $(selector.trigger), {editor: this}, this.onClick);
        this.isActive = false;
        this.root = $(selector.root);
        this.contents = {
          active: $(selector.activeContents).html(),
          inactive: this.root.html()
        };
      },
      onClick: function(event) {
        var editor = event.data.editor;
        if (editor.isActive) {
          editor.isActive = false;
          editor.root.html(editor.contents.inactive)
        } else {
          editor.isActive = true;
          editor.root.html(editor.contents.active);
          util.create(EditorInput).init(editor.root);
        }
      }
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

    return Editor;
  });
});
