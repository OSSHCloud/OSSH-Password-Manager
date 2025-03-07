<?php
/*
Plugin Name: Custom Password Manager
Description: A plugin to manage passwords with custom post type and taxonomy.
Version: 1.0
Author: Your Name
*/

// Register Custom Post Type
function cpm_register_password_post_type() {
    $labels = array(
        'name'                  => _x( 'Passwords', 'Post Type General Name', 'custom-password-manager' ),
        'singular_name'         => _x( 'Password', 'Post Type Singular Name', 'custom-password-manager' ),
        'menu_name'             => __( 'Passwords', 'custom-password-manager' ),
        'name_admin_bar'        => __( 'Password', 'custom-password-manager' ),
        'archives'              => __( 'Password Archives', 'custom-password-manager' ),
        'attributes'            => __( 'Password Attributes', 'custom-password-manager' ),
        'parent_item_colon'     => __( 'Parent Password:', 'custom-password-manager' ),
        'all_items'             => __( 'All Passwords', 'custom-password-manager' ),
        'add_new_item'          => __( 'Add New Password', 'custom-password-manager' ),
        'add_new'               => __( 'Add New', 'custom-password-manager' ),
        'new_item'              => __( 'New Password', 'custom-password-manager' ),
        'edit_item'             => __( 'Edit Password', 'custom-password-manager' ),
        'update_item'           => __( 'Update Password', 'custom-password-manager' ),
        'view_item'             => __( 'View Password', 'custom-password-manager' ),
        'view_items'            => __( 'View Passwords', 'custom-password-manager' ),
        'search_items'          => __( 'Search Password', 'custom-password-manager' ),
        'not_found'             => __( 'Not found', 'custom-password-manager' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'custom-password-manager' ),
        'featured_image'        => __( 'Featured Image', 'custom-password-manager' ),
        'set_featured_image'    => __( 'Set featured image', 'custom-password-manager' ),
        'remove_featured_image' => __( 'Remove featured image', 'custom-password-manager' ),
        'use_featured_image'    => __( 'Use as featured image', 'custom-password-manager' ),
        'insert_into_item'      => __( 'Insert into password', 'custom-password-manager' ),
        'uploaded_to_this_item' => __( 'Uploaded to this password', 'custom-password-manager' ),
        'items_list'            => __( 'Passwords list', 'custom-password-manager' ),
        'items_list_navigation' => __( 'Passwords list navigation', 'custom-password-manager' ),
        'filter_items_list'     => __( 'Filter passwords list', 'custom-password-manager' ),
    );
    $args = array(
        'label'                 => __( 'Password', 'custom-password-manager' ),
        'description'           => __( 'Password post type', 'custom-password-manager' ),
        'labels'                => $labels,
        'supports'              => array(), // Remove 'title' and 'editor' from supports
        'taxonomies'            => array( 'password_category' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    register_post_type( 'password', $args );
}
add_action( 'init', 'cpm_register_password_post_type', 0 );

// Register Custom Taxonomy
function cpm_register_password_category_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Password Categories', 'Taxonomy General Name', 'custom-password-manager' ),
        'singular_name'              => _x( 'Password Category', 'Taxonomy Singular Name', 'custom-password-manager' ),
        'menu_name'                  => __( 'Password Category', 'custom-password-manager' ),
        'all_items'                  => __( 'All Categories', 'custom-password-manager' ),
        'parent_item'                => __( 'Parent Category', 'custom-password-manager' ),
        'parent_item_colon'          => __( 'Parent Category:', 'custom-password-manager' ),
        'new_item_name'             => __( 'New Category Name', 'custom-password-manager' ),
        'add_new_item'               => __( 'Add New Category', 'custom-password-manager' ),
        'edit_item'                 => __( 'Edit Category', 'custom-password-manager' ),
        'update_item'               => __( 'Update Category', 'custom-password-manager' ),
        'view_item'                 => __( 'View Category', 'custom-password-manager' ),
        'separate_items_with_commas' => __( 'Separate categories with commas', 'custom-password-manager' ),
        'add_or_remove_items'        => __( 'Add or remove categories', 'custom-password-manager' ),
        'choose_from_most_used'     => __( 'Choose from the most used', 'custom-password-manager' ),
        'popular_items'             => __( 'Popular Categories', 'custom-password-manager' ),
        'search_items'              => __( 'Search Categories', 'custom-password-manager' ),
        'not_found'                 => __( 'Not Found', 'custom-password-manager' ),
        'no_terms'                  => __( 'No categories', 'custom-password-manager' ),
        'items_list'                => __( 'Categories list', 'custom-password-manager' ),
        'items_list_navigation'     => __( 'Categories list navigation', 'custom-password-manager' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'password_category', array( 'password' ), $args );
}
add_action( 'init', 'cpm_register_password_category_taxonomy', 0 );

// Add Custom Fields
function cpm_add_password_meta_boxes() {
    add_meta_box(
        'password_email',
        __( 'Email', 'custom-password-manager' ),
        'cpm_password_email_callback',
        'password',
        'normal',
        'high'
    );

    add_meta_box(
        'password_password',
        __( 'Password', 'custom-password-manager' ),
        'cpm_password_password_callback',
        'password',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'cpm_add_password_meta_boxes' );

function cpm_password_email_callback( $post ) {
    wp_nonce_field( 'cpm_password_email_nonce', 'cpm_password_email_nonce' );
    $value = get_post_meta( $post->ID, '_password_email', true );
    echo '<input type="email" id="password_email" name="password_email" value="' . esc_attr( $value ) . '" size="25" />';
}

function cpm_password_password_callback( $post ) {
    wp_nonce_field( 'cpm_password_password_nonce', 'cpm_password_password_nonce' );
    $value = get_post_meta( $post->ID, '_password_password', true );
    echo '<input type="text" id="password_password" name="password_password" value="' . esc_attr( $value ) . '" size="25" />';
}

// Save Custom Fields
function cpm_save_password_meta( $post_id ) {
    if ( ! isset( $_POST['cpm_password_email_nonce'] ) || ! isset( $_POST['cpm_password_password_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['cpm_password_email_nonce'], 'cpm_password_email_nonce' ) || ! wp_verify_nonce( $_POST['cpm_password_password_nonce'], 'cpm_password_password_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['password_email'] ) ) {
        update_post_meta( $post_id, '_password_email', sanitize_email( $_POST['password_email'] ) );
    }

    if ( isset( $_POST['password_password'] ) ) {
        update_post_meta( $post_id, '_password_password', sanitize_text_field( $_POST['password_password'] ) );
    }
}
add_action( 'save_post', 'cpm_save_password_meta' );
