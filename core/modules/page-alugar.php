<?php

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_page_alugar = new Module('acf_page_alugar', 'Textos', 0);

// Fields
$acf_page_alugar->set_field('image', 'Banner', 'banner');
$acf_page_alugar->set_field('qtranslate_text', 'Título', 'titulo');
$acf_page_alugar->set_field('qtranslate_wysiwyg', 'Texto', 'texto');
$acf_page_alugar->set_field('qtranslate_text', 'Título 2', 'titulo_2');
$acf_page_alugar->set_field('qtranslate_wysiwyg', 'Texto 2', 'texto_2');

// Locations
$acf_page_alugar->set_location('page', 25);

// Register
register_field_group($acf_page_alugar->arguments());

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_page_alugar_chamada = new Module('acf_page_alugar_chamada', 'Chamada app', 1);

// Fields
$acf_page_alugar_chamada->set_field('qtranslate_text', 'Título', 'titulo_chamada');
$acf_page_alugar_chamada->set_field('qtranslate_textarea', 'Texto', 'texto_chamada');


// Locations
$acf_page_alugar_chamada->set_location('page', 25);

// Register
register_field_group($acf_page_alugar_chamada->arguments());
