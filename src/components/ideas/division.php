<?php
enum Division: string {
    case AdministrativeAndPlanning = 'Administrative and Planning Division';
    case CustomerServices = 'Customer Services Division';
    case WaterworksPlanningAndEngineering = 'Waterworks Planning and Engineering Division';
    case Operation = 'Operation Division';

    public function getDetailsLink(): string {
        return "./src/components/add_regular_employee.php?division=" . urlencode($this->value);
    }
}
?>