import express from 'express'
import path from 'path'
import { fileURLToPath } from 'url'

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

const app = express()
const port = process.env.PORT || 3000
const distPath = path.join(__dirname, 'dist')

// Serve static files
app.use(express.static(distPath))

// Ensure favicon is served with correct headers (some browsers request it directly)
app.get('/favicon.ico', (req, res) => {
  const icoPath = path.join(distPath, 'favicon.ico')
  res.setHeader('Content-Type', 'image/x-icon')
  res.setHeader('Cache-Control', 'public, max-age=86400')
  res.sendFile(icoPath)
})

// Fallback to index.html for SPA routing
app.get('*', (req, res) => {
  res.sendFile(path.join(distPath, 'index.html'))
})

const server = app.listen(port, () => {
  console.log(`Server listening on http://localhost:${port}`)
})

// Graceful shutdown
const shutdown = () => {
  console.log('Shutting down server...')
  server.close(() => process.exit(0))
}

process.on('SIGINT', shutdown)
process.on('SIGTERM', shutdown)
