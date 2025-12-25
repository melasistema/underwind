# 🌬️ Underwind

**A modern, utility-first WordPress starter theme.**

Underwind is a beautifully crafted starter theme for WordPress, built for the modern developer. It merges the rock-solid foundation of **\_underscores** with a high-velocity development environment powered by **Vite**, **Tailwind CSS**, and **Alpine.js**.

It is designed to be a clean and elegant canvas, ready to be transformed into your next bespoke WordPress project.

---

![Underwind](resources/images/underwind-feature-image.png)

## ✨ Features

*   **✍️ First-Class Gutenberg & Block Editor Support:** Seamlessly integrate Tailwind CSS within the WordPress Block Editor with editor styles, Tailwind-ready `theme.json` defaults, and a robust workflow for custom block patterns.
*   **⚡️ Modern Dev Environment:** A seamless development experience with near-instant updates powered by **Vite**, including Hot Module Replacement (HMR).
*   **🎨 Utility-First Styling:** Direct and powerful styling workflow using **Tailwind CSS**, enabling rapid UI development without leaving your HTML.
*   **🧩 Effortless Interactivity:** **Alpine.js** is integrated and ready for creating rich, reactive, client-side components with minimal overhead.
*   **🏗️ Clean & Solid Foundation:** Built on the latest standards from **\_underscores**, providing lean, well-documented, and modern HTML5 templates.
*   **🛠️ Optimized & Modular PHP:**
    *   `inc/template-tags.php`: Custom template tags to keep your template files clean and DRY.
    *   `inc/template-functions.php`: A collection of small, useful functions to enhance the WordPress theming experience.
*   **🛒 WooCommerce Ready:** Full and seamless support for WooCommerce via dedicated hooks and styles, ensuring your e-commerce integration is smooth and consistent.
*   **✅ Integrated Code Quality:** Enforce and maintain high code standards with built-in support for **ESLint**, **Prettier**, and **PHP_CodeSniffer**.

---

## 🚀 Getting Started

### Requirements

*   **Node.js** (LTS version)
*   **PHP** (8.0+)
*   **Composer**

### Setup

1.  **Clone the Repository:**
    Clone the theme into your WordPress themes directory.
    ```bash
    git clone https://github.com/melasistema/underwind.git your-theme-name
    cd your-theme-name
    ```

2.  **Install Dependencies:**
    Install both the Node.js and PHP dependencies.
    ```bash
    npm install
    composer install
    ```

---

## 💻 Development Workflow

Underwind comes with a complete set of CLI commands to streamline your workflow.

### Primary Commands

| Command         | Description                                                                                                        |
| :-------------- | :----------------------------------------------------------------------------------------------------------------- |
| `npm run dev`   | Starts the Vite development server with Hot Module Replacement (HMR) and compiles editor styles locally for the Gutenberg editor. This is the primary command for development.   |
| `npm run build` | Compiles and bundles all assets for production and creates a distributable theme folder in `release/underwind`.      |
| `npm run preview` | Runs a local preview of your production-built assets.                                                              |

### Code Quality

| Command            | Description                                                                                                   |
| :----------------- | :------------------------------------------------------------------------------------------------------------ |
| `npm run lint:js`  | Lints all JavaScript and TypeScript files using ESLint.                                                       |
| `npm run format:js`| Formats all JS, TS, CSS, and JSON files with Prettier.                                                        |
| `npm run lint:php` | Lints all PHP files against WordPress coding standards using PHP_CodeSniffer.                                 |
| `npm run format:php` | Automatically fixes PHP code style violations with `phpcbf`.                                                  |

---

## 🚀 Deployment

Running `npm run build` prepares a production-ready version of your theme in the `release/underwind` directory. This folder is optimized and contains all the necessary files for a live WordPress environment.

To deploy your theme:

1.  Upload the contents of the `release/underwind` folder to your server's `wp-content/themes/` directory. You may rename the folder to match your theme's name.
2.  Log in to your WordPress admin dashboard, navigate to **Appearance > Themes**, and activate your newly uploaded theme.

For automated or Git-based workflows, this `release/underwind` directory is the perfect source for your CI/CD pipeline.

---

## 📜 License

Underwind is licensed under the [**GPLv2 or later**.](LICENSE)

Go forth and create.
