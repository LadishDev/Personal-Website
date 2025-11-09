const canvas = document.getElementById('matrix-canvas');
if (!canvas) {
  console.error('Canvas element with id "matrix-canvas" not found');
  throw new Error('Canvas element not found');
}

const ctx = canvas.getContext('2d');
if (!ctx) {
  console.error('Unable to get 2D context from canvas');
  throw new Error('Canvas context not available');
}

const letters = '01';
const fontSize = 14;
let columns;
let drops;

function resizeCanvas() {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
  columns = Math.floor(canvas.width / fontSize);
  
  // Preserve existing drops or create new ones
  const newDrops = Array.from({ length: columns });
  for (let i = 0; i < columns; i++) {
    // Reuse existing drop positions if available, otherwise start fresh
    newDrops[i] = drops && i < drops.length ? drops[i] : Math.floor(Math.random() * canvas.height / fontSize);
  }
  drops = newDrops;
}
resizeCanvas();

function draw() {
  ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  ctx.fillStyle = '#00FF00';
  ctx.font = fontSize + 'px monospace';

  for (let i = 0; i < drops.length; i++) {
    const text = letters.charAt(Math.floor(Math.random() * letters.length));
    ctx.fillText(text, i * fontSize, drops[i] * fontSize);

    if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
      drops[i] = 0;
    }
    drops[i]++;
  }
}

setInterval(draw, 33);

// Debounce resize
let resizeTimeout;
window.addEventListener('resize', () => {
  clearTimeout(resizeTimeout);
  resizeTimeout = setTimeout(resizeCanvas, 100);
});
