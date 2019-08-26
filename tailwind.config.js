module.exports = {
  theme: {
    extend: {}
  },
  variants: {
    container: ['responsive'],
  },
  plugins: [
    require('@ky-is/tailwindcss-plugin-width-height')({ variants: ['responsive'] }),
  ],
}
