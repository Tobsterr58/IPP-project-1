<?php
    require 'regex.php';
    ini_set('display_errors', 'stderr');

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

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    $header = false;
    while ($line = fgets(STDIN)) {
        if ($header = false) {
            if ($line == ".IPPcode23") {
                $header = true;
            }
            else {
                exit(21);
            }
        }
        //TODO komentar dat prec
        $token = explode(' ', trim($line, "\n"));
        
        switch(strtoupper($token[0])) {
            case "MOVE" :
            case "CREATEFRAME" :
            case "PUSHFRAME" :
            case "POPFRAME" :
            case "DEFVAR" :
                if (variable_regex($token[1])) {
                    echo "<instruction order=\"order\" opcode=\"$token[0]\">\n";
                }
                else {
                    exit(23);
                }
                break;
            case "CALL" :
            case "RETURN" :
            case "PUSHS" :
            case "POPS" :
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
            case "INT2CHAR" :
            case "STRI2INT" :
            case "READ" :
            case "WRITE" :
            case "CONCAT" :
            case "STRLEN" :
            case "GETCHAR" :
            case "SETCHAR" :
            case "TYPE" :
            case "LABEL" :
            case "JUMP" :
            case "JUMPIFEQ" :
            case "JUMPIFNEQ" :
            case "EXIT" :
            case "DPRINT" :
            case "BREAK" :
                break;

        }

    }
?>
