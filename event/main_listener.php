<?php
/**
*
* @package phpBB Extension - Vipaka Censors* @copyright (c) 2014 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace vipaka\censors\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'load_language_on_setup',
			'core.page_header'						=> 'add_page_header_links',
		);
	}


 /* @var \phpbb\controller\helper */
  protected $helper;

  /* @var \phpbb\template\template */
  protected $template;
  protected $db;
  protected $config;
  protected $config_text;
  /**
  * Constructor
  *
  * @param \phpbb\controller\helper $helper   Controller helper object
  * @param \phpbb\template      $template Template object
  */
  public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, \phpbb\config\db_text $config_text)
  {
    $this->config = $config;
    $this->config_text = $config_text;
    $this->helper = $helper;
    $this->template = $template;
    $this->db = $db;
  }

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'vipaka/censors',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_page_header_links($event)
	{
		global $db, $config, $user, $table_prefix;

    
		 $sql = 'SELECT * FROM light_user_censors
            WHERE user_id = ' . (int) $user->data['user_id'];
            $result = $this->db->sql_query($sql);
            while ($row = $this->db->sql_fetchrow($result)){

                $this->template->assign_block_vars('censored_words', array(
                        'WORD'    => $row['word'],
                        'REPLACER'  => $row['replacement'],
                  ));
            }
       
	}
}
