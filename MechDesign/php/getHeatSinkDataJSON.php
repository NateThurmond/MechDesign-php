<?php

/*
    Author: Nathan Thurmond
    Revision Date: 2024-11-27
    Notes: I'm keeping this script in case I need to reference the calcuations later but
        the code itself is deprecated in favor of whole model approach loaded to front-end
*/

/*
    heatSinkType = MechDesign.mechinternals.heatSinkType
    currentHeatWeight = MechDesign.mechinternals.heatSinksTonnage
    heatSinksNum = GET heatSinksNum

    UPDATE mechinternals SET
        totalInternalTonnage = (totalInternalTonnage + heatSinkNum - 10),
        heatSinksNum = heatSinkNum,
        heatSinksCriticals = heatSinkNum-1,
        heatSinksTonnage = heatSinkNum - 10

    heatDissipation = heatSinkType === Singles ? heatSinksNum : heatSinksNum * 2
    
    $heatSinkDataArrayJSON = array(
        "heatSinkType" => $heatSinkDataArray['heatSinkType'],
        "heatSinksNum" => $heatSinkDataArray['heatSinksNum'],
        "heatSinksTonnage" => $heatSinkDataArray['heatSinksTonnage'],
        "heatSinksCriticals" => $heatSinkDataArray['heatSinksCriticals'],
        "heatDissipation" => $heatDissipation
    );
    
    echo json_encode($heatSinkDataArrayJSON);
*/