<?php

function variable_regex($var) {
    if (preg_match('/^(GF|LF|TF)@([a-zA-Z]|[_&%$*!?-]+)[a-zA-Z0-9_&%$*!?-]*$/', $var)) {
        return true;
    }
    else {
        return false;
    }
}

function label_regex($label) {
    if (preg_match('/^([a-zA-Z]|[_&%$*!?-]+)[a-zA-Z0-9_&%$*!?-]*$/', $label)) {
        return true;
    }
    else {
        return false;
    }
}

function type_regex($type) {
    if (preg_match('/^(int|string|bool)$/', $type)) {
        return true;
    }
    else {
        return false;
    }
}

function symbol_regex($symbol) {
    if (preg_match('/^(GF|LF|TF)@([a-zA-Z]|[_&%$*!?-])[a-zA-Z0-9]*$/', $symbol)) {
        return "var";
    }
    elseif (preg_match('/^int@([+-]?[0-9]+)$/', $symbol)) {
        return true;
    }
    elseif (preg_match('/^bool@(true|false)$/', $symbol)) {
        return true;
    }
    elseif (preg_match("/^string@(\\\\\d{3}|[^\\x00-\\x20\\x23\\x5C])*$/u", $symbol)) {
        return true;
    }
    elseif (preg_match('/^nil@nil$/', $symbol)) {
        return true;
    }
    else {
        return false;
    }
}

?>