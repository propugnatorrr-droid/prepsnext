<?php
/**
 * Plugin Name: PrepsNext Athlete Profiles
 * Plugin URI:  https://prepsnextmag.com
 * Description: Complete athlete profile system for PrepsNext Magazine. Basketball and football player profiles with media galleries, rankings, career history, recruiting info, social media links, and blog post tagging.
 * Version:     1.0.6
 * Author:      PrepsNext Magazine
 * Author URI:  https://prepsnextmag.com
 * License:     GPL-2.0+
 * Text Domain: prepsnext
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ── Constants ────────────────────────────────────────────────────────────────
define( 'PREPSNEXT_VERSION',    '1.0.6' );
define( 'PREPSNEXT_DIR',        plugin_dir_path( __FILE__ ) );
define( 'PREPSNEXT_URL',        plugin_dir_url( __FILE__ ) );
define( 'PREPSNEXT_FILE',       __FILE__ );

// ── Load all class files immediately (no lazy loading) ───────────────────────
require_once PREPSNEXT_DIR . 'includes/class-prepsnext-cpt.php';
require_once PREPSNEXT_DIR . 'includes/class-prepsnext-taxonomies.php';
require_once PREPSNEXT_DIR . 'includes/class-prepsnext-metaboxes.php';
require_once PREPSNEXT_DIR . 'includes/class-prepsnext-admin.php';
require_once PREPSNEXT_DIR . 'includes/class-prepsnext-frontend.php';
require_once PREPSNEXT_DIR . 'includes/class-prepsnext-shortcodes.php';
require_once PREPSNEXT_DIR . 'includes/class-prepsnext-user-profile.php';
require_once PREPSNEXT_DIR . 'includes/class-prepsnext-ajax.php';
require_once PREPSNEXT_DIR . 'includes/class-prepsnext-widget.php';
require_once PREPSNEXT_DIR . 'includes/class-prepsnext-threads-db.php';
require_once PREPSNEXT_DIR . 'includes/class-prepsnext-threads.php';
require_once PREPSNEXT_DIR . 'includes/class-prepsnext-threads-ajax.php';

// ── Boot all classes immediately ─────────────────────────────────────────────
// Each class registers its own hooks in its constructor.
// We call ::instance() right now so hooks are registered before 'init' fires.
function prepsnext_boot() {
    PrepsNext_CPT::instance();
    PrepsNext_Taxonomies::instance();
    PrepsNext_Metaboxes::instance();
    PrepsNext_Admin::instance();
    PrepsNext_Frontend::instance();
    PrepsNext_Shortcodes::instance();
    PrepsNext_User_Profile::instance();
    PrepsNext_Ajax::instance();
    PrepsNext_Threads::instance();
    PrepsNext_Threads_Ajax::instance();
    // Widget registration is handled via the widgets_init hook inside class-prepsnext-widget.php

    // Threads DB install / upgrade — only run during a normal web request,
    // not on every AJAX call, to avoid the overhead / "headers already sent" issues.
    if ( ! wp_doing_ajax() && ! wp_doing_cron() && PrepsNext_Threads_DB::needs_install() ) {
        PrepsNext_Threads_DB::install();
    }

    // Admin: athlete approval column on Users page
    add_filter( 'manage_users_columns',       'prepsnext_users_columns' );
    add_filter( 'manage_users_custom_column', 'prepsnext_users_column_value', 10, 3 );
    add_filter( 'user_row_actions',           'prepsnext_user_row_actions', 10, 2 );
    add_action( 'admin_post_pn_approve_athlete', 'prepsnext_approve_athlete' );
    add_action( 'admin_post_pn_revoke_athlete',  'prepsnext_revoke_athlete' );

    // Enqueue assets
    add_action( 'wp_enqueue_scripts',    'prepsnext_frontend_assets' );
    add_action( 'admin_enqueue_scripts', 'prepsnext_admin_assets' );
}
add_action( 'plugins_loaded', 'prepsnext_boot' );

// ── Frontend assets ───────────────────────────────────────────────────────────
function prepsnext_frontend_assets() {
    $post = get_post();
    $load = is_singular( 'pn_athlete' )
         || is_post_type_archive( 'pn_athlete' )
         || ( $post && has_shortcode( $post->post_content, 'prepsnext_athlete' ) )
         || ( $post && has_shortcode( $post->post_content, 'prepsnext_athletes' ) )
         || ( $post && has_shortcode( $post->post_content, 'prepsnext_rankings' ) )
         || ( $post && has_shortcode( $post->post_content, 'prepsnext_register' ) )
         || ( $post && has_shortcode( $post->post_content, 'prepsnext_claim' ) )
         || is_active_widget( false, false, 'prepsnext_new_athletes', true );

    if ( ! $load ) return;

    wp_enqueue_style(
        'prepsnext-fonts',
        'https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,400;0,600;0,700;0,800;0,900;1,700;1,800&family=Barlow:wght@400;500;600;700&display=swap',
        [],
        null
    );
    wp_enqueue_style( 'prepsnext-profile', PREPSNEXT_URL . 'assets/css/profile.css', [], PREPSNEXT_VERSION );
    wp_enqueue_style( 'prepsnext-forms',   PREPSNEXT_URL . 'assets/css/forms.css',   ['prepsnext-profile'], PREPSNEXT_VERSION );
    wp_enqueue_script(
        'prepsnext-profile',
        PREPSNEXT_URL . 'assets/js/profile.js',
        [ 'jquery' ],
        PREPSNEXT_VERSION,
        true
    );
    wp_localize_script( 'prepsnext-profile', 'prepsnextData', [
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'nonce'     => wp_create_nonce( 'prepsnext_nonce' ),
        'pluginUrl' => PREPSNEXT_URL,
    ] );
}

// ── Admin assets ──────────────────────────────────────────────────────────────
function prepsnext_admin_assets( $hook ) {
    $screen = get_current_screen();
    if ( ! $screen ) return;

    $is_athlete_screen = ( $screen->post_type === 'pn_athlete' );
    $is_settings_page  = ( strpos( $hook, 'prepsnext' ) !== false );

    if ( ! $is_athlete_screen && ! $is_settings_page ) return;

    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_style( 'prepsnext-admin', PREPSNEXT_URL . 'assets/css/admin.css', [], PREPSNEXT_VERSION );
    wp_enqueue_media();
    wp_enqueue_script(
        'prepsnext-admin',
        PREPSNEXT_URL . 'assets/js/admin.js',
        [ 'jquery', 'jquery-ui-sortable', 'wp-color-picker', 'media-upload' ],
        PREPSNEXT_VERSION,
        true
    );
    wp_localize_script( 'prepsnext-admin', 'prepsnextAdmin', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'prepsnext_admin_nonce' ),
        'strings' => [
            'uploadImage'   => __( 'Upload Image', 'prepsnext' ),
            'selectImage'   => __( 'Select Image', 'prepsnext' ),
            'removeImage'   => __( 'Remove', 'prepsnext' ),
            'confirmDelete' => __( 'Are you sure?', 'prepsnext' ),
        ],
    ] );
}

// ── Admin: Threads Approval ─────────────────────────────────────────────────
function prepsnext_users_columns( $cols ) {
    $cols['pn_approved'] = '✅ Threads Approved';
    return $cols;
}
function prepsnext_users_column_value( $val, $col, $uid ) {
    if ( $col !== 'pn_approved' ) return $val;
    $approved = get_user_meta( $uid, 'pn_athlete_approved', true );
    return $approved ? '<span style="color:#AAFF00;font-weight:700">✅ Approved</span>'
                     : '<span style="color:#FF4D4D;font-weight:700">⏳ Pending</span>';
}
function prepsnext_user_row_actions( $actions, $user ) {
    if ( current_user_can( 'manage_options' ) ) {
        $approved = get_user_meta( $user->ID, 'pn_athlete_approved', true );
        if ( ! $approved ) {
            $actions['pn_approve'] = '<a href="' . esc_url( admin_url( 'admin-post.php?action=pn_approve_athlete&uid=' . $user->ID . '&nonce=' . wp_create_nonce( 'pn_approve_' . $user->ID ) ) ) . '" style="color:#AAFF00">✅ Approve for Threads</a>';
        } else {
            $actions['pn_revoke'] = '<a href="' . esc_url( admin_url( 'admin-post.php?action=pn_revoke_athlete&uid=' . $user->ID . '&nonce=' . wp_create_nonce( 'pn_revoke_' . $user->ID ) ) ) . '" style="color:#FF4D4D">❌ Revoke Access</a>';
        }
    }
    return $actions;
}
function prepsnext_approve_athlete() {
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Unauthorized' );
    $uid = absint( $_GET['uid'] ?? 0 );
    if ( ! wp_verify_nonce( $_GET['nonce'] ?? '', 'pn_approve_' . $uid ) ) wp_die( 'Invalid nonce' );
    update_user_meta( $uid, 'pn_athlete_approved', 1 );
    // Notify the user
    $user = get_userdata( $uid );
    if ( $user ) wp_mail( $user->user_email, 'Your PrepsNext account is approved!', 'Great news! Your PrepsNext athlete account has been approved. You can now post, comment, and interact: ' . home_url( '/prepsnext-feed/' ) );
    wp_redirect( add_query_arg( [ 'pn_approved' => 1 ], admin_url( 'users.php' ) ) ); exit;
}
function prepsnext_revoke_athlete() {
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Unauthorized' );
    $uid = absint( $_GET['uid'] ?? 0 );
    if ( ! wp_verify_nonce( $_GET['nonce'] ?? '', 'pn_revoke_' . $uid ) ) wp_die( 'Invalid nonce' );
    update_user_meta( $uid, 'pn_athlete_approved', 0 );
    wp_redirect( add_query_arg( [ 'pn_revoked' => 1 ], admin_url( 'users.php' ) ) ); exit;
}

// ── Activation ────────────────────────────────────────────────────────────────
register_activation_hook( __FILE__, 'prepsnext_activate' );
function prepsnext_activate() {
    // Register CPT & taxonomies so rewrite rules are generated correctly
    PrepsNext_CPT::register_post_type_static();
    PrepsNext_Taxonomies::register_taxonomies_static();
    flush_rewrite_rules();
    // Install Threads DB tables
    PrepsNext_Threads_DB::install();
    // Clear page-creation cache so pages are re-created if missing
    delete_transient( 'pn_threads_pages_created' );

    add_option( 'prepsnext_settings', [
        'accent_color'       => '#AAFF00',
        'dark_bg'            => '#111111',
        'show_contact_form'  => 1,
        'enable_athlete_reg' => 1,
        'default_sport'      => 'basketball',
        'archive_per_page'   => 24,
        'profile_sidebar'    => 1,
        'contact_email'      => get_option( 'admin_email' ),
    ] );
}

// ── Deactivation ─────────────────────────────────────────────────────────────
register_deactivation_hook( __FILE__, 'prepsnext_deactivate' );
function prepsnext_deactivate() {
    flush_rewrite_rules();
}
