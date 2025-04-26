import defaultTheme from "tailwindcss/defaultTheme";
import daisyui from "daisyui";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    // daisyUI config
    daisyui: {
        themes: [
            {
                light: {
                    ...require("daisyui/src/theming/themes")["light"],
                    primary: "#FFC83D", // Sunflower Yellow (Energetic & Optimistic)
                    secondary: "#FF6B35", // Vibrant Tangerine (Energetic & Motivating)
                    accent: "#4CAF50", // Fresh Green (Growth & New Beginnings)
                    neutral: "#374151", // Charcoal Gray (Strong & Balanced)
                    "base-100": "#F2F2F2",
                    info: "#3B82F6", // Bright Blue (Trust & Positivity)
                    success: "#22C55E", // Bright Green (Growth & Accomplishment)
                    warning: "#FACC15", // Golden Yellow (Attention & Enthusiasm)
                    error: "#EF4444", // Bold Red (Alert & Action)
                },
            },
        ], // false: only light + dark | true: all themes | array: specific themes like this ["light", "dark", "cupcake"]
        darkTheme: "dark", // name of one of the included themes for dark mode
        base: true, // applies background color and foreground color for root element by default
        styled: true, // include daisyUI colors and design decisions for all components
        utils: true, // adds responsive and modifier utility classes
        prefix: "", // prefix for daisyUI classnames (components, modifiers and responsive class names. Not colors)
        logs: true, // Shows info about daisyUI version and used config in the console when building your CSS
        themeRoot: ":root", // The element that receives theme color CSS variables
    },

    theme: {
        extend: {
            fontFamily: {
                rethink: ["Rethink Sans", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "primary-50": "#FFFAE5", // Lightest shade of Sunflower Yellow
                "primary-100": "#FFEBA1", // Light shade of Sunflower Yellow
                "primary-200": "#FFC83D", // Sunflower Yellow
                "primary-300": "#FBBF24", // Medium shade of Sunflower Yellow
                "primary-400": "#F59E0B", // Darker shade of Sunflower Yellow
                "primary-500": "#D97706", // Darkest shade of Sunflower Yellow
                "secondary-50": "#FFF8E1", // Lightest shade of Vibrant Tangerine
                "secondary-100": "#FFEDD5", // Light shade of Vibrant Tangerine
                "secondary-200": "#FF6B35", // Vibrant Tangerine
                "secondary-300": "#F97316", // Medium shade of Vibrant Tangerine
                "secondary-400": "#EA580C", // Darker shade of Vibrant Tangerine
                "secondary-500": "#C2410C", // Darkest shade of Vibrant Tangerine
                "accent-50": "#E6F4EA", // Lightest shade of Fresh Green
                "accent-100": "#D1FAE5", // Light shade of Fresh Green
                "accent-200": "#4CAF50", // Fresh Green
                "accent-300": "#34D399", // Medium shade of Fresh Green
                "accent-400": "#10B981", // Darker shade of Fresh Green
                "accent-500": "#059669", // Darkest shade of Fresh Green
            },
        },
    },

    plugins: [daisyui],
};
