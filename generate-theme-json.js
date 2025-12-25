// generate-theme-json.js
import fs from 'fs'
import path from 'path'
import resolveConfig from 'tailwindcss/resolveConfig.js'
import tailwindConfig from './tailwind.config.js'

const fullConfig = resolveConfig(tailwindConfig)

const theme = {
  version: 2,
  settings: {
    color: {
      palette: [],
    },
    spacing: {
      units: ['px', 'rem', '%', 'vw', 'vh'],
      spacingSizes: [],
    },
    typography: {
      fontFamilies: [],
      fontSizes: [],
    },
  },
}

// Convert Tailwind colors to theme.json format
for (const [name, color] of Object.entries(fullConfig.theme.colors)) {
  if (typeof color === 'string') {
    theme.settings.color.palette.push({
      name,
      slug: name,
      color,
    })
  } else {
    for (const [shade, value] of Object.entries(color)) {
      theme.settings.color.palette.push({
        name: `${name}-${shade}`,
        slug: `${name}-${shade}`,
        color: value,
      })
    }
  }
}

// Convert Tailwind spacing to theme.json format
for (const [name, value] of Object.entries(fullConfig.theme.spacing)) {
  theme.settings.spacing.spacingSizes.push({
    name,
    slug: name,
    size: value,
  })
}

// Convert Tailwind font families to theme.json format
for (const [name, value] of Object.entries(fullConfig.theme.fontFamily)) {
    theme.settings.typography.fontFamilies.push({
        name: name,
        slug: name,
        fontFamily: Array.isArray(value) ? value.join(', ') : value,
    });
}


// Convert Tailwind font sizes to theme.json format
for (const [name, value] of Object.entries(fullConfig.theme.fontSize)) {
  const [size, options] = Array.isArray(value) ? value : [value, {}]
  theme.settings.typography.fontSizes.push({
    name,
    slug: name,
    size,
    lineHeight: options.lineHeight,
  })
}

fs.writeFileSync(
  path.resolve(process.cwd(), 'theme.json'),
  JSON.stringify(theme, null, 2)
)

console.log('theme.json generated successfully.')
