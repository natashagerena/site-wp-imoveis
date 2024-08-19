<?php

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_imagem_destacada = new Module('acf_imagem_destacada', 'Imagem destacada');

// Fields
$acf_imagem_destacada->set_field('image', 'Imagem', 'imagem');

// Locations
$acf_imagem_destacada->set_location('page', 26);
$acf_imagem_destacada->set_location('page', 11);
$acf_imagem_destacada->set_location('post_type', 'noticias');
$acf_imagem_destacada->set_location('post_type', 'servicos');

// Options
$acf_imagem_destacada->set_options(array(
    'position' => 'side'
));

// Register
register_field_group($acf_imagem_destacada->arguments());