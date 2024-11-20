import { defineConfig } from 'vitest/config';

export default defineConfig({
  test: {
    include: ['**/*.{test,spec}.{js,ts,jsx,tsx}'], // Ensure it matches your file naming convention
    exclude: [
      'node_modules',
      'dist',
      'cypress',
      '**/.{idea,git,cache,output,temp}/**',
      '**/{karma,rollup,webpack,vite,vitest,jest,ava,babel,nyc,cypress,tsup,build,eslint,prettier}.config.*',
    ],
  },
});
