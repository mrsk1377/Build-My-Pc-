// scrollable content
let counter = 1;

function increment() {
  document.getElementById('r' + counter).checked = true;
  counter++;
  if (counter > 5) {
    counter = 1;
  }
}

let time_interval = setInterval(increment, 3000);

function change_counter(value) {
  counter = value;
}

// Scroll animation handler
function handleScrollAnimations() {
  const elements = document.querySelectorAll('.animate-on-scroll, .animate-card');
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          entry.target.classList.add('visible');
        }, index * 200);
      }
    });
  }, {
    threshold: 0.1,
    rootMargin: '50px'
  });

  elements.forEach(element => observer.observe(element));
}

// Enhanced parallax effect
function handleParallax() {
  const parallaxElements = document.querySelectorAll('.parallax-bg');
  
  window.addEventListener('scroll', () => {
    requestAnimationFrame(() => {
      const scrolled = window.pageYOffset;
      parallaxElements.forEach(element => {
        const speed = 0.5;
        const yPos = -(scrolled * speed);
        element.style.transform = `translate3d(0, ${yPos}px, 0)`;
      });
    });
  });
}

// Card animation handler
function handleCardAnimations() {
  const cards = document.querySelectorAll('.prebuilt-card');
  
  cards.forEach((card, index) => {
    // Add initial state
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    
    // Add delay based on index
    setTimeout(() => {
      card.style.transition = 'all 0.6s ease-out';
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, 500 + (index * 200));
  });
}

// Quick view modal handler
function initializeQuickView() {
  const quickViewButtons = document.querySelectorAll('.quick-view');
  
  quickViewButtons.forEach(button => {
    button.addEventListener('click', (e) => {
      const card = e.target.closest('.prebuilt-card');
      // Add your quick view logic here
      console.log('Quick view clicked for:', card.querySelector('h3').textContent);
    });
  });
}

// Initialize animations
document.addEventListener('DOMContentLoaded', () => {
  handleScrollAnimations();
  handleParallax();
  handleCardAnimations();
  initializeQuickView();
  
  // Handle image loading
  const images = document.querySelectorAll('img');
  images.forEach(img => {
    img.addEventListener('error', function() {
      this.src = 'images/placeholder.jpg'; // Add a placeholder image
    });
  });
  
  // Refresh animations on resize
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      handleScrollAnimations();
    }, 250);
  });
});

// Add smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    document.querySelector(this.getAttribute('href')).scrollIntoView({
      behavior: 'smooth'
    });
  });
});
