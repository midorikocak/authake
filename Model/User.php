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
App::uses('AuthakeAppModel', 'Authake.Model');
class User extends AuthakeAppModel {
	var $name = 'User';
	var $useTable = 'authake_users';
	var $useDbConfig = 'authake';
	var $recursive = 1;
	var $hasAndBelongsToMany = array('Group' => array('className' => 'Authake.Group', 'joinTable' => 'authake_groups_users', 'foreignKey' => 'user_id', 'associationForeignKey' => 'group_id', 'conditions' => '', 'fields' => '', 'order' => '', 'limit' => '', 'offset' => '', 'finderQuery' => '', 'deleteQuery' => '', 'insertQuery' => ''));
function beforeValidate($options = array()){
    $validateOptions = array();
    if(!Configure::read('Authake.useEmailAsUsername'))
    {
        $loginOptions = array('login' => array(
            'alphanumeric' => array(
                'rule' => 'alphaNumeric', 
                'message' => 'Only alphabets and numbers allowed'
            ), 
            'minlength' => array(
                'rule' => array('minLength', ( Configure::read('Authake.useEmailAsUsername') ? '0' : '3' )),
                /* set min length to 0 if we do not want usernames but only emails*/
                'message' => 'Minimum length of 3 characters'
            ), 
            'maxlength' => array(
                'rule' => array('maxLength', '32'), 
                'message' => 'Maximum length of 32 characters'
            ),
        ));
        $validateOptions = $loginOptions;
    }
    $otherOptions = array(
        'email' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty', 
                'message'=>__('Username can not be blank')
            ), 
            'unique' => array(
                'rule' => 'isUnique',
                'message'=>__('This e-mail has already been used'), 
                'on'=>'create'
            ),
            /*'emailAddress' => array('rule' => array('email', true),'message' => __('Please supply a valid email address'))*/
        ), 
        'password1' => array(
            'checkEmpty' => array(
            'rule' => array('notEmpty'), 
            'message' => __('Passwords must be equal and not empty'),
            'on' => 'create'
                )
        ), 
        'password2' => array(
            'checkInsertPass' => array(
                'rule' => array('notEmpty'), 
                'message' => __('Passwords must be equal and not empty'),
                'on' => 'create'
            )
        )
    );
    $validateOptions += $otherOptions;
    $this->validate = $validateOptions;
}

function checkPasswords()
{
	if (($this->request->data['User']['password1'] != $this->request->data['User']['password2']))
	{
		return false;
	}

	return true;
}

function getLoginData($login='', $password='')
{
	$hashed = md5($password);

	if (Configure::read('Authake.useEmailAsUsername') == false)
	{
		$data = $this->find('first', array('conditions'=>array('login'=>$login, 'password'=>$hashed), 'recursive' => 1));
	}
	else
	{
		$data = $this->find('first', array('conditions'=>array('email'=>$login, 'password'=>$hashed), 'recursive' => 1));
	}

	if (!empty($data))
	{
	/*
	$data['User']['group_ids'][] = 0; // everybody is at least a guest
	$data['User']['group_names'][] = __('Guest');
	*/

		if (!empty($data['Group']))
		{
			foreach ($data['Group'] as $group)
			{
				$data['User']['group_ids'][] = $group['id'];
				$data['User']['group_names'][] = $group['name'];
			}
		}

		unset($data['User']['password']);// not useful to save the encrypted password in session
		return $data;
	}
	else
	{
		return false;
	}
}

	function getGroups($id)
	{
		$groups = $this->findById($id);//SORUN TAM DA BURADA OLABİLİR
		$list = array(0);

		foreach ($groups['Group'] as $group)
		{
			$list[] = $group['id'];
		}

		return $list;//var_dump($list);
	}
}
?>