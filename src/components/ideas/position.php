<?php
enum Position: string {
    case AccountingClerkII = 'ACCOUNTING CLERK II';
    case AccountingClerkIII = 'ACCOUNTING CLERK III';
    case AdminAideIIIPlumberI = 'ADMIN AIDE III (PLUMBER I)';
    case AdminAideVPlumberII = 'ADMIN AIDE V / PLUMBER II';
    case AdminAideVPlumberIIAlt = 'ADMIN AIDE V (PLUMBER II)';
    case AdminAideVIElectrician = 'ADMIN AIDE VI (ELECTRICIAN)';
    case AdminAssistantIII = 'ADMINISTRATIVE ASSISTANT III';
    case AdminAssistantIV = 'ADMINISTRATIVE ASSISTANT IV';
    case AdminAssistantV = 'ADMINISTRATIVE ASSISTANT V';
    case AdminAssistantVI = 'ADMINISTRATIVE ASSISTANT VI';
    case AdminAssistantVAlt = 'ADMINISTRATIVE ASSISTANT V';
    case AdminAssistantIVAlt = 'ADMINISTRATIVE ASSISTANT IV';
    case EngineerI = 'ENGINEER I';
    case EngineerIII = 'ENGINEER III';
    case EngineerIV = 'ENGINEER IV';
    case EngineerIIIStep2 = 'ENGINEER III ( STEP 2 )';
    case EngineeringAssistant = 'ENGINEERING ASSISTANT';
    case ExecutiveSpecialOperationOfficerI = 'EXECUTIVE SPECIAL OPERATION OFFICER I';
    case InfoTechOfficer = 'INFO. TECH OFFICER';
    case LaboratoryTechnicianI = 'LABORATORY TECHNICIAN I';
    case MechanicII = 'MECHANIC II';
    case MechanicIII = 'MECHANIC III';
    case MedTechIStep3 = 'MED. TECH I ( STEP 3 )';
    case MeterReaderI = 'METER READER I';
    case MeterReaderII = 'METER READER II';
    case MeterReaderIII = 'METER READER III';
    case PipeFitterForeman = 'PIPE FITTER FOREMAN';
    case PlumberII = 'PLUMBER II';
    case PlumbingAndTinningInspectorII = 'PLUMBING & TINNIN INSPECTOR II';
    case SeniorAdminAssistantI = 'SENIOR ADMINISTRATIVE ASSISTANT I';
    case SeniorAdminAssistantII = 'SENIOR ADMINISTRATIVE ASSISTANT II';
    case SeniorAdminAssistantIII = 'SENIOR ADMINISTRATIVE ASSISTANT III';
    case SeniorAdminAssistantV = 'SR. ADMIN. ASST V';
    case SeniorBookkeeper = 'SENIOR BOOKKEEPER';
    case SupervisingAdminOfficer = 'SUPERVISING ADMIN OFFICER';
    case WaterworksSupervisor = 'WATERWORKS SUPERVISOR';
    case WellDriller = 'WELL DRILLER';
    case WellDrillerI = 'WELL DRILLER I';
    case WellDrillerII = 'WELL DRILLER II';
    case WelderII = 'WELDER II';

    public function getDetailsLink(): string {
        return "./src/components/add_regular_employee.php?position=" . $this->value;
    }
}
?>