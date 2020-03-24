<?php

if (! function_exists('square_brackets_to_dots')) {
    /**
     * Turns a string from bracket-type array to dot-notation array.
     * Ex: array[0][property] turns into array.0.property.
     *
     * @param $path
     *
     * @return string
     */
    function square_brackets_to_dots($string)
    {
        $string = str_replace(['[', ']'], ['.', ''], $string);

        return $string;
    }
}

if (! function_exists('is_countable')) {
    /**
     * We need this because is_countable was only introduced in PHP 7.3,
     * and in PHP 7.2 you should check if count() argument is really countable.
     * This function may be removed in future if PHP >= 7.3 becomes a requirement.
     *
     * @param $obj
     *
     * @return bool
     */
    function is_countable($obj)
    {
        return is_array($obj) || $obj instanceof Countable;
    }
}
