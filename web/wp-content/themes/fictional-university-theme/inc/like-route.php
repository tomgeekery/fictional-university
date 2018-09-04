<?php

function university_like_routes() {
	register_rest_route( 'university/v1', 'like', array(
		'methods'  => 'POST',
		'callback' => 'create_like',
	) );

	register_rest_route( 'university/v1', 'like', array(
		'methods'  => 'DELETE',
		'callback' => 'delete_like',
	) );
}

function create_like( $data ) {
	$professor_id = sanitize_text_field( $data['professorId'] );

	// Create new like post.
	wp_insert_post( array(
		'post_type'   => 'like',
		'post_status' => 'publish',
		'meta_input'  => array( 'liked_professor_id' => $professor_id ),
	) );
}

function delete_like() {
	return 'Thanks for trying to delete a like.';
}

add_action( 'rest_api_init', 'university_like_routes' );
