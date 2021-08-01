<?php

namespace app\Core\Form;

use app\Core\Model;

class Field {
    public const TYPE_TEXT = 'text';
    public const TYPE_EMAIL= 'email';
    public const TYPE_PASSWORD = 'password';
    

    public string $type;
    public Model $model;
    public string $attribute;

    public function __construct($model, $attribute){
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString() {
        return sprintf('
            <div class="mb-3">
                <label>%s</label>
                <input type="%s" name="%s" value="%s" class="form-control%s">
                <div class="invalid-feedback">
                   %s 
                </div>
            </div>
        ',
            $this->model->labels()[$this->attribute] ?? $this->attribute,
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->model->getFirstError($this->attribute)
        );
    }

    public function fieldEmail() {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    public function fieldPassword() {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
}