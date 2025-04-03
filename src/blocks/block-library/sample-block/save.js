/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function Save() {
	return (
		<div { ...useBlockProps.save() }>
			{ __( 'Sample Block – hello from the saved content!', 'simple-block-theme' ) }
		</div>
	);
}
