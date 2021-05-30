module.exports = {
	purge: ["./app/Components/**/*.php"],
	darkMode: false,
	jit: true,
	theme: {
		extend: {},
	},
	variants: {
		extend: {},
	},
	plugins: [
		require("@tailwindcss/forms"),
		require("@tailwindcss/typography"),
	],
};
