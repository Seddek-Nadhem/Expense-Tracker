#!/usr/bin/env php
<?php

require 'ExpenseManager.php';
$manager = new ExpenseManager();

if (count($argv) < 2 || $argv[1] === '--help' || $argv[1] === '--h') {
    echo "Usage: expense-tracker <command> [options]\n\n";
    echo "Commands:\n";
    echo "  add      --description <text> --amount <number>\n";
    echo "  list     View all expenses\n";
    echo "  summary  View total (optional: --month <1-12>)\n";
    echo "  delete   --id <number>\n";
    echo "  update   --id <number> --description <text> --amount <number>\n";
    exit(1); 
}

switch ($argv[1]) {
    case "add":
        // 1. Check if enough arguments exist (script + command + desc_flag + desc + amt_flag + amt = 6)
        if (count($argv) < 6) {
            echo "Error: Missing arguments.\n";
            echo "Usage: expense-tracker add --description \"Item\" --amount 20\n";
            exit(1);
        }

        // 2. Check if the first flag is strictly '--description'
        if ($argv[2] !== "--description") {
            echo "Error: Expected '--description' but found '{$argv[2]}'.\n";
            exit(1);
        }

        // 3. Check if the second flag is strictly '--amount'
        if ($argv[4] !== "--amount") {
            echo "Error: Expected '--amount' but found '{$argv[4]}'.\n";
            echo "Make sure you put the description first, then the amount.\n";
            exit(1);
        }

        // 4. Check if the value provided for amount is actually a number
        if (!is_numeric($argv[5])) {
            echo "Error: The amount must be a number (e.g., 20 or 20.50).\n";
            echo "You entered: '{$argv[5]}'\n";
            exit(1);
        }

        $description = $argv[3];
        $amount = $argv[5];

        $id = $manager->addExpense($description, $amount);
        echo "Expense added successfully (ID: $id)\n";
        break;

        
}