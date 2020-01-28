<?php


namespace App\Presenters\contracts;


class Presenter
{
    protected $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function __get($property)
    {
        if (!method_exists($this, $property)){
            return $this->entity->{$property};
        }
        return $this->{$property}();
    }
}
