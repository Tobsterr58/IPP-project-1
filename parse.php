<?php
    require 'regex.php';
    require 'generate.php';

    ini_set('display_errors', 'stderr');

    //////////////////// ARGUMENTS ////////////////////
    if ($argc == 2) {
        if ($argv[1] == "--help") {
            echo "Usage: php parse.php [file] [options]" . PHP_EOL;
            exit(0);
        }
        else {
            exit(10);
        }
    }
    elseif ($argc > 2) {
        exit(10);
    }

    function delete_comment($line) {
        $comment = strpos($line, '#');
        if ($comment !== false) {
            $line = substr($line, 0, $comment);
        }
        return $line;
    }

    //////////////////// PARSE ////////////////////
    generate_header();

    $header = false;
    while ($line = fgets(STDIN)) {
        if ($header = false) {
            if ($line == ".IPPcode23") {
                $header = true;
                generate_program();
            }
            else {
                exit(21);
            }
        }
        $token = explode(' ', trim($line, "\n"));
        delete_comments($token);
        
        $order_counter = 1;
        switch(strtoupper($token[0])) {
            // OPCODE
            case "CREATEFRAME" :
            case "PUSHFRAME" :
            case "POPFRAME" :
            case "RETURN" :
            case "BREAK" :
                generate_instruction($token[0], $order_counter);
                break;
            // <var>
            case "DEFVAR" :
            case "POPS" :
                generate_var($token[0], $token[1], $order_counter);
                break;
            // <label>
            case "CALL" :
            case "LABEL" :
            case "JUMP" :
                generate_label($token[0], $token[1], $order_counter);
                break;
            // <symb>
            case "PUSHS" :
            case "WRITE" :
            case "EXIT" :
            case "DPRINT" :
                generate_symb($token[0], $token[1], $order_counter);
                break;
            // <var> <symb>
            case "MOVE" :
            case "INT2CHAR" :
            case "STRLEN" :
            case "TYPE" :
                generate_var_symb($token[0], $token[1], $token[2], $order_counter);
                break;
            // <var> <type>
            case "READ" :
                generate_var_type($token[0], $token[1], $token[2], $order_counter);
                break;
            // <var> <symb1> <symb2>
            case "ADD" :
            case "SUB" :
            case "MUL" :
            case "IDIV" :
            case "LT" :
            case "GT" :
            case "EQ" :
            case "AND" :
            case "OR" :
            case "NOT" :
            case "STRI2INT" :
            case "CONCAT" :
            case "GETCHAR" :
            case "SETCHAR" :
                generate_var_symb_symb($token[0], $token[1], $token[2], $token[3], $order_counter);
                break;
            // <label> <symb1> <symb2>
            case "JUMPIFEQ" :
            case "JUMPIFNEQ" :
                generate_label_symb_symb($token[0], $token[1], $token[2], $token[3], $order_counter);
                break;
            default :
                exit(22);
        }

    }
    generate_footer();
?>