var h_pc = 170;
var h_sp = 80;

$(window).bind('load', function() {

});

$(document).ready(function() {
    $('#submit_cancel').click(function() {
        sessionStorage.setItem('fmail_back', 'true');
    });

    $('#submit_confirm, #submit_confirm').click(function() {
        sessionStorage.removeItem('fmail_back');
    });


});

if ($('.contact_page').length) {
    $(window).bind('load', function() {
        window.addEventListener('pageshow', function(event) {
            var str = window.location.search,
                n = str.search("mode"),
                fmail = $('#fmail_form').offset(),
                scrollTopValue = ($(window).width() > 750) ? fmail.top - h_pc : fmail.top - h_sp;
                let str1 = window.location.href;
                let type = str1.split("?mode=")[1];


            if (sessionStorage.getItem('fmail_back') === 'true' || n >= 0) {
                $('html,body').animate({ scrollTop: scrollTopValue }, 400);
            }
        });
        const val1 = localStorage.getItem("en1241805126");
        const val2 = localStorage.getItem("en1245937466");
        const val3 = localStorage.getItem("en1786948497");


        const $radio1 = $("input[name='en1241805126'][value='" + val1 + "']");
        $radio1.prop("checked", true);
        $radio1.closest("label").removeClass("fmail_label_disabled").addClass("fmail_label_enabled");


        const $radio2 = $("input[name='en1245937466'][value='" + val2 + "']");
        $radio2.prop("checked", true);
        $radio2.closest("label").removeClass("fmail_label_disabled").addClass("fmail_label_enabled");

        const $checkbox = $("input[name='en1786948497'][value='" + val3 + "']");
        $checkbox.prop("checked", true);
        $checkbox.closest("label").removeClass("fmail_label_disabled").addClass("fmail_label_enabled");

    });
}

$(window).bind('load', function() {
    "use strict";
    // anchor in page
    function scroll_animate(position) {
        if ($(window).width() > 750) {
            $('html,body').animate({ scrollTop: position.top - h_pc }, 0);
        } else {
            $('html,body').animate({ scrollTop: position.top - h_sp }, 0);
        }
    }

    $(function() {
        $('a[href^="#"]').click(function() {
            var target = $(this).attr('href');

            if (target === "#" || target === "" || $(target).length === 0) {
                return false;
            }

            var p = $(target).offset();
            scroll_animate(p);
            return false;
        });
    });


    // anchor top page #
    var hash = location.hash;
    if (hash) {
        var p = $(hash).offset();
        scroll_animate(p);
    }

    // LOAD IFRAME PAGESPEED
    var iframes = $('iframe[data-src]');
    if (iframes.length) {
        var iframeOffsetTop = iframes.offset().top;
        var windowHeight = $(window).outerHeight();

        function loadIframes() {
            iframes.each(function() {
                $(this).attr('src', $(this).data('src')).removeAttr('data-src');
            });
            $(window).unbind('scroll load', checkAndLoadIframes);
        }

        function checkAndLoadIframes() {
            if ($(this).scrollTop() > iframeOffsetTop - windowHeight) {
                loadIframes();
            }
        }

        $(window).bind('scroll load', checkAndLoadIframes);
    }
    // END LOAD IFRAME PAGESPEED
    
});

$(window).bind('load scroll', function() {
    "use strict";
    if ($(this).scrollTop() >= 500) {
        $('.to_top,.sp_contact').addClass('show');
    } else {
        $('.to_top,.sp_contact').removeClass('show');
    }
    if ($(this).scrollTop() >= 1) {
        $('header').addClass('show');
    } else {
        $('header').removeClass('show');
    }
    let mv=$(".mv").height() + 100;
   
    if ($(this).scrollTop() >= mv) {
        $('.box_fixed_pc').addClass('show');
    } else {
        $('.box_fixed_pc').removeClass('show');
    }
});

$(document).ready(function() {
    "use strict";
    var windowWidth = $(window).width();

    // nav
    $(".hamburger").click(function() {
        $(this).toggleClass("is_active");
        $("nav").fadeToggle(100);
    });

    $("nav .sub_btn").click(function() {
        if (windowWidth <= 750) {
            $(this).toggleClass("open");
            $(this).next().stop(1, 0).slideToggle(400);
        } else {
            $(this).removeClass("open");
            $(this).next().removeAttr("style");
        }
    });

    if (windowWidth <= 750) {
        $("nav ul li a[href]").click(function() {
            $('.hamburger').removeClass('is_active');
            $('nav').hide();
        });
    }
    // back to top
    $('.to_top').click(function() {
        $('html, body').animate({ scrollTop: 0 }, 600);
    });

    /*================= JS CUSTOM ===================*/

    // JS ONLY PAGE SPECIAL
    if ($('.under main .list_faq dt').length) {
        $(".under main .list_faq dt").click(function () {
            const $item = $(this).closest("dl");
            $item.toggleClass("active");
            $item.find("dd").stop(1, 0).slideToggle(400);
        });
    }

    if ($(".ovn_content").length) {
        $(".ovn_content h3").each(function () {
            const text = $(this).text();

             $(this).wrapInner(`<span class="txt"></span>`);
        });
    }

});