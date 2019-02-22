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
 */
class Rest_Api_Select_Field extends Field {

	/**
	 * Endpoint.
	 *
	 * @var string
	 */
	protected $endpoint;

	/**
	 * Endpoint label path.
	 *
	 * @var string
	 */
	protected $endpoint_label_path = 'title.rendered';

	/**
	 * Endpoint value path.
	 *
	 * @var string
	 */
	protected $endpoint_value_path = 'id';

	/**
	 * Endpoint search param.
	 *
	 * @var string
	 */
	protected $endpoint_search_param = 'search';

	/**
	 * Set Endpoint.
	 *
	 * @param string $endpoint REST API Endpoint.
	 * @return $this
	 */
	public function set_endpoint( $endpoint ) {
		$this->endpoint = $endpoint;
		return $this;
	}

	/**
	 * Get Endpoint.
	 *
	 * @return string
	 */
	public function get_endpoint() {
		return $this->endpoint;
	}

	/**
	 * Set endpoint label path.
	 *
	 * @param string $endpoint_label_path Endpoint label path.
	 * @return $this
	 */
	public function set_endpoint_label_path( $endpoint_label_path ) {
		$this->endpoint_label_path = $endpoint_label_path;
		return $this;
	}

	/**
	 * Get endpoint label path.
	 *
	 * @return string
	 */
	public function get_endpoint_label_path() {
		return $this->endpoint_label_path;
	}

	/**
	 * Set endpoint value path.
	 *
	 * @param string $endpoint_value_path Endpoint value path.
	 * @return $this
	 */
	public function set_endpoint_value_path( $endpoint_value_path ) {
		$this->endpoint_value_path = $endpoint_value_path;
		return $this;
	}

	/**
	 * Get endpoint value path.
	 *
	 * @return string
	 */
	public function get_endpoint_value_path() {
		return $this->endpoint_value_path;
	}

	/**
	 * Set endpoint search param.
	 *
	 * @param string $endpoint_search_param Endpoint search param.
	 * @return $this
	 */
	public function set_endpoint_search_param( $endpoint_search_param ) {
		$this->endpoint_search_param = $endpoint_search_param;
		return $this;
	}

	/**
	 * Get endpoint search param.
	 *
	 * @return string
	 */
	public function get_endpoint_search_param() {
		return $this->endpoint_search_param;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return void
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

		$field_data = array_merge(
			$field_data,
			array(
				'endpoint'              => $this->get_endpoint(),
				'endpoint_label_path'   => $this->get_endpoint_label_path(),
				'endpoint_value_path'   => $this->get_endpoint_value_path(),
				'endpoint_search_param' => $this->get_endpoint_search_param(),
			)
		);

		return $field_data;
	}
}
