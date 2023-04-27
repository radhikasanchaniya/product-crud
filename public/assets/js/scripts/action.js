$(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip();

  if (jQuery().validate) {
    jQuery.validator.setDefaults({
      errorPlacement: function (error, element) {
        $(error).addClass("text-danger");
        error.insertAfter(element);
      },
    });

   
    $.validator.addMethod(
      "filesize",
      function (value, element, param) {
        if (element.files.length) {
          return this.optional(element) || element.files[0].size <= param;
        }
        return true;
      },
      "File size must be less than 5mb."
    );
  }

  $(document).on("click", ".delete-confrim", function (e) {
    e.preventDefault();

    var el = $(this);
    var url = el.attr("href");
    var id = el.data("id");
    var refresh = el.closest("table");
    Swal.fire({
      title: "Are you sure?",
      text: "This is just Soft Deletes",
      icon: "warning",
      showCancelButton: !0,
      confirmButtonText: "Yes, delete it!",
      customClass: {
        confirmButton: "btn btn-primary",
        cancelButton: "btn btn-outline-danger ml-1",
      },
      buttonsStyling: !1,
    }).then((result) => {
      if (result.value) {
        //showLoader();
        $.ajax({
          type: "POST",
          url: url,
          cache: false,
          data: {
            id: id,
            _method: "DELETE",
          },
        })
          .always(function (respons) {
            //stopLoader();

            $(refresh).DataTable().ajax.reload();
          })
          .done(function (respons) {
            Swal.fire({
              title: "Success",
              text: respons.message,
              icon: "success",
              customClass: { confirmButton: "btn btn-primary" },
              buttonsStyling: !1,
            });
          })
          .fail(function (respons) {
            console.log(respons);
            var data = respons.responseJSON;
            if (respons.responseJSON.errormessage) {
              data.message =
                "This data is use in other modules so you can’t delete";
            }
            if (respons.responseJSON.catgeorymessage) {
              data.message = "This data is use in parent so you can’t delete";
            }
            Swal.fire({
              title: "Error",
              text: data.message
                ? data.message
                : "something went wrong please try again !",
              icon: "error",
              customClass: { confirmButton: "btn btn-primary" },
              buttonsStyling: !1,
            });
          });
      }
    });
  });

  $(document).on("click", ".call-model", function (e) {
    e.preventDefault();
    // return false;
    var el = $(this);
    var url = el.data("url");
    var target = el.data("target-modal");

    $.ajax({
      type: "GET",
      url: url,
    })
      .always(function () {
        $("#load-modal").html(" ");
      })
      .done(function (res) {
        $("#load-modal").html(res.html);
        $(target).modal("toggle");
      });
  });

  $(document).on("click", ".hard-delete-confrim", function (e) {
    e.preventDefault();

    var el = $(this);
    var url = el.attr("href");
    var id = el.data("id");
    var refresh = el.closest("table");
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: !0,
      confirmButtonText: "Yes, delete it!",
      customClass: {
        confirmButton: "btn btn-primary",
        cancelButton: "btn btn-outline-danger ml-1",
      },
      buttonsStyling: !1,
    }).then((result) => {
      if (result.value) {
        //showLoader();
        $.ajax({
          type: "POST",
          url: url,
          cache: false,
          data: {
            id: id,
            _method: "DELETE",
          },
        })
          .always(function (respons) {
            //stopLoader();

            $(refresh).DataTable().ajax.reload();
          })
          .done(function (respons) {
            Swal.fire({
              title: "Success",
              text: respons.message,
              icon: "success",
              customClass: { confirmButton: "btn btn-primary" },
              buttonsStyling: !1,
            });
          })
          .fail(function (respons) {
            console.log(respons);
            var data = respons.responseJSON;
            if (respons.responseJSON.errormessage) {
              data.message =
                "This data is use in other modules so you can’t delete";
            }
            if (respons.responseJSON.catgeorymessage) {
              data.message = "This data is use in parent so you can’t delete";
            }
            Swal.fire({
              title: "Error",
              text: data.message
                ? data.message
                : "something went wrong please try again !",
              icon: "error",
              customClass: { confirmButton: "btn btn-primary" },
              buttonsStyling: !1,
            });
          });
      }
    });
  });
});
