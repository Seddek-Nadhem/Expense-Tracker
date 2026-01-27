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
            exit(1);
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

    case "summary":
        if (count($argv) < 3) {
            getSummaryOfAllMonths($manager);
            exit(0);
        }

        validateSummaryArgs($argv);

        $month = $argv[3];
        $summary = getSummaryOfOneMonth($manager, $month);

        if ($summary == 0) {
            echo "There are no expenses for this month!\n";
            exit(0);
        } else {
            echo "The summary of the month you entered is: \${$summary}\n";
        }

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

    if (count($argv) > 6) {
        echo "You entered arguments more than needed!\n";
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
function validateSummaryArgs($argv) {
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
function getSummaryOfOneMonth($manager, $month) {
    $expenses = $manager->loadExpenses();
    $summary = 0;
    $currentYear = date('Y');

    foreach($expenses as $expense) {
        $timestamp = strtotime($expense['date']);
        // 1. strtotime converts "2026-01-24" into a timestamp
        // 2. date('n') extracts the month number without leading zeros (1 to 12)
        $expenseMonth = date('n', $timestamp);
        $expenseYear = date('Y', $timestamp);

        if ((int)$expenseMonth === (int)$month && (int)$expenseYear === (int)$currentYear) {
            $summary += $expense['amount'];
        }
    }

    return $summary;
}
function getSummaryOfAllMonths($manager) {
    $expenses = $manager->loadExpenses();

    if (empty($expenses)) {
        echo "There're no expenses!\n";
        exit(1);
    }

    $summary = 0;
    foreach($expenses as $expense) {
        $summary += $expense['amount'];
    }

    echo "Total expenses: \${$summary}\n";
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