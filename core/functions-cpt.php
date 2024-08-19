<?php

// -----------------------------------------------------------------------------
// Class Custom post type
// -----------------------------------------------------------------------------
class Custom_Post_Type {

	protected $labels    = array();
	protected $arguments = array();

	// Construct post type
	public function __construct( $menu_name, $name, $slug ) {
		$this->menu_name = $menu_name;
		$this->name      = $name;
		$this->slug      = $slug;

		// Register post type
		add_action( 'init', array( &$this, 'register_post_type' ) );
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
			'name'          => sprintf( $this->menu_name, $this->name ),
			'singular_name' => sprintf( '%s', $this->name ),
			'view_item'     => sprintf( 'Ver %s', $this->name ),
			'edit_item'     => sprintf( 'Editar %s', $this->name ),
			'search_items'  => sprintf( 'Buscar %s', $this->name ),
			'update_item'   => sprintf( 'Atualizar %s', $this->name ),
			'menu_name'     => sprintf( $this->menu_name, $this->name ),
			'add_new'       => sprintf( 'Adicionar %s', $this->name ),
			'add_new_item'  => sprintf( 'Adicionar %s', $this->name )
		);

		return array_merge( $default, $this->labels );
	}

	// Arguments
	protected function arguments() {
		$default = array(
			'labels'              => $this->labels(),
			'hierarchical'        => false,
			'supports'            => array( 'title' ),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post'
		);

		return array_merge( $default, $this->arguments );
	}

	// Register CPT
	public function register_post_type() {
		register_post_type( $this->slug, $this->arguments() );
	}
}
