module.exports = {
  theme: {
    container: {
      padding: '2rem',
      center: true,
    },
    fontFamily: {
        sans: ['Inter', 'sans-serif'],
        mono: ['"IBM Plex Mono"', 'monospace']
    },
    fontSize: {
      'xs': '10px',
      'sm': '12px',
      'base': '14px',
      'lg': '16px',
      'xl': '18px',
    },
    extend: {
      colors: {
        gray: {
          '100': '#f5f5f5',
          '200': '#eeeeee',
          '300': '#e0e0e0',
          '400': '#bdbdbd',
          '500': '#9e9e9e',
          '600': '#757575',
          '700': '#616161',
          '800': '#424242',
          '900': '#212121',
        }
      }
    }
  },
  variants: {
  },
  plugins: [
    require('@ky-is/tailwindcss-plugin-width-height')({ variants: ['responsive'] }),
  ],
}