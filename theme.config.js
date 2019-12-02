const { ThemeBuilder, Theme } = require('tailwindcss-theming');

const mainTheme = new Theme()
  .default()
  .colors({
    'body': '#ffffff',
    'on-body': '#676f7f',
    'body-border': '#e8eaf0',
    'surface': '#f1f5f8',
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
  })
  .colorVariant('active', '#474f5a', 'navigation')
  .colorVariant('hover', '#474f5a', 'navigation')
  .colorVariant('pinned', '#479f4b', 'discussion-icon')
  .colorVariant('hot', '#e53e3e', 'discussion-icon')
  .colorVariant('locked', '#000000', 'discussion-icon')
;

// const darkTheme = new Theme()
//   .colors({
//     'body': '#1c1d1f',
//     'on-body': '#bbb6ac',
//     'surface': '#181a1b',
//     'on-surface': '#c9c5bd',
//     'navigation': '#010101',
//     'on-navigation': '#e8e9ea',
//   })
//   .colorVariant('active', '#474f5a', 'navigation')
//   .colorVariant('hover', '#474f5a', 'navigation');
// ;

module.exports = new ThemeBuilder()
  .asDataThemeAttribute()
  .default(mainTheme);
  // .dark(darkTheme);