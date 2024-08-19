<?php

	$data                = Timber::get_context();
	$data['tipos']       = Timber::get_terms('tipos');
	$data['finalidades'] = Timber::get_terms('finalidades');
	$data['cidades']     = Timber::get_terms('cidades');
	$data['post']        = Timber::get_post();

	Timber::render('single-alugar.twig', $data);