<?php

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_servicos_cadastro = new Module('acf_servicos_cadastro', 'Cadastro servicos', 0);

// Fields
$acf_servicos_cadastro->set_field('qtranslate_wysiwyg', 'Texto', 'texto');
$acf_servicos_cadastro->set_field('repeater', 'Itens', 'itens',
    array(
        array(
            'key'         => 'field_itens_foto',
            'label'       => 'Foto',
            'name'        => 'foto',
            'type'        => 'image',
            'required'    => 1,
            'save_format' => 'url',
            'library'     => 'uploadedTo',
        ),
        array(
            'key'        => 'field_itens_titulo',
            'label'      => 'Título',
            'name'       => 'titulo',
            'type'       => 'qtranslate_text',
            'formatting' => 'none',
        ),
        array(
            'key'        => 'field_itens_texto',
            'label'      => 'Texto',
            'name'       => 'texto',
            'type'       => 'qtranslate_textarea',
            'formatting' => 'br',
        ),
    )
);

// Locations
$acf_servicos_cadastro->set_location('post_type', 'servicos');

// Register
register_field_group($acf_servicos_cadastro->arguments());