<?php

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_landing_page = new Module('acf_landing_page', 'Landing Page');

// Fields
$acf_landing_page->set_field('flexible_content', 'Conteúdo', 'conteudo',
    array(
        'layouts' => array(
            array(
                'label' => 'Título',
                'name' => 'titulo',
                'sub_fields' => array(
                    array(
                        'key' => 'field_landing_page_titulo',
                        'label' => 'Título',
                        'name' => 'titulo',
                        'type' => 'text',
                        'required'    => 1,
                    ),
                ),
            ),
            array(
                'label' => 'Texto',
                'name' => 'texto',
                'display' => 'row',
                'sub_fields' => array(
                    array(
                        'key' => 'field_landing_page_texto',
                        'label' => 'Texto',
                        'name' => 'texto',
                        'type' => 'wysiwyg',
                        'toolbar' => 'basic',
                        'media_upload' => 'no',
                        'required'    => 1,
                    ),
                ),
            ),
            array(
                'label' => 'Vídeo',
                'name' => 'video',
                'sub_fields' => array(
                    array(
                        'key' => 'field_landing_page_video',
                        'label' => 'Vídeo',
                        'name' => 'video',
                        'type' => 'text',
                        'placeholder' => 'http://',
                        'required'    => 1,
                    ),
                ),
            ),
            array(
                'label' => 'Imagem',
                'name' => 'imagem',
                'display' => 'row',
                'sub_fields' => array(
                    array(
                        'key' => 'field_landing_page_imagem',
                        'label' => 'Imagem',
                        'name' => 'imagem',
                        'type'        => 'image',
                        'required'    => 1,
                        'save_format' => 'url',
                        'library'     => 'uploadedTo',
                    ),
                ),
            ),
            array(
                'label' => 'CTA',
                'name' => 'cta',
                'display' => 'row',
                'sub_fields' => array(
                    array(
                        'key' => 'field_landing_page_cta_texto',
                        'label' => 'Texto',
                        'name' => 'texto',
                        'type' => 'text',
                        'required'    => 1,
                    ),
                    array(
                        'key' => 'field_landing_page_cta_link',
                        'label' => 'Link',
                        'name' => 'link',
                        'type' => 'text',
                        'placeholder' => 'http://',
                        'required'    => 1,
                    ),
                ),
            ),
        ),
    )
);
$acf_landing_page->set_field('checkbox', 'Formulário', 'formulario',
    array(
        'choices' => array (
            'habilitar' => 'Habilitar',
        ),
    )
);
$acf_landing_page->set_field('text', 'Título do formulário', 'titulo_do_formulario',
    array(
        'conditional_logic' => array (
            'status' => 1,
            'rules' => array (
                array (
                    'field' => 'field_acf_landing_page_formulario',
                    'operator' => '==',
                    'value' => 'habilitar',
                ),
            ),
            'allorany' => 'all',
        ),
    )
);
$acf_landing_page->set_field('file', 'Arquivo', 'arquivo',
    array(
        'conditional_logic' => array (
            'status' => 1,
            'rules' => array (
                array (
                    'field' => 'field_acf_landing_page_formulario',
                    'operator' => '==',
                    'value' => 'habilitar',
                ),
            ),
            'allorany' => 'all',
        ),
    )
);
$acf_landing_page->set_field('textarea', 'Texto do email', 'texto_email',
    array(
        'conditional_logic' => array (
            'status' => 1,
            'rules' => array (
                array (
                    'field' => 'field_acf_landing_page_formulario',
                    'operator' => '==',
                    'value' => 'habilitar',
                ),
            ),
            'allorany' => 'all',
        ),
    )
);

// Locations
$acf_landing_page->set_location('post_type','landing_page');

// Register
register_field_group($acf_landing_page->arguments());