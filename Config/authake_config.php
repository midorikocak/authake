<?php
$config = array (
  'Authake' => 
  array (
    'useDefaultLayout' => '1',
    'baseUrl' => 'http://showcase.dev/aktifshemale/',
    'service' => 'Authake',
    'loginAction' => 
    array (
      'plugin' => 'authake',
      'controller' => 'user',
      'action' => 'login',
      'named' => 
      array (
      ),
      'pass' => 
      array (
      ),
    ),
    'loggedAction' => 'http://showcase.dev/aktifshemale/',
    'sessionTimeout' => '604800',
    'defaultDeniedAction' => 
    array (
      'plugin' => 'authake',
      'controller' => 'user',
      'action' => 'denied',
      'named' => 
      array (
      ),
      'pass' => 
      array (
      ),
    ),
    'rulesCacheTimeout' => '300',
    'systemEmail' => 'noreply@example.com',
    'systemReplyTo' => 'noreply@example.com',
    'passwordVerify' => '1',
    'registration' => '1',
    'defaultGroup' => '2',
    'useEmailAsUsername' => '0',
  ),
);