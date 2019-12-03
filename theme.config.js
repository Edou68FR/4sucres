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
    'on-surface': '#676f7f',
    'surface-border': '#e8eaf0',
    'navigation': '#282e43',
    'on-navigation': '#e8e9ea',
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
  .colorVariant('active', '#2b6cb0', 'navigation')
  .colorVariant('hover', '#474f5a', 'navigation')
  .colorVariant('pinned', '#479f4b', 'discussion-icon')
  .colorVariant('hot', '#e53e3e', 'discussion-icon')
  .colorVariant('locked', '#000000', 'discussion-icon')
;

const darkTheme = new Theme()
  .colors({
    'body': '#151419',
    'on-body': '#838690',
    'body-border': '#27292d',
    'body-variant': '#1e1d24',
    'on-body-variant': '#838690',
    'surface': '#1e1d24',
    'on-surface': '#838690',
    'surface-border': '#27292d',
    'navigation': '#151419',
    'on-navigation': '#ffffff',
    'discussion-icon': '#fbc02d',
    'on-discussion-icon': '#ffffff',
    'button-primary': '#3d81fc',
    'on-button-primary': '#ffffff',
    'button-secondary': '#27282f',
    'on-button-secondary': '#b8b9bf',
    'button-tertiary': '#151419',
    'on-button-tertiary': '#838690',
    'brand': '#3182ce',
    'on-brand': '#3182ce',
  })
  .colorVariant('brand', '#434960', 'navigation')
  .colorVariant('active', '#2b6cb0', 'navigation')
  .colorVariant('hover', '#474f5a', 'navigation')
  .colorVariant('pinned', '#479f4b', 'discussion-icon')
  .colorVariant('hot', '#e53e3e', 'discussion-icon')
  .colorVariant('locked', '#000000', 'discussion-icon')
;

module.exports = new ThemeBuilder()
  .asDataThemeAttribute()
  .default(mainTheme)
  // .dark(darkTheme)
;