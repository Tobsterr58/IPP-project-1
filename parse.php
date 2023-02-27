<?php
    include_once 'regex.php';
    include_once 'generate.php';

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
    //////////////////// PARSE ////////////////////
    generate_header();

    $header = false;
    $order_counter = 1;
    while ($line = fgets(STDIN)) {
        
        if (strpos($line, "#") !== false) {
            $line = explode("#", $line);
            $line = $line[0];
        }
        
        $line = trim($line);
        $token = preg_split('/\s+/', $line);
        
        if (empty($line)) {
            continue;
        }
        
        
        if ($header === false) {
            if ($line == ".IPPcode23") {
                $header = true;
                generate_program();
            }
            else {
                exit(21);
            }
        } 
        else {
            if ($line == ".IPPcode23") {
                exit(22);
            }
        }
        
        if (count($token) > 4) {
            exit(23);
        }

        switch($token[0] = strtoupper($token[0])) {
            // OPCODE
            case "CREATEFRAME" :
            case "PUSHFRAME" :
            case "POPFRAME" :
            case "RETURN" :
            case "BREAK" :
                check_one(count($token));
                generate_instruction($token[0], $order_counter);
                $order_counter++;
                break;
            // <var>
            case "DEFVAR" :
            case "POPS" :       
                check_two(count($token));
                generate_var($token[0], $token[1], $order_counter);
                $order_counter++;
                break;
            // <label>
            case "CALL" :
            case "LABEL" :
            case "JUMP" :
                check_two(count($token));
                generate_label($token[0], $token[1], $order_counter);
                $order_counter++;
                break;
            // <symb>
            case "PUSHS" :
            case "WRITE" :
            case "EXIT" :
            case "DPRINT" :
                check_two(count($token));
                generate_symb($token[0], $token[1], $order_counter);
                $order_counter++;
                break;
            // <var> <symb>
            case "MOVE" :
            case "INT2CHAR" :
            case "STRLEN" :
            case "TYPE" :
                check_three(count($token));
                generate_var_symb($token[0], $token[1], $token[2], $order_counter);
                $order_counter++;
                break;
            // <var> <type>
            case "READ" :
                check_three(count($token));
                generate_var_type($token[0], $token[1], $token[2], $order_counter);
                $order_counter++;
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
                if($token[0] == "NOT") {
                    check_three(count($token));
                    generate_var_symb($token[0], $token[1], $token[2], $order_counter);
                }
                else {
                    check_four(count($token));
                    generate_var_symb_symb($token[0], $token[1], $token[2], $token[3], $order_counter);
                }
                $order_counter++;
                break;
            // <label> <symb1> <symb2>
            case "JUMPIFEQ" :
            case "JUMPIFNEQ" :
                check_four(count($token));
                generate_label_symb_symb($token[0], $token[1], $token[2], $token[3], $order_counter);
                $order_counter++;
                break;
            case ".IPPCODE23" :
                break;
            default :
                exit(22);
        }

    }
    generate_footer();
    exit(0);
?>