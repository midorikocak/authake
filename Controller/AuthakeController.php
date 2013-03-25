<?php
/*
	This file is part of Authake.

	Author: Jérôme Combaz (jakecake/velay.greta.fr)
	Contributors: Mutlu Tevfik Kocak (mtkocak.net)

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
class AuthakeController extends AuthakeAppController {
	var $uses = array('Authake.User','Authake.Rule','Authake.Group');// needed as we don't have any model
	//var $layout = 'authake';
	
	function index() {
		$this->set('title_for_layout', 'Authake User & Group Management');
		$admins = $this->Group->find('all', array('conditions'=>array('name'=>'Administrators')));
		$adminCount = sizeof($admins[0]['User']);
		$userCount = $this->User->find('count');
		$groupCount = $this->Group->find('count');
		$ruleCount = $this->Rule->find('count');
		$this->set(compact('adminCount','userCount','groupCount','ruleCount'));
	}
	
	function help() {
		$this->set('title_for_layout', 'Help for Authake');
	}
	
	function settings(){
		if (!empty($this->request->data['Settings']))
		{
		    $this->request->data['Settings']['loginAction'] = Router::parse($this->request->data['Settings']['loginAction']);
		    $this->request->data['Settings']['defaultDeniedAction'] = Router::parse($this->request->data['Settings']['defaultDeniedAction']);
			Configure::write('Authake',$this->request->data['Settings']);
		}
	$configs = Configure::read('Authake');
	Configure::dump('authake_config.php', 'Authake', array('Authake'));
	$this->set(compact('configs'));// fix permissions dropdown menu
	}
	
	function reset(){
	            Configure::write('Authake.baseUrl', Router::url('/', true));   // set the full application url
	            Configure::write('Authake.service', 'Authake'); //Name of the service i.e. "Super Authake"
	            Configure::write('Authake.loginAction', array('plugin' => 'authake', 'controller' => 'user', 'action' => 'login', 'admin' => 0));
	            Configure::write('Authake.loggedAction', Configure::read('Authake.baseUrl'));
	            Configure::write('Authake.sessionTimeout', 3600 * 24 * 7);
	            Configure::write('Authake.defaultDeniedAction', array('plugin' => 'authake', 'controller' => 'user', 'action' => 'denied', 'admin' => 0));
	            Configure::write('Authake.rulesCacheTimeout', 300);
	            Configure::write('Authake.systemEmail', 'noreply@example.com');
	            Configure::write('Authake.systemReplyTo', 'noreply@example.com');
	            Configure::write('Authake.passwordVerify', true);
	            Configure::write('Authake.registration', true); //or false
	            Configure::write('Authake.defaultGroup', 2); //could be array or single number
	            Configure::write('Authake.useDefaultLayout', false); //could be true or false
	            Configure::write('Authake.useEmailAsUsername', false); //could be true or false
	            Configure::dump('authake_config.php', 'Authake', array('Authake'));
				$this->Session->setFlash(__('Authake Reset'), 'success');
				$this->redirect(array('action'=>'index'));
			}
}
?>