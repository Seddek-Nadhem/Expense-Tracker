#!/usr/bin/env php
<?php

require 'ExpenseManager.php';
require 'Validator.php';
$manager = new ExpenseManager();

// 1. Check for Help
if (count($argv) < 2 || in_array($argv[1], ['--help', '-h', '--h'])) {
    showHelp();
    exit(1);
}

switch ($argv[1]) {
    case "add":
        Validator::validateAddArgs($argv);

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
        Validator::validateDeleteArgs($argv);

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

        Validator::validateSummaryArgs($argv);

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