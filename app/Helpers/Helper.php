<?php


/**
 * This function checks is var is set and not empty or null otherwise return null.
 * @param any $var
 */
function ifEmptyReturnNull($var)
{
    if (empty($var) || is_null($var) || !isset($var)) {
        return null;
    }

    return $var;
}

