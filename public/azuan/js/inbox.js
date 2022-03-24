let table = null

$(document).ready(function () {
    loadData()
});

function loadData() {
    if (table != null) {
        table.destroy()
    }

    table = $('#table-inbox').DataTable({
        "dom": "<'row justify-content-between '<'col-md-6'l><'col-md-6 text-right'i>> <'row'<'col-12'tr>> <'row '<'col-md-12 text-right'p>>",
        "deferRender": false,
        "paging" : true,
        "pageLength": 10,
        "order": [[0, "desc"]],
        "autoWidth": false, // disable twice rendered
        "pagingType": "full_numbers",            
        "language":{"paginate": { first: '<span class="fa fa-angle-double-left font-lg"></span>', previous: '<span class="fa fa-angle-left font-lg"></span>', next: '<span class="fa fa-angle-right font-lg"></span>', last: '<span class="fa fa-angle-double-right font-lg"></span>' }},
        "ajax":{ url:urlInboxList, type:"POST", data:{_token:token}, error: function(err) { alert('failed load data'); loadData(); }},
        "columns": [
            { name: 'path_photo', data: 'path_photo', render: function (val, type, data, meta)
                {
                    return '<img src="data:image/png;base64,'+ data.path_photo +'" width="75" height="75" class="image">' ;
                }
            },
            { name: 'fullname', data: 'fullname', render: function (val, type, data, meta)
                {
                    let html = ""

                    html += '<h4 class="text-left text-info">'+ val +'</h4>'
                    html += '<p class="text-primary">'+ data.title +'</p>'
                    html += '<span>'+ data.message +'</span>'

                    return html ;
                }
            },
            { name: 'id', data: 'id', render: function (val, type, data, meta)
                {
                    let html = ""

                    html += '<button class="btn btn-info" title="Detail" data-toggle="modal" href="#modal-detail" onclick="detail('+ val +')"><i class="fa fa-eye"></i></button>'
                    html += '<button class="btn btn-danger" title="Delete" data-toggle="modal" href="#modal-delete" onclick="modalDelete('+ val +')"><i class="fa fa-trash"></i>'

                    return '<div class="btn-group">'+ html +'</button></div>' ;
                }
            },
        ], 
        columnDefs: [  
            { width: "7%", targets: 0 },          
            { width: "100%", targets: 1 },          
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
}

function detail(id) {
    $.ajax({
        type: "POST",
        url: urlInboxDetail,
        data: {_token : token, id : id},
        success: function (response) {
            $("#inbox-title").html(response.title);
            $("#inbox-message").html(response.message);
            console.log(response);
        }
    });
}

function modalDelete(id) {
    $("#id").val(id);
}