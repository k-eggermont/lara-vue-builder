<?php
namespace Keggermont\LaraVueBuilder\App\Fields;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NumberField extends Field {

    public $vueComponent = "NumberField";
    public $validationType = "numeric";
    public $step = 1;

    public function __construct($name,$field = null) {
        parent::__construct($name,$field);
        return $this;
    }

    public function step($step = 1) {
        $this->step = $step;
        return $this;
    }



}