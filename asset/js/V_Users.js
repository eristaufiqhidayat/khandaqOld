function add() {
  (url = "add"),
    $(".modal-title").html("Add Data User"),
    $('.modal button[type="submit"]').html("Add");
}
function addData() {
  $.ajax({
    url: addUrl,
    type: "post",
    data: $("#form").serialize(),
    success: (a) => {
      $(".modal").modal("hide"),
        Swal.fire("Sukses", "Sukses Menambahkan Data", "success"),
        reloadTable();
      $(".modal-backdrop").remove();
      $("#modal").modal("toggle");
    },
    error: function (request, status, error) {
      alert(status.responseText);
      alert("Password tidak sama");
    },
  });
}
function remove(e) {
  swal({
    title: "Hapus Data User ?",
    text: "yakin data ini akan di hapus",
    icon: "warning",
    buttons: ["No", "Yes"],
    dangerMode: true,
  }).then(function (isConfirm) {
    if (isConfirm) {
      $.ajax({
        url: deleteUrl,
        type: "post",
        dataType: "JSON",
        data: {
          id: e,
        },
        success: () => {
          swal("Deleted", "File Sudah Dihapus", "success");
          reloadTable();
        },
        error: function (request, status, error) {
          alert(request.responseText);
          swal("Deleted", "File Sudah Dihapus", "success");
          reloadTable();
          //alert(id);
        },
      });
    } else {
      swal("Cancelled", "File tidak jadi dihapus", "error");
    }
  });
}
function reloadTable() {
  tdu.ajax.reload();
}
function edit(a) {
  $.ajax({
    url: editFormUrl,
    type: "post",
    dataType: "json",
    data: { user_id: a },
    success: (a) => {
      $('[name="username"]').val(a.username),
        $('[name="email"]').val(a.email),
        $('[name="user_id"]').val(a.id),
        //$('#group option[value="' + a.group_id + '"]').prop("selected", true),
        //$("#group").val(a.group_id).attr("selected", "selected"),
        $('[name="group"]').append(
          `<option value='${a.group_id}'>${a.description}</option>`
        ),
        $(".modal").modal("show"),
        $(".modal-title").html("Edit Data"),
        $('.modal button[type="submit"]').html("Edit"),
        (url = "edit");
      $('#group option[value="' + a.group_id + '"]').prop("selected", true);
    },
    error: (a) => {
      console.log(a);
    },
  });
}
function editData() {
  swal({
    title: "Edit Data User ?",
    text: "yakin data ini akan di Edit",
    icon: "alert",
    buttons: ["No", "Yes"],
    dangerMode: true,
  }).then(function (isConfirm) {
    if (isConfirm) {
      $.ajax({
        url: editUrl,
        type: "post",
        dataType: "JSON",
        data: $("#form").serialize(),
        success: () => {
          $(".modal").modal("hide"),
            Swal.fire("Sukses", "Sukses Edit Data", "success"),
            reloadTable();
          $(".modal-backdrop").remove();
          $("#modal").modal("toggle");
        },
        error: function (request, status, error) {
          alert(request.responseText);
          alert(editUrl);
          //swal("Edited", "File Sudah Di edit", "success");
          //reloadTable();
          //alert(id);
        },
      });
    } else {
      swal("Cancelled", "File tidak jadi dihapus", "error");
    }
  });
}
tdu.on("order.dt search.dt", () => {
  tdu
    .column(0, { search: "applied", order: "applied" })
    .nodes()
    .each((a, e) => {
      a.innerHTML = e + 1;
    });
}),
  $("#form").validate({
    errorElement: "span",
    errorPlacement: (a, e) => {
      a.addClass("invalid-feedback"), e.closest(".form-group").append(a);
    },
    submitHandler: () => {
      "edit" == url ? editData() : addData();
    },
  }),
  $("#group").select2({
    placeholder: "Pilih Group User",
    ajax: {
      url: groupUsers,
      type: "post",
      dataType: "json",
      data: (a) => ({ group: a.term }),
      processResults: (a) => ({ results: a }),
      cache: !0,
    },
  }),
  $(".modal").on("hidden.bs.modal", () => {
    $("#form")[0].reset(), $("#form").validate().resetForm();
  });
