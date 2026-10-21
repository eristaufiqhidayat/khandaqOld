function add() {
  (url = "add"),
    $(".modal-title").html("Add Data User"),
    $('.modal button[type="submit"]').html("Add");
}

function addData() {
  var formData = new FormData($("#form")[0]);
  $.ajax({
    url: addUrl,
    type: "post",
    data: formData,
    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    processData: false,
    //data: $("#form").serialize(),
    success: (a) => {
      $(".modal").modal("hide"),
        Swal.fire("Sukses", "Sukses Menambahkan Data", "success"),
        reloadTable();
      $(".modal-backdrop").remove();
      $("#modal").modal("toggle");
    },
    error: function (xhr, status, error) {
      console.log(xhr);
      alert(xhr.responseText || error || status);
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
          no: e,
        },
        success: () => {
          swal("Deleted", "File Sudah Dihapus", "success");
          reloadTable();
        },
        error: function (request, status, error) {
          alert(request.responseText);
          //swal("Deleted", "File Sudah Dihapus", "success");
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
    data: { no: a },
    success: (a) => {
      console.log(a);
      $('[name="no"]').val(a.no),
        $('[name="nama_siswa"]').val(a.nama_siswa),
        $('[name="alamat"]').val(a.foto),
        $('[name="telp"]').val(a.telp),
        $('[name="tanggal"]').val(a.tanggal),
        $('[name="rp"]').val(a.rp),
        $('[name="nama_ortu"]').val(a.nama_ortu),
        $('[name="bukti"]').attr('src', imgFolder + "/" + a.foto),
        $('[name="keterangan"]').val(a.keterangan),
        $(".modal").modal("show"),
        $(".modal-title").html("Edit Data"),
        $('.modal button[type="submit"]').html("Edit"),
        (url = "edit");
    },
    error: function (request, status, error) {
      alert(status.responseText);
    },
  });
}
function editData() {
  var formData = new FormData($("#form")[0]);
  swal({
    title: "Edit Data User ?",
    text: "yakin data ini akan di Edit",
    icon: "warning",
    buttons: ["No", "Yes"],
    dangerMode: true,
  }).then(function (isConfirm) {
    if (isConfirm) {
      $.ajax({
        url: editUrl,
        type: "post",
        dataType: "JSON",
        data: formData,
        mimeType: "multipart/form-data",
        contentType: false,
        cache: false,
        processData: false,
        //data: new FormData(this),
        //data: $("#form").serialize(),
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
      alert("error");
    },
    submitHandler: () => {
      "edit" == url ? editData() : addData();
    },
  }),
  $(".modal").on("hidden.bs.modal", () => {
    $("#form")[0].reset(), $("#form").validate().resetForm();
  });
