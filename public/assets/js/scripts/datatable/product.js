"use strict";
var DatatablesDataSourceHtml = (function () {
  var initProductTable = function () {
    $("#productTable").DataTable({
      processing: true,
      serverSide: true,
      stateSave: true,
      ajax: {
        url: $("#productTable").attr("data-url"),
        dataType: "json",
        type: "POST",
        data: function (d) {
          return $.extend({}, d, {});
        },
      },
      order: [[0, "desc"]],
      columns: [
        { data: "image" },
        { data: "item_id" },
        { data: "price" },
        { data: "qty" },
        { data: "action" },
      ],
    });
  };

  return {
    init: function () {
      initProductTable();
    },
  };
})();

jQuery(document).ready(function () {
  DatatablesDataSourceHtml.init();
});
