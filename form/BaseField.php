<?php

/**
 *  Class BaseField
 *
 * @author Martin Maly
 * @package app\core\form
 */

namespace app\core\form;

use app\core\Model;

abstract class BaseField
{
    public Model $model;
    public string $attribute;

    /**
    * Field constractor
    * @param app\core\Model $model
    * @param string $attribute
    *
    * if you want to create custom fields just  extend  BaseField
    */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    abstract public function renderInput(): string;

     //convert object to string
    public function __toString()
    {
        return sprintf(
            '<div class="form-group">
                <label>%s</label>
                %s
                <div class="invalid-feedback">
                %s
                </div>
            </div>',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}