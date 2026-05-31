document.addEventListener(
  'DOMContentLoaded',
  () => {

    const sections =
      document.querySelectorAll(
        '[data-publications]'
      );

    sections.forEach(section => {

      const grid =
        section.querySelector(
          '[data-publication-grid]'
        );

      const sliderContainer =
        section.querySelector(
          '.lecturer-publications__slider'
        );

      const tabs =
        section.querySelectorAll(
          '.filter-list.segmented .filter-btn'
        );

      const cards =
        Array.from(
          grid.querySelectorAll(
            '.publication-card'
          )
        );

      /*
      ========================================
      SORTING & DYNAMIC BADGE TOGGLE
      ========================================
      */

      const sortCards = type => {

        const sorted =
          [...cards];

        if (type === 'citations') {

          sorted.sort(
            (a, b) =>
              Number(
                b.dataset.citations
              )
              -
              Number(
                a.dataset.citations
              )
          );

        }

        if (type === 'latest') {

          sorted.sort(
            (a, b) =>
              Number(
                b.dataset.year
              )
              -
              Number(
                a.dataset.year
              )
          );

        }

        if (type === 'oldest') {

          sorted.sort(
            (a, b) =>
              Number(
                a.dataset.year
              )
              -
              Number(
                b.dataset.year
              )
          );

        }

        // Hide badges for 'latest' or 'oldest', show them for 'citations'
        const hideCitationsBadges = (type === 'latest' || type === 'oldest');
        
        cards.forEach(card => {
          const highlightBadge = card.querySelector('.badge--section');
          const neutralBadge = card.querySelector('.publication-card__badge--neutral');
          
          if (hideCitationsBadges) {
            if (highlightBadge) highlightBadge.style.display = 'none';
            if (neutralBadge) neutralBadge.style.display = 'none';
          } else {
            if (highlightBadge) highlightBadge.style.display = 'inline-flex';
            if (neutralBadge) neutralBadge.style.display = 'inline-flex';
          }
        });

        grid.innerHTML = '';

        sorted.forEach(card => {
          grid.appendChild(card);
        });

      };

      tabs.forEach(tab => {

        tab.addEventListener(
          'click',
          () => {

            tabs.forEach(t =>
              t.classList.remove(
                'active'
              )
            );

            tab.classList.add(
              'active'
            );

            sortCards(
              tab.dataset.sort
            );

          }
        );

      });

      sortCards('citations');

      /*
      ========================================
      SLIDER (SCROLLING THE CONTAINER)
      ========================================
      */

      const prev =
        section.querySelector(
          '[data-publication-prev]'
        );

      const next =
        section.querySelector(
          '[data-publication-next]'
        );

      // Card width (350px) + Gap (24px) = 374px
      const scrollAmount = 374;

      next?.addEventListener(
        'click',
        () => {

          sliderContainer?.scrollBy({

            left:
              scrollAmount,

            behavior:
              'smooth',

          });

        }
      );

      prev?.addEventListener(
        'click',
        () => {

          sliderContainer?.scrollBy({

            left:
              -scrollAmount,

            behavior:
              'smooth',

          });

        }
      );

    });

  }
);