<?php
// Modulo
$acf_color = new Module('acf_color', 'Cor', 0);

// Fields
$acf_color->set_field('color_picker', 'Cor', 'cor', array('required' => true));

// Locations
$acf_color->set_location('taxonomy', 'categorias');

// Register
register_field_group($acf_color->arguments());