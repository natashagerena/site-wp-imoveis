<?php
global $paged;
if (!isset($paged) || !$paged){
	$paged = 1;
}

// Query ---
$query['post_type'] = 'alugar';
$query['posts_per_page'] = 1;
$query['paged'] = $paged;
$query['tax_query']['relation'] = 'AND';
$query['meta_query']['relation'] = 'AND';

// Filtro por cidade ---
if ($_GET['cidade']) {
	$query['tax_query'][] = [
		'taxonomy' => 'cidades',
		'terms' => $_GET['cidade']
	];
}

// Filtro por finalidade ---
if ($_GET['finalidade']) {
	$query['tax_query'][] = [
		'taxonomy' => 'finalidades',
		'terms' => $_GET['finalidade']
	];
}

// Filtro por tipo ---
if ($_GET['tipo']) {
	$query['tax_query'][] = [
		'taxonomy' => 'tipos',
		'terms' => $_GET['tipo']
	];
}

// Filtro dormitorios ---
if ($_GET['dormitorios']) {
	$query['meta_query'][] = [
		'key' => 'dormitorios',
		'value' => $_GET['dormitorios'],
		'compare' => '='
	];
}

// Filtro valor alguel ---
if ($_GET['aluguel']) {
	$query['meta_query'][] = [
		'key' => 'aluguel',
		'value' => $_GET['aluguel'],
		'compare' => '<=',
	];
}

// Filtro código/tag ---
if ($_GET['codigo']) {
	$query['meta_query'][] = [
		'key' => 'codigo',
		'value' => $_GET['codigo'],
	];
}

$data                = Timber::get_context();
$data['post']        = Timber::get_post(25);
$data['tipos']       = Timber::get_terms('tipos');
$data['finalidades'] = Timber::get_terms('finalidades');
$data['cidades']     = Timber::get_terms('cidades');
$data['posts']       = new Timber\PostQuery($query);
$data['get']         = $_GET;

Timber::render('archive-alugar.twig', $data);