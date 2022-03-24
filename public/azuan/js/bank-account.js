$(document).ready(function () {
    loadData()
});

function loadData() {
    
    if (table != null) {
        table.destroy()
    }

    table = $('#table-bank').DataTable({
        "dom": "<'row justify-content-between '<'col-md-6'l><'col-md-6 text-right'i>> <'row'<'col-12'tr>> <'row '<'col-md-12 text-right'p>>",
        "deferRender": false,
        "paging" : true,
        "pageLength": 10,
        "order": [[0, "desc"]],
        "autoWidth": false, // disable twice rendered
        "pagingType": "full_numbers",            
        "language":{"paginate": { first: '<span class="fa fa-angle-double-left font-lg"></span>', previous: '<span class="fa fa-angle-left font-lg"></span>', next: '<span class="fa fa-angle-right font-lg"></span>', last: '<span class="fa fa-angle-double-right font-lg"></span>' }},
        "ajax":{ url:urlBankAccountList, type:"POST", data:{_token:token}, error: function(err) { alert('failed load data'); loadData(); } },
        "columns": [
            { name: '', data: null, render: function (val, type, data, meta)
                {
                    return '' ;
                }
            },
            { name: 'bank_user_name', data: 'bank_user_name', render: function (val, type, data, meta)
                {
                    return val ? "<h6>" + val  + "</h6>" : "-";
                }
            },
            { name: 'bank_name', data: 'bank_name', render: function (val, type, data, meta)
                {
                    return val ? "<h6>" + val  + "</h6>": "-";
                }
            },
            { name: 'bank_number', data: 'bank_number', render: function (val, type, data, meta)
                {
                    return val ? "<h6>" + val  + "</h6>": "-";
                }
            },
            { name: 'created_at', data: 'created_at', render: function (val, type, data, meta)
                {
                    let d = new Date(val)
                    let date = d.getDate() + "-" + ("0" + d.getMonth()+1).slice(-2) + "-" + d.getFullYear()
                    let time = ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2)

                    return val ? "<h6>" + date + " " + time  + "</h6>": "-";
                }
            },
            { name: 'updated_at', data: 'updated_at', render: function (val, type, data, meta)
                {
                    let d = new Date(val)
                    let date = d.getDate() + "-" + ("0" + d.getMonth()+1).slice(-2) + "-" + d.getFullYear()
                    let time = ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2)

                    return val ? "<h6>" + date + " " + time  + "</h6>": "-";
                }
            },
            { name: 'is_active', data: 'is_active', render: function (val, type, data, meta)
                {
                    return val == 1 ? "<h6><i class='fa fa-check text-success'></i></h6>" : "<h6><i class='fa fa-times-circle text-danger'></i></h6>";
                }
            },
            { name: 'id', data: 'id', render: function (val, type, data, meta)
                {
                    if (role == "SUPERADMIN") {
                        return '<div class="btn-group btn-group-sm"><a class="btn btn-circle btn-success btn-xs" data-toggle="modal" href="#modal-bank" title="Edit" href="javascript:void(0)" onclick=\"editData(\''+ val +'\')"><i class="fa fa-pencil" aria-hidden="true"></i></a></div>'   
                    }else{
                        return ""
                    }
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

function clearData() {
    $("#id").val("");
    $("#modal-title").html("Add Bank Account");
    $("#bank_user_name").val("");
    $("#bank_number").val("");
    $("#bank_name").val("");
}

function editData(id) {
    $.ajax({
        type: "POST",
        url: urlBankAccountDetail,
        data: {_token : token, id : id},
        success: function (response) {
            $.each(response, function (key, value) { 
                $("#"+key).val(value);
            });
        }
    });
}
