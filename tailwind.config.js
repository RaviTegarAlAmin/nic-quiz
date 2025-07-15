import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                primary: {
                    100: '#FFFFFC', // Very light cream
                    200: '#FCFCF7', // Slightly off-white
                    300: '#FAF9F0', // Soft neutral
                    400: '#F7F6E9', // Warmer neutral
                    500: '#F4F1DE', // Base: quarter Spanish white
                    600: '#DBD4B4', // Muted sand
                    700: '#B8AA7D', // Faded olive
                    800: '#948051', // Earthy tone
                    900: '#6E562D', // Deep khaki
                },
                secondary: {
                    50: '#F6F0FC',
                    100: '#EDE1FA',
                    200: '#D1B8F5',
                    300: '#AF8EED',
                    400: '#6546E0',
                    500: '#1003D4',
                    600: '#0F02BF',
                    700: '#0C029E',
                    800: '#080180',
                    900: '#05005E',
                    950: '#03003D',
                },
                danger: {
                    50: '#FCF9F5',
                    100: '#FCF6ED',
                    200: '#F7E7D5',
                    300: '#F2D4BB',
                    400: '#EBAA8A',
                    500: '#E07A5F',
                    600: '#C9664D',
                    700: '#A84934',
                    800: '#873322',
                    900: '#662013',
                    950: '#421008',
                },
                warning: {
                    50: '#FFFEFA',
                    100: '#FFFDF5',
                    200: '#FCF7E3',
                    300: '#FAEFD2',
                    400: '#F7DFB0',
                    500: '#F2CC8F',
                    600: '#DBB074',
                    700: '#B58650',
                    800: '#916233',
                    900: '#6E421E',
                    950: '#47240C',
                },
                success: {
                    50: '#FAFCFC',
                    100: '#F0F7F5',
                    200: '#DDEDE8',
                    300: '#C8E0D8',
                    400: '#A1C9B9',
                    500: '#81B29A',
                    600: '#68A184',
                    700: '#488563',
                    800: '#2E6B47',
                    900: '#194F2D',
                    950: '#0B3318',
                },
            }
        },
    },
    plugins: [],
};
