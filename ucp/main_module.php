<?php
/**
*
* @package phpBB Extension - Vipaka Censors
* @copyright (c) 2014 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace vipaka\censors\ucp;

class main_module
{
  protected $config_text;
  protected $request;

	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache, $request, $table_prefix, $config, $phpbb_root_path, $phpbb_admin_path, $phpEx, $phpbb_container;

    $this->config_text = $phpbb_container->get('config_text');
    $this->request = $request;
		$user->add_lang('common');
		$this->tpl_name = 'censors_body';
		$this->page_title = $user->lang('UCP_CENSORS_SETTINGS');
    define('CENSORS_TABLE', $table_prefix . 'user_censors');

		if ($request->is_set_post('submit'))
			{

        $word = utf8_clean_string($request->variable('wordage', '', true));
        $replacement = utf8_clean_string($request->variable('replacer', '', true));

         $insert_array = array(
                'word' => $word,
                  'replacement' => $replacement,
                  'user_id'  => (int) $user->data['user_id'],
              );
          $sql = "INSERT INTO " . CENSORS_TABLE . " " . $db->sql_build_array('INSERT', $insert_array);
          $db->sql_query($sql);

				trigger_error($user->lang('UCP_CENSORS_SETTING_SAVED'));
			}
     if ($request->is_set_post('del'))
      {

        $censorid = $request->variable('delete', 0);
       
        $sql = 'DELETE FROM ' . CENSORS_TABLE . ' 
            WHERE id = ' . (int) $censorid . ' 
            AND user_id = ' . (int) $user->data['user_id'];
        $db->sql_query($sql);

        trigger_error($user->lang('UCP_CENSORS_SETTING_DELETED'));
      }
		 $sql = 'SELECT * FROM ' . CENSORS_TABLE . '
            WHERE user_id = ' . (int) $user->data['user_id'];
            $result = $db->sql_query($sql);
            if ($db->sql_affectedrows() > 0){
                $has_censors = 1;
            }
            else{
                $has_censors = 0;
            }
            while ($row = $db->sql_fetchrow($result)){
                $template->assign_block_vars('censor_words', array(
                        'WORD'    => $row['word'],
                        'REPLACER'  => $row['replacement'],
                        'ID'      => $row['id'],
                  ));
            }

		$template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
      'HAS_CENSORS'   => ($has_censors > 0) ? 1: 0,
      'S_NAVBAR_PARENT'   => $parent,
      'S_NAVBAR_SUB_PARENT'   => $sub_parent,
		));
	}
}
