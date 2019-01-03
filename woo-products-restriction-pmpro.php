<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://innovsit.com
 * @since             1.0.0
 * @package           Woo Product Restriction for PM PRO
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Product Restriction for Paid Membership PRO 
 * Plugin URI:        https://innovsit.com/product/woo-product-restriction-for-paid-membership-pro/
 * Description:       Restrict Woo Products from being bought without a Membership
 * Version:           1.0.1
 * Author:            Shawon Chowdhury
 * Author URI:		  https://profiles.wordpress.org/shawon786
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       
 * Domain Path:       
 */
 
function wprpm_restrict_non_pmpro_members_from_buying_woo_product( $is_purchasable, $product ) {
	
	// Check if the user has an active membership.
	if( pmpro_hasMembershipLevel() ) {
		return $is_purchasable;
	}

	// Restricted categories (category-slug) that require membership level to purchase.
	$restricted_category_slugs = array(
		'woo-pm'
	);

	if( has_term( $restricted_category_slugs, 'product_cat', $product->id ) ) {
		$is_purchasable = false;	
	}
	return $is_purchasable;
}


/**
 * Message to the customer to purchase a membership and linking to the membership registration page
 */

function wprpm_purchase_disabled_message() {

    global $product;
    $wprpm_url = home_url( 'levels', 'relative' );
    
    // checking if the customer has a membership
	if( !pmpro_hasMembershipLevel() ) {
		echo '<div class="woocommerce"><div class="woocommerce-info wc-nonpurchasable-message">You need to have a Membership to purchase this product.</br><a href="'.$wprpm_url.'"><strong>Register Now!</strong></a></div></div>';		

	}
    
}

add_action( 'woocommerce_single_product_summary', 'wprpm_purchase_disabled_message', 10 );
add_filter( 'woocommerce_is_purchasable', 'wprpm_restrict_non_pmpro_members_from_buying_woo_product', 10, 2 );