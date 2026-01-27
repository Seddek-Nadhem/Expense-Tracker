<?php

class Validator {
    public static function validateAddArgs($argv) {
        
        if (count($argv) < 6) {
            echo "Error: Missing arguments.\n";
            echo "Usage: expense-tracker add --description \"Item\" --amount 20\n";
            exit(1);
        }

        if (count($argv) > 6) {
            echo "You entered arguments more than needed!\n";
            echo "Usage: expense-tracker add --description \"Item\" --amount 20\n";
            exit(1);
        }

        if ($argv[2] !== "--description") {
            echo "Error: Expected '--description' at position 2 but found '{$argv[2]}'.\n";
            exit(1);
        }

        if ($argv[4] !== "--amount") {
            echo "Error: Expected '--amount' at position 4 but found '{$argv[4]}'.\n";
            echo "Make sure you put the description first, then the amount.\n";
            exit(1);
        }

        if (!is_numeric($argv[5])) {
            echo "Error: The amount must be a number (e.g., 20 or 20.50).\n";
            echo "You entered: '{$argv[5]}'\n";
            exit(1);
        }
    }
    public static function validateDeleteArgs($argv) {
        if (count($argv) < 4) {
            echo "There's something missing in your command!\n";
            echo "It has to be like this: expense-tracker delete --id <id>\n";
            exit(1);
        }

        if (count($argv) > 4) {
            echo "You entered arguments more than needed!\n";
            echo "It has to be like this: expense-tracker delete --id <id>\n";
            exit(1);
        }

        if ($argv[2] !== '--id') {
            echo "Error: Expected '--id' but found '{$argv[2]}'.\n";
            exit(1);
        }

        if (!is_numeric($argv[3])) {
            echo "The ID you entered is not a number. Please enter the correct ID!\n";
            exit(1);
        }
    }
    public static function validateSummaryArgs($argv) {
        if (count($argv) < 4) {
            echo "You didn't enter enough arguments!\n";
            echo "It has to be like this: expense-tracker summary OR like this: expense-tracker summary --month 8\n";
            exit(1);
        }

        if (count($argv) > 4) {
            echo "You entered arguments more than needed!\n";
            echo "It has to be like this: expense-tracker summary OR like this: expense-tracker summary --month 8\n";
            exit(1);
        }

        if (is_numeric($argv[2]) || $argv[2] != "--month") {
            echo "Review your input please!\n";
            echo "It has to be like this: expense-tracker summary --month 8\n";
            exit(1);
        }

        if (!is_numeric($argv[3])) {
            echo "The month should be a number from 1-12!\n";
            exit(1);
        }

        if ($argv[3] > 12 || $argv[3] < 1) {
            echo "The month should be a number from 1-12!\n";
            exit(1);
        }
    }

}