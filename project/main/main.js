// function to run a php script using ajax which increases the like counter
// or decreases the like counter by 1
// https://www.w3schools.com/xml/ajax_database.asp
// w3 got me covered ngl
function likeCounter(postID, userID, text) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText != -1) {
                $(text).toggleClass("liked-this-post");
                text.innerHTML = '<i class="fa-regular fa-heart" ></i> ' + this.responseText + ' Likes';
            }
        }
    }
    xmlhttp.open("POST", "increaseLikes.php?postID=" + postID + "&userID=" + userID, true);
    xmlhttp.send();
}

function report(postID, userID, element){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText != -1) {
                element.classList.add("disabled");
            }
        }
    }
    xmlhttp.open("POST", "report.php?postID=" + postID + "&userID=" + userID, true);
    xmlhttp.send();    
}

// function to run a php script to add a comment to a post
function createComt(userID, postID, comment, element) {
    text = document.getElementById(comment).value;
    document.getElementById(comment).value = "";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText != -1) {
                document.getElementById(element).innerHTML += this.responseText;

            }
        }
    }
    xmlhttp.open("POST", "addComment.php?postID=" + postID + "&userID=" + userID + "&comment=" + text, true);
    xmlhttp.send();
}

// https://stackoverflow.com/questions/454202/creating-a-textarea-with-auto-resize
$("textarea").each(function () {
    this.setAttribute("style", "height:" + (Math.max(30, this.scrollHeight)) + "px;overflow-y:hidden;");
}).on("input", function () {
    this.style.height = 0;
    this.style.height = (this.scrollHeight) + "px";
});

// function to run a php script to increase likes for a comment
function likeCounterComment(commentID, userID, text) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText != -1) {
                $(text).toggleClass("liked-this-post");
            }
        }
    }
    xmlhttp.open("POST", "increaseCommentLikes.php?commentID=" + commentID + "&userID=" + userID, true);
    xmlhttp.send();
}


function loadMore(self) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText != -1) {
                self.remove();
                document.getElementById('PostContainer').innerHTML += this.responseText;
                document.getElementById('PostContainer').innerHTML += '<div class="load-more text-center"><button class="btn btn-primary" onclick="loadMore(this)">Load More</button></div>';
            }
            else {
                self.remove();
                document.getElementById('PostContainer').innerHTML += '<div class="text-center"><h2>No more posts to load!</h2></div>';
            }
        }
    }
    xmlhttp.open("POST", "loadMore.php", true);
    xmlhttp.send();
}
