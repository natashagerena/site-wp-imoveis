<?php

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_imoveis24 = new Module('acf_imoveis24', 'imoveis24horas', 0);

// Fields
$acf_imoveis24 ->set_field('tab', 'Banner','tab_banner',array('placement' => 'left'));
$acf_imoveis24->set_field('image', 'Banner', 'banner');
$acf_imoveis24->set_field('qtranslate_text', 'Título 1', 'titulo_1');
$acf_imoveis24->set_field('qtranslate_text', 'Título 2', 'titulo_2');
$acf_imoveis24->set_field('qtranslate_wysiwyg', 'Texto', 'texto');

$acf_imoveis24 ->set_field('tab', 'Chamada','tab_chamada',array('placement' => 'left'));
$acf_imoveis24->set_field('qtranslate_text', 'Título chamada', 'titulo_chamada');
$acf_imoveis24->set_field('qtranslate_textarea', 'Texto chamada', 'texto_chamada');
$acf_imoveis24->set_field('repeater', 'Etapas', 'etapas',
    array (
        array (
            'key'          => 'field_etapas_imagem',
            'label'        => 'Imagem',
            'name'         => 'imagem',
            'type'         => 'image',
            'required'     => 1,
            'save_format'  => 'url',
            'preview_size' => 'thumbnail',
            'library'      => 'uploadedTo',
        ),
        array (
            'key'        => 'field_etapas_titulo',
            'label'      => 'Título',
            'name'       => 'titulo',
            'type'       => 'qtranslate_text',
            'formatting' => 'none',
        ),
        array (
            'key'        => 'field_etapas_texto',
            'label'      => 'Texto',
            'name'       => 'texto',
            'type'       => 'qtranslate_textarea',
            'formatting' => 'br',
        ),
        array (
            'key'        => 'field_etapas_link',
            'label'      => 'Link',
            'name'       => 'link',
            'type'       => 'link',
        ),
    )
);
$acf_imoveis24->set_field('image', 'Imagem chamada', 'imagem_chamada');

$acf_imoveis24 ->set_field('tab', 'Chamada 2','tab_chamada2',array('placement' => 'left'));
$acf_imoveis24->set_field('text', 'Link youtube', 'link_youtube');
$acf_imoveis24->set_field('image', 'Imagem chamada2', 'Imagem_chamada2');

$acf_imoveis24 ->set_field('tab', 'Solicite','tab_solicite',array('placement' => 'left'));
$acf_imoveis24->set_field('qtranslate_text', 'Título solicite', 'titulo_solicite');
$acf_imoveis24->set_field('qtranslate_textarea', 'Texto solicite', 'texto_solicite');
$acf_imoveis24->set_field('link', 'Link login', 'link_login');
$acf_imoveis24->set_field('link', 'Link cadastre', 'link_cadastre');

// Locations
$acf_imoveis24->set_location('page', 12);

// Register
register_field_group($acf_imoveis24->arguments());
