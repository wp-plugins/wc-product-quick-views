<?php
/*
  Plugin Name: Products Quick View
  Description: This plugin adds the ultimate Quick View feature to your Shop page, Product category and Product tags listings.
  Version:
  Author: Satyendra Mishra
  Author URI: http://www.infoway.us
 */
?>
<?php
add_action('plugins_loaded', 'pqv_callback');

function pqv_callback() {

    define('PQV_FILE_PATH', dirname(__FILE__));
    define('PQV_FOLDER', dirname(plugin_basename(__FILE__)));
    define('PQV_URL', untrailingslashit(plugins_url('/', __FILE__)));
    define('PQV_NAME', plugin_basename(__FILE__));
    define('PQV_IMAGES_URL', PQV_URL . '/assets/images');
    define('PQV_JS_URL', PQV_URL . '/assets/js');
    define('PQV_CSS_URL', PQV_URL . '/assets/css');

    include ('admin/quick-view.php');

    function pqv_enqueue() {       
        wp_enqueue_script('thickbox');        
        wp_enqueue_script('pqv_custom_script', PQV_JS_URL . '/quick-view.js');
    }

    add_action('admin_enqueue_scripts', 'pqv_enqueue');
    
    function pqv_enqueue_style(){
         wp_enqueue_style('pqv-main-style', PQV_CSS_URL . '/style.css');
    }
    
    add_action('wp_enqueue_scripts', 'pqv_enqueue_style');

    add_action('woocommerce_after_shop_loop_item', 'pqv_button', 11);

    function pqv_button() {
        global $product;
        global $woocommerce;
        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        $woocommerce_db_version = get_option('woocommerce_db_version', null);

        $frontend_script_path = ( ( version_compare($woocommerce_db_version, '2.1', '<') ) ? $woocommerce->plugin_url() : WC()->plugin_url() ) . '/assets/js/frontend/';

        if (get_option('woocommerce_product_quick_view') == 'yes'):
            ?>
            <?php add_thickbox(); ?>
            <div id="my-content<?php echo $product->id; ?>" style="display:none;">
                <?php do_action('woocommerce_before_single_product_summary'); ?>
                <div class="summary entry-summary">
                    <?php do_action('woocommerce_single_product_summary'); ?>
                </div>
                <?php
                do_action('woocommerce_after_single_product_summary');
                ?>
              
            </div>

            <a href="TB_inline?width=600&height=550&inlineId=my-content<?php echo $product->id; ?>" class="quick-view thickbox">Quick View</a>
            <?php
        endif;
    }

}
?>