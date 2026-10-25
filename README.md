# 🍽️ Restaurant Website Template

A fully responsive restaurant website built using **HTML**, **CSS**, and **JavaScript**.
Includes dynamic features like an **auto-sliding hero section**, **interactive menu with item counter**, and **About Us page with testimonials**.

---

## ✨ Features

### 🔥 Hero Section (Auto-Slide)

* Automatically cycles through featured images every few seconds.
* Smooth fade/slide transitions using JavaScript.
* Supports manual navigation if needed.

### 🧾 Dynamic Menu With Cart Bar

* Users can click **+** to add menu items.
* A **bottom cart bar** appears dynamically once the first item is added.
* Bar shows:

  * Restaurant name (“Grilli” or your custom name)
  * A **View Cart** button
  * Total **number of selected items**
* Data is stored using **LocalStorage**, so refresh does not reset the cart.

### 🧠 Menu Item Management

* Supports:

  * Adding items
  * Real-time item count updates
  * Storing menu selections locally

### 👨‍🍳 About Us Page

* Details about the restaurant’s story, mission, and culinary experience.
* Images + beautifully styled content sections.

### ⭐ Testimonials

* Customer reviews displayed in an attractive layout.
* Optional:

  * Slider
  * Cards
  * Fade transitions

### 📱 Fully Responsive

* Optimized for mobile, tablet, and desktop.
* Uses CSS Flexbox + Grid for layout.

---
## 📸 Preview
[TTS App Preview](assets/ <img width="1399" height="799" alt="Screenshot 2025-12-02 235534" src="https://github.com/user-attachments/assets/36726ad4-1bb0-4cf5-97cc-0856f5bcbf8e" />)
[TTS App Preview](assets/ <img width="1896" height="862" alt="Screenshot 2025-12-02 235618" src="https://github.com/user-attachments/assets/690abf85-5d1f-4063-a6ce-98d1e11ffa22" />)
[TTS App Preview](assets/ <img width="1919" height="856" alt="Screenshot 2025-12-02 235638" src="https://github.com/user-attachments/assets/26f54e59-1873-4d10-a2f1-62259c79fcdc" />
[TTS App Preview](assets/ <img width="1898" height="873" alt="Screenshot 2025-12-02 235702" src="https://github.com/user-attachments/assets/9bc3d000-0864-4f9d-835d-9825cfa48041" />

## 📁 Project Structure

```
restaurant-website/
│
├── index.html           # Homepage with hero slider + menu
├── about.html           # About Us + Testimonials
│
├── css/
│   └── style.css        # Main styling
│
├── js/
│   ├── slider.js        # Hero auto-slide logic
│   └── cart.js          # Dynamic menu + cart bar logic
│
├── images/
│   ├── hero1.jpg
│   ├── hero2.jpg
│   ├── hero3.jpg
│   └── menu items...
│
└── README.md            # Documentation
```

---

## 🚀 How to Run

1. Download or clone the repository:

   ```bash
   git clone https://github.com/Akashs-777/Restaurant-Template.git
   ```
2. Open **index.html** in any browser.
3. Make edits in `/css/style.css` or `/js` files as needed.

---

## 🛠️ Technologies Used

* **HTML5** – structure
* **CSS3** – layout, responsiveness, animations
* **JavaScript (ES6)** – hero slider, cart bar, local storage

---

## ⚙️ Scripts Overview

### ▶️ Auto-Slide Hero Script (`slider.js`)

* Cycles through `.slide` elements every 3–4 seconds.
* Adds/removes `.active` class to create transitions.

### 🛒 Cart Bar Script (`cart.js`)

* Adds click listeners to all menu “+” buttons.
* Updates item count in real-time.
* Displays cart bar when count > 0.
* Saves cart state using:

  ```js
  localStorage.setItem("cartCount", count);
  ```

---

## 📖 Pages Overview

### 🏠 **Home Page**

* Auto-sliding hero banner
* Menu section
* Dynamic cart bar

### 👨‍🍳 **About Us Page**

* Our story
* Mission & values
* Chef/restaurant images

### ⭐ **Testimonials**

* Customer reviews
* Styled with grids or slider

---

## 🧩 Future Enhancements

* Add checkout page
* Add backend for real orders
* Add animations on scroll (AOS)
* Dark/light mode toggle

---

## 🤝 Contributing

Contributions are welcome!
Feel free to submit issues or pull requests.

---

## 📄 License

This project is open source under the **MIT License**.

---

If you'd like, Ak, I can **create all the files**, including the **entire codebase**, and drop them in a zip file or generate each file one by one.
