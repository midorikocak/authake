<?php

/*
  This file is part of Authake.

  Author: Jérôme Combaz (jakecake/velay.greta.fr)
  Contributors:

  Authake is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  Authake is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 */

class AuthakeComponent extends Component {

    var $components = array('Session');
    var $_forward = null;
    var $_flashmessage = '';

    function initialize(Controller $controller) {
        
    }

    function __construct(ComponentCollection $collection, $settings = array()) {
        parent::__construct($collection, $settings);
    }

    function startup(Controller $controller = null) {
        App::uses('PhpReader', 'Configure');
        //Configure::config('Authake', new PhpReader(APP.'/Plugin/Authake/Config/'));
	Configure::config('Authake', new PhpReader(App::pluginPath('Authake').'Config/'));
        
        Configure::load('authake_config.php', 'Authake');
        /**
         * AUTHAKE CONFIGURATION
         * All these changes can be overrided in AppController->beforeFilter action
         */
        /**
         * Base URL, used to insert the application URL in mails.
         */
        if (Configure::read('Authake.baseUrl') == null) {
            Configure::write('Authake.baseUrl', Router::url('/', true));   // set the full application url
        }
        if (Configure::read('Authake.service') == null) {
            Configure::write('Authake.service', 'Authake'); //Name of the service i.e. "Super Authake"
        }
        /**
         * Default login action
         */
        if (Configure::read('Authake.loginAction') == null) {
            Configure::write('Authake.loginAction', array('plugin' => 'authake', 'controller' => 'user', 'action' => 'login', 'admin' => 0));
        }
        /**
         * Used to redirect the users if the current user is logged out. Basically, this
         * is used in case when The login page is the home page. If this is not set to different location, then it's going into recursion.
         */
        if (Configure::read('Authake.loggedAction') == null) {
            Configure::write('Authake.loggedAction', Configure::read('Authake.baseUrl'));
        }
        /**
         * Session timeout in seconds, if managed by Authake (or null to disable)
         */
        if (Configure::read('Authake.sessionTimeout') == null) {
            Configure::write('Authake.sessionTimeout', 3600 * 24 * 7);
        }
        /**
         * Default page when access is denied (should be allowed by ACLs...)
         */
        if (Configure::read('Authake.defaultDeniedAction') == null) {
            Configure::write('Authake.defaultDeniedAction', array('plugin' => 'authake', 'controller' => 'user', 'action' => 'denied', 'admin' => 0));
        }
        /**
         * Reload all rules every x seconds
         */
        if (Configure::read('Authake.rulesCacheTimeout') == null) {
            Configure::write('Authake.rulesCacheTimeout', 300);
        }
        /**
         * Email which sends the system mails
         */
        if (Configure::read('Authake.systemEmail') == null) {
            Configure::write('Authake.systemEmail', 'noreply@example.com');
        }
        if (Configure::read('Authake.systemReplyTo') == null) {
            Configure::write('Authake.systemReplyTo', 'noreply@example.com');
        }
        /**
         * User need to authenticate that he requested the password change
         * (by receiving the confirmation link at his e-mail)
         */
        if (Configure::read('Authake.passwordVerify') == null) {
            Configure::write('Authake.passwordVerify', true);
        }
        /**
         * Users can register
         */
        if (Configure::read('Authake.registration') == null) {
            Configure::write('Authake.registration', true); //or false
        }
        /**
         * Default group for registered users
         * If set registered user will be inserted into specified group
         */
        if (Configure::read('Authake.defaultGroup') == null) {
            Configure::write('Authake.defaultGroup', 2); //could be array or single number
        }
        /**
         * Skip using authake layout for User controller.
         * This is used to display default layout of the application to actions
         * like login, register, change password etc.
         */
        if (Configure::read('Authake.useDefaultLayout') == null) {
            Configure::write('Authake.useDefaultLayout', false); //could be true or false
        }
        /**
         * Use only email instead of user/email (a lot of sites are using this behavior, i.e.: Google,
         * so people is already used to it)
         * Defaults to false so it keeps on the old behavior
         */
         
        if (Configure::read('Authake.useEmailAsUsername') == null) {
            Configure::write('Authake.useEmailAsUsername', false); //could be true or false
        }
        //Configure::dump('authake_config.php', 'Authake', array('Authake'));
    }

    function beforeFilter(&$controller) { //pr($this);
        //Getting vars
        $this->startup();

        // get action path

        $path = $controller->request->params;
        
        $loginAction = Configure::read('Authake.loginAction');
        
        if(!is_array($loginAction))
        {
            $loginAction = Router::parse($loginAction); 
        }
        if (Router::url($controller->request->params + array("base" => false)) != Router::url($loginAction + array("base" => false)) ) {
        
            $this->setPreviousUrl(null);
        }

        // check session timeout
        $tm = Configure::read('Authake.sessionTimeout');
        if ($tm && $this->isLogged()) {
            $ts = $this->Session->read('Authake.timestamp');
            if ((time() - $ts) > $tm) {
                $this->setPreviousUrl($path);
                $this->logout();
                $this->Session->setFlash(__('Your session expired'), 'warning');
                $controller->redirect($loginAction);
            }
            $this->setTimestamp();
        }

        if (!$this->isAllowed($path)) { // check for permissions
            if ($this->isLogged()) { // if denied & logged, write a message
                if ($this->_flashmessage) { // message from the rule (accept path in %s)
                    $this->Session->setFlash(sprintf(__($this->_flashmessage), $path), 'error');    // Set Flash message
                }

                $fw = $this->_forward ? $this->_forward : Configure::read('Authake.defaultDeniedAction');
                $controller->redirect($fw);
            } else { // if denied & not loggued, propose to log in
                $this->setPreviousUrl($path);
             $strpath = Router::url($path + array("base" => false));
            $this->Session->setFlash(sprintf(__('You have to log in to access %s'), $strpath), 'warning');
       $controller->redirect($loginAction);
            }
            $this->_flashmessage = '';
        }
    }

    /**
     * API functions
     */
    function setPreviousUrl($url) {
        $this->Session->write('Authake.previousUrl', $url);
    }

    function getPreviousUrl() {
        return $this->Session->read('Authake.previousUrl');
    }

    function isLogged() {
        return ($this->getUserId() !== null);
    }

    function getLogin() {
        return $this->Session->read('Authake.login');
    }

    function getUserId() {
        return $this->Session->read('Authake.id');
    }

    function getUserEmail() {
        return $this->Session->read('Authake.email');
    }

    function getGroupIds() {
        $gid = $this->Session->read('Authake.group_ids');
        return (empty($gid) ? null : $gid); //If not logged in (or no groups - return null)
    }

    function getGroupNames() {
        $gn = $this->Session->read('Authake.group_names');
        return (is_array($gn) ? $gn : array(__('Guest')));
    }

    function isMemberOf($gid) {
        return in_array($gid, $this->getGroupIds());
    }

    function setTimestamp() {
        $ts = $this->Session->write('Authake.timestamp', time());
    }

    function login($user) {
        $previousUrl = $this->Session->read("Authake.previousUrl");
        $this->Session->write('Authake', $user);
        $this->Session->write("Authake.previousUrl", $previousUrl);
        $this->setTimestamp();
    }

    function logout() {
        $this->Session->delete('Authake');
    }

    function getRules($group_ids = null) {
        $force_reload = (time() - $this->Session->read('Authake.cacheRulesTime')) > Configure::read('Authake.rulesCacheTimeout');

        if ($force_reload
                || is_array($group_ids)
                //|| ($cacheRules = $this->Session->read('Authake.cacheRules')) === null
                || $cacheRules = null === null
        ) {
            App::import("Model", "Authake.Rule");
            $rule = new Rule;
            $cacheRules = $rule->getRules(is_array($group_ids) ? $group_ids : $this->getGroupIds(), true); // use groups provided or take groups of the users

            if ($group_ids === null) { // cache only if groups of user used
                $this->Session->write('Authake.cacheRules', $cacheRules);
                $this->Session->write('Authake.cacheRulesTime', time());
            }
        }

        return $cacheRules;
    }

    // Function to check the access for the controller / action
    function isAllowed($url = "", $group_ids = null) { // $checkStr: "/name/action/" $group_ids: check again thess groups
          if (is_array($url)) { $url = $this->cleanUrl($url) ;}
        $allow = false;
        $rules = $this->getRules($group_ids);
        foreach ($rules as $data) {
            if (preg_match("/^({$data['Rule']['action']})$/i", $url, $matches)) {
                $allow = $data['Rule']['permission']; //echo $allow.'=>'.$url.' ** '.$data['Rule']['action'];
                //The Enum database type has to be changed to boolean, False for deny, True for allow
                if ($allow == false) {
                    $allow = false;
                    $this->_forward = $data['Rule']['forward'];
                    $this->_flashmessage = $data['Rule']['message'];
                } else {
                    $allow = true;
                }
            }
        }
        return $allow;
    }

    function getActionsPermissions($group_ids) {
        //pr(getcwd());

        $controllers = $this->_getControllers();
        $rules = $this->getRules($group_ids);
        $actionsList = array();

        foreach ($controllers as $controller => $actions) {
            foreach ($actions as $k => $action) {
                $con = strtolower($controller);
                $permission = $this->_areGroupsAllowed("/{$con}/{$action}/", $rules);
                $actionsList[$controller][] = array('controller' => $con, 'action' => $action, 'permission' => $permission);
            }
        }

        return $actionsList;
    }

    function _getControllers($lowercase = false) {//http://www.cleverweb.nl/cakephp/list-all-controllers-in-cakephp-2/
        $aCtrlClasses = App::objects('controller');

        foreach ($aCtrlClasses as $controller) {
            if ($controller != 'AppController') {
                // Load the controller
                App::import('Controller', str_replace('Controller', '', $controller));


                // Load its methods / actions
                $aMethods = get_class_methods($controller);

                foreach ($aMethods as $method => $idx) {

                    if ($method{0} == '_') {
                        unset($aMethods[$idx]);
                    }
                }

                // Load the ApplicationController (if there is one)
                App::import('Controller', 'AppController');
                $parentActions = get_class_methods('AppController');

                $controllers[$controller] = array_diff($aMethods, $parentActions);
            }
        }
        return $controllers;
    }

    // Function to check the access for the controller / action
    function _areGroupsAllowed($url = "", $rules) { // $checkStr: "/name/action/" $group_ids: check again thess groups
        $allow = false;
        foreach ($rules as $data) {
            if (preg_match("/{$data['Rule']['action']}/i", $url, $matches)) {
                $allow = $data['Rule']['permission'];
                if ($allow == false)
                    $allow = false;
                else
                    $allow = true;
            }
        }
        return $allow;
    }

    private function cleanUrl($url) {
        $clurl = array_intersect_key($url, array("controller" => '', "action" => '', "prefix" => '', "admin" => ''));
        
        return Router::url($clurl + array("base" => false));
   }

}

?>
