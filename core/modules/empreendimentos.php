<?php

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_empreendimentos_cadastro = new Module('acf_empreendimentos_cadastro', 'Cadastro empreendimentos', 0);

// Fields
$acf_empreendimentos_cadastro->set_field('qtranslate_text', 'Subtitulo', 'subtitulo');
$acf_empreendimentos_cadastro->set_field('repeater', 'Fotos', 'fotos',
    array(
        array(
            'key'         => 'field_fotos_foto',
            'label'       => 'Foto',
            'name'        => 'foto',
            'type'        => 'image',
            'required'    => 1,
            'save_format' => 'url',
            'library'     => 'uploadedTo',
        ),
        array(
            'key'        => 'field_fotos_legenda',
            'label'      => 'Legenda',
            'name'       => 'legenda',
            'type'       => 'text',
            'formatting' => 'none',
        ),
    )
);
$acf_empreendimentos_cadastro->set_field('qtranslate_wysiwyg', 'Texto', 'texto');
$acf_empreendimentos_cadastro->set_field('image', 'Imagem full', 'imagem_full');

// Locations
$acf_empreendimentos_cadastro->set_location('post_type', 'empreendimentos');

// Register
register_field_group($acf_empreendimentos_cadastro->arguments());

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_empreendimentos_ficha = new Module('acf_empreendimentos_ficha', 'Ficha tecnica empreendimentos', 1);

// Fields
$acf_empreendimentos_ficha->set_field('text', 'Bairro', 'bairro');
$acf_empreendimentos_ficha->set_field('textarea', 'Endereço', 'endereco');
$acf_empreendimentos_ficha->set_field('text', 'Área terreno', 'area_terreno');
$acf_empreendimentos_ficha->set_field('text', 'Área construção', 'area_construcao');
$acf_empreendimentos_ficha->set_field('text', 'Área útil', 'area_util');
$acf_empreendimentos_ficha->set_field('text', 'Área total', 'area_total');
$acf_empreendimentos_ficha->set_field('text', 'Condição do imóvel', 'condicao_do_imovel');
$acf_empreendimentos_ficha->set_field('text', 'Ponto de referência', 'ponto_de_referencia');
$acf_empreendimentos_ficha->set_field('repeater', 'Ficha', 'tags',
    array(
        array(
            'key'        => 'field_tags_tag',
            'label'      => 'Tag',
            'name'       => 'tag',
            'type'       => 'text',
            'formatting' => 'none',
        ),
    )
);

// Locations
$acf_empreendimentos_ficha->set_location('post_type', 'empreendimentos');

// Register
register_field_group($acf_empreendimentos_ficha->arguments());
