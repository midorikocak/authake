UPDATE: 31 Jan 2012 

Chages added made by Lonardo Pedretti
fixed: this->rquest->data issues
login using email
views

UPDATE: 22 jan 2012 

Upgrading to Cakephp 2.1
fixed: getcontrollers
views


UPDATE: Best run with after CakePHP 2.0.3.

Authake is finally arrived to CakePHP 2.0 and is (another) solution to manage users and groups and their rights in a CakePHP platform, as well as their registration, email confirmation and password changing requests. It’s composed by a component, a plugin, and a helper.

For download:

https://github.com/mtkocak/authake

For install instructions and feedback, please go to Authake home page: http://www.mtkocak.net/?p=333

For install:

1. Unzip the plugin to your app/Plugin folder with the name Authake. Case is important, lowercase folder name does not work.

2. You have to have in your bootstrap.php

CakePlugin::loadAll();
or

CakePlugin::load('Authake');
3. Add the Authake/db/authake_clean.sql to your database.

4. Add this to your config/database.php to make authake work.
The idea behind this is that it would be possible to have 1 Authake instalation which handle multiple apps.

var $authake = array(
'datasource' => 'Database/Mysql',
'persistent' => false,
'host' => 'localhost',
'login' => ", //username for the db
'password' => ", //password for the db
'database' => 'authake', //or any other where you have imported the authake.sql file
'prefix' => ",
);

5. Create AppController.php in you'r app's Controller folder first.

Change it's contents like this: UPDATED: No need debug_kit anymore

<?php

class AppController extends Controller {
	var $helpers = array('Form', 'Time', 'Html', 'Session', 'Js', 'Authake.Authake');
	var $components = array('Session','RequestHandler', 'Authake.Authake');
	var $counter = 0;
	function beforeFilter(){
		$this->auth();
	}
	private function auth(){
		Configure::write('Authake.useDefaultLayout', true);
		$this->Authake->beforeFilter($this);
	}

}
?>

6. Use username: admin password: admin to login

- For any question mtkocak@gmail.com
