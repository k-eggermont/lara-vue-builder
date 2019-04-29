<?php
namespace Keggermont\LaraVueBuilder\App\Fields;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DateTimeField extends Field {

    public $vueComponent = "DatetimeField";
    public $displayDateFormat = "d-m-Y H:i";
    public $enableTime = false;
    public $minDate = null;
    public $maxDate = null;
    public $defaultDate = null;

    public function setMinDate($val) {
        $this->minDate = $val;
        return $this;
    }
    public function setDefaultDate($val) {
        $this->defaultDate = $val;
        return $this;
    }
    public function setMaxDate($val) {
        $this->maxDate = $val;
        return $this;
    }

    public function setEnableTime(Bool $val = true) {
        $this->enableTime = $val;
        return $this;
    }
    public function setDisplayDateFormat(String $val = "d-m-Y H:i") {
        $this->displayDateFormat = $val;
        return $this;
    }

    public function __construct($name,$field = null) {
        parent::__construct($name,$field);
        return $this;
    }



}