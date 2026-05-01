/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                navy:   '#0F172A',
                steel:  '#0369A1',
                teal:   '#0F766E',
                cta:    '#2563EB',
                cream:  '#F8FAFC',
                softbg: '#EFF6FF',
                body:   '#0F172A',
                muted:  '#475569',
                border: '#D8E3F0',
            },
            fontFamily: {
                display: ['"Libre Bodoni"', 'Georgia', 'serif'],
                heading: ['"Libre Bodoni"', 'Georgia', 'serif'],
                sans:    ['"Public Sans"', 'system-ui', 'sans-serif'],
            },
            maxWidth: {
                'screen-xl': '1200px',
            },
            boxShadow: {
                'card':       '0 4px 20px rgba(0,0,0,0.08)',
                'card-hover': '0 8px 40px rgba(0,0,0,0.13)',
                'hero':       '0 20px 60px rgba(24,26,63,0.18)',
            },
            typography: {
                DEFAULT: {
                    css: {
                        color: '#2C2C3E',
                        a: { color: '#2563EB' },
                        h1: { fontFamily: '"Libre Bodoni", Georgia, serif' },
                        h2: { fontFamily: '"Libre Bodoni", Georgia, serif' },
                        h3: { fontFamily: '"Libre Bodoni", Georgia, serif' },
                    },
                },
            },
        },
    },
    plugins: [],
};
