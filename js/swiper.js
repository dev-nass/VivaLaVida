/*
  - CREATE SEPARATE SWIPER INSTANCE FOR EACH ELEMENT WITH THE SAME CLASS.
*/

// Select all elements with the class .card-wrapper
const cardWrappers = document.querySelectorAll('.card-wrapper');

// Loop through each element and initialize a Swiper instance
cardWrappers.forEach((cardWrapper, index) => {
  new Swiper(cardWrapper, {
    speed: 400,
    spaceBetween: 20,

    // Navigation arrows (use dynamic selectors to ensure uniqueness for each swiper)
    navigation: {
      nextEl: `.swiper-button-next-${index}`,
      prevEl: `.swiper-button-prev-${index}`,
    },

    // Pagination
    pagination: {
      el: `.swiper-pagination-${index}`,
      clickable: true,
      dynamicBullets: true
    },

    breakpoints: {
      0: {
        slidesPerView: 1
      },

      768: {
        slidesPerView: 2
      },

      1024: {
        slidesPerView: 3
      }
    },

    stopOnLastSlide: true
  });
});
