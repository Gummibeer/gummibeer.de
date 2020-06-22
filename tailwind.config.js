module.exports = {
    purge: [
        './resources/views/**/*.blade.php',
    ],
    theme: {
        fontFamily: {
            sans: [
                'Inter',
                'system-ui',
                '-apple-system',
                'BlinkMacSystemFont',
                '"Segoe UI"',
                'Roboto',
                '"Helvetica Neue"',
                'Arial',
                '"Noto Sans"',
                'sans-serif',
                '"Apple Color Emoji"',
                '"Segoe UI Emoji"',
                '"Segoe UI Symbol"',
                '"Noto Color Emoji"',
            ],
            mono: [
                '"Fira Code"',
                'Menlo',
                'Monaco',
                'Consolas',
                '"Liberation Mono"',
                '"Courier New"',
                'monospace',
            ],
            logo: '"Permanent Marker", sans-serif',
        },
        boxShadow: {
            light: 'rgba(184, 194, 215, 0.25) 0px 4px 6px, rgba(184, 194, 215, 0.1) 0px 5px 7px',
            dark: 'rgba(15, 17, 21, 0.25) 0px 4px 6px, rgba(15, 17, 21, 0.1) 0px 5px 7px',
            none: 'none',
        },
        borderRadius: {
            0: '0',
            1: '0.25rem',
            2: '0.5rem',
            3: '0.75rem',
            4: '1rem',
            full: '100%',
        },
        extend: {
            colors: {
                black: '#000000',
                white: '#ffffff',
                brand: '#ffb300',

                snow: {
                    20: '#88888E',
                    10: '#DEDDDD',
                    0: '#FAFAFA',
                },

                night: {
                    20: '#070615',
                    10: '#12152B',
                    0: '#161B2A',
                },
            },
            screens: {
                dark: {raw: 'screen and (prefers-color-scheme: dark)'},
                light: {raw: 'screen and (prefers-color-scheme: light)'},
                print: {raw: 'print'},
            },
            listStyleType: {
                square: 'square',
                roman: 'upper-roman',
            },
            minWidth: {
                1: '0.25rem',
                2: '0.5rem',
                3: '0.75rem',
                4: '1rem',
                8: '2rem',
                12: '3rem',
                16: '4rem',
                'xs': '20rem',
                'md': '24rem',
                'lg': '32rem',
                'xl': '36rem',
                '2xl': '42rem',
            },
            inset: {
                '1/4': '25%',
                '1/2': '50%',
            }
        }
    },
    variants: {
        borderStyle: ['responsive', 'hover'],
    },
};
