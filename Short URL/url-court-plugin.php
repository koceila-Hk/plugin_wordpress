<?php
/*
Plugin Name: Mon premier plugin
Description: Mon premier plugin pour raccourcir l'URL!
Version: 1.0
Author: Moi
*/


// function pour raccourcir une URL avec TinyURL
function urlTinyurl($url) {
    $tinyurl_api = 'https://tinyurl.com/api-create.php?url=' . urlencode($url);
    $response = wp_remote_get($tinyurl_api);
    if (is_array($response) && !is_wp_error($response)) {
        return wp_remote_retrieve_body($response);
    } else {
        return $url; 
    }
}

// Function lors de la publication d'un article Hook
function urlPublished($postID) {
    $article_url = get_permalink($postID);
    $url_court = urlTinyurl($article_url);
    if ($url_court !== $article_url) {
        update_post_meta($postID, '_url_court', $url_court);
    }
}
add_action('publish_post', 'urlPublished');

function add_colonne_url_court($columns) {
    $columns['url_court'] = 'URL Court';
    return $columns;
}
add_filter('manage_posts_columns', 'add_colonne_url_court');

// Afficher l'URL courte dans la colonne "URL Court" du backoffice
function afficher_contenu_colonne_url_court($column_name, $postID) {
    if ($column_name == 'url_court') {
        $url_court = get_post_meta($postID, '_url_court', true);
        echo esc_url($url_court);
    }
}
add_action('manage_posts_custom_column', 'afficher_contenu_colonne_url_court', 10, 2);