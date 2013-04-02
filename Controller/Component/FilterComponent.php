<?php
/**
* Filter component
* Benefits:
* 1. Keep the filter criteria in the Session
* 2. Give ability to customize the search wrapper of the field types
*
* @author  Mutlu Tevfik Kocak
* @website http://www.mtkocak.net
* @version 2.2.3
*
* @author  Nik Chankov
* @website http://nik.chankov.net
* @version 1.0.0
*
*/

class FilterComponent extends Component {
    /**
    * fields which will replace the regular syntax in where i.e. field = 'value'
    */
    var $fieldFormatting    = array(
        "string"=>array("%1\$s LIKE", "%2\$s%%"),
        "text"=>array("%1\$s LIKE", "%2\$s%%"),
        "date"=>array("DATE_FORMAT(%1\$s, '%%d-%%m-%%Y')", "%2\$s"),
        "datetime"=>array("DATE_FORMAT(%1\$s, '%%d-%%m-%%Y')", "%2\$s")
        );
        /**
        * Function which will change controller->data array
        *
        * @param object $controller the class of the controller which call this component
        * @access public
        */
        function initialize(Controller $controller) { }
        function __construct(ComponentCollection $collection, $settings = array()) {
            parent::__construct($collection, $settings);
        }
        function process($controller){
            $this->_prepareFilter($controller);
            $ret = array();
            if(isset($controller->request->data)){
                //Loop for models
                foreach($controller->request->data as $key=>$value){
                    if(isset($controller->{$key})){
                        $columns = $controller->{$key}->getColumnTypes();
                        foreach($value as $k=>$v){
                            if($v != ''){
                                //Trim the value
                                $v=trim($v);
                                //Check if there are some fieldFormatting set
                                if(isset($this->fieldFormatting[$columns[$k]])){
                                    $ret[sprintf($this->fieldFormatting[$columns[$k]][0], $key.'.'.$k, $v)] = sprintf($this->fieldFormatting[$columns[$k]][1], $key.'.'.$k, $v);
                                } else {
                                    $ret[$key.'.'.$k] = $v;
                                }
                            }
                        }
                        //unsetting the empty forms
                        if(count($value) == 0){
                            unset($controller->data[$key]);
                        }
                    }
                }
            }
            return $ret;
        }

        /**
        * function which will take care of the storing the filter data and loading after this from the Session
        */
        function _prepareFilter(Controller $controller){
            if(isset($controller->data)){
                foreach($controller->data as $model=>$fields){
                    foreach($fields as $key=>$field){
                        if($field == ''){
                            unset($controller->request->data[$model][$key]);
                        }
                    }
                }
                $controller->Session->write($controller->name.'.'.$controller->params['action'], $controller->data);
            }
            $filter = $controller->Session->read($controller->name.'.'.$controller->params['action']);
            $controller->data = $filter;
        }
    }