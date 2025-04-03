<?php
/**
 * Block Library: Sample Block
 * 
 * Use this file if you want to render the block server side, vs from
 * the saved content in the block editor (what is in save.js).
 * 
 * You will need to add "render": "file:./render.php" to the block.json
 * if you want to use this file.
 * 
 * If you will not be rendering the block server side, delete this file.
 * 
 * @var array $attributes Attributes for the block.
 * @var string $content Block content.
 * @var WP_Block $block The block instance.
 * 
 * @package SimpleBlockTheme
 */

?>

<div <?php echo get_block_wrapper_attributes(); ?>>
	<!-- Do something -->
</div>
