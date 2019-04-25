<?php
namespace Keggermont\LaraVueBuilder\App\Fields;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class InputField extends Field {

    public $vueComponent = "InputField";

    public function __construct($name,$field = null) {
        parent::__construct($name,$field);
        return $this;
    }



}