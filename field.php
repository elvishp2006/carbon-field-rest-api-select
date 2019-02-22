<?php
/**
 * Carbon Field REST API Select.
 *
 * @package Carbon_Field_Rest_Api_Select
 * @version 0.2.1
 */

if ( ! function_exists( 'add_action' ) ) {
	return;
}

use Carbon_Fields\Carbon_Fields;
use Carbon_Field_Rest_Api_Select\Rest_Api_Select_Field;

define( 'Carbon_Field_Rest_Api_Select\\DIR', __DIR__ );
define( 'Carbon_Field_Rest_Api_Select\\VERSION', '0.2.1' );

Carbon_Fields::extend( Rest_Api_Select_Field::class, function( $container ) {
	return new Rest_Api_Select_Field( $container['arguments']['type'], $container['arguments']['name'], $container['arguments']['label'] );
} );
