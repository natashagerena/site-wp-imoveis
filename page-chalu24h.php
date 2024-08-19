<?php

	$data         = Timber::get_context();
	$data['post'] = Timber::get_post();

	Timber::render('page-imoveis24h.twig', $data);