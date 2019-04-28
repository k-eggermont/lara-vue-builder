<?php
namespace Keggermont\LaraVueBuilder\App\Fields;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UploaderField extends Field {

    public $vueComponent = "UploaderField";
    public $validationType = "array";
    public $maxFiles = 1;
    public $maxSizePerFiles = 1024; // 1mo / 1024ko


    public function __construct($name,$field = null) {
        parent::__construct($name,$field);

        $this->

        $this->renderBeforeStore(function() {

            dump($this->value);
            request()->validate([
                $this->name.".old" => "array",
                $this->name.".uploads" => "array",
                $this->name.".uploads.*.base64" => "is_base64",
                $this->name.".uploads.*.name" => "string"
            ]);

            if($this->maxSizePerFiles) {
                request()->validate([
                    $this->name.".old" => "array",
                    $this->name.".uploads" => "array",
                    $this->name.".uploads.*.base64" => "is_base64",
                    $this->name.".uploads.*.name" => "string"
                ]);
            }

            return "string";
            //dd($this->value);
            //dd("ok");
        });
        return $this;
    }



}