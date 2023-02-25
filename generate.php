<?php

require 'regex.php';
function generate_header() {
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
}

function generate_program() {
    echo "<program language=\"IPPcode23\">\n";
}

function generate_footer() {
    echo "</program>\n";
}

function generate_instruction($instruction, $order_counter) {
    echo "\t<instruction order=\"$order_counter\" opcode=\"$instruction\">\n";
    echo "\t</instruction>\n";
    $order_counter++;
}

function generate_var($instruction, $var, $order_counter) {
    if (variable_regex($var)) {
        echo "\t<instruction order=\"$order_counter\" opcode=\"$instruction\">\n";
        echo "\t\t<arg1 type=\"var\">$var</arg1>\n";
        echo "\t</instruction>\n";
        $order_counter++;
    }
    else {
        exit(23);
    }
}

function generate_label($instruction, $label, $order_counter) {
    if (label_regex($label)) {
        echo "\t<instruction order=\"$order_counter\" opcode=\"$instruction\">\n";
        echo "\t\t<arg1 type=\"label\">$label</arg1>\n";
        echo "\t</instruction>\n";
        $order_counter++;
    }
    else {
        exit(23);
    }
}

function generate_symb($instruction, $symb, $order_counter) {
    if (symbol_regex($symb)) {
        echo "\t<instruction order=\"$order_counter\" opcode=\"$instruction\">\n";
        echo "\t\t<arg1 type=\"symb\">$symb</arg1>\n";
        echo "\t</instruction>\n";
        $order_counter++;
    }
    else {
        exit(23);
    }
}

function generate_var_symb($instruction, $var, $symb, $order_counter) {
    if (variable_regex($var) && symbol_regex($symb)) {
        echo "\t<instruction order=\"$order_counter\" opcode=\"$instruction\">\n";
        echo "\t\t<arg1 type=\"var\">$var</arg1>\n";
        echo "\t\t<arg2 type=\"symb\">$symb</arg2>\n";
        echo "\t</instruction>\n";
        $order_counter++;
    }
    else {
        exit(23);
    }
}

function generate_var_type($instruction, $var, $type, $order_counter) {
    if (variable_regex($var) && type_regex($type)) {
        echo "\t<instruction order=\"$order_counter\" opcode=\"$instruction\">\n";
        echo "\t\t<arg1 type=\"var\">$var</arg1>\n";
        echo "\t\t<arg2 type=\"type\">$type</arg2>\n";
        echo "\t</instruction>\n";
        $order_counter++;
    }
    else {
        exit(23);
    }
}




    
?>