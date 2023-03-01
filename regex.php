<?php

function variable_regex($var) {
    if (preg_match('/^(GF|LF|TF)@([a-zA-Z]|[_&%$*!?-]+)[a-zA-Z0-9_&%$*!?-]*$/', $var)) { //regex for var
        return true;
    }
    else {
        return false;
    }
}

function label_regex($label) {
    if (preg_match('/^([a-zA-Z]|[_&%$*!?-]+)[a-zA-Z0-9_&%$*!?-]*$/', $label)) { //regex for label
        return true;
    }
    else {
        return false;
    }
}

function type_regex($type) {
    if (preg_match('/^(int|string|bool)$/', $type)) { //regex for type
        return true;
    }
    else {
        return false;
    }
}

function symbol_regex($symbol) {
    if (preg_match('/^(GF|LF|TF)@([a-zA-Z]|[_&%$*!?-])[a-zA-Z0-9]*$/', $symbol)) { //regex for var in symbol
        return "var"; //return var if symbol is var
    }
    elseif (preg_match('/^int@([+-]?[0-9]+)$/', $symbol)) { //regex for int
        return true;
    }
    elseif (preg_match('/^bool@(true|false)$/', $symbol)) { //regex for bool
        return true;
    }
    elseif (preg_match("/^string@(\\\\\d{3}|[^\\x00-\\x20\\x23\\x5C])*$/u", $symbol)) { //regex for string
        return true;
    }
    elseif (preg_match('/^nil@nil$/', $symbol)) { //regex for nil
        return true;
    }
    else {
        return false; //if symbol is not in any of the above regexes return false
    }
}

?>