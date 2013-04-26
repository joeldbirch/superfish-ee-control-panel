<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Superfish Admin Extension
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Extension
 * @author		Joel Birch
 * @link		http://github.com/joeldbirch
 */

class Superfish_admin_ext {
	
	public $settings 		= array();
	public $description		= 'Superfish helps with EE navigation.';
	public $docs_url		= 'http://github.com/joeldbirch/superfish';
	public $name			= 'Superfish Control Panel Menu';
	public $settings_exist	= 'n';
	public $version			= '0.1';
	
	private $EE;
	
	/**
	 * Constructor
	 *
	 * @param 	mixed	Settings array or empty string if none exist.
	 */
	public function __construct($settings = '')
	{
		$this->EE =& get_instance();
		$this->settings = $settings;
	}

	// ----------------------------------------------------------------------
	
	/**
	 * Activate Extension
	 *
	 * This function enters the extension into the exp_extensions table
	 *
	 * @see http://codeigniter.com/user_guide/database/index.html for
	 * more information on the db class.
	 *
	 * @return void
	 */
	public function activate_extension()
	{
		// Setup custom settings in this array.
		$this->settings = array();
		
		$hooks = array(
			'cp_menu_array' => 'cp_menu_array'
		);

		foreach ($hooks as $hook => $method)
		{
			$data = array(
				'class'		=> __CLASS__,
				'method'	=> $method,
				'hook'		=> $hook,
				'settings'	=> serialize($this->settings),
				'version'	=> $this->version,
				'enabled'	=> 'y'
			);

			$this->EE->db->insert('extensions', $data);			
		}
	}	


	// ----------------------------------------------------------------------


	public function cp_menu_array($menu)
	{
		$this->EE->cp->add_to_foot('<script src="'.URL_THIRD_THEMES.'superfish_admin/js/superfish-combined-ck.js"></script>');

		$css = '
			#navigationTabs li.parent > ul {
				display: none;
			}
			#navigationTabs li.parent:hover > ul,
			#navigationTabs li.parent.active > ul {
				display: block;
			}
			#navigationTabs a:focus,
			#navigationTabs a:hover,
			#navigationTabs a:active {
				color: black;
				background-color: rgba(255,255,255,.5);
			}
		';

		if ( ! empty($css))
		{
			$this->EE->cp->add_to_head('<style>'.$css.'</style>');
		}

		return $menu;
	}


	/**
	 * Disable Extension
	 *
	 * This method removes information from the exp_extensions table
	 *
	 * @return void
	 */
	function disable_extension()
	{
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->delete('extensions');
	}

	// ----------------------------------------------------------------------

	/**
	 * Update Extension
	 *
	 * This function performs any necessary db updates when the extension
	 * page is visited
	 *
	 * @return 	mixed	void on update / false if none
	 */
	function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
	}	
	
	// ----------------------------------------------------------------------
}

/* End of file ext.superfish_admin.php */
/* Location: /system/expressionengine/third_party/superfish_admin/ext.superfish_admin.php */