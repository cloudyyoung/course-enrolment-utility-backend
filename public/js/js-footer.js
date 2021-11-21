
$.extend({
  "i18nNames": ["lang/lang"],
  "i18nReplace": function (addNames = []) {
    if (addNames instanceof Array) {
      $.i18nNames = $.merge($.i18nNames, addNames);
    } else if (typeof (addNames) == 'string' && addNames != "") {
      $.i18nNames.push(addNames);
    }

    $.i18n.properties({
      name: $.i18nNames,
      mode: 'map',
      cache: false,
      encoding: 'UTF-8'
    });

    $("[i18n], [i18n-title]").each(function () {
      try {
        if ($(this).attr("i18n-ignore") != "true") {

          if (typeof ($(this).attr("i18n")) != "undefined") {
            if ($(this).has('input')) {
              $(this).attr('placeholder', $.i18n.prop($(this).attr("i18n")));
            }
            $(this).html($.i18n.prop($(this).attr("i18n")));
          }
          if (typeof ($(this).attr("i18n-title")) != "undefined") {
            $(this).attr('title', $.i18n.prop($(this).attr("i18n-title")));
          }

        }
      } catch (e) {
        // console.log(e);
      }
    });
  }
});

$.i18nReplace();