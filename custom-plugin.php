<?php
/*
Plugin Name: Redeal Referral Marketing
Plugin URI: https://www.redeal.se
Description: Redeal Referral Marketing
Version: 1.0.1
Author: Redeal STHLM AB
Author URI: https://www.redeal.se/en/get-started
License: GPL2
*/

	if ( is_admin() ) {		
		
		require_once dirname(__FILE__) . '/admin.php';	
		
        function redeal_section_after_title( $args ) {
            ?>
			<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Set below details to display redeal popup on thank you page.', 'wporg' ); ?></p>
            <?php
        }


        function redeal_field_configuration( $args ) {
			
			do_action('redeal_fields');			
			apply_filters( 'redeal_fields_filter', 'code to be filtered goes here' ); 
            // get the value of the setting we've registered with register_setting()
            $options = get_option( 'redeal_options' );
            // output the field
            ?>
			<select id="<?php echo esc_attr( $args['label_for'] ); ?>"
					data-custom="<?php echo esc_attr( $args['redeal_custom_data'] ); ?>"
					name="redeal_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			>
				<option value="1" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], '1', false ) ) : ( '' ); ?>>
                    <?php esc_html_e( 'Yes', 'redeal' ); ?>
				</option>
				<option value="0" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], '0', false ) ) : ( '' ); ?>>
                    <?php esc_html_e( 'No', 'redeal' ); ?>
				</option>
			</select>
			<p class="description">
			
                <?php esc_html_e( 'Enable or disable Redeal Referralmarketing extension', 'redeal' ); ?>
			</p>

            <?php
        }
        function redeal_field_input($args){
            $options = get_option( 'redeal_options' );
            ?>
			<input type="text" id="redeal_field_container"
				   data-custom="<?php echo esc_attr( $args['redeal_custom_data'] ); ?>"
				   name="redeal_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
				   value="<?php echo esc_attr( $options[$args['label_for']] ); ?>">
            <?php
        }
		/*function redeal_field_environment($args){
			
			
			$options = get_option( 'redeal_options' );
			
			?>
			<select id="<?php echo esc_attr( $args['label_for'] ); ?>"
					data-custom="<?php echo esc_attr( $args['redeal_custom_data'] ); ?>"
					name="redeal_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			>
				<option value="1" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], '1', false ) ) : ( '' ); ?>>
                    <?php esc_html_e( 'Live', 'redeal' ); ?>
				</option>
				<option value="0" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], '0', false ) ) : ( '' ); ?>>
                    <?php esc_html_e( 'Test', 'redeal' ); ?>
				</option>
			</select>
			<p class="description">				
                <?php esc_html_e( 'Set Environment for Redeal Referralmarketing extension', 'redeal' ); ?>
			</p>
			<?php
		}*/
        /**
         * top level menu
         */
        function redeal_options_page() {
            // add top level menu page
            add_menu_page(
                'Redeal Referralmarketing Options',
                'Redeal Configurations',
                'manage_options',
                'redeal-referral-marketing',
                'redeal_options_page_html'
            );

        }

        /**
         * register our wporg_options_page to the admin_menu action hook
         */
        add_action( 'admin_menu', 'redeal_options_page' );

        /**
         * top level menu:
         * callback functions
         */
        function redeal_options_page_html() {
            // check user capabilities
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }

            // add error/update messages

            // check if the user have submitted the settings
            // wordpress will add the "settings-updated" $_GET parameter to the url
            if ( isset( $_GET['settings-updated'] ) ) {
                // add settings saved message with the class of "updated"
                add_settings_error( 'redeal_messages', 'redeal_message', __( 'Settings Saved', 'redeal' ), 'updated' );
            }

            // show error/update messages
            settings_errors( 'redeal_messages' );
            ?>
			<div class="wrap">
				<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
				<form action="options.php" method="post">
                    <?php
                    // output security fields for the registered setting "redeal"
                    settings_fields( 'redeal' );
                    // output setting sections and their fields
                    // (sections are registered for "redeal", each field is registered to a specific section)
                    do_settings_sections( 'redeal' );
                    // output save settings button
                    submit_button( 'Save Settings' );
                    ?>
				</form>
			</div>
            <?php
        }
	}
function add_script_header(){ 
	error_reporting(0);
	$options = get_option( 'redeal_options' );
	
	?>
    <script>	
	(function(i,s,o,g,r,a,m){i['RedealObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window, document, 'script', window.location.protocol + '//widget.redeal.se/js/redeal.js', 'redeal');
    </script>	
	<?php 
     if(is_wc_endpoint_url( 'order-received' )) {
        

        //check option is enable.
        if($options['redeal_field_enable'] == 1){
            if(isset($options['redeal_field_container'])){
                $containerId = $options['redeal_field_container'];
            }
        ?>
        <!-- Bhavik Google Tag Manager -->
        <script>
            var containerId = "<?php echo $containerId; ?>";

            (function (w, d, s, l, i) {
                //alert(containerId);
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(), event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';

                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', containerId);</script>
        
        <?php
            global $wp;
            //check if on view-order page and get parameter is available
			if(isset($_GET['view-order'])) {
				$order_id = $_GET['view-order'];
			}
			//check if on view order-received page and get parameter is available
			else if(isset($_GET['order-received'])) {
				$order_id = $_GET['order-received'];
			}
			//no more get parameters in the url
			else {
				$url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
				$template_name = strpos($url,'/order-received/') === false ? '/view-order/' : '/order-received/';
				if (strpos($url,$template_name) !== false) {
					$start = strpos($url,$template_name);
					$first_part = substr($url, $start+strlen($template_name));
					$order_id = substr($first_part, 0, strpos($first_part, '/'));
				}
			}
            $order = new WC_Order( $order_id );
		
			$coupons = $order->get_used_coupons();
   			$items = $order->get_items();
			
			
			$products = array();
			$ecommerce = array();
			$products['id'] = ($order_id != '') ? $order_id : '';
			$products['total'] = ($order->data['total'] != '') ? $order->data['total'] : '';
			$products['price'] = 0;
			$products['tax'] = ($order->data['total_tax'] != '') ? $order->data['total_tax'] : '';
			$products['shipping'] = ( $order->get_total_shipping() != '') ?  $order->get_total_shipping() : '';
			$products['currency'] = ($order->data['currency'] != '') ? $order->data['currency'] : '';
			$products['country'] = ($default['country'] != '') ? $order->data['country'] : 'SE';
			$products['language'] = ($order->data['language'] != '') ? $order->data['language'] : 'sv';
			$products['email'] = ($order->data['billing']['email'] != '') ? $order->data['billing']['email'] : '';
			$products['phone'] = ($order->data['billing']['phone'] != '') ? $order->data['billing']['phone'] : '';
			$products['name'] = ($order->data['billing']['first_name'] != '') ? $order->data['billing']['first_name'] : '';
			$products['coupons'] = (!empty($coupons)) ? $coupons : '';
			
        	
			// Loop through ordered items
				 $i = 0;
				foreach ($items as $item) {
				 
					$term_list = wp_get_post_terms($item['product_id'], 'product_cat', array('fields' => 'names'));
				// Check if product has variation.
				  if ($products['product'][$i]->product_variation_id) { 
					$product = new WC_Product($item['variation_id']);
					  
				  } else {
					$product = new WC_Product($item['product_id']);
				  }

				  // Redeal
				  if(!empty($product)){					  
					  $products['product'][$i]->sku = $product->get_sku();				  			  
					  $products['product'][$i]->price = ($item['total']) ? $item['total'] : '';
					  $products['product'][$i]->category = ($term_list) ? implode(',',$term_list) : '';
					  $products['product'][$i]->quantity = ($item['qty']) ? $item['qty'] : '';	
					  $products['price'] = (string)($products['price'] + $products['product'][$i]->price);
					 
				  }
			 
				  
				// DataLayer
				  $ecommerce['ecommerce']['purchase']['products']->id = ($item['product_id'] != '') ? $item['product_id'] : '';
					$ecommerce['ecommerce']['purchase']['products']->name = ($item['name'] != '') ? $item['name'] : '';
					$ecommerce['ecommerce']['purchase']['products']->price = ($item['total'] != '') ? $item['total'] : '';
					$ecommerce['ecommerce']['purchase']['products']->brand = ($item['brand'] != '') ? $item['brand'] : '';
					$ecommerce['ecommerce']['purchase']['products']->category = (!empty($term_list)) ? implode(',',$term_list) : '';
					$ecommerce['ecommerce']['purchase']['products']->variant = ($product->get_formatted_name() != '') ? $product->get_formatted_name() : '';
					$ecommerce['ecommerce']['purchase']['products']->quantity = ($item['qty'] != '') ? $item['qty'] : '';
					$ecommerce['ecommerce']['purchase']['products']->coupon = (!empty($coupons)) ? $coupons : '';	
				  	
				  $i++;	
				}
			$products['revenue'] = (string)($products['price'] + $products['shipping']);
			//$products['total'] = $products['revenue']+ $products['tax'];
			//DataLayer Option	
			
			
			$ecommerce['ecommerce']['purchase']['actionField']['id'] = ($order_id != '') ? $order_id : '';
			$ecommerce['ecommerce']['purchase']['actionField']['affiliation'] = ($affiliation != '') ? $affiliation : 'Online Store';
			$ecommerce['ecommerce']['purchase']['actionField']['revenue'] = ($products['revenue'] != '') ? $products['revenue'] : '';
			$ecommerce['ecommerce']['purchase']['actionField']['tax'] = ($products['tax'] != '') ? $products['tax'] : '';
			$ecommerce['ecommerce']['purchase']['actionField']['shipping'] = ( $order->get_total_shipping() != '') ?  $order->get_total_shipping() : '';
			$ecommerce['ecommerce']['purchase']['actionField']['coupon'] = (!empty($coupons)) ? $coupons : '';
            ?>
        <script type="text/javascript">
			//debugger++;
			var checkOutData = <?php echo json_encode($products); ?>;
			var pushCheckOutData = <?php echo json_encode($ecommerce); ?>;

            redeal('checkout', checkOutData );
			
            window.dataLayer = window.dataLayer || [];
            dataLayer.push(pushCheckOutData);
        </script>
        <!-- End Google Tag Manager -->

        <?php
        }
    }
}
add_action('wp_head','add_script_header', 10, 1);