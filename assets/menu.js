/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/menu.css';

// start the Stimulus application
import './bootstrap';

console.log('Hello Webpack Encore! Edit me in assets/menu.js');

window.onscroll = function() {myFunction()};

var header = document.getElementById("menus");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("is-sticky");
  } else {
    header.classList.remove("is-sticky");
  }
}

// function to set a given theme/color-scheme
function setTheme(themeName) {
  localStorage.setItem('theme', themeName);
  document.documentElement.className = themeName;
}
// function to toggle between light and dark theme
document.getElementById('slider').addEventListener('change', toggleTheme, false);

function toggleTheme() {
 if (localStorage.getItem('theme') === 'theme-dark'){
     setTheme('theme-light');
 } else {
     setTheme('theme-dark');
 }
}

// Immediately invoked function to set the theme on initial load
(function () {
 if (localStorage.getItem('theme') === 'theme-dark') {
     setTheme('theme-dark');
 } else {
   console.log('Jasne');
  document.getElementById("slider").checked = true;
     setTheme('theme-light');
     
 }
})();
