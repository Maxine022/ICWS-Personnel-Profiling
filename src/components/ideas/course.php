<?php
enum CollegeCourse: string {
    case BSInformationTechnology = 'BS Information Technology';
    case BSComputerScience = 'BS Computer Science';
    case BSElectronicsEngineering = 'BS Electronics Engineering';
    case BSAccountancy = 'BS Accountancy';
    case BSBusinessAdministration = 'BS Business Administration';
    case BSNursing = 'BS Nursing';
    case BSEducation = 'BS Education';
    case BSArchitecture = 'BS Architecture';
    case BSMechanicalEngineering = 'BS Mechanical Engineering';
    case BSHotelAndRestaurantManagement = 'BS Hotel and Restaurant Management';
    case BSBiology = 'BS Biology';
    case BSPharmacy = 'BS Pharmacy';
    case BSPhysics = 'BS Physics';
    case BSMathematics = 'BS Mathematics';
    case BSMarineBiology = 'BS Marine Biology';
    case BSForestry = 'BS Forestry';
    case BSAgriculture = 'BS Agriculture';
    case BSCivilEngineering = 'BS Civil Engineering';
    case BSElectricalEngineering = 'BS Electrical Engineering';
    case BSChemicalEngineering = 'BS Chemical Engineering';
    case BSBiologyEducation = 'BS Biology Education';
    case BSPhysicsEducation = 'BS Physics Education';
    case BSMathematicsEducation = 'BS Mathematics Education';
    case BSStatistics = 'BS Statistics';
    case BSEconomics = 'BS Economics';
    case BSSocialWork = 'BS Social Work';
    case BSHumanResourceManagement = 'BS Human Resource Management';
    case BSBroadcastCommunication = 'BS Broadcast Communication';
    case BSMassCommunication = 'BS Mass Communication';
    case BSSocialScience = 'BS Social Science';
    case BSSociology = 'BS Sociology';
    case BSPsychology = 'BS Psychology';
    case BSHistory = 'BS History';
    case BSPhilosophy = 'BS Philosophy';
    case BSLibraryAndInformationScience = 'BS Library and Information Science';
    case BSLaw = 'BS Law';
    case BSBiologyAndChemistry = 'BS Biology and Chemistry';
    case BSEnvironmentalScience = 'BS Environmental Science';
    case BSInformationSystem = 'BS Information System';
    case BSComputerEngineering = 'BS Computer Engineering';
    case BSMaterialsEngineering = 'BS Materials Engineering';
    case BSBiomedicalEngineering = 'BS Biomedical Engineering';
    case BSChemistry = 'BS Chemistry';
    case BSMicrobiology = 'BS Microbiology';
    case BSBiochemistry = 'BS Biochemistry';
    case BSMolecularBiology = 'BS Molecular Biology';

    public function getDetailsLink(): string {
        return "./src/components/add_student.php?course=" . urlencode($this->value);
    }
}

enum College: string {
    case UniversityOfThePhilippines = 'University of the Philippines';
    case AteneoDeManilaUniversity = 'Ateneo de Manila University';
    case DeLaSalleUniversity = 'De La Salle University';
    case UniversityOfSantoTomas = 'University of Santo Tomas';
    case PolytechnicUniversityOfThePhilippines = 'Polytechnic University of the Philippines';
    case MapuaUniversity = 'Mapúa University';
    case MindanaoStateUniversity = 'Mindanao State University';
    case MindanaoStateUniversityIIT = 'Mindanao State University - Iligan Institute of Technology';
    case UniversityOfSanAgustin = 'University of San Agustin';
    case UniversityOfTheCordilleras = 'University of the Cordilleras';
    case UniversityOfTheVisayas = 'University of the Visayas';
    case UniversityOfSouthernPhilippines = 'University of Southern Philippines';
    case UniversityOfTheEastRamonMagsaysayMemorialMedicalCenter = 'University of the East Ramon Magsaysay Memorial Medical Center';
    case UniversityOfTheEastCalabarzon = 'University of the East Calabarzon';
    case UniversityOfTheEastManila = 'University of the East Manila';
    case UniversityOfTheEastCavite = 'University of the East Cavite';
    case UniversityOfTheEastQuezonCity = 'University of the East Quezon City';
    case UniversityOfTheEastPampanga = 'University of the East Pampanga';
    case SillimanUniversity = 'Silliman University';
    case FarEasternUniversity = 'Far Eastern University';
    case UniversityOfTheEast = 'University of the East';
    case AdamsonUniversity = 'Adamson University';
    case LyceumOfThePhilippinesUniversity = 'Lyceum of the Philippines University';
    case SanBedaUniversity = 'San Beda University';
    case UniversityOfNegrosOccidentalRecoletos = 'University of Negros Occidental-Recoletos';
    case XavierUniversity = 'Xavier University';
    case CentralPhilippineUniversity = 'Central Philippine University';
    case CebuTechnologicalUniversity = 'Cebu Technological University';
    case UniversityOfCebu = 'University of Cebu';
    case UniversityOfSanCarlos = 'University of San Carlos';
    case UniversityOfMindanao = 'University of Mindanao';

    public function getDetailsLink(): string {
        return "./src/components/add_student.php?college=" . urlencode($this->value);
    }
}
?>