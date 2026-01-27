<?php 

class ExpenseManager {
    private $filePath;

    public function __construct($filePath = 'expenses.json') {
        $this->filePath = $filePath;

        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, '[]');
        }
    }
    public function hasExpense($id) {
        $expenses = $this->loadExpenses();

        foreach($expenses as $expense) {
            if ($expense['id'] == $id) return true;
        }

        return false;
    }
    public function loadExpenses() {
        $content = file_get_contents($this->filePath);
        $data = json_decode($content, true);

        return is_array($data) ? $data : [];
    }
    public function saveExpenses(array $data) {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($this->filePath, $json);
    }
    public function addExpense($description, $amount) {
        $expenses = $this->loadExpenses();

        $newId = 1;
        if (!empty($expenses)) {
            $lastExpense = end($expenses);
            $newId = $lastExpense['id'] + 1;
        }

        $newExpense = [
            'id' => $newId,
            'date' => date('Y-m-d'),
            'description' => $description,
            'amount' => $amount
        ];

        $expenses[] = $newExpense;

        $this->saveExpenses($expenses);

        return $newId;
    }
    public function deleteExpense($id) {
        $expenses = $this->loadExpenses();
        $newExpenses = [];

        foreach($expenses as $expense) {
            if ($expense['id'] == $id) continue;
            else $newExpenses[] = $expense;
        }

        if (count($expenses) === count($newExpenses)) return false;

        $this->saveExpenses($newExpenses);
        
        return true;
    }
    public function updateExpense($id, $description, $amount) {
        $expenses = $this->loadExpenses();

        foreach($expenses as &$expense) {
            if($expense['id'] == $id) {
                $expense['description'] = $description;
                $expense['amount'] = $amount;
                $expense['date'] = date('Y-m-d');
                
                $this->saveExpenses($expenses);

                return true;
            }
        }

        return false;
    }
    public function getAllExpenses() {
        return $this->loadExpenses();
    }
}