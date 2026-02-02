import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Outfit", "sans-serif", ...defaultTheme.fontFamily.sans],
                display: ["Outfit", "sans-serif"],
            },
            colors: {
                brand: {
                    dark: "#0f172a", // Midnight Blue / Slate 900
                    primary: "#3b82f6", // bright blue
                    secondary: "#64748b", // Slate 500
                    accent: "#f59e0b", // Amber 500
                    light: "#f8fafc", // Slate 50
                },
            },
        },
    },

    plugins: [forms],
};
