<?php

function university_like_routes() {
	register_rest_route('university/v1', 'like', array(
		'methods' => 'POST',
		'callback' => 'create_like',
	));

	register_rest_route('university/v1', 'like', array(
		'methods' => 'DELETE',
		'callback' => 'delete_like',
	));
}

function create_like() {
	return 'Thanks for trying to create a like.';
}

function delete_like() {
	return 'Thanks for trying to delete a like.';
}

add_action( 'rest_api_init', 'university_like_routes' );
