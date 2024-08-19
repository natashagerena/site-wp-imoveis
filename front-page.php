<?php

	$data         = Timber::get_context();
	$data['post'] = Timber::get_post();
	$data['imoveis'] = Timber::get_posts('post_type=alugar&posts_per_page=6');

	Timber::render('front-page.twig', $data);