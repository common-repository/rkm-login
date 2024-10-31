<?php
/**
 * Uninstall.
 *
 * @package RKM Custom Login
 */

// Don't uninstall unless you absolutely want to!
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	wp_die( 'WP_UNINSTALL_PLUGIN undefined.' );
}

delete_option( 'my_option' );

/* Goodbye! Thank you for having me! */
