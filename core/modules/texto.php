<?php
// Modulo
$acf_texto = new Module('acf_texto', 'Texto', 0);

// Fields
$acf_texto->set_field('qtranslate_wysiwyg', 'Texto', 'texto');

// Locations
$acf_texto->set_location('post_type', 'noticias');
$acf_texto->set_location('page', 8);

// Register
register_field_group($acf_texto->arguments());