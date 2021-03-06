import $ from "jquery";

/*====================================
=            ON DOM READY            =
====================================*/
$(function() {
    $(".toggle-nav").click(function() {
        toggleNav();
    });
});

/*========================================
=            CUSTOM FUNCTIONS            =
========================================*/

function showNavigation() {
    $(".site-wrapper").addClass("show-nav");
    var overlay = $("#overlay_dark");
    overlay.fadeIn("fast");
    overlay.on("click", function() {
        hideNavigation();
    });
}

function hideNavigation() {
    $(".site-wrapper").removeClass("show-nav");
    var overlay = $("#overlay_dark");
    overlay.fadeOut("fast");
    overlay.off("click");
}

function toggleNav() {
    if ($(".site-wrapper").hasClass("show-nav")) {
        // Do things on Nav Close
        hideNavigation();
    } else {
        // Do things on Nav Open
        showNavigation();
    }
}

$(function() {
    // Delete confirmation method
    $(".delete-confirmation").on("click", function() {
        return confirm($(this).attr("data-confirmation"));
    });

    //  Context navigation
    $(".context-nav-toggle").on("click", function() {
        var nav = $(this).siblings(".context-nav");
        var overlay = $("#overlay");
        if (nav.is(":visible")) {
            nav.fadeOut("fast");
            overlay.fadeOut("fast");
        } else {
            nav.fadeIn("fast");
            overlay.fadeIn("fast");
            overlay.on("click", function() {
                if ($(".context-nav").is(":visible")) {
                    nav.fadeOut("fast");
                    overlay.fadeOut("fast");
                }
            });
        }
    });
});

/**
 * Method for sending post request (Logout button)
 */
import { postRequest } from "@/utils/form";
window.postRequest = postRequest;
