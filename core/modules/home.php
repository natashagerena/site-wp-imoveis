<?php

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_home_banners = new Module('acf_home_banners', 'Banners home', 0);

// Fields
$acf_home_banners->set_field('repeater', '', 'banners',
    array (
        array (
            'key'          => 'field_banners_imagem',
            'label'        => 'Imagem',
            'name'         => 'imagem',
            'type'         => 'image',
            'required'     => 1,
            'save_format'  => 'url',
            'preview_size' => 'thumbnail',
            'library'      => 'uploadedTo',
        ),
        array (
            'key'        => 'field_banners_legenda',
            'label'      => 'Legenda',
            'name'       => 'legenda',
            'type'       => 'qtranslate_text',
            'formatting' => 'none',
        ),
        array (
            'key'         => 'field_banners_link',
            'label'       => 'Link',
            'name'        => 'link',
            'type'        => 'text',
            'placeholder' => 'http://',
            'formatting'  => 'none',
        ),
    )
);

// Locations
$acf_home_banners->set_location('page', 2);

// Register
register_field_group($acf_home_banners->arguments());

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_home_propostas = new Module('acf_home_propostas', 'Propostas', 1);

// Fields
$acf_home_propostas->set_field('repeater', '', 'propostas',
    array (
        array (
            'key'        => 'field_propostas_titulo',
            'label'      => 'Título',
            'name'       => 'titulo',
            'type'       => 'qtranslate_text',
            'formatting' => 'none',
        ),
        array (
            'key'         => 'field_propostas_texto',
            'label'       => 'Texto',
            'name'        => 'texto',
            'type'        => 'qtranslate_textarea',
            'formatting'  => 'br',
        ),
    )
);
$acf_home_propostas->set_field('image', 'Imagem', 'imagem_proposta');
$acf_home_propostas->set_field('text', 'Link youtube', 'link_youtube');

// Locations
$acf_home_propostas->set_location('page', 2);

// Register
register_field_group($acf_home_propostas->arguments());

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_home_chamada = new Module('acf_home_chamada', 'Chamada', 2);

// Fields
$acf_home_chamada->set_field('qtranslate_text', 'Nome', 'nome_chamada');
$acf_home_chamada->set_field('qtranslate_text', 'Título', 'titulo_chamada');
$acf_home_chamada->set_field('qtranslate_textarea', 'Texto', 'texto_chamada');
$acf_home_chamada->set_field('image', 'Imagem', 'imagem_chamada');

// Locations
$acf_home_chamada->set_location('page', 2);

// Register
register_field_group($acf_home_chamada->arguments());

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_home_imoveissa = new Module('acf_home_imoveissa', 'imoveissa', 3);

// Fields
$acf_home_imoveissa->set_field('repeater', 'Blocos', 'blocos',
    array (
        array (
            'key'          => 'field_blocos_imagem',
            'label'        => 'Imagem',
            'name'         => 'imagem',
            'type'         => 'image',
            'required'     => 1,
            'save_format'  => 'url',
            'preview_size' => 'thumbnail',
            'library'      => 'uploadedTo',
        ),
        array (
            'key'        => 'field_blocos_titulo',
            'label'      => 'Título',
            'name'       => 'titulo',
            'type'       => 'qtranslate_text',
            'formatting' => 'none',
        ),
        array (
            'key'        => 'field_blocos_texto',
            'label'      => 'Texto',
            'name'       => 'texto',
            'type'       => 'qtranslate_textarea',
            'formatting' => 'br',
        ),
        array (
            'key'         => 'field_blocos_link',
            'label'       => 'Link',
            'name'        => 'link',
            'type'        => 'text',
            'placeholder' => 'http://',
            'formatting'  => 'none',
        ),
    )
);

// Locations
$acf_home_imoveissa->set_location('page', 2);

// Register
register_field_group($acf_home_imoveissa->arguments());