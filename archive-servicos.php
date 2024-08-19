<?php

	$data          = Timber::get_context();
	$data['post']  = Timber::get_post(10);
	$data['posts'] = Timber::get_posts();

	Timber::render('archive-servicos.twig', $data);