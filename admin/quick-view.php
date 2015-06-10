 <?php
 add_filter('woocommerce_general_settings', 'pqv_button_setting');

    function pqv_button_setting($settings) {
        $updated_settings = array();



        foreach ($settings as $section) {



            // at the bottom of the General Options section

            if (isset($section['id']) && 'general_options' == $section['id'] &&
                    isset($section['type']) && 'sectionend' == $section['type']) {



                $updated_settings[] = array(
                    'name' => __('Quick View', 'wc_quick_view'),
                    'desc_tip' => __('The Quick View of Product.', 'wc_quick_view'),
                    'id' => 'woocommerce_product_quick_view',
                    'type' => 'checkbox',
                    'css' => 'min-width:300px;',
                    'std' => '1', // WC < 2.0

                    'default' => '1', // WC >= 2.0
                );
            }



            $updated_settings[] = $section;
        }

        return $updated_settings;
    }