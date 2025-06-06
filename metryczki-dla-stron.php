<?php
/*
Plugin Name: Metryczki dla stron
Description: Generator <strong>metryczek</strong> dla stron (do elementu o klasie mn-mn) z możliwością dodania własnego CSS i klas tabelki w ustawieniach.
Version: 1.6
Author: Antoni Roskosz
*/

$default_css = ".mn-mn table { 
    border-collapse: collapse; 
    width: 100%; 
    margin: 0 auto;
    margin-top: 1em; 
    border: none;
}
.mn-mn table td {padding: 4px; border-top: 1px solid #003c7d;}
.mn-mn table td:nth-child(even){font-weight: bold;}
.mn-mn table tr:nth-child(odd) {background-color: #f2f2f2;}
.mn-mn table tr:last-child {border-bottom: 1px solid #003c7d;}";
$default_classes = '';

add_action('admin_init', function () {
    register_setting('metryczki_options_group', 'metryczki_custom_css');
    register_setting('metryczki_options_group', 'metryczki_table_classes');
});

// Dodanie strony ustawień w menu
add_action('admin_menu', function () {
    add_options_page(
        'Metryczki stron - ustawienia',
        'Metryczki stron',
        'manage_options',
        'metryczki-settings',
        'metryczki_settings_page'
    );
});

// Wczytanie Bootstrap w panelu admina
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'settings_page_metryczki-settings') return;
    wp_enqueue_style('bootstrap-css-admin', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', [], '5.3.0');
    wp_enqueue_script('bootstrap-js-admin', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', ['jquery'], '5.3.0', true);
});

// Strona ustawień
function metryczki_settings_page()
{
    global $default_css, $default_classes;
    $custom_css     = get_option('metryczki_custom_css', $default_css);
    $table_classes  = get_option('metryczki_table_classes', $default_classes);
?>
    <div class="wrap">
        <h1>Metryczki stron - Ustawienia</h1>
        <form method="post" action="options.php">
            <?php settings_fields('metryczki_options_group'); ?>
            <table class="form-table table">
                <tr>
                    <th scope="row"><label for="metryczki_custom_css">Własny CSS tabelki</label></th>
                    <td>
                        <textarea id="metryczki_custom_css" name="metryczki_custom_css" rows="10" cols="50" class="form-control code"><?php echo esc_textarea($custom_css); ?></textarea>
                        <p class="description">Wklej kod CSS dla generowanej tabelki metryczek.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="metryczki_table_classes">Klasy tabelki</label></th>
                    <td>
                        <input type="text" id="metryczki_table_classes" name="metryczki_table_classes" value="<?php echo esc_attr($table_classes); ?>" class="form-control code" />
                        <p class="description">Podaj klasy, które zostaną dodane do <code>&lt;table&gt;</code>. Domyślnie <code><?php echo esc_html($default_classes); ?></code>.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td>
                        <button type="button" class="button" id="metryczki-reset-css">Resetuj</button>
                        <p class="description">Przywraca domyślny CSS oraz klasy tabelki.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <h2>Podgląd tabelki</h2>
        <div class="mn-mn" id="metryczki-preview-wrapper">
            <!-- tu tabelka -->
        </div>
    </div>
    <script>
        (function($) {
            var defaultCss = `<?php echo str_replace("`", "\\`", $default_css); ?>`;
            var defaultClasses = '<?php echo esc_js($default_classes); ?>';

            function renderPreview() {
                var css = $('#metryczki_custom_css').val();
                var classes = $('#metryczki_table_classes').val();
                $('#metryczki-preview-style').remove();
                $('#metryczki-preview-wrapper').empty();
                $('<style>', {
                    id: 'metryczki-preview-style',
                    text: css
                }).appendTo('head');
                var sample = {
                    'Wytworzył:': 'Jan Kowalski',
                    'Data wytworzenia:': '01-01-2025',
                    'Opublikowane przez:': 'Jan Kowalski',
                    'Data publikacji:': '02-01-2025 12:00',
                    'Ostatnio zaktualizował:': 'Jan Kowalski',
                    'Data aktualizacji:': '03-01-2025 14:00',
                    'Liczba odwiedzin:': '12345'
                };
                var $tbl = $('<table>').addClass(classes);
                $.each(sample, function(label, value) {
                    var $tr = $('<tr>');
                    $('<td>').text(label).appendTo($tr);
                    $('<td>').text(value).appendTo($tr);
                    $tbl.append($tr);
                });
                $('#metryczki-preview-wrapper').append($tbl);
            }
            $(function() {
                renderPreview();
                $('#metryczki_custom_css, #metryczki_table_classes').on('input', renderPreview);
                // OBSŁUGA PRZYCISKU RESETUJ:
                $('#metryczki-reset-css').on('click', function() {
                    $('#metryczki_custom_css').val(defaultCss);
                    $('#metryczki_table_classes').val(defaultClasses);
                    renderPreview();
                });
            });
        })(jQuery);
    </script>
<?php
}

// ładowanie jQuery, Bootstrap i metryczki
add_action('wp_enqueue_scripts', function () {
    // jQuery
    if (! wp_script_is('jquery', 'registered')) {
        wp_register_script('jquery', includes_url('/js/jquery/jquery.js'), [], null, true);
    }
    if (! wp_script_is('jquery', 'enqueued')) {
        wp_enqueue_script('jquery');
    }
    // Bootstrap CSS + JS
    if (! wp_style_is('bootstrap-css', 'registered')) {
        wp_register_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', [], '5.3.0');
    }
    if (! wp_style_is('bootstrap-css', 'enqueued')) {
        wp_enqueue_style('bootstrap-css');
    }
    if (! wp_script_is('bootstrap-js', 'registered')) {
        wp_register_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', ['jquery'], '5.3.0', true);
    }
    if (! wp_script_is('bootstrap-js', 'enqueued')) {
        wp_enqueue_script('bootstrap-js');
    }
});

add_action('wp_footer', function () {
    if (! (is_page() || is_single())) return;
    global $post;

    $data = [
        'Wytworzył:'              => get_the_author_meta('display_name', $post->post_author),
        'Data wytworzenia:'       => mysql2date('d-m-Y',  $post->post_date),
        'Opublikowane przez:'     => get_the_author_meta('display_name', $post->post_author),
        'Data publikacji:'        => mysql2date('d-m-Y H:i', $post->post_date),
        'Ostatnio zaktualizował:' => mysql2date('d-m-Y H:i', $post->post_date) !== mysql2date('d-m-Y H:i', $post->post_modified)
            ? get_the_modified_author()
            : 'brak',
        'Data aktualizacji:'      => mysql2date('d-m-Y H:i', $post->post_date) !== mysql2date('d-m-Y H:i', $post->post_modified)
            ? mysql2date('d-m-Y H:i', $post->post_modified)
            : '',
        'Liczba odwiedzin:'       => null,
    ];
    $json           = wp_json_encode($data);
?>
    <script>
        jQuery(function($) {
            var meta = <?php echo $json; ?>;
            var txt = $('.mn-mn').text();
            var m = txt.match(/Liczba odwiedzin\D*([\d ]+)/i);
            meta['Liczba odwiedzin:'] = m ? m[1].replace(/\s+/g, '') : '—';
            $('.mn-mn').find('p').filter(function() {
                return /^Liczba odwiedzin/i.test($(this).text().trim());
            }).remove();
            $('<style>').text(`<?php echo get_option('metryczki_custom_css'); ?>`).appendTo('head');
            var $tbl = $('<table>').addClass('<?php echo get_option('metryczki_table_classes'); ?>');
            $.each(meta, function(label, value) {
                if (value === '' || value === null) return;
                var $tr = $('<tr>');
                $('<td>').text(label).appendTo($tr);
                $('<td>').text(value).appendTo($tr);
                $tbl.append($tr);
            });
            $('.mn-mn').append($tbl);
        });
    </script>
<?php
}, 5);
