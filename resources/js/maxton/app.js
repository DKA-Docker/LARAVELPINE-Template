const theme = import.meta.env.VITE_THEME_NAME || 'maxton';

import './bootstrap';

import "./assets/pace.min.js"
/** library JS **/
import './assets/bootstrap.bundle.min.js';
import 'jquery/dist/jquery.min.js';
/** Imported Plugin**/
import (`../../plugins/${theme}/simplebar/js/simplebar.min.js`);
import (`../../plugins/${theme}/peity/jquery.peity.min.js`);
/** Action for main asset in js client template  **/
import './assets/main.js';
