/* ========================================
   SLIDER
======================================== */

document.addEventListener('DOMContentLoaded', () => {

  const sliders =
    document.querySelectorAll(
      '.slider-container'
    );

  if (!sliders.length) return;

  sliders.forEach((slider) => {

    const track =
      slider.querySelector(
        '.slider-track'
      );

    const wrapper =
      slider.closest(
        '.slider-wrapper'
      );

    if (!track || !wrapper)
      return;

    const prevButton =
      wrapper.querySelector(
        '.slider-btn-prev'
      );

    const nextButton =
      wrapper.querySelector(
        '.slider-btn-next'
      );

    if (
      !prevButton ||
      !nextButton
    ) return;

    /* ========================================
       GET SCROLL AMOUNT
    ======================================== */

    const getScrollAmount = () => {

      const item =
        track.querySelector(
          '.slider-item'
        );

      if (!item) return 300;

      const gap = 24;

      return (
        item.offsetWidth + gap
      );

    };

    /* ========================================
       NEXT
    ======================================== */

    nextButton.addEventListener(
      'click',
      () => {

        track.scrollBy({

          left:
            getScrollAmount(),

          behavior:
            'smooth'

        });

      }
    );

    /* ========================================
       PREV
    ======================================== */

    prevButton.addEventListener(
      'click',
      () => {

        track.scrollBy({

          left:
            -getScrollAmount(),

          behavior:
            'smooth'

        });

      }
    );

  });

});