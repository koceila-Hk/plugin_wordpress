<?php
/*
Plugin Name: Mon plugin counter views
Description: Mon plugin pour incémenter les vues
Version: 1.0
Author: Moi
*/

// ======= function incrémenter ======== 
function incrementer_compteur_vues() {
    if (is_single() || is_page()) {
        $post_id = get_the_ID();
        $vues = get_post_meta($post_id, 'vues', true);
        $vues = empty($vues) ? 1 : intval($vues) + 1;
        update_post_meta($post_id, 'vues', $vues);
    }
}
add_action('wp_head', 'incrementer_compteur_vues');

// ========= function get views ========
function get_vues_article($post_id) {
    return intval(get_post_meta($post_id, 'vues', true));
}

// ===== function affichage contenus les plus populaires ======
function afficher_contenus_populaires() {
    $array = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
        'meta_key' => 'vues',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    );
    $populaire = new WP_Query($array);

    if ($populaire->have_posts()) {
        echo '<ul>';
        while ($populaire->have_posts()) {
            $populaire->the_post();
            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a> - ' . get_vues_article(get_the_ID()) . ' vues</li>';
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo 'Aucun contenu populaire trouvé.';
    }
}