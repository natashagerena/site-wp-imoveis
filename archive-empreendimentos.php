<?php

	$data          = Timber::get_context();
	$data['post']  = Timber::get_post(26);
	$data['posts'] = Timber::get_posts();

	Timber::render('archive-empreendimentos.twig', $data);