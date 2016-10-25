//changes website title upon losing focus
jQuery(function ($) {
  var message = 'We miss you, come back!';
  var original;
  $(window).focus(function() {
    if(original) {
      document.title = original;
    }
  }).blur(function() {
    var title = $('title').text();
    if(title != message) {
      original = title;
    }
    document.title = message;
  });
});