

function validate(){
    let RCS = document.forms["myform"]["RCS"].value;
    let password = document.forms["myform"]["Password"].value;
    if(RCS == "" && password ==""){
        alert("You haven't enter anything")
        return false;
    }
    if(RCS == ""){
        alert("Please enter your RCS ID");
    }
    if(password == ""){
        alert("Please enter your password");
    }
}

function create(){
    window.location.href = "./create.html";
}