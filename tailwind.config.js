const tailwind = require('tailwindcss/defaultTheme');

module.exports = {
  theme: {
    container: {
      padding: '2rem',
      center: true,
    },
    fontFamily: {
        // sans: ['Inter', 'sans-serif'],
        mono: ['"IBM Plex Mono"', 'monospace']
    },
    fontSize: {
      'xs': '10px',
      'sm': '12px',
      'base': '14px',
      'lg': '16px',
      'xl': '18px',
    },
  },
  variants: {
  },
  plugins: [
    require('./theme.config.js'),
    require('@ky-is/tailwindcss-plugin-width-height')({ variants: ['responsive'] }),
  ],
}