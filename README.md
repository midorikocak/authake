Authake
============

Authake is finally arrived to CakePHP 2.2.3 and is (another) solution to manage users and groups and their rights in a CakePHP platform, as well as their registration, email confirmation and password changing requests. It’s composed by a component, a plugin, and a helper.

Newest features are:

1. Totally new look & feel. New interface using twitter bootstrap library
2. Generated schema file to use cache schema create
3. Total adaptation to CakePHP 2.2.3
4. Totally new Dashboard
5. Gravatar Support
6. Better alerts
7. Beautiful navigation and breadcrumbs
8. html5shiv support for older browsers
9. Dropdown lists for commands
10. Help file with regex information
11. Settings page (needs some effort)
12. Better readme files with markdowns

Further changes are here for your contribution:

- sha1 security
- long id's
- For questions and issues: Mutlu Tevfik Kocak mtkocak(at) gmail.com

Downlad
--------------

https://github.com/mtkocak/authake

For install instructions and feedback, please go to Authake home page: http://www.mtkocak.net/?p=333

Install
----------

1. Unzip the plugin to your app/Plugin folder with the name Authake. Case is important, lowercase folder name does not work.

2. You have to have in your bootstrap.php

        CakePlugin::loadAll();
        //or
        CakePlugin::load('Authake');

3. You can create schema from plugin using command to console terminal when you are in your app folder: 

    Do not use any schema to generate SQL. Causes redirection loop instead of it add the Authake/db/authake_clean.sql to your database.

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

6. Use username: **admin** password: **admin** to login

    For any question mtkocak@gmail.com
    
7. Change the permissions of Config folder to 777 and recurse into enclosed items
    Chmod 777

8. Your login page is located at http://localhost/auth/authake/user/login if you want to login from http://localhost/auth/login you have to create a route at app/config/routes.php like this:

        Router::connect('/login', array('plugin'=>'authake','controller' => 'user', 'action' => 'login'));

    Before the line that contains:

        require CAKE . 'Config' . DS . 'routes.php';
