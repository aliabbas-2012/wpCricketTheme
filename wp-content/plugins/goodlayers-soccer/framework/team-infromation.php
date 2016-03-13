<?php

/**
 * Team Module
 */
add_action('init', 'itst_cricket_create_team');

function itst_cricket_create_team() {
    register_post_type('team', array(
        'labels' => array(
            'name' => __('Teams', 'gdlr-soccer'),
            'singular_name' => __('Team', 'gdlr-soccer'),
            'add_new' => __('Add New', 'gdlr-soccer'),
            'add_new_item' => __('Add New Team', 'gdlr-soccer'),
            'edit_item' => __('Edit Team', 'gdlr-soccer'),
            'new_item' => __('New Team', 'gdlr-soccer'),
            'all_items' => __('All Team', 'gdlr-soccer'),
            'view_item' => __('View Team', 'gdlr-soccer'),
            'search_items' => __('Search Teams', 'gdlr-soccer'),
            'not_found' => __('No Teams found', 'gdlr-soccer'),
            'not_found_in_trash' => __('No teams found in Trash', 'gdlr-soccer'),
            'parent_item_colon' => '',
            'menu_name' => __('Teams', 'gdlr-soccer')
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        //'rewrite'            => array( 'slug' => 'player'  ),
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'supports' => array('title', 'author', 'thumbnail', 'custom-fields')
            )
    );

    // create player categories
    register_taxonomy(
            'team_category', array("team"), array(
        'hierarchical' => true,
        'show_admin_column' => true,
        'label' => __('Team Categories', 'gdlr-soccer'),
        'singular_label' => __('Team Category', 'gdlr-soccer'),
        'rewrite' => array('slug' => 'team_category')));
    register_taxonomy_for_object_type('team_category', 'team');

    add_filter('single_template', 'gdlr_soccer_register_team_template');
}

function gdlr_soccer_register_team_template($template) {
    global $wpdb, $post, $current_user;

    if ($post->post_type == 'team') {
        $template = dirname(dirname(__FILE__)) . '/single-team.php';
    }

    return $template;
}

// enqueue the necessary admin script for making tab layout
add_action('admin_enqueue_scripts', 'gdlr_cricket_team_script');

function gdlr_cricket_team_script() {
    global $post;
    if (!empty($post) && $post->post_type != 'team')
        return;

    wp_enqueue_style('gdlr-soccer-meta-box', plugins_url('/stylesheet/meta-box.css', __FILE__));
    wp_enqueue_style('gdlr-date-picker', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_script('gdlr-soccer-meta-box', plugins_url('/javascript/meta-box.js', __FILE__));
}

// add the player option
add_action('add_meta_boxes', 'gdlr_cricket_add_team_meta_box');

function gdlr_cricket_add_team_meta_box() {
    add_meta_box('player-option', __('Player Option', 'gdlr-soccer'), 'gdlr_cricket_create_team_meta_box', 'team', 'normal', 'high');
}

function gdlr_cricket_create_team_meta_box() {
    global $post;

    // Add an nonce field so we can check for it later.
    wp_nonce_field('team_meta_box', 'team_meta_box_nonce');

    /////////////////
    //// setting ////
    /////////////////

    $player_settings = array(
        'team-info' => array(
            'title' => __('Team Info', 'gdlr-soccer'),
            'options' => array(
                'general-info' => array(
                    'title' => __('General Info', 'gdlr-soccer'),
                    'type' => 'title'
                ),
                'total-test-matches' => array(
                    'title' => __('Total Test Matches', 'gdlr-soccer'),
                    'type' => 'number'
                ),
                'total-odi_matches' => array(
                    'title' => __('Total ODI Matches', 'gdlr-soccer'),
                    'type' => 'number'
                ),
                'total-t20_matches' => array(
                    'title' => __('Total T20Is Matches', 'gdlr-soccer'),
                    'type' => 'number'
                ),
                'total_series_won' => array(
                    'title' => __('Total Series won', 'gdlr-soccer'),
                    'type' => 'number'
                ),
                'icc_one_day_ranking' => array(
                    'title' => __('ICC one Day ranking', 'gdlr-soccer'),
                    'type' => 'number'
                ),
                'icc_t20_ranking' => array(
                    'title' => __('ICC T20 ranking', 'gdlr-soccer'),
                    'type' => 'number'
                ),
                'team-established_date' => array(
                    'title' => __('Team Established Date', 'gdlr-soccer'),
                    'type' => 'datepicker'
                ),
                'team-country' => array(
                    'title' => __('Country', 'gdlr-soccer'),
                    'type' => 'text'
                ),
                'date-of-birth' => array(
                    'title' => __('Date Of Birth', 'gdlr-soccer'),
                    'type' => 'text'
                ),
                'height' => array(
                    'title' => __('Hieght', 'gdlr-soccer'),
                    'type' => 'text'
                ),
                'social-media' => array(
                    'title' => __('Social Media', 'gdlr-soccer'),
                    'type' => 'title',
                    'class' => 'with-space'
                ),
                'facebook' => array(
                    'title' => __('Facebook', 'gdlr-soccer'),
                    'type' => 'text'
                ),
                'twitter' => array(
                    'title' => __('Twitter', 'gdlr-soccer'),
                    'type' => 'text'
                ),
                'youtube' => array(
                    'title' => __('Youtube', 'gdlr-soccer'),
                    'type' => 'text'
                ),
                'instagram' => array(
                    'title' => __('Instagram', 'gdlr-soccer'),
                    'type' => 'text'
                ),
            ),
        ),
        'biography' => array(
            'title' => __('Biography', 'gdlr-soccer'),
            'options' => array(
                'biography' => array(
                    'type' => 'wysiwyg'
                ),
            ),
        ),
        'gallery' => array(
            'title' => __('Gallery', 'gdlr-soccer'),
            'options' => array(
                'player-gallery' => array(
                    'type' => 'wysiwyg'
                ),
            ),
        ),
    );
    $player_val = gdlr_lms_decode_preventslashes(get_post_meta($post->ID, 'gdlr-cricket-player-settings', true));
    $player_settings_val = empty($player_val) ? array() : json_decode($player_val, true);

    echo '<div class="gdlr-lms-meta-wrapper gdlr-tabs">';

    // tab title
    $count = 0;
    echo '<div class="soccer-tab-title">';
    foreach ($player_settings as $section_slug => $player_setting) {
        echo '<span data-tab="' . $section_slug . '" ';
        echo ($count == 0) ? 'class="active" ' : '';
        echo '>' . $player_setting['title'] . '</span>';

        $count++;
    }
    echo '</div>'; // soccer-tab-title
    // tab content
    $count = 0;
    echo '<div class="soccer-tab-content-wrapper">';
    foreach ($player_settings as $section_slug => $player_setting) {
        echo '<div class="soccer-tab-content ';
        echo ($count == 0) ? 'active' : '';
        echo '" data-tab="' . $section_slug . '" >';
        foreach ($player_setting['options'] as $option_slug => $option_val) {
            $option_val['slug'] = $option_slug;
            $option_val['value'] = $player_settings_val[$section_slug][$option_slug];
            gdlr_lms_print_meta_box($option_val);
        }
        echo '</div>';

        $count++;
    }
    echo '</div>'; // soccer-tab-content-wrapper

    echo '<textarea name="gdlr-cricket-player-settings">' . esc_textarea($player_val) . '</textarea>';
    echo '</div>';
}
