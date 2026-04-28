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

    // LX Menu Widget Logic
    $(document).on('click', '.lx_menu_toggler', function(e) {
      e.preventDefault();
      $(this).closest('.lx_menu_container').addClass('is-open');
    });

    $(document).on('click', '.lx_menu_close, .lx_menu_backdrop', function(e) {
      e.preventDefault();
      $(this).closest('.lx_menu_container').removeClass('is-open');
    });

    $(document).on('click', '.lx_menu_container .menu-item-has-children > a', function(e) {
      if ($(window).width() < 1200) {
        e.preventDefault();
        var $parentLi = $(this).parent();
        $parentLi.toggleClass('is-active');
        $(this).siblings('.sub-menu').slideToggle(300);
      }
    });

    if (typeof $.fn.matchHeight === 'function') {
      $('[data-mh]').matchHeight();
    }

    // LX FAQs Accordion Logic
    $(document).on('click', '.lx_faq_header', function() {
      var $item = $(this).closest('.lx_faq_item');
      var $wrapper = $(this).siblings('.lx_faq_content_wrapper');
      
      if ($(this).attr('aria-expanded') === 'true') {
        $(this).attr('aria-expanded', 'false');
        $item.removeClass('is-active');
        $wrapper.slideUp(300);
      } else {
        // Close other items in the same accordion
        var $accordion = $(this).closest('.lx_faq_accordion');
        $accordion.find('.lx_faq_header[aria-expanded="true"]').attr('aria-expanded', 'false');
        $accordion.find('.lx_faq_item').removeClass('is-active');
        $accordion.find('.lx_faq_content_wrapper').slideUp(300);

        $(this).attr('aria-expanded', 'true');
        $item.addClass('is-active');
        $wrapper.slideDown(300);
      }
    });
  });
})(jQuery);
