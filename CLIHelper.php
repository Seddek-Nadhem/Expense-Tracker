<?php

class CLIHelper {
    public static function showHelp($message = "") {
        if ($message) echo $message . "\n";

        echo "Commands:\n\n";
        echo "  1- add      --description <product name> --amount <product price>\n";
        echo "  2- list     View all expenses\n";
        echo "  3- summary  (sum of all expenses of all the months of the current year)\n";
        echo "  4- summary  --month <month number 1-12> (sum of all expenses for only a month of the current year)\n";
        echo "  5- delete   --id <number>\n";
    }
    public static function printAllExpenses($expenses) {
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
}