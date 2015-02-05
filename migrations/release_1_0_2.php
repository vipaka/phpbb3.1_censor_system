<?php
/**
*
* @package phpBB Extension - Vipaka Censors* @copyright (c) 2014 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace vipaka\censors\migrations;

class release_1_0_2 extends \phpbb\db\migration\migration
{
	public function update_schema()
	{
		return array(
			'add_tables'		=> array(
				$this->table_prefix . 'user_censors'	=> array(
					'COLUMNS'		=> array(
						'id'			=> array('UINT', null, 'auto_increment'),
						'word'			=> array('VCHAR:255', ''),
						'replacement'			=> array('VCHAR:255', ''),	
						'user_id'		=> array('UINT', 0),			
					),
					'PRIMARY_KEY'	=> 'id',
				),
			),
		);
	}
	public function update_data()
	{
		return array(
			

			array('module.add', array(
				'ucp',
				'UCP_PREFS',
				'UCP_CENSORS_TITLE'
			)),
			array('module.add', array(
				'ucp',
				'UCP_CENSORS_TITLE',
				array(
					'module_basename'	=> '\vipaka\censors\ucp\main_module',
					'modes'				=> array('censors'),
				),
			)),
		);
	}
	

	public function revert_schema()
	{
		
		return array(
			
			'drop_tables'		=> array(
				$this->table_prefix . 'user_censors',
			),
		);
	}
}
