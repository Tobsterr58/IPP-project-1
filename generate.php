<?php

include_once 'regex.php';

///////////CHECK ARGUMENTS////////////

function check_one ($arguments) {
    if ( $arguments == 1) {
        return true;
    }
    else {
        exit(23);
    }
}

function check_two ($arguments) {
    if ( $arguments == 2) {
        return true;
    }
    else {
        exit(23);
    }
}

function check_three ($arguments) {
    if ( $arguments == 3) {
        return true;
    }
    else {
        exit(23);
    }
}

function check_four ($arguments) {
    if ( $arguments == 4) {
        return true;
    }
    else {
        exit(23);
    }
}
/////////// SYMB TO VAR OR TYPE /////

function symb_to ($symb, $arg_counter) {
    if (symbol_regex($symb)==="var") {
        echo "\t\t<arg$arg_counter type=\"var\">$symb</arg$arg_counter>\n";
    }
    else {
        $symb = explode ("@", $symb);
        echo "\t\t<arg$arg_counter type=\"$symb[0]\">".strtr($symb[1], ["<" => "&lt;", ">" => "&gt;", "&" => "&amp;"])."</arg$arg_counter>\n";
    }
}

///////////GENERATE XML////////////

function generate_header() {
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
}

function generate_program() {
    echo "<program language=\"IPPcode23\">\n";
}

function generate_footer() {
    echo "</program>\n";
    echo "\n";
}

function generate_instruction($instruction, $order_counter) {
    echo "\t<instruction order=\"$order_counter\" opcode=\"$instruction\">\n";
    echo "\t</instruction>\n";
}

function generate_var($instruction, $var, $order_counter) {
    if (variable_regex($var)) {
        echo "\t<instruction order=\"$order_counter\" opcode=\"$instruction\">\n";
        echo "\t\t<arg1 type=\"var\">".strtr($var, ["<" => "&lt;", ">" => "&gt;", "&" => "&amp;"])."</arg1>\n";
        echo "\t</instruction>\n";
    }
    else {
        exit(23);
    }
}

function generate_label($instruction, $label, $order_counter) {
    if (label_regex($label)) {
        echo "\t<instruction order=\"$order_counter\" opcode=\"$instruction\">\n";
        echo "\t\t<arg1 type=\"label\">".strtr($label, ["&" => "&amp;"])."</arg1>\n";
        echo "\t</instruction>\n";
    }
    else {
        exit(23);
    }
}

function generate_symb($instruction, $symb, $order_counter) {
    if (symbol_regex($symb)!==false) {
        echo "\t<instruction order=\"$order_counter\" opcode=\"$instruction\">\n";
        symb_to($symb, 1);
        echo "\t</instruction>\n";
    }
    else {
        exit(23);
    }
}

function generate_var_symb($instruction, $var, $symb, $order_counter) {
    if (variable_regex($var) && symbol_regex($symb)) {
        echo "\t<instruction order=\"$order_counter\" opcode=\"$instruction\">\n";
        echo "\t\t<arg1 type=\"var\">$var</arg1>\n";
        symb_to($symb, 2);
        echo "\t</instruction>\n";
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
    }
    else {
        exit(23);
    }
}

function generate_var_symb_symb($instruction, $var, $symb1, $symb2, $order_counter) {
    if (variable_regex($var) && symbol_regex($symb1) && symbol_regex($symb2)) {
        echo "\t<instruction order=\"$order_counter\" opcode=\"$instruction\">\n";
        echo "\t\t<arg1 type=\"var\">$var</arg1>\n";
        symb_to($symb1, 2);
        symb_to($symb2, 3);
        echo "\t</instruction>\n";
    }
    else {
        exit(23);
    }
}

function generate_label_symb_symb($instruction, $label, $symb1, $symb2, $order_counter) {
    if (label_regex($label) && symbol_regex($symb1) && symbol_regex($symb2)) {
        echo "\t<instruction order=\"$order_counter\" opcode=\"$instruction\">\n";
        echo "\t\t<arg1 type=\"label\">$label</arg1>\n";
        symb_to($symb1, 2);
        symb_to($symb2, 3);
        echo "\t</instruction>\n";
    }
    else {
        exit(23);
    }
}
  
?>