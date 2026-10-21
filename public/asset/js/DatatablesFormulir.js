let url,
  tdu = $("#tformulir").DataTable({
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    pageLength: 50,
    columnDefs: [{ searcable: !1, orderable: !1, targets: 0 }],
    order: [[0, "desc"]],
    ajax: {
      url: dataFormulir,
      dataSrc: "data",
    },
    columnDefs: [
      {
        width: "30px",
        title: "No",
        targets: [0],
      },
      {
        width: "50px",
        title: "Nama Siswa",
        targets: [1],
      },
      {
        width: "200px",
        title: "Alamat",
        targets: [2],
      },
      {
        width: "100px",
        title: "Telp",
        targets: [3],
      },
      {
        width: "50px",
        title: "Tanggal",
        targets: [4],
      },
      {
        width: "20px",
        title: "Nama Orang Tua",
        targets: [5],
      },
      {
        width: "10px",
        title: "rp",
        render: $.fn.dataTable.render.number(".", ",", 0, ""),
        targets: [6],
      },
      {
        width: "100px",
        title: "Keterangan",
        targets: [7],
      },
      {
        width: "100px",
        title: "id",
        targets: [8],
      },
      {
        width: "100px",
        title: "Bukti Transfer",
        targets: [9],
      },
    ],
    columns: [
      { data: "no" },
      { data: "nama_siswa" },
      { data: "alamat" },
      { data: "telp" },
      { data: "tanggal" },
      { data: "nama_ortu" },
      { data: "rp" },
      { data: "keterangan" },
      { data: "no" },
      {
        data: "foto",
        render: function (data, type, row) {
          return '<img width=200 src="' + imgFolder + "/" + data + '">';
        },
      },
      {
        data: null,
        title: "Command",
        render: function (data, type, row, meta) {
          return (
            '<button type="button" class="btn btn-primary" onclick="edit(' +
            data["no"] +
            ')"><i class="fas fa-pencil-alt" title="Edit Data"></i></button>' +
            '<button type="button" class="btn btn-danger" onclick="remove(' +
            data["no"] +
            ')"><i class="fas fa-trash" title="Delete Data"></i></button>'
          );
        },
      },
    ],

    //"destroy": true,
  });
