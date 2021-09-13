module.exports = {
	env: {
		browser: true,
		es2021: true,
	},
	extends: [
		"eslint:recommended",
		"plugin:vue/essential",
		"plugin:@typescript-eslint/recommended",
	],
	parserOptions: {
		ecmaVersion: 12,
		parser: ["@typescript-eslint/parser", "vue-eslint-parser"],
		sourceType: "module",
	},
	plugins: ["vue", "@typescript-eslint"],
	rules: {
		"vue/no-multiple-template-root": "off",
	},
};
