<?php

class changepasswd_AD extends rcube_plugin
{
	public $task = 'settings';
	private $config;
	private $db;

	function init()
	{
		rcmail::get_instance()->output->add_label('password');
		$this->add_texts('localization/', array('nocurpassword', 'nopassword', 'passwordinconsistency'));
		$this->register_action('plugin.changepasswd_AD', array($this, 'init_html'));
		$this->register_action('plugin.changepasswd_AD.save', array($this, 'save'));
		$this->include_script('changepasswd_AD.js');
	}

	function init_html()
	{
		$this->api->output->add_handler('changepasswd', array($this, 'gen_form'));
		$this->api->output->set_pagetitle($this->gettext('changepasswd'));
		$this->api->output->send('changepasswd_AD.changepasswd');
	}

	function gen_form()
	{
		list($form_start, $form_end) = get_form_tags(null, 'plugin.changepasswd_AD.save');

		// return the complete form as table
		$out = $form_start;
		$table = new html_table(array('cols' => 2));

		// show old password field
		$field_id = 'rcmfd_curpwd';
		$input_curpasswd = new html_passwordfield(array('name' => '_curpasswd', 'id' => $field_id));

		$table->add('title', html::label($field_id, Q($this->gettext('curpasswd'))));
		$table->add(null, $input_curpasswd->show());

		// show new password field
		$field_id = 'rcmfd_newpwd';
		$input_newpasswd = new html_passwordfield(array('name' => '_newpasswd', 'id' => $field_id,));

		$table->add('title', html::label($field_id, Q($this->gettext('newpasswd'))));
		$table->add(null, $input_newpasswd->show());

		// show new password confirm field
		$field_id = 'rcmfd_cnfpwd';
		$input_confpasswd = new html_passwordfield(array('name' => '_confpasswd', 'id' => $field_id));

		$table->add('title', html::label($field_id, Q($this->gettext('confpasswd'))));
		$table->add(null, $input_confpasswd->show());

		$out .= $table->show();
		$out .= $form_end;

		return $out;
	}

	function save()
	{
		
		$old_pw = $_POST['_curpasswd'];
		$new_pw = $_POST['_newpasswd'];
    
    $uid = $_SESSION['username'];
   
    $ret = $this->changePassword($uid, $old_pw, $new_pw);
    switch ($ret) {
      case 9: 
        $_SESSION['password'] = rcmail::get_instance()->encrypt($new_pw);
				$this->api->output->command('display_message', $this->gettext('passwordchanged'), 'confirmation');
        break;
      case 1: 
        $this->api->output->command('display_message', $this->gettext('passwordfailed1'), 'error');
        break;
      case 2: 
        $this->api->output->command('display_message', $this->gettext('passwordfailed2'), 'error');
        break;
      case 3: 
        $this->api->output->command('display_message', $this->gettext('passwordfailed3'), 'error');
        break;
      case 4: 
        $this->api->output->command('display_message', $this->gettext('passwordfailed4'), 'error');
        break;
      case 5: 
        $this->api->output->command('display_message', $this->gettext('passwordfailed5'), 'error');
        break;
      case 6: 
        $this->api->output->command('display_message', $this->gettext('passwordfailed6'), 'error');
        break;
      case 7: 
        $this->api->output->command('display_message', $this->gettext('passwordfailed7'), 'error'); 
        break;
      case 8: 
        $this->api->output->command('display_message', $this->gettext('passwordfailed8'), 'error');
        break;
      case 0: 
        $this->api->output->command('display_message', $this->gettext('passwordfailed0'), 'error');
        break;
    }

		// go to next step
		rcmail_overwrite_action('plugin.changepasswd_AD');
		$this->action = 'plugin.changepasswd_AD';
		$this->init_html();
	}
  function changePassword($uid, $old_pw, $new_pw) {

      include ("changepasswd_AD_config.php"); 
      if (!$debug) {
        error_reporting(1);
      }
      else {
        error_reporting(0);
      } 
      include ("/phpActiveDirectoryPasswdChange/csLogging.class.php");

      $logwriter = new csLogging($errorlogfile,$debuglogfile,$debug);

      $postData = array
      (
        'uid' => $uid,
        'curpwd' => $old_pw,
        'newpwdone' => $new_pw,
        'newpwdtwo' => $new_pw,
        'successurl' => $successurl,
        'failurl' => $failurl,
      );
      $post['http'] = array
      (
        'method' => 'GET',
        'content' => http_build_query($postData, '', '&'),
      );
      $logwriter->debugwrite("POST DATA: " . http_build_query($postData, '', '&'));
      $logwriter->debugwrite("POST: $post");
      $stream = stream_context_create($post);
      $streamPost = @fopen($posturl,'rb',false,$stream);
      if (!$streampost) {
        $logwriter->writelog("Error in post: $php_errormsg");
      }
      $ret = @stream_get_contents($streamPost);
      $logwriter->debugwrite("RET: $ret");
      return $ret;
  }
}

?>
