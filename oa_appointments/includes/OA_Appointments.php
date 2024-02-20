<?php
/*
  @author: Oscar Alderete
  @website: https://oscaralderete.com
  @email: oscaralderete@gmail.com
 */

namespace OscarAlderete;


class OA_Appointments
{
	const CODE = 'OA_Appointments';
	const SLUG = 'oa_appointments';
	const TITLE = 'OA Appointments';
	const PERMISSION = 'administrator';
	const ADMIN_PAGE = '/admin-page';
	const ICON = 'dashicons-id';
	const VERSION = '1.0.0';
	const AJAX_LISTENER = '_front_ajax_request';

	private $uri;
	private $path;
	private $file;
	private $ajaxAction;
	private $s = ['result' => 'ERROR', 'msg' => 'Error code 3001'];

	function __construct(string $path)
	{
		$this->uri = plugin_dir_url($path);
		$this->path = plugin_dir_path($path);
		$this->file = $path;
		$this->ajaxAction = self::SLUG . self::AJAX_LISTENER;

		// shortcode
		add_shortcode(self::CODE, [$this, 'get_shortcode']);

		// register admin scripts + styles
		//add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts'], 4);

		// admin page
		//add_action('admin_menu', [$this, 'admin_menu'], 2);

		// register scripts to use 
		add_action('wp_ajax_' . $this->ajaxAction, [$this, 'process_ajax_request'], 4);
		add_action('wp_ajax_nopriv_' . $this->ajaxAction, [$this, 'process_ajax_request'], 5);
	}

	// publics
	public function get_shortcode($atts)
	{
		global $wpdb, $wp;

		// get attributes/defaults
		$atts = shortcode_atts(['somekey' => 'some value'], $atts);

		// data
		$records = $wpdb->get_results("SELECT post_id FROM {$wpdb->prefix}appointments WHERE meta_key = 'user_email'");
		$records = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_status = 'publish'");

		$types = [
			['value' => 'draft', 'label' => 'Draft'],
			['value' => 'inherit', 'label' => 'Inherit'],
			['value' => 'publish', 'label' => 'Publish'],
		];

		ob_start();

		include $this->path . 'public/template/shortcode_css.php';
		include $this->path . 'public/template/shortcode_html.php';
		include $this->path . 'public/template/shortcode_scripts.php';

		$html = ob_get_contents();

		ob_end_clean();

		return $html;
	}

	public function process_ajax_request()
	{
		$s = $this->s;

		switch ($_POST['type']) {
			case 'wpe_manually_populate_data':
				$s = $this->manualllyPopulateData();
				break;
			case 'wpe_filter_properties':
				$s = $this->filterProperties($_POST['data']);
				break;
				// pending
			case 'wpe_inmogestion_settings':
				$s = $this->update_settings($_POST['data']);
				break;
			default:
				$s['msg'] = 'Error code 2001';
		}

		echo json_encode($s);
		wp_die();
	}
}
