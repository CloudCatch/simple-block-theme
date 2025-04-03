/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import edit from './edit';
import save from './save';
import metadata from './block.json';

import './style.scss';

const { name } = metadata;

export { metadata, name };

export const settings = {
	edit,
	save,
};

registerBlockType( { name, ...metadata }, settings );
