<?php
// Modulo
$acf_meta_tags = new Module('acf_meta_tags', 'Meta description');

// Fields
$acf_meta_tags->set_field('textarea', 'Descrição', 'meta_description');

// Locations
$acf_meta_tags->set_location('post_type', 'post');
$acf_meta_tags->set_location('post_type', 'page');

// Options
$acf_meta_tags->set_options(array(
	'position'       => 'side',
));

// Register
register_field_group($acf_meta_tags->arguments());