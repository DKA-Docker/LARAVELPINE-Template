import PerfectScrollbar from 'perfect-scrollbar';
import MetisMenu from "metismenu";

$(function () {

    /* ================================
       Load Saved Theme from localStorage
    ===================================*/
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme) {
        $("html").attr("data-bs-theme", savedTheme);
    }

    /* ================================
       Load Sidebar State from localStorage
    ===================================*/
    const isSidebarToggled = localStorage.getItem("sidebarToggled") === "true";
    if (isSidebarToggled) {
        $("body").addClass("toggled");
        $(".sidebar-wrapper").hover(
            function () {
                $("body").addClass("sidebar-hovered");
            },
            function () {
                $("body").removeClass("sidebar-hovered");
            }
        );
    }

    /* ===================
       Scrollbar Init
    ======================*/
    if ($('.notify-list').length) {
        new PerfectScrollbar('.notify-list');
    }

    if ($('.search-content').length) {
        new PerfectScrollbar('.search-content');
    }

    // new PerfectScrollbar(".mega-menu-widgets")

    /* ===================
       Sidebar Toggle
    ======================*/
    $(".btn-toggle").on('click', function () {
        const body = $("body");
        if (body.hasClass("toggled")) {
            body.removeClass("toggled");
            localStorage.setItem("sidebarToggled", "false");
            $(".sidebar-wrapper").unbind("hover");
        } else {
            body.addClass("toggled");
            localStorage.setItem("sidebarToggled", "true");
            $(".sidebar-wrapper").hover(
                function () {
                    body.addClass("sidebar-hovered");
                },
                function () {
                    body.removeClass("sidebar-hovered");
                }
            );
        }
    });

    /* ===================
       MetisMenu Init
    ======================*/
    new MetisMenu($('#sidenav'));

    $(".sidebar-close").on("click", function () {
        $("body").removeClass("toggled");
        localStorage.setItem("sidebarToggled", "false");
    });

    /* ===================
       Dark Mode Button
    ======================*/
    $(".dark-mode i").click(function () {
        $(this).text(function (i, v) {
            return v === 'dark_mode' ? 'light_mode' : 'dark_mode';
        });
    });

    $(".dark-mode").on('click', function () {
        $("html").attr("data-bs-theme", function (i, v) {
            const newTheme = v === 'dark' ? 'light' : 'dark';
            localStorage.setItem("theme", newTheme);
            return newTheme;
        });
    });

    /* ===================
       Sticky Header
    ======================*/
    $(window).on("scroll", function () {
        if ($(this).scrollTop() > 60) {
            $('.top-header .navbar').addClass('sticky-header');
        } else {
            $('.top-header .navbar').removeClass('sticky-header');
        }
    });

    /* ===================
       Email UI Events
    ======================*/
    $(".email-toggle-btn").on("click", function () {
        $(".email-wrapper").toggleClass("email-toggled")
    });

    $(".email-toggle-btn-mobile").on("click", function () {
        $(".email-wrapper").removeClass("email-toggled")
    });

    $(".compose-mail-btn").on("click", function () {
        $(".compose-mail-popup").show()
    });

    $(".compose-mail-close").on("click", function () {
        $(".compose-mail-popup").hide()
    });

    /* ===================
       Chat UI Events
    ======================*/
    $(".chat-toggle-btn").on("click", function () {
        $(".chat-wrapper").toggleClass("chat-toggled")
    });

    $(".chat-toggle-btn-mobile").on("click", function () {
        $(".chat-wrapper").removeClass("chat-toggled")
    });

    /* ===================
       Theme Switcher
    ======================*/
    $("#BlueTheme").on("click", function () {
        $("html").attr("data-bs-theme", "blue-theme");
        localStorage.setItem("theme", "blue-theme");
    });

    $("#LightTheme").on("click", function () {
        $("html").attr("data-bs-theme", "light");
        localStorage.setItem("theme", "light");
    });

    $("#DarkTheme").on("click", function () {
        $("html").attr("data-bs-theme", "dark");
        localStorage.setItem("theme", "dark");
    });

    $("#SemiDarkTheme").on("click", function () {
        $("html").attr("data-bs-theme", "semi-dark");
        localStorage.setItem("theme", "semi-dark");
    });

    $("#BoderedTheme").on("click", function () {
        $("html").attr("data-bs-theme", "bodered-theme");
        localStorage.setItem("theme", "bodered-theme");
    });

    /* ===================
       Search Popup Control
    ======================*/
    $(".search-control").click(function () {
        $(".search-popup").addClass("d-block");
        $(".search-close").addClass("d-block");
    });

    $(".search-close").click(function () {
        $(".search-popup").removeClass("d-block");
        $(".search-close").removeClass("d-block");
    });

    $(".mobile-search-btn").click(function () {
        $(".search-popup").addClass("d-block");
    });

    $(".mobile-search-close").click(function () {
        $(".search-popup").removeClass("d-block");
    });

    /* ===================
       Menu Active State
    ======================*/
    const currentUrl = window.location.href;
    const element = $(".metismenu li a").filter(function () {
        return this.href === currentUrl;
    });

    element.addClass("mm-active")
        .parents("li")
        .addClass("mm-active");

    element.parents("ul")
        .addClass("mm-show")
        .parents("li")
        .addClass("mm-active");
});
