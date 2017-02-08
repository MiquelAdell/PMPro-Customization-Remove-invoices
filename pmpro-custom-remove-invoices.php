<?php
/*
Plugin Name: PMPro Customization: Remove invoices
Plugin URI: https://github.com/MiquelAdell/PMPro-Customization-Remove-invoices
Description: Remove invoices from PMPro
Version: .1
Author: Miquel Adell
Author URI: http://www.miqueladell.com
*/

/*
 * the confirmation tempalte has extensive invoice references so we are
 * replacing it whole
 */
function my_pmpro_pages_shortcode_confirmation($content) {
	ob_start();
	include(plugin_dir_path(__FILE__) . "templates/confirmation.php");
	$temp_content = ob_get_contents();
	ob_end_clean();
	return $temp_content;
}
add_filter("pmpro_pages_shortcode_confirmation", "my_pmpro_pages_shortcode_confirmation");


function my_pmpro_pages_shortcode_account($content) {
	ob_start();
	include(plugin_dir_path(__FILE__) . "templates/account.php");
	$temp_content = ob_get_contents();
	ob_end_clean();
	return $temp_content;
}
add_filter("pmpro_pages_shortcode_account", "my_pmpro_pages_shortcode_account");


/*
 * the pmpro_account shortcode is quite complex so we are using the full HTML
 * and just hiding relevant invoicing sections with inline CSS
 */
function overwrite_pmpro_account_shortcode() {
	function custom_pmpro_shortcode_account($atts, $content=null, $code="") {
		ob_start()
		?>
		<style>
			#pmpro_account-invoices {
				display: none;
			}
		</style>
		<?php
		pmpro_shortcode_account($atts, $content, $code);
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	remove_shortcode('pmpro_account');
	add_shortcode('pmpro_account', 'custom_pmpro_shortcode_account');
}
add_action( 'init', 'overwrite_pmpro_account_shortcode' );
