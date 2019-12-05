const { ThemeBuilder, Theme } = require('tailwindcss-theming');

const mainTheme = new Theme()
  .default()
  .colors({
    'body': '#ffffff',
    'on-body': '#676f7f',
    'body-border': '#e8eaf0',
    'body-variant': '#f1f5f8',
    'on-body-variant': '#636d88',
    'surface': '#ffffff',
    'surface-hover': '#f1f5f8',
    'on-surface': '#676f7f',
    'surface-border': '#e8eaf0',
    'navigation': '#222b3a',
    'on-navigation': '#5b6272',
    'discussion-icon': '#fbc02d',
    'on-discussion-icon': '#ffffff',
    'button-primary': '#3d81fc',
    'on-button-primary': '#ffffff',
    'button-secondary': '#e8eaf0',
    'on-button-secondary': '#989aa7',
    'button-tertiary': '#ffffff',
    'on-button-tertiary': '#989aa7',
    'brand': '#3182ce',
    'on-brand': '#3182ce',
  })
  .colorVariant('active', '#e9ecf4', 'on-navigation')
  .colorVariant('hover', '#e9ecf4', 'on-navigation')
  .colorVariant('pinned', '#479f4b', 'discussion-icon')
  .colorVariant('hot', '#e53e3e', 'discussion-icon')
  .colorVariant('locked', '#000000', 'discussion-icon')
;

const darkTheme = new Theme()
  .colors({
  })
;

module.exports = new ThemeBuilder()
  .asDataThemeAttribute()
  .default(mainTheme)
  // .dark(darkTheme)
;