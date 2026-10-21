let tdsb = $("#tdsb").DataTable({
  paging: false,
  lengthChange: false,
  searching: false,
  ordering: false,
  info: false,
  autoWidth: false,
  responsive: true,
  //"destroy":true,
  ajax: {
    url: tdsbDatatables,
    dataSrc: "",
  },
  columnDefs: [
    {
      width: "100px",
      title: "Transaksi No",
      targets: [0],
    },
    {
      width: "100px",
      title: "ID Siswa",
      targets: [1],
    },
    {
      width: "100px",
      title: "Tahun Ajaran",
      targets: [2],
    },
    {
      width: "100px",
      title: "Tanggal",
      targets: [3],
    },
    {
      width: "50px",
      title: "Rp",
      render: $.fn.dataTable.render.number(".", ",", 0, ""),
      targets: [4],
    },
    {
      width: "100px",
      title: "Keterangan",
      targets: [5],
    },
    {
      width: "50px",
      title: "Bukti",
      targets: [6],
    },
  ],
  columns: [
    {
      data: "no",
    },
    {
      data: "id_siswa",
    },
    {
      data: "tahunajaran",
    },
    {
      data: "tanggal",
    },
    {
      data: "rp",
    },
    {
      data: "keterangan",
    },
    {
      data: "bukti",
    },

    {
      data: null,
      title: "Command",

      render: function (data, type, row, meta) {
        return (
          '<button type="button" class="btn btn-danger" onclick="remove(' +
          data["no"] +
          "," +
          data["id_siswa"] +
          ',1)"><i class="fas fa-trash" title="Delete Data"></i></button>'
        );
      },
    },
  ],
  //"destroy": true,
});

let tdu = $("#tdu").DataTable({
  paging: false,
  lengthChange: false,
  searching: false,
  ordering: false,
  info: false,
  autoWidth: false,
  responsive: true,
  //"destroy":true,
  ajax: {
    url: tduDatatables,
    dataSrc: "",
  },
  columnDefs: [
    {
      width: "100px",
      title: "Transaksi No",
      targets: [0],
    },
    {
      width: "100px",
      title: "ID Siswa",
      targets: [1],
    },
    {
      width: "100px",
      title: "Tahun Ajaran",
      targets: [2],
    },
    {
      width: "100px",
      title: "Tanggal",
      targets: [3],
    },
    {
      width: "50px",
      title: "Rp",
      render: $.fn.dataTable.render.number(".", ",", 0, ""),
      targets: [4],
    },
    {
      width: "100px",
      title: "Keterangan",
      targets: [5],
    },
    {
      width: "50px",
      title: "Jenis",
      targets: [6],
    },
  ],
  columns: [
    {
      data: "no",
    },
    {
      data: "id_siswa",
    },
    {
      data: "tahunajaran",
    },
    {
      data: "tanggal",
    },
    {
      data: "rp",
    },
    {
      data: "keterangan",
    },
    {
      data: "jenis",
    },

    {
      data: null,
      title: "Command",
      render: function (data, type, row, meta) {
        return (
          '<button type="button" class="btn btn-danger" onclick="remove(' +
          data["no"] +
          "," +
          data["id_siswa"] +
          ',2)"><i class="fas fa-trash" title="Delete Data"></i></button>'
        );
      },
    },
  ],
  //"destroy": true,
});
