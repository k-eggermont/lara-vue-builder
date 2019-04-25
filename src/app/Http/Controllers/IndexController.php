<?php
namespace Keggermont\LaraVueBuilder\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends FormController {

    public function index(Request $request) {
        $this->authorize('index', $this->resource);
        return $this->resource::with($this->form::$with)->paginate($request->get("per_page",20));
    }
    public function fields() {
        if(request()->get("state") == "updating") { $ability = "update"; }
        elseif(request()->get("state") == "creating") { $ability = "create"; }
        else {
            $ability = request()->get("state");
        }

        $this->authorize($ability, $this->resource);
        return $this->form->getFieldsData(null,request()->get("state"));
    }

    public function delete() {
        $this->authorize('delete', $this->resource);
        if($this->resource) {
            $this->resource->delete();
            return ["success" => true];
        }
        abort(404, "404 Not found");

    }

    public function create(Request $request) {
        $this->authorize('create', $this->resource);
        $request->validate($this->form->validationRules());

        list($model, $fieldsNotUpdated) = $this->createModel($this->resource, $request);

        $model = $this->form->executeBeforeProcessing($model,$fieldsNotUpdated);
        $model->save();

        return ["success" => true, "model" => $model];
    }

    public function store(Request $request) {
        $this->authorize('update', $this->resource);
        if(!$this->resource) {
            abort(404, "404 Not found.");
        }
        $request->validate($this->form->validationRules());

        // We can retrive the model with new values, and the list of non updated fields.
        list($model, $fieldsNotUpdated) = $this->updateModel($this->resource, $request);

        $model = $this->form->executeBeforeProcessing($model,$fieldsNotUpdated);
        $model->save();

        return ["success" => true, "model" => $model];
    }

}