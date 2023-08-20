var currentSlide = 0;
var totalSlides = document.querySelectorAll('.slider > div').length;
var slider = document.querySelector('.slider');
var sliderButtons = document.querySelectorAll('.slider-button');

sliderButtons[currentSlide].classList.add('active');

for (var i = 0; i < sliderButtons.length; i++) {
  sliderButtons[i].addEventListener('click', function(event) {
    currentSlide = parseInt(event.target.getAttribute('data-index'));
    updateSlide();
  });
}

function updateSlide() {
  var slideWidth = slider.clientWidth;
  var newPosition = -currentSlide * slideWidth;
  slider.style.transform = `translateX(${newPosition}px)`;

  sliderButtons.forEach(function(button, index) {
    if (index === currentSlide) {
      button.classList.add('active');
    } else {
      button.classList.remove('active');
    }
  });
}