// function to run a php script using ajax which increases the like counter
// or decreases the like counter by 1
function likeCounter(postID, userID, text) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText != -1) {
                text.innerHTML = '<i class="fa-regular fa-heart" ></i> ' + this.responseText + ' Likes';
            }
        }
    }
    xmlhttp.open("POST", "increaseLikes.php?postID=" + postID + "&userID=" + userID, true);
    xmlhttp.send();
}