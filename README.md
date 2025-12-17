# 🌬️ Underwind

**A modern, utility-first WordPress starter theme.**

Underwind is built on the robust foundation of **\_underscores** and is supercharged with a modern, high-speed development stack: **Tailwind CSS**, **Vite**, and **Alpine.js**.

It's designed from the ground up to be hacked and transformed into your next awesome, bespoke WordPress theme with zero bloat.

---

## ✨ Features & Philosophy

Underwind embraces a **utility-first CSS framework**, giving you **full control** over styling while keeping your builds highly optimized.

Here’s what makes Underwind the ultimate modern starter:

* **⚡️ Modern Development Workflow:** Streamlined theme development powered by **Vite** (for blazing fast HMR), **Tailwind CSS** (for utility-first styling), and **Alpine.js** (for reactive UI components).
* **🏗️ Clean Foundation:** A just-right amount of lean, well-commented, modern HTML5 templates based on **\_underscores**.
* **🛠️ Optimized Templating:**
    * Custom template tags in `inc/template-tags.php` to keep templates clean and prevent code duplication.
    * Small functional tweaks in `inc/template-functions.php` to enhance your theming experience.
* **🧩 Interactive Components:** The `js/app.js` entry point is ready with Alpine.js, providing an example toggled menu for small screens—ready for your custom styling and expansion.
* **🛒 WooCommerce Ready:** Full support for WooCommerce integration via hooks in `inc/woocommerce.php` and a styling override (`woocommerce.css`) with modern features like product gallery zoom, swipe, and lightbox enabled.

---

## 🚀 Getting Started

### Requirements

To run Underwind, ensure you have the following installed on your development environment:

* **Node.js** (for `npm` / **Vite**)
* **PHP** (standard for WordPress development)
* **Composer** (optional, for PHP dependency management if needed)

### Quick Start & Setup

1.  **Clone the Repository:**
    ```bash
    git clone [https://github.com/YourUsername/underwind.git](https://github.com/YourUsername/underwind.git) wp-content/themes/your-new-theme-name
    cd wp-content/themes/your-new-theme-name
    ```

2.  **Install Node Dependencies:**
    ```bash
    npm install
    ```
    *This step installs Vite, Tailwind CSS, and all necessary build tools.*

---

## 💻 CLI Commands

Underwind is configured with convenient command-line interface (CLI) commands, powered by **Vite**, to manage your assets:

| Command | Description | Usage |
| :--- | :--- | :--- |
| `npm run dev` | Starts the **Vite development server** with **Hot Module Replacement (HMR)**. | **Primary command for local development.** |
| `npm run build` | **Compiles and optimizes** all assets (CSS, JS) for **production deployment**. | Creates the versioned assets inside the `dist` directory. |
| `npm run preview` | Locally previews your **production build**, useful for final checks before deployment. | Simulates the deployed environment. |

---

## 📜 License

Underwind is licensed under the [**GPLv2 or later**.](LICENSE)

Go forth and make something cool! 🙂