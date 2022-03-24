let images = []
let dataRfp = []
let table = null
let totalAmount = 0

$(document).ready(function () {
    loadProject()
    loadBank()
    renderDate()
    loadDetail()
    loadListRfp()
    loadListImage()

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

function loadDetail() {
    $.ajax({
        type: "POST",
        url: urlRfpDetail,
        data: {_token : token, id : idRfp},
        success: function (response) {
            let opt = new Option(response.project_name, response.id_project,true, true)
            $("#id_project").append(opt).trigger('change');
            $("#type").val(response.type);
            $("#no_rfp").val(response.no_rfp);
            $("#headline").val(response.headline);
            $("#desc").val(response.description);
        }
    });
}

function renderDate() {
    $(".date").datepicker({
        format : "yyyy-mm-dd"
    })
}

function loadProject(){
    $.ajax({
        type: "POST",
        url: urlListProject,
        data: {_token : token},
        success: function (response) {
            let data = [{id:'', text : "- SELECT -"}]

            $.each(response.data, function (key, value) { 
                data.push({id : value.id, text : value.project_name})
            });

            $("#id_project").select2({
                data : data
            })

        }
    });
}

function loadBank(){
    $.ajax({
        type: "POST",
        url: urlListBank,
        data: {_token : token},
        success: function (response) {
            let data = [{id:'', text : "- SELECT -"}]

            $.each(response.data, function (key, value) { 
                data.push({id : value.id + "-" + value.bank_user_name + "-" + value.bank_number + "-" + value.bank_name, text : value.bank_user_name + " - " + value.bank_number + " (" + value.bank_name + ")"})
            });

            $("#account").select2({
                data : data
            })

        }
    });
}

function loadDataItem() {
    if (table != null) {
        table.destroy()
    }

    table = $('#table-item-rfp').DataTable({
        "dom": "<'row justify-content-between '<'col-md-6'l><'col-md-6 text-right'i>> <'row'<'col-12'tr>> <'row '<'col-md-12 text-right'p>>",
        "deferRender": false,
        "paging" : true,
        "pageLength": 10,
        "order": [[0, "desc"]],
        "autoWidth": false, // disable twice rendered
        "pagingType": "full_numbers",            
        "language":{"paginate": { first: '<span class="fa fa-angle-double-left font-lg"></span>', previous: '<span class="fa fa-angle-left font-lg"></span>', next: '<span class="fa fa-angle-right font-lg"></span>', last: '<span class="fa fa-angle-double-right font-lg"></span>' }},
        "data" : dataRfp,
        "columns": [
            { name: 'invoice_number', data: 'invoice_number', render: function (val, type, data, meta)
                {
                    return val ;
                }
            },
            { name: 'vendor', data: 'vendor', render: function (val, type, data, meta)
                {
                    return val ;
                }
            },
            { name: 'account', data: 'account', render: function (val, type, data, meta)
                {
                    return val ;
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
            { name: 'code_rfp', data: 'code_rfp', render: function (val, type, data, meta)
                {
                    return '<div class="btn-group" data-toggle="buttons"><button class="btn btn-info" onclick="deleteItem(\''+ val +'\')"><i class="fa fa-trash"></i></button></div>' 
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

function loadListRfp() {
    $.ajax({
        type: "POST",
        url: urlListItemRfp,
        data: {_token : token, id : idRfp},
        success: function (response) {
            dataRfp = []
            $.each(response.data, function (key, value) {
                console.log(value); 
                dataRfp.push({
                    id : value.id,
                    code_rfp : value.code_rfp,
                    invoice_number : value.invoice_number,
                    vendor : value.vendor_name,
                    id_bank : value.id_bank,
                    account : value.bank_number + " - " + value.bank_user_name + " (" + value.bank_name + ")",
                    amount : value.amount,
                    date_transaction : value.date_transaction,
                    due_date_transaction : value.due_date_transaction,
                    description : value.description,
                    status : "stored"
                })
                totalAmount += value.amount
            });
            loadDataItem()
        }
    });
}

function loadListImage() {
    $.ajax({
        type: "POST",
        url: urlListImage,
        data: {_token : token, id : idRfp},
        success: function (response) {
            $.each(response, function (key, value) { 
                images.push({id : value.id,src : value.path_photo, status : "stored"})
            });
            listImage()
        }
    });
}

function listImage(){
    let list = "<div class='row'>"
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

function addItem() {
    let inNumber = $("#invoice_number").val();
    let vendor = $("#vendor").val();
    let bank = $("#account").val().split("-");
    let amount = $("#amount").val();
    let date = $("#start-date").val();
    let dueDate = $("#due-date").val();
    let desc = $("#desc-list").val();

    let obj = {
        invoice_number : inNumber,
        code_rfp : generateCode(),
        vendor : vendor,
        id_bank : bank[0],
        account : bank[2] + " - " + bank[1] + " (" + bank[3] + ")",
        amount : amount,
        date_transaction : date,
        due_date_transaction : dueDate,
        description : desc,
        status : "temp"
    }

    totalAmount += parseInt(amount)

    dataRfp.push(obj)
    loadDataItem()
}

function encodeImage(element){
    var file = element.files[0];
 
    var reader = new FileReader();
 
      reader.onload = function() {
        getImage = this.result
      }

      reader.onloadend = function() {
        images.push({id :null, src : getImage, status : "temp"})
        listImage()
      }

      reader.readAsDataURL(file);
}

function submitRfp() {
    let project = $("#id_project").val();
    let type = $("#type").val();
    let noRfp = $("#no_rfp").val();
    let headline = $("#headline").val();
    let desc = $("#desc").val();

    if (dataRfp.length > 0 && images.length > 0) {
        let data = {
            id : idRfp,
            project : project,
            noRfp : noRfp,
            type : type,
            headline : headline,
            desc : desc,
            totalAmount : totalAmount,
            items : dataRfp,
            attachments : images
        }

        console.log(data);
    
        $.ajax({
            type: "POST",
            url: urlRfpUpdate,
            data: {_token : token, data: data},
            success: function (response) {
                console.log(response);
                alert("Update RFP Success!")
                // window.location.href = urlRfp
            },
            error : function(err) {
                console.log(err)
            }
        });
    }else{
        alert("Harap Di Isi Semua")
    }
}

function deleteItem(code) {
    let index = dataRfp.findIndex(x => x.code_rfp === code)
    
    totalAmount -= dataRfp[index].amount
    
    if(dataRfp[index].status == "stored"){
        $.ajax({
            type: "POST",
            url: urlRfpDeleteItem,
            data: {_token : token, id : dataRfp[index].id},
            success: function (response) {
                loadListRfp()
            }
        });
    }
    
    dataRfp.splice(index,1)
    loadDataItem()
}

function generateCode() {
    var result           = [];
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < 15; i++ ) {
      result.push(characters.charAt(Math.floor(Math.random() * charactersLength)));
    }
    return result.join('');
}