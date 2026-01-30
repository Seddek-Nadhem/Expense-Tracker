#!/usr/bin/env php
<?php

require 'ExpenseManager.php';
require 'Validator.php';
require 'CLIHelper.php';

$manager = new ExpenseManager();

// if no command provided
if (count($argv) < 2) {
    CLIHelper::showHelp("You did not enter a valid command! Feel free to type --help for instructions :D\n");
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

    case "update":
        Validator::validateUpdateArgs($argv);

        $id = $argv[3];
        $newDescription = null;
        $newAmount = null;

        // Check if --description exists in the arguments
        $descIndex = array_search('--description', $argv);
        if ($descIndex !== false) {
            $newDescription = $argv[$descIndex + 1];
        }

        // Check if --amount exists in the arguments
        $amountIndex = array_search('--amount', $argv);
        if ($amountIndex !== false) {
            $newAmount = $argv[$amountIndex + 1];
        }

        $success = $manager->updateExpense($id, $newDescription, $newAmount);

        if ($success) {
            echo "Expense updated successfully.\n";
        } else {
            echo "Error: Expense with ID $id not found.\n";
        }
        break;

    default:
        CLIHelper::showHelp("You did not enter a valid command! Feel free to type --help for instructions :D\n");
}

