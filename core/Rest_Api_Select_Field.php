<?php
/**
 * REST API Select Field.
 *
 * @package Carbon_Field_Rest_Api_Select
 */

namespace Carbon_Field_Rest_Api_Select;

use Carbon_Fields\Field\Field;

/**
 * REST API Select Field class.
 *
 * @since 0.1.0
 */
class Rest_Api_Select_Field extends Field {

	/**
	 * Endpoint.
	 *
	 * @var string
	 * @since 0.1.0
	 */
	protected $endpoint;

	/**
	 * Set Endpoint.
	 *
	 * @param string $endpoint REST API Endpoint.
	 * @return $this
	 * @since 0.1.0
	 */
	public function set_endpoint( $endpoint ) {
		$this->endpoint = $endpoint;
		return $this;
	}

	/**
	 * Get Endpoint.
	 *
	 * @return string
	 * @since 0.1.0
	 */
	public function get_endpoint() {
		return $this->endpoint;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public static function field_type_activated() {
		$dir    = \Carbon_Field_Rest_Api_Select\DIR . '/languages/';
		$locale = get_locale();
		$path   = $dir . $locale . '.mo';

		load_textdomain( 'carbon-field-rest-api-select', $path );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return void
	 * @since 0.1.0
	 */
	public static function admin_enqueue_scripts() {
		$root_uri = \Carbon_Fields\Carbon_Fields::directory_to_url( \Carbon_Field_Rest_Api_Select\DIR );

		wp_enqueue_script( 'carbon-field-rest-api-select', $root_uri . '/assets/js/bundle.js', array( 'carbon-fields-boot' ), \Carbon_Field_Rest_Api_Select\VERSION, true );
		wp_enqueue_style( 'carbon-field-rest-api-select', $root_uri . '/assets/css/field.css', array(), \Carbon_Field_Rest_Api_Select\VERSION );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param bool $load Should the value be loaded from the database or use the value from the current instance.
	 * @return array
	 */
	public function to_json( $load ) {
		$field_data = parent::to_json( $load );

		$field_data = array_merge( $field_data, array(
			'endpoint' => $this->get_endpoint(),
		) );

		return $field_data;
	}
}
