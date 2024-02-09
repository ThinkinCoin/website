<?php

if ( ! defined( 'myCRED_VERSION' ) ) exit;

/**
 * myCRED_Addons_Module class
 * @since 0.1
 * @version 1.1.1
 */

if ( ! class_exists( 'myCRED_Addons_Module' ) ) :
	class myCRED_Addons_Module extends myCRED_Module {

		/**
		 * Construct
		 */
		public function __construct( $type = MYCRED_DEFAULT_TYPE_KEY ) {

			parent::__construct( 'myCRED_Addons_Module', array(
				'module_name' => 'addons',
				'option_id'   => 'mycred_pref_addons',
				'defaults'    => array(
					'installed'     => array(),
					'active'        => array()
				),
				'labels'      => array(
					'menu'        => __( 'Add-ons', 'mycred' ),
					'page_title'  => __( 'Add-ons', 'mycred' )
				),
				'screen_id'   => MYCRED_SLUG . '-addons',
				'accordion'   => true,
				'menu_pos'    => 30,
				'main_menu'   => true
			), $type );

		}

		/**
		 * Admin Init
		 * Catch activation and deactivations
		 * @since 0.1
		 * @version 1.2.2
		 */
		public function module_admin_init() {

			// Handle actions
			if ( isset( $_GET['addon_action'] ) && isset( $_GET['addon_id'] ) && isset( $_GET['_token'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_token'] ) ), 'mycred-activate-deactivate-addon' ) && $this->core->user_is_point_admin() ) {

				$addon_id = sanitize_text_field( wp_unslash( $_GET['addon_id'] ) );
				$action   = sanitize_text_field( wp_unslash( $_GET['addon_action'] ) );

				$this->get();
				if ( array_key_exists( $addon_id, $this->installed ) ) {

					// Activation
					if ( $action == 'activate' ) {
						// Add addon id to the active array
						$this->active[] = $addon_id;
						$result         = 1;
					}

					// Deactivation
					elseif ( $action == 'deactivate' ) {
						// Remove addon id from the active array
						$index = array_search( $addon_id, $this->active );
						if ( $index !== false ) {
							unset( $this->active[ $index ] );
							$result = 0;
						}

						// Run deactivation now before the file is no longer included
						do_action( 'mycred_addon_deactivation_' . $addon_id );
					}

					$new_settings = array(
						'installed' => $this->installed,
						'active'    => $this->active
					);

					mycred_update_option( 'mycred_pref_addons', $new_settings );

					$url = add_query_arg( array( 'page' => MYCRED_SLUG . '-addons', 'activated' => $result, $addon_id => $action ), admin_url( 'admin.php' ) );

					wp_safe_redirect( $url );
					exit;

				}

			}

			$this->all_activate_deactivate();
		}


		public function all_activate_deactivate() {

			// Handle actions
			if ( isset( $_GET['addon_all_action'] ) && isset( $_GET['_token'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_token'] ) ), 'mycred-activate-deactivate-addon') && $this->core->user_is_point_admin() ) {

				$action = sanitize_text_field( wp_unslash( $_GET['addon_all_action'] ) );

				if ( $action == 'activate' ) {

					$this->active = array_keys( $this->installed );

				}
				elseif ( $action == 'deactivate' ) {

					$this->active = array();
					
				}

				$new_settings = array(
					'installed' => $this->installed,
					'active'    => $this->active
				);

				mycred_update_option( 'mycred_pref_addons', $new_settings );

				$url = add_query_arg( array( 'page' => MYCRED_SLUG . '-addons' ), admin_url( 'admin.php' ) );

				wp_safe_redirect( $url );
				exit;
			
			}

		}

		/**
		 * Run Addons
		 * Catches all add-on activations and deactivations and loads addons
		 * @since 0.1
		 * @version 1.2
		 */
		public function run_addons() {

			// Make sure each active add-on still exists. If not delete.
			if ( ! empty( $this->active ) ) {
				$active = array_unique( $this->active );
				$_active = array();
				foreach ( $active as $pos => $active_id ) {
					if ( array_key_exists( $active_id, $this->installed ) ) {
						$_active[] = $active_id;
					}
				}
				$this->active = $_active;
			}

			// Load addons
			foreach ( $this->installed as $key => $data ) {
				if ( $this->is_active( $key ) ) {

					if ( apply_filters( 'mycred_run_addon', true, $key, $data, $this ) === false || apply_filters( 'mycred_run_addon_' . $key, true, $data, $this ) === false ) continue;

					// Core add-ons we know where they are
					if ( file_exists( myCRED_ADDONS_DIR . $key . '/myCRED-addon-' . $key . '.php' ) )
						include_once myCRED_ADDONS_DIR . $key . '/myCRED-addon-' . $key . '.php';

					// If path is set, load the file
					elseif ( isset( $data['path'] ) && file_exists( $data['path'] ) )
						include_once $data['path'];

					else {
						continue;
					}

					// Check for activation
					if ( $this->is_activation( $key ) )
						do_action( 'mycred_addon_activation_' . $key );

				}
			}

		}

		/**
		 * Is Activation
		 * @since 0.1
		 * @version 1.0
		 */
		public function is_activation( $key ) {

			if ( isset( $_GET['addon_action'] ) && isset( $_GET['addon_id'] ) && $_GET['addon_action'] == 'activate' && $_GET['addon_id'] == $key )
				return true;

			return false;

		}

		/**
		 * Is Deactivation
		 * @since 0.1
		 * @version 1.0
		 */
		public function is_deactivation( $key ) {

			if ( isset( $_GET['addon_action'] ) && isset( $_GET['addon_id'] ) && $_GET['addon_action'] == 'deactivate' && $_GET['addon_id'] == $key )
				return true;

			return false;

		}

		/**
		 * Get Addons
		 * @since 0.1
     * @since 2.5.0 Added `badge-plus`
		 * @version 1.7.3
		 */
		public function get( $save = false ) {

			$installed = array();

			// Badges Add-on
			$installed['badges'] = array(
				'name'        => 'Badges',
				'description' => __( 'Give your users badges based on their interaction with your website.', 'mycred' ),
				'addon_url'   => 'http://codex.mycred.me/chapter-iii/badges/',
				'version'     => '1.3',
				'author'      => 'myCred',
				'author_url'  => 'https://www.mycred.me',
				'screenshot'  => plugins_url( 'assets/images/badges-addon.png', myCRED_THIS ),
				'requires'    => array()
			);

			// buyCRED Add-on
			$installed['buy-creds'] = array(
				'name'        => 'buyCRED',
				'description' => __( 'The <strong>buy</strong>CRED Add-on allows your users to buy points using PayPal, Skrill (Moneybookers) or NETbilling. <strong>buy</strong>CRED can also let your users buy points for other members.', 'mycred' ),
				'addon_url'   => 'http://codex.mycred.me/chapter-iii/buycred/',
				'version'     => '1.5',
				'author'      => 'myCred',
				'author_url'  => 'https://www.mycred.me',
				'screenshot'  => plugins_url( 'assets/images/buy-creds-addon.png', myCRED_THIS ),
				'requires'    => array()
			);
			
			// cashCRED Add-on
			$installed['cash-creds'] = array(	
				'name'        => 'cashCRED',
				'description' => __( '', 'mycred' ),
				'addon_url'   => 'https://codex.mycred.me/chapter-iii/cashcred/',
				'version'     => '1.0',
				'author'      => 'Gabriel S Merovingi',
				'author_url'  => 'https://www.merovingi.com',
				'screenshot'  => plugins_url( 'assets/images/banking-addon.png', myCRED_THIS ),
				'requires'    => array()
			);

			// Central Deposit Add-on
			$installed['banking'] = array(
				'name'        => 'Central Deposit',
				'description' => __( 'Setup recurring payouts or offer / charge interest on user account balances.', 'mycred' ),
				'addon_url'   => 'https://codex.mycred.me/chapter-iii/central-deposit-add-on/',
				'version'     => '2.0',
				'author'      => 'myCred',
				'author_url'  => 'https://www.mycred.me',
				'screenshot'  => plugins_url( 'assets/images/banking-addon.png', myCRED_THIS ),
				'requires'    => array()
			);

			// Coupons Add-on
			$installed['coupons'] = array(
				'name'        => 'Coupons',
				'description' => __( 'The coupons add-on allows you to create coupons that users can use to add points to their accounts.', 'mycred' ),
				'addon_url'   => 'http://codex.mycred.me/chapter-iii/coupons/',
				'version'     => '1.4',
				'author'      => 'myCred',
				'author_url'  => 'https://www.mycred.me',
				'screenshot'  => plugins_url( 'assets/images/coupons-addon.png', myCRED_THIS ),
				'requires'    => array()
			);

			// Email Notices Add-on
			$installed['email-notices'] = array(
				'name'        => 'Email Notifications',
				'description' => __( 'Create email notices for any type of myCRED instance.', 'mycred' ),
				'addon_url'   => 'http://codex.mycred.me/chapter-iii/email-notice/',
				'version'     => '1.4',
				'author'      => 'myCred',
				'author_url'  => 'https://www.mycred.me',
				'screenshot'  => plugins_url( 'assets/images/email-notifications-addon.png', myCRED_THIS ),
				'requires'    => array()
			);

			// Gateway Add-on
			$installed['gateway'] = array(
				'name'        => 'Gateway',
				'description' => __( 'Let your users pay using their <strong>my</strong>CRED points balance. Supported Carts: WooCommerce, MarketPress and WP E-Commerce. Supported Event Bookings: Event Espresso and Events Manager (free & pro).', 'mycred' ),
				'addon_url'   => 'http://codex.mycred.me/chapter-iii/gateway/',
				'version'     => '1.4',
				'author'      => 'myCred',
				'author_url'  => 'https://www.mycred.me',
				'screenshot'  => plugins_url( 'assets/images/gateway-addon.png', myCRED_THIS ),
				'requires'    => array()
			);

			// Notifications Add-on
			$installed['notifications'] = array(
				'name'        => 'Notifications',
				'description' => __( 'Create pop-up notifications for when users gain or loose points.', 'mycred' ),
				'addon_url'   => 'http://codex.mycred.me/chapter-iii/notifications/',
				'version'     => '1.1.2',
				'author'      => 'myCred',
				'author_url'  => 'https://www.mycred.me',
				'pro_url'     => 'https://mycred.me/store/notifications-plus-add-on/',
				'screenshot'  =>  plugins_url( 'assets/images/notifications-addon.png', myCRED_THIS ),
				'requires'    => array()
			);

			// Ranks Add-on
			$installed['ranks'] = array(
				'name'        => 'Ranks',
				'description' => __( 'Create ranks for users reaching a certain number of %_plural% with the option to add logos for each rank.', 'mycred' ),
				'addon_url'   => 'http://codex.mycred.me/chapter-iii/ranks/',
				'version'     => '1.6',
				'author'      => 'myCred',
				'author_url'  => 'https://www.mycred.me',
				'screenshot'  => plugins_url( 'assets/images/ranks-addon.png', myCRED_THIS ),
				'requires'    => array()
			);

			// Sell Content Add-on
			$installed['sell-content'] = array(
				'name'        => 'Sell Content',
				'description' => __( 'This add-on allows you to sell posts, pages or any public post types on your website. You can either sell the entire content or using our shortcode, sell parts of your content allowing you to offer "teasers".', 'mycred' ),
				'addon_url'   => 'http://codex.mycred.me/chapter-iii/sell-content/',
				'version'     => '2.0.1',
				'author'      => 'myCred',
				'author_url'  => 'https://www.mycred.me',
				'screenshot'  => plugins_url( 'assets/images/sell-content-addon.png', myCRED_THIS ),
				'requires'    => array( 'log' )
			);

			// Statistics Add-on
			$installed['stats'] = array(
				'name'        => 'Statistics',
				'description' => __( 'Gives you access to your myCRED Statistics based on your users gains and loses.', 'mycred' ),
				'addon_url'   => 'http://codex.mycred.me/chapter-iii/statistics/',
				'version'     => '2.0',
				'author'      => 'myCred',
				'author_url'  => 'https://www.mycred.me',
				'screenshot'  => plugins_url( 'assets/images/statistics-addon.png', myCRED_THIS )
			);

			// Transfer Add-on
			$installed['transfer'] = array(
				'name'        => 'Transfers',
				'description' => __( 'Allow your users to send or "donate" points to other members by either using the mycred_transfer shortcode or the myCRED Transfer widget.', 'mycred' ),
				'addon_url'   => 'http://codex.mycred.me/chapter-iii/transfers/',
				'version'     => '1.6',
				'author'      => 'myCred',
				'author_url'  => 'https://www.mycred.me',
				'pro_url'     => 'https://mycred.me/store/transfer-plus/',
				'screenshot'  => plugins_url( 'assets/images/transfer-addon.png', myCRED_THIS ),
				'requires'    => array()
			);

			$installed = apply_filters( 'mycred_setup_addons', $installed );

			if ( $save === true && $this->core->user_is_point_admin() ) {
				$new_data = array(
					'active'    => $this->active,
					'installed' => $installed
				);
				mycred_update_option( 'mycred_pref_addons', $new_data );
			}

			$this->installed = $installed;
			
			return $installed;

		}

		/**
		 * Admin Page
		 * @since 0.1
		 * @version 1.2.2
		 */
		public function admin_page() {

			// Security
			if ( ! $this->core->user_is_point_admin() ) wp_die( 'Access Denied' );

			$installed = $this->get( true ); 
		?>

			<style type="text/css">
				#myCRED-wrap > h1 { margin-bottom: 15px; }
				.theme-browser .theme:focus, .theme-browser .theme:hover { cursor: default !important; }
				.theme-browser .mycred-addons-element:hover .more-details { opacity: 1; }
				.theme-browser .mycred-addons-element:hover a.more-details, .theme-browser .mycred-addons-element:hover a.more-details:hover { text-decoration: none; }
			</style>

			<script type="text/javascript">
			jQuery(document).ready(function(jQuery){

			   	jQuery("#mycred-addons-checkbox").change(function(){
			
					var check = jQuery("#mycred-addons-checkbox").is(":checked");
			
					if ( check == true ) {

						window.location.href = jQuery('.mycred-addon-switch').attr("data-activation-url");

					}
					else {

						window.location.href = jQuery('.mycred-addon-switch').attr("data-deactivation-url");

					}
			
			   	});
			
			});
			</script>
			
			<?php 
			
			$activate_url = get_mycred_all_addon_activation_url();
			$deactivate_url = get_mycred_all_addon_deactivation_url();
			$free_addons_url = get_mycred_addon_page_url('free_addons');
			$premium_addons_url = get_mycred_addon_page_url('premium_addons');
			
			?>
<div class="wrap" id="myCRED-wrap">
	<div class="mycred-addon-outer">	
		<div class="myCRED-addon-heading">
			<h1><?php esc_html_e( 'Add-ons', 'mycred' ); if ( MYCRED_DEFAULT_LABEL === 'myCRED' ) : ?><a href="http://codex.mycred.me/chapter-iii/" class="mycred-ui-info-btn" target="_blank"><?php esc_html_e( '', 'mycred' ); ?><p>Documentation</p></a><?php endif; ?></h1>
		</div>
		<div class="mycred-addons-main-nav">
			<div class="mycred-addons-nav-tab-wrapper">
				<ul class="subsubsub">
					<li>
						<a href="<?php echo esc_url( admin_url('admin.php?page=mycred-addons') ); ?>" class="mycred-addons-nav-tab <?php echo !isset( $_GET['mycred_addons'] ) ? 'current' : ''; ?>">Built-in Addons</a>|
					</li>
					<li>
						<a href="<?php echo esc_url( $free_addons_url ); ?>" class="mycred-addons-nav-tab <?php echo ( isset( $_GET['mycred_addons'] ) && $_GET['mycred_addons'] == 'free_addons' ) ? 'current' : ''; ?>">Free Addons</a>|
					</li>
					<li>
						<a href="<?php echo esc_url( $premium_addons_url ); ?>" class="<?php echo ( isset( $_GET['mycred_addons'] ) && $_GET['mycred_addons'] == 'premium_addons' ) ? 'current' : ''; ?>">Premium Addons</a>
					</li>
				</ul>
			</div>
			<?php if( !isset( $_GET['mycred_addons'] ) ):?>
			<div class="mycred-addon-switch mycred-toggle-wrapper" data-activation-url="<?php echo esc_url( $activate_url ); ?>" data-deactivation-url="<?php echo esc_attr( $deactivate_url ); ?>">
				<label for="mycred-addons-checkbox"><?php esc_html_e( 'Activate/Deactivate All Add-ons', 'mycred' ); ?></label>
				<label for="mycred-addons-checkbox" class="mycred-toggle mycred-addons-switch">
				  	<input type="checkbox" name="mycred-addons-checkbox" id="mycred-addons-checkbox" <?php echo $this->check_all_addons() ? 'checked' : ''; ?> >
				  	<span class="slider round"></span>
				</label>
			</div>
			<?php endif;?>
		</div>
	</div>
			<?php

			// Messages
			if ( isset( $_GET['activated'] ) ) {

				if ( $_GET['activated'] == 1 )
					echo '<div id="message" class="updated"><p>' . esc_html__( 'Add-on Activated', 'mycred' ) . '</p></div>';

				elseif ( $_GET['activated'] == 0 )
					echo '<div id="message" class="error"><p>' . esc_html__( 'Add-on Deactivated', 'mycred' ) . '</p></div>';

			} ?>

	<div class="theme-browser">
		<div class="mycred-addons-page">
<?php

if ( isset( $_GET['mycred_addons'] ) ) 
{
	if ( $_GET['mycred_addons'] == 'free_addons' ) 
	{

		require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
			/** Prepare our query */
	    $call_api = 
	    	plugins_api( 
	    		'query_plugins', 
	    		array( 
	    			'author' => 'mycred', 
	    			'per_page' => '100'
	    		) 
	    	);
	 
	    /** Check for Errors & Display the results */
	    if ( is_wp_error( $call_api ) ) {
	 
	      echo wp_kses_post( '<pre>' . print_r( $call_api->get_error_message(), true ) . '</pre>' );
	 
	    } 
	    else {

	 		$mycred_plugins = $call_api->plugins;
	 			
	 	}

		foreach ( $mycred_plugins as $key => $data ) {
			
			if ( $data['slug'] == 'mycred' ) continue; 
			if ( $data['slug'] == 'mycred-blocks' ) continue;

			if ( $data['icons'] != '' ) : ?>
			<div class="mycred-addons-element inactive" tabindex="0" aria-describedby="free-action free-name">
				<div class="mycred-free-addons-title">
					<h2 class="mycred-addons-name" ><?php echo esc_html( $data['name'] ); ?></h2>
				</div>
				<div class="mycred-addons-images"> <?php

					if ( ! empty( $data['icons']['2x'] ) ) {
						$img = $data['icons']['2x'];
					}else{
						$img = $data['icons']['1x'];
					} ?>

					<img src="<?php echo esc_url( $img ); ?>" alt="">

				</div>

				<div class="mycred-addons-container">

					<a href="https://wordpress.org/plugins/<?php echo esc_html( $data['slug'] ); ?>" title="View on Wordpress" target="_blank" class="mycred-action">View</a>

				</div>

			</div>
			
			<?php endif; 
		}
	}
	
	if ( $_GET['mycred_addons'] == 'premium_addons' ) 
	{
		$premium_addons = array();

		$request_args = array(
			'body' => array(
				'site'        => get_bloginfo( 'url' ),
				'api-key'     => md5( get_bloginfo( 'url' ) )
			),
			'timeout' => 12
		);

		// Pass license url
		$response = wp_remote_post( 'https://license.mycred.me/wp-json/license/get-premium-addons', $request_args );

		$addons = json_decode( $response['body'] )->data;
							
		foreach ( $addons as $key => $value ) { ?>

			<div class="mycred-addons-element inactive" tabindex="0" aria-describedby="premium-action premium-name">
										
				<div class="mycred-premium-addons-title">
					<h2 class="mycred-addons-name" id="badges-name"><?php echo esc_html( $value->title ); ?></h2>
				</div>
				<div class="mycred-addons-images">
					<img src="<?php echo ! empty( $value->image ) ? esc_url( $value->image ) : '' ; ?>" width="256px" alt="">
				</div>
				<div class="mycred-addons-container">
					<a href="<?php echo esc_url( $value->url ); ?>" title="Install" target="_blank" class="mycred-action">View</a>

				</div>

			</div>

			<?php
			
		}
	}
}
else
{

	// Loop though installed
	if ( ! empty( $installed ) ) {

		foreach ( $installed as $key => $data ) {

			$aria_action = $key . '-action';
			$aria_name   = $key . '-name'; ?>

			<div class="mycred-addons-element<?php if ( $this->is_active( $key ) ) echo ' active'; else echo ' inactive'; ?>" tabindex="0" aria-describedby="<?php echo esc_attr( $aria_action ) . ' ' . esc_attr( $aria_name ); ?>"> <?php 

			if ( $this->is_active( $key ) ) : ?>
				<h2 class="mycred-addons-name" id="<?php echo esc_attr( $aria_name ); ?>"><?php echo esc_html( $this->core->template_tags_general( $data['name'] ) ); ?></h2><?php 
			else : ?>
				<h2 class="mycred-addons-name" id="<?php echo esc_attr( $aria_name ); ?>"><?php echo esc_html( $this->core->template_tags_general( $data['name'] ) ); ?></h2><?php 
			endif;  

			if ( $data['screenshot'] != '' ) : ?>

				<div class="mycred-addons-images">
					<img src="<?php echo esc_url( $data['screenshot'] ); ?>" alt="" />
				</div><?php 
			else : ?>
				<div class="theme-screenshot blank"></div><?php 
			endif; ?>
				
				<a class="more-details" id="<?php echo esc_attr( $aria_action ); ?>" href="<?php echo esc_url( $data['addon_url'] ); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'mycred' ); ?></a>
				<div class="mycred-addons-container">

						<?php echo wp_kses_post( $this->activate_deactivate( $key ) ); ?>
				</div>
			</div><?php
		}
	}	

}?>
		</div>
	</div>
</div>
<?php

		}

		/**
		 * Activate / Deactivate Button
		 * @since 0.1
		 * @version 1.2
		 */
		public function activate_deactivate( $addon_id = NULL ) {

			$link_url  = get_mycred_addon_activation_url( $addon_id );
			$link_text = __( 'Activate', 'mycred' );

			// Deactivate
			if ( $this->is_active( $addon_id ) ) {

				$link_url  = get_mycred_addon_deactivation_url( $addon_id );
				$link_text = __( 'Deactivate', 'mycred' );

			}

			return '<a href="' . esc_url_raw( $link_url ) . '" title="' . esc_attr( $link_text ) . '" class="mycred-action ' . esc_attr( $addon_id ) . '">' . esc_html( $link_text ) . '</a>';

		}

		public function check_all_addons( ) {
		
			$all_addons = count($this->installed);
			$active_addons = count($this->active);
			
			if($all_addons == $active_addons){
				
				return true;

			}else{

				return false;
			}
		}
	}
endif;

/**
 * Get Activate Add-on Link
 * @since 1.7
 * @version 1.0
 */
if ( ! function_exists( 'get_mycred_addon_activation_url' ) ) :
	function get_mycred_addon_activation_url( $addon_id = NULL, $deactivate = false ) {

		if ( $addon_id === NULL ) return '#';

		$args = array(
			'page'         => MYCRED_SLUG . '-addons',
			'addon_id'     => $addon_id,
			'addon_action' => ( ( $deactivate === false ) ? 'activate' : 'deactivate' ),
			'_token'       => wp_create_nonce( 'mycred-activate-deactivate-addon' )
		);

		return esc_url( add_query_arg( $args, admin_url( 'admin.php' ) ) );

	}
endif;

/**
 * Get Deactivate Add-on Link
 * @since 1.7
 * @version 1.0
 */
if ( ! function_exists( 'get_mycred_addon_deactivation_url' ) ) :
	function get_mycred_addon_deactivation_url( $addon_id = NULL ) {

		if ( $addon_id === NULL ) return '#';

		return get_mycred_addon_activation_url( $addon_id, true );

	}
endif;




if ( ! function_exists( 'get_mycred_all_addon_activation_url' ) ) :
	function get_mycred_all_addon_activation_url() 
  {

		$args = array(
			'page'         => MYCRED_SLUG . '-addons',
			'addon_all_action' =>  'activate',
			'_token'       => wp_create_nonce( 'mycred-activate-deactivate-addon' )
		);

		return esc_url( add_query_arg( $args, admin_url( 'admin.php' ) ) );

	}
endif;


if ( ! function_exists( 'get_mycred_all_addon_deactivation_url' ) ) :
	function get_mycred_all_addon_deactivation_url( ) {
		
		$args = array(
			'page'         => MYCRED_SLUG . '-addons',
			'addon_all_action' =>  'deactivate',
			'_token'       => wp_create_nonce( 'mycred-activate-deactivate-addon' )
		);

		return esc_url( add_query_arg( $args, admin_url( 'admin.php' ) ) );

	}
endif;

if ( ! function_exists( 'get_mycred_addon_page_url' ) ) :
	function get_mycred_addon_page_url( $addon_type ) {
		
		$args = array(
			'page'         => MYCRED_SLUG . '-addons',
			'mycred_addons' =>  $addon_type,
		);

		return esc_url( add_query_arg( $args, admin_url( 'admin.php' ) ) );

	}
endif;
