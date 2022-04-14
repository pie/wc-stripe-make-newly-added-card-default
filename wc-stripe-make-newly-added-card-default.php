<?php
/*
Plugin Name: WooCommerce Stripe: Force Default New Card
Description: When a user adds a new card to their account it will automatically be set as the default payment method
Version: 0.1
Author: The team at PIE
Author URI: http://pie.co.de
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

/* PIE\WCStripeAddNewCardDefault is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version.

PIE\WCStripeAddNewCardDefault is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with PIE\WCStripeAddNewCardDefault. If not, see https://www.gnu.org/licenses/gpl-3.0.en.html */

namespace PIE\WCStripeAddNewCardDefault;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Update newly added card as default in Stripe and WooCommerce
 * @param  [type] $customer_id                   [description]
 * @param  [type] $card_token                    [description]
 * @param  [type] $stripe_response               [description]
 * @return [type]                  [description]
 */
function make_new_card_default( $customer_id, $card_token, $stripe_response ) {
    $user_id         = get_current_user_id();
    $stripe_customer = new \WC_Stripe_Customer( $user_id );
    $stripe_customer->set_default_card( $card_token->get_token() );
    \WC_Payment_Tokens::set_users_default( $user_id, intval( $card_token->get_id() ) );
}
add_action( 'woocommerce_stripe_add_card', __NAMESPACE__ . '\\make_new_card_default', 10, 3 );
