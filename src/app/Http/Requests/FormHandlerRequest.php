<?php

namespace Keggermont\LaraVueBuilder\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormHandlerRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function getFormObject($entity) {
        if (php_sapi_name() == 'cli') {
            return null;
        }
        $resource = $this->route('resource');
        $resource = "\App\Forms\\" . ucfirst($resource) . "Form";
        if (!class_exists($resource)) {
            abort(404, 'Form "' . addslashes($resource) . '" not found');
            throw new \Exception("Form doesn't exist");
        }

        return new $resource($entity);
    }

    /**
     * Return the entity with params.
     * @return object
     * @throws \Exception
     */
    public function getResourceObject() {
        if (php_sapi_name() == 'cli') {
            return null;
        }

        $className = "\App\Test";
        if(!$className) {
            abort(404, 'The property class was not set on the form.');
        }
        if (!class_exists($className)) {
            abort(404, 'Entity "' . addslashes($className) . '" not found');
        }

        $id = $this->route('resourceId',false);
        if ($id) {
            $resource = ($className)::where("id", $id)->firstOrFail();
            return $resource;
        }

        return new $className();
    }
}
