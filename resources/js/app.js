const theme = import.meta.env.VITE_THEME_NAME || 'maxton';

import(`./${theme}/app.js`);
