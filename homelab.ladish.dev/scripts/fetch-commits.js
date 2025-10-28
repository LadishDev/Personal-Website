#!/usr/bin/env node
import fs from 'fs'
import path from 'path'

// Use global fetch when available (Node 18+). If not, dynamically import node-fetch.
let fetchFn = globalThis.fetch
async function ensureFetch() {
  if (!fetchFn) {
    try {
      const mod = await import('node-fetch')
      fetchFn = mod.default
    } catch (err) {
      console.error('node-fetch not available and global fetch not found. Please run in Node 18+ or install node-fetch.')
      process.exit(1)
    }
  }
  return fetchFn
}

// Config
const OWNER = process.env.GH_OWNER || 'LadishDev'
const REPO = process.env.GH_REPO || 'personal-website'
const TARGET_PATH = process.env.GH_PATH || 'homelab.ladish.dev'
const PER_PAGE = 6
const OUT_DIR = path.resolve(process.cwd(), 'src', 'data')
const OUT_FILE = path.join(OUT_DIR, 'homelab-commits.json')

async function run() {
  if (!fs.existsSync(OUT_DIR)) fs.mkdirSync(OUT_DIR, { recursive: true })
  const token = process.env.GITHUB_TOKEN
  const url = `https://api.github.com/repos/${OWNER}/${REPO}/commits?path=${TARGET_PATH}&per_page=${PER_PAGE}`
  const headers = { 'User-Agent': 'fetch-commits-script' }
  if (token) headers['Authorization'] = `token ${token}`
  try {
    const fetch = await ensureFetch()
    const res = await fetch(url, { headers })
    if (!res.ok) throw new Error(`GitHub API ${res.status} ${res.statusText}`)
    const data = await res.json()
    // Enforce a strict maximum number of commits (PER_PAGE)
    const raw = Array.isArray(data) ? data.slice(0, PER_PAGE) : []
    const commits = raw.map(c => ({
      sha: c.sha,
      shortSha: c.sha.slice(0,7),
      message: (c.commit?.message || '').split('\n')[0].trim(),
      date: c.commit?.committer?.date || c.commit?.author?.date || null,
      url: c.html_url
    }))
    fs.writeFileSync(OUT_FILE, JSON.stringify({ generatedAt: new Date().toISOString(), commits }, null, 2))
    console.log(`Wrote ${commits.length} commits to ${OUT_FILE}`)
  } catch (err) {
    console.error('Failed to fetch commits:', err.message)
    process.exit(1)
  }
}

run()
