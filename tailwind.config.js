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
            }
        },
    },
    variants: {
        extend: {
            zIndex: ['hover', 'active'],
        },
    },
    plugins: [],
}
