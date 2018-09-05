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
	if ( is_user_logged_in() ) {
		$professor_id = sanitize_text_field( $data['professorId'] );

		$exist_query = new WP_Query( array(
			'post_type'  => 'like',
			'author'     => get_current_user_id(),
			'meta_query' => array(
				array(
					'key'     => 'liked_professor_id',
					'compare' => '=',
					'value'   => $professor_id,
				),
			),
		) );

		if ( $exist_query->found_posts == 0 && get_post_type( $professor_id ) == 'professor' ) {
			// Create new like post.
			return wp_insert_post( array(
				'post_type'   => 'like',
				'post_status' => 'publish',
				'meta_input'  => array( 'liked_professor_id' => $professor_id ),
			) );
		} else {
			die( "Invalid professor ID" );
		}
	} else {
		die( "Only logged in users can create a like." );
	}
}

function delete_like() {
	return 'Thanks for trying to delete a like.';
}

add_action( 'rest_api_init', 'university_like_routes' );
