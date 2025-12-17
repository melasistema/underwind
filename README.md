# 🌬️ Underwind

**A modern, utility-first WordPress starter theme.**

Underwind is built on the robust foundation of **\_underscores** and is supercharged with a modern, high-speed development stack: **Tailwind CSS**, **Vite**, and **Alpine.js**.

It's designed from the ground up to be hacked and transformed into your next awesome, bespoke WordPress theme with zero bloat.

---

## ✨ Features & Philosophy

Underwind embraces a **utility-first CSS framework**, giving you **full control** over styling while keeping your builds highly optimized.

Here’s what makes Underwind the ultimate modern starter:

*   **⚡️ Modern Development Workflow:** Streamlined theme development powered by **Vite** (for blazing fast HMR). All front-end assets, including JavaScript and CSS, are now processed by Vite, ensuring optimal performance and modern tooling.
*   **🏗️ Clean Foundation:** A just-right amount of lean, well-commented, modern HTML5 templates based on **\_underscores**.
*   **🛠️ Optimized Templating:**
    *   Custom template tags in `inc/template-tags.php` to keep templates clean and prevent code duplication.
    *   Small functional tweaks in `inc/template-functions.php` to enhance your theming experience.
*   **🧩 Interactive Components:** The `src/js/app.js` entry point is ready with Alpine.js, which defines the `menu()` data component for interactive elements. It provides an example toggled menu for small screens—ready for your custom styling and expansion.
*   **🛒 WooCommerce Ready:** Full support for WooCommerce integration via hooks in `inc/woocommerce.php`. WooCommerce styles are now integrated into the main CSS build via Vite, along with modern features like product gallery zoom, swipe, and lightbox enabled.

---

## 🚀 Getting Started

### Requirements

To run Underwind, ensure you have the following installed on your development environment:

*   **Node.js** (for `npm` / **Vite**)
*   **PHP** (standard for WordPress development)
*   **Composer** (optional, for PHP dependency management if needed)

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
| `npm run build` | **Compiles and optimizes** all assets (CSS, JS) for **production deployment**. | Creates the versioned assets inside the `release/underwind/dist` directory. |
| `npm run preview` | Locally previews your **production build**, useful for final checks before deployment. | Simulates the deployed environment. |

### Release Script Optimization

The `build` script utilizes `cpy-cli` to prepare the theme for release. While effective, the current approach relies on an extensive list of exclusions. For improved clarity, control, and maintainability, especially as the project grows, consider these optimization strategies:

1.  **Refactor `cpy-cli` Exclusions:** Review and refine the existing `cpy-cli` exclusion patterns. Group similar exclusions and add comments to improve readability and make it easier to understand what's being included or omitted.
2.  **Custom Node.js Script:** For ultimate flexibility and more explicit control over the release process, consider replacing `cpy-cli` with a custom Node.js script. Utilizing a library like `fs-extra` would allow for explicit inclusion patterns (e.g., `copy all .php files`, `copy the 'inc' directory`) and more fine-grained management of the copying process. This approach also facilitates the integration of pre-processing or post-processing steps specific to your release workflow.

---

## 📜 License

Underwind is licensed under the [**GPLv2 or later**.](LICENSE)

Go forth and make something cool! 🙂