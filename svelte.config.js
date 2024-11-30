import adapterStatic from '@sveltejs/adapter-static';
import adapterVercel from '@sveltejs/adapter-vercel';

/** @type {import('@sveltejs/kit').Config} */
const config = {
  kit: {
    adapter: process.env.VERCEL ? adapterVercel() : adapterStatic({
      pages: 'public',
      assets: 'public',
      fallback: undefined,
      precompress: false,
      strict: true
    })
  }
};

export default config;
