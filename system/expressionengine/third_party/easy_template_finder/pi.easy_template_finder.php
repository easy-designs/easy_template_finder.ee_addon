<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Easy_template_finder Class
 *
 * @package			ExpressionEngine
 * @category		Plugin
 * @author			Aaron Gustafson
 * @copyright		Copyright (c) Easy! Designs, LLC
 * @link			http://www.easy-designs.net/
 */

$plugin_info = array(
  'pi_name'			=> 'Easy Template Finder',
  'pi_version'		=> '1.0',
  'pi_author'		=> 'Aaron Gustafson',
  'pi_author_url'	=> 'http://easy-designs.net/',
  'pi_description'	=> 'Finds the template used by a given entry',
  'pi_usage'		=> Easy_template_finder::usage()
);

class Easy_template_finder {

	var $return_data;
  
  	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
	function Easy_template_finder ( $entry_id=FALSE )
	{
		$this->EE =& get_instance();
		
		$path = FALSE;

		# get the entry
		if ( ! $entry_id &&
			 $temp = $this->EE->TMPL->fetch_param('entry_id') ) $entry_id = $temp;

		if ( $entry_id !== FALSE )
		{
			# site?
			$site_id	= $this->EE->config->item('site_id');
			
			# find the template
			$pages		= $this->EE->config->item('site_pages');
			$template	= $pages[$site_id]['templates'][$entry_id];
	
			# look up the template path
			$path = $this->EE->db->query(
				"SELECT		CONCAT(`tg`.`group_name`, '/', `t`.`template_name` ) AS `template`
				 FROM		`exp_templates` AS `t`
				 	INNER JOIN `exp_template_groups` AS `tg` ON `t`.`group_id` = `tg`.`group_id`
				 WHERE		`t`.`template_id` = '{$template}'"
			)->row('template');
			
		}

		# return the processed string
		$this->return_data = ( ! empty( $path ) ? $path : '' );

	} # end Easy_template_finder constructor
  
	/**
   * Easy_template_finder::usage()
   * Describes how the plugin is used
   */
  function usage()
  {
	ob_start(); ?>

This plugin is useful for dynamically embedding entries. Here’s an example using a Playa field to control sidebars:

{exp:channel:entries
	disable="categories|category_fields|member_data|pagination|trackbacks"
	}
	{sidebars}
		{embed="{exp:easy_template_finder entry_id='{entry_id}'}"
			entry_id="{entry_id}"
			}
	{/sidebars}
{/exp:channel:entries}

The plugin only takes a single argument, the `entry_id`, and it returns the template path for embedding.

<?php
	$buffer = ob_get_contents();
	ob_end_clean();
	return $buffer;
  } # end Easy_template_finder::usage()

} # end Easy_template_finder

/* End of file pi.easy_template_finder.php */ 
/* Location: ./system/expressionengine/third_party/easy_template_finder/pi.easy_template_finder.php */