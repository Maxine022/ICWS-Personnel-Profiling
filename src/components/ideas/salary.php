<?php

enum Salary: string {
    case Step1 = 'Step 1';
    case Step2 = 'Step 2';
    case Step3 = 'Step 3';
    case Step4 = 'Step 4';
    case Step5 = 'Step 5';

    public function getSalaryDetails(int $salaryGrade): array {
        $salaryData = [
            1 => [15000, 15500, 16000, 16500, 17000],
            2 => [18000, 18500, 19000, 19500, 20000],
            3 => [21000, 21500, 22000, 22500, 23000],
            4 => [24000, 24500, 25000, 25500, 26000],
            5 => [27000, 27500, 28000, 28500, 29000],
            6 => [30000, 30500, 31000, 31500, 32000],
            // Add more salary grades as per CSC standards
        ];

        return [
            'step' => $this->value,
            'salary' => $salaryData[$salaryGrade][$this->getStepIndex()],
        ];
    }

    private function getStepIndex(): int {
        return match ($this) {
            self::Step1 => 0,
            self::Step2 => 1,
            self::Step3 => 2,
            self::Step4 => 3,
            self::Step5 => 4,
        };
    }
}