const mix = require("laravel-mix");

mix.ts("resources/js/app.ts", "public/js")
	.vue({ version: 3 })
	.sass("resources/scss/app.scss", "public/css");
