<?php

function university_register_search() {
	register_rest_route( 'university/v1', 'search', array(
		'methods'  => WP_REST_SERVER::READABLE,
		'callback' => 'university_search_results',
	) );
}

function university_search_results( $data ) {
	$main_query = new WP_Query( array(
		'post_type' => array( 'post', 'page', 'professor', 'program', 'campus', 'event' ),
		's'         => sanitize_text_field( $data['term'] ),
	) );

	$results = array(
		'general_info' => array(),
		'professors'   => array(),
		'programs'     => array(),
		'events'       => array(),
		'campuses'     => array(),
	);

	while ( $main_query->have_posts() ) {
		$main_query->the_post();

		if ( get_post_type() == 'post' or get_post_type() == 'page' ) {
			array_push( $results['general_info'], array(
				'title'       => get_the_title(),
				'permalink'   => get_the_permalink(),
				'post_type'   => get_post_type(),
				'author_name' => get_the_author(),
			) );
		}

		if ( get_post_type() == 'professor' ) {
			array_push( $results['professors'], array(
				'title'     => get_the_title(),
				'permalink' => get_the_permalink(),
				'image'     => get_the_post_thumbnail_url( 0, 'professorLandscape' ),
			) );
		}

		if ( get_post_type() == 'program' ) {
			array_push( $results['programs'], array(
				'title'     => get_the_title(),
				'permalink' => get_the_permalink(),
			) );
		}

		if ( get_post_type() == 'campus' ) {
			array_push( $results['campuses'], array(
				'title'     => get_the_title(),
				'permalink' => get_the_permalink(),
			) );
		}

		if ( get_post_type() == 'event' ) {
			$event_date = new DateTime( get_field( 'event_date' ) );

			if ( has_excerpt() ) {
				$description = get_the_excerpt();
			} else {
				$description = wp_trim_words( get_the_content(), 18 );
			}

			array_push( $results['events'], array(
				'title'       => get_the_title(),
				'permalink'   => get_the_permalink(),
				'month'       => $event_date->format( 'M' ),
				'day'         => $event_date->format( 'd' ),
				'description' => $description,
			) );
		}
	}

	return $results;
}

add_action( 'rest_api_init', 'university_register_search' );