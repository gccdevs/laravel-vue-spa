let path = require('path');

function resolve (target) {
    return path.resolve(__dirname, '..', target);
}

module.exports = {
    // UI components aliases
    '@frontend_ui': resolve('resources/assets/js/frontend/components'),
    'frontendUtils': resolve('resources/assets/js/frontend/Utils'),
    '@backend_ui': resolve('resources/assets/js/backend/components'),
    'backendUtils': resolve('resources/assets/js/backend/Utils'),

    // Application aliases
    'src': resolve('resources/assets/js/core'),

    // styles
    'frontend_styles': resolve('resources/assets/sass/backend'),
    'backend_styles': resolve('resources/assets/sass/frontend'),

    // javascript entry
    'backend': resolve('resources/assets/js/backend'),
    'frontend': resolve('resources/assets/js/frontend'),

    // variables
    'backend_variables': resolve('resources/assets/sass/backend/_variables.scss'),
    'frontend_variables': resolve('resources/assets/sass/frontend/_variables.scss'),

    'images': resolve('resources/images')
}
