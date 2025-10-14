// global-script.js - shared site-wide JavaScript as ESM module
export default function globalScript() {
  // Disable browser scroll restoration to prevent jump after refresh or navigation
  if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
  }

  // Always scroll to top on page load and navigation
  window.scrollTo(0, 0);
  window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
      window.scrollTo(0, 0);
    }
  });
  document.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', function(e) {
      // Only scroll to top for internal links
      const href = link.getAttribute('href');
      if (href && href.startsWith('/') && !href.startsWith('//') && !link.hasAttribute('target')) {
        setTimeout(() => window.scrollTo(0, 0), 0);
      }
    });
  });
}
