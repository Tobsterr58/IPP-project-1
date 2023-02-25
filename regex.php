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



?>