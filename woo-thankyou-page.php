<?php

/**
 * Plugin Name:       WooCommerce Thankyou Page
 * Plugin URI:        https://everaldo.dev/
 * Description:       Redirect user to page /compra-concluida after success sale.
 * Version:           1.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Everaldo Matias
 * Author URI:        https://everaldo.dev/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://everaldo.dev/
 * Text Domain:       woo-thankyou-page
 * Domain Path:       /languages
 */

add_action( 'template_redirect', 'wtp_redirect_user_away_from_the_thankyou_page_if_paying_cash_on_delivery' );

function wtp_redirect_user_away_from_the_thankyou_page_if_paying_cash_on_delivery (){

    if ( !is_wc_endpoint_url( 'order-received' ) || empty( $_GET['key'] ) ) {
        return;
    }

    if ( isset( $_GET['method'] ) && $_GET['method'] == 'pix' ) {
        return;
    }

    $order_id = wc_get_order_id_by_order_key( $_GET['key'] );
    $order = wc_get_order( $order_id );

    $link_redirect = esc_url( home_url( 'compra-concluida' ) );

    if ( ! $order->has_status( 'failed' ) ) {
        wp_redirect( $link_redirect );
        exit;
    }
}