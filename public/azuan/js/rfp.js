let images = []

$(document).ready(function () {
    loadData()

    // start function for attachment

    // to stop command open file when drag file on html
    $("html").on("dragover",function(e){
        e.preventDefault();
        e.stopPropagation();
    });
    // to stop command open file when drop file on html
    $("html").on("drop",function(e){
        e.preventDefault();
        e.stopPropagation();
    });

    $("#container-upload").click(function() {
        $("#file").click()
    });

    // to stop command open file when drag file on div
    $("#container-upload").on("dragover",function(e){
        e.preventDefault();
        e.stopPropagation();
    });
    // to stop command open file when drop file on div
    $("#container-upload").on("drop",function(e){
        e.preventDefault();
        e.stopPropagation();
        // $("#container-upload").text("Uploading...");
        var file = e.originalEvent.dataTransfer;
        encodeImage(file)
    });
    //when user drag file and leave div container-upload
    $("#container-upload").on('dragleave', function(e){
        e.stopPropagation();
        e.preventDefault();
    });

    $("#file").change(function (e) { 
        var file = $('#file')[0];
        encodeImage(file)
    });

    // end function for attachment
});

function loadData() {
    
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
        "ajax":{ url:urlListRfp, type:"POST", data:{_token:token}, error: function(err) { alert('failed load data'); loadData(); }},
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
            { name: 'id', data: 'id', render: function (val, type, data, meta)
                {
                    let btn = ""

                    if (data.status == 1 && data.id_user == userId || data.status == 5 && data.id_user == userId) {
                        btn += '<a href="'+urlFormEdit+ val + '" class="btn btn-circle btn-info btn-xs" data-toggle="tooltip" title="Edit" href="javascript:void(0)" onclick=\"modalDeleteGroup(\''+ val +'\')\"><i class="fa fa-pencil" aria-hidden="true"></i></a>'
                    }

                    btn += '<a class="btn btn-circle btn-info btn-xs" data-toggle="modal" data-target="#modal-logs" data-toggle="tooltip" title="Logs" href="javascript:void(0)" onclick=\"getLogs(\''+ val +'\')\"><i class="fa fa-clock" aria-hidden="true"></i></a>'

                    return '<div class="btn-group btn-group-sm"><a class="btn btn-circle btn-info btn-xs" data-toggle="modal" data-target="#modal-detail" data-toggle="modal" href="#modal-project" title="Detail" href="javascript:void(0)" onclick=\"detail(\''+ val +'\')"><i class="fa fa-eye" aria-hidden="true"></i></a>'+ btn +'</div>'
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

function getLogs(id){
    if (tableLogs != null) {
        tableLogs.destroy()
    }

    tableLogs = $('#table-logs').DataTable({
        "dom": "<'row justify-content-between '<'col-md-6'l><'col-md-6 text-right'i>> <'row'<'col-12'tr>> <'row '<'col-md-12 text-right'p>>",
        "deferRender": false,
        "paging" : true,
        "pageLength": 10,
        "lengthChange": false,
        "bInfo" : false,
        "bSort" : false,
        "order": [[0, "desc"]],
        "autoWidth": false, // disable twice rendered
        "pagingType": "full_numbers",            
        "language":{"paginate": { first: '<span class="fa fa-angle-double-left font-lg"></span>', previous: '<span class="fa fa-angle-left font-lg"></span>', next: '<span class="fa fa-angle-right font-lg"></span>', last: '<span class="fa fa-angle-double-right font-lg"></span>' }},
        "ajax":{ url:urlLogsRfp, type:"POST", data:{_token:token, id : id}, error: function(err) { alert('failed load data'); loadData(); }},
        "columns": [
            { name: 'id', data: "id", render: function (val, type, data, meta)
                {
                    let d = new Date(data.created_at)
                    let date = ('0' + d.getDate()).slice(-2) + "-" + ("0" + (d.getMonth()+1)).slice(-2) + "-" + d.getFullYear()
                    let time = ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2)
                    let icon = ""
                    
                    switch (data.status) {
                        case 5:
                            icon = "fa fa-times-circle text-danger"
                            break;
                        default:
                            icon = "fa fa-check-circle text-success"
                            break;
                    }

                    return '<div class="card"><div class="card-body"><div class="row"><div class="col-6"><h6>'+ data.title +'</h6></div>' +
                            '<div class="col-6 text-right"><i class="'+ icon +'"></i></div>' +
                            '<div class="col-12"><h5>'+ data.message +'</h5></div>' + 
                            '<div class="col-12"><span class="text-secondary">'+ date+ ' ' + time +'</span></div></div></div></div>' ;
                }
            },
        ], 
        columnDefs: [            
            {
                "targets": '_all',
                "defaultContent" : "-",
            },
        ],
        "fnInitComplete": function(oSettings) {
            $("#table-logs thead").hide();
        }
    
    });
}

function detail(id) {
    $.ajax({
        type: "POST",
        url: urlDetailRfp,
        data: {_token : token, id : id},
        success: function (response) {
            $(".id-rfp-detail").val(response.id);
            $.each(response, function (key, val) { 
                let value = ""
                if (key == "type") {

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
                    
                    $("#text-"+key).text(value);

                }else if(key == "status"){
                    switch (val) {
                        case 1:
                            value = "<span class='badge badge-secondary'>Waiting list</span>"
                            break;
                        case 2:
                            value = "<span class='badge badge-info'>Approved By Manager</span>"
                            break;
                        case 3:
                            value = "<span class='badge badge-info'>Approved By Admin</span>"
                            break;
                        case 4:
                            value = "<span class='badge badge-success'>Transferred</span>"
                            break;
                        case 5:
                            value = "<span class='badge badge-danger'>Rejected</span>"
                            break;
                        default:
                            value = "<span class='badge badge-danger'>Rejected</span>"
                            break;
                    }

                    $("#text-"+key).html(value);

                }else{
                    $("#text-"+key).text(val);
                }

            });

            if (response.status == 3) {
                $("#field-upload").css('display','block');
            }else{
                $("#field-upload").css('display','none');
            }

            listItem(response.id)
            listImage(response.id)
        }
    });
}

function listItem(id) {
    if (tableItem != null) {
        tableItem.destroy()
    }

    tableItem = $('#table-item-rfp').DataTable({
        "dom": "<'row justify-content-between '<'col-md-6'l><'col-md-6 text-right'i>> <'row'<'col-12'tr>> <'row '<'col-md-12 text-right'p>>",
        "deferRender": false,
        "paging" : true,
        "pageLength": 10,
        "order": [[0, "desc"]],
        "autoWidth": false, // disable twice rendered
        "pagingType": "full_numbers",            
        "language":{"paginate": { first: '<span class="fa fa-angle-double-left font-lg"></span>', previous: '<span class="fa fa-angle-left font-lg"></span>', next: '<span class="fa fa-angle-right font-lg"></span>', last: '<span class="fa fa-angle-double-right font-lg"></span>' }},
        "ajax":{ url:urlDetailListRfp, type:"POST", data:{_token:token, id : id}, error: function(err) { alert('failed load data'); loadData(); }},
        "columns": [
            { name: 'invoice_number', data: 'invoice_number', render: function (val, type, data, meta)
                {
                    return val ;
                }
            },
            { name: 'vendor_name', data: 'vendor_name', render: function (val, type, data, meta)
                {
                    return val ;
                }
            },
            { name: 'bank_name', data: 'bank_name', render: function (val, type, data, meta)
                {
                    return data.bank_user_name + " - " + data.bank_number + "(" + data.bank_name + ")";
                }
            },
            { name: 'amount', data: 'amount', render: function (val, type, data, meta)
                {
                    return val ;
                }
            },
            { name: 'date_transaction', data: 'date_transaction', render: function (val, type, data, meta)
                {
                    return val ;
                }
            },
            { name: 'due_date_transaction', data: 'due_date_transaction', render: function (val, type, data, meta)
                {
                    return val ;
                }
            },
            { name: 'description', data: 'description', render: function (val, type, data, meta)
                {
                    return val ;
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

    tableItem.on('draw.dt', function () {
        var info = tableItem.page.info();
        tableItem.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + info.start;
        });
    });
}

function listImage(id) {
    $.ajax({
        type: "POST",
        url: urlDetailImageRfp,
        data: {_token : token, id : id},
        success: function (response) {
            let element = ""

            $.each(response, function (key, value) { 
                element += '<div class="col-3 mb-2"><img class="col-12" src="'+ value.path_photo +'"/></div>'
            });

            $("#list-image-detail").html(element);

        }
    });
}

function encodeImage(element){
    var file = element.files[0];
 
    var reader = new FileReader();
 
      reader.onload = function() {
        getImage = this.result
      }

      reader.onloadend = function() {
        images.push({src : getImage})
        showImages()
      }

      reader.readAsDataURL(file);
}

function showImages(){
    let list = "<div class='row'>"
    console.log(images);
    if (images.length != 0) {
        $("#gallery").css("display", "block");
        for (let i = 0; i < images.length; i++) {
            list += "<div class='col-lg-2 list-images' onclick=detailImg('"+ i +"')><img src='" + images[i].src +"' class='col-lg-12'></div>"
        }
        list += "</div>"

        $("#list-image").html(list);

    } else {
        $("#gallery").css("display", "none");
    }
    
}

function transfer() {
    let id = $(".id-rfp-detail").val();

    $.ajax({
        type: "POST",
        url: urlRfpTransfer,
        data: {_token : token, id : id, attachments : images},
        success: function (response) {
            console.log(response);
            alert("RFP was Transferred!")
            window.location.reload()
        }
    });
}