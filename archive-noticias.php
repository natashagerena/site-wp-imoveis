<?php

	$data          = Timber::get_context();
	$data['posts'] = Timber::get_posts();
	$data['cats']  = Timber::get_terms('categorias');

	Timber::render('archive-noticias.twig', $data);