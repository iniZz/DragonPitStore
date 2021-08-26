/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

console.log('Hello Webpack Encore! Edit me in assets/app.js');

const slider = document.querySelector(".image-slider");
const nextBtn = document.querySelector(".next-btn");
const prevBtn = document.querySelector(".prev-btn");
const slides = document.querySelectorAll(".slide");
const slideIcons = document.querySelectorAll(".slide-icon");
const numberOfSlides = slides.length;
var slideNumber = 0;


//image slider next button
nextBtn.addEventListener("click", async () => {
  var currSlide;
  var currSlideIcons;
  slides.forEach((slide) => {

    if (slide.classList.contains("active")) {
      currSlide = slide;
    }
  });
  slideIcons.forEach((slideIcon) => {
    if (slideIcon.classList.contains("active")) {
      currSlideIcons = slideIcon;
    }

  });

  slideNumber++;

  if (slideNumber > (numberOfSlides - 1)) {
    slideNumber = 0;
  }

  slides[slideNumber].classList.add("active");
  slideIcons[slideNumber].classList.add("active");


  currSlide.classList.add("activeafter");
  currSlideIcons.classList.add("activeafter");
  currSlide.classList.remove("active");
  currSlideIcons.classList.remove("active");
  setTimeout(async function () {
    currSlide.classList.remove("activeafter");
    currSlideIcons.classList.remove("activeafter");
  }, 1500);

});

//image slider previous button
prevBtn.addEventListener("click", async () => {
  var currSlide;
  var currSlideIcons;
  slides.forEach((slide) => {

    if (slide.classList.contains("active")) {
      currSlide = slide;
    }
  });
  slideIcons.forEach((slideIcon) => {
    if (slideIcon.classList.contains("active")) {
      currSlideIcons = slideIcon;
    }

  });

  slideNumber--;

  if (slideNumber < 0) {
    slideNumber = numberOfSlides - 1;
  }

  slides[slideNumber].classList.add("active");
  slideIcons[slideNumber].classList.add("active");
  currSlide.classList.add("activeafter");
  currSlideIcons.classList.add("activeafter");
  currSlide.classList.remove("active");
  currSlideIcons.classList.remove("active");
  setTimeout(async function () {
    currSlide.classList.remove("activeafter");
    currSlideIcons.classList.remove("activeafter");
  }, 1500);
});

//image slider autoplay
var playSlider;

var repeater = () => {
  playSlider = setInterval(function () {
    var currSlide;
    var currSlideIcons;
    slides.forEach((slide) => {

      if (slide.classList.contains("active")) {
        currSlide = slide;
      }
    });
    slideIcons.forEach((slideIcon) => {
      if (slideIcon.classList.contains("active")) {
        currSlideIcons = slideIcon;
      }

    });

    slideNumber++;

    if (slideNumber > (numberOfSlides - 1)) {
      slideNumber = 0;
    }

    slides[slideNumber].classList.add("active");
    slideIcons[slideNumber].classList.add("active");

    currSlide.classList.add("activeafter");
    currSlideIcons.classList.add("activeafter");
    currSlide.classList.remove("active");
    currSlideIcons.classList.remove("active");
    setTimeout(async function () {
      currSlide.classList.remove("activeafter");
      currSlideIcons.classList.remove("activeafter");
    }, 1500);
  }, 10000);
}
repeater();

//stop the image slider autoplay on mouseover
slider.addEventListener("mouseover", () => {
  clearInterval(playSlider);
});

//start the image slider autoplay again on mouseout
slider.addEventListener("mouseout", () => {
  repeater();
});

function sleep(milliseconds) {
  const date = Date.now();
  let currentDate = null;
  do {
    currentDate = Date.now();
  } while (currentDate - date < milliseconds);
}


