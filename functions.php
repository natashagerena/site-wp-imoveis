<?php

// -----------------------------------------------------------------------------
//  API Key Google Maps
// -----------------------------------------------------------------------------
$api_maps = '';


// -----------------------------------------------------------------------------
// Includes 
// -----------------------------------------------------------------------------
include_once "core/helpers.php";
include_once "core/functions-modules.php";
include_once "core/functions-cpt.php";
include_once "core/functions-taxonomy.php";
include_once "core/functions-contact-form-front-end.php";
include_once "core/functions-contact-form.php";

// Admin
include_once "core/functions-admin.php";


// -----------------------------------------------------------------------------
// Incluo algumas informações no contexto do Timber
// -----------------------------------------------------------------------------
function add_to_context($data) {

    // Páginas
    $data['home'] = Timber::get_post(2);
    $data['imoveis24'] = Timber::get_post(12);
	$data['noticias'] = Timber::get_posts('post_type=noticias&posts_per_page=3');

    // Formulários
    global $form, $form_info, $form_amigo;
    $data['form'] = $form->render();
    $data['form_info'] = $form_info->render();
    $data['form_amigo'] = $form_amigo->render();
    $data['form_info_before'] = $form_info->render_before();
    $data['form_info_after'] = $form_info->render_after();


    // Return
    return $data;
}
add_filter('timber_context', 'add_to_context');


// -----------------------------------------------------------------------------
// Forms
// -----------------------------------------------------------------------------
$email = get_field('email_formulario', 'option');

// Contact Form construct
$form = new Contact_Form( 'form', $email );

// Fields
$form->set_field( 
	'text', 
	'nome', 
	'Nome', 
	true, 
	array(
		'attributes' => array(
			'placeholder' => 'Nome'
		)
	)
);
$form->set_field( 
	'email', 
	'email', 
	'E-mail', 
	true, 
	array(
		'attributes' => array(
			'placeholder' => 'E-mail'
		)
	)
);
$form->set_field( 
	'text', 
	'telefone', 
	'Telefone', 
	true, 
	array(
		'attributes' => array(
			'placeholder' => 'Whatsapp',
			'class'       => 'telefone',
		)
	)
);
$form->set_field( 
	'select', 
	'sobre', 
	'Sobre', 
	true, 
	array(
		'attributes' => array(
			'placeholder' => 'Sobre'
		),
		'options' => array(
			'' => 'Selecione a finalidade',
			'Informações de imóveis' => 'Informações de imóveis',
			'Sugestões / reclamações' => 'Sugestões / reclamações',
			'App imoveis 24 horas' => 'App imoveis 24 horas',
			'Locação' => 'Locação'
		),
	)
);
$form->set_field( 
	'text', 
	'assunto', 
	'Assunto', 
	true, 
	array(
		'attributes' => array(
			'placeholder' => 'Assunto'
		)
	)
);
$form->set_field( 
	'textarea', 
	'mensagem', 
	'Mensagem', 
	true, 
	array(
		'attributes' => array(
			'placeholder' => 'Mensagem'
		)
	)
);

// Informacoes para envio
$form->set_subject( 'Formulário de contato' );
$form->set_reply_to( 'email' );

// -----------------------------------------------------------------------------
// Contact Form construct
$form_info = new Contact_Form( 'form_info', $email );

// Fields
$form_info->set_field( 
	'text', 
	'nome', 
	'Nome', 
	true, 
	array(
		'attributes' => array(
			'placeholder' => 'Meu nome'
		)
	)
);
$form_info->set_field( 
	'email', 
	'email', 
	'E-mail', 
	true, 
	array(
		'attributes' => array(
			'placeholder' => 'melhor@email'
		)
	)
);
$form_info->set_field( 
	'text', 
	'telefone', 
	'Telefone', 
	true, 
	array(
		'attributes' => array(
			'placeholder' => '(00) 00000-0000',
			'class'       => 'telefone',
		)
	)
);
$form_info->set_field( 
	'text', 
	'assunto', 
	'Assunto', 
	true
);
$form_info->set_field( 
	'textarea', 
	'mensagem', 
	'Mensagem', 
	true, 
	array(
		'attributes' => array(
			'placeholder' => 'Mensagem'
		)
	)
);

// Informacoes para envio
$form_info->set_subject( 'Formulário - Alugar' );
$form_info->set_reply_to( 'email' );

// -----------------------------------------------------------------------------
// Contact Form construct
$form_amigo = new Contact_Form( 'form_amigo', $email );

$form_amigo->set_field('text', 'nome', '', true, [
	'attributes' => [
		'placeholder' => 'Meu nome'
	]
]);

$form_amigo->set_field('email', 'email', '', true, [
	'attributes' => [
		'placeholder' => 'meu@email'
	]
]);

$form_amigo->set_field('text', 'nome_amigo', '', true, [
	'attributes' => [
		'placeholder' => 'Nome do amigo'
	]
]);

$form_amigo->set_field('email', 'email_amigo', '', true, [
	'attributes' => [
		'placeholder' => 'emaildoamigo@email'
	]
]);

$form_amigo->set_field( 'textarea', 'mensagem', '', true, [
	'attributes' => [
		'placeholder' => 'Mensagem'
	]
]);

// Informacoes para envio
$form_amigo->set_subject( 'Formulário - Alugar' );
$form_amigo->set_reply_to( 'email' );


// -----------------------------------------------------------------------------
// CPTs
// -----------------------------------------------------------------------------
$cpt_empreendimentos = new Custom_Post_Type( 'Empreendimentos', 'Empreendimento', 'empreendimentos' );
$cpt_empreendimentos->set_arguments(array(
	'taxonomies' => array('post_tag')
));
$cpt_alugar 		 = new Custom_Post_Type( 'Alugar', 'Imóvel', 'alugar' );
$cpt_alugar->set_arguments(array(
	'taxonomies' => array('post_tag')
));
$cpt_noticias 		 = new Custom_Post_Type( 'Notícias', 'Notícia', 'noticias' );
$cpt_servicos 		 = new Custom_Post_Type( 'Serviços', 'Serviço', 'servicos' );


$taxonomy_noticias    = new Taxonomy('Categorias', 'Categoria', 'categorias', 'noticias');
$taxonomy_cidades     = new Taxonomy('Cidade', 'Cidade', 'cidades', 'alugar');
$taxonomy_finalidades = new Taxonomy('Finalidade', 'Finalidade', 'finalidades', 'alugar');
$taxonomy_tipos       = new Taxonomy('Tipo', 'Tipo', 'tipos', 'alugar');
