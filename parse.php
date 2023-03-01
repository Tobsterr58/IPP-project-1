<?php
    include_once 'generate.php';

    ini_set('display_errors', 'stderr'); //set error output to STDERR

    //////////////////// ARGUMENTS ////////////////////
    if ($argc == 2) {
        if ($argv[1] == "--help") { 
            echo "Usage: php parse.php [file] [options]" . PHP_EOL; //print help
            exit(0);
        }
        else {
            exit(10);
        }
    }
    elseif ($argc > 2) {
        exit(10);
    }
    //////////////////// PARSER ////////////////////
    generate_header(); //generate header of XML file

    $header = false; //check if there is header (setted to false by default)
    $order_counter = 1; //counter for order of instructions
    while ($line = fgets(STDIN)) { //read line by line from STDIN
        
        if (strpos($line, "#") !== false) { //remove comments
            $line = explode("#", $line);
            $line = $line[0];
        }
        
        $line = trim($line);
        $token = preg_split('/\s+/', $line); //split line by whitespaces
        
        if (empty($line)) { //skip empty lines
            continue;
        }
        
        
        if ($header === false) {
            if ($line == ".IPPcode23") { //set header to true if there is header
                $header = true; 
                generate_program(); //generate program tag
            }
            else {
                exit(21);
            }
        } 
        else {
            if ($line == ".IPPcode23") { //check if there is more than one header
                exit(22);
            }
        }
        
        if (count($token) > 4) { //check if there are more than 4 arguments
            exit(23);
        }

        switch($token[0] = strtoupper($token[0])) { //convert to uppercase and switch
            // OPCODE
            case "CREATEFRAME" :
            case "PUSHFRAME" :
            case "POPFRAME" :
            case "RETURN" :
            case "BREAK" :
                check_one(count($token)); //check if there is only one argument
                generate_instruction($token[0], $order_counter); //generate instruction tag
                $order_counter++;
                break;
            // <var>
            case "DEFVAR" :
            case "POPS" :       
                check_two(count($token)); //check if there are only two arguments
                generate_var($token[0], $token[1], $order_counter); //generate var tag
                $order_counter++;
                break;
            // <label>
            case "CALL" :
            case "LABEL" :
            case "JUMP" :
                check_two(count($token));
                generate_label($token[0], $token[1], $order_counter); //generate label tag
                $order_counter++;
                break;
            // <symb>
            case "PUSHS" :
            case "WRITE" :
            case "EXIT" :
            case "DPRINT" :
                check_two(count($token));
                generate_symb($token[0], $token[1], $order_counter); //generate symb tag
                $order_counter++;
                break;
            // <var> <symb>
            case "MOVE" :
            case "INT2CHAR" :
            case "STRLEN" :
            case "TYPE" :
                check_three(count($token)); //check if there are only three arguments
                generate_var_symb($token[0], $token[1], $token[2], $order_counter); //generate var and symb tag
                $order_counter++;
                break;
            // <var> <type>
            case "READ" :
                check_three(count($token));
                generate_var_type($token[0], $token[1], $token[2], $order_counter); //generate var and type tag
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
                if($token[0] == "NOT") { //if token is NOT, generate only two arguments after it
                    check_three(count($token));
                    generate_var_symb($token[0], $token[1], $token[2], $order_counter); //generate var and symb tag
                }
                else { //else generate three arguments
                    check_four(count($token));
                    generate_var_symb_symb($token[0], $token[1], $token[2], $token[3], $order_counter); //generate var, symb1 and symb2 tag
                }
                $order_counter++;
                break;
            // <label> <symb1> <symb2>
            case "JUMPIFEQ" :
            case "JUMPIFNEQ" :
                check_four(count($token));
                generate_label_symb_symb($token[0], $token[1], $token[2], $token[3], $order_counter); //generate label, symb1 and symb2 tag
                $order_counter++;
                break;
            case ".IPPCODE23" :
                break;
            default :
                exit(22);
        }

    }
    generate_footer(); //generate footer of XML file
    exit(0);
?>