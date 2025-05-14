<?php
/*
Plugin Name: Metryczki dla stron
Description: Generator <strong>metryczek</strong> dla stron (do elementu o klasie mn-mn, wtyczka raczej zostanie włączona do szablonu) 
Version: 1.1
Author: Antoni Roskosz
*/

function enqueue_jquery() {
    wp_enqueue_script('jquery');
}

function add_page_author_info()
{
    if (is_page() || is_single()) {
        global $post;

        $created_by = get_the_author_meta('display_name', $post->post_author);
        $created_date = mysql2date('d-m-Y H:i', $post->post_date);
        $created_date_short = mysql2date('d-m-Y', $post->post_date);
        $modified_by = get_the_modified_author();
        $modified_date = mysql2date('d-m-Y H:i', $post->post_modified);

        if ($created_date !== $modified_date) {
            $modification_info = '<p>Ostatnio zaktualizował: ' . esc_html($modified_by) . '</p><p>Data ostatniej aktualizacji: <span style="white-space: nowrap;">' . esc_html($modified_date) . '</span></p>';
        } else {
            $modification_info = '<p>Ostatnio zaktualizował: brak</p>';
        }

        $html = '<p>Wytworzył: ' . esc_html($created_by) . '</p><p>Data wytworzenia: <span style="white-space: nowrap;">' . esc_html($created_date_short) . '</span></p>';
        $html .= '<p>Opublikowane przez: ' . esc_html($created_by) . '</p><p>Data publikacji:  <span style="white-space: nowrap;">' . esc_html($created_date) . '</span></p>';
        $html .= $modification_info;

        echo "<script>
            jQuery(document).ready(function($) {
                $('.mn-mn').append('" . addslashes($html) . "');
            });
        </script>";
    }
}

add_action('wp_enqueue_scripts', 'enqueue_jquery');
add_action('wp_footer', 'add_page_author_info', 5);