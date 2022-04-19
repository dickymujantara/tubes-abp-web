var idUser = ""
$(document).ready(function () {
    loadData()
});

function detail(id){
    $.ajax({
        type: "GET",
        url: urlDetail,
        data: {id : id},
        success: function (response) {
            idUser = id
            $("#id-detail").text(response.data.id);            
            $("#name-detail").text(response.data.name);            
            $("#email-detail").text(response.data.email);            
            $("#username-detail").text(response.data.username);            
            $("#address-detail").text(response.data.address);            
            $("#status-detail").val(response.data.has_verified_email.toString());            
        }
    });
}

function update(){
    let status = $("#status-detail").val();
    $.ajax({
        type: "POST",
        url: urlUpdate,
        data: {id : idUser, status : status, _token : token},
        success: function (response) {
            idUser = ""
            alert("Update Status Berhasil!")
            loadData()
        }
    });
}

function loadData() {
    
    if (table != null) {
        table.destroy()
    }

    table = $('#table-users').DataTable({
        "dom": "<'row justify-content-between '<'col-md-6'l><'col-md-6 text-right'i>> <'row'<'col-12'tr>> <'row '<'col-md-12 text-right'p>>",
        "deferRender": false,
        "paging" : true,
        "pageLength": 10,
        "order": [[0, "desc"]],
        "autoWidth": false, // disable twice rendered
        "pagingType": "full_numbers",            
        "language":{"paginate": { first: '<span class="fa fa-angle-double-left font-lg"></span>', previous: '<span class="fa fa-angle-left font-lg"></span>', next: '<span class="fa fa-angle-right font-lg"></span>', last: '<span class="fa fa-angle-double-right font-lg"></span>' }},
        "ajax":{ url:urlList, type:"GET", error: function(err) { alert('failed load data'); loadData(); }},
        "columns": [
            { name: '', data: null, render: function (val, type, data, meta)
                {
                    return '' ;
                }
            },
            { name: 'username', data: 'username', render: function (val, type, data, meta)
                {
                    return val ? "<h6>" + val  + "</h6>" : "-";
                }
            },
            { name: 'name', data: 'name', render: function (val, type, data, meta)
                {
                    return val ? "<h6>" + val  + "</h6>" : "-";
                }
            },
            { name: 'email', data: 'email', render: function (val, type, data, meta)
                {
                    return val ? "<h6>" + val  + "</h6>": "-";
                }
            },
            { name: 'address', data: 'address', render: function (val, type, data, meta)
                {
                    return val ? "<h6>" + val  + "</h6>": "-";
                }
            },
            { name: 'has_verified_email', data: 'has_verified_email', render: function (val, type, data, meta)
                {
                    let status = ""

                    switch (val) {
                        case 0:
                            status = "PENDING"
                            break;
                        case 1:
                            status = "PROCESS"
                            break;   
                        case 2:
                            status = "SUCCESS"
                            break;
                        case 3:
                            status = "FAILED"
                            break;
                        default:
                            break;
                    }
                    
                    return status ? "<h6>" + status + "</h6>": "-";
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
            { name: 'id', data: 'id', render: function (val, type, data, meta)
                {
                    return '<div class="btn-group btn-group-sm"><a class="btn btn-circle btn-info btn-xs" data-toggle="modal" data-target="#modal-users" data-toggle="modal" href="#modal-project" title="Detail" href="javascript:void(0)" onclick=\"detail(\''+ val +'\')"><i class="fa fa-eye" aria-hidden="true"></i></a></div>'
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
