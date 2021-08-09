<?php
/*
Plugin Name: Nox Custom Posts 2
Version: 0.7
Plugin URI:
Description: Plugin to add custom post types
Author: Nox
Author URI:
*/


function wpdocs_scripts_method() {
    wp_enqueue_script( 'custom-script-2', plugin_dir_url( __FILE__ ) . 'jquery.min.js', array(), false, true );
    wp_enqueue_script( 'custom-script-3', plugin_dir_url( __FILE__ ) . 'jquery.fancybox.min.js', array(), false, true );
    wp_enqueue_script( 'custom-script-1', plugin_dir_url( __FILE__ ) . 'box.js', array(), false, true );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_scripts_method' );



function exclude_category( $query ) { if ( $query->is_home() && $query->is_main_query() ) { $query->set( 'cat', '-261' );
add_action( 'wp_enqueue_scripts', 'wpdocs_scripts_method' );}
}

add_action( 'pre_get_posts', 'exclude_category' );



function nox_custom_scripts() {
    wp_register_style( 'custom-script-4',  plugin_dir_url( __FILE__ ) . 'jquery.fancybox.min.css' );
    wp_enqueue_style( 'custom-script-4' );
}
add_action( 'wp_enqueue_scripts', 'nox_custom_scripts' );

function all_settings_link() {
    add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
   }
add_action('admin_menu', 'all_settings_link');



add_filter( 'big_image_size_threshold', '__return_false' );



function modify_attachment_link( $markup, $id, $size, $permalink, $icon, $text )

{
        $_post = get_post( $id );

        if ( empty( $_post ) || ( 'attachment' !== $_post->post_type ) || ! wp_get_attachment_url( $_post->ID ) ) {
                return __( 'Missing Attachment' );
        }

        $url = wp_get_attachment_url( $_post->ID );

        if ( $permalink ) {
                $url = get_attachment_link( $_post->ID );
        }

        if ( $text ) {
                $link_text = $text;
        } elseif ( $size && 'none' !== $size ) {
                $link_text = wp_get_attachment_image( $_post->ID, $size, $icon, $attr );
        } else {
                $link_text = '';
        }

        if ( '' === trim( $link_text ) ) {
                $link_text = $_post->post_title;
        }

        if ( '' === trim( $link_text ) ) {
                $link_text = esc_html( pathinfo( get_attached_file( $_post->ID ), PATHINFO_FILENAME ) );
        }
        if ( is_attachment() ) {
        return "<a href='" . esc_url( $url ) . "'>$link_text</a>";
        }
    else {
     return "<a data-fancybox='gallery' href='" . esc_url( $url ) . "'>$link_text</a>";
    }
}

add_filter( 'wp_get_attachment_link', 'modify_attachment_link', 10, 6, );


remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'custom_gallery');

function custom_gallery($attr) {

    $post = get_post();
    static $instance = 0;
    $instance++;
    $attr['columns'] = 1;
    $attr['size'] = 'full';
    $attr['link'] = 'none';
    $attr['orderby'] = 'post__in';
    $attr['include'] = $attr['ids'];
    $output = apply_filters('post_gallery', '', $attr);
    if ( $output != '' )
        return $output;
    # We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
        unset( $attr['orderby'] );
    }
    extract(shortcode_atts(array(
        'order'      => 'DESC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'div',
        'icontag'    => 'div',
        'captiontag' => 'p',
        'columns'    => 1,
        'size'       => 'medium',
        'include'    => '',
        'exclude'    => ''
    ), $attr));
    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';
    if ( !empty($include) ) {
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }
    if ( empty($attachments) )
        return '';
    $gallery_style = $gallery_div = '';
    if ( apply_filters( 'use_default_gallery_style', true ) )
        $gallery_style = "<!-- see gallery_shortcode() in functions.php -->";
    $gallery_div = "<div class='gallery gallery-columns-1 gallery-size-full'>";
    $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
    foreach ( $attachments as $id => $attachment ) {
                 $lr3nfo = wp_get_attachment_metadata($id);
                 $cam = $lr3nfo[image_meta][camera];
                 $lr2nfo = "$lr3nfo[width] x $lr3nfo[height]";
                 $lr5nfo = $lr3nfo[file];
                 $lr6nfo = substr($lr5nfo, strpos($lr5nfo, "/") + 1);
                 $lr4nfo = substr($lr6nfo, strpos($lr6nfo, "/") + 1);
                 $trunc_nfo = $string = substr($lr4nfo,0,45);
				 $date5 = get_the_date('M d, Y', $attachment);

        $link = wp_get_attachment_link($id, 'medium', false, false);

        $output .= "
                         <div class='imgc'>
                $link <div class=\"dimensions\">$lr2nfo</div>
				<a href=\"/wp-content/uploads/$lr5nfo \" download> <div title=\"$lr4nfo\" class=\"filename\">$trunc_nfo</div></a>
                     
					  <div class=\"uploaded\">Uploaded: $date5</div>
            </div>";
        $output .= "";
    }
    $output .= "</div>\n";
    return $output;
}

/*
function wp78649_extend_search( $query ) {
    $search_term = filter_input( INPUT_GET, 's', FILTER_SANITIZE_NUMBER_INT) ?: 0;
    if (
        $query->is_search
        && !is_admin()
        && $query->is_main_query()
        // && your extra condition
    ) {
        $query->set('meta_query', [
            [
                'key' => 'meta_key',
                'value' => $search_term,
                'compare' => '='
            ]
        ]);

        add_filter( 'get_meta_sql', function( $sql )
        {
            global $wpdb;

            static $nr = 0;
            if( 0 != $nr++ ) return $sql;

            $sql['where'] = mb_eregi_replace( '^ AND', ' OR', $sql['where']);

            return $sql;
        });
    }
    return $query;
}

add_action( 'pre_get_posts', 'wp78649_extend_search');

*/

add_filter('wp_generate_attachment_metadata', 'add_metac', 10, 2);


function add_metac($meta, $id){

    update_post_meta($id, 'height', (int) $meta['height']);
    update_post_meta($id, 'width', (int) $meta['width']);
    update_post_meta($id, 'camera', (string) $meta['image_meta']['camera']);
    update_post_meta($id, 'date_taken', (string) $meta['image_meta']['created_timestamp']);
    update_post_meta($id, 'credit', (string) $meta['image_meta']['credit']);
	update_post_meta($id, 'copyright', (string) $meta['image_meta']['copyright']);
    update_post_meta($id, 'file', (string) $meta['file']);
    return $meta;

}

add_action( 'admin_menu', 'wpse_91693_register' );

function wpse_91693_register()
{
    add_menu_page(
        'Edit top level pages',     // page title
        'Top level pages',     // menu title
        'manage_options',   // capability
        'include-text',     // menu slug
        'wpse_91693_render' // callback function
    );
}

function wpse_91693_render()
{
    global $title;

    
    print "<h1>$title</h1>";

    $file = plugin_dir_path( __FILE__ ) . "included.html";

    if ( file_exists( $file ) )
        require $file;

    print "";

 
}