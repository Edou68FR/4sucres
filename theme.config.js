const { ThemeBuilder, Theme } = require('tailwindcss-theming');

const mainTheme = new Theme()
  .default()
  .colors({
    'body': '#edeff4',
    'on-body': '#676f7f',
    'surface': '#ffffff',
    'on-surface': '#676f7f',
    'navigation': '#1f2631',
    'on-navigation': '#e8e9ea',
  })
  .colorVariant('active', '#474f5a', 'navigation')
  .colorVariant('hover', '#474f5a', 'navigation');
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