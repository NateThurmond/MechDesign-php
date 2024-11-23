var getFullMechData; // FN to return full mech data
var fullMechData = {}; // Returned from db on page load from above fn
var armorCharts = {};
var dataByWeaponName = {};
var weaponArray = [];

const isMechInternalStructurePoints = {
    20: { head: 3, centerTorso: 6, sideTorso: 5, arms: 3, legs: 4 },
    25: { head: 3, centerTorso: 7, sideTorso: 6, arms: 4, legs: 5 },
    30: { head: 3, centerTorso: 8, sideTorso: 6, arms: 5, legs: 7 },
    40: { head: 3, centerTorso: 12, sideTorso: 8, arms: 6, legs: 9 },
    45: { head: 3, centerTorso: 13, sideTorso: 9, arms: 7, legs: 10 },
    50: { head: 3, centerTorso: 15, sideTorso: 10, arms: 8, legs: 11 },
    55: { head: 3, centerTorso: 16, sideTorso: 11, arms: 9, legs: 12 },
    60: { head: 3, centerTorso: 18, sideTorso: 12, arms: 10, legs: 13 },
    65: { head: 3, centerTorso: 19, sideTorso: 13, arms: 11, legs: 14 },
    70: { head: 3, centerTorso: 21, sideTorso: 14, arms: 11, legs: 15 },
    75: { head: 3, centerTorso: 23, sideTorso: 15, arms: 12, legs: 16 },
    80: { head: 3, centerTorso: 24, sideTorso: 16, arms: 13, legs: 17 },
    85: { head: 3, centerTorso: 26, sideTorso: 17, arms: 14, legs: 18 },
    90: { head: 3, centerTorso: 27, sideTorso: 18, arms: 15, legs: 19 },
    95: { head: 3, centerTorso: 29, sideTorso: 19, arms: 16, legs: 20 },
    100: { head: 3, centerTorso: 30, sideTorso: 20, arms: 17, legs: 21 },
};

const clanMechInternalStructurePoints = {
    20: { head: 3, centerTorso: 6, sideTorso: 4, arms: 3, legs: 4 },
    25: { head: 3, centerTorso: 8, sideTorso: 5, arms: 4, legs: 5 },
    30: { head: 3, centerTorso: 10, sideTorso: 6, arms: 5, legs: 6 },
    40: { head: 3, centerTorso: 12, sideTorso: 8, arms: 6, legs: 8 },
    45: { head: 3, centerTorso: 14, sideTorso: 9, arms: 7, legs: 9 },
    50: { head: 3, centerTorso: 16, sideTorso: 10, arms: 8, legs: 10 },
    55: { head: 3, centerTorso: 17, sideTorso: 11, arms: 9, legs: 11 },
    60: { head: 3, centerTorso: 19, sideTorso: 12, arms: 10, legs: 12 },
    65: { head: 3, centerTorso: 20, sideTorso: 13, arms: 11, legs: 13 },
    70: { head: 3, centerTorso: 22, sideTorso: 15, arms: 11, legs: 15 },
    75: { head: 3, centerTorso: 24, sideTorso: 16, arms: 12, legs: 16 },
    80: { head: 3, centerTorso: 26, sideTorso: 17, arms: 13, legs: 17 },
    85: { head: 3, centerTorso: 28, sideTorso: 18, arms: 14, legs: 18 },
    90: { head: 3, centerTorso: 30, sideTorso: 19, arms: 15, legs: 19 },
    95: { head: 3, centerTorso: 32, sideTorso: 20, arms: 16, legs: 20 },
    100: { head: 3, centerTorso: 34, sideTorso: 22, arms: 17, legs: 22 },
};

// Approximate num of avail slots per weight class
const mechSlotByWeightClass = {
    Light: {
        mecharm: 4,
        mechhead: 1,
        mechtorso: 4,
        mechtorsocenter: 5,
        mechleg: 2,
    },
    Medium: {
        mecharm: 5,
        mechhead: 1,
        mechtorso: 6,
        mechtorsocenter: 7,
        mechleg: 3,
    },
    Heavy: {
        mecharm: 7,
        mechhead: 1,
        mechtorso: 9,
        mechtorsocenter: 10,
        mechleg: 4,
    },
    Assault: {
        mecharm: 8,
        mechhead: 1,
        mechtorso: 12,
        mechtorsocenter: 12,
        mechleg: 5,
    },
};

/* Companion function to above - get mech weight class */
function returnWeightClass(mechWeightPassed = "") {
    let foundMechWeight = mechWeightPassed ? mechWeightPassed : fullMechData.mechs_maxTonnage;
    foundMechWeight = parseInt(foundMechWeight, 10);
    if (foundMechWeight >= 85) return "Assault";
    else if (foundMechWeight >= 65) return "Heavy";
    else if (foundMechWeight >= 40) return "Medium";
    else return "Light";
}

/* Companion function to above - get mech slots available (by weight) */
function weaponSlotsAvail() {
    return mechSlotByWeightClass[returnWeightClass()];
}

/* When changing weights, remove extra weapons that don't fit */
function clearSlotsOnWeightChange() {
    let weightClass = returnWeightClass();
    let weaponSlotsAvailToEval = mechSlotByWeightClass[weightClass];

    for (let [comp, slotsAvail] of Object.entries(weaponSlotsAvailToEval)) {
        for (let i in [0, 1, 2]) {
            let currentCompCrits = getMechPartSlots(comp, parseInt(i, 10));

            if ($.isEmptyObject(currentCompCrits)) continue;

            let slotCounter = Object.keys(currentCompCrits).length;
            for (let [slotKey, slotVal] of Object.entries(currentCompCrits).reverse()) {
                if (slotCounter > parseInt(slotsAvail, 10)) {
                    fullMechData[slotKey] = "";
                    if (slotVal === "overflow") {
                        slotsAvail = parseInt(slotsAvail, 10) - 1;
                    }
                }
                slotCounter--;
            }
        }
    }
}

// Re-index weapon slots
function shiftSlots(obj) {
    // Extract all values from the object
    const values = Object.values(obj);

    // Separate non-empty and empty values
    const nonEmpty = values.filter((value) => value !== "");
    const empty = values.filter((value) => value === "");

    // Recombine non-empty and empty values
    const shiftedValues = [...nonEmpty, ...empty];

    // Map shifted values back to the original object keys
    const keys = Object.keys(obj);
    const result = {};
    keys.forEach((key, index) => {
        result[key] = shiftedValues[index];
    });

    return result;
}

// FUNCTION TO DISPLAY ARMOR POINTS DYNAMICALLY AND EVENLY ACROSS MULTIPLE ROWS
function armorDisplayCircles(classToMod, idToMod, armorCircles, divLines) {
    const container = document.createElement("div");
    container.className = classToMod;
    container.id = idToMod;

    let divCounter = 0;
    for (let count = 0; count < armorCircles; count++) {
        const circle = document.createElement("p");
        circle.className = "circle";
        container.appendChild(circle);
        divCounter++;
        if (divCounter % divLines === 0) {
            container.appendChild(document.createElement("br"));
        }
    }
    return container;
}

function updateMechMeta(mechData) {
    $('input[name="mechName"]').val(mechData.mechs_mechName);
    $('input[name="mechModel"]').val(mechData.mechs_mechModel);
    $("#indMechEra").html(`Era: ${mechData.mechs_era}`);
    $("#indMechTechBase").html(`Tech Base: ${mechData.mechs_techBase}`);
    $("#indMechProdYear").html(`Production Year: ${mechData.mechs_productionYear}`);
}

// FUNCTION TO DISPLAY ARMOR VALUES (External armor that is)
function displayArmorSection(displayLocale, mechData) {
    mechData = mechData;
    const mechArmorContainer = document.getElementById("mechArmor");
    $(mechArmorContainer).empty();

    // Add arm armor
    const armorCirclesLeftArm = parseInt(mechData.mechexternalarmor_armLeftArmor);
    const armorCirclesRightArm = parseInt(mechData.mechexternalarmor_armRightArmor);
    const numDivsLeftArm = Math.ceil(armorCirclesLeftArm / 10);
    const numDivsRightArm = Math.ceil(armorCirclesRightArm / 10);

    const armContainer = document.createElement("div");
    armContainer.id = "arm";

    armContainer.appendChild(
        armorDisplayCircles("armorDisplayLayout", "leftArmArmor", armorCirclesLeftArm, numDivsLeftArm)
    );
    armContainer.appendChild(
        armorDisplayCircles("armorDisplayLayout", "rightArmArmor", armorCirclesRightArm, numDivsRightArm)
    );

    armContainer.innerHTML += `
        <div id="leftArmArmorNumeric"><p>${armorCirclesLeftArm}</p></div>
        <div id="rightArmArmorNumeric"><p>${armorCirclesRightArm}</p></div>
    `;
    mechArmorContainer.appendChild(armContainer);

    // Add head armor
    const armorCirclesHead = parseInt(mechData.mechexternalarmor_headArmor);
    const numDivsHead = Math.ceil(armorCirclesHead / 3);

    const headContainer = document.createElement("div");
    headContainer.id = "head";

    headContainer.appendChild(
        armorDisplayCircles("armorDisplayLayout", "mechHeadArmor", armorCirclesHead, numDivsHead)
    );
    headContainer.innerHTML += `<div id="mechHeadArmorNumeric"><p>${armorCirclesHead}</p></div>`;
    mechArmorContainer.appendChild(headContainer);

    // Add center armor
    const armorCirclesCenter = parseInt(mechData.mechexternalarmor_centerArmor);
    const armorCirclesRearCenter = parseInt(mechData.mechexternalarmor_rearCenterArmor);
    const numDivsCenter = Math.ceil(armorCirclesCenter / 9);
    const numDivsRearCenter = Math.ceil(armorCirclesRearCenter / 9);

    const centerContainer = document.createElement("div");
    centerContainer.id = "center";

    centerContainer.appendChild(
        armorDisplayCircles("armorDisplayLayout", "centerArmor", armorCirclesCenter, numDivsCenter)
    );
    centerContainer.appendChild(
        armorDisplayCircles("armorDisplayLayout", "centerRearArmor", armorCirclesRearCenter, numDivsRearCenter)
    );

    centerContainer.innerHTML += `
        <div id="centerArmorNumeric"><p>${armorCirclesCenter}</p></div>
        <div id="centerRearArmorNumeric"><p>${armorCirclesRearCenter}</p></div>
    `;
    mechArmorContainer.appendChild(centerContainer);

    // Torsor Armor
    const armorCirclesLeftTorso = parseInt(mechData.mechexternalarmor_torsoLeftArmor);
    const armorCirclesRightTorso = parseInt(mechData.mechexternalarmor_torsoRightArmor);
    const armorCirclesLeftRear = parseInt(mechData.mechexternalarmor_rearLeftTorsoArmor);
    const armorCirclesRightRear = parseInt(mechData.mechexternalarmor_rearRightTorsoArmor);

    const armorTorsoLeftTop = Math.round(armorCirclesLeftTorso * 0.57);
    const numDivsTorsoLeftTop = Math.ceil(armorTorsoLeftTop / 4);
    const armorTorsoRightTop = Math.round(armorCirclesRightTorso * 0.57);
    const numDivsTorsoRightTop = Math.ceil(armorTorsoRightTop / 4);
    const armorTorsoLeftBottom = Math.round(armorCirclesLeftTorso * 0.285);
    const numDivsTorsoLeftBottom = Math.ceil(armorTorsoLeftBottom / 2);
    const armorTorsoRightBottom = Math.round(armorCirclesRightTorso * 0.285);
    const numDivsTorsoRightBottom = Math.ceil(armorTorsoRightBottom / 2);
    const armorTorsoLeftMiddle = armorCirclesLeftTorso - (armorTorsoLeftTop + armorTorsoLeftBottom);
    const numDivsTorsoLeftMiddle = Math.ceil(armorTorsoLeftMiddle / 3);
    const armorTorsoRightMiddle = armorCirclesRightTorso - (armorTorsoRightTop + armorTorsoRightBottom);
    const numDivsTorsoRightMiddle = Math.ceil(armorTorsoRightMiddle / 3);
    const numDivsTorsoLeftRear = Math.ceil(armorCirclesLeftRear / 4);
    const numDivsTorsoRightRear = Math.ceil(armorCirclesRightRear / 4);

    const torsoContainer = document.createElement("div");
    torsoContainer.id = "torso";

    torsoContainer.appendChild(
        armorDisplayCircles("armorDisplayLayout", "leftTorsoArmorTop", armorTorsoLeftTop, numDivsTorsoLeftTop)
    );
    torsoContainer.appendChild(
        armorDisplayCircles("armorDisplayLayout", "leftTorsoArmorMiddle", armorTorsoLeftMiddle, numDivsTorsoLeftMiddle)
    );
    torsoContainer.appendChild(
        armorDisplayCircles("armorDisplayLayout", "leftTorsoArmorBottom", armorTorsoLeftBottom, numDivsTorsoLeftBottom)
    );

    torsoContainer.appendChild(
        armorDisplayCircles("armorDisplayLayout", "rightTorsoArmorTop", armorTorsoRightTop, numDivsTorsoRightTop)
    );
    torsoContainer.appendChild(
        armorDisplayCircles(
            "armorDisplayLayout",
            "rightTorsoArmorMiddle",
            armorTorsoRightMiddle,
            numDivsTorsoRightMiddle
        )
    );
    torsoContainer.appendChild(
        armorDisplayCircles(
            "armorDisplayLayout",
            "rightTorsoArmorBottom",
            armorTorsoRightBottom,
            numDivsTorsoRightBottom
        )
    );

    torsoContainer.appendChild(
        armorDisplayCircles("armorDisplayLayout", "leftRearTorsoArmor", armorCirclesLeftRear, numDivsTorsoLeftRear)
    );
    torsoContainer.appendChild(
        armorDisplayCircles("armorDisplayLayout", "rightRearTorsoArmor", armorCirclesRightRear, numDivsTorsoRightRear)
    );

    torsoContainer.innerHTML += `
        <div id="leftTorsoArmorNumeric">${armorCirclesLeftTorso}</div>
        <div id="rightTorsoArmorNumeric">${armorCirclesRightTorso}</div>
        <div id="leftRearTorsoArmorNumeric">${armorCirclesLeftRear}</div>
        <div id="rightRearTorsoArmorNumeric">${armorCirclesRightRear}</div>
    `;
    mechArmorContainer.appendChild(torsoContainer);

    // And finally leg armor
    const armorCirclesLeftLeg = mechData.mechexternalarmor_legLeftArmor;
    const armorCirclesRightLeg = mechData.mechexternalarmor_legRightArmor;

    const numDivsLeftLeg = Math.ceil(armorCirclesLeftLeg / 12);
    const numDivsRightLeg = Math.ceil(armorCirclesRightLeg / 12);

    const legSection = document.createElement("div");
    legSection.id = "leg";

    // Left Leg Armor
    legSection.appendChild(
        armorDisplayCircles("armorDisplayLayout", "leftLegArmor", armorCirclesLeftLeg, numDivsLeftLeg)
    );

    // Right Leg Armor
    legSection.appendChild(
        armorDisplayCircles("armorDisplayLayout", "rightLegArmor", armorCirclesRightLeg, numDivsRightLeg)
    );

    // Numeric Values for Left and Right Leg
    const leftLegNumeric = document.createElement("div");
    leftLegNumeric.id = "leftLegArmorNumeric";
    leftLegNumeric.textContent = armorCirclesLeftLeg;
    legSection.appendChild(leftLegNumeric);

    const rightLegNumeric = document.createElement("div");
    rightLegNumeric.id = "rightLegArmorNumeric";
    rightLegNumeric.textContent = armorCirclesRightLeg;
    legSection.appendChild(rightLegNumeric);

    // Append the leg section to the parent container
    mechArmorContainer.appendChild(legSection);
}

// Method to update the heat sink/type/dissipation data
function updateHeatSinksJSON(swapHeatSyncType = false, newHeatSyncNum = -1) {
    let changeMade = false;
    if (swapHeatSyncType === true) {
        fullMechData.mechinternals_heatSinkType =
            fullMechData.mechinternals_heatSinkType === "Singles" ? "Doubles" : "Singles";
        changeMade = true;
    }
    if (newHeatSyncNum !== -1) {
        fullMechData.mechinternals_heatSinksNum = newHeatSyncNum;
        changeMade = true;
    }

    $("#heatSinkTypeDropDown").val(fullMechData.mechinternals_heatSinkType);
    $("#heatSinkNumDropDown").val(fullMechData.mechinternals_heatSinksNum);
    let heatSinkMulti = $("#heatSinkTypeDropDown").val() === "Singles" ? 1 : 2;
    $("#heatDissipation").html(heatSinkMulti * parseInt($("#heatSinkNumDropDown").val(), 10));

    if (changeMade === true) {
        changeMechInternalTonnage(fullMechData.mechs_maxTonnage);
    }
}

async function updateEngine(updatedEngineChange = false) {
    if (updatedEngineChange !== false && typeof updatedEngineChange === "string") {
        fullMechData.mechengine_engineName = updatedEngineChange;
        const resp = await $.getJSON(
            "php/getMechEngineData.php?engineName=" + encodeURIComponent(fullMechData.mechengine_engineName)
        );

        // Destructure the response
        const { engineRating, mechJump, mechRun, mechWalk } = resp;
        fullMechData.mechengine_mechRun = mechRun;
        fullMechData.mechengine_mechJump = mechJump;
        fullMechData.mechengine_mechWalk = mechWalk;
        fullMechData.mechengine_engineRating = engineRating;
    }

    // Update the DOM
    $("#engineDropDown").val(fullMechData.mechengine_engineName);
    $("#mechWalk").find(".movementValues").val(fullMechData.mechengine_mechWalk);
    $("#mechRun").find(".movementValues").val(fullMechData.mechengine_mechRun);
    $("#mechJump").find(".movementValues").val(fullMechData.mechengine_mechJump);
    changeMechInternalTonnage(fullMechData.mechs_maxTonnage);
}

function changeMechInternalTonnage(mechWeight) {
    fullMechData.mechs_maxTonnage = mechWeight;

    let walkSpeed = parseInt($("#mechWalk").find(".movementValues").val(), 10);

    // Calculate the engine rating (assumes walking speed of 4)
    const engineRating = mechWeight * walkSpeed;

    // Internal Structure Weight: 10% of mech weight
    const internalStructure = mechWeight * 0.1;

    // Engine Weight and Criticals (based on official table approximations)
    let engineWeight, engineCrits;
    if (fullMechData.mechengine_engineName === "Fusion Engine") {
        engineWeight = getFusionEngineWeight(engineRating, mechWeight);
        engineCrits = 6; // Fixed: 2 in each torso section
    } else if (fullMechData.mechengine_engineName === "XL Engine") {
        engineWeight = getXLEngineWeight(engineRating, mechWeight);
        engineCrits = 12; // Fixed: 4 in each torso section
    }

    // Gyro Weight and Slots
    const gyroWeight = Math.ceil((engineRating / 100) * 2 * 2) / 2;
    const gyroCrits = 4; // Standard gyro

    // Cockpit Weight and Slots
    const cockpitWeight = 3;
    const cockpitCrits = 1; // Always in the head

    // Heat Sink Weight and Slots
    const extraHeatSinkWeight = Math.max(fullMechData.mechinternals_heatSinksNum - 10, 0);
    const heatSinkCrits =
        fullMechData.mechinternals_heatSinksNum > 10 ? fullMechData.mechinternals_heatSinksNum - 10 : 0;

    // Total Weight
    const totalWeight = internalStructure + engineWeight + gyroWeight + cockpitWeight + extraHeatSinkWeight;

    // Total Criticals
    const totalCriticals = engineCrits + gyroCrits + cockpitCrits + heatSinkCrits;

    // Return all calculated values
    console.log({
        mechWeight,
        engineName: fullMechData.mechengine_engineName,
        heatSinksNum: fullMechData.mechinternals_heatSinksNum,
        internalStructure: internalStructure.toFixed(1),
        engineWeight: engineWeight.toFixed(1),
        gyroWeight: gyroWeight.toFixed(1),
        cockpitWeight: cockpitWeight.toFixed(1),
        extraHeatSinkWeight: extraHeatSinkWeight.toFixed(1),
        totalWeight: totalWeight.toFixed(1),
        engineCrits,
        gyroCrits,
        cockpitCrits,
        heatSinkCrits,
        totalCriticals,
    });

    // fullMechData.mechinternals_totalInternalTonnage = internalStructure.toFixed(1);
    fullMechData.mechinternals_engineTonnage = engineWeight.toFixed(1);

    // fullMechData.mechinternals_internalStructureTonnage = totalWeight.toFixed(1);
    // fullMechData.mechinternals_internalStructureCriticals = totalCriticals;

    fullMechData.mechinternals_gyroTonnage = gyroWeight.toFixed(1);
    fullMechData.mechinternals_cockpitTonnage = cockpitWeight.toFixed(1);
    fullMechData.mechinternals_heatSinksTonnage = extraHeatSinkWeight.toFixed(1);
    fullMechData.mechinternals_engineCriticals = engineCrits;
    fullMechData.mechinternals_gyroCriticals = gyroCrits;
    fullMechData.mechinternals_cockpitCriticals = cockpitCrits;
    fullMechData.mechinternals_heatSinksCriticals = heatSinkCrits;
    fullMechData.mechinternals_jumpJetsNum = $("#mechJump").find(".movementValues").val();
    fullMechData.mechinternals_jumpJetsTonnage = $("#mechJump").find(".movementValues").val();
    fullMechData.mechinternals_jumpJetsCriticals = Math.ceil(fullMechData.mechinternals_jumpJetsNum / 3);

    fullMechData.mechinternals_internalStructureTonnage =
        parseInt(fullMechData.mechinternals_engineTonnage, 10) +
        parseInt(fullMechData.mechinternals_gyroTonnage, 10) +
        parseInt(fullMechData.mechinternals_cockpitTonnage, 10) +
        parseInt(fullMechData.mechinternals_heatSinksTonnage, 10) +
        parseInt(1, 10) +
        parseInt(fullMechData.mechinternals_jumpJetsNum, 10);

    // let externalArmor = fullMechData.mechexternalarmor_mechArmorTotal;
    // let maxTonnage = fullMechData.mechs_maxTonnage;
    // let externalArmorWeight = Math.ceil(fullMechData.mechexternalarmor_mechArmorTotal / 8) / 2;
    fullMechData.mechinternals_totalInternalTonnage =
        fullMechData.mechinternals_internalStructureTonnage +
        Math.ceil(fullMechData.mechexternalarmor_mechArmorTotal / 8) / 2;

    fullMechData.mechinternals_internalStructureCriticals =
        parseInt(fullMechData.mechinternals_engineCriticals, 10) +
        parseInt(fullMechData.mechinternals_gyroCriticals, 10) +
        parseInt(fullMechData.mechinternals_cockpitCriticals, 10) +
        parseInt(fullMechData.mechinternals_heatSinksCriticals, 10) +
        parseInt(1, 10) +
        parseInt(fullMechData.mechinternals_jumpJetsCriticals, 10);

    updateEngineTonnageJSON();
    updateTonnage();
    clearSlotsOnWeightChange();
    displayAllCrits();
}

function getFusionEngineWeight(engineRating, mechWeight) {
    // Weight table with mech weight as key and array of weights as values for different engine ratings
    const weightTable = {
        20: [1.5, 2, 2.5, 3, 3.5, 4],
        25: [2, 2.5, 3, 3.5, 4, 4.5],
        30: [2.5, 3, 3.5, 4, 4.5, 5],
        35: [3, 3.5, 4, 4.5, 5, 5.5],
        40: [3.5, 4, 4.5, 5, 5.5, 6],
        45: [4, 4.5, 5, 5.5, 6, 6.5],
        50: [4.5, 5, 5.5, 6, 6.5, 7],
        55: [5, 5.5, 6, 6.5, 7, 7.5],
        60: [5.5, 6, 6.5, 7, 7.5, 8],
        65: [6, 6.5, 7, 7.5, 8, 8.5],
        70: [6.5, 7, 7.5, 8, 8.5, 9],
        75: [7, 7.5, 8, 8.5, 9, 9.5],
        80: [7.5, 8, 8.5, 9, 9.5, 10],
        85: [8, 8.5, 9, 9.5, 10, 10.5],
        90: [8.5, 9, 9.5, 10, 10.5, 11],
        95: [9, 9.5, 10, 10.5, 11, 11.5],
        100: [9.5, 10, 10.5, 11, 11.5, 12],
    };

    // Determine engine rating index based on engine rating
    let ratingIndex;
    if (engineRating <= 80) {
        ratingIndex = 0; // Rating 80
    } else if (engineRating <= 100) {
        ratingIndex = 1; // Rating 100
    } else if (engineRating <= 120) {
        ratingIndex = 2; // Rating 120
    } else if (engineRating <= 140) {
        ratingIndex = 3; // Rating 140
    } else if (engineRating <= 160) {
        ratingIndex = 4; // Rating 160
    } else {
        ratingIndex = 5; // Rating 180
    }

    // If mechWeight is higher than 100, use the closest match from the table
    if (mechWeight > 100) {
        mechWeight = 100; // Cap to 100 tons for now as there is no direct match in the table for larger weights
    }

    // Get the engine weight based on the mech weight and the rating index
    return weightTable[mechWeight][ratingIndex];
}

function getXLEngineWeight(engineRating, mechWeight) {
    // XL engines are 50% lighter but require extra critical slots
    return getFusionEngineWeight(engineRating, mechWeight) * 0.5;
}

function updateEngineTonnageJSON() {
    $("#mechTonnageDropDown").val(fullMechData.mechs_maxTonnage);
    document.getElementById("mechEngineRating").innerHTML = fullMechData.mechengine_engineRating;
    document.getElementById("internalsTonnage").innerHTML = fullMechData.mechinternals_internalStructureTonnage;
    document.getElementById("InternalsCriticalsTableData").innerHTML =
        fullMechData.mechinternals_internalStructureCriticals;
    document.getElementById("engineTonnage").innerHTML = fullMechData.mechinternals_engineTonnage;
    document.getElementById("engineCriticals").innerHTML = fullMechData.mechinternals_engineCriticals;
    document.getElementById("cockpitTonnage").innerHTML = fullMechData.mechinternals_cockpitTonnage;
    document.getElementById("cockpitCriticals").innerHTML = fullMechData.mechinternals_cockpitCriticals;
    document.getElementById("gyroTonnage").innerHTML = fullMechData.mechinternals_gyroTonnage;
    document.getElementById("gyroCriticals").innerHTML = fullMechData.mechinternals_gyroCriticals;
    document.getElementById("heatSinksTonnage").innerHTML = fullMechData.mechinternals_heatSinksTonnage;
    document.getElementById("heatSinksCriticals").innerHTML = fullMechData.mechinternals_heatSinksCriticals;
    document.getElementById("enhancementsTonnage").innerHTML = fullMechData.mechinternals_enhancementsTonnage;
    document.getElementById("enhancementsCriticals").innerHTML = fullMechData.mechinternals_enhancementsCriticals;
    document.getElementById("jumpJetsTonnage").innerHTML = fullMechData.mechinternals_jumpJetsTonnage;
    document.getElementById("jumpJetsCriticals").innerHTML = fullMechData.mechinternals_jumpJetsCriticals;
}

function pickMechs() {
    $.getJSON("php/pickMechs.php", (mechsToPick) => {
        let mechPickRowContent = "";
        mechsToPick.forEach((mechToPick) => {
            let { mechID, mechName, mechModel, armor, mechWalk, maxTonnage, introDate } = mechToPick;
            mechPickRowContent += `
                <tr>
                    <td id='mechPickLink'><a href='mechDesign.php?mechIDPassed=${mechID}'>${mechName}</a></td>
                    <td>${mechModel}</td>
                    <td>${armor}</td>
                    <td>${mechWalk}</td>
                    <td>${maxTonnage}</td>
                    <td>${introDate}</td>
                <tr>
            `;
        });

        let mechPickerTable = `
            <table class='mechPickTable' border='1'
                <tr>
                    <th>Mech Name</th>
                    <th>Mech Model</th>
                    <th>Armor</th>
                    <th>Movement</th>
                    <th>Tonnage</th>
                    <th>Intro Date</th>
                </tr>
                ${mechPickRowContent}
            </table>
        `;

        document.getElementById("mechSelect").innerHTML = mechPickerTable;
    });
}

function getMechPartSlots(mechPart, leftRight) {
    let leftRightMod = "";
    if (leftRight === 0) {
        leftRightMod = "Left";
    } else if (leftRight === 1) {
        leftRightMod = "Right";
    }
    let finalPrefix = mechPart + leftRightMod + "_";

    const critDetailsUnsorted = Object.fromEntries(
        Object.entries(fullMechData).filter((key, val) => {
            return key[0].indexOf(finalPrefix) === 0 && key[0].includes("_slot");
        })
    );

    const sortedKeys = Object.keys(critDetailsUnsorted).sort((a, b) => {
        const numA = parseInt(a.match(/slot(\d+)/)[1], 10);
        const numB = parseInt(b.match(/slot(\d+)/)[1], 10);
        return numA - numB;
    });

    // Rebuild the object with sorted keys
    const critDetails = Object.fromEntries(sortedKeys.map((key) => [key, critDetailsUnsorted[key]]));

    return critDetails;
}

/* EXAMPLE pageload calls to this function */
// displayCrits("leftArmCritTable", "mecharm", 0);
// displayCrits("rightArmCritTable", "mecharm", 1);
// displayCrits("headCritTable", "mechhead", 2);
// displayCrits("leftTorsoCritTable", "mechtorso", 0);
// displayCrits("rightTorsoCritTable", "mechtorso", 1);
// displayCrits("leftLegCritTable", "mechleg", 0);
// displayCrits("rightLegCritTable", "mechleg", 1);
// displayCrits("centerCritTable", "mechtorsocenter", 2);
function displayCrits(idToMod, mechPart, leftRight) {
    let weaponSlotsAvailToEval = weaponSlotsAvail();
    let numUnmovable = weaponSlotsAvailToEval[mechPart];

    const critDetails = getMechPartSlots(mechPart, leftRight);

    var myNode = document.getElementById(idToMod);
    while (myNode.firstChild) {
        myNode.removeChild(myNode.firstChild);
    }

    let counter = numUnmovable;
    for (var key in critDetails) {
        var TR = document.createElement("tr");
        TR.className = "dropSlots";
        var TD = document.createElement("td");
        TD.className = "dropSlotsTD";
        TD.innerHTML = critDetails[key];

        if (critDetails[key] == "overflow") {
            TD.innerHTML = "&#8595" + "&nbsp&nbsp&nbsp" + "&#8595" + "&nbsp&nbsp&nbsp" + "&#8595";
            TD.className = "dropSlotsUnmovable";
        }
        if (critDetails[key] == "") {
            TD.className = "dropSlotsUnmovable";
        }
        if (counter > 0) {
            // TD.className = "dropSlotsUnmovable";
            TD.style.backgroundColor = "#FFAC30";
        }

        TD.style.textOverflow = "visible";
        TD.style.whiteSpace = "nowrap";

        document.getElementById(idToMod).appendChild(TR).appendChild(TD);
        counter--;
    }

    // This function has to be called here bc it can only be made
    // droppable after being created.
    makeDroppable();
}

function updateCrits(mechPart, leftRight, critToAdd, addRemove, containerID, rowIndex = false) {
    console.log(mechPart, leftRight, critToAdd, addRemove, containerID);

    let critDetails = getMechPartSlots(mechPart, leftRight);
    console.log(critDetails);

    let TotalSlotsAvailable = parseInt(Object.keys(critDetails).length, 10);
    let slotsUnused = parseInt(Object.values(critDetails).filter((value) => !Boolean(value)).length, 10);
    let slotsUsed = parseInt(Object.values(critDetails).filter(Boolean).length, 10);
    let tonnageSlotsAvail = parseInt(weaponSlotsAvail()[mechPart], 10);
    let critToAddDetails = dataByWeaponName[critToAdd];
    let critToAddSlots = parseInt(critToAddDetails.slotsRequired, 10);
    let critToAddTons = parseInt(critToAddDetails.tons, 10);

    if (addRemove === "remove") {
        fullMechData.mechinternals_weaponTonnage -= critToAddTons;
        fullMechData.mechinternals_totalInternalTonnage -= critToAddTons;

        let critEntryDeleted = false;
        for (let [compKey, slotCompVal] of Object.entries(critDetails)) {
            if (parseInt(compKey.replace(/\D/g, ""), 10) === rowIndex) {
                critDetails[compKey] = "";
                critEntryDeleted = true;
                critToAddSlots--;
            } else if (critEntryDeleted && slotCompVal === "overflow" && critToAddSlots > 0) {
                critDetails[compKey] = "";
            } else if (critEntryDeleted && slotCompVal !== "overflow") {
                break;
            }
        }
        let shiftedSlots = shiftSlots(critDetails);
        for (let [compKey, slotCompVal] of Object.entries(shiftedSlots)) {
            fullMechData[compKey] = slotCompVal;
        }
        displayCrits(containerID, mechPart, leftRight);
        updateTonnage();
    } else if (critToAddSlots <= tonnageSlotsAvail - slotsUsed) {
        fullMechData.mechinternals_weaponTonnage += critToAddTons;
        fullMechData.mechinternals_totalInternalTonnage += critToAddTons;

        let critToAddSlotsCopy = critToAddSlots;
        for (let [compKey, slotCompVal] of Object.entries(critDetails)) {
            if (slotCompVal === "" && critToAddSlotsCopy > 0) {
                fullMechData[compKey] = critToAddSlotsCopy === critToAddSlots ? critToAdd : "overflow";
                critToAddSlotsCopy--;
            }
        }
        displayCrits(containerID, mechPart, leftRight);
        updateTonnage();
    }
}

function displayAllCrits() {
    displayCrits("leftArmCritTable", "mecharm", 0);
    displayCrits("rightArmCritTable", "mecharm", 1);
    displayCrits("headCritTable", "mechhead", 2);
    displayCrits("leftTorsoCritTable", "mechtorso", 0);
    displayCrits("rightTorsoCritTable", "mechtorso", 1);
    displayCrits("leftLegCritTable", "mechleg", 0);
    displayCrits("rightLegCritTable", "mechleg", 1);
    displayCrits("centerCritTable", "mechtorsocenter", 2);
}

$(document).ready(function () {
    // Build out heatsink options for our dropdown for this
    var heatSinkNumOptions2 = [];
    for (var i = 10; i <= 65; i++) {
        heatSinkNumOptions2[i] = document.createElement("option");
        heatSinkNumOptions2[i].text = i;
        heatSinkNumOptions2[i].value = i;
        heatSinkNumOptions2[i].id = i;
        document.getElementById("heatSinkNumDropDown").appendChild(heatSinkNumOptions2[i]);
    }

    // Build out engine tonnage options (once)
    for (var i = 20; i <= 100; i += 5) {
        var option = document.createElement("option");
        option.text = i;
        option.value = i;
        option.id = "mechTonnageSelect_" + i;
        document.getElementById("mechTonnageDropDown").appendChild(option);
    }

    // Get static weapon data
    $.getJSON("php/getMechWeapons.php", (res) => {
        dataByWeaponName = res[0];
        weaponArray = res[1];
    });

    // Get static data on max armor
    $.getJSON("php/getMaxArmorChart.php", (res) => {
        armorCharts = res;
    });

    // FN to get all data for the mech in one call
    getFullMechData = function () {
        // Get all data representing the full mech
        $.getJSON("php/getFullMechDetails.php", function (mechData) {
            fullMechData = mechData; // Set globally
            console.log(mechData);

            // Proceed to build out the views
            updateMechMeta(mechData);
            displayArmorSection("mechArmor", mechData);
            updateHeatSinksJSON();
            updateEngine();
            changeMechInternalTonnage(mechData.mechs_maxTonnage);
            displayAllCrits();
        });
    };
    getFullMechData(); // Called on page load

    $(".weaponChildLI").click(function () {
        var weaponName = $(this).attr("name");
        let weaponDetails = dataByWeaponName[weaponName];

        // DELETE THE PREVIOUS DATA
        var myNode = document.getElementById("weaponDetails");
        while (myNode.firstChild) {
            myNode.removeChild(myNode.firstChild);
        }

        for (var key in weaponDetails) {
            var TD = document.createElement("td");
            TD.innerHTML = weaponDetails[key];
            document.getElementById("weaponDetails").appendChild(TD);
        }
    });

    $(".weaponAccordionLI").click(function () {
        if (!$(this).children().is(":visible")) {
            $(this).parent().children().children().slideUp();
            $(this).children().slideDown();
        }
    });

    $(".weaponAccordionLI").hover(
        function () {
            $(this).addClass("highlighted");
        },
        function () {
            $(this).removeClass("highlighted");
        }
    );

    $(".weaponChildLI").hover(
        function () {
            $(this).addClass("weaponHighlight");
        },
        function () {
            $(this).removeClass("weaponHighlight");
        }
    );

    $(".selector").hover(
        function () {
            $(this).addClass("highlighted2");
        },
        function () {
            $(this).removeClass("highlighted2");
        }
    );

    function hidePopouts(iden) {
        if (iden !== 1) {
            $(".popoutTab").hide();
            $("#mechSelector").removeClass("highlighted3");
        }
        if (iden !== 2) {
            $(".popoutTab2").hide();
            $("#armorSelector").removeClass("highlighted3");
        }
        if (iden !== 3) {
            $(".popoutTab3").hide();
            $("#weaponSelector").removeClass("highlighted3");
        }
        if (iden !== 4) {
            $(".popoutTab4").hide();
            $("#criticalSelector").removeClass("highlighted3");
        }

        if ($(".selector").hasClass("highlighted3")) {
            $("#navBar").removeClass("blur");
            $("#footer").removeClass("blur");
        }
    }

    $(document).mouseup(function (e) {
        var container = $(".popoutClass");
        var container2 = $(".selector");

        if (
            !container.is(e.target) &&
            !container2.is(e.target) && // if the target of the click isn't the container or button
            container.has(e.target).length === 0
        ) {
            // ... nor a descendant of the container
            container.hide("200");
            $("#navBar").removeClass("blur");
            $("#footer").removeClass("blur");
            container2.removeClass("highlighted3");
            $(".navBarLink").css("pointer-events", "auto");
            $(".weaponAccordionLI").children().slideUp(); // Hide any open accordion tabs from the weapons page.
        } else {
            if (!$("#navBar").hasClass("blur")) {
                $("#navBar").addClass("blur");
                $("#footer").addClass("blur");
                $(".navBarLink").css("pointer-events", "none");
            }
            if ($("#mechSelector").is(e.target)) {
                // If they click the button again
                hidePopouts(1);
                $(".popoutTab").slideToggle("slow");
                $("#mechSelector").toggleClass("highlighted3");
            } else if ($("#armorSelector").is(e.target)) {
                // If they click the button again
                hidePopouts(2);
                $(".popoutTab2").slideToggle("slow");
                $("#armorSelector").toggleClass("highlighted3");
            } else if ($("#weaponSelector").is(e.target)) {
                // If they click the button again
                hidePopouts(3);
                $(".popoutTab3").slideToggle("slow");
                $("#weaponSelector").toggleClass("highlighted3");
            } else if ($("#criticalSelector").is(e.target)) {
                // If they click the button again
                hidePopouts(4);
                $(".popoutTab4").slideToggle("slow");
                $("#criticalSelector").toggleClass("highlighted3");
            }
        }
    });
});

function changeMechStats(armorLocation, incDec, armorUpdateID) {
    var linked = "yes";
    if (!$("#mirrorArmorBox").is(":checked")) {
        linked = "no";
    }

    // Example args passed to this function
    // 'headArmor' 'increase' 'head' 'yes'

    // Example data from mechFullData we utilize in this function
    /*
        "mechexternalarmor_armLeftArmor": 4,
        "mechexternalarmor_armRightArmor": 4,
        "mechexternalarmor_centerArmor": 4,
        "mechexternalarmor_headArmor": 4,
        "mechexternalarmor_id": 2,
        "mechexternalarmor_legLeftArmor": 4,
        "mechexternalarmor_legRightArmor": 4,
        "mechexternalarmor_mechArmorTotal": 100,
        "mechexternalarmor_mechID": 2,
        "mechexternalarmor_rearCenterArmor": 4,
        "mechexternalarmor_rearLeftTorsoArmor": 4,
        "mechexternalarmor_rearRightTorsoArmor": 4,
        "mechexternalarmor_torsoLeftArmor": 4,
        "mechexternalarmor_torsoRightArmor": 4,
    */

    // Fetch the necessary data from the fullMechData object
    let mechData = fullMechData;
    let maxTonnage = mechData.mechs_maxTonnage;

    let tonArmor = armorCharts[maxTonnage];
    let maxTorsoArmor = tonArmor.torsoMax;
    let maxArmArmor = tonArmor.armMax;
    let maxLegArmor = tonArmor.legMax;
    let maxCenterArmor = tonArmor.centerTorsoMax;

    let armorLocation2;
    let altArmorLocation;
    let altArmorLocation2;
    let maxArmor;
    let revAltArmor = 0;

    if (armorLocation == "torsoLeftArmor") {
        maxArmor = maxTorsoArmor;
        altArmorLocation = "torsoRightArmor";
        revAltArmor = fullMechData.mechexternalarmor_rearLeftTorsoArmor;
        armorLocation2 = "rearLeftTorsoArmor";
        altArmorLocation2 = "rearRightTorsoArmor";
    } else if (armorLocation == "torsoRightArmor") {
        maxArmor = maxTorsoArmor;
        altArmorLocation = "torsoLeftArmor";
        revAltArmor = fullMechData.mechexternalarmor_rearRightTorsoArmor;
        armorLocation2 = "rearRightTorsoArmor";
        altArmorLocation2 = "rearLeftTorsoArmor";
    } else if (armorLocation == "legLeftArmor") {
        maxArmor = maxLegArmor;
        altArmorLocation = "legRightArmor";
    } else if (armorLocation == "legRightArmor") {
        maxArmor = maxLegArmor;
        altArmorLocation = "legLeftArmor";
    } else if (armorLocation == "armLeftArmor") {
        maxArmor = maxArmArmor;
        altArmorLocation = "armRightArmor";
    } else if (armorLocation == "armRightArmor") {
        maxArmor = maxArmArmor;
        altArmorLocation = "armLeftArmor";
    } else if (armorLocation == "rearLeftTorsoArmor") {
        maxArmor = maxTorsoArmor;
        altArmorLocation = "rearRightTorsoArmor";
        revAltArmor = fullMechData.mechexternalarmor_torsoLeftArmor;
        armorLocation2 = "torsoLeftArmor";
        altArmorLocation2 = "torsoRightArmor";
    } else if (armorLocation == "rearRightTorsoArmor") {
        maxArmor = maxTorsoArmor;
        altArmorLocation = "rearLeftTorsoArmor";
        revAltArmor = fullMechData.mechexternalarmor_torsoRightArmor;
        armorLocation2 = "torsoRightArmor";
        altArmorLocation2 = "torsoLeftArmor";
    } else if (armorLocation == "centerArmor") {
        maxArmor = maxCenterArmor;
        revAltArmor = fullMechData.mechexternalarmor_rearCenterArmor;
        linked = "no";
        armorLocation2 = "rearCenterArmor";
    } else if (armorLocation == "rearCenterArmor") {
        maxArmor = maxCenterArmor;
        revAltArmor = fullMechData.mechexternalarmor_centerArmor;
        linked = "no";
        armorLocation2 = "centerArmor";
    } else if (armorLocation == "headArmor") {
        maxArmor = 9;
        linked = "no";
    }

    let armorLocationMod = 1;
    if (incDec == "decrease") {
        if (fullMechData["mechexternalarmor_" + armorLocation] > 1) {
            armorLocationMod = -1;
        } else {
            armorLocationMod = 0;
        }
    }

    if (fullMechData["mechexternalarmor_" + armorLocation] < maxArmor) {
        updateArmor(armorLocation, armorLocationMod, linked, altArmorLocation);
    } else if (fullMechData["mechexternalarmor_" + armorLocation] >= maxArmor && incDec == "decrease") {
        updateArmor(armorLocation, armorLocationMod, linked, altArmorLocation);
    }

    if (revAltArmor) {
        let armorThis = fullMechData["mechexternalarmor_" + armorLocation];

        if (revAltArmor + armorThis > maxArmor) {
            updateArmor(armorLocation2, -1, linked, altArmorLocation2);
        }

        if (altArmorLocation2) {
            revAltArmor = fullMechData["mechexternalarmor_" + altArmorLocation2];
            armorThis = fullMechData["mechexternalarmor_" + altArmorLocation];

            if (revAltArmor + armorThis > maxArmor) {
                updateArmor(altArmorLocation2, -1, linked, armorLocation2);
            }
        }
    }

    function updateArmor(armorLocation, armorLocationMod, linked, altArmorLocation) {
        fullMechData["mechexternalarmor_" + armorLocation] =
            fullMechData["mechexternalarmor_" + armorLocation] + armorLocationMod;

        if (linked == "yes") {
            fullMechData["mechexternalarmor_" + altArmorLocation] = fullMechData["mechexternalarmor_" + armorLocation];
        }
    }

    fullMechData.mechexternalarmor_mechArmorTotal =
        fullMechData.mechexternalarmor_torsoLeftArmor +
        fullMechData.mechexternalarmor_torsoRightArmor +
        fullMechData.mechexternalarmor_legLeftArmor +
        fullMechData.mechexternalarmor_legRightArmor +
        fullMechData.mechexternalarmor_armLeftArmor +
        fullMechData.mechexternalarmor_armRightArmor +
        fullMechData.mechexternalarmor_rearLeftTorsoArmor +
        fullMechData.mechexternalarmor_rearRightTorsoArmor +
        fullMechData.mechexternalarmor_centerArmor +
        fullMechData.mechexternalarmor_rearCenterArmor +
        fullMechData.mechexternalarmor_headArmor;

    displayArmorSection("mechArmor", fullMechData);
    updateTonnage();
}

function updateTonnage() {
    // Example data from mechFullData we utilize in this function
    /*
        "mechexternalarmor_armLeftArmor": 4,
        "mechexternalarmor_armRightArmor": 4,
        "mechexternalarmor_centerArmor": 4,
        "mechexternalarmor_headArmor": 4,
        "mechexternalarmor_id": 2,
        "mechexternalarmor_legLeftArmor": 4,
        "mechexternalarmor_legRightArmor": 4,
        "mechexternalarmor_mechArmorTotal": 100,
        "mechexternalarmor_mechID": 2,
        "mechexternalarmor_rearCenterArmor": 4,
        "mechexternalarmor_rearLeftTorsoArmor": 4,
        "mechexternalarmor_rearRightTorsoArmor": 4,
        "mechexternalarmor_torsoLeftArmor": 4,
        "mechexternalarmor_torsoRightArmor": 4,
    */

    let internalWeight = fullMechData.mechinternals_totalInternalTonnage;
    let externalArmor = fullMechData.mechexternalarmor_mechArmorTotal;
    let maxTonnage = fullMechData.mechs_maxTonnage;
    let externalArmorWeight = Math.ceil(externalArmor / 8) / 2;
    let totalWeight = externalArmorWeight + internalWeight;

    if (totalWeight > maxTonnage) {
        document.getElementById("totalWeight").style.color = "red";
        document.getElementById("totalWeightArmorPage").style.color = "red";
    } else {
        document.getElementById("totalWeight").style.color = "white";
        document.getElementById("totalWeightArmorPage").style.color = "black";
    }

    document.getElementById("totalWeight").innerHTML =
        "<strong>Current Tonnage:</strong> " + totalWeight + "/" + maxTonnage;
    document.getElementById("totalWeightArmorPage").innerHTML =
        "<strong>Current Tonnage:</strong> " + totalWeight + "/" + maxTonnage;
}

$(document).ready(function () {
    $(".weaponChildLI").draggable({
        revert: true,
        revertDuration: 0,
        cursor: "move",
        start: function (event, ui) {
            $(this).toggleClass("draggingWeapon");
            $(this).css("width", "80px");

            mousePos = event.pageX - 224;
            $(this).css("margin-left", mousePos);
        },
        stop: function (event, ui) {
            $(this).toggleClass("draggingWeapon");
            $(this).css("margin-left", "0px");
            $(this).css("width", "auto");
            $(this).css("height", "auto");
        },
    });
});

// THIS FUNCTION MAKES THE CRIT CONTAINERS DROPPABLE BUT HAS TO BE CALLED AFTER
// THOSE CONTAINERS ARE MADE DYNAMICALLY.
function makeDroppable() {
    $(".dropSlots").droppable({
        tolerance: "pointer",
        accept: ".weaponChildLI",

        drop: function (event, ui) {
            ui.draggable.data("dropped", true);

            containerID = $(this).parent().attr("id");
            if (containerID == "headCritTable") {
                modLocation = "mechhead";
                altLocation = 2;
            } else if (containerID == "leftArmCritTable") {
                modLocation = "mecharm";
                altLocation = 0;
            } else if (containerID == "rightArmCritTable") {
                modLocation = "mecharm";
                altLocation = 1;
            } else if (containerID == "leftTorsoCritTable") {
                modLocation = "mechtorso";
                altLocation = 0;
            } else if (containerID == "rightTorsoCritTable") {
                modLocation = "mechtorso";
                altLocation = 1;
            } else if (containerID == "centerCritTable") {
                modLocation = "mechtorsocenter";
                altLocation = 2;
            } else if (containerID == "leftLegCritTable") {
                modLocation = "mechleg";
                altLocation = 0;
            } else if (containerID == "rightLegCritTable") {
                modLocation = "mechleg";
                altLocation = 1;
            }

            updateCrits(modLocation, altLocation, $(ui.draggable).html(), "add", containerID);
        },
    });

    $(".dropSlotsTD").draggable({
        revert: true,
        revertDuration: 0,
        cursor: "move",
        start: function (event, ui) {
            $(this).toggleClass("draggingWeapon");
            $(this).css("display", "block");
        },
        stop: function (event, ui) {
            $(this).toggleClass("draggingWeapon");
            const rowIndex = parseInt($(this).parent().index(), 10) + 1;

            containerID = $(this).parent().parent().attr("id");
            if (containerID == "headCritTable") {
                modLocation = "mechhead";
                altLocation = 2;
            } else if (containerID == "leftArmCritTable") {
                modLocation = "mecharm";
                altLocation = 0;
            } else if (containerID == "rightArmCritTable") {
                modLocation = "mecharm";
                altLocation = 1;
            } else if (containerID == "leftTorsoCritTable") {
                modLocation = "mechtorso";
                altLocation = 0;
            } else if (containerID == "rightTorsoCritTable") {
                modLocation = "mechtorso";
                altLocation = 1;
            } else if (containerID == "centerCritTable") {
                modLocation = "mechtorsocenter";
                altLocation = 2;
            } else if (containerID == "leftLegCritTable") {
                modLocation = "mechleg";
                altLocation = 0;
            } else if (containerID == "rightLegCritTable") {
                modLocation = "mechleg";
                altLocation = 1;
            }

            updateCrits(modLocation, altLocation, $(this).html(), "remove", containerID, rowIndex);
            $(this).remove();
        },
    });
}

$(document).on("click", ".upMovementArrow", function () {
    $(this)
        .prev()
        .val(parseInt($(this).prev().val(), 10) + 1);

    fullMechData.mechengine_mechWalk = $("#mechWalk").find(".movementValues").val();
    fullMechData.mechengine_mechRun = Math.ceil(fullMechData.mechengine_mechWalk * 1.5);
    $("#mechRun").find(".movementValues").val(fullMechData.mechengine_mechRun);
    fullMechData.mechengine_mechJump = $("#mechJump").find(".movementValues").val();
    updateEngine(false);
});

$(document).on("click", ".downMovementArrow", function () {
    let walkJumpMin = $(this).attr("id") === "downArrowWalk" ? 1 : 0;
    let prevNum = parseInt($(this).prev().prev().val(), 10);
    prevNum = prevNum - 1;
    prevNum = Math.max(prevNum, walkJumpMin);
    $(this).prev().prev().val(prevNum);

    fullMechData.mechengine_mechWalk = $("#mechWalk").find(".movementValues").val();
    fullMechData.mechengine_mechRun = Math.ceil(fullMechData.mechengine_mechWalk * 1.5);
    $("#mechRun").find(".movementValues").val(fullMechData.mechengine_mechRun);
    fullMechData.mechengine_mechJump = $("#mechJump").find(".movementValues").val();
    updateEngine(false);
});

$(document).on("click", ".submitChanges, #criticalSelector", (e) => {
    e.stopPropagation();
    e.preventDefault();

    fullMechData.mechs_mechName = $("input[name='mechName']").val();
    fullMechData.mechs_mechModel = $("input[name='mechModel']").val();
    console.log(fullMechData);

    $.ajax({
        url: "php/updateFullMechDetails.php",
        type: "POST",
        dataType: "json",
        contentType: "application/json",
        data: JSON.stringify(fullMechData), // Convert the object to a JSON string
        success: function (response) {
            console.log(response);
            if (response.success) {
                console.log("Mech data saved successfully:", response.mechId);
                const newURL = new URL(window.location.href); // Create a URL object with the current URL
                newURL.searchParams.set("mechIDPassed", response.mechId); // Set or update the 'mechIDPassed' parameter
                // Update the URL in the browser without reloading the page
                window.history.replaceState(null, "", newURL.toString());
            } else if (response.error) {
                console.error("Error:", response.error);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX request failed:", status, error);
        },
    });
});
