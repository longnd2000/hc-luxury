(function ($) {
  'use strict';

  // jQuery 100%
  $(function () {
    $('html').addClass('js-ready');

    if (typeof $.fn.slick !== 'function') {
      return;
    }

    var $caseSliders = $('.cases-slider, .case-slider, [data-slider="cases"]');
    if ($caseSliders.length) {
      $caseSliders.slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: true,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 3500,
        infinite: true,
        responsive: [
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 2,
            },
          },
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 1,
            },
          },
        ],
      });
    }

    var $testimonialSlider = $('.testimonial-slider');
    if ($testimonialSlider.length) {
      $testimonialSlider.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        autoplay: false,
        infinite: true,
      });
    }

    if (typeof $.fn.matchHeight === 'function') {
      $('[data-mh]').matchHeight();
    }
  });
})(jQuery);
