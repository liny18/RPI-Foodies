// https://developer.mozilla.org/en-US/docs/Web/API/FileReader/readAsDataURL - picture appears after input

$(window).ready(centerPost);
$(window).resize(centerPost);
$("body").keyup(validateText);
$(document).ready(postSubmit());

//centers the text on screen based on the width and height of the 
//boxes
function centerPost() {
    var h = $("#uploadPhoto").last().position();
    var offsetHeight = $("#postPhoto").height();
    var offsetWidth = $("#uploadPhoto").width();
    var align = $("#postPhoto");
    align.css("position", "relative");
    align.css("top", h.top / 2);
    align.css("left", offsetWidth / 2 - $("#postPhoto").width() / 2);
    var p = $("#photo").css("display");
}

function previewFile() {
    const preview = document.querySelector('img');
    const file = document.querySelector('input[type=file]').files[0];

    // make sure correct file type is given
    if(!("image/jpeg".includes(file.type) || "image/png".includes(file.type))) {
        alert("Please enter a jpg or a png file type");
        return false
    }

    const reader = new FileReader();

    reader.addEventListener("load", () => {
        // convert image file to base64 string
        preview.src = reader.result;
    }, false);

    if (file) {
        $(".imgCont").css("visibility", "visible");
        $("#postPhoto").css("display", "none");
        reader.readAsDataURL(file);
        makePicFit();
    }
}

//finds the dimenesions of the photo and scales it to the
//dimensions we want
function makePicFit() {
    $(".imgCont").css("overflow", "hidden");
    var width = $(".photo").width();
    var height = $(".photo").height();
    if (height - width < 0) {
        if (width > 560) {
            var dif = width - 560;
            width -= dif;
            height -= dif;
        } else {
            var dif = 560 - width;
            width += dif;
            height += dif;
        }
    } else {
        if (height > 560) {
            var dif = height - 560;
            width -= dif;
            height -= dif;
        } else {
            var dif = 560 - height;
            width += dif;
            height += dif;
        }
    }
    $(".photo").css("width", width + 'px');
    $(".photo").css("height", height + 'px');
}


//if text is valid and there is a photo, allow submit button to appear
function validateText() {
    if ($(".imgCont").css("visibility") != "hidden") {
        if ($("#Caption").val() != null && $("#floatLocation").val() != null) {
            $("#postButton").removeAttr("disabled");
        }
    }
}


//when submited say submitted go to hompage
function postSubmit() {
    $(document).on('submit', '#postText', function () {
        alert("Successful Post")
        return false;
    });
}