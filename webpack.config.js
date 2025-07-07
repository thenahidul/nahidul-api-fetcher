const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );
const CopyPlugin = require( 'copy-webpack-plugin' );

// Define path variables
const srcDir = path.resolve( __dirname, 'src' );
const buildDir = path.resolve( __dirname, 'build' );

const adminDir = path.join( srcDir, 'admin' );
const frontendDir = path.join( srcDir, 'frontend' );

const adminImagesDir = path.join( adminDir, 'images' );
const frontendImagesDir = path.join( frontendDir, 'images' );

module.exports = {
	...defaultConfig,

	entry: {
		...defaultConfig.entry(),

		// Admin assets
		'admin/index': path.resolve( adminDir, 'js/index.js' ),
		'admin/style': path.resolve( adminDir, 'scss/index.scss' ),

		// Frontend assets
		'frontend/index': path.resolve( frontendDir, 'js/index.js' ),
		'frontend/style': path.resolve( frontendDir, 'scss/index.scss' ),
	},

	output: {
		...defaultConfig.output,
		path: buildDir,
		filename: ( pathData ) => {
			if (
				pathData.chunk?.name?.startsWith( 'blocks/' ) &&
				typeof defaultConfig.output.filename === 'function'
			) {
				return defaultConfig.output.filename( pathData );
			}
			return '[name].js';
		},
	},

	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,
			{
				test: /\.(png|jpe?g|gif|svg)$/i,
				type: 'asset/resource',
				generator: {
					filename: 'images/[name][ext]',
				},
			},
		],
	},

	plugins: [
		...(defaultConfig.plugins || []),
		new CopyPlugin({
			patterns: [
				{
					from: adminImagesDir,
					to: path.join( buildDir, 'images' ),
					noErrorOnMissing: true,
				},
				{
					from: frontendImagesDir,
					to: path.join( buildDir, 'images' ),
					noErrorOnMissing: true,
				},
			],
		}),
	],
};
