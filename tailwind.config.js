module.exports = {
  theme: {
    extend: {}
  },
  variants: {},
  plugins: [
    require('@ky-is/tailwindcss-plugin-width-height')({ variants: ['responsive'] }),
  ],
}
