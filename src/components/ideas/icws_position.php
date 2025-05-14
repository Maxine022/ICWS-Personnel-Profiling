<?php

enum Division: string {
    case ADMINISTRATIVE_AND_PLANNING = 'Administrative and Planning Division';
    case CUSTOMER_SERVICES = 'Customer Services Division';
    case WATERWORKS_PLANNING_AND_ENGINEERING = 'Waterworks Planning and Engineering Division';
    case OPERATION = 'Operation Division';

    public function isEnabledForSection(Section $section): bool {
        return match ($this) {
            self::ADMINISTRATIVE_AND_PLANNING => in_array($section, [
                Section::ADMINISTRATIVE,
                Section::REVENUE_STRATEGY_AND_FORECASTING,
                Section::MIS_SUPPORT,
            ]),
            self::CUSTOMER_SERVICES => in_array($section, [
                Section::APPLICATION,
                Section::METERING,
                Section::BILLING,
                Section::CUSTOMER_RELATIONS,
            ]),
            self::WATERWORKS_PLANNING_AND_ENGINEERING => in_array($section, [
                Section::WATERWORKS_PLANNING,
                Section::CONSTRUCTION,
            ]),
            self::OPERATION => in_array($section, [
                Section::PRODUCTION,
                Section::DISTRIBUTION,
                Section::WATER_QUALITY_CONTROL,
                Section::REPAIRS_AND_MOTORPOOL,
            ]),
        };
    }
}

enum Section: string {
    case ADMINISTRATIVE = 'Administrative Section';
    case REVENUE_STRATEGY_AND_FORECASTING = 'Revenue Strategy and Forecasting';
    case MIS_SUPPORT = 'Management Information System (MIS) Support';
    case APPLICATION = 'Application Section';
    case METERING = 'Metering Section';
    case BILLING = 'Billing Section';
    case CUSTOMER_RELATIONS = 'Customer Relations Section';
    case WATERWORKS_PLANNING = 'Waterworks Planning Section';
    case CONSTRUCTION = 'Construction Section';
    case PRODUCTION = 'Production Section';
    case DISTRIBUTION = 'Distribution Section';
    case WATER_QUALITY_CONTROL = 'Water Quality Control Section';
    case REPAIRS_AND_MOTORPOOL = 'Repairs and Motorpool Section';

    public function isEnabledForUnit(Unit $unit): bool {
        return match ($this) {
            self::ADMINISTRATIVE => in_array($unit, [
                Unit::HUMAN_RESOURCES_AND_PAYROLL,
                Unit::GENERAL_SERVICES,
                Unit::COMMUNICATION_RECORDS_DOCUMENTATION,
                Unit::WAREHOUSE,
            ]),
            self::REVENUE_STRATEGY_AND_FORECASTING => in_array($unit, [
                Unit::STRATEGY_AND_FORECASTING,
                Unit::BUDGET_AND_FINANCE,
                Unit::POLICY_STATISTICS_ANALYTICAL,
            ]),
            self::MIS_SUPPORT => in_array($unit, [
                Unit::IT_SUPPORT_AND_AUTOMATION,
                Unit::DATA_MANAGEMENT,
                Unit::GIS,
            ]),
            self::APPLICATION => in_array($unit, [
                Unit::APPLICATION_PROCESSING,
                Unit::INSPECTION_AND_INVESTIGATION,
            ]),
            self::METERING => in_array($unit, [
                Unit::METER_READING,
                Unit::METER_CALIBRATION,
            ]),
            self::BILLING => in_array($unit, [
                Unit::BILLING_DISTRIBUTION,
                Unit::OVERDUE_ACCOUNTS_MANAGEMENT,
            ]),
            self::CUSTOMER_RELATIONS => in_array($unit, [
                Unit::INFORMATION_EDUCATION_COMMUNICATION,
                Unit::FEEDBACK_COMPLAINTS_MANAGEMENT,
            ]),
            self::WATERWORKS_PLANNING => in_array($unit, [
                Unit::SURVEY_DEVELOPMENT,
                Unit::SYSTEMS_PROGRAM_DESIGN,
            ]),
            self::CONSTRUCTION => in_array($unit, [
                Unit::PROJECT_MANAGEMENT,
                Unit::PROJECT_IMPLEMENTATION,
            ]),
            self::PRODUCTION => in_array($unit, [
                Unit::WATER_SOURCE_MANAGEMENT,
                Unit::WATER_PRESSURE_MANAGEMENT,
            ]),
            self::DISTRIBUTION => in_array($unit, [
                Unit::CONNECTION_MANAGEMENT,
                Unit::PIPELINE_MANAGEMENT,
                Unit::LEAK_DETECTION,
            ]),
            self::WATER_QUALITY_CONTROL => in_array($unit, [
                Unit::LABORATORY,
                Unit::WATER_TREATMENT,
            ]),
            self::REPAIRS_AND_MOTORPOOL => in_array($unit, [
                Unit::FABRICATION_MACHINE_SHOP,
                Unit::VEHICLE_MAINTENANCE,
                Unit::ELECTRICAL,
            ]),
            default => false,
        };
    }
}

enum Unit: string {
    case HUMAN_RESOURCES_AND_PAYROLL = 'Human Resources and Payroll Support';
    case GENERAL_SERVICES = 'General Services Unit';
    case COMMUNICATION_RECORDS_DOCUMENTATION = 'Communication, Records and Documentation';
    case WAREHOUSE = 'Warehouse Unit';
    case STRATEGY_AND_FORECASTING = 'Strategy and Forecasting Unit';
    case BUDGET_AND_FINANCE = 'Budget and Finance Unit';
    case POLICY_STATISTICS_ANALYTICAL = 'Policy, Statistics and Analytical Unit';
    case IT_SUPPORT_AND_AUTOMATION = 'IT Support and Automation Unit';
    case DATA_MANAGEMENT = 'Data Management Unit';
    case GIS = 'GIS Unit';
    case APPLICATION_PROCESSING = 'Application Processing Unit';
    case INSPECTION_AND_INVESTIGATION = 'Inspection and Investigation Unit';
    case METER_READING = 'Meter Reading Unit';
    case METER_CALIBRATION = 'Meter Calibration Unit';
    case BILLING_DISTRIBUTION = 'Billing Distribution Unit';
    case OVERDUE_ACCOUNTS_MANAGEMENT = 'Overdue Accounts Management Unit';
    case INFORMATION_EDUCATION_COMMUNICATION = 'Information, Education and Communication Unit';
    case FEEDBACK_COMPLAINTS_MANAGEMENT = 'Feedback and Complaints Management Unit';
    case SURVEY_DEVELOPMENT = 'Survey Development Unit';
    case SYSTEMS_PROGRAM_DESIGN = 'Systems and Program Design Unit';
    case PROJECT_MANAGEMENT = 'Project Management Unit';
    case PROJECT_IMPLEMENTATION = 'Project Implementation Unit';
    case WATER_SOURCE_MANAGEMENT = 'Water Source Management Unit';
    case WATER_PRESSURE_MANAGEMENT = 'Water Pressure Management Unit';
    case CONNECTION_MANAGEMENT = 'Connection Management Unit';
    case PIPELINE_MANAGEMENT = 'Pipeline Management Unit';
    case LEAK_DETECTION = 'Leak Detection Unit';
    case LABORATORY = 'Laboratory Unit';
    case WATER_TREATMENT = 'Water Treatment Unit';
    case FABRICATION_MACHINE_SHOP = 'Fabrication and Machine Shop Unit';
    case VEHICLE_MAINTENANCE = 'Vehicle Maintenance Unit';
    case ELECTRICAL = 'Electrical Unit';

    public function isEnabledForTeam(Team $team): bool {
        return match ($this) {
            self::CONNECTION_MANAGEMENT => in_array($team, [
                Team::INSTALLATION,
                Team::DISCONNECTION,
                Team::INVESTIGATION,
            ]),
            self::PIPELINE_MANAGEMENT => in_array($team, [
                Team::WELL_DRILLING,
                Team::LEAK_REPAIR,
            ]),
            default => false,
        };
    }

    public function isEnabledForOperator(Operator $operator): bool {
        return match ($this) {
            self::WATER_QUALITY_CONTROL => in_array($operator, [
                Operator::PUMP,
                Operator::VALVE,
                Operator::WATERSHED,
            ]),
            default => false,
        };
    }
}

enum Team: string {
    case INSTALLATION = 'Installation Team';
    case DISCONNECTION = 'Disconnection Team';
    case INVESTIGATION = 'Investigation Team';
    case WELL_DRILLING = 'Well Drilling Team';
    case LEAK_REPAIR = 'Leak Repair Team';
}

enum Operator: string {
    case PUMP = 'Pump Operators';
    case VALVE = 'Valve Operators';
    case WATERSHED = 'Watershed Operators';
}

// Example usage
$division = Division::ADMINISTRATIVE_AND_PLANNING;
$section = Section::ADMINISTRATIVE;

if ($division->isEnabledForSection($section)) {
    echo "The section is enabled for this division.";
} else {
    echo "The section is not enabled for this division.";
}
