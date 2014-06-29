define(function(){
  return {
    create: function(prototype) {
        function f() {}
        f.prototype = prototype;
        return new f;
    },
    bind: function(eventType, trigger, data, event) {
        trigger.bind(eventType, data, event);
    }
  }
});
