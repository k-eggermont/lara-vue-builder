!!!!!!! DON'T USE THIS PACKAGE IN PRODUCTION -- THE PACKAGE IS UNDER DEVELOPEMENT !!!!!!!

# LaraVueBuilder

LaraVueBuilder is a package for Laravel 5.8 for generating forms from laravel, and easy get a VueJS2 dynamic form with validation, policies, events ...

It's inspired by *Laravel Nova*, but more lighter, customizable and for front & back usage.


## Summary
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage section](#usage)
- [Routes generated by form](#routes)
- [Authorization and policies](#authorization)
- [Custom PHP processing before creating/updating](#custom-processing)
- [Available Fields Type](#fields)

## Installation

### Install package
Install the composer package :
```bash
composer require k-eggermont/lara-vue-builder
```


### Auto-Discovery
The package is configured for Laravel Auto-Discovery.
If this feature was not enabled on your project, please add on your config/app.php file :


```php
return [
    'providers' => [
    
        // (...)        
        Keggermont\LaraVueBuilder\LaraVueBuilderServiceProvider::class,
        // (...)
        
    ]
];
```

### Publish assets

After, you can publishes files (config, translations, js, sass) :
```bash
php artisan vendor:publish --provider="Keggermont\LaraVueBuilder\LaraVueBuilderServiceProvider"
```

### NPM dependancies
```bash
npm i --save form-backend-validation 

# Not required, but if you don't install this packages, you need to reconfigure the file in resources/js/laravuebuilder.js
npm i --save vue-flatpickr-component vue-m-message vue-sweetalert2
```

I recommend to use vue-router in your project 


### Add the resources to your assets

Add the require to your app.js file :
```js
require('./vendor/laravuebuilder/laravuebuilder.js');
```

## Configuration

### PHP
You can configure the php file /config/laravuebuilder.php.

### Javascript
The best practice was to copy the file /js/vendor/laravuebuilder/laravuebuilder.js to your /resources/js folder.
After, you can adapt the dependencies, or requirements (adding new field, update a field, the form etc..)

For example, if you want to change the InputField.vue :

Copy the resources/js/vendor/laravuebuilder/components/Fields/InputField.vue to /resources/js/Fields/InputField.vue
You can erase all component OR using the base on a mixin, example :
```js
<template>
    <label :class="{ errorClass: isError }">
        {{ field.name }} :
        <input type="text" :value="$parent.form[field.name]" @input="updateField($event.target.value)" v-on:keyup.enter="$parent.onSubmit">
    </label>
</template> 
<script>
    import InputFieldMixin from "../vendor/laravuebuilder/components/Fields/InputField.vue";
    export default {

        props: ["field", "error", "isError"],
        mixins: [ InputField ],
        mounted() {
            console.log("field mounted!");
        }, 
    }
</script>
```

### SASS
On this package, i'll give a SASS file with some default style.
Tailwindcss was required for use this style. If tailwind was installed and configured, you can add to your main scss file : 

```css
@import 'vendor/laravuebuilder/app.scss';
```

More informations about installation and configuration of tailwindcss: https://tailwindcss.com/docs/installation/


### Render assets
```bash
npm i && npm run watch
```

## Usage

### Generator
You can use the command make:form.
Exemple, i have a entity "App\Book", and i want to create the form "BookForm". I will use :

```bash
php artisan make:form BookForm "App\Book" --policy
```

That will create the form in app/Forms/BookForm.php

### Configure the fields
Now you can open the file app/Forms/BookForm.php

```php
    public function fields() {

        /*
        Here you can add your fields.
        */
        return [
            
            // Declare the input "title"
            (new \Keggermont\LaraVueBuilder\App\Fields\InputField("title"))->nullable(),
            
        ];

    }
```

On the field, you can set some params :

Min value => ->min($value)
Max value => ->max($value)
Nullable => ->nullable()

The settings will add validation rules for backend validation (Laravel Validator).

You can explore the file Keggermont\LaraVueBuilder\App\Fields\Field.php for more settings.

@todo => others fields type.

### Routes
The form model give you some new api routes.

- POST /api/forms/{nameOfForm} => Create a new resource
- POST /api/forms/{nameOfForm}/{resourceId} => Update a resource
- DELETE /api/forms/{nameOfForm}/{resourceId} => Delete
- GET /api/forms/{nameOfForm}/{resourceId} => Get data of a resource @todo
- GET /api/forms/{nameOfForm} => Get data of all resources @todo



### Display the form 
On the view, you need to do for the create form :
```html
<form-field resource="Book" :resource-id="null" :reset-on-submit="true">
    <div slot="submit-text">Create</div>
</form-field>
```
For the edition, we can pass the resource-id (Book id: 1) :
```html
<form-field resource="Book" :resource-id="1" :reset-on-submit="false">
    <div slot="submit-text">Edit</div>
</form-field>
```

You can customize the form and the text with slot. Check the source code of the FormField.vue


### Authorization
You can setup custom authorization with the policy. 
You are able to configure a custom policy closure with the method ->can() (on a field).

#### Make action possible with guest users
For let non authenticated user use the form, in the policy you have to put (?User $user) instead of (User $user)

### Custom processing
For custom processing (before updating or creating), you can use the method executeBeforeProcessing in the Form model.

Events :

- Keggermont\LaraVueBuilder\App\Events\LaraVueFormCreated
- Keggermont\LaraVueBuilder\App\Events\LaraVueFormCreating
- Keggermont\LaraVueBuilder\App\Events\LaraVueFormUpdated
- Keggermont\LaraVueBuilder\App\Events\LaraVueFormUpdating
- Keggermont\LaraVueBuilder\App\Events\LaraVueFormDeleted
- Keggermont\LaraVueBuilder\App\Events\LaraVueFormDeleting

Maybe need some improvements !


## Fields
- InputField
- SelectField

TODO => make more fields, like :

- Searchable Select2 Field
- Radio Field
- Boolean Field
- Checkbox Field
- Textarea Field
- Uploader Field
 [...]