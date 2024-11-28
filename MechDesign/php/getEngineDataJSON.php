<?php


/*
    Author: Nathan Thurmond
    Revision Date: 2024-11-27
    Notes: I'm keeping this script in case I need to reference the calcuations later but
        the code itself is deprecated in favor of whole model approach loaded to front-end
*/

/*

    Here's the psuedo-code that gets mech engine data. Keeping for reference
    
    $engineRating = MechDesign.engineRating.engineRating;
    $mechTonnage = MechDesign.mechs.maxTonnage;
    $mechInternals = MechDesign.mechinternals.*
    
    $EngineDataArray = array(
        "engineRating" => $engineRating,
        "mechTonnage" => $mechTonnage,
        "internalsTonnage" => $internalsArray['internalStructureTonnage'],
        "internalsCriticals" => $internalsArray['internalStructureCriticals'],
        "engineTonnage" => $internalsArray['engineTonnage'],
        "engineCriticals" => $internalsArray['engineCriticals'],
        "gyroTonnage" => $internalsArray['gyroTonnage'],
        "gyroCriticals" => $internalsArray['gyroCriticals'],
        "cockpitTonnage" => $internalsArray['cockpitTonnage'],
        "cockpitCriticals" => $internalsArray['cockpitCriticals'],
        "heatSinksTonnage" => $internalsArray['heatSinksTonnage'],
        "heatSinksCriticals" => $internalsArray['heatSinksCriticals'],
        "enhancementsTonnage" => $internalsArray['enhancementsTonnage'],
        "enhancementsCriticals" => $internalsArray['enhancementsCriticals'],
        "jumpJetsTonnage" => $internalsArray['jumpJetsTonnage'],
        "jumpJetsCriticals" => $internalsArray['jumpJetsCriticals']
    );

    echo json_encode($EngineDataArray);

*/