<?php

/**
 * This file contains functions and hooks.
 *
 * @package Variations
 * 
 */

/**
 * Define version to use it with JS and CSS files.
 */
if (!defined('VARIATIONS_THEME_VERSION')) {

    define('VARIATIONS_THEME_VERSION', wp_get_theme()->get('Version'));
}

/**
 * Enqueue Scripts.
 */
require_once get_template_directory() . '/inc/enqueue-scripts.php';

/**
 * Hooks and actions.
 */
require_once get_template_directory() . '/inc/hooks-actions.php';

// affichage l'URL raccourcie
function boite_meta_info() {
    add_meta_box('boite-meta-url-courte', 'URL courte', 'afficher_url_courte_meta_box', 'post', 'side');
}
add_action('add_meta_boxes', 'boite_meta_info');

// Afficher l'URL raccourcie dans la boîte de méta-information
function afficher_url_courte_meta_box($post) {
    $url_courte = get_post_meta($post->ID, '_url_court', true);
    ?>
    <p>
        <?php if (!empty($url_courte)) : ?>
            <strong>URL courte :</strong> <a href="<?php echo esc_url($url_courte); ?>" target="_blank"><?php echo esc_url($url_courte); ?></a>
        <?php else : ?>
            Aucune URL courte disponible.
        <?php endif; ?>
    </p>
    <?php
}

