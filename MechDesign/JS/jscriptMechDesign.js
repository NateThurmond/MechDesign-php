var getFullMechData; // FN to return full mech data
var fullMechData = {}; // Returned from db on page load from above fn

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
    if (swapHeatSyncType === true) {
        fullMechData.mechinternals_heatSinkType =
            fullMechData.mechinternals_heatSinkType === "Singles" ? "Doubles" : "Singles";
    }
    if (newHeatSyncNum !== -1) {
        fullMechData.mechinternals_heatSinksNum = newHeatSyncNum;
    }

    $("#heatSinkTypeDropDown").val(fullMechData.mechinternals_heatSinkType);
    $("#heatSinkNumDropDown").val(fullMechData.mechinternals_heatSinksNum);
    let heatSinkMulti = $("#heatSinkTypeDropDown").val() === "Singles" ? 1 : 2;
    $("#heatDissipation").html(heatSinkMulti * parseInt($("#heatSinkNumDropDown").val(), 10));
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
}

function changeMechTotalTonnage(mechWeight) {
    fullMechData.mechs_maxTonnage = mechWeight;
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
            updateEngineTonnageJSON();
        });
    };
    getFullMechData(); // Called on page load

    // updateArmor("mechArmor");
    // updateTonnage();

    function displayAllCrits() {
        displayCrits("leftArmCritTable", "mecharm", 0, "one", 4);
        displayCrits("rightArmCritTable", "mecharm", 1, "two", 4);
        displayCrits("headCritTable", "mechhead", 2, "three", 5);
        displayCrits("leftTorsoCritTable", "mechtorso", 0, "four", 0);
        displayCrits("rightTorsoCritTable", "mechtorso", 1, "five", 0);
        displayCrits("leftLegCritTable", "mechleg", 0, "six", 4);
        displayCrits("rightLegCritTable", "mechleg", 1, "eight", 4);
        displayCrits("centerCritTable", "mechtorsocenter", 2, "nine", 10);
    }
    displayAllCrits();

    $(".weaponChildLI").click(function () {
        var weaponName = $(this).attr("name");

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp7 = new XMLHttpRequest();
        }
        xmlhttp7.onreadystatechange = function () {
            if (xmlhttp7.readyState === 4 && xmlhttp7.status === 200) {
                var weaponDetails = JSON.parse(xmlhttp7.response);

                // DELETE THE PREVIOUS DATA
                var myNode = document.getElementById("weaponDetails");
                while (myNode.firstChild) {
                    myNode.removeChild(myNode.firstChild);
                }

                for (var key in weaponDetails) {
                    var TD = document.createElement("td");
                    //TD.text = weaponDetails[key];
                    //TD.value = weaponDetails[key];
                    //TD.class = "dropSlots";
                    TD.innerHTML = weaponDetails[key];
                    document.getElementById("weaponDetails").appendChild(TD);
                }
            }
        };
        xmlhttp7.open("GET", "php/showWeaponInfo.php?weaponName=" + weaponName, true);
        xmlhttp7.send();
    });

    $(".weaponAccordionLI").click(function () {
        if (!$(this).children().is(":visible")) {
            $(this).parent().children().children().slideUp();
            $(this).children().slideDown();
        }
        // TOOK THIS OUT SO MENU DOESNT DISSAPEAR WHEN CLICKING ON WEAPON
        /*else {
            $(this).children().slideUp();
        }*/
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

    /*  MIGHT NOT NEED
    $('.downMovementArrow').hover(
        
        function() {
            $('.downMovementArrow').css('pointer-events', 'auto');
        }
    );
    */

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
            //$('#main').removeClass('blur');     //WANT TO ADD BUT SLOWING DOWN PAGE
            container2.removeClass("highlighted3");
            $(".navBarLink").css("pointer-events", "auto");
            $(".weaponAccordionLI").children().slideUp(); // Hide any open accordion tabs from the weapons page.
        } else {
            if (!$("#navBar").hasClass("blur")) {
                $("#navBar").addClass("blur");
                $("#footer").addClass("blur");
                //$('#main').toggleClass('blur');    //WANT TO ADD BUT SLOWING DOWN PAGE
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

// function updateArmor(displayLocation) {
//     getFullMechData();
// }

function changeMechStats(mechID, armorLocation, incDec, armorUpdateID) {
    var linked = "yes";

    if (!$("#mirrorArmorBox").is(":checked")) {
        linked = "no";
    }

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp2 = new XMLHttpRequest();
    }
    xmlhttp2.onreadystatechange = function () {
        if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
            //document.getElementById("test2").innerHTML=xmlhttp2.responseText;
            // updateArmor(armorUpdateID);
            // updateTonnage();
        }
    };

    xmlhttp2.open(
        "GET",
        "php/getMechData.php?mechIdPassed=" +
            mechID +
            "&incArm=" +
            incDec +
            "&armorLocation=" +
            armorLocation +
            "&linked=" +
            linked,
        true
    );
    xmlhttp2.send();
}

function updateTonnage() {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp6 = new XMLHttpRequest();
    }
    xmlhttp6.onreadystatechange = function () {
        if (xmlhttp6.readyState === 4 && xmlhttp6.status === 200) {
            var tonnageDataJSON = JSON.parse(xmlhttp6.response);

            if (tonnageDataJSON.totalWeight > tonnageDataJSON.maxTonnage) {
                document.getElementById("totalWeight").style.color = "red";
                document.getElementById("totalWeightArmorPage").style.color = "red";
            } else {
                document.getElementById("totalWeight").style.color = "white";
                document.getElementById("totalWeightArmorPage").style.color = "black";
            }

            document.getElementById("totalWeight").innerHTML =
                "<strong>Current Tonnage:</strong> " + tonnageDataJSON.totalWeight + "/" + tonnageDataJSON.maxTonnage;
            document.getElementById("totalWeightArmorPage").innerHTML =
                "<strong>Current Tonnage:</strong> " + tonnageDataJSON.totalWeight + "/" + tonnageDataJSON.maxTonnage;
        }
    };

    xmlhttp6.open("GET", "php/getMechTonnage.php", true);
    xmlhttp6.send();
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
            //$(this).removeClass('draggingWeapon');
            //$(this).addClass('weaponChild');
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

        /* over: function(event, ui) {
                 //$('.ui-draggable-dragging').removeClass('weaponHighlight');
                 //$('.weaponAccordionLI').removeClass('highlighted');
         //$('.ui-draggable-dragging').addClass('highlighted2');
     },*/

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

            //prompt($(this).parent().attr('id'));
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
            //$(this).removeClass('draggingWeapon');
            //$(this).addClass('weaponChild');
            $(this).toggleClass("draggingWeapon");

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

            //prompt(containerID);
            //prompt($(this).html());
            updateCrits(modLocation, altLocation, $(this).html(), "remove", containerID);
            $(this).remove();
        },
    });
}

$(document).on("click", ".submitChanges", (e) => {
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
