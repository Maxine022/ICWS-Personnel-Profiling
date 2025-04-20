<?php
enum Position: string {
    case Manager = 'Manager';
    case Developer = 'Developer';
    case Designer = 'Designer';
    case Tester = 'Tester';
    case HR = 'HR';

    public function getDetailsLink(): string {
        return "./src/components/add_regular_employee.php?position=" . $this->value;
    }
}
?>
