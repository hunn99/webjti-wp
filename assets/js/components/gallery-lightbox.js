/* ========================================
   GALLERY LIGHTBOX
======================================== */

document.addEventListener('DOMContentLoaded', () => {

  const lightbox =
    document.getElementById(
      'gallery-lightbox'
    );

  if (!lightbox) return;

  const galleryItems =
    document.querySelectorAll(
      '.gallery-item'
    );

  if (!galleryItems.length)
    return;

  const imageElement =
    lightbox.querySelector(
      '#lightbox-img'
    );

  const closeButton =
    lightbox.querySelector(
      '.lightbox-close'
    );

  const previousButton =
    lightbox.querySelector(
      '.prev'
    );

  const nextButton =
    lightbox.querySelector(
      '.next'
    );

  const overlay =
    lightbox.querySelector(
      '.lightbox-overlay'
    );

  const counter =
    lightbox.querySelector(
      '#current-idx'
    );

  const images =
    [...galleryItems].map((item) =>
      item.dataset.full
    );

  let currentIndex = 0;

  /* ========================================
     UPDATE LIGHTBOX
  ======================================== */

  const updateLightbox = () => {

    imageElement.src =
      images[currentIndex];

    if (counter) {

      counter.textContent =
        currentIndex + 1;

    }

  };

  /* ========================================
     OPEN
  ======================================== */

  const openLightbox = (index) => {

    currentIndex = index;

    updateLightbox();

    lightbox.setAttribute(
      'aria-hidden',
      'false'
    );

    document.body.style.overflow =
      'hidden';

  };

  /* ========================================
     CLOSE
  ======================================== */

  const closeLightbox = () => {

    lightbox.setAttribute(
      'aria-hidden',
      'true'
    );

    document.body.style.overflow =
      '';

  };

  /* ========================================
     NEXT
  ======================================== */

  const nextImage = () => {

    currentIndex =
      (currentIndex + 1)
      % images.length;

    updateLightbox();

  };

  /* ========================================
     PREVIOUS
  ======================================== */

  const previousImage = () => {

    currentIndex =
      (currentIndex - 1 + images.length)
      % images.length;

    updateLightbox();

  };

  /* ========================================
     TRIGGERS
  ======================================== */

  galleryItems.forEach((item, index) => {

    item.addEventListener(
      'click',
      () => {

        openLightbox(index);

      }
    );

  });

  /* ========================================
     CONTROLS
  ======================================== */

  closeButton?.addEventListener(
    'click',
    closeLightbox
  );

  overlay?.addEventListener(
    'click',
    closeLightbox
  );

  nextButton?.addEventListener(
    'click',
    nextImage
  );

  previousButton?.addEventListener(
    'click',
    previousImage
  );

  /* ========================================
     KEYBOARD
  ======================================== */

  document.addEventListener(
    'keydown',
    (event) => {

      const isOpen =
        lightbox.getAttribute(
          'aria-hidden'
        ) === 'false';

      if (!isOpen) return;

      switch (event.key) {

        case 'Escape':
          closeLightbox();
          break;

        case 'ArrowRight':
          nextImage();
          break;

        case 'ArrowLeft':
          previousImage();
          break;

      }

    }
  );

});