// JavaScript for slider navigation
const btns = document.querySelectorAll('.nav-btn');
const slides = document.querySelectorAll('.video-slide');
let currentSlide = 0;

const sliderNav = function (manual) {
  btns.forEach((btn) => {
    btn.classList.remove('active');
  });

  slides.forEach((slide) => {
    slide.classList.remove('active');
  });

  btns[manual].classList.add('active');
  slides[manual].classList.add('active');
};

btns.forEach((btn, i) => {
  btn.addEventListener("click", () => {
    sliderNav(i);
    currentSlide = i; // Update currentSlide when manually navigating
  });
});

// Automatic slideshow
const autoSlide = () => {
  currentSlide = (currentSlide + 1) % slides.length; // Loop back to the first slide
  sliderNav(currentSlide);
};

// Set interval for automatic slide change (e.g., every 5 seconds)
setInterval(autoSlide, 7000);


function filterGallery(category) {
  const photos = document.querySelectorAll('.photo');
  const tabs = document.querySelectorAll('.tab');

  tabs.forEach(tab => tab.classList.remove('active'));
  event.target.classList.add('active');

  photos.forEach(photo => {
    if (category === 'all') {
      photo.style.display = 'block';
    } else {
      photo.style.display = photo.classList.contains(category) ? 'block' : 'none';
    }
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const protectedLinks = document.querySelectorAll("a.requires-login");

  protectedLinks.forEach(link => {
    link.addEventListener("click", function (e) {
      // Simulate check — replace with real login logic if available
      const isLoggedIn = false; // Set true when logged in

      if (!isLoggedIn) {
        e.preventDefault();
        showToast("Please login first to access this page.", "error");
      }
    });
  });

  function showToast(message, type = "success") {
    const toast = document.createElement("div");
    toast.classList.add("toast", type);
    toast.textContent = message;

    document.body.appendChild(toast);
    setTimeout(() => toast.style.display = "block", 100);
    setTimeout(() => {
      toast.style.display = "none";
      toast.remove();
    }, 3000);
  }
});
