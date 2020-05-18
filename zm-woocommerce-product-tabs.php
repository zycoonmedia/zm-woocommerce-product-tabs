<?php
/**
 * Plugin Name: ZM Product Tabs for WooCommerce
 * Plugin URI: http://www.zycoonmedia.com
 * Description: Extend WooCommerce for Additional Product Tabs
 * Author: Zycoon Media
 * Author URI: http://www.zycoonmedia.com
 * Version: 1.0
 * Text Domain: zm-woocommerce-product-tabs
 * Domain Path: languages/
 *
 */

function zm_custom_field_create() {
    $args = array(
        'id' => 'zm_field_01',
        'label' => __( 'Custom Field', 'zmcf' ),
        'class' => 'zm-custom-field'
    );
    woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_general_product_data', 'zm_custom_field_create' );

function zm_custom_field_save( $post_id ) {
    $product = wc_get_product( $post_id );
    $zm_field_01_content = isset( $_POST['zm_field_01'] ) ? $_POST['zm_field_01'] : '';
    $product->update_meta_data( 'zm_field_01', sanitize_text_field( $zm_field_01_content ) );
    $product->save();
}
add_action( 'woocommerce_process_product_meta', 'zm_custom_field_save' );

function zm_product_tab_content()  {
    $prod_id = get_the_ID();
    echo'<p>'.get_post_meta($prod_id,'zm_field_01',true).'</p>';
}

function zm_product_tab( $tabs ) {
    $prod_id = get_the_ID();
    if(get_post_meta($prod_id,'zm_field_01',true))
    {
        $tabs['zm_tab1'] = array(
            'title'     => __( 'Custom Field', 'woocommerce' ),
            'priority'  => 50,
            'callback'  => 'zm_product_tab_content'
        );
    }
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'zm_product_tab' );


