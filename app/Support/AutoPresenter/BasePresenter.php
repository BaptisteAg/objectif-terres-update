<?php

declare(strict_types=1);

namespace App\Support\AutoPresenter;

use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Support\Str;
use JsonSerializable;
use App\Support\AutoPresenter\Exceptions\MethodNotFoundException;

abstract class BasePresenter implements UrlRoutable, JsonSerializable
{
    protected $wrappedObject;

    public function setWrappedObject($resource)
    {
        $this->wrappedObject = $resource;

        return $this;
    }

    public function getWrappedObject()
    {
        return $this->wrappedObject;
    }

    public function getRouteKey()
    {
        return $this->wrappedObject->getRouteKey();
    }

    public function getRouteKeyName()
    {
        return $this->wrappedObject->getRouteKeyName();
    }

    public function resolveRouteBinding($routeKey, $field = null)
    {
        if (method_exists($this->wrappedObject, 'resolveRouteBinding') && is_callable([$this->wrappedObject, 'resolveRouteBinding'])) {
            return $this->wrappedObject->resolveRouteBinding($routeKey, $field);
        }

        return $this->wrappedObject->where($field ?? $this->wrappedObject->getRouteKeyName(), $routeKey)->first();
    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        if (method_exists($this->wrappedObject, 'resolveChildRouteBinding') && is_callable([$this->wrappedObject, 'resolveChildRouteBinding'])) {
            return $this->wrappedObject->resolveChildRouteBinding($childType, $value, $field);
        }

        return $this->wrappedObject->{Str::plural($childType)}()->where($field, $value)->first();
    }

    public function jsonSerialize(): array
    {
        $attributes = [];

        foreach ($this->wrappedObject->getAttributes() as $attribute => $value) {
            $attributes[$attribute] = $this->$attribute;
        }

        return $attributes;
    }

    public function __get(string $key)
    {
        if (method_exists($this, $key)) {
            return $this->{$key}();
        }

        return $this->wrappedObject->$key;
    }

    public function __call(string $key, array $args)
    {
        if (method_exists($this->wrappedObject, $key)) {
            return call_user_func_array([$this->wrappedObject, $key], $args);
        }

        throw new MethodNotFoundException(get_called_class(), $key);
    }

    public function __isset(string $key)
    {
        if (method_exists($this, $key)) {
            return true;
        }

        return isset($this->wrappedObject->$key);
    }

    public function __toString()
    {
        return (string) $this->wrappedObject;
    }
}
