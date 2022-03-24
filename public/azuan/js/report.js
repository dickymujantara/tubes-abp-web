function loadData() {
    let startDate = $("#start-date").val();
    let endDate = $("#end-date").val();

    if (table != null) {
        table.destroy()
    }

    table = $('#table-rfp').DataTable({
        "dom": "<'row justify-content-between '<'col-md-6'l><'col-md-6 text-right'i>> <'row'<'col-12'tr>> <'row '<'col-md-12 text-right'p>>",
        "deferRender": false,
        "paging" : true,
        "pageLength": 10,
        "order": [[0, "desc"]],
        "autoWidth": false, // disable twice rendered
        "pagingType": "full_numbers",            
        "language":{"paginate": { first: '<span class="fa fa-angle-double-left font-lg"></span>', previous: '<span class="fa fa-angle-left font-lg"></span>', next: '<span class="fa fa-angle-right font-lg"></span>', last: '<span class="fa fa-angle-double-right font-lg"></span>' }},
        "ajax":{ url:urlList, type:"POST", data:{_token:token, startDate : startDate, endDate : endDate}, error: function(err) { alert('failed load data'); loadData(); }},
        "columns": [
            { name: '', data: null, render: function (val, type, data, meta)
                {
                    return '' ;
                }
            },
            { name: 'fullname', data: 'fullname', render: function (val, type, data, meta)
                {
                    return val ? "<h6>" + val  + "</h6>" : "-";
                }
            },
            { name: 'project_name', data: 'project_name', render: function (val, type, data, meta)
                {
                    return val ? "<h6>" + val  + "</h6>": "-";
                }
            },
            { name: 'headline', data: 'headline', render: function (val, type, data, meta)
                {
                    return val ? "<h6>" + val  + "</h6>": "-";
                }
            },
            { name: 'type', data: 'type', render: function (val, type, data, meta)
                {
                    let value = ""

                    switch (val) {
                        case 1:
                            value = "RFP"
                            break;
                        case 2:
                            value = "Claim"
                        case 3:
                            value = "Cashbond"
                        default:
                            break;
                    }

                    return val ? "<h6>" + value  + "</h6>": "-";
                }
            },
            { name: 'total_amount', data: 'total_amount', render: function (val, type, data, meta)
                {
                    return val ? "<h6>Rp." + val  + "</h6>": "-";
                }
            },
            { name: 'description', data: 'description', render: function (val, type, data, meta)
                {
                    return val ? "<h6>" + val  + "</h6>": "-";
                }
            },
            { name: 'status', data: 'status', render: function (val, type, data, meta)
                {
                    let tag = ""

                    switch (val) {
                        case 1:
                            tag = "<span class='badge badge-secondary'>Waiting list</span>"
                            break;
                        case 2:
                            tag = "<span class='badge badge-info'>Approved By Manager</span>"
                            break;
                        case 3:
                            tag = "<span class='badge badge-info'>Approved By Admin</span>"
                            break;
                        case 4:
                            tag = "<span class='badge badge-success'>Transferred</span>"
                            break;
                        case 5:
                            tag = "<span class='badge badge-danger'>Rejected</span>"
                            break;
                        default:
                            tag = "<span class='badge badge-danger'>Rejected</span>"
                            break;
                    }

                    return val ? tag : "-";
                }
            },
            { name: 'created_at', data: 'created_at', render: function (val, type, data, meta)
                {
                    let d = new Date(val)
                    let date = ('0' + d.getDate()).slice(-2) + "-" + ("0" + (d.getMonth()+1)).slice(-2) + "-" + d.getFullYear()
                    let time = ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2)

                    return val ? "<h6>" + date + " " + time  + "</h6>": "-";
                }
            },
            { name: 'updated_at', data: 'updated_at', render: function (val, type, data, meta)
                {
                    let d = new Date(val)
                    let date = ('0' + d.getDate()).slice(-2) + "-" + ("0" + (d.getMonth()+1)).slice(-2) + "-" + d.getFullYear()
                    let time = ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2)

                    return val ? "<h6>" + date + " " + time  + "</h6>": "-";
                }
            },
        ], 
        columnDefs: [            
            {
                "targets": '_all',
                "defaultContent" : "-",
                "createdCell": function(td, cellData, rowData, row, col)
                {
                    $(td).addClass('py-1').attr('style', 'line-height:1');
                }
            },
        ],
    
    });

    table.on('draw.dt', function () {
        var info = table.page.info();
        table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + info.start;
        });
    });
}