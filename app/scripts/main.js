/**
 * Custom jQuery goes here
 */
jQuery(document).ready(function($) {
  console.info('test: GRC 2018 jQuery injection');
});

/**
 * Custom JavaScript goes here
 */

console.info('test: GRC 2018 JavaScript injection');

// SwiperSlider custom settings
var mySwiper = new Swiper('.swiper-container', {
    // Optional parameters
    // direction: 'vertical',
  direction: 'horizontal',
  loop: true,

    // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },

    // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

    // And if we need scrollbar
  scrollbar: {
    el: '.swiper-scrollbar',
  },
})
// end SwiperSlider custom settings
