<?php
namespace Keggermont\LaraVueBuilder\App\Fields;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Field {

    public $vueComponent = "InputField";
    public $field;
    public $name;
    public $nullable = false;
    public $displayOn = ["index","creating","updating"];
    public $min = null;
    public $max = null;
    public $value = "valuedemo";
    public $validationType = "string";
    public $authorized = true;
    public $callbackBeforeStore = false;
    public $metas = [];
    public $options = [];
    public $placeholder = "";

    //field vueComponent name nullable value

    public function __construct($name,$field = null) {
        if(!$field) {
            $field = $name;
        }
        $this->field = $field;
        $this->name = $name;
        return $this;
    }

    public function onlyOnIndex() {
        $this->displayOn = ["index"];
        return $this;
    }

    public function setPlaceholder($placeholder) {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function onlyOnForms() {
        $this->displayOn = ["updating","creating"];
        return $this;
    }
    public function onlyWhenUpdating() {
        $this->displayOn = ["updating"];
        return $this;
    }
    public function onlyWhenCreating() {
        $this->displayOn = ["creating"];
        return $this;
    }
    public function hideOnIndex() {
        $this->displayOn = array_diff($this->displayOn, ["index"]);
        return $this;
    }
    public function hideOnUpdating() {
        $this->displayOn = array_diff($this->displayOn, ["updating"]);
        return $this;
    }
    public function hideOnCreating() {
        $this->displayOn = array_diff($this->displayOn, ["creating"]);
        return $this;
    }

    public function min($val = null) {
        if(intval($val) > 0) { $this->min = intval($val); }
        return $this;
    }
    public function max($val = null) {
        if(intval($val) > 0) { $this->max = intval($val); }
        return $this;
    }

    /*
     * Execute action before creating or updating
     */
    public function renderBeforeStore(Callable $callback) {
        $this->callbackBeforeStore = $callback;
        return $this;
    }

    public function renderCallback() {
        if($this->callbackBeforeStore instanceof Closure) {
            $this->value = call_user_func($this->callbackBeforeStore,$this);
        }
        return $this;
    }


    public function nullable($val = true) {
        if($val != true) { $this->nullable = false; }
        else { $this->nullable = true; }
        return $this;
    }

    /*
     * $data can be a string (policy method from object) or a callback.
     */
    public function can($data, $entity = false) {
        if($data instanceof Closure) {
            $data = call_user_func($data);
        } else {
            if(is_string($data) && $entity) {
                if(policy($entity)->{$data}(null, $entity)) {
                    $this->authorized = true;
                } else {
                    $this->authorized = false;
                }
            }
        }
        if($data != true) {
            $this->authorized = false;
        }
        return $this;
    }

    public function setMeta(array $arr = []) {
        $this->metas = $arr;
        return $this;
    }


    public function options($opt) {
        if($opt instanceof Closure) {
            $this->options = call_user_func($opt);
            return $this;
        }
        $this->options = $opt;
        return $this;
    }


}