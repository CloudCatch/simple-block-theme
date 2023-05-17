wp.domReady(() => {
	wp.blocks.registerBlockStyle('core/button', {
		name: 'outline',
		label: 'Outline',
	});

	wp.blocks.registerBlockStyle('core/columns', {
		name: 'separator',
		label: 'Separator',
	});

	wp.blocks.registerBlockStyle('core/navigation-link', {
		name: 'button',
		label: 'Button',
	});
});
