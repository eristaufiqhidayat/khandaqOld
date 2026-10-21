function addDSB() {
  (url = "add"),
    $(".modal-title").html("Add Data DSB"),
    $('.modal button[type="submit"]').html("Add");
}
function addDU() {
  (url = "add"),
    $(".modal-title").html("Add Data Daftar Ulang"),
    $('.modal button[type="submit"]').html("Add");
}
function addDataDSB() {
  if (cek_null_entriDSB() == true) {
    $.ajax({
      url: addDSBUrl,
      type: "get",
      data: $("#modalEntriDSB").serialize(),
      success: (a) => {
        Swal.fire("Sukses", "Sukses Menambahkan Data", "success"),
          reloadTable(1);
        //$("#ModalDSB").removeClass("in");
        $(".modal-backdrop").remove();
        //$("body").removeClass("modal-open");
        //$("body").css("padding-right", "");
        $("#ModalDSB").modal("toggle");
      },
      error: function (request, status, error) {
        alert(request.responseText);
      },
    });
  }
}
function addDataDU() {
  if (cek_null_entriDU() == true) {
    $.ajax({
      url: addDUUrl,
      type: "get",
      data: $("#modalEntriDU").serialize(),
      success: (a) => {
        Swal.fire("Sukses", "Sukses Menambahkan Data", "success"),
          reloadTable(2);
        //$("#ModalDSB").removeClass("in");
        $(".modal-backdrop").remove();
        //$("body").removeClass("modal-open");
        //$("body").css("padding-right", "");
        $("#ModalDU").modal("toggle");
      },
      error: function (request, status, error) {
        alert(request.responseText);
      },
    });
  }
}
function cek_null_entrikredit() {
  var x = document.forms["modalEntriKredit"]["tanggal"].value;
  var y = document.forms["modalEntriKredit"]["rp"].value;
  if (x == "") {
    alert("Tanggal harus diisi");
    return false;
  }
  if (y == "") {
    alert("rupiah harus diisi");
    return false;
  }
}

function cek_null_entridebet() {
  var x = document.forms["modalEntriDebet"]["tanggal"].value;
  var y = document.forms["modalEntriDebet"]["rp"].value;
  if (x == "") {
    alert("Tanggal harus diisi");
    return false;
  }
  if (y == "") {
    alert("rupiah harus diisi");
    return false;
  }
}

function cek_null_entriDSB() {
  var x = document.forms["modalEntriDSB"]["tanggal"].value;
  var y = document.forms["modalEntriDSB"]["rp"].value;
  if (x == "") {
    alert("Tanggal harus diisi");
    return false;
  }
  if (y == "") {
    alert("rupiah harus diisi");
    return false;
  }
  return true;
}

function cek_null_entriDU() {
  var x = document.forms["modalEntriDU"]["tanggal"].value;
  var y = document.forms["modalEntriDU"]["rp"].value;
  if (x == "") {
    alert("Tanggal harus diisi");
    return false;
  }
  if (y == "") {
    alert("rupiah harus diisi");
    return false;
  }
  return true;
}

function sppBulan() {
  var jml = 0;

  for (var i = 1; i <= 12; i++) {
    if (
      document.getElementsByName("sppbulan" + i)[0].type == "checkbox" &&
      document.getElementsByName("sppbulan" + i)[0].checked == true &&
      document.getElementsByName("sppbulan" + i)[0].disabled == false
    ) {
      jml =
        parseInt(jml) +
        parseInt(document.getElementsByName("sppbulan" + i)[0].value);
    }
  }
  jml = parseInt(document.getElementsByName("rp")[0].value) - parseInt(jml);
  return jml;
}

function cekangka(str) {
  return Boolean(str.match(/^[0-9]*$/));
}

function cekJml() {
  var jml = sppBulan();
  if (!document.forms["modalEntriKredit"]["tanggal"].value) {
    alert("Tanggal Harus diisi");
    return false;
  }
  if (!document.forms["modalEntriKredit"]["rp"].value) {
    alert("Rupiah Harus diisi");
    return false;
  }
  if (!cekangka(document.getElementsByName("rp")[0].value)) {
    alert("harus angka");
    return false;
  }
  if (jml < 0) {
    alert("Nilai Rupiah yang dimasukan kurang dari total SPP");
    return false;
  }
}

function reloadTable(b) {
  if (b == 1) {
    tdsb.ajax.reload();
  } else {
    tdu.ajax.reload();
  }
}
function remove(e, idsiswa, b) {
  var url = "";
  if (b == 1) {
    url = deleteDSBUrl;
    $();
  } else {
    url = deleteDUUrl;
  }
  swal({
    title: "Hapus Data ?",
    text: "yakin data ini akan di hapus",
    icon: "warning",
    buttons: ["No", "Yes"],
    dangerMode: true,
  }).then(function (isConfirm) {
    if (isConfirm) {
      $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        data: {
          no: e,
          id_siswa: idsiswa,
        },
        success: () => {
          swal("Deleted", "File Sudah Dihapus", "success");
          reloadTable(b);
        },
        error: function (request, status, error) {
          alert(request.responseText);
        },
      });
    } else {
      swal("Cancelled", "File tidak jadi dihapus", "error");
    }
  });
}

$(function () {
  $("#modalShow").DataTable({
    responsive: true,
    lengthChange: true,
    autoWidth: false,
    paging: true,
  });
  $("#example1")
    .DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      paging: true,
      buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
    })
    .buttons()
    .container()
    .appendTo("#example1_wrapper .col-md-6:eq(0)");
  $("#example2").DataTable({
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    //"destroy":true,
  });
  $("#tkes").DataTable({
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    //"destroy":true,
  });
  $("#tldr").DataTable({
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    //"destroy":true,
  });
  $("#tspp").DataTable({
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    //"destroy":true,
  });
});
$(function () {
  $("#checklistspp").hide();
  $("#savespp1").hide();
  $("#KKodeTransaksi").change(function () {
    if ($("#KKodeTransaksi").val() == "TKSPP") {
      $("#checklistspp").show();
      $("#savespp1").show();
      $("#savenonspp1").hide();
    } else {
      $("#checklistspp").hide();
      $("#savespp1").hide();
      $("#savenonspp1").show();
    }
  });
});

$("#modalEntriDSB").validate({
  errorElement: "span",
  errorPlacement: (a, e) => {
    a.addClass("invalid-feedback"), e.closest(".form-group").append(a);
  },
  submitHandler: () => {
    //addDataDSB();
    "edit" == url ? editData() : addDataDSB();
  },
});

$("#modalEntriDU").validate({
  errorElement: "span",
  errorPlacement: (a, e) => {
    a.addClass("invalid-feedback"), e.closest(".form-group").append(a);
  },
  submitHandler: () => {
    "edit" == url ? editData() : addDataDU();
  },
});
