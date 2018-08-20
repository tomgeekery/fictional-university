<?php

function university_register_search() {
	register_rest_route( 'university/v1', 'search', array(
		'methods'  => WP_REST_SERVER::READABLE,
		'callback' => 'university_search_results',
	) );
}

function university_search_results( $data ) {
	$professors = new WP_Query( array(
		'post_type' => 'professor',
		's'         => sanitize_text_field( $data['term'] ),
	) );

	$professor_results = array();

	while ( $professors->have_posts() ) {
		$professors->the_post();

		array_push( $professor_results, array(
			'title'     => get_the_title(),
			'permalink' => get_the_permalink(),
		) );
	}

	return $professor_results;
}

add_action( 'rest_api_init', 'university_register_search' );