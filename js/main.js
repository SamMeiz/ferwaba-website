// Basic interactivity for nav and anchors
document.addEventListener('DOMContentLoaded', function(){
  var navToggle = document.getElementById('navToggle');
  var mainNav = document.getElementById('mainNav');
  if(navToggle && mainNav){
    navToggle.addEventListener('click', function(){
      mainNav.classList.toggle('open');
    });
  }
});


