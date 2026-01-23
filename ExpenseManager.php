<?php 

class ExpenseManager {
    private $filePath;

    public function __construct($filePath = 'expenses.json') {
        $this->filePath = $filePath;

        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, '[]');
        }
    }

    public function loadExpenses() {
        $content = file_get_contents($this->filePath);
        $data = json_decode($content, true);

        return is_array($data) ?? [];
    }

    public function saveExpenses(array $data) {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($this->filePath, $json);
    }

}