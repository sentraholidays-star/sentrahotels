document.addEventListener('DOMContentLoaded', () => {
  // (Scroll-effect disabled, navbar is now fixed dark top navbar)

  // --- INITIALIZE SWIPER HERO CAROUSEL ---
  if (document.querySelector('.heroSwiper')) {
    const heroSwiper = new Swiper('.heroSwiper', {
      loop: true,
      effect: 'fade',
      fadeEffect: {
        crossFade: true
      },
      speed: 1000,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });
  }

  // --- INITIALIZE SWIPER PREFERRED HOTELS CAROUSEL ---
  if (document.querySelector('.preferredSwiper')) {
    const preferredSwiper = new Swiper('.preferredSwiper', {
      loop: true,
      speed: 800,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      spaceBetween: 24,
      breakpoints: {
        320: {
          slidesPerView: 3,
          spaceBetween: 16
        },
        768: {
          slidesPerView: 4,
          spaceBetween: 20
        },
        1024: {
          slidesPerView: 6,
          spaceBetween: 24
        }
      }
    });
  }

  // --- INITIALIZE SWIPER DESTINASI CAROUSEL ---
  if (document.querySelector('.destinationSwiper')) {
    const destinationSwiper = new Swiper('.destinationSwiper', {
      loop: true,
      speed: 800,
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
      },
      slidesPerView: 'auto',
      spaceBetween: 16,
      breakpoints: {
        768: { spaceBetween: 24 }
      }
    });
  }

  // --- HOTEL IMAGES SLIDER ---
  const sliderWrapper = document.getElementById('hotelSliderWrapper');
  const prevBtn = document.getElementById('sliderPrev');
  const nextBtn = document.getElementById('sliderNext');
  
  if (sliderWrapper) {
    const slides = Array.from(sliderWrapper.children);
    let currentIndex = 0;
    
    const updateSlider = () => {
      sliderWrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
    };
    
    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % slides.length;
        updateSlider();
      });
    }
    
    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        updateSlider();
      });
    }
  }

  // --- SUBMIT FORM REQUEST KE WHATSAPP ---
  const requestForm = document.getElementById('hotelRequest');
  if (requestForm) {
    requestForm.addEventListener('submit', (e) => {
      e.preventDefault();
      
      const name = requestForm.elements['name'].value;
      const segment = requestForm.elements['segment'].value;
      const destination = requestForm.elements['destination'].value;
      const dates = requestForm.elements['dates'].value;
      const notes = requestForm.elements['notes'].value || '-';
      
      const message = `Halo Sentra Hotels,\n\nSaya ingin memesan hotel luxury dengan detail:\n- *Nama:* ${name}\n- *Tipe Layanan:* ${segment}\n- *Destinasi:* ${destination}\n- *Tanggal:* ${dates}\n- *Catatan:* ${notes}`;
      const encodedText = encodeURIComponent(message);
      
      window.open(`https://wa.me/6287722389541?text=${encodedText}`, '_blank');
    });
  }

  // --- KODE FAQ ACCORDION ---
  const faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(item => {
    const trigger = item.querySelector('.faq-trigger');
    const content = item.querySelector('.faq-content');
    
    trigger.addEventListener('click', () => {
      const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
      
      // Tutup semua item FAQ lainnya
      faqItems.forEach(otherItem => {
        if (otherItem !== item) {
          otherItem.querySelector('.faq-trigger').setAttribute('aria-expanded', 'false');
          otherItem.querySelector('.faq-content').style.maxHeight = null;
        }
      });
      
      // Toggle status item yang diklik
      if (isExpanded) {
        trigger.setAttribute('aria-expanded', 'false');
        content.style.maxHeight = null;
      } else {
        trigger.setAttribute('aria-expanded', 'true');
        content.style.maxHeight = content.scrollHeight + 'px';
      }
    });
  });

  // --- WHATSAPP WIDGET TOGGLE LOGIC ---
  const waTriggerBtn = document.getElementById('waTriggerBtn');
  const waPopup = document.getElementById('waPopup');
  const waCloseBtn = document.getElementById('waCloseBtn');
  const waWidget = document.getElementById('waWidget');

  if (waTriggerBtn && waPopup) {
    const toggleWaPopup = (forceClose = null) => {
      const isExpanded = waTriggerBtn.getAttribute('aria-expanded') === 'true';
      const shouldOpen = forceClose !== null ? !forceClose : !isExpanded;

      if (shouldOpen) {
        waPopup.classList.add('is-active');
        waPopup.setAttribute('aria-hidden', 'false');
        waTriggerBtn.setAttribute('aria-expanded', 'true');
      } else {
        waPopup.classList.remove('is-active');
        waPopup.setAttribute('aria-hidden', 'true');
        waTriggerBtn.setAttribute('aria-expanded', 'false');
      }
    };

    // Toggle on trigger click
    waTriggerBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      toggleWaPopup();
    });

    // Close on close button click
    if (waCloseBtn) {
      waCloseBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleWaPopup(true); // Force close
      });
    }

    // Close on click outside the widget
    document.addEventListener('click', (e) => {
      const isClickInside = waWidget && waWidget.contains(e.target);
      if (!isClickInside) {
        toggleWaPopup(true); // Force close
      }
    });

    // Prevent closing when clicking inside the popup
    waPopup.addEventListener('click', (e) => {
      e.stopPropagation();
    });
  }

  // --- NAVBAR SCROLL EFFECT ---
  const header = document.querySelector('.site-header');
  if (header) {
    const handleScroll = () => {
      if (window.scrollY > 30) {
        header.setAttribute('data-scrolled', 'true');
      } else {
        header.setAttribute('data-scrolled', 'false');
      }
    };
    window.addEventListener('scroll', handleScroll);
    handleScroll();
  }

  // --- RESPONSIVE MOBILE MENU (Dipindahkan ke inline app.blade.php mengikuti Sentra Holidays) ---
});