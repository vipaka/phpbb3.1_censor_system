<?php
/**
*
* @package phpBB Extension - Censors
* @copyright (c) 2014 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace vipaka\censors\ucp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\vipaka\censors\ucp\main_module',
			'title'		=> 'UCP_CENSORS_TITLE',
			'version'	=> '1.0.2',
			'modes'		=> array(
				'censors'	=> array('title' => 'UCP_CENSORS_WORDS', 'auth' => 'ext_vipaka/censors', 'cat' => array('UCP_CENSORS_TITLE')),
			),
		);
	}
}
