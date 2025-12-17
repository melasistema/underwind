module.exports = {
  root: true,
  env: {
    browser: true,
    es2020: true,
    node: true,
    'wp-admin': true, // For WordPress admin environment variables
  },
  extends: [
    'eslint:recommended',
    'plugin:@typescript-eslint/recommended',
    'plugin:prettier/recommended', // Enables eslint-plugin-prettier and eslint-config-prettier
    'plugin:alpinejs/recommended',
    'plugin:tailwindcss/recommended',
    'plugin:import/recommended',
    'plugin:node/recommended',
    'plugin:promise/recommended',
  ],
  parser: '@typescript-eslint/parser',
  parserOptions: {
    ecmaVersion: 'latest',
    sourceType: 'module',
  },
  plugins: [
    '@typescript-eslint',
    'alpinejs',
    'tailwindcss',
    'import',
    'node',
    'promise',
  ],
  settings: {
    'import/resolver': {
      node: {
        extensions: ['.js', '.jsx', '.ts', '.tsx'],
      },
    },
    tailwindcss: {
      callees: ['tw', 'classnames', 'clsx'], // Customize if you use other utility functions for Tailwind
      config: './tailwind.config.js',
    },
  },
  rules: {
    // Custom rules can be added here
    'prettier/prettier': 'warn', // Warn about Prettier issues instead of error
    '@typescript-eslint/no-unused-vars': ['warn', { argsIgnorePattern: '^_' }], // Warn for unused variables
    'no-unused-vars': 'off', // Turn off base ESLint rule as TS version is used
  },
};
