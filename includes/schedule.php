<?php
/**
 * Scheduled Functions
 *
 * Schedule functions to run at certain times using the WordPress "cron" functions.
 *
 * @package    Church_Content_Manager
 * @subpackage Functions
 * @copyright  Copyright (c) 2013, churchthemes.com
 * @link       https://github.com/churchthemes/church-content-manager
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/*************************************************
 * RECURRING EVENTS
 *************************************************/
 
/**
 * Schedule weekly, monthly and yearly events
 *
 * Move recurring event dates forward after they end.
 *
 * @since 0.9
 */
function ccm_schedule_recurring_events() {

	// Schedule if not already scheduled
	if ( ! wp_next_scheduled( 'ccm_update_recurring_event_dates' ) ) {
		wp_schedule_event( time(), 'hourly', 'ccm_update_recurring_event_dates' ); // hourly so happens as soon as possible after event ends the day before
	}

}

add_action( 'wp', 'ccm_schedule_recurring_events' );

/**
 * Update recurring event dates
 *
 * @since 0.9
 */
function ccm_update_recurring_event_dates() {

	// Get all events that ended yesterday and have valid recurring value
	$events_query = new WP_Query( array(
		'post_type'	=> 'ccm_event',
		'nopaging'	=> true,
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => '_ccm_event_end_date',
				'value' => date_i18n( 'Y-m-d', time() - DAY_IN_SECONDS ) // yesterday, localized
		   ),
			array(
				'key' => '_ccm_event_recurrence',
				'value' => array( 'weekly', 'monthly', 'yearly' ),
		 		'compare' => 'IN',
		   )
		)
	) );

	// Loop events
	if ( ! empty( $events_query->posts ) ) {

		foreach ( $events_query->posts as $post ) {

		 	// Get recurrence
		 	$recurrence = get_post_meta( $post->ID, '_ccm_event_recurrence', true );

			// Get dates
			$start_date = get_post_meta( $post->ID, '_ccm_event_start_date', true );
			$end_date = get_post_meta( $post->ID, '_ccm_event_end_date', true );

			// Increment dates
			$start_date = ccm_increment_date( $start_date, $recurrence );
			$end_date = ccm_increment_date( $end_date, $recurrence );

			// Update dates
			update_post_meta( $post->ID, '_ccm_event_start_date', $start_date );
			update_post_meta( $post->ID, '_ccm_event_end_date', $end_date );

		}

	}

}

add_action( 'ccm_update_recurring_event_dates', 'ccm_update_recurring_event_dates' );