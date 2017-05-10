/* JavaScript Document */
/**
 * [File : general.js]
 *
 * Project:         Ministry of Justice Intranet
 * Version:         1.0.
 * Last change:     22/10/09
 * Assigned to:     Geoff Anscombe, Harjinder Virk MOJ
 *
 *
 *
 * [Table of contents]
 *
 *  Temp jquery
 *  Icons for links
 *  Content fader functions
 *    Slider function with pagination
 *    Lightbox prettyphoto
 *    Accordian function
 *    Set your intranet function
*/

/*------------------------------------------------------------------
 * Temp jquery
*/
$(document).ready(function() {
    $('.landing-box h2 a').append(' &raquo;');
});

/*------------------------------------------------------------------
 * Icons for links
*/
(function( $ ) {
    $.fn.niceLink = function(options) {
        var settings = $.extend({
            addClass: false,
            linkTitle: false
        }, options);

        this.each(function(k, element) {
            element = $(element);

            // Add title to link
            if (settings.linkTitle) {
                element.attr('title', settings.linkTitle);
            }

            // Add class name for file type
            if (settings.addClass) {
                var $parent = element.parent().get(0).tagName.toLowerCase();

                if ($parent == 'li') {
                    element.parent().addClass(settings.addClass);
                } else {
                    element.addClass(settings.addClass);
                }
            }

            // Add target="_blank" if 'target' isn't already specified
            if (typeof element.attr('target') == 'undefined' || element.attr('target') == '') {
                element.attr('target', '_blank');
            }
        });

        return this;
    };
}( jQuery ));

$(document).ready(function() {
    // PDF links
    $("a[href$='.pdf'], a[href$='.PDF']").niceLink({
        linkTitle: 'PDF link, opens in a new browser window.',
        addClass: 'pdf'
    });

    // DOC links
    $("a[href$='.doc'], a[href$='.DOC']").niceLink({
        linkTitle: 'Microsoft Word link, opens in a new browser window.',
        addClass: 'doc'
    });

    // DOT links
    $("a[href$='.dot'], a[href$='.DOT']").niceLink({
        linkTitle: 'Microsoft Word template link, opens in a new browser window.',
        addClass: 'dot'
    });

    // PPT links
    $("a[href$='.ppt'], a[href$='.PPT']").niceLink({
        linkTitle: 'Microsoft Power point link, opens in a new browser window.',
        addClass: 'ppt'
    });

    // XLS links
    $("a[href$='.xls'], a[href$='.XLS']").niceLink({
        linkTitle: 'Microsoft Excel link, opens in a new browser window.',
        addClass: 'xls'
    });

    // Email links
    $("a[href^='mailto:']").niceLink({
        linkTitle: 'This is an email link.',
        addClass: 'email'
    });

    // External links
    var currentDomain = document.location.protocol + '//' + document.location.hostname;
    var outboundLinks = 'a[href^="http"]:not([href*="' + currentDomain + '"])';
    $('#mainContent ' + outboundLinks + ', #rightColumn ' + outboundLinks).niceLink({
        linkTitle: 'External website link, opens in a new browser window.',
        addClass: 'http'
    });
});
/*------------------------------------------------------------------
 * Content fader functions
*/
$(document).ready(function() {
    // turn tabs on
    $("body.section1 .content-switcher-newspanel1 #tabs").show();
    // mojozine + latest news + media summaries + insight + announcements
    $('body.section1 .content-switcher-newspanel1').tabs(2,{ fxFade: true, fxSpeed: 'slow' });
    $('.content-switcher-newspanel1 h2').addClass('offset');

    $("body.section1 .static-panel #tabs").show();
    // mojozine + latest news + media summaries + insight + announcements

    /* $('body.section1 .offlinepanel #panel_offline').fadeIn('slow');*/

    $('.static-panel h2').addClass('offset');


});
/*------------------------------------------------------------------
 * Slider function with pagination
*/
$(document).ready(function() {
    $("#slider").easySlider({
        /*
        auto: false,
        continuous: true,
        */
        numeric: true,
        speed: 400,
        numericId: 'controls'
    });
});
/*------------------------------------------------------------------
 * Lightbox prettyphoto
*/
$(document).ready(function() {

    $("a[rel^='prettyphoto']").prettyphoto({
        animationSpeed: 'fast',
        padding: 40,
        opacity: 0.85,
        showTitle: true,
        allowresize: true,

        theme: 'dark_square',
        callback: function(){}

    });
});
/*------------------------------------------------------------------
 * Accordian function
*/
$(document).ready(function() {
    $('div.accordian> div').hide().addClass('offset');
    $('div.accordian> div.default').show().removeClass('offset');
    $('div.accordian> p.accordian-heading').click(function() {
        var $text = $(this).text().replace(/ /g,'');
        if($text == 'Open'){
            $(this).text('Close');
            $(this).removeClass('open');
            $(this).addClass('close');
        } else if ($text == 'Close') {
            $(this).text('Open');
            $(this).removeClass('close');
            $(this).addClass('open');
        }
        var $nextDiv = $(this).next();
        var $visibleSiblings = $nextDiv.siblings('div:visible');
            if ($visibleSiblings.length ) {
                $visibleSiblings.slideUp('slow', function() {
                    $visibleSiblings.addClass('offset');
                    $nextDiv.removeClass('offset');
                    $nextDiv.slideDown('slow');
                });
            } else {
                $nextDiv.removeClass('offset');
                $nextDiv.slideToggle('slow');
            }
    });
});

/*------------------------------------------------------------------
 * Set your intranet function
*/
$(document).ready(function() {
    /* check to see if cookies are enabled */
    $.cookie('cookie_check', 'cookie test');
    if($.cookie('cookie_check')){
        // if javascript is turned on enter these values */
        $('.set-your-intranet-header').replaceWith('<div class="heading set-your-intranet-header">Set your intranet</div>');
        $('.set-your-intranet .accordian p.accordian-heading').show();
        // add the reset button to the bottom of the list */
        $("div.set-your-intranet ul").append('<li><a href="/index.htm" title="Reset">Reset</a></li>');
        // if a intranet choice is made do this */
        $('div.set-your-intranet a').click(function() {
            // set href values to variables */
            var $intranet_link = $(this).attr("href");
            // set title values to variables*/
            var $intranet_name = $(this).attr("title");
            // set title values to variables after lowercasing and removing whitespace*/
            var $intranet_img = $(this).attr("title").toLowerCase().replace(/ /g,'');
            // create and set cookies from above variables */
            $.cookie('the_cookie_link', $intranet_link, {expires:365});
            $.cookie('the_cookie_name', $intranet_name, {expires:365});
            $.cookie('the_cookie_img', $intranet_img, {expires:365});
            // get cookies values and assign to variables */
            var $cookie_link_value = $.cookie('the_cookie_link');
            var $cookie_image_value = $.cookie('the_cookie_img');
            var $cookie_name_value = $.cookie('the_cookie_name');
            var $image_displayed = $("div.set-your-intranet> .image").attr("style").toLowerCase().slice(0, 13);
            // show and replace image and link */
            if($cookie_image_value == 'reset'){
                $('div.set-your-intranet> .image').slideUp('slow');
                $('.set-your-intranet-header').replaceWith('<div class="heading set-your-intranet-header">Set your intranet</div>');
            }
            else if($image_displayed == 'display: none') {
                $('.set-your-intranet-header').replaceWith('<div class="heading set-your-intranet-header">' + $cookie_name_value + '</div>');
                $('div.set-your-intranet> .image').replaceWith("<div class='image' style='display: none;'><a href=" + $cookie_link_value + "><img src='images/set-intranet/" + $cookie_image_value + ".gif' /></a></div>");
                $('div.set-your-intranet> .image').slideToggle();
            }
            else {
                $('.set-your-intranet-header').replaceWith('<div class="heading set-your-intranet-header">' + $cookie_name_value + '</div>');
                $('div.set-your-intranet> .image').fadeOut('slow');
                $('div.set-your-intranet> .image').replaceWith("<div class='image'><a href=" + $cookie_link_value + "><img src='images/set-intranet/" + $cookie_image_value + ".gif' /></a></div>");
                $('div.set-your-intranet> .image').hide();
                $('div.set-your-intranet> .image').fadeIn('slow');
            }
            $('div.set-your-intranet div.accordian> div').slideToggle('slow');
            $.cookie('cookie_do_not_display', 'Do not display', {expires:365});
            setTimeout(function() { $('.one-click-message').animate({opacity: "hide", top: "-50px"}, "slow"); }, 500);
            setTimeout(function() { $('.open-message').slideUp('slow'); }, 1000);
            return false;
        });
        // if cookie is set show and assign values */
        if ($.cookie('the_cookie_link')) {
            var $cookie_link_value = $.cookie('the_cookie_link');
            var $cookie_image_value = $.cookie('the_cookie_img');
            var $cookie_name_value = $.cookie('the_cookie_name');
            // if cookie is reset then hide otherwise show image and link */
            if($cookie_image_value == 'reset'){
                $('div.set-your-intranet> .image').hide();
            } else {
                $('div.set-your-intranet> .image').show();
                $('.set-your-intranet-header').replaceWith('<div class="heading set-your-intranet-header">' + $cookie_name_value + '</div>');
                $('div.set-your-intranet> .image').replaceWith("<div class='image'><a href=" + $cookie_link_value + "><img src='images/set-intranet/" + $cookie_image_value + ".gif' /></a></div>");
            }
        } else {
            $('div.set-your-intranet> .image').hide();
            $('.set-your-intranet-header').replaceWith('<div class="heading set-your-intranet-header">Set your intranet</div>');
        }
    } else {
        $('div.set-your-intranet div.accordian> p.accordian-heading').hide();
        $('div.set-your-intranet div.accordian> div').show();
    }
});
/* on-click-message */
$(document).ready(function () {
    //$.cookie('cookie_do_not_display', '', { expires: -1 }); // delete cookie
    var $cookie_do_not_display = $.cookie('cookie_do_not_display');
    if (!$cookie_do_not_display) {
            setTimeout(function() { $('.open-message').slideDown('slow'); }, 1000);
            setTimeout(function() {
                $('.one-click-message').animate({opacity: "show", top: "-10px"}, "slow");
                return false;
            }, 2000);
    }
    $('.one-click-message a').click(function() {
        $.cookie('cookie_do_not_display', 'Do not display', {expires:365});
        setTimeout(function() { $('.one-click-message').animate({opacity: "hide", top: "-50px"}, "slow"); }, 500);
        setTimeout(function() { $('.open-message').slideUp('slow'); }, 1000);
    });
});
/* cute time thing */
$(document).ready(function () {
    // both lines assign cuteTime controller to all 'timetamp' class objectes
    $('.timestamp_move').cuteTime();
    // returns a cuter string of the passed in datetime
    $('.predetermined').text(" -> "+$.cuteTime('2009/10/16 22:11:19'));
    my_cutetime = $('.timestamp').cuteTime({ refresh: 10000 });
});
