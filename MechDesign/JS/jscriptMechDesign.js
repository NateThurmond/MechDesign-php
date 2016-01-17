
$(document).ready(function () {

    var heatSinkNumOptions2 = [];
    for (var i = 10; i <= 65; i++) {
        heatSinkNumOptions2[i] = document.createElement("option");
        heatSinkNumOptions2[i].text = i;
        heatSinkNumOptions2[i].value = i;
        heatSinkNumOptions2[i].id = i;
        document.getElementById("heatSinkNumDropDown").appendChild(heatSinkNumOptions2[i]);
    }
    
    /* These calls retrieve the initial values for Armor and engine for the mechs on page load.
       passing 1 to updateEngine() tells it that we are not updating the engine type.
    */
    updateArmor("mechArmor");
    updateHeatSinksJSON(false);
    updateTonnage();
    updateEngine(1);
    
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
    
    $('.weaponChildLI').click(function() {
       var weaponName = $(this).attr('name');
       
       if (window.XMLHttpRequest) {    // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp7=new XMLHttpRequest();
        }
        xmlhttp7.onreadystatechange=function() {
            if (xmlhttp7.readyState===4 && xmlhttp7.status===200) {
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
        xmlhttp7.open("GET","php/showWeaponInfo.php?weaponName="+weaponName, true);
        xmlhttp7.send();
    });
    
    $('.weaponAccordionLI').click(function() {
        
       if (!$(this).children().is(":visible")) {
           $(this).parent().children().children().slideUp();
           $(this).children().slideDown();
       }
       // TOOK THIS OUT SO MENU DOESNT DISSAPEAR WHEN CLICKING ON WEAPON
       /*else {
           $(this).children().slideUp();
       }*/
    });
    
    $('.weaponAccordionLI').hover(
        function() {
            $(this).addClass('highlighted');
        },
        function() {
            $(this).removeClass('highlighted');
        }
    );
    
    $('.weaponChildLI').hover(
        function() {
            $(this).addClass('weaponHighlight');
        },
        function() {
            $(this).removeClass('weaponHighlight');
        }
    );

    $('.selector').hover(
        
        function() {
            $(this).addClass('highlighted2');
        },
        function() {
            $(this).removeClass('highlighted2');
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
        if (iden !== 1) { $('.popoutTab').hide(); $('#mechSelector').removeClass('highlighted3'); }
        if (iden !== 2) { $('.popoutTab2').hide(); $('#armorSelector').removeClass('highlighted3'); }
        if (iden !== 3) { $('.popoutTab3').hide(); $('#weaponSelector').removeClass('highlighted3'); }
        if (iden !== 4) { $('.popoutTab4').hide(); $('#criticalSelector').removeClass('highlighted3'); }
        
        if ($('.selector').hasClass('highlighted3')) {
            $('#navBar').removeClass('blur');
            $('#footer').removeClass('blur');
        }
    }
        
    $(document).mouseup(function (e) {
        var container = $('.popoutClass');
        var container2 = $('.selector');

        if ((!container.is(e.target) && !container2.is(e.target) // if the target of the click isn't the container or button
        && container.has(e.target).length === 0)) // ... nor a descendant of the container
        {
            container.hide('200');
            $('#navBar').removeClass('blur');
            $('#footer').removeClass('blur');
            //$('#main').removeClass('blur');     //WANT TO ADD BUT SLOWING DOWN PAGE
            container2.removeClass('highlighted3');
            $('.navBarLink').css('pointer-events', 'auto');
            $('.weaponAccordionLI').children().slideUp(); // Hide any open accordion tabs from the weapons page.
        }
        else {
            
            if (!$('#navBar').hasClass('blur')) {
                $('#navBar').addClass('blur');
                $('#footer').addClass('blur');
                //$('#main').toggleClass('blur');    //WANT TO ADD BUT SLOWING DOWN PAGE
                $('.navBarLink').css('pointer-events', 'none');
            }
            if ($('#mechSelector').is(e.target)) { // If they click the button again
                hidePopouts(1);
                $('.popoutTab').slideToggle('slow');
                $('#mechSelector').toggleClass('highlighted3');
            }
            else if ($('#armorSelector').is(e.target)) { // If they click the button again
                hidePopouts(2);
                $('.popoutTab2').slideToggle('slow');
                $('#armorSelector').toggleClass('highlighted3');
            }
            else if ($('#weaponSelector').is(e.target)) { // If they click the button again
                hidePopouts(3);
                $('.popoutTab3').slideToggle('slow');
                $('#weaponSelector').toggleClass('highlighted3');
            }
            else if ($('#criticalSelector').is(e.target)) { // If they click the button again
                hidePopouts(4);
                $('.popoutTab4').slideToggle('slow');
                $('#criticalSelector').toggleClass('highlighted3');
            }
        }
    });    
});


    function updateArmor(displayLocation) {
        
        /*if (displayLocation == "arm") {
            alert("click");
        }*/

        if (window.XMLHttpRequest) {    // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState===4 && xmlhttp.status===200) {
                //alert(xmlhttp.responseText); // Error Checking, shows what will be displayed as html.
                document.getElementById(displayLocation).innerHTML=xmlhttp.responseText;
                //alert(xmlhttp.responseText);
            }
        };
        
        xmlhttp.open("GET","php/getMechArmor.php?displayLocation="+displayLocation, true);
        xmlhttp.send();

        // HAVE TO INCLUDE THIS LINE, SOMETIMES innerHTML DOES NOT REFRESH
        //$('#head').load("php/getMechArmor.php");
        
    }

    function changeMechStats(mechID, armorLocation, incDec, armorUpdateID) {
        
        var linked = 'yes';
        
        if (!$('#mirrorArmorBox').is(":checked")) {
            linked = 'no';
        }
        
        if (window.XMLHttpRequest) {    // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp2=new XMLHttpRequest();
        }
        xmlhttp2.onreadystatechange=function() {
            if (xmlhttp2.readyState==4 && xmlhttp2.status==200) {
                //document.getElementById("test2").innerHTML=xmlhttp2.responseText;
                updateArmor(armorUpdateID);
                updateTonnage();
            }
        }
        
        xmlhttp2.open("GET","php/getMechData.php?mechIdPassed="+mechID+"&incArm="+incDec+"&armorLocation="+armorLocation+"&linked="+linked, true);
        xmlhttp2.send();
    }
            
    function updateEngine(updatedEngine) {
                
        if (window.XMLHttpRequest) {    // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp3=new XMLHttpRequest();
        }
        xmlhttp3.onreadystatechange=function() {
            if (xmlhttp3.readyState===4 && xmlhttp3.status===200) {
                document.getElementById("mechEngineDetails").innerHTML=xmlhttp3.responseText;
                updateEngineTonnageJSON();
            }
        };

        if (updatedEngine === 1) {
            xmlhttp3.open("GET","php/getMechEngineData.php",true);
            xmlhttp3.send();
        }
        else {
            xmlhttp3.open("GET","php/getMechEngineData.php?updatedEngine="+updatedEngine,true);
            xmlhttp3.send();
        }
    }
    
    
    function updateTonnage() {
    
        if (window.XMLHttpRequest) {    // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp6=new XMLHttpRequest();
        }
        xmlhttp6.onreadystatechange=function() {
            if (xmlhttp6.readyState===4 && xmlhttp6.status===200) {
                var tonnageDataJSON = JSON.parse(xmlhttp6.response);
                
                if (tonnageDataJSON.totalWeight > tonnageDataJSON.maxTonnage) {
                    document.getElementById("totalWeight").style.color = "red";
                    document.getElementById("totalWeightArmorPage").style.color = "red";
                }
                else {
                    document.getElementById("totalWeight").style.color = "white";
                    document.getElementById("totalWeightArmorPage").style.color = "black";
                }
                
                document.getElementById("totalWeight").innerHTML = '<strong>Current Tonnage:</strong> ' + tonnageDataJSON.totalWeight + '/' + tonnageDataJSON.maxTonnage;
                document.getElementById("totalWeightArmorPage").innerHTML = '<strong>Current Tonnage:</strong> ' + tonnageDataJSON.totalWeight + '/' + tonnageDataJSON.maxTonnage;
            }
        };
        
        xmlhttp6.open("GET","php/getMechTonnage.php", true);
        xmlhttp6.send();
    }
    
    
   function updateEngineTonnageJSON() {

        var myArr;

        if (window.XMLHttpRequest) {    // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp4=new XMLHttpRequest();
        }
        xmlhttp4.onreadystatechange=function() {
            if (xmlhttp4.readyState===4 && xmlhttp4.status===200) {
                var engineDataJSON = JSON.parse(xmlhttp4.response);
                
                for (var i = 20; i <= 100; i+=5) {                    
                    var option = document.createElement("option");
                    option.text = i;
                    option.value = i;
                    option.id = 'mechTonnageSelect_' + i;
                    
                    if (i == engineDataJSON.mechTonnage) {
                        option.selected = true;
                    }
                    document.getElementById("mechTonnageDropDown").appendChild(option); 
                }
                
                // THIS WILL NOT WORK LONG TERM, IT GETS IN RACE CONDITION WITH GETMECHDATA
                // THIS MAY DISPLAY OR MAY NOT. IT IS 50/50
                document.getElementById("mechEngineRating").innerHTML = engineDataJSON.engineRating;
         
                document.getElementById("internalsTonnage").innerHTML = engineDataJSON.internalsTonnage;
                document.getElementById("InternalsCriticalsTableData").innerHTML = engineDataJSON.internalsCriticals;
                document.getElementById("engineTonnage").innerHTML = engineDataJSON.engineTonnage;
                document.getElementById("engineCriticals").innerHTML = engineDataJSON.engineCriticals;
                document.getElementById("cockpitTonnage").innerHTML = engineDataJSON.cockpitTonnage;
                document.getElementById("cockpitCriticals").innerHTML = engineDataJSON.cockpitCriticals;
                document.getElementById("gyroTonnage").innerHTML = engineDataJSON.gyroTonnage;
                document.getElementById("gyroCriticals").innerHTML = engineDataJSON.gyroCriticals;
                
                document.getElementById("heatSinksTonnage").innerHTML = engineDataJSON.heatSinksTonnage;
                document.getElementById("heatSinksCriticals").innerHTML = engineDataJSON.heatSinksCriticals;
                document.getElementById("enhancementsTonnage").innerHTML = engineDataJSON.enhancementsTonnage;
                document.getElementById("enhancementsCriticals").innerHTML = engineDataJSON.enhancementsCriticals;
                document.getElementById("jumpJetsTonnage").innerHTML = engineDataJSON.jumpJetsTonnage;
                document.getElementById("jumpJetsCriticals").innerHTML = engineDataJSON.jumpJetsCriticals;
            }
        };
        xmlhttp4.open("GET","php/getEngineDataJSON.php",true);
        xmlhttp4.send();

    }
    
    
$(document).ready(function() {
    
    $(".weaponChildLI").draggable({
    revert: true,
    revertDuration: 0,
    cursor: 'move',
    start: function (event, ui) {

        $(this).toggleClass('draggingWeapon');
        $(this).css("width", "80px");
        
        mousePos = event.pageX - 224;
        $(this).css("margin-left", mousePos);
    },
    stop: function (event, ui) {
        //$(this).removeClass('draggingWeapon');
        //$(this).addClass('weaponChild');
        $(this).toggleClass('draggingWeapon');
        $(this).css("margin-left", "0px");
        $(this).css("width", "auto");
        $(this).css("height", "auto");
    }
    
    });
    
    
});
    
    
    // THIS FUNCTION MAKES THE CRIT CONTAINERS DROPPABLE BUT HAS TO BE CALLED AFTER
    // THOSE CONTAINERS ARE MADE DYNAMICALLY.
    function makeDroppable() {
        $('.dropSlots').droppable(
        {
            tolerance: "pointer",
            accept: '.weaponChildLI',
            
           /* over: function(event, ui) {
                //$('.ui-draggable-dragging').removeClass('weaponHighlight');
                //$('.weaponAccordionLI').removeClass('highlighted');
        //$('.ui-draggable-dragging').addClass('highlighted2');
    },*/
            
            drop: function(event, ui)
            {
                ui.draggable.data('dropped', true);
                
                containerID = $(this).parent().attr('id');
                if (containerID == "headCritTable") { modLocation = "mechhead"; altLocation = 2; }
                else if (containerID == "leftArmCritTable") { modLocation = "mecharm"; altLocation = 0; }
                else if (containerID == "rightArmCritTable") { modLocation = "mecharm"; altLocation = 1; }
                else if (containerID == "leftTorsoCritTable") { modLocation = "mechtorso"; altLocation = 0; }
                else if (containerID == "rightTorsoCritTable") { modLocation = "mechtorso"; altLocation = 1; }
                else if (containerID == "centerCritTable") { modLocation = "mechtorsocenter"; altLocation = 2; }
                else if (containerID == "leftLegCritTable") { modLocation = "mechleg"; altLocation = 0; }
                else if (containerID == "rightLegCritTable") { modLocation = "mechleg"; altLocation = 1; }
                
                //prompt($(this).parent().attr('id'));
                updateCrits(modLocation, altLocation, $(ui.draggable).html(), "add", containerID);
            }
        });
        
        $('.dropSlotsTD').draggable({
        revert: true,
        revertDuration: 0,
        cursor: 'move',
        start: function (event, ui) {

            $(this).toggleClass('draggingWeapon');
            $(this).css("display", "block");
        },
        stop: function (event, ui) {
            //$(this).removeClass('draggingWeapon');
            //$(this).addClass('weaponChild');
            $(this).toggleClass('draggingWeapon');
            
            containerID = $(this).parent().parent().attr('id');
            if (containerID == "headCritTable") { modLocation = "mechhead"; altLocation = 2; }
            else if (containerID == "leftArmCritTable") { modLocation = "mecharm"; altLocation = 0; }
            else if (containerID == "rightArmCritTable") { modLocation = "mecharm"; altLocation = 1; }
            else if (containerID == "leftTorsoCritTable") { modLocation = "mechtorso"; altLocation = 0; }
            else if (containerID == "rightTorsoCritTable") { modLocation = "mechtorso"; altLocation = 1; }
            else if (containerID == "centerCritTable") { modLocation = "mechtorsocenter"; altLocation = 2; }
            else if (containerID == "leftLegCritTable") { modLocation = "mechleg"; altLocation = 0; }
            else if (containerID == "rightLegCritTable") { modLocation = "mechleg"; altLocation = 1; }
            
            //prompt(containerID);
            //prompt($(this).html());
            updateCrits(modLocation, altLocation, $(this).html(), "remove", containerID);
            $(this).remove();
        }

        });
    }
    
    
    function checkLogin() {

        if (window.XMLHttpRequest) {    // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState===4 && xmlhttp.status===200) {
                document.getElementById('TEST2').innerHTML=xmlhttp.responseText;
                var userLoggedIn = xmlhttp.responseText;
                
                if (userLoggedIn == 'N/A') {
                    return "false";
                }
                else {
                    return "true";
                }
            }
        };
        
        xmlhttp.open("GET","php/checkLogin.php", true);
        xmlhttp.send();
    }

function updateHeatSinksJSON(changeHeatSink, newHeatSinkNums) {

            if (window.XMLHttpRequest) {    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp5=new XMLHttpRequest();
                }
                xmlhttp5.onreadystatechange=function() {
                if (xmlhttp5.readyState===4 && xmlhttp5.status===200) {
                    var heatSinkDataJSON = JSON.parse(xmlhttp5.response);

                    var heatSinkTypeOptions = document.createElement("option");
                        heatSinkTypeOptions.text = heatSinkDataJSON.heatSinkType;
                        heatSinkTypeOptions.value = heatSinkDataJSON.heatSinkType;
                        heatSinkTypeOptions.id = heatSinkDataJSON.heatSinkType;
                        heatSinkTypeOptions.selected = true;

                    var altHeatSinkOption = document.createElement("option");
                    altHeatSinkOption.id = "altHeatSink";

                    if (heatSinkDataJSON.heatSinkType == "Singles") {
                        altHeatSinkOption.text = "Doubles";
                    }
                    else {
                        altHeatSinkOption.text = "Singles";
                    }

                    $('#heatSinkTypeDropDown').find('option').remove().end();
                    document.getElementById("heatSinkTypeDropDown").appendChild(heatSinkTypeOptions);
                    document.getElementById("heatSinkTypeDropDown").appendChild(altHeatSinkOption);
                    document.getElementById("heatDissipation").innerHTML = '&nbsp' + heatSinkDataJSON.heatDissipation;

                    //document.getElementById("heatSinkNumDropDown").option[0].value = '&nbsp' + heatSinkDataJSON.heatDissipation;
                    //$('#heatSinkNumDropDown').val("val2");
                    //var e = document.getElementById("heatSinkNumDropDown");
                    //e.options[e.selectedIndex].value = heatSinkDataJSON.heatSinksNum;
                    $("#heatSinkNumDropDown").val(heatSinkDataJSON.heatSinksNum);
                    
                    updateTonnage();
                }
            };

            if ((changeHeatSink == false) || (changeHeatSink == null)) {
                xmlhttp5.open("GET","php/getHeatSinkDataJSON.php",true);
            }
            else if (changeHeatSink == 'changeNum') {
                xmlhttp5.open("GET","php/getHeatSinkDataJSON.php?newHeatSinkNums="+newHeatSinkNums, true);
                //prompt(newHeatSinkNums);
            }
            else if (changeHeatSink == true) {

                xmlhttp5.open("GET","php/getHeatSinkDataJSON.php?changeHeatSink=true", true);
            }
            xmlhttp5.send();
        }
        
        
        function changeMechTotalTonnage(mechWeight) {
            
            if (window.XMLHttpRequest) {    // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp12=new XMLHttpRequest();
            }
            
            xmlhttp12.onreadystatechange=function() {
                if (xmlhttp12.readyState===4 && xmlhttp12.status===200) {
                    //document.getElementById('TEST2').innerHTML=xmlhttp12.responseText;
                    
                    //updateArmor("mechArmor");
                    //updateHeatSinksJSON(false);
                    updateTonnage();
                    updateEngine(1);
                    
                    var docID = 'mechTonnageSelect_' + mechWeight;
                    document.getElementById(docID).selected = true;
                }
            };

            xmlhttp12.open("GET","php/changeMechTotalTonnage.php?tons="+mechWeight, true);
            xmlhttp12.send();
        }



        function updateHeatSinksJSON(changeHeatSink, newHeatSinkNums) {

            if (window.XMLHttpRequest) {    // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp5 = new XMLHttpRequest();
            }
            xmlhttp5.onreadystatechange = function () {
                if (xmlhttp5.readyState === 4 && xmlhttp5.status === 200) {
                    var heatSinkDataJSON = JSON.parse(xmlhttp5.response);

                    var heatSinkTypeOptions = document.createElement("option");
                    heatSinkTypeOptions.text = heatSinkDataJSON.heatSinkType;
                    heatSinkTypeOptions.value = heatSinkDataJSON.heatSinkType;
                    heatSinkTypeOptions.id = heatSinkDataJSON.heatSinkType;
                    heatSinkTypeOptions.selected = true;

                    var altHeatSinkOption = document.createElement("option");
                    altHeatSinkOption.id = "altHeatSink";

                    if (heatSinkDataJSON.heatSinkType == "Singles") {
                        altHeatSinkOption.text = "Doubles";
                    }
                    else {
                        altHeatSinkOption.text = "Singles";
                    }

                    $('#heatSinkTypeDropDown').find('option').remove().end();
                    document.getElementById("heatSinkTypeDropDown").appendChild(heatSinkTypeOptions);
                    document.getElementById("heatSinkTypeDropDown").appendChild(altHeatSinkOption);
                    document.getElementById("heatDissipation").innerHTML = '&nbsp' + heatSinkDataJSON.heatDissipation;

                    //document.getElementById("heatSinkNumDropDown").option[0].value = '&nbsp' + heatSinkDataJSON.heatDissipation;
                    //$('#heatSinkNumDropDown').val("val2");
                    //var e = document.getElementById("heatSinkNumDropDown");
                    //e.options[e.selectedIndex].value = heatSinkDataJSON.heatSinksNum;
                    $("#heatSinkNumDropDown").val(heatSinkDataJSON.heatSinksNum);

                    updateTonnage();
                }
            };

            if ((changeHeatSink == false) || (changeHeatSink == null)) {
                xmlhttp5.open("GET", "php/getHeatSinkDataJSON.php", true);
            }
            else if (changeHeatSink == 'changeNum') {
                xmlhttp5.open("GET", "php/getHeatSinkDataJSON.php?newHeatSinkNums=" + newHeatSinkNums, true);
                //prompt(newHeatSinkNums);
            }
            else if (changeHeatSink == true) {

                xmlhttp5.open("GET", "php/getHeatSinkDataJSON.php?changeHeatSink=true", true);
            }
            xmlhttp5.send();
        }


        function changeMechTotalTonnage(mechWeight) {

            if (window.XMLHttpRequest) {    // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp12 = new XMLHttpRequest();
            }

            xmlhttp12.onreadystatechange = function () {
                if (xmlhttp12.readyState === 4 && xmlhttp12.status === 200) {
                    //document.getElementById('TEST2').innerHTML=xmlhttp12.responseText;

                    //updateArmor("mechArmor");
                    //updateHeatSinksJSON(false);
                    updateTonnage();
                    updateEngine(1);

                    var docID = 'mechTonnageSelect_' + mechWeight;
                    document.getElementById(docID).selected = true;
                }
            };

            xmlhttp12.open("GET", "php/changeMechTotalTonnage.php?tons=" + mechWeight, true);
            xmlhttp12.send();
        }
