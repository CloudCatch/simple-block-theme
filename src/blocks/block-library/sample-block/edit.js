/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import './editor.scss';

export default function Edit() {
	return (
		<div { ...useBlockProps() }>
			{ __( 'Sample Block – hello from the editor!', 'simple-block-theme' ) }
		</div>
	);
}
