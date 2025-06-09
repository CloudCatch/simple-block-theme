# Simple Block Theme

A **WordPress block theme** built for flexibility and performance, designed with modern block-based editing in mind.

---

## 🚀 Features

- **Block-based** theme structure
- Easy customization using the WordPress Site Editor
- Pre-configured build scripts for development and production
- Linting and internationalization support

---

## 📦 Scripts

Here’s a quick rundown of the available scripts in `package.json`:

| Command             | Description                                                      |
|---------------------|------------------------------------------------------------------|
| `npm start`         | Start the development server for block scripts                    |
| `npm run build`     | Build optimized assets for production                            |
| `npm run lint:css`  | Lint CSS/SCSS files                                              |
| `npm run lint:js`   | Lint JavaScript files                                            |
| `npm run lint:md:docs` | Lint Markdown documentation files                              |
| `npm run lint:php`  | Run PHP Code Sniffer (PHP linting)                               |
| `npm run lint:pkg-json` | Lint `package.json` file                                      |
| `npm run packages-update` | Update WordPress scripts dependencies                       |
| `npm run i18n`      | Generate a `.pot` file for theme translations                    |
| `npm run theme-zip` | Build a zip file of the theme for distribution                   |

---

## 🛠️ Installation

Clone the repository and install the dependencies:

```bash
git clone https://github.com/YOUR_USERNAME/simple-block-theme.git
cd simple-block-theme
npm install
