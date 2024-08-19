<?php

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_page_alugar = new Module('acf_page_alugar', 'Textos servicos', 0);

// Fields
$acf_page_alugar->set_field('image', 'Banner', 'banner');
$acf_page_alugar->set_field('qtranslate_text', 'Título', 'titulo');
$acf_page_alugar->set_field('qtranslate_text', 'Subtitulo', 'subtitulo');
$acf_page_alugar->set_field('qtranslate_wysiwyg', 'Texto', 'texto');
$acf_page_alugar->set_field('repeater', 'Chamadas', 'chamadas',
    array(
        array(
            'key'         => 'field_chamadas_foto',
            'label'       => 'Foto',
            'name'        => 'foto',
            'type'        => 'image',
            'required'    => 1,
            'save_format' => 'url',
            'library'     => 'uploadedTo',
        ),
        array(
            'key'        => 'field_chamadas_titulo',
            'label'      => 'Título',
            'name'       => 'titulo',
            'type'       => 'qtranslate_text',
            'formatting' => 'none',
        ),
        array(
            'key'        => 'field_chamadas_texto',
            'label'      => 'Texto',
            'name'       => 'texto',
            'type'       => 'qtranslate_textarea',
            'formatting' => 'br',
        ),
        array(
            'key'        => 'field_chamadas_link',
            'label'      => 'Link',
            'name'       => 'link',
            'type'       => 'link',
        ),
    )
);


// Locations
$acf_page_alugar->set_location('page', 10);

// Register
register_field_group($acf_page_alugar->arguments());
