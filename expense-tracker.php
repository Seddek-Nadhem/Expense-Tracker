#!/usr/bin/env php
<?php

require 'ExpenseManager.php';
require 'Validator.php';
require 'CLIHelper.php';
$manager = new ExpenseManager();

// if no command provided
if (count($argv) < 2) {
    CLIHelper::showHelp("You did not enter a command! Feel free to type --help for instructions :D\n\n");
    exit(1);
}
//if asked for help
if (in_array($argv[1], ['--help', '-h', '--h'])) {
    CLIHelper::showHelp();
    exit(0);
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
            $manager->getSummaryOfAllMonths($manager);
            exit(0);
        }

        Validator::validateSummaryArgs($argv);

        $month = $argv[3];
        $summary = $manager->getSummaryOfOneMonth($manager, $month);

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

