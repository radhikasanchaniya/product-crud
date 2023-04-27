"use strict";
var DatatablesDataSourceHtml = (function () {
  var initItemTable = function () {
    $("#itemTable").DataTable({
      processing: true,
      serverSide: true,
      stateSave: true,
      ajax: {
        url: $("#itemTable").attr("data-url"),
        dataType: "json",
        type: "POST",
        data: function (d) {
          return $.extend({}, d, {});
        },
      },
      order: [[0, "desc"]],
      columns: [
        { data: "name" },
        { data: "description" },
        { data: "action" },
      ],
    });
  };

  return {
    init: function () {
      initItemTable();
    },
  };
})();

jQuery(document).ready(function () {
  DatatablesDataSourceHtml.init();
});
