<?php

class Validator {
    public static function validateAddArgs($argv) {
        
        if (count($argv) < 6) {
            echo "Error: Missing arguments.\n";
            echo "Usage: add --description <product name> --amount <product price>\n";
            exit(1);
        }

        if (count($argv) > 6) {
            echo "You entered arguments more than needed!\n";
            echo "Usage: add --description <product name> --amount <product price>\n";
            exit(1);
        }

        if ($argv[2] !== "--description") {
            echo "Error: Expected '--description' at position 2 but found '{$argv[2]}'.\n";
            echo "Usage: add --description <product name> --amount <product price>\n";
            exit(1);
        }

        if ($argv[4] !== "--amount") {
            echo "Error: Expected '--amount' at position 4 but found '{$argv[4]}'.\n";
            echo "Usage: add --description <product name> --amount <product price>\n";
            exit(1);
        }

        if (!is_numeric($argv[5])) {
            echo "Error: The amount must be a number (e.g., 20 or 20.50).\n";
            echo "Usage: add --description <product name> --amount <product price>\n";
            exit(1);
        }
    }
    public static function validateDeleteArgs($argv) {
        if (count($argv) < 4) {
            echo "You have to write the ID!\n";
            echo "Usage: delete --id <id>\n";
            exit(1);
        }

        if (count($argv) > 4) {
            echo "You entered arguments more than needed!\n";
            echo "Usage: delete --id <id>\n";
            exit(1);
        }

        if ($argv[2] !== '--id') {
            echo "Error: Expected '--id' but found '{$argv[2]}'.\n";
            echo "Usage: delete --id <id>\n";
            exit(1);
        }

        if (!is_numeric($argv[3])) {
            echo "The ID you entered is not a number. Please enter the correct ID!\n";
            echo "Usage: delete --id <id>\n";
            exit(1);
        }
    }
    public static function validateSummaryArgs($argv) {
        if (count($argv) < 4) {
            echo "Too few inputs!\n";
            echo "Usage: summary --month 8\n";
            exit(1);
        }

        if (count($argv) > 4) {
            echo "Too many arguments!\n";
            echo "Usage: summary --month 8\n";
            exit(1);
        }

        if (is_numeric($argv[2]) || $argv[2] != "--month") {
            echo "Invalid input!\n";
            echo "Usage: summary --month 8\n";
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