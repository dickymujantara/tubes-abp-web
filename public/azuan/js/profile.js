$(document).ready(function () {
    loadProfile()
});

function loadProfile() {
    $.ajax({
        type: "POST",
        url: urlUserProfile,
        data: {_token : token},
        success: function (response) {
            $.each(response, function (key, value) { 
                $("#" + key).val(value);
            });
            $("#is_active").val(response.is_active === 1 ? "Active" : "Inactive");
            $("#photo-profile").attr({"src" : "data:image/jpeg;base64," + response.path_photo});
        }
    });
}

function clickSelectPhoto() {
    $("#input-image").click();
}

$("#input-image").change(function (e) { 
    // $("#view-image").attr({"src" : $("#input-image").val()});
    console.log($("#input-image")[0].files[0]);

    let getImage = null
    let file = $("#input-image")[0].files[0]
    let reader = new FileReader()
    
    reader.onload = function() {
        getImage = this.result
        $('#zoom-view-image').zoom();
    }

    reader.onloadend = function() {
        $("#view-image").attr({"src" : getImage});
    }

    reader.readAsDataURL(file);

    console.log(reader);
});

function closeImage(){
    $('#zoom-view-image').trigger('zoom.destroy');
    $("#view-image").attr({"src" : ""});
}