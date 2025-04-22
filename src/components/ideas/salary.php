<?php

enum SalaryGrade: int {
    case Grade1 = 1;
    case Grade2 = 2;
    case Grade3 = 3;
    case Grade4 = 4;
    case Grade5 = 5;
    case Grade6 = 6;
    case Grade7 = 7;
    case Grade8 = 8;
    case Grade9 = 9;
    case Grade10 = 10;
    case Grade11 = 11;
    case Grade12 = 12;
    case Grade13 = 13;
    case Grade14 = 14;
    case Grade15 = 15;
    case Grade16 = 16;
    case Grade17 = 17;
    case Grade18 = 18;
    case Grade19 = 19;
    case Grade20 = 20;
    case Grade21 = 21;
    case Grade22 = 22;
    case Grade23 = 23;
    case Grade24 = 24;
    case Grade25 = 25;
    case Grade26 = 26;
    case Grade27 = 27;
    case Grade28 = 28;
    case Grade29 = 29;
    case Grade30 = 30;
    case Grade31 = 31;
    case Grade32 = 32;
    case Grade33 = 33;

    public static function getStepsForGrade(self $salaryGrade): array {
        // Define salary standards for each grade and step (up to step 8 where applicable)
        $salaryData = [
            self::Grade1->value => [14061, 14164, 14278, 14393, 14509, 14626, 14743, 14862],
            self::Grade2->value => [14925, 15035, 15146, 15258, 15371, 15484, 15599, 15714],
            self::Grade3->value => [15852, 15971, 16088, 16208, 16329, 16448, 16571, 16693],
            self::Grade4->value => [16833, 16958, 17084, 17209, 17337, 17464, 17594, 17724],
            self::Grade5->value => [17866, 18000, 18133, 18267, 18401, 18538, 18676, 18813],
            self::Grade6->value => [18957, 19098, 19239, 19383, 19526, 19670, 19819, 19963],
            self::Grade7->value => [20110, 20258, 20408, 20560, 20711, 20865, 21019, 21175],
            self::Grade8->value => [21448, 21642, 21839, 22035, 22234, 22435, 22638, 22843],
            self::Grade9->value => [23226, 23411, 23599, 23788, 23978, 24170, 24364, 24558],
            self::Grade10->value => [25586, 25790, 25996, 26203, 26412, 26623, 26835, 27050],
            self::Grade11->value => [30024, 30308, 30597, 30889, 31185, 31486, 31790, 32099],
            self::Grade12->value => [32245, 32529, 32817, 33108, 33403, 33702, 34004, 34310],
            self::Grade13->value => [34421, 34733, 35049, 35369, 35694, 36022, 36354, 36691],
            self::Grade14->value => [37024, 37384, 37749, 38118, 38491, 38869, 39252, 39640],
            self::Grade15->value => [40208, 40604, 41006, 41413, 41824, 42241, 42662, 43090],
            self::Grade16->value => [43560, 43996, 44438, 44885, 45338, 45796, 46261, 46730],
            self::Grade17->value => [47247, 47727, 48213, 48705, 49203, 49708, 50218, 50735],
            self::Grade18->value => [51304, 51832, 52367, 52907, 53456, 54014, 54572, 55140],
            self::Grade19->value => [56390, 57165, 57953, 58753, 59567, 60394, 61235, 62089],
            self::Grade20->value => [62967, 63842, 64732, 65637, 66557, 67489, 68439, 69403],
            self::Grade21->value => [70013, 71000, 72004, 73024, 74061, 75115, 76151, 77229],
            self::Grade22->value => [78162, 79277, 80411, 81564, 82735, 83927, 85138, 86369],
            self::Grade23->value => [87315, 88574, 89855, 91163, 92494, 93850, 95228, 96655],
            self::Grade24->value => [98185, 99721, 101283, 102871, 104483, 106123, 107739, 109431],
            self::Grade25->value => [111727, 113476, 115254, 117062, 118899, 120766, 122664, 124591],
            self::Grade26->value => [126252, 128228, 130238, 132280, 134356, 136465, 138608, 140788],
            self::Grade27->value => [142663, 144897, 147169, 149407, 151752, 153850, 156267, 158723],
            self::Grade28->value => [160469, 162988, 165548, 167994, 170634, 173320, 175803, 178572],
            self::Grade29->value => [180492, 183332, 186218, 189151, 192131, 194797, 197870, 200993],
            self::Grade30->value => [203200, 206401, 209558, 212766, 216022, 219434, 222797, 226319],
            self::Grade31->value => [293191, 298773, 304464, 310119, 315883, 321846, 327895, 334059],
            self::Grade32->value => [347888, 354743, 361736, 368694, 375969, 383391, 390963, 398686],
            self::Grade33->value => [438844, 451713],
        ];

        // Return steps for the specific grade
        return $salaryData[$salaryGrade->value] ?? [];
    }
}