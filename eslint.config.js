import globals from 'globals';
import pluginJs from '@eslint/js';
import prettierPlugin from 'eslint-plugin-prettier';
import alpinejs from 'eslint-plugin-alpinejs';
import tailwindcss from 'eslint-plugin-tailwindcss';
import pluginImport from 'eslint-plugin-import';
import pluginNode from 'eslint-plugin-node';
import pluginPromise from 'eslint-plugin-promise';

export default [
  {
    ignores: [
      'dist',
      'release',
      'vendor',
      'node_modules',
      '.git',
      '.idea',
      '.vscode',
      '.DS_Store',
      '.env*',
      '.eslintcache',
      '.stylelintcache',
      '**/*.min.*',
      '**/*.js.map',
      '**/*.css.map',
      '.*',
      '!eslint.config.js',
      '!.prettierrc.cjs',
      '!.tailwind.config.js',
      '!.postcss.config.js',
    ],
  },
  pluginJs.configs.recommended, // Basic ESLint recommended rules
  {
    files: ['{src,inc}/**/*.{js,jsx}'], // Targeting only JS/JSX for now. TypeScript linting is temporarily disabled.
    languageOptions: {
      globals: {
        ...globals.browser,
        ...globals.es2020,
        ...globals.node,
        wp: true,
        jQuery: true,
      },
    },
    plugins: {
      prettier: prettierPlugin,
      alpinejs: alpinejs,
      tailwindcss: tailwindcss,
      import: pluginImport,
      node: pluginNode,
      promise: pluginPromise,
    },
    rules: {
      // Basic rules
      'no-unused-vars': ['warn', { argsIgnorePattern: '^_' }],
      'prettier/prettier': ['warn', {
        tabWidth: 4,
        singleQuote: true,
        semi: false,
        trailingComma: 'es5',
        printWidth: 80,
      }],
      // Alpine.js plugin rules
      // 'alpinejs/no-custom-directive': 'warn', // Example of a valid rule

      // Tailwind CSS plugin rules
      'tailwindcss/no-custom-classname': 'off',
      'tailwindcss/classnames-order': 'warn',
      'tailwindcss/no-contradicting-classname': 'warn',

      // Import plugin rules (examples)
      'import/order': ['warn', { 'newlines-between': 'always' }],
      'import/no-unresolved': 'off', // Turn off due to potential false positives with aliases/paths

      // Node plugin overrides for browser environments if applicable
      'node/no-unpublished-import': 'off',
      'node/no-missing-import': 'off',
      'node/no-unsupported-features/es-syntax': 'off',

      // Promise plugin rules (examples)
      'promise/always-return': 'warn',
      'promise/no-return-wrap': 'error',
    },
    settings: {
      'import/resolver': {
        node: {
          extensions: ['.js', '.jsx'], // Only JS/JSX for now
        },
      },
      tailwindcss: {
        callees: ['tw', 'classnames', 'clsx'],
        config: './tailwind.config.js',
      },
    },
  },
];
