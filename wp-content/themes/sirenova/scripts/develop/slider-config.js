'use strict';

function initMainNewSlider() {
  $('#mainNewSlider').slick({
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [{
      breakpoint: 1200,
      settings: {
        slidesToShow: 3
      }
    }, {
      breakpoint: 768,
      settings: {
        slidesToShow: 2
      }
    }, {
      breakpoint: 576,
      settings: {
        slidesToShow: 1,
        // arrows: false
      }
    }]
  });
}

function checkSliderLength() {
  var sliderLength = $('#mainNewSlider').children().length;
  if (sliderLength > 4) {
    initMainNewSlider();
  }
}

$('#productSliderNavigation').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  asNavFor: '#productSliderSingle',
  dots: false,
  focusOnSelect: true,
  vertical: true,
  responsive: [{
    breakpoint: 576,
    settings: {
      slidesToShow: 3
    }
  }]
});
$('#productSliderSingle').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '#productSliderNavigation'
});

$('.modal').fancybox({
  afterLoad: function afterLoad() {
    $('#productSliderNavigationModal').slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      asNavFor: '#productSliderSingleModal',
      dots: false,
      focusOnSelect: true,
      vertical: true,
      responsive: [{
        breakpoint: 576,
        settings: {
          slidesToShow: 3
        }
      }]
    });
    $('#productSliderSingleModal').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '#productSliderNavigationModal'
    });
  }
});

$('[data-fancybox="productGallery"]').fancybox({
  buttons: [
    "close"
  ]
});

window.addEventListener('DOMContentLoaded', function () {
  checkSliderLength();
});
//# sourceMappingURL=slider-config.js.map
