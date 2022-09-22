"use strict";

const popup = document.querySelectorAll(".popup");
const content = document.querySelectorAll(".analysis");
for (let i = 0; i < popup.length; i++) {
  popup[i].addEventListener("click", function () {
    content[i].classList.toggle("show-analysis");
  });
}