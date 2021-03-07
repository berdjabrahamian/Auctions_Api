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
                    100: '#7BA7F9',
                    200: '#4F8AF8',
                    300: '#236DF6',
                    400: '#0955E1',
                    DEFAULT: '#0845B7',
                    500: '#063B9B',
                    600: '#053181',
                    700: '#042768',
                    800: '#031D4E',
                },
                'auction-red': {
                    100: '#ff7184',
                    200: '#ff425b',
                    300: '#FF1232',
                    400: '#E2001E',
                    DEFAULT: '#DF1D1D',
                    500: '#990014',
                    600: '#800011',
                    700: '#66000E',
                    800: '#4d000a',
                },
                'auction-green': {
                    DEFAULT: '#008b6b',
                },
                "auction-platinum" : {
                    DEFAULT: "EBEBEB",
                }
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
