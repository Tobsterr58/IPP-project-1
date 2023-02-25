<?php

function variable_regex($var) {
    return preg_match('/^(GF|LF|TF)@([a-zA-Z]|[_&%$*!?-])[a-zA-Z0-9]*$/', $var);
}

function label_regex($label) {
    return preg_match('/^([a-zA-Z]|[_&%$*!?-])[a-zA-Z0-9]*$/', $label);
}

function type_regex($type) {
    return preg_match('/^(int|string|bool)$/', $type);
}

function symbol_regex($symbol) {
    if (preg_match('/^(GF|LF|TF)@([a-zA-Z]|[_&%$*!?-])[a-zA-Z0-9]*$/', $symbol)) {
        return true;
    }
    elseif (preg_match('/^int@([+-]?[0-9]+)$/', $symbol)) {
        return true;
    }
    elseif (preg_match('/^bool@(true|false)$/', $symbol)) {
        return true;
    }
    elseif (preg_match('/^string@([^\s#\\\\]|(\\\\[0-9]{3}))*$/', $symbol)) {
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