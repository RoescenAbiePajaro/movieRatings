// import adapter from '@sveltejs/adapter-static';
// import { vitePreprocess } from '@sveltejs/vite-plugin-svelte';

// /** @type {import('@sveltejs/kit').Config} */
// const config = {
//     preprocess: vitePreprocess(),

//     kit: {
//         adapter: adapter({ pages: "build", assets: "build", fallback: undefined, precompress: false, strict: true }),

//     },
// };

// export default config;

import adapter from '@sveltejs/adapter-vercel';

/** @type {import('@sveltejs/kit').Config} */
const config = {
  kit: {
    // Other configurations
    adapter: adapter(),
     pages: 'build',
      assets: 'build'
  },
};

export default config;


