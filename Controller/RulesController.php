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


class RulesController extends AuthakeAppController {
   
    var $uses = array('Authake.Rule');
    //var $scaffold;
   // var $layout = 'authake';

    function index($tableonly = false) {
        $this->Rule->recursive = 0;
        $this->set('rules', $this->Rule->find('all'));
        $this->set('tableonly', $tableonly);
    }
    
    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Rule.'), 'error');
            $this->redirect(array('action'=>'index'));
        }
        $this->set('rule', $this->Rule->read(null, $id));
    }


    function add() {
        if (!empty($this->data)) {
            $this->Rule->create();
            if ($this->Rule->save($this->data)) {
                $this->Session->setFlash(__('The Rule has been saved'), 'success');
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Rule could not be saved. Please, try again.'), 'warning');
            }
        }
        
        $groups = $this->Rule->Group->find('list');
        $this->set(compact('groups'));
        
        // fix permissions dropdown menu
        $permissions = $this->Rule->getEnumValues('permission');
        $this->set(compact('permissions'));
    }

    function edit($id = null) {//$this->Rule->getEnumValues('permission'));
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Rule'), 'error');
            $this->redirect(array('action'=>'index'));
        }
        if ($id == '1') { // do not touch to the admin rule
            $this->Session->setFlash(__('Impossible to edit this rule!'), 'warning');
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Rule->save($this->data)) {
                $this->Session->setFlash(__('The Rule has been saved'), 'success');
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Rule could not be saved. Please, try again.'), 'warning');
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Rule->read(null, $id);
        }
        
        // fix groups dropdown menu
        $groups = $this->Rule->Group->find('list');
        $this->set(compact('groups'));
        
        // fix permissions dropdown menu
        $permissions = $this->Rule->getEnumValues('permission');
        $this->set(compact('permissions'));
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Rule'), 'error');
        } else
        if ($id == '1') { // do not touch to the admin rule
            $this->Session->setFlash(__('Impossible to delete this rule!'), 'warning');
        } else
        if ($this->Rule->delete($id)) {
            $this->Session->setFlash(__('Rule deleted'), 'success');
        }
        $this->redirect(array('action'=>'index'));
    }

    function up($id1, $id2) {   // swap order of two rules
        if ($id1 != 1 && $id2 != 1) {
            $r1 = $this->Rule->findById($id1);
            $r2 = $this->Rule->findById($id2);
//            pr(array($r1,$r2));
            $order = $r1['Rule']['order'];
            $r1['Rule']['order'] = $r2['Rule']['order'];
            $r2['Rule']['order'] = $order;
//            pr(array($r1,$r2));
            $this->Rule->save($r1);
            $this->Rule->save($r2);
        }
        $this->redirect(array('action'=>'index'));
    }

}

?>