<?php

// -----------------------------------------------------------------------------
// acf_options
// -----------------------------------------------------------------------------

// Modulo
$acf_options = new Module('acf_options', 'Opções');

// Fields
$acf_options->set_field('image', 'Logo', 'logo');
$acf_options->set_field('image', 'Logo rodapé', 'logo_rodape');
$acf_options->set_field('image', 'Favicon', 'favicon');
$acf_options->set_field('textarea', 'Endereço', 'endereco');
$acf_options->set_field('repeater', 'Telefones', 'telefones',
    array(
        array(
            'key'        => 'field_telefones_telefone',
            'label'      => 'Telefone',
            'name'       => 'telefone',
            'type'       => 'text',
            'formatting' => 'none',
        )
    )
);
$acf_options->set_field('repeater', 'Emails', 'emails',
    array(
        array(
            'key'        => 'field_emails_email',
            'label'      => 'Email',
            'name'       => 'email',
            'type'       => 'text',
            'formatting' => 'none',
        )
    )
);
$acf_options->set_field('repeater', 'Redes sociais', 'redes_sociais',
    array(
        array(
            'key'     => 'field_nome',
            'label'   => 'Nome',
            'name'    => 'nome',
            'type'    => 'select',
            'choices' => array(
                'facebook'  => 'Facebook',
                'instagram' => 'Instagram',
                'twitter'   => 'Twitter',
                'gplus'     => 'Google+',
                'linkedin'  => 'Linkedin',
                'youtube'   => 'Youtube',
            ),
        ),
        array(
            'key'        => 'field_link',
            'label'      => 'Link',
            'name'       => 'link',
            'type'       => 'text',
            'required'   => 1,
            'formatting' => 'none',
        ),
    )
);      

// Locations
$acf_options->set_location('options_page', 'acf-options');

// Register
register_field_group($acf_options->arguments());


// -----------------------------------------------------------------------------
// acf_options_add
// -----------------------------------------------------------------------------

// Modulo
$acf_options_add = new Module('acf_options_add', 'Opções adicionais', 1);

// Fields
$acf_options_add->set_field('text', 'Google Analytics', 'google_analytics');
$acf_options_add->set_field('text', 'Pixel Facebook', 'pixel_facebook');
$acf_options_add->set_field('text', 'Email para formulário', 'email_formulario');
$acf_options_add->set_field('textarea', 'Texto para formulário', 'texto_formulario', array(
    'default_value' => 'Obrigado pelo email! Em breve nossa equipe entrará em contato.'
));

// Locations
$acf_options_add->set_location('options_page', 'acf-options');

// Register
register_field_group($acf_options_add->arguments());


// -----------------------------------------------------------------------------
// acf_options_seo
// -----------------------------------------------------------------------------

// Modulo
$acf_options_seo = new Module('acf_options_seo', 'Opções SEO', 2);

// Fields
$acf_options_seo->set_field('textarea', 'Descrição', 'meta_description');
$acf_options_seo->set_field('image', 'Imagem', 'meta_imagem');

// Locations
$acf_options_seo->set_location('options_page', 'acf-options');

// Options
$acf_options_seo->set_options(array(
    'position' => 'side',
));

// Register
register_field_group($acf_options_seo->arguments());