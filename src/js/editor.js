/**
 * WordPress dependencies
 */
import domReady from '@wordpress/dom-ready';
import { registerBlockStyle } from '@wordpress/blocks';

domReady( () => {
	registerBlockStyle( 'core/button', {
		name: 'outline',
		label: 'Outline',
	} );

	registerBlockStyle( 'core/columns', {
		name: 'separator',
		label: 'Separator',
	} );

	registerBlockStyle( 'core/navigation-link', {
		name: 'button',
		label: 'Button',
	} );
} );
