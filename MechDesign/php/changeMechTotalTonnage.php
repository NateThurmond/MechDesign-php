<?php

/*
    Author: Nathan Thurmond
    Revision Date: 2024-11-21
    Notes: I'm keeping this script in case I need to reference the calcuations later but
        the code itself is deprecated in favor of whole model approach loaded to front-end
*/

/*
    Here's the psuedo-code that implements some version of the logic I did have going on
        in the back-end. Hopefully I never need to reverse engineer this

    $mechWalk = mechengine.mechWalk
    $mechEngineType = mechengine.engineName
    $newEngineRating = $mechWalk * $tons

    $jumpJetsNum = mechinternals.jumpJetsNum
    $internalStructureTonnage = $tons/10;

    if ($mechEngineType == "Fusion Engine") {
        $engineTonnage = engineratingweights.regEngWeight
    }
    else if ($mechEngineType == "XL Engine") {
        $engineTonnage = engineratingweights.xlEngWeight
    }
    
    $gyroTonnage = engineratingweights.gyroWeight

    if ($tons <= 55) {
        $jumpJetsTon = $jumpJetsNum * 0.5;
    }
    else if ($tons <= 85) {
        $jumpJetsTon = $jumpJetsNum * 1;
    }
    else {
        $jumpJetsTon = $jumpJetsNum * 2;
    }

    UPDATE mechinternals SET `internalStructureTonnage`=$internalStructureTonnage,
        `engineTonnage`=$engineTonnage, `gyroTonnage`=$gyroTonnage, `jumpJetsTonnage`=$jumpJetsTon

    $newTonnage = mechinternals.weaponTonnage + mechinternals.internalStructureTonnage + mechinternals.engineTonnage
        + mechinternals.gyroTonnage + mechinternals.cockpitTonnage + mechinternals.heatSinksTonnage + mechinternals.jumpJetsTonnage

    UPDATE `mechinternals` SET `totalInternalTonnage`=$newTonnage
    UPDATE `mechs` SET `maxTonnage`=$tons
    UPDATE `mechengine` SET `engineRating`=$newEngineRating
*/

?>
