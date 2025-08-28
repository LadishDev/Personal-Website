const fs = require('fs');
const path = require('path');

const SRC_DIR = path.join(__dirname, 'src');

// Helper to recursively walk directories
function walk(dir, callback) {
  fs.readdirSync(dir).forEach(f => {
    const full = path.join(dir, f);
    if (fs.statSync(full).isDirectory()) walk(full, callback);
    else callback(full);
  });
}

// 1. Rename folders
function renameFolders() {
  const contentBlog = path.join(SRC_DIR, 'content', 'blog');
  const contentProjects = path.join(SRC_DIR, 'content', 'projects');
  if (fs.existsSync(contentBlog)) fs.renameSync(contentBlog, contentProjects);

  const pagesBlog = path.join(SRC_DIR, 'pages', 'blog');
  const pagesProjects = path.join(SRC_DIR, 'pages', 'projects');
  if (fs.existsSync(pagesBlog)) fs.renameSync(pagesBlog, pagesProjects);
}

// 2. Rename files if needed (e.g., BlogPost.astro → ProjectPost.astro)
function renameFiles() {
  const layoutsDir = path.join(SRC_DIR, 'layouts');
  const blogPost = path.join(layoutsDir, 'BlogPost.astro');
  const projectPost = path.join(layoutsDir, 'ProjectPost.astro');
  if (fs.existsSync(blogPost)) fs.renameSync(blogPost, projectPost);
}

// 3. Replace 'blog' with 'projects' in file contents
function replaceInFiles() {
  const exts = ['.astro', '.ts', '.js', '.mdx', '.md'];
  walk(SRC_DIR, file => {
    if (!exts.includes(path.extname(file))) return;
    let content = fs.readFileSync(file, 'utf8');
    let updated = content
      .replace(/blog/g, 'projects')
      .replace(/Blog/g, 'Projects')
      .replace(/BLOG/g, 'PROJECTS');
    if (updated !== content) {
      fs.writeFileSync(file, updated, 'utf8');
      console.log('Updated:', file);
    }
  });
}

// 4. Update .astro/content.d.ts and .astro/collections/blog.schema.json if needed
function updateAstroGenerated() {
  const contentDts = path.join(__dirname, '.astro', 'content.d.ts');
  if (fs.existsSync(contentDts)) {
    let content = fs.readFileSync(contentDts, 'utf8');
    let updated = content.replace(/blog/g, 'projects');
    if (updated !== content) fs.writeFileSync(contentDts, updated, 'utf8');
  }
  const blogSchema = path.join(__dirname, '.astro', 'collections', 'blog.schema.json');
  const projectsSchema = path.join(__dirname, '.astro', 'collections', 'projects.schema.json');
  if (fs.existsSync(blogSchema)) fs.renameSync(blogSchema, projectsSchema);
}

// Run all steps
renameFolders();
renameFiles();
replaceInFiles();
updateAstroGenerated();

console.log('All done! Please review your site and restart the dev server.');