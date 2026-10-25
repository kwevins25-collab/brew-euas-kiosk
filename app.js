const images = [
  'assets/images/hero-slider-1.jpg',
  'assets/images/hero-slider-2.jpg',
  'assets/images/hero-slider-3.jpg',
];

let index = 0;

const hero = document.querySelector('.heroSection');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

// Only run slider logic if hero exists
if (hero && prevBtn && nextBtn) {
  hero.style.backgroundImage = `url(${images[index]})`;

  function nextImage() {
    index = (index + 1) % images.length;
    hero.style.backgroundImage = `url(${images[index]})`;
  }
  function prevImage() {
    index = (index - 1 + images.length) % images.length;
    hero.style.backgroundImage = `url(${images[index]})`;
  }

  let slider = setInterval(nextImage, 4000);

  nextBtn.addEventListener("click", () => {
    nextImage();
    resetTimer();
  });

  prevBtn.addEventListener("click", () => {
    prevImage();
    resetTimer();
  });

  function resetTimer() {
    clearInterval(slider);
    slider = setInterval(nextImage, 4000);
  }
}

// --- Cart Logic ---

const addButtons = document.querySelectorAll('.add-btn');
const cartBar = document.getElementById('cartBar');
const cartCount = document.getElementById('cartCount');

// Get cart from localStorage or initialize
let cart = JSON.parse(localStorage.getItem('cart')) || {};

// Function to update cart UI and localStorage
function updateCartUI() {
  const items = Object.keys(cart);
  const totalCount = items.reduce((sum, item) => sum + cart[item].quantity, 0);

  if (totalCount > 0) {
    if (cartBar) cartBar.classList.add('show');
    if (cartCount) cartCount.textContent = totalCount;
  } else {
    if (cartBar) cartBar.classList.remove('show');
    if (cartCount) cartCount.textContent = 0;
  }

  localStorage.setItem('cart', JSON.stringify(cart));
}

// Add click event for each add button
addButtons.forEach(button => {
  button.addEventListener('click', (e) => {
    e.preventDefault(); // Prevent default if it's inside a link
    const itemName = button.getAttribute('data-name');
    const itemPrice = parseFloat(button.getAttribute('data-price'));

    // Add item to cart
    if (cart[itemName]) {
      cart[itemName].quantity += 1;
    } else {
      cart[itemName] = { price: itemPrice, quantity: 1 };
    }

    // Update UI
    updateCartUI();

    // Optional: Visual feedback
    const originalText = button.textContent;
    button.textContent = '✓';
    setTimeout(() => button.textContent = originalText, 1000);
  });
});

// Initialize cart UI on page load
updateCartUI();

// Clear Cart Logic
const clearCartBtn = document.getElementById('clearCartBtn');
if (clearCartBtn) {
  clearCartBtn.addEventListener('click', () => {
    if (confirm('Are you sure you want to clear your cart?')) {
      cart = {};
      localStorage.removeItem('cart');
      updateCartUI();
    }
  });
}

// --- Testimonial Slider Logic ---
const testimonials = [
  {
    name: "John Doe",
    title: "Food Lover",
    text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.",
    rating: 5,
    avatar: "assets/images/testi-avatar.jpg"
  },
  {
    name: "Jane Smith",
    title: "Regular Customer",
    text: "The ambiance is amazing and the food is even better. I highly recommend the grilled salmon!",
    rating: 5,
    avatar: "assets/images/testi-avatar.jpg"
  },
  {
    name: "Michael Brown",
    title: "Food Critic",
    text: "A hidden gem! The flavors are authentic and the service is top-notch. Will definitely be coming back.",
    rating: 4,
    avatar: "assets/images/testi-avatar.jpg"
  }
];

let currentTestimonial = 0;
const testiName = document.querySelector('.testi-name');
const testiTitle = document.querySelector('.testi-title');
const testiText = document.querySelector('.testi-text');
const testiAvatar = document.querySelector('.testi-avatar');
const ratingWrapper = document.querySelector('.rating-wrapper');
const prevTestiBtn = document.querySelector('.prev-testi');
const nextTestiBtn = document.querySelector('.next-testi');

if (testiName && prevTestiBtn && nextTestiBtn) {
  function renderTestimonial(index) {
    const testimonial = testimonials[index];
    testiName.textContent = testimonial.name;
    testiTitle.textContent = testimonial.title;
    testiText.textContent = `"${testimonial.text}"`;
    testiAvatar.src = testimonial.avatar;

    // Render stars
    ratingWrapper.innerHTML = '';
    for (let i = 0; i < 5; i++) {
      if (i < testimonial.rating) {
        ratingWrapper.innerHTML += '<ion-icon name="star"></ion-icon>';
      } else {
        ratingWrapper.innerHTML += '<ion-icon name="star-outline"></ion-icon>';
      }
    }
  }

  function nextTestimonial() {
    currentTestimonial = (currentTestimonial + 1) % testimonials.length;
    renderTestimonial(currentTestimonial);
  }

  function prevTestimonial() {
    currentTestimonial = (currentTestimonial - 1 + testimonials.length) % testimonials.length;
    renderTestimonial(currentTestimonial);
  }

  nextTestiBtn.addEventListener('click', nextTestimonial);
  prevTestiBtn.addEventListener('click', prevTestimonial);

  // Auto-play
  setInterval(nextTestimonial, 5000);
}
