<?php
/*
Plugin Name: OSSH Password Manager
Description: A plugin to manage passwords with custom post type and taxonomy.
Version: 1.0
Author: Muhammad Owais Nizami
*/

// Register Custom Post Type
function ossh_pm_register_ossh_password_post_type() {
    $labels = array(
        'name'                  => _x( 'Passwords', 'Post Type General Name', 'ossh-password-manager' ),
        'singular_name'         => _x( 'Password', 'Post Type Singular Name', 'ossh-password-manager' ),
        'menu_name'             => __( 'Passwords', 'ossh-password-manager' ),
        'name_admin_bar'        => __( 'Password', 'ossh-password-manager' ),
        'archives'              => __( 'Password Archives', 'ossh-password-manager' ),
        'attributes'            => __( 'Password Attributes', 'ossh-password-manager' ),
        'parent_item_colon'     => __( 'Parent Password:', 'ossh-password-manager' ),
        'all_items'             => __( 'All Passwords', 'ossh-password-manager' ),
        'add_new_item'          => __( 'Add New Password', 'ossh-password-manager' ),
        'add_new'               => __( 'Add New', 'ossh-password-manager' ),
        'new_item'              => __( 'New Password', 'ossh-password-manager' ),
        'edit_item'             => __( 'Edit Password', 'ossh-password-manager' ),
        'update_item'           => __( 'Update Password', 'ossh-password-manager' ),
        'view_item'             => __( 'View Password', 'ossh-password-manager' ),
        'view_items'            => __( 'View Passwords', 'ossh-password-manager' ),
        'search_items'          => __( 'Search Password', 'ossh-password-manager' ),
        'not_found'             => __( 'Not found', 'ossh-password-manager' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'ossh-password-manager' ),
        'featured_image'        => __( 'Featured Image', 'ossh-password-manager' ),
        'set_featured_image'    => __( 'Set featured image', 'ossh-password-manager' ),
        'remove_featured_image' => __( 'Remove featured image', 'ossh-password-manager' ),
        'use_featured_image'    => __( 'Use as featured image', 'ossh-password-manager' ),
        'insert_into_item'      => __( 'Insert into password', 'ossh-password-manager' ),
        'uploaded_to_this_item' => __( 'Uploaded to this password', 'ossh-password-manager' ),
        'items_list'            => __( 'Passwords list', 'ossh-password-manager' ),
        'items_list_navigation' => __( 'Passwords list navigation', 'ossh-password-manager' ),
        'filter_items_list'     => __( 'Filter passwords list', 'ossh-password-manager' ),
    );
    $args = array(
        'label'                 => __( 'Password', 'ossh-password-manager' ),
        'description'           => __( 'Password post type', 'ossh-password-manager' ),
        'labels'                => $labels,
        'supports'              => array(), // Remove all default supports
        'taxonomies'            => array( 'ossh_password_category' ),
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
    register_post_type( 'ossh_password', $args );
}
add_action( 'init', 'ossh_pm_register_ossh_password_post_type', 0 );

// Remove Title and Editor Support
function ossh_pm_remove_ossh_password_supports() {
    remove_post_type_support( 'ossh_password', 'title' );
    remove_post_type_support( 'ossh_password', 'editor' );
}
add_action( 'init', 'ossh_pm_remove_ossh_password_supports' );

// Register Custom Taxonomy
function ossh_pm_register_ossh_password_category_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Password Categories', 'Taxonomy General Name', 'ossh-password-manager' ),
        'singular_name'              => _x( 'Password Category', 'Taxonomy Singular Name', 'ossh-password-manager' ),
        'menu_name'                  => __( 'Password Category', 'ossh-password-manager' ),
        'all_items'                  => __( 'All Categories', 'ossh-password-manager' ),
        'parent_item'                => __( 'Parent Category', 'ossh-password-manager' ),
        'parent_item_colon'          => __( 'Parent Category:', 'ossh-password-manager' ),
        'new_item_name'             => __( 'New Category Name', 'ossh-password-manager' ),
        'add_new_item'               => __( 'Add New Category', 'ossh-password-manager' ),
        'edit_item'                 => __( 'Edit Category', 'ossh-password-manager' ),
        'update_item'               => __( 'Update Category', 'ossh-password-manager' ),
        'view_item'                 => __( 'View Category', 'ossh-password-manager' ),
        'separate_items_with_commas' => __( 'Separate categories with commas', 'ossh-password-manager' ),
        'add_or_remove_items'        => __( 'Add or remove categories', 'ossh-password-manager' ),
        'choose_from_most_used'     => __( 'Choose from the most used', 'ossh-password-manager' ),
        'popular_items'             => __( 'Popular Categories', 'ossh-password-manager' ),
        'search_items'              => __( 'Search Categories', 'ossh-password-manager' ),
        'not_found'                 => __( 'Not Found', 'ossh-password-manager' ),
        'no_terms'                  => __( 'No categories', 'ossh-password-manager' ),
        'items_list'                => __( 'Categories list', 'ossh-password-manager' ),
        'items_list_navigation'     => __( 'Categories list navigation', 'ossh-password-manager' ),
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
    register_taxonomy( 'ossh_password_category', array( 'ossh_password' ), $args );
}
add_action( 'init', 'ossh_pm_register_ossh_password_category_taxonomy', 0 );

// Add Custom Fields
function ossh_pm_add_ossh_password_meta_boxes() {
    add_meta_box(
        'ossh_password_email',
        __( 'Email', 'ossh-password-manager' ),
        'ossh_pm_password_email_callback',
        'ossh_password',
        'normal',
        'high'
    );

    add_meta_box(
        'ossh_password_password',
        __( 'Password', 'ossh-password-manager' ),
        'ossh_pm_password_password_callback',
        'ossh_password',
        'normal',
        'high'
    );

    add_meta_box(
        'ossh_website_meta_box', 
        __( 'Select Website', 'ossh-password-manager' ), 
        'ossh_pm_password_website_callback', 
        'ossh_password', 
        'normal', 
        'high'
    );
}
add_action( 'add_meta_boxes', 'ossh_pm_add_ossh_password_meta_boxes' );

function ossh_pm_password_email_callback( $post ) {
    wp_nonce_field( 'ossh_pm_password_email_nonce', 'ossh_pm_password_email_nonce' );
    $value = get_post_meta( $post->ID, '_password_email', true );
    echo '<input type="email" id="ossh_password_email" name="ossh_password_email" value="' . esc_attr( $value ) . '" size="25" />';
}

function ossh_pm_password_password_callback( $post ) {
    wp_nonce_field( 'ossh_pm_password_password_nonce', 'ossh_pm_password_password_nonce' );
    $value = get_post_meta( $post->ID, '_password_password', true );
    echo '<input type="text" id="ossh_password_password" name="ossh_password_password" value="' . esc_attr( $value ) . '" size="25" />';
}

function ossh_pm_password_website_callback($post) {
    $selected_website = get_post_meta($post->ID, 'ossh_password_website', true);

    // Get all ossh_website posts
    $websites = get_posts(array(
        'post_type'      => 'ossh_website',
        'posts_per_page' => -1
    ));

    echo '<label for="ossh_password_website">Select Website:</label>';
    echo '<select name="ossh_password_website" id="ossh_password_website">';
    echo '<option value="">Select a website</option>';

    foreach ($websites as $website) {
        echo '<option value="' . esc_attr($website->ID) . '" ' . selected($selected_website, $website->ID, false) . '>' . esc_html($website->post_title) . '</option>';
    }

    echo '</select>';
}

// Save Custom Fields
function ossh_pm_save_ossh_password_meta( $post_id ) {
    if ( ! isset( $_POST['ossh_pm_password_email_nonce'] ) || ! isset( $_POST['ossh_pm_password_password_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['ossh_pm_password_email_nonce'], 'ossh_pm_password_email_nonce' ) || ! wp_verify_nonce( $_POST['ossh_pm_password_password_nonce'], 'ossh_pm_password_password_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['ossh_password_email'] ) ) {
        update_post_meta( $post_id, 'ossh_password_email', sanitize_email( $_POST['ossh_password_email'] ) );
    }

    if ( isset( $_POST['ossh_password_password'] ) ) {
        update_post_meta( $post_id, 'ossh_password_password', sanitize_text_field( $_POST['ossh_password_password'] ) );
    }

    if ( isset( $_POST['ossh_password_website'] ) ) {
        update_post_meta( $post_id, 'ossh_password_website', sanitize_text_field( $_POST['ossh_password_website'] ) );
    }
}
add_action( 'save_post', 'ossh_pm_save_ossh_password_meta' );
