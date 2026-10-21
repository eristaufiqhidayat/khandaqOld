let url,
  tdu = $("#tusers").DataTable({
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    columnDefs: [{ searcable: !1, orderable: !1, targets: 0 }],
    order: [[1, "asc"]],
    ajax: {
      url: dataUsers,
      dataSrc: "data",
    },
    columnDefs: [
      {
        width: "30px",
        title: "No",
        targets: [0],
      },
      {
        width: "100px",
        title: "Nama",
        targets: [1],
      },
      {
        width: "30px",
        title: "Email",
        targets: [2],
      },
      {
        width: "100px",
        title: "Password_Hash",
        targets: [3],
      },
      {
        width: "50px",
        title: "ID User",
        render: $.fn.dataTable.render.number(".", ",", 0, ""),
        targets: [4],
      },
      {
        width: "20px",
        title: "Active",
        targets: [5],
      },
    ],
    columns: [
      { data: "id" },
      { data: "username" },
      { data: "email" },
      { data: "password_hash" },
      { data: "id" },
      { data: "active" },
      {
        data: null,
        title: "Command",
        render: function (data, type, row, meta) {
          return (
            '<button type="button" class="btn btn-primary" onclick="edit(' +
            data["id"] +
            ')"><i class="fas fa-pencil-alt" title="Edit Data"></i></button>' +
            '<button type="button" class="btn btn-danger" onclick="remove(' +
            data["id"] +
            ')"><i class="fas fa-trash" title="Delete Data"></i></button>'
          );
        },
      },
    ],

    //"destroy": true,
  });
