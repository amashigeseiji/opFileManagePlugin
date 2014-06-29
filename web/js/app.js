require.config({
  paths: {
    jquery: '../../js/jquery.min',
    util: 'lib/util',
    Editor: 'view/fileNameEditor'
  },
});

require(['jquery', 'util', 'Editor'], function($, util, Editor) {
  for (var i in selector) {
    util.create(Editor).init(selector[i]);
  }
});
