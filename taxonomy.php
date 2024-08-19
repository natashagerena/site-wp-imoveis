<?php

	$data          = Timber::get_context();
	$data['posts'] = Timber::get_posts();
	$data['cats']  = Timber::get_terms('categorias');
	$data['slug']  = Timber::get_term(get_the_ID())->slug;

	Timber::render('archive-noticias.twig', $data);