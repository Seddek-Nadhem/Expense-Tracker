#!/usr/bin/env php
<?php

require 'ExpenseManager.php';
$manager = new ExpenseManager();

// 1. Check for Help
if (count($argv) < 2 || in_array($argv[1], ['--help', '-h', '--h'])) {
    showHelp();
    exit(1);
}

switch ($argv[1]) {
    case "add":
        validateAddArgs($argv);

        $description = $argv[3];
        $amount = $argv[5];

        $id = $manager->addExpense($description, $amount);
        echo "Expense added successfully (ID: $id)\n";
        break;
    
    case "list":
        $expenses = $manager->loadExpenses();
        if (empty($expenses)) {
            echo "No expenses recorded yet.\n";
            break;
        }

        printAllExpenses($expenses);
        break;

    case "delete":
        validateDeleteArgs($argv);

        $id = $argv[3];

        $success = $manager->deleteExpense($id);

        if ($success) echo "Expense has been deleted SUCCESSFULLY!\n";
        else echo "Expense has not been found! Please enter the right ID\n";
        break;

    default:
        echo "default\n";
}



function showHelp() {
    echo "Usage: expense-tracker <command> [options]\n\n";
    echo "Commands:\n";
    echo "  add      --description <text> --amount <number>\n";
    echo "  list     View all expenses\n";
    echo "  summary  View total (optional: --month <1-12>)\n";
    echo "  delete   --id <number>\n";
    echo "  update   --id <number> --description <text> --amount <number>\n";
}
function validateAddArgs($argv) {
    // 1. Check count
    if (count($argv) < 6) {
        echo "Error: Missing arguments.\n";
        echo "Usage: expense-tracker add --description \"Item\" --amount 20\n";
        exit(1);
    }

    // 2. Check Description flag
    if ($argv[2] !== "--description") {
        echo "Error: Expected '--description' at position 2 but found '{$argv[2]}'.\n";
        exit(1);
    }

    // 3. Check Amount flag
    if ($argv[4] !== "--amount") {
        echo "Error: Expected '--amount' at position 4 but found '{$argv[4]}'.\n";
        echo "Make sure you put the description first, then the amount.\n";
        exit(1);
    }

    // 4. Check Numeric value
    if (!is_numeric($argv[5])) {
        echo "Error: The amount must be a number (e.g., 20 or 20.50).\n";
        echo "You entered: '{$argv[5]}'\n";
        exit(1);
    }
}
function validateDeleteArgs($argv) {
    if (count($argv) < 4) {
        echo "There's something missing in your command!\n";
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
function printAllExpenses($expenses) {
    // 2. Print the Header Row
    echo str_pad("ID", 5) . str_pad("Date", 12) . str_pad("Description", 20) . "Amount\n";
    echo str_repeat("-", 50) . "\n"; // A separator line

    foreach ($expenses as $expense) {
        echo str_pad($expense['id'], 5);
        echo str_pad($expense['date'], 12);
        echo str_pad($expense['description'], 20);
        echo "$" . $expense['amount'] . "\n";
    }
}