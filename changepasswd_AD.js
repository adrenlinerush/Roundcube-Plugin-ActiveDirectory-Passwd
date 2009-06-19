
if (window.rcmail) {
	rcmail.addEventListener('init', function(evt) {
		var tab = $('<span>').attr('id', 'settingstabpluginchangepasswd_AD').addClass('tablink');

		var button = $('<a>').attr('href', rcmail.env.comm_path+'&_action=plugin.changepasswd_AD').html(rcmail.gettext('password')).appendTo(tab);
		button.bind('click', function(e){ return rcmail.command('plugin.changepasswd_AD', this) });

		// add button and register command
		rcmail.add_element(tab, 'tabs');
		rcmail.register_command('plugin.changepasswd_AD', function(){ rcmail.goto_url('plugin.changepasswd_AD') }, true);

		if (rcmail.env.action == 'plugin.changepasswd_AD') {
			rcmail.register_command('plugin.changepasswd_AD.save', function(){
					var input_curpasswd = rcube_find_object('_curpasswd');
					var input_newpasswd = rcube_find_object('_newpasswd');
					var input_confpasswd = rcube_find_object('_confpasswd');

					if (input_curpasswd && input_curpasswd.value == '') {
						alert(rcmail.gettext('nocurpassword','changepasswd_AD'));
						input_curpasswd.focus();
					}
					else if (input_newpasswd && input_newpasswd.value == '' && input_confpasswd && input_confpasswd.value == '') {
						alert(rcmail.gettext('nopassword','changepasswd_AD'));
						input_newpasswd.value = '';
						input_confpasswd.value = '';
						input_newpasswd.focus();
					}
					else if (input_newpasswd && input_confpasswd && input_newpasswd.value != input_confpasswd.value) {
						alert(rcmail.gettext('passwordinconsistency','changepasswd_AD'));
						input_newpasswd.value = '';
						input_confpasswd.value = '';
						input_newpasswd.focus();
					}
					else {
						rcmail.gui_objects.editform.submit();
					}

					return false;
				}, true);
			rcmail.enable_command('plugin.changepasswd_AD.save', true);
		}
	})
}
