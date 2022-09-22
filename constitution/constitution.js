"use strict";

const popup = document.querySelectorAll(".popup");
const content = document.querySelectorAll(".analysis");
for (let i = 0; i < popup.length; i++) {
  popup[i].addEventListener("click", function () {
    content[i].classList.toggle("show-analysis");
  });
}

let coll = document.getElementsByClassName("collapsible");
let i;
for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    let content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    } 
  });
}