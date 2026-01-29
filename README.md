# Expense Tracker CLI

A simple, robust command-line tool to track, manage, and analyze your personal expenses. Built with native PHP and uses JSON for persistent storage.

## 🚀 Features

* **Add Expenses:** Record new expenses with a description and amount.
* **List Expenses:** View a formatted table of all recorded expenses.
* **Summary:** View your total expenses or filter by a specific month (current year).
* **Delete:** Remove specific expenses by their unique ID.
* **Persistent Storage:** Data is saved locally in a JSON file (`expenses.json`).
* **Strict Validation:** Prevents invalid inputs to keep data clean.

## 🛠️ Requirements

* PHP 7.4 or higher installed on your machine.

## 📦 Installation & Setup

### 1. Clone the Repository
```bash
git clone https://github.com/seddek-nadhem/expense-tracker.git
cd expense-tracker
```

### 2. Run on Windows
  This project includes a expense-tracker.bat file for easy execution.
```bash
expense-tracker list
```

### 3. Run on Mac / Linux
  Mac and Linux use the executable permission instead of a .bat file.

  Step 1: Make the script executable Run this command once inside the project folder:
```bash
chmod +x expense-tracker.php
```

Step 2: Run locally You can now run it using ./:
```bash
./expense-tracker.php list
```

## 📖 Usage Guides

1. Add an Expense
You must provide a description and an amount (in that order).
```bash
expense-tracker add --description "Lunch" --amount 20
```

2. List All Expenses
Shows a table of ID, Date, Description, and Amount.
```bash
expense-tracker list
```

3. View Summary
   a. Total of all time:
```bash
expense-tracker summary
```
   b. Total for a specific month (e.g., August):
```bash
expense-tracker summary --month 8
```

4. Delete an Expense
   Remove an expense using the ID found in the list command.
```bash
expense-tracker delete --id 1
```

## 📂 Project Structure

- `expense-tracker.php` - The main entry point (CLI logic).
- `ExpenseManager.php` - Handles business logic, math, and file operations.
- `Validator.php` - Handles all strict input validation.
- `CLIHelper.php` - Handles output formatting and UI.
- `expenses.json` - The database file (ignored by Git).
- `expense-tracker.bat` - Windows executable wrapper.

## 🛡️ License
- This project is open-source and available under the MIT License.




