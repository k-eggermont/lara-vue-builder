<?php
namespace Keggermont\LaraVueBuilder\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Keggermont\LaraVueBuilder\Http\Requests\FormHandlerRequest;

class FormController extends Controller {
    public $form;
    public $resource;

    public function __construct(FormHandlerRequest $request) {
        list($resource, $entity) = $request->parseResourceInformations();

        $this->resource = $resource;
        $this->form = $entity;
    }

    public function updateModel($model = null, Request $request) {
        if(!$model) { $model = $this->resource; }
        $form = ($this->form->getFieldsData($request->all(),"updating"));
        $unset = [];
        foreach($request->all() as $key => $val) {
            if(!isset($model->{$key})) {
                $unset[$key] = $val;
            }
        }
        foreach($form as $field) {
            if(!isset($unset[$field->field])) {
                $model->{$field->field} = $field->value;
            }
        }

        return [$model, collect($unset)];
    }
    public function createModel($model = null, Request $request) {
        if(!$model) { $model = $this->resource; }
        $form = ($this->form->getFieldsData($request->all(),"creating"));
        $unset = [];
        foreach($request->all() as $key => $val) {
            if(!isset($model->{$key})) {
                $unset[$key] = $val;
            }
        }
        foreach($form as $field) {
                $model->{$field->field} = $field->value;
        }

        return [$model, collect($unset)];
    }

}