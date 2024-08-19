<?php

// -----------------------------------------------------------------------------
// Remove Scripts 
// -----------------------------------------------------------------------------
function remove_head_scripts() { 
   remove_action('wp_head', 'wp_print_scripts'); 
   remove_action('wp_head', 'wp_print_head_scripts', 9); 
   remove_action('wp_head', 'wp_enqueue_scripts', 1);
   remove_action('wp_head', 'wp_oembed_add_discovery_links');
   
   add_action('wp_footer', 'wp_print_scripts', 5);
   add_action('wp_footer', 'wp_enqueue_scripts', 5);
   add_action('wp_footer', 'wp_print_head_scripts', 5); 
} 
add_action( 'wp_enqueue_scripts', 'remove_head_scripts' );

// Remove wp-embed, jquery
function my_deregister_scripts(){
    wp_deregister_script( 'wp-embed' );
    wp_deregister_script( 'jquery' );
    wp_deregister_script( 'jquery-migrate' );
}
add_action( 'init', 'my_deregister_scripts' );

// Remove Gutenberg CSS
function wpassist_remove_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
} 
add_action( 'wp_enqueue_scripts', 'wpassist_remove_block_library_css' );

// -----------------------------------------------------------------------------
// Desabilitando novos temas
// -----------------------------------------------------------------------------
function __block_caps( $caps, $cap )
{
    if ( $cap === 'install_themes' )
        $caps[] = 'do_not_allow';
    return $caps;
}
add_filter( 'map_meta_cap', '__block_caps', 10, 2 );


// -----------------------------------------------------------------------------
// Incluo algumas informações no contexto do Timber
// -----------------------------------------------------------------------------
function add_api_maps_context($data) {
    // API Key Maps - Timber
    global $api_maps;
    
    $data['api_maps'] = $api_maps;

    return $data;
}
add_filter('timber_context', 'add_api_maps_context');


// -----------------------------------------------------------------------------
// API Key Google Maps
// -----------------------------------------------------------------------------
function apikey($return) {
    global $api_maps;
    
    $return['key'] = $api_maps;

    return $return;
}
add_filter('acf/fields/google_map/api', 'apikey');


// -----------------------------------------------------------------------------
// Adicionando Filtros e Funcoes no Timber
// -----------------------------------------------------------------------------
function add_to_twig($twig) {
    $twig->addExtension(new Twig_Extension_StringLoader());
    
    // Filters
    $twig->addFilter(new Twig_SimpleFilter('text_custom', 'text_custom'));
    
    // Functions
    $twig->addFunction(new Twig_SimpleFunction('get_page_class', 'get_page_class'));
    $twig->addFunction(new Twig_SimpleFunction('is_active', 'is_active'));
    $twig->addFunction(new Twig_SimpleFunction('option', 'option'));
    $twig->addFunction(new Twig_SimpleFunction('social_share', 'social_share'));
    $twig->addFunction(new Twig_SimpleFunction('asset', 'asset'));

    return $twig;
}
add_filter('timber/twig', 'add_to_twig');


// -----------------------------------------------------------------------------
// Filtro para converter <<texto>> em <span>texto</span>
// -----------------------------------------------------------------------------
function text_custom($text) {
    $text = htmlspecialchars_decode($text);
    $newtext = str_replace(array('<<', '>>'), array('<span>', '</span>'), $text);
    return $newtext;
}

// Ajustando wp_title para Título personalizados
function wp_title_custom() {
    $_post = get_queried_object();
 
    if ( is_single() || ( is_home() && ! is_front_page() ) || ( is_page() && ! is_front_page() ) ) {
        $title = str_replace(array('<<', '>>'), array('', ''), $_post->post_title);
    }

    // If there's a post type archive
    if ( is_post_type_archive() ) {
        $post_type = get_query_var( 'post_type' );
        if ( is_array( $post_type ) ) {
            $post_type = reset( $post_type );
        }
        $post_type_object = get_post_type_object( $post_type );
        if ( ! $post_type_object->has_archive ) {
            $title = post_type_archive_title( '', false );
        }
    }
 
    // If there's a category or tag
    if ( is_category() || is_tag() ) {
        $title = single_term_title( '', false );
    }
 
    // If there's a taxonomy
    if ( is_tax() ) {
        $term = get_queried_object();
        if ( $term ) {
            $tax   = get_taxonomy( $term->taxonomy );
            $title = single_term_title( $tax->labels->name . ' ' . $t_sep, false );
        }
    }
 
    // If there's an author
    if ( is_author() && ! is_post_type_archive() ) {
        $author = get_queried_object();
        if ( $author ) {
            $title = $author->display_name;
        }
    }
 
    // Post type archives with has_archive should override terms.
    if ( is_post_type_archive() && $post_type_object->has_archive ) {
        $title = post_type_archive_title( '', false );
    }
 
    // If there's a month
    if ( is_archive() && ! empty( $m ) ) {
        $my_year  = substr( $m, 0, 4 );
        $my_month = $wp_locale->get_month( substr( $m, 4, 2 ) );
        $my_day   = intval( substr( $m, 6, 2 ) );
        $title    = $my_year . ( $my_month ? $t_sep . $my_month : '' ) . ( $my_day ? $t_sep . $my_day : '' );
    }
 
    // If there's a year
    if ( is_archive() && ! empty( $year ) ) {
        $title = $year;
        if ( ! empty( $monthnum ) ) {
            $title .= $t_sep . $wp_locale->get_month( $monthnum );
        }
        if ( ! empty( $day ) ) {
            $title .= $t_sep . zeroise( $day, 2 );
        }
    }
 
    // If it's a search
    if ( is_search() ) {
        /* translators: 1: separator, 2: search phrase */
        $title = sprintf( __( 'Search Results %1$s %2$s' ), $t_sep, strip_tags( $search ) );
    }
 
    // If it's a 404 page
    if ( is_404() ) {
        $title = __( 'Page not found' );
    }
 
    $prefix = '';
    if ( ! empty( $title ) ) {
        $prefix = " $sep ";
    }
    
    return $title;
}
add_filter( 'wp_title', 'wp_title_custom', 10, 2 );

// -----------------------------------------------------------------------------
// Funcao para retornar slug ou tipo de post
// -----------------------------------------------------------------------------
function get_page_class() {

    global $wp_query;
    $query = $wp_query->query;
    $slug  = get_post( $post )->post_name;

    if (is_singular('post')):
        $return = 'single';
    else :
        if ( ! empty( $query['post_type'] ) ) :
            $return = $query['post_type'];
        else:
            $return = $slug;
        endif;
    endif;

    return $return;
}


// -----------------------------------------------------------------------------
// Funcao que checa a se o link da pagina esta ativo
// -----------------------------------------------------------------------------
function is_active($pag) {
    $slug = get_page_class();

    if ( is_array($pag) ) :
        foreach ($pag as $p) :
            if ( $slug == $p ) return "_active";
        endforeach;
    else :
        if ( $slug == $pag ) return "_active";
    endif;
}


// -----------------------------------------------------------------------------
// Funções para PAGE OPTION
// -----------------------------------------------------------------------------
function option($op) {
    $return = get_field($op, 'option');
    return $return;
}

function get_option_mapa() {
    global $api_maps;
    
    $option = get_field('mapa', 'option');
    if ($option and $api_maps) {
        echo "<script type='text/javascript'>
        function initMapa() {
            // Gmap3
            $('.mapa')
              .gmap3({
                center:[".str_replace(',', '.', $option['lat']).", ".str_replace(',', '.', $option['lng'])."],
                zoom: 17,
                mapTypeControl: true,
                navigationControl: false,
                scrollwheel: false,
                streetViewControl: true
              })
              .marker([
                {
                    position:[".str_replace(',', '.', $option['lat']).", ".str_replace(',', '.', $option['lng'])."],
                },
              ]);
        }
        </script>

        <script src='https://maps.googleapis.com/maps/api/js?key=".$api_maps."&callback=initMapa'></script>";
    }
}

function get_google_analytics() {
    $option = get_field('google_analytics', 'option');
    if ($option) {
        echo "<script async src=\"https://www.googletagmanager.com/gtag/js?id=".$option."\"></script>
                <script>
                  window.dataLayer = window.dataLayer || [];
                  function gtag(){dataLayer.push(arguments);}
                  gtag('js', new Date());
                  gtag('config', '".$option."');
            </script>";
    }
}
add_action( 'wp_footer', 'get_google_analytics' );


function get_pixel_facebook() {
    $option = get_field('pixel_facebook', 'option');
    if ($option) {
        echo "<script>
            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '".$option."');
            fbq('track', 'PageView');
        </script>
        <noscript><img height='1' width='1' style='display:none'
        src='https://www.facebook.com/tr?id=".$option."&ev=PageView&noscript=1'
        /></noscript>";
    }
}
add_action( 'wp_footer', 'get_pixel_facebook' );


// -----------------------------------------------------------------------------
// Exibir compartilhamento de redes sociais
// -----------------------------------------------------------------------------
function social_share($share) {
    $url         = get_permalink();
    $title       = get_the_title();
    $blog_name   = get_option( 'blogname' );
    $blog_name   = get_option( 'blogname' );
    $encoded_url = urlencode( $url );
    $text        = $title . ' - ' . $blog_name;
    $media       = get_field('imagem') ? get_field('meta_imagem', 'option') : get_field('meta_imagem', 'option');
 
    if ($share == 'all') {
        $share = 'facebook, twitter, gplus, linkedin, pinterest, email, whatsapp';
    }

    $share = explode(', ',strtolower($share));

    $html = '<ul class="Redes-sociais _unstyled">'; 

    foreach ($share as $rede) {
        if ($rede == 'facebook') {
            $html .= '<li class="facebook"><a href="https://www.facebook.com/sharer.php?u=' . $encoded_url . '" target="_blank" title="Facebook"><i class="icon-facebook"></i></a></li>';
        } elseif ($rede == 'twitter') {
            $html .= '<li class="twitter"><a href="https://twitter.com/share?text=' . urlencode( $text ) . '&url=' . $encoded_url . '" target="_blank" title="Tweet"><i class="icon-twitter"></i></a></li>'; 
        } elseif ($rede == 'gplus') {
            $html .= '<li class="gplus"><a href="https://plus.google.com/share?url=' . $encoded_url . '" target="_blank" title="G+"><i class="icon-gplus"></i></a></li>'; 
        } elseif ($rede == 'linkedin') {
            $html .= '<li class="linkedin"><a href="https://www.linkedin.com/shareArticle?mini=true&url=' . $encoded_url . '" target="_blank" title="Linkedin"><i class="icon-linkedin"></i></a></li>';
        } elseif ($rede == 'pinterest') {
            $html .= '<li class="pinterest"><a href="https://www.pinterest.com/pin/create/button/?url=' . $encoded_url . '&media=' . $media . '&description=' . urlencode( $title . ' - ' . $url ) . '" target="_blank" title="Pinterest"><i class="icon-pinterest"></i></a></li>';
        } elseif ($rede == 'email') {
            $html .= '<li class="email"><a href="mailto:?subject=' . $text . '&body=' . $text . ': ' . $encoded_url . '" title="Email"><i class="icon-mail"></i></a></li>';
        } elseif ($rede == 'whatsapp') {
            $html .= '<li class="whatsapp"><a href="https://api.whatsapp.com/send?text=' . $text . ':%20' . $encoded_url . '" target="_blank" title="Whatsapp"><i class="icon-whatsapp"></i></a></li>';
        }
    }

    $html .= '</ul>';
    
    echo wp_kses_post($html);
}

/**
 * Outputs the variable
 */
if ( !function_exists('dump') ) {
    function dump($var) {
        if ( is_array($var) || is_object($var) ) {
            echo '<pre>';
            print_r($var);
            echo '</pre>';
        } else {
            var_dump($var);
        }
    }
}

/**
 * Outputs the variable and die()
 */
if ( !function_exists('dd') ) {
    function dd($var) {
        dump($var);
        die();
    }
}

// -----------------------------------------------------------------------------
// Gerar fotos do instagram
// -----------------------------------------------------------------------------
function instagram($value, $qtd) {

    if (preg_match('/\#\b/', $value)) {
        $hashtag = str_replace('#', '', $value);
        $url = 'https://www.instagram.com/explore/tags/'. $hashtag .'/?__a=1';
    } else {
        $url = 'https://www.instagram.com/'. $value .'/?__a=1';
    }

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $response = json_decode($response);

    if (preg_match('/\#\b/', $value)) {
        $formatted = $response->graphql->hashtag->edge_hashtag_to_media->edges;
    } else {
        $formatted = $response->graphql->user->edge_owner_to_timeline_media->edges;
    }

    $images = array();

    if ($formatted) {
        foreach ($formatted as $key) {
            $images[] = array(
                'image'  => $key->node->display_url,
                'link'   => 'https://www.instagram.com/p/'.$key->node->shortcode
            );
        }
    }

    $data['instagram_images'] = array_slice($images, 0, $qtd);

    return $data['instagram_images'];
}

function asset($url) {
    $file_url = get_template_directory() . '/assets/'. $url;
    $url      = get_template_directory_uri() . '/assets/' . $url . '?v=' . date('dmYHis', filemtime($file_url));

    return $url;
}