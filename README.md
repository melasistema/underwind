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
*   **Composer** (mandatory, for PHP dependency management)

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

## 🧹 Code Quality & Standards

To ensure code consistency, reduce errors, and streamline development, Underwind integrates several tools for linting and formatting.

| Command            | Description                                                                                                                                              |
| :----------------- | :------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `npm run lint:js`  | Checks JavaScript and TypeScript files for errors and style violations using ESLint.                                                                     |
| `npm run format:js`| Automatically formats JavaScript, TypeScript, CSS, and JSON files using Prettier, adhering to the project's defined style.                               |
| `npm run lint:php` | Checks PHP files for coding standard violations using PHP_CodeSniffer, based on the `phpcs.xml.dist` configuration (WordPress and Theme Review standards). |
| `npm run format:php` | Automatically fixes many common PHP coding standard violations using `phpcbf`.                                                                           |

---

## 🧪 Testing

Implementing a comprehensive testing strategy is crucial for maintaining code quality, preventing regressions, and ensuring the reliability of your theme as it evolves. While not strictly enforced out-of-the-box, consider integrating the following types of tests:

*   **PHP Unit Testing:** For backend PHP logic (e.g., custom functions, classes, and WordPress hooks), PHPUnit is the standard. This helps verify that individual components of your PHP code work as expected.
*   **JavaScript Unit/Integration Testing:** For frontend JavaScript logic (especially Alpine.js components or any complex interactions), tools like Jest or Vitest can be used. This ensures your JavaScript code functions correctly in isolation and when integrated with other small units.
*   **End-to-End (E2E) Testing:** For verifying critical user flows and theme functionality in a browser environment, E2E testing frameworks like Cypress or Playwright are invaluable. These tests simulate real user interactions and ensure the theme behaves correctly across different pages and scenarios.

Integrating testing frameworks involves setting up test runners, writing test cases, and potentially adding new `npm` scripts for running tests. These are advanced steps that can significantly enhance the robustness of your theme.

---

## 🚀 Deployment

After running `npm run build`, a production-ready version of your theme will be generated in the `release/underwind` directory. This folder contains all the necessary files for your WordPress theme, optimized for deployment.

To deploy your theme to a live WordPress environment:

1.  **Access Your Server:** Connect to your web server using FTP/SFTP or SSH.
2.  **Navigate to Themes Directory:** Go to your WordPress installation's `wp-content/themes/` directory.
3.  **Upload the Release:** Upload the entire `release/underwind` folder (rename it to your desired theme folder name, e.g., `your-theme-name`) into the `wp-content/themes/` directory on your server.
4.  **Activate Theme:** Log in to your WordPress admin dashboard, navigate to "Appearance > Themes", and activate your newly uploaded theme.

For more advanced deployment workflows (e.g., Git-based deployment, CI/CD pipelines), you would typically configure your system to automatically transfer the contents of the `release/underwind` folder to your production server upon a successful build or commit.

---

## ⚡️ Performance Optimization

Ensuring your theme performs optimally is key for a great user experience. Beyond the initial setup with Vite and Tailwind CSS, consider these areas for further performance enhancements:

*   **Image Optimization:** Images often contribute significantly to page load times. Implement strategies such as:
    *   **Responsive Images:** Use `srcset` and `sizes` attributes to serve appropriately sized images based on the user's device.
    *   **Lazy Loading:** Defer loading of offscreen images until they are needed, using native browser lazy loading (`loading="lazy"`) or JavaScript libraries.
    *   **Modern Formats:** Convert images to modern, more efficient formats like WebP or AVIF, which offer better compression with little to no loss in quality.
    *   **Compression:** Optimize images without visually perceptible quality loss using tools or services.
*   **Critical CSS Generation:** For optimal perceived performance, consider generating and inlining "Critical CSS" for the above-the-fold content of your pages. This ensures that the essential styling loads as quickly as possible, providing a fast initial render. Tools can analyze your page and extract the necessary CSS.

---

## 📜 License

Underwind is licensed under the [**GPLv2 or later**.](LICENSE)

Go forth and make something cool! 🙂