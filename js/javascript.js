javascript.js
function O(i){ return typeof i == 'object' ? i : document.getElementById(i)};
function S(i){ return O(1).style};
function C(i){ return document.getElementsByClassName(i)};