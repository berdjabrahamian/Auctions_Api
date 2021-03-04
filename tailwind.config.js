const colors = require('tailwindcss/colors');

module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            'boxShadow': {
                dp0: '0 0 1px rgba(0,0,0,0.2)',
                dp2: '0 0 0 rgba(0,0,0,0.1), 0 1px 1px rgba(0,0,0,0.2), 0 2px 3px rgba(0,0,0,0.12)',
                dp4: '0 0 1px rgba(0,0,0,0.2), 0 2px 4px rgba(0,0,0,0.12), 0 4px 8px rgba(0,0,0,0.12)',
                dp6: '0 0 1px rgba(0,0,0,0.2), 0 2px 4px rgba(0,0,0,0.12), 0 4px 8px rgba(0,0,0,0.12), 0 8px 16px rgba(0,0,0,0.12)',
                dp8: '0 0 1px rgba(0,0,0,0.2), 0 2px 4px rgba(0,0,0,0.12), 0 4px 8px rgba(0,0,0,0.12), 0 8px 16px rgba(0,0,0,0.12), 0 16px 32px rgba(0,0,0,0.12)',
                dp10: '0 0 1px rgba(0,0,0,0.2), 0 4px 8px rgba(0,0,0,0.12), 0 8px 16px rgba(0,0,0,0.12), 0 16px 32px rgba(0,0,0,0.12), 0 32px 64px rgba(0,0,0,0.12)',
            },
            'colors': {
                gray: colors.trueGray,
                'auction-blue': {
                    100: '#9DA9EB',
                    200: '#7C8CE4',
                    300: '#5C6FDE',
                    400: '#3B52D7',
                    DEFAULT: '#0845B7',
                    500: '#2236A7',
                    600: '#1C2D8B',
                    700: '#17246F',
                    800: '#111B53',
                },
                'auction-red': {
                    100: '#FF7184',
                    200: '#FF425B',
                    300: '#FF1232',
                    400: '#E2001E',
                    DEFAULT: '#B40017',
                    500: '#990014',
                    600: '#800011',
                    700: '#66000E',
                    800: '#4D000A',
                },
                'auction-green': {
                    DEFAULT: '#008b6b',
                },
            },
        },
    },
    variants: {
        extend: {
            zIndex: ['hover', 'active'],
        },
    },
    plugins: [],
}
