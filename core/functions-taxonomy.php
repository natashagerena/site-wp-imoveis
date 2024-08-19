<?php

// -----------------------------------------------------------------------------
// Class Taxonomy
// -----------------------------------------------------------------------------
class Taxonomy {


	protected $labels = array();
	protected $arguments = array();

	// Construct taxonomy
	public function __construct( $menu_name, $name, $slug, $object_type ) {
		$this->menu_name   = $menu_name;
		$this->name        = $name;
		$this->slug        = $slug;
		$this->object_type = $object_type;

		// Register taxonomy
		add_action( 'init', array( &$this, 'register_taxonomy' ) );
	}

	// Custom labels
	public function set_labels( $labels = array() ) {
		$this->labels = $labels;
	}

	// Custom arguments
	public function set_arguments( $arguments = array() ) {
		$this->arguments = $arguments;
	}

	// Labels
	protected function labels() {
		$default = array(
			'name'          => sprintf($this->menu_name, $this->name ),
			'add_new_item'  => sprintf('Adicionar %s', $this->name ),
		);

		return array_merge( $default, $this->labels );
	}

	// Arguments
	protected function arguments() {
		$default = array(
			'labels'            => $this->labels(),
			'hierarchical'      => true, // Like categories.
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
            'query_var'         => false,
		);

		return array_merge( $default, $this->arguments );
	}

	// Register taxonomy
	public function register_taxonomy() {
		register_taxonomy( $this->slug, $this->object_type, $this->arguments() );
	}
}
