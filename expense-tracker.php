#!/usr/bin/env php
<?php

require 'ExpenseManager.php';
require 'Validator.php';
require 'CLIHelper.php';
$manager = new ExpenseManager();

// 1. Check for Help
if (count($argv) < 2 || in_array($argv[1], ['--help', '-h', '--h'])) {
    CLIHelper::showHelp();
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

        CLIHelper::printAllExpenses($expenses);
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
