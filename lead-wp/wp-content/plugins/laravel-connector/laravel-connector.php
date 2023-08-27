<?php
/*
Plugin Name: Laravel Connector
Description: Laravel Connector Plugin to handle potential leads created via API.
Version: 1.0
Author: Amad Zahid
*/

add_action('rest_api_init', 'custom_subscriber_api_init');

function custom_subscriber_api_init() {
    register_rest_route('custom-subscriber/v1', '/add-subscriber', array(
        'methods' => 'POST',
        'callback' => 'handle_subscriber_creation',
    ));
}

// Verify API token before processing the request
function verify_api_token($incoming_token) {
    $stored_token = 'bZzacpEMnh1MrXDX1MNuSoPZAFj05CyF1aAE';
    // Token verification failed/Pass
    if ($incoming_token !== $stored_token) {
        return false; 
    }
    return true;
}


function handle_subscriber_creation($request) {

    // Get the token from the request header
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $auth_header = $_SERVER['HTTP_AUTHORIZATION'];
        list($token_type, $incoming_token) = explode(' ', $auth_header);
    } else {
        return rest_ensure_response(array('error' => 'Unauthorized')); 
    }

    //API token Authorization
    if (!verify_api_token($incoming_token)) {
        return rest_ensure_response(array('error' => 'Unauthorized'));
    }
    
    $params = $request->get_params();

    // Validate upcoming API data
    if (empty($params['external_id'])) {
        return rest_ensure_response(array('error' => 'External ID is required.'));
    }
    if (empty($params['name'])) {
        return rest_ensure_response(array('error' => 'Name is required.'));
    }
    if (empty($params['email']) || !is_email($params['email'])) {
        return rest_ensure_response(array('error' => 'A valid email address is required.'));
    }

    // Sanitize data
    $email = sanitize_email($params['email']);
    $name = sanitize_text_field($params['name']);
    $external_id = isset($params['external_id']) ? sanitize_text_field($params['external_id']) : '';
    $external_url = isset($params['external_url']) ? sanitize_text_field($params['external_url']) : '';
    $is_external = true;


    $user = get_user_by('email', $email);
    if ($user) {
        $response = array(
            'new_user' => false,
            'success' => true,
            'user_id' => $user->id,
            'nicename' => $user->user_nicename,
        );
        return rest_ensure_response($response);
    }

    // Set a default password for subscribers
    $default_password = wp_generate_password();

    // Extract first name and last name from the provided name
    $full_name = explode(' ', $name);
    $first_name = isset($full_name[0]) ? $full_name[0] : '';
    $last_name = isset($full_name[1]) ? $full_name[1] : '';

    // Create a new user with the default password
    $user_id = wp_insert_user(array(
        'user_login' => $email,
        'user_email' => $email,
        'user_pass'  => $default_password,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'display_name' => $name,
        'role' => 'subscriber',
    ));

    if (is_wp_error($user_id)) {
        $response = array('error' => 'Subscriber already exists');
    } else {
        // Update custom user meta with external information
        update_user_meta($user_id, 'external_id', $external_id);
        update_user_meta($user_id, 'is_external', $is_external);
        update_user_meta($user_id, 'external_url', $external_url);

        $user = get_userdata($user_id);

        $response = array(
            'new_user' => true,
            'success' => true,
            'user_id' => $user_id,
            'nicename' => $user->user_nicename,
            // 'user_info' => get_userdata($user_id),
        );
    }

    return rest_ensure_response($response);
}

function custom_user_list_column_header($columns) {
    $columns['external_flag'] = 'Laravel Lead';
    return $columns;
}
add_filter('manage_users_columns', 'custom_user_list_column_header');

// Populate custom column
function custom_user_list_column_content($value, $column_name, $user_id) {
    if ($column_name === 'external_flag') {
        $is_external = get_user_meta($user_id, 'is_external', true);
        $external_url = get_user_meta($user_id, 'external_url', true);
        if ($is_external) {
            $flag_html = '<a href="'.$external_url.'" target="_blank">View</a>';
            // $flag_html = '<span class="external-flag">External</span>';
            return $flag_html;
        }
    }
    return $value;
}
add_filter('manage_users_custom_column', 'custom_user_list_column_content', 10, 3);

// Add custom CSS
function custom_admin_styles() {
    echo '<style>
            .external-flag {
                background-color: #f2c94c;
                color: #fff;
                padding: 2px 6px;
                border-radius: 4px;
            }
        </style>';
}
add_action('admin_head', 'custom_admin_styles');

// Add custom field to user edit screen
function custom_user_profile_fields($user) {
    $external_id = get_user_meta($user->ID, 'external_id', true);
    if ($external_id) {
        echo '<h2>External Information</h2>';
        echo '<table class="form-table">';
        echo '<tr>';
        echo '<th><label for="external_id">External ID</label></th>';
        // echo '<td><a href="' . esc_url($external_id) . '">' . esc_html($external_id) . '</a></td>';
        echo '<td><a href="http://127.0.0.1:8000/contacts" target="_blank">' . esc_html($external_id) . '</a></td>';
        echo '</tr>';
        echo '</table>';
    }
}
add_action('show_user_profile', 'custom_user_profile_fields');
add_action('edit_user_profile', 'custom_user_profile_fields');



