<?php

namespace Keggermont\LaraVueBuilder\App\Forms;

abstract class Form {

    private $entity = null;
    static $with = [];
    static $actions = ["create","update","delete","index","view"];

    public function __construct($entity = null)
    {
        if($entity) { $this->entity = $entity; }
        else { $this->entity = new $this->class(); }
        if(!$this->entity) { throw new \Exception("You need to set the ENTITY on your form"); }
    }


    public function getFieldsData($post = null, $method = "index") {
        $fields = $this->fields();
        $data = [];
        foreach($fields as $field) {
            if($field->authorized && in_array($method,$field->displayOn)) {

                if(is_array($post) && isset($post[$field->field])) {
                    $field->value = $post[$field->field];
                    if($field->callbackBeforeStore) {
                        $field->renderCallback();
                    }
                } else {
                    $field->value = $this->entity->{$field->field};
                }
                $data[] = $field;
            }
        }
        return $data;
    }

    public function executeBeforeProcessing($model, $fieldsNotUpdated) {
        /**
         * You can update this method for adding custom processing before insert/update
         */
        return $model;
    }

    public function validationRules() {
        $return = [];

        //$request->validate(["Test1"=> array("required","string","min:3")]);
        foreach($this->getFieldsData() as $field) {
            $tmp = []; 
            if($field->nullable == true) { $tmp[] = "nullable"; } else { $tmp[] = "required"; }
            $tmp[] = $field->validationType;
            if($field->min > 0) { $tmp[] = "min:".$field->min; }
            if($field->max > 0) { $tmp[] = "max:".$field->max; }
            if(is_array($field->options) && sizeof($field->options)>0) { $tmp[] = "in:".implode(",",array_keys($field->options)); }

            $return[$field->field] = $tmp;
        }
        return $return;
    }

}