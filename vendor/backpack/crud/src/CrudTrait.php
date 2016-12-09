<?php

namespace Backpack\CRUD;

use DB;
use Illuminate\Database\Eloquent\Model;

trait CrudTrait
{
    /*
    |--------------------------------------------------------------------------
    | Methods for ENUM and SELECT crud fields.
    |--------------------------------------------------------------------------
    */

    public static function getPossibleEnumValues($field_name)
    {
        $instance = new static(); // create an instance of the model to be able to get the table name
        $type = DB::select(DB::raw('SHOW COLUMNS FROM '.$instance->getTable().' WHERE Field = "'.$field_name.'"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = [];
        foreach (explode(',', $matches[1]) as $value) {
            $enum[] = trim($value, "'");
        }

        return $enum;
    }

    public static function isColumnNullable($column_name)
    {
        $instance = new static(); // create an instance of the model to be able to get the table name
        $answer = DB::select(DB::raw("SELECT IS_NULLABLE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$instance->getTable()."' AND COLUMN_NAME='".$column_name."' AND table_schema='".env('DB_DATABASE')."'"))[0];

        return $answer->IS_NULLABLE === 'YES';
    }

    /*
    |--------------------------------------------------------------------------
    | Methods for Fake Fields functionality (used in PageManager).
    |--------------------------------------------------------------------------
    */

    /**
     * Add fake fields as regular attributes, even though they are stored as JSON.
     *
     * @param array $columns - the database columns that contain the JSONs
     */
    public function addFakes($columns = ['extras'])
    {
        foreach ($columns as $key => $column) {
            $column_contents = $this->{$column};

            if (! is_object($this->{$column})) {
                $column_contents = json_decode($this->{$column});
            }

            if (count($column_contents)) {
                foreach ($column_contents as $fake_field_name => $fake_field_value) {
                    $this->setAttribute($fake_field_name, $fake_field_value);
                }
            }
        }
    }

    /**
     * Return the entity with fake fields as attributes.
     *
     * @param array $columns - the database columns that contain the JSONs
     *
     * @return Model
     */
    public function withFakes($columns = [])
    {
        $model = '\\'.get_class($this);

        if (! count($columns)) {
            $columns = (property_exists($model, 'fakeColumns')) ? $this->fakeColumns : ['extras'];
        }

        $this->addFakes($columns);

        return $this;
    }
}
