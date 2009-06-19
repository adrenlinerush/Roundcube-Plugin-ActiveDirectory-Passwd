<?php

$labels = array();
$labels['changepasswd']  = 'Change password';
$labels['curpasswd']  = 'Current password';
$labels['newpasswd']  = 'New password';
$labels['confpasswd']  = 'Confirm new password';

$messages = array();
$messages['nocurpassword'] = 'Please enter your current password';
$messages['nopassword'] = 'Please enter your new password';
$messages['passwordinconsistency'] = 'Inconsistency in new password, please try again';
$messages['passwordfailed1'] = 'Error: failed password validation';
$messages['passwordfailed2'] = 'Error: failed initial connect to ldap server';
$messages['passwordfailed3'] = 'Error: failed to bind with search dn';
$messages['passwordfailed4'] = 'Error: failed to find user';
$messages['passwordfailed5'] = 'Error: failed to get user cn';
$messages['passwordfailed6'] = 'Error: failed to connect to ldap server second time';
$messages['passwordfailed7'] = 'Error: failed to bind with user dn';
$messages['passwordfailed8'] = 'Error: failed to change password';
$messages['passwordchanged'] = 'Successfully changed password';

?>
