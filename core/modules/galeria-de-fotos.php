<?php

// -----------------------------------------------------------------------------
// Register
// -----------------------------------------------------------------------------
// Modulo
$acf_galeria_de_fotos = new Module('acf_galeria_de_fotos', 'Galeria de fotos',10);

// Fields
$acf_galeria_de_fotos->set_field('repeater', 'Fotos', 'fotos',
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

// Locations
$acf_galeria_de_fotos->set_location('page',9);
$acf_galeria_de_fotos->set_location('post_type', 'noticias');

// Register
register_field_group($acf_galeria_de_fotos->arguments());