# LaraVueBuilder

LaraVueBuilder is a package for Laravel 5.8 for generating forms from laravel, and easy get a VueJS2 dynamic form with validation, policies, events ...

It's inspired by *Laravel Nova*, but more lighter, customizable and for front & back usage.


## Summary
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage section](#usage)
- [Authorization and policies](#policies)

## Installation

### Install package
Install the composer package :
```bash
composer require keggermont/laravuebuilder
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
npm i --save vue-m-message vue-sweetalert2
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


## Usage