<h1 align="center">Personal Websites</h1>

Source code for the websites hosted under `ladish.dev`. The repository contains a personal portfolio, a homelab dashboard and notes site, and a small links page.

## 🚀 Features

- Project portfolio with detailed write-ups and repo links
- Project write-ups and resume pages
- MDX-powered homelab documentation and lab notes
- Responsive, mobile-first design
- Static site generation with Astro and Vite
- Custom components and layouts
- SEO, RSS, and sitemap support on the portfolio site
- Custom CSS, fonts, and lightweight JavaScript

## 🛠️ Tech Stack
- ladish.dev
	- [Astro](https://astro.build/) (static site generator)
	- [MDX](https://mdxjs.com/) (Markdown + JSX for content)
	- Astro Node, RSS, and sitemap integrations

- homelab.ladish.dev
	- [Vue](https://vuejs.org/)
	- [Vite](https://vitejs.dev/)
	- Express server for production serving

- links.ladish.dev
	- Static HTML, CSS, and JavaScript

- under_construction.html
	- Static HTML, CSS, and JavaScript

## 📂 Project Structure

- `ladish.dev/` — Main Astro project
  - `src/` — Source code (components, pages, content, assets)
  - `public/` — Static assets (images, fonts, scripts)
  - `astro.config.mjs`, `tsconfig.json` — Config files

- `homelab.ladish.dev/` — Homelab Vue/Vite project
	- `src/pages/` — Dashboard, documentation, and lab-note pages
	- `src/content/` — MDX documentation and lab notes
	- `src/components/` — Shared navigation and UI components
	- `public/` — Static assets and generated badges
	- `scripts/` — Build-time data collection scripts

- `links.ladish.dev/` — Static links page, styles, and Matrix-style background script

- `under_construction.html` — Standalone temporary landing page for pages that are still being developed

## 🧑‍💻 Getting Started

Each site is an independent project with its own dependencies.

**Clone the repository:**
	```sh
	git clone https://github.com/LadishDev/personal-website.git
	cd personal-website
	```

### Portfolio

Install dependencies and start the Astro development server:

	```sh
	cd ladish.dev
	npm install
	npm run dev
	```

Build the portfolio for production:

	```sh
	cd ladish.dev
	npm run build
	```

### Homelab

Install dependencies and start the Vite development server:

	```sh
	cd homelab.ladish.dev
	npm install
	npm run dev
	```

Build and preview the homelab site:

	```sh
	cd homelab.ladish.dev
	npm run build
	npm run preview
	```

The homelab production build refreshes commit data before generating the Vite output. To serve the built site with Express, use `npm run serve` instead of `npm run preview`.

The `links.ladish.dev/` page and `under_construction.html` have no build step and can be opened directly in a browser.

## 🌐 Deployment

`ladish.dev`, `links.ladish.dev`, and `under_construction.html` can be deployed to any static hosting provider. `homelab.ladish.dev` can be served with its Express server after building or deployed as the generated Vite output where appropriate.

## 🤝 Contributing

Pull requests and suggestions are welcome! Please open an issue or PR for any improvements or bug fixes.

## 📄 License

This project is licensed under the MIT License. See `LICENSE.md` for details.