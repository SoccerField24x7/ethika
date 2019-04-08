<?php

namespace App\Models;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;

class ModelWithValidation extends Model
{

    protected $rules = [];
    protected $errors = [];

    public function validate($data) : bool
    {
        $v = Validator::make($data, $this->rules);

        if ($v->fails()) {
            foreach ($v->errors()->all() as $error) {
                $this->errors[] = $error;
            }
            return false;
        }

        return true;
    }

    public function errors() : array
    {
        return $this->errors;
    }

    public static function toObject(array $data, $obj)
    {
        $cols = $obj->getTableColumns();

        foreach ($data as $key => $value) {
            /* if the key exists in the table, set the value */
            if (in_array($key, $cols)) {
                $obj->{$key} = $value;
            }
        }

        return $obj;
    }

    public function getTableColumns() : array
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
