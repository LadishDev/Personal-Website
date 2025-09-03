// @ts-check

import mdx from '@astrojs/mdx';
import sitemap from '@astrojs/sitemap';
import { defineConfig } from 'astro/config';

// https://astro.build/config
export default defineConfig({
    // Site URL for sitemap generation and SEO
    site: 'https://ladish.dev',
    
    // Enable MDX support and automatic sitemap generation
    integrations: [mdx(), sitemap()],
    
    // Build configuration
    build: {
        // Enable inline stylesheets for better performance
        inlineStylesheets: 'auto'
    },
    
    // Vite configuration for minification and optimization
    vite: {
        build: {
            // Enable minification with terser
            minify: 'terser',
            
            // Terser options for code optimization
            terserOptions: {
                compress: {
                    // Remove console statements in production
                    drop_console: true,
                    // Remove debugger statements
                    drop_debugger: true
                },
                mangle: {
                    // Mangle variable names (but keep property names readable)
                    properties: false
                },
                format: {
                    // Remove comments from production build
                    comments: false
                }
            },
            
            // Disable source maps in production for security
            sourcemap: false
        }
    }
});