// Extract `mechIDPassed` from the current page's URL
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

// Store the `mechIDPassed` parameter from the page URL
const mechIDPassed = getQueryParam("mechIDPassed");

// Override the XMLHttpRequest `open` method to always pass our mechID
(function () {
    const originalOpen = XMLHttpRequest.prototype.open;
    XMLHttpRequest.prototype.open = function (method, url, async, user, password) {
        if (mechIDPassed) {
            // Append `mechIDPassed` to the request URL
            const separator = url.includes("?") ? "&" : "?";
            url = `${url}${separator}mechIDPassed=${mechIDPassed}`;
        }
        // Call the original `open` method with the modified URL
        originalOpen.call(this, method, url, async, user, password);
    };
})();

function checkFormData() {
    var newUserName = document.forms["registerForm"]["registerName"].value;
    var newUserEmail = document.forms["registerForm"]["registerEmail"].value;
    var newRegisterPassword = document.forms["registerForm"]["registerPassword"].value;
    var newConfirmPassword = document.forms["registerForm"]["confirmPassword"].value;

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("registerBox").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open(
        "POST",
        "php/register.php?name=" +
            newUserName +
            "&pass=" +
            newRegisterPassword +
            "&confirmPass=" +
            newConfirmPassword +
            "&email=" +
            newUserEmail,
        true
    );
    xmlhttp.send();
}

function clearForm() {
    $("#registerBox").fadeToggle("slow");

    $("input[type=text]").each(function () {
        $("#registerName").val("");
        $("#myusername").val("");
        $("#registerEmail").val("");
        $("#registerPassword").val("");
        $("#mypassword").val("");
        $("#confirmPassword").val("");
        $(".registerError").empty();
    });
}

$(document).ready(function () {
    /* Set error messages related to log in and log out
       to disappear after 10 seconds. */
    setTimeout(function () {
        $("#error").remove();
    }, 10000);

    $("div").removeClass("highlighted");

    var pageWidth = $(window).width();
    var pageHeight = $(window).height();

    if (pageWidth > 1266) {
        $("#navBar").css("width", pageWidth - 236);
        $("#footer").css("width", pageWidth - 15);
        $("#main").css("width", pageWidth - 245);
    }

    if (pageHeight > 816) {
        $("body").css("height", pageHeight);
        $("#sidebar").css("height", 700 + (pageHeight - 816));
        $("#main").css("height", 698 + (pageHeight - 816));
    }

    if ($("#loginInfo").css("display") === "block") {
        setTimeout(function () {
            $("#loginInfo").toggle("slow");
        }, 6000);
    }

    $(".registerButton").click(function () {
        $("#registerBox").fadeToggle("slow");

        $("input[type=text]").each(function () {
            $("#registerName").val("");
            $("#myusername").val("");
            $("#registerEmail").val("");
            $("#registerPassword").val("");
            $("#mypassword").val("");
            $("#confirmPassword").val("");
            $(".registerError").empty();
        });
    });

    $(".navBarLink").hover(
        function () {
            if (!$("#navBar").hasClass("blur")) {
                $(this).addClass("highlighted");
            }
        },
        function () {
            if (!$("#navBar").hasClass("blur")) {
                $(this).removeClass("highlighted");
            }
        }
    );

    $(".navButtons").mouseenter(function () {
        if (!$("#navBar").hasClass("blur")) {
            $(this).addClass("highlighted");
        }
    });

    $(".navButtons").mouseleave(function () {
        $(this).removeClass("highlighted");
    });

    $(".nav0").mouseenter(function () {
        if (!$("#navBar").hasClass("blur")) {
            $(".ul-1").hide(0);
            $(".ul-2").hide(0);
        }
    });
    $(".nav1").mouseenter(function () {
        if (!$("#navBar").hasClass("blur")) {
            $(".ul-1").slideToggle(0); // Speed at which the drop down tabs come out - May change later.
            $(".ul-2").hide(0);
        }
    });
    $(".nav2").mouseenter(function () {
        if (!$("#navBar").hasClass("blur")) {
            $(".ul-2").slideToggle(0); // Speed at which the drop down tabs come out - May change later.
            $(".ul-1").hide(0);
        }
    });
    $(".nav3").mouseenter(function () {
        $(".ul-1").hide(0);
        $(".ul-2").hide(0);
    });
    $(".nav4").mouseenter(function () {
        $(".ul-1").hide(0);
        $(".ul-2").hide(0);
    });
    $("#navBar").mouseleave(function () {
        $(".ul-1").hide(0);
        $(".ul-2").hide(0);
    });

    $(".ul-1").mouseleave(function () {
        $(".ul-1").hide(0);
    });
    $(".ul-2").mouseleave(function () {
        $(".ul-2").hide(0);
    });

    $(".tabLinks").hover(
        function () {
            $(this).children().addClass("linkHighlight");
        },
        function () {
            $(this).children().removeClass("linkHighlight");
        }
    );

    $("#commentSubmit").click(function () {
        var d = new Date();
        var n = d.getDate();
        var y = d.getFullYear();
        var m = d.getMonth();
        var h = d.getHours();
        var min = d.getMinutes();

        if (min < 9) {
            min = "0" + min;
        }

        // TO-DO: at some point save these in DB
        var comments = $("textarea[name=comments]").val();
        $("#commentArea").append(
            '<div class="individualComments">' +
                m +
                "-" +
                n +
                "-" +
                y +
                " at " +
                h +
                ":" +
                min +
                "&nbsp;" +
                "&nbsp;" +
                "&nbsp;" +
                "&nbsp;" +
                comments +
                "</div>"
        );
    });
});

$(window).resize(function () {
    location.reload();
});
