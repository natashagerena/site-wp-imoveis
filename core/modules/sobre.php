<?php

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_sobre = new Module('acf_sobre', 'Sobre', 0);

// Fields
$acf_sobre->set_field('image', 'Banner', 'banner');
$acf_sobre->set_field('qtranslate_text', 'Título', 'titulo');
$acf_sobre->set_field('qtranslate_wysiwyg', 'Texto', 'texto');

// Locations
$acf_sobre->set_location('page', 9);

// Register
register_field_group($acf_sobre->arguments());
