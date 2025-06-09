# Simple Block Theme

A developer-friendly **WordPress block theme** built for flexibility and performance, designed for **full-site editing** and modern block-based editing experiences.

## ✨ Features

- Uses `@wordpress/scripts` with extended Webpack support for easy bundling of SCSS, JS, and Gutenberg blocks
- Automatic block registration for new blocks in `src/blocks/block-library`
- Conditional style loading for block-specific SCSS in `scss/blocks/**`
- Semantic Release with Conventional Commits for automated versioning and changelogs
- GitHub Actions workflow for CI/CD (build and deploy theme)


## 🛠️ Installation

Clone the repository and install the dependencies:

```bash
git clone https://github.com/CloudCatch/simple-block-theme.git
cd simple-block-theme
npm install
npm run start
```

## 📦 Scripts

Here’s a quick rundown of the available scripts in `package.json`:

| Command                 | Description                                                      |
|-------------------------|------------------------------------------------------------------|
| `npm start`             | Start the development server for block scripts                   |
| `npm run build`         | Build optimized assets for production                            |
| `npm run lint:css`      | Lint CSS/SCSS files                                              |
| `npm run lint:js`       | Lint JavaScript files                                            |
| `npm run lint:md:docs`  | Lint Markdown documentation files                                |
| `npm run lint:php`      | Run PHP Code Sniffer (PHP linting)                               |
| `npm run lint:pkg-json` | Lint `package.json` file                                         |
| `npm run packages-update` | Update WordPress scripts dependencies                          |
| `npm run i18n`          | Generate a `.pot` file for theme translations                    |
| `npm run theme-zip`     | Build a zip file of the theme for distribution                   |

## 📁 Project Structure

Here’s an overview of the `src` directory structure:

```
src/
├── blocks/
│   ├── block-library/     # Individual blocks
│   ├── components/        # Reusable components
│   └── hooks/             # Custom hooks
├── fonts/                 # Font files
├── img/                   # Image assets
├── js/                    # Entry JavaScript files (editor.js, index.js)
├── scss/                  # SCSS stylesheets
│   ├── blocks/            # Styles for blocks
│   │   ├── core/          # Namespace "core" blocks
│   │   │   └── details.scss # SCSS for core/details block
│   │   ├── custom/        # Example: another namespace
│   │   │   └── example.scss # SCSS for custom/example block
│   ├── editor.scss        # Editor styles
│   ├── main.scss          # Frontend styles
│   └── svg/               # SVG assets
```

## 🧩 Block and Style Loading

- **Automatic Block Registration**  
  Any new block placed under `src/blocks/block-library` is automatically detected and registered by the theme.  
  There’s no need to manually register these blocks.

- **Efficient Style Loading**  
  All stylesheets inside `scss/blocks/**` are conditionally enqueued.  
  This means that stylesheets are only loaded when the corresponding block is actually present on the page.  
  For example:  
  - `scss/blocks/core/details.scss` is only enqueued if the `core/details` block is present.  
  - `scss/blocks/custom/example.scss` is only enqueued if the `custom/example` block is present.



## 🚀 Release and Deployment

This repository uses **[Semantic Release](https://semantic-release.gitbook.io/semantic-release/)**, which automates versioning based on commit messages.

### Commit Conventions
To trigger proper releases, commit messages should follow the **Conventional Commits** specification, e.g.:

- `fix:` – Bug fixes  
- `feat:` – New features  
- `perf:` – Performance improvements  
- `chore:` – Maintenance, build scripts, etc.

**Example:**
```shell
feat: add support for custom block styles
```

When a commit message follows this convention and is merged to the default branch, **Semantic Release** will automatically:
1. Determine the next semantic version (e.g. `1.0.1`, `1.1.0`, etc.)
2. Tag the commit with the new version
3. Create a **GitHub Release**

### Automated Deployment
A **GitHub Actions** workflow is set up to run `npm run theme-zip` and can be extended to:
- Deploy the final built theme to your WordPress site or any other hosting environment.  
- Push built assets to a dedicated deployment branch (if needed).

This ensures a fully automated **CI/CD workflow** for your theme.


---

## 📄 License

This project is licensed under the [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html).

---

## 🤝 Contributing

Contributions are welcome! Please fork this repository and open a pull request.

---

## 💬 Support

If you encounter any issues or have feature requests, please open an issue on [GitHub](https://github.com/CloudCatch/simple-block-theme/issues).

---

Enjoy using Simple Block Theme!
