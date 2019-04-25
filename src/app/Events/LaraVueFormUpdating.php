<?php

namespace Keggermont\LaraVueBuilder\App\Events;

class LaraVueFormUpdating
{
    /**
     * The user instance.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $form;

    public $entity;


    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function __construct($form,$entity)
    {
        $this->form = $form;
        $this->entity = $entity;
    }
}
