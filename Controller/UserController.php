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

App::uses('CakeEmail', 'Network/Email');
class UserController extends AuthakeAppController {
  var $name     = 'User';
  var $uses     = array('Authake.User', 'Authake.Rule', 'Authake.Group');
  var $components = array('Email');
  var $layout = 'authake';
  
  //var $scaffold;
    
    function denied(){
      // display this view (/app/views/users/denied.ctp) when the user is denied
    }
    
    function message(){
      // display this view if you want to say something important to your users.
      // For example (your password was changed and you need to receive mail to
      // confirm it.)
    }
    
    /**
    * User profile
    */
    function index() {
        if (!$this->Authake->getUserId()) {
            $this->Session->setFlash(__('Invalid User'), 'error', array('plugin' => 'Authake'));
            $this->redirect('/');
        }

        $user = $this->User->read(null, $this->Authake->getUserId());

        if (!empty($this->data)) {
            if ($this->data['User']['password1'] != '') { // password changed
                if ($this->data['User']['password1'] != $this->data['User']['password2']) {
                    $this->Session->setFlash(__('The two passwords do not match!'), 'error', array('plugin' => 'Authake'));
                } else {
                    $user['User']['password'] = md5($this->data['User']['password1']);
                    $this->Session->setFlash(__('Password changed!'), 'success', array('plugin' => 'Authake'));
                }
            }
            $state = 0;
            if (Configure::read('Authake.passwordVerify') == true && $this->data['User']['email'] != $user['User']['email']) {
                    //Check if that email is not registered by another user
                    if($this->User->find('count', array('conditions'=>array('User.email LIKE'=>$this->data['User']['email'], 'User.id != '.$user['User']['id']))) > 0){
                      $this->Session->setFlash(__('This e-mail has beeen used by another user in the system. Please try with another one!'), 'error', array('plugin' => 'Authake'));
                      $this->redirect(array('action'=>'index'));
                    }
                    
                    $user['User']['emailcheckcode'] = md5(rand().time().rand().$user['User']['email']);
                    $user['User']['email'] = $this->data['User']['email'];
                    // send a mail with code to change the pw
                    $email = new CakeEmail();
                    $email->to($user['User']['email']);
                    $email->subject(sprintf(__('Your e-mail change request at %s '), Configure::read('Authake.service', 'Authentication')));
                    $email->replyTo(Configure::read('Authake.systemReplyTo'));
                    $email->from(Configure::read('Authake.systemEmail'));
                    $email->emailFormat('html');
                    //$this->Email->charset = 'utf-8';
                    $email->template('Authake.verify'); 
                    //Set the code into template
                    $this->set('code', $user['User']['emailcheckcode']);
                    $this->set('service', Configure::read('Authake.service'));
                    if ($email->send() ) {
                        $state = 1;
                    } else {
                        $state = 2;
                    }
            }

            //Unbind HABTM relation for this save
            $this->User->unbindModel(array('hasAndBelongsToMany'=>array('Group')), false);
            
            if($this->User->save($user['User'])){
              
              switch($state){
                case 1:
                  $this->Session->setFlash(__('Your e-mail has been changed, you should receive a mail with instructions to confirm your new e-mail...'), 'warning', array('plugin' => 'Authake'));
                  break;
                
                case 2:
                  $this->Session->setFlash(sprintf(__('Failed to send a email to change your password. Please contact the administrator at %s'), Configure::read('Authake.systemReplyTo')), 'error', array('plugin' => 'Authake'));
                  break;
                default:
                  $this->Session->setFlash(__('The User profile has been saved'), 'success', array('plugin' => 'Authake'));
              } 
            }
            if(Configure::read('Authake.passwordVerify') == true){
              $this->redirect(array('action'=>'index'));
            } else {
              $this->redirect(array('action'=>'messages'));
            }
        }

        //$this->data = null;
        $this->set(compact('user'));
    }
    
    /**
    * Confirm the email change if needed
    */
    function verify($code = null) {
        if(Configure::read('Authake.registration') == false){
          $this->redirect('/');
        }
        
        if($code != null){
          $this->request->data['User']['code'] = $code;
        }
        if (!empty($this->data)) {
            $this->User->recursive = 0;
                $user = $this->User->find('first', array('conditions'=>array('emailcheckcode'=>$this->data['User']['code'])));
                
                if (empty($user)) { // bad code or email
                    $this->Session->setFlash(__('Bad identification data!'), 'error', array('plugin' => 'Authake'));
                } else {
                    $user['User']['emailcheckcode'] = '';
                    $this->User->unbindModel(array('hasAndBelongsToMany'=>array('Group')), false);
                    $this->User->save($user);
                    
                    if($this->Authake->getUserId() == null){ //User need to be redirected to login
                      $this->Session->setFlash(__('The confirmation code has been accepted. You may log in now!'), 'success', array('plugin' => 'Authake'));
                      $this->redirect(array('action'=>'login'));
                    } else {
                      $this->Session->setFlash(__('The confirmation code has been accepted. Thank you!'), 'success', array('plugin' => 'Authake'));
                      $this->redirect(array('action'=>'index'));
                    }
                }
        }
    }
    
    /**
     * User registration
    */
    function register() {
        if(Configure::read('Authake.registration') == false){
          $this->redirect('/');
        }
        if (!empty($this->data)) {
            
            $this->User->recursive = 0;
            $exist = $this->User->findByLogin($this->data['User']['login']);
            if (!empty($exist)) {
                $this->Session->setFlash(__('This login is already used!'), 'error', array('plugin' => 'Authake'));
                return;
            }
            
            $exist = $this->User->findByEmail($this->data['User']['email']);
            if (!empty($exist)) {
                $this->Session->setFlash(__('This email is already registred!'), 'error', array('plugin' => 'Authake'));
                return;
            }

            $pwd = $this->__makePassword($this->data['User']['password1'], $this->data['User']['password2']);
            if (!$pwd) return;  // password is invalid...
            $this->request->data['User']['password'] = $pwd;
            
            $this->request->data['User']['emailcheckcode'] = md5(time()*rand());
            $this->User->create();
            //add default group if there is such thing
            if(Configure::read('Authake.defaultGroup') != null && Configure::read('Authake.defaultGroup') != false){
              $groups = $this->Group->find('all', array('fields'=>array('Group.id'), 'conditions'=>array('Group.id'=>Configure::read('Authake.defaultGroup'))));
              foreach($groups as $group){
                $this->request->data['Group']['Group'][] = $group['Group']['id'];
              }
            }
            //
            if ($this->User->save($this->data)) {
            
                // send a mail to finish the registration
$email = new CakeEmail();
                $email->to($this->data['User']['email']);
                $email->subject(sprintf(__('Your registration confirmation at %s '), Configure::read('Authake.service', 'Authentication')));
                
$email->viewVars(array('service' => Configure::read('Authake.service'), 'code'=> $this->data['User']['emailcheckcode']));
$email->replyTo(Configure::read('Authake.systemReplyTo'));
                $email->from(Configure::read('Authake.systemEmail'));
                    $email->emailFormat('html');
                //$this->Email->charset = 'utf-8';
                $email->template('Authake.register'); 
                //Set the code into template
                //$this->set('code', $this->data['User']['emailcheckcode']);
                //$this->set('service', Configure::read('Authake.service'));
                
                if ($email->send()) {
                    $this->Session->setFlash(__('You will receive an email with a code in order to finish the registration...'), 'info', array('plugin' => 'Authake'));
                } else {
                    $this->Session->setFlash(sprintf(__('Failed to send the confirmation email. Please contact the administrator at %s'), Configure::read('Authake.systemReplyTo')), 'error', array('plugin' => 'Authake'));
                }
                $this->redirect(array('plugin'=>'authake','controller'=>'user','action'=>'login'));
            } else {
                $this->Session->setFlash(__('The registration failed!'), 'error', array('plugin' => 'Authake'));
            }
        }
    }
    
    /**
     * Function which allow user to change his password if he request it
    */
    function pass($code = null){
      if($this->Authake->getUserId() > 0){
        $this->Session->setFlash(__('You are already logged in. Change your password in your profile!'), 'warning', array('plugin' => 'Authake'));
        $this->redirect(array('action'=>'index'));
      }
      $this->User->recursive = 0;
      if (!empty($this->data)) {
        $user = $this->User->find('first', array('conditions'=>array('passwordchangecode'=>$this->data['User']['passwordchangecode'])));
        if (!empty($user)) {
          $pwd = $this->__makePassword($this->data['User']['password1'], $this->data['User']['password2']);
          if (!$pwd) return;  // password is invalid...
          
          $user['User']['password'] = $pwd;
          $user['User']['passwordchangecode'] = '';
          $this->User->unbindModel(array('hasAndBelongsToMany'=>array('Group')), false);
          if($this->User->save($user)){
            //
            $this->Session->setFlash(__('Your password has been changed!. You may log in now!'), 'success', array('plugin' => 'Authake'));
            $this->redirect(array('action'=>'login'));
          } else {
            $this->Session->setFlash(__('Error while saving your password!'), 'error', array('plugin' => 'Authake'));
          }
        }
      }
      if($code != null){
        $this->request->data['User']['passwordchangecode'] = $code;
      }
    }
    
    /**
     * Login functionality
   */
    function login(){
        if ($this->Authake->isLogged()) {
            $this->Session->setFlash(__('You are already logged in!'), 'info', array('plugin' => 'Authake'));
            $this->redirect(Configure::read('Authake.loggedAction'));
        }
        
        if (!empty($this->data) ) {
            $login  = $this->data['User']['login'];
            $password = $this->data['User']['password'];
            
            $user = $this->User->findByLogin($login);
            
            if (empty($user)) {
                $this->Session->setFlash(__('Invalid login or password!'), 'error', array('plugin' => 'Authake'));
                return;
            }
            
            // check for locked account
            if ($user['User']['id'] != 1 and $user['User']['disable']) {
                $this->Session->setFlash(__('Your account is disabled!'), 'error', array('plugin' => 'Authake'));
                $this->redirect('/');
            }

            // check for expired account
            $exp = $user['User']['expire_account'];
            if ($user['User']['id'] != 1 and $exp != '0000-00-00' and $exp != null and strtotime($exp) < time()) {
                $this->Session->setFlash(__('Your account has expired!'), 'error', array('plugin' => 'Authake'));
                $this->redirect('/');
            }
            
            // check for not confirmed email
            if ($user['User']['emailcheckcode'] != '') {
                $this->Session->setFlash(__('You registration has not been confirmed!'), 'warning', array('plugin' => 'Authake'));
                $this->redirect(array('action'=>'verify'));
            }
            
            $userdata = $this->User->getLoginData($login, $password);
            
            if (empty($userdata)) {
                $this->Session->setFlash(__('Invalid login or password!'), 'error', array('plugin' => 'Authake'));
                return;
            } else {
                if($user['User']['passwordchangecode'] != ''){
                  //clear password change code (if there is any)
                  $this->User->unbindModel(array('hasAndBelongsToMany'=>array('Group')), false);
                  $user['User']['passwordchangecode'] = '';
                  $this->User->save($user);
                }
                
                
                $next = $this->Authake->getPreviousUrl();
                $this->Authake->login($userdata['User']);
                $this->Session->setFlash(__('You are logged in as ').$userdata['User']['login'], 'success' , array('plugin'=>'authake'));                
				$this->redirect(array('plugin' => null,'controller'=>'pages', 'action' => 'index'));
            }
        }
    }
    
    function lost_password() {
        if(Configure::read('Authake.registration') == false){
          $this->redirect('/');
        }
        $this->User->recursive = 0;
        
        if (!empty($this->data)) {
            $loginoremail = $this->data['User']['loginoremail'];
            if ($loginoremail) {
                $user = $this->User->findByLogin($loginoremail);
            }
            if (empty($user)) {
                $user = $this->User->findByEmail($loginoremail);
            }
            if (!empty($user)) { // ok, login or email is ok
                //Prevent sending more than 11 e-mail
                if($user['User']['passwordchangecode'] != ''){
                  $this->Session->setFlash(__("You already requested password change. Please check your e-mail and use the code which we've sent"), 'error', array('plugin' => 'Authake'));
                  $this->redirect(array('action'=>'lost_password'));
                }
                $md5 = $user['User']['passwordchangecode'] = md5(time()*rand().$user['User']['email']);
                
                $this->User->unbindModel(array('hasAndBelongsToMany'=>array('Group')), false);
                if ($this->User->save($user)) {
                    // send a mail with code to change the pw
                    $this->Email->to = $user['User']['email'];
                    $this->Email->subject = sprintf(__('Your password change request at %s '), Configure::read('Authake.service', 'Authentication'));
                    $this->Email->replyTo = Configure::read('Authake.systemReplyTo');
                    $this->Email->from = Configure::read('Authake.systemEmail');
                    $this->Email->sendAs = 'html';
                    $this->Email->charset = 'utf-8';
                    $this->Email->template = '`Authake.lost_password'; 
                    //Set the code into template
                    $this->set('code', $user['User']['passwordchangecode']);
                    $this->set('service', Configure::read('Authake.service'));
                     
                    if ($this->Email->send() ) {
                        $this->Session->setFlash(__('If data provided is correct, you should receive a mail with instructions to change your password...'), 'warning', array('plugin' => 'Authake'));
                    } else {
                        $this->Session->setFlash(sprintf(__('Failed to send a email to change your password. Please contact the administrator at %s'), Configure::read('Authake.systemReplyTo')), 'error', array('plugin' => 'Authake'));
                    }
                } else {
                    $this->Session->setFlash(sprintf(__('Failed to change your password. Please contact the administrator at %s'), Configure::read('Authake.systemReplyTo')), 'error', array('plugin' => 'Authake'));
                }
            } else {
                $this->Session->setFlash(__('If data provided is correct, you should receive a mail with instructions to change your password...'), 'warning', array('plugin' => 'Authake'));
            }
            $this->redirect(array('action'=>'lost_password'));
        }
    }

    function logout()
    {
        if ($this->Authake->isLogged()) {
            $this->Authake->logout();
            $this->Session->setFlash(__('You are logged out!'), 'info', array('plugin' => 'Authake'));
        }
        $this->redirect('/');
    }
    
    function beforeFilter(){
      parent::beforeFilter();
      
      //Overwriting the authake layout with the default one
      if(Configure::read('Authake.useDefaultLayout') == true){
        $this->layout = 'default';
      }
    }
}

?>