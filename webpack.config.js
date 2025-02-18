/**
 * External dependencies
 */
const path = require( 'path' );
const fs = require( 'fs' );
const RemovePlugin = require( 'remove-files-webpack-plugin' );
const CopyWebpackPlugin = require( 'copy-webpack-plugin' );
const MiniCSSExtractPlugin = require( 'mini-css-extract-plugin' );
/**
 * WordPress dependencies
 */
const glob = require( 'glob' );
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );

/**
 * WordPress dependencies
 */
const { getAsBooleanFromENV } = require( '@wordpress/scripts/utils' );

// Check if the --experimental-modules flag is set.
const hasExperimentalModulesFlag = getAsBooleanFromENV(
	'WP_EXPERIMENTAL_MODULES'
);

let wpScriptsConfig, wpScriptsModulesConfig;

if ( hasExperimentalModulesFlag ) {
	[
		wpScriptsConfig,
		wpScriptsModulesConfig,
	] = require( '@wordpress/scripts/config/webpack.config' );
} else {
	wpScriptsConfig = require( '@wordpress/scripts/config/webpack.config' );
}

const skipBlocks = process.env.WP_SCRIPTS_SKIP_BLOCKS || false;

const srcDir = process.env.WP_SCRIPTS_SRC_DIR || 'src';
const outputDir = process.env.WP_SCRIPTS_OUTPUT_DIR || 'assets';
const blocksOutputDir = process.env.WP_SCRIPTS_BLOCKS_OUTPUT_DIR || 'blocks';

/**
 * Get all the root files in the indicated folder
 *
 * @param {Object} options
 * @return {Object} The object with the relative output path as the key for each
 */
function getEntries( options ) {
	const {
		root = '',
		include = '',
		outputFolder = '',
		blockDir = false,
	} = options;

	const entries = glob.sync( root + '/' + include );

	const entriesWithKeys = entries.reduce( ( acc, entry ) => {
		if ( 'index' === path.parse( entry ).name ) {
			return acc;
		}

		const _outputDir = outputFolder + '/';

		const name = blockDir
			? getBlockStylesheetName( entry )
			: path.parse( entry ).name;
		acc[ _outputDir + name ] = path.resolve( entry );
		return acc;
	}, {} );
	return entriesWithKeys;
}

/**
 * Get the name of the block stylesheet
 *
 * @param {string} filePath
 * @return {string} The name of the block stylesheet
 */
function getBlockStylesheetName( filePath ) {
	const pathParts = filePath.split( path.sep );
	if ( pathParts.length ) {
		const fileName = pathParts[ pathParts.length - 1 ];
		pathParts[ pathParts.length - 1 ] = path.parse( fileName ).name;
	}
	const blockNamespace = pathParts[ pathParts.length - 2 ];
	const blockName = pathParts[ pathParts.length - 1 ];
	return blockNamespace + '-' + blockName;
}

const themeScriptsConfig = {
	mode: wpScriptsConfig.mode,
	target: wpScriptsConfig.target,
	entry: {
		...getEntries( {
			root: `${ srcDir }/js`,
			include: '*.js',
			outputFolder: `js`,
		} ),
		...getEntries( {
			root: `${ srcDir }/scss`,
			include: '*.scss',
			outputFolder: `css`,
		} ),
	},
	output: {
		filename: '[name].js',
		chunkFilename: '[name].js?ver=[chunkhash]',
		path: path.resolve( process.cwd(), outputDir ),
	},
	resolve: wpScriptsConfig.resolve,
	module: wpScriptsConfig.module,
	optimization: wpScriptsConfig.optimization,
	stats: wpScriptsConfig.stats,
	plugins: [
		new MiniCSSExtractPlugin( {
			filename: '[name].css',
		} ),
		! process.env.WP_NO_EXTERNALS && new DependencyExtractionWebpackPlugin(),
		new RemovePlugin( {
			after: {
				log: false,
				logWarning: false,
				test: [
					{
						folder: `${ outputDir }/css`,
						recursive: true,
						method: ( absoluteItemPath ) => {
							return new RegExp( /\.js/, 'm' ).test(
								absoluteItemPath
							);
						},
					},
					{
						folder: `${ outputDir }/css`,
						recursive: true,
						method: ( absoluteItemPath ) => {
							return new RegExp( /\-rtl\.css/, 'm' ).test(
								absoluteItemPath
							);
						},
					},
					{
						folder: outputDir,
						recursive: true,
						method: ( absoluteItemPath ) => {
							return new RegExp( /\.gitkeep/, 'm' ).test(
								absoluteItemPath
							);
						},
					},
				],
			},
		} ),
	].filter( Boolean ),
};

const dirsToCopy = [ 'fonts', 'img', 'images', 'svg' ];

const filteredDirsToCopy = dirsToCopy.filter( ( dir ) =>
	fs.existsSync( path.resolve( process.cwd(), srcDir, dir ) )
);

if ( filteredDirsToCopy.length ) {
	themeScriptsConfig.plugins.push(
		new CopyWebpackPlugin( {
			patterns: filteredDirsToCopy.map( ( dir ) => ( {
				from: path.resolve( process.cwd(), srcDir, dir ),
				to: path.resolve( process.cwd(), outputDir, dir ),
			} ) ),
		} )
	);
}

if ( wpScriptsConfig.devtool ) {
	themeScriptsConfig.devtool = wpScriptsConfig.devtool;
}

const defaultExports = [ themeScriptsConfig ];

if ( ! skipBlocks ) {
	const blocksConfig = {
		...wpScriptsConfig,
		output: {
			...wpScriptsConfig.output,
			path: path.resolve( process.cwd(), blocksOutputDir ),
		},
	};

	defaultExports.push( blocksConfig );
}

if ( hasExperimentalModulesFlag ) {
	wpScriptsModulesConfig.output.path = path.resolve(
		process.cwd(),
		blocksOutputDir
	);

	defaultExports.push( wpScriptsModulesConfig );
}

module.exports = defaultExports;
