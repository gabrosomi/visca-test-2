<?php

function add_sportsbook_metabox() {
	add_meta_box(
		'sportsbook_option',
		'Sportsbook',
		'sportsbook_option',
		null,
		'side',
		'default'
	);
}

/**
 * Outputs the sportsbook panel
 */
function sportsbook_option() {
	
	global $post;

	$selected_partner = get_post_meta( $post->ID, 'partner', true );
	$partners = get_sportsbooks();

	echo '<select name="partner">';

		$empty = empty($selected_partner) ? 'selected' : false;
		echo "<option value=\"\" $empty>Select a partner</option>";

		foreach ($partners as $key => $partner) {
			$selected = $selected_partner == $key ? 'selected' : false;
			echo "<option value=\"$key\" $selected>$partner</option>";
		}

	echo '</select>';

}

/**
 * Save the metabox data
 */
function link_partner_to_post ( $post_id, $post ) {

	if ( get_post_meta( $post_id, 'partner', false ) ) {
		update_post_meta( $post_id, 'partner', $_POST['partner'] );
	} else {
		add_post_meta( $post_id, 'partner', $_POST['partner']);
	}
	
	/* if empty, remove the post_meta to avoid polution */
	if ( empty($_POST['partner']) ) {
		delete_post_meta( $post_id, 'partner' );
	}

}

add_action( 'save_post', 'link_partner_to_post', 1, 2 );
add_action( 'add_meta_boxes', 'add_sportsbook_metabox' );
