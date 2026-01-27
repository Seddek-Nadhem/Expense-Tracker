<?php

class CLIHelper {
    public static function showHelp() {
        echo "Usage: expense-tracker <command> [options]\n\n";
        echo "Commands:\n";
        echo "  add      --description <text> --amount <number>\n";
        echo "  list     View all expenses\n";
        echo "  summary  View total (optional: --month <1-12>)\n";
        echo "  delete   --id <number>\n";
        echo "  update   --id <number> --description <text> --amount <number>\n";
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