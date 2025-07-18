/******/ (() => { // webpackBootstrap
/*!***************************************!*\
  !*** ./resources/js/core/app-menu.js ***!
  \***************************************/
/*=========================================================================================
  File Name: app-menu.js
  Description: Menu navigation, custom scrollbar, hover scroll bar, multilevel menu
  initialization and manipulations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/
(function (window, document, $) {
  'use strict';

  var vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', vh + 'px');
  $.app = $.app || {};
  var $body = $('body');
  var $window = $(window);
  var menuWrapper_el = $('div[data-menu="menu-wrapper"]').html();
  var menuWrapperClasses = $('div[data-menu="menu-wrapper"]').attr('class');

  // Main menu
  $.app.menu = {
    expanded: null,
    collapsed: null,
    hidden: null,
    container: null,
    horizontalMenu: false,
    is_touch_device: function is_touch_device() {
      var prefixes = ' -webkit- -moz- -o- -ms- '.split(' ');
      var mq = function mq(query) {
        return window.matchMedia(query).matches;
      };
      if ('ontouchstart' in window || window.DocumentTouch && document instanceof DocumentTouch) {
        return true;
      }
      // include the 'heartz' as a way to have a non matching MQ to help terminate the join
      // https://git.io/vznFH
      var query = ['(', prefixes.join('touch-enabled),('), 'heartz', ')'].join('');
      return mq(query);
    },
    manualScroller: {
      obj: null,
      init: function init() {
        var scroll_theme = $('.main-menu').hasClass('menu-dark') ? 'light' : 'dark';
        if (!$.app.menu.is_touch_device()) {
          this.obj = new PerfectScrollbar('.main-menu-content', {
            suppressScrollX: true,
            wheelPropagation: false
          });
        } else {
          $('.main-menu').addClass('menu-native-scroll');
        }
      },
      update: function update() {
        // if (this.obj) {
        // Scroll to currently active menu on page load if data-scroll-to-active is true
        if ($('.main-menu').data('scroll-to-active') === true) {
          var activeEl, menu, activeElHeight;
          activeEl = document.querySelector('.main-menu-content li.active');
          menu = document.querySelector('.main-menu-content');
          if ($body.hasClass('menu-collapsed')) {
            if ($('.main-menu-content li.sidebar-group-active').length) {
              activeEl = document.querySelector('.main-menu-content li.sidebar-group-active');
            }
          }
          if (activeEl) {
            activeElHeight = activeEl.getBoundingClientRect().top + menu.scrollTop;
          }

          // If active element's top position is less than 2/3 (66%) of menu height than do not scroll
          if (activeElHeight > parseInt(menu.clientHeight * 2 / 3)) {
            var start = menu.scrollTop,
              change = activeElHeight - start - parseInt(menu.clientHeight / 2);
          }
          setTimeout(function () {
            $.app.menu.container.stop().animate({
              scrollTop: change
            }, 300);
            $('.main-menu').data('scroll-to-active', 'false');
          }, 300);
        }
        // this.obj.update();
        // }
      },
      enable: function enable() {
        if (!$('.main-menu-content').hasClass('ps')) {
          this.init();
        }
      },
      disable: function disable() {
        if (this.obj) {
          this.obj.destroy();
        }
      },
      updateHeight: function updateHeight() {
        if (($body.data('menu') == 'vertical-menu' || $body.data('menu') == 'vertical-menu-modern' || $body.data('menu') == 'vertical-overlay-menu') && $('.main-menu').hasClass('menu-fixed')) {
          $('.main-menu-content').css('height', $(window).height() - $('.header-navbar').height() - $('.main-menu-header').outerHeight() - $('.main-menu-footer').outerHeight());
          this.update();
        }
      }
    },
    init: function init(compactMenu) {
      if ($('.main-menu-content').length > 0) {
        this.container = $('.main-menu-content');
        var menuObj = this;
        this.change(compactMenu);
      }
    },
    change: function change(compactMenu) {
      var currentBreakpoint = Unison.fetch.now(); // Current Breakpoint

      this.reset();
      var menuType = $body.data('menu');
      if (currentBreakpoint) {
        switch (currentBreakpoint.name) {
          case 'xl':
            if (menuType === 'vertical-overlay-menu') {
              this.hide();
            } else {
              if (compactMenu === true) this.collapse(compactMenu);else this.expand();
            }
            break;
          case 'lg':
            if (menuType === 'vertical-overlay-menu' || menuType === 'vertical-menu-modern' || menuType === 'horizontal-menu') {
              this.hide();
            } else {
              this.collapse();
            }
            break;
          case 'md':
          case 'sm':
            this.hide();
            break;
          case 'xs':
            this.hide();
            break;
        }
      }

      // On the small and extra small screen make them overlay menu
      if (menuType === 'vertical-menu' || menuType === 'vertical-menu-modern') {
        this.toOverlayMenu(currentBreakpoint.name, menuType);
      }
      if ($body.is('.horizontal-layout') && !$body.hasClass('.horizontal-menu-demo')) {
        this.changeMenu(currentBreakpoint.name);
        $('.menu-toggle').removeClass('is-active');
      }

      // Dropdown submenu on large screen on hover For Large screen only
      // ---------------------------------------------------------------
      if (currentBreakpoint.name == 'xl') {
        $('body[data-open="hover"] .main-menu-content .dropdown') // Use selector $('body[data-open="hover"] .header-navbar .dropdown') for menu and navbar DD open on hover
        .on('mouseenter', function () {
          if (!$(this).hasClass('show')) {
            $(this).addClass('show');
          } else {
            $(this).removeClass('show');
          }
        }).on('mouseleave', function (event) {
          $(this).removeClass('show');
        });
        /* ? Uncomment to enable all DD open on hover
        $('body[data-open="hover"] .dropdown a').on('click', function (e) {
          if (menuType == 'horizontal-menu') {
            var $this = $(this);
            if ($this.hasClass('dropdown-toggle')) {
              return false;
            }
          }
        });
        */
      }

      // Added data attribute brand-center for navbar-brand-center

      if (currentBreakpoint.name == 'sm' || currentBreakpoint.name == 'xs') {
        $('.header-navbar[data-nav=brand-center]').removeClass('navbar-brand-center');
      } else {
        $('.header-navbar[data-nav=brand-center]').addClass('navbar-brand-center');
      }
      // On screen width change, current active menu in horizontal
      if (currentBreakpoint.name == 'xl' && menuType == 'horizontal-menu') {
        $('.main-menu-content').find('li.active').parents('li').addClass('sidebar-group-active active');
      }
      if (currentBreakpoint.name !== 'xl' && menuType == 'horizontal-menu') {
        $('#navbar-type').toggleClass('d-none d-xl-block');
      }

      // Dropdown submenu on small screen on click
      // --------------------------------------------------
      $('ul.dropdown-menu [data-bs-toggle=dropdown]').on('click', function (event) {
        if ($(this).siblings('ul.dropdown-menu').length > 0) {
          event.preventDefault();
        }
        event.stopPropagation();
        $(this).parent().siblings().removeClass('show');
        $(this).parent().toggleClass('show');
      });

      // Horizontal layout submenu drawer scrollbar
      if (menuType == 'horizontal-menu') {
        $('li.dropdown-submenu').on('mouseenter', function () {
          if (!$(this).parent('.dropdown').hasClass('show')) {
            $(this).removeClass('openLeft');
          }
          var dd = $(this).find('.dropdown-menu');
          if (dd) {
            var pageHeight = $(window).height(),
              // ddTop = dd.offset().top,
              ddTop = $(this).position().top,
              ddLeft = dd.offset().left,
              ddWidth = dd.width(),
              ddHeight = dd.height();
            if (pageHeight - ddTop - ddHeight - 28 < 1) {
              var maxHeight = pageHeight - ddTop - 170;
              $(this).find('.dropdown-menu').css({
                'max-height': maxHeight + 'px',
                'overflow-y': 'auto',
                'overflow-x': 'hidden'
              });
              var menu_content = new PerfectScrollbar('li.dropdown-submenu.show .dropdown-menu', {
                wheelPropagation: false
              });
            }
            // Add class to horizontal sub menu if screen width is small
            if (ddLeft + ddWidth - (window.innerWidth - 16) >= 0) {
              $(this).addClass('openLeft');
            }
          }
        });
        $('.theme-layouts').find('.semi-dark').hide();
      }

      // Horizontal Fixed Nav Sticky hight issue on small screens
      // if (menuType == 'horizontal-menu') {
      //   if (currentBreakpoint.name == 'sm' || currentBreakpoint.name == 'xs') {
      //     if ($(".menu-fixed").length) {
      //       $(".menu-fixed").unstick();
      //     }
      //   }
      //   else {
      //     if ($(".navbar-fixed").length) {
      //       $(".navbar-fixed").sticky();
      //     }
      //   }
      // }
    },
    transit: function transit(callback1, callback2) {
      var menuObj = this;
      $body.addClass('changing-menu');
      callback1.call(menuObj);
      if ($body.hasClass('vertical-layout')) {
        if ($body.hasClass('menu-open') || $body.hasClass('menu-expanded')) {
          $('.menu-toggle').addClass('is-active');

          // Show menu header search when menu is normally visible
          if ($body.data('menu') === 'vertical-menu') {
            if ($('.main-menu-header')) {
              $('.main-menu-header').show();
            }
          }
        } else {
          $('.menu-toggle').removeClass('is-active');

          // Hide menu header search when only menu icons are visible
          if ($body.data('menu') === 'vertical-menu') {
            if ($('.main-menu-header')) {
              $('.main-menu-header').hide();
            }
          }
        }
      }
      setTimeout(function () {
        callback2.call(menuObj);
        $body.removeClass('changing-menu');
        menuObj.update();
      }, 500);
    },
    open: function open() {
      this.transit(function () {
        $body.removeClass('menu-hide menu-collapsed').addClass('menu-open');
        this.hidden = false;
        this.expanded = true;
        if ($body.hasClass('vertical-overlay-menu')) {
          $('.sidenav-overlay').addClass('show');
          // $('.sidenav-overlay').removeClass('d-none').addClass('d-block');
          // $('body').css('overflow', 'hidden');
        }
      }, function () {
        if (!$('.main-menu').hasClass('menu-native-scroll') && $('.main-menu').hasClass('menu-fixed')) {
          this.manualScroller.enable();
          $('.main-menu-content').css('height', $(window).height() - $('.header-navbar').height() - $('.main-menu-header').outerHeight() - $('.main-menu-footer').outerHeight());
          // this.manualScroller.update();
        }
        if (!$body.hasClass('vertical-overlay-menu')) {
          $('.sidenav-overlay').removeClass('show');
          // $('.sidenav-overlay').removeClass('d-block d-none');
          // $('body').css('overflow', 'auto');
        }
      });
    },
    hide: function hide() {
      this.transit(function () {
        $body.removeClass('menu-open menu-expanded').addClass('menu-hide');
        this.hidden = true;
        this.expanded = false;
        if ($body.hasClass('vertical-overlay-menu')) {
          $('.sidenav-overlay').removeClass('show');
          // $('.sidenav-overlay').removeClass('d-block').addClass('d-none');
          // $('body').css('overflow', 'auto');
        }
      }, function () {
        if (!$('.main-menu').hasClass('menu-native-scroll') && $('.main-menu').hasClass('menu-fixed')) {
          this.manualScroller.enable();
        }
        if (!$body.hasClass('vertical-overlay-menu')) {
          $('.sidenav-overlay').removeClass('show');
          // $('.sidenav-overlay').removeClass('d-block d-none');
          // $('body').css('overflow', 'auto');
        }
      });
    },
    expand: function expand() {
      if (this.expanded === false) {
        if ($body.data('menu') == 'vertical-menu-modern') {
          $('.modern-nav-toggle').find('.collapse-toggle-icon').replaceWith(feather.icons['disc'].toSvg({
            "class": 'd-none d-xl-block collapse-toggle-icon primary font-medium-4'
          }));
        }
        this.transit(function () {
          $body.removeClass('menu-collapsed').addClass('menu-expanded');
          this.collapsed = false;
          this.expanded = true;
          $('.sidenav-overlay').removeClass('show');

          // $('.sidenav-overlay').removeClass('d-block d-none');
        }, function () {
          if ($('.main-menu').hasClass('menu-native-scroll') || $body.data('menu') == 'horizontal-menu') {
            this.manualScroller.disable();
          } else {
            if ($('.main-menu').hasClass('menu-fixed')) this.manualScroller.enable();
          }
          if (($body.data('menu') == 'vertical-menu' || $body.data('menu') == 'vertical-menu-modern') && $('.main-menu').hasClass('menu-fixed')) {
            $('.main-menu-content').css('height', $(window).height() - $('.header-navbar').height() - $('.main-menu-header').outerHeight() - $('.main-menu-footer').outerHeight());
            // this.manualScroller.update();
          }
        });
      }
    },
    collapse: function collapse() {
      if (this.collapsed === false) {
        if ($body.data('menu') == 'vertical-menu-modern') {
          $('.modern-nav-toggle').find('.collapse-toggle-icon').replaceWith(feather.icons['circle'].toSvg({
            "class": 'd-none d-xl-block collapse-toggle-icon primary font-medium-4'
          }));
        }
        this.transit(function () {
          $body.removeClass('menu-expanded').addClass('menu-collapsed');
          this.collapsed = true;
          this.expanded = false;
          $('.content-overlay').removeClass('d-block d-none');
        }, function () {
          if ($body.data('menu') == 'horizontal-menu' && $body.hasClass('vertical-overlay-menu')) {
            if ($('.main-menu').hasClass('menu-fixed')) this.manualScroller.enable();
          }
          if (($body.data('menu') == 'vertical-menu' || $body.data('menu') == 'vertical-menu-modern') && $('.main-menu').hasClass('menu-fixed')) {
            $('.main-menu-content').css('height', $(window).height() - $('.header-navbar').height());
            // this.manualScroller.update();
          }
          if ($body.data('menu') == 'vertical-menu-modern') {
            if ($('.main-menu').hasClass('menu-fixed')) this.manualScroller.enable();
          }
        });
      }
    },
    toOverlayMenu: function toOverlayMenu(screen, menuType) {
      var menu = $body.data('menu');
      if (menuType == 'vertical-menu-modern') {
        if (screen == 'lg' || screen == 'md' || screen == 'sm' || screen == 'xs') {
          if ($body.hasClass(menu)) {
            $body.removeClass(menu).addClass('vertical-overlay-menu');
          }
        } else {
          if ($body.hasClass('vertical-overlay-menu')) {
            $body.removeClass('vertical-overlay-menu').addClass(menu);
          }
        }
      } else {
        if (screen == 'sm' || screen == 'xs') {
          if ($body.hasClass(menu)) {
            $body.removeClass(menu).addClass('vertical-overlay-menu');
          }
        } else {
          if ($body.hasClass('vertical-overlay-menu')) {
            $body.removeClass('vertical-overlay-menu').addClass(menu);
          }
        }
      }
    },
    changeMenu: function changeMenu(screen) {
      // Replace menu html
      $('div[data-menu="menu-wrapper"]').html('');
      $('div[data-menu="menu-wrapper"]').html(menuWrapper_el);
      var menuWrapper = $('div[data-menu="menu-wrapper"]'),
        menuContainer = $('div[data-menu="menu-container"]'),
        menuNavigation = $('ul[data-menu="menu-navigation"]'),
        /*megaMenu           = $('li[data-menu="megamenu"]'),
        megaMenuCol        = $('li[data-mega-col]'),*/
        dropdownMenu = $('li[data-menu="dropdown"]'),
        dropdownSubMenu = $('li[data-menu="dropdown-submenu"]');
      if (screen === 'xl') {
        // Change body classes
        $body.removeClass('vertical-layout vertical-overlay-menu fixed-navbar').addClass($body.data('menu'));

        // Remove navbar-fix-top class on large screens
        $('nav.header-navbar').removeClass('fixed-top');

        // Change menu wrapper, menu container, menu navigation classes
        menuWrapper.removeClass().addClass(menuWrapperClasses);
        $('a.dropdown-item.nav-has-children').on('click', function () {
          event.preventDefault();
          event.stopPropagation();
        });
        $('a.dropdown-item.nav-has-parent').on('click', function () {
          event.preventDefault();
          event.stopPropagation();
        });
      } else {
        // Change body classes
        $body.removeClass($body.data('menu')).addClass('vertical-layout vertical-overlay-menu fixed-navbar');

        // Add navbar-fix-top class on small screens
        $('nav.header-navbar').addClass('fixed-top');

        // Change menu wrapper, menu container, menu navigation classes
        menuWrapper.removeClass().addClass('main-menu menu-light menu-fixed menu-shadow');
        // menuContainer.removeClass().addClass('main-menu-content');
        menuNavigation.removeClass().addClass('navigation navigation-main');

        // If Dropdown Menu
        dropdownMenu.removeClass('dropdown').addClass('has-sub');
        dropdownMenu.find('a').removeClass('dropdown-toggle nav-link');
        dropdownMenu.find('a').attr('data-bs-toggle', '');
        dropdownMenu.children('ul').find('a').removeClass('dropdown-item');
        dropdownMenu.find('ul').removeClass('dropdown-menu');
        dropdownSubMenu.removeClass().addClass('has-sub');
        $.app.nav.init();

        // Dropdown submenu on small screen on click
        // --------------------------------------------------
        $('ul.dropdown-menu [data-bs-toggle=dropdown]').on('click', function (event) {
          event.preventDefault();
          event.stopPropagation();
          $(this).parent().siblings().removeClass('open');
          $(this).parent().toggleClass('open');
        });
        $('.main-menu-content').find('li.active').parents('li').addClass('sidebar-group-active');
        $('.main-menu-content').find('li.active').closest('li.nav-item').addClass('open');
      }
      if (feather) {
        feather.replace({
          width: 14,
          height: 14
        });
      }
    },
    toggle: function toggle() {
      var currentBreakpoint = Unison.fetch.now(); // Current Breakpoint
      var collapsed = this.collapsed;
      var expanded = this.expanded;
      var hidden = this.hidden;
      var menu = $body.data('menu');
      switch (currentBreakpoint.name) {
        case 'xl':
          if (expanded === true) {
            if (menu == 'vertical-overlay-menu') {
              this.hide();
            } else {
              this.collapse();
            }
          } else {
            if (menu == 'vertical-overlay-menu') {
              this.open();
            } else {
              this.expand();
            }
          }
          break;
        case 'lg':
          if (expanded === true) {
            if (menu == 'vertical-overlay-menu' || menu == 'vertical-menu-modern' || menu == 'horizontal-menu') {
              this.hide();
            } else {
              this.collapse();
            }
          } else {
            if (menu == 'vertical-overlay-menu' || menu == 'vertical-menu-modern' || menu == 'horizontal-menu') {
              this.open();
            } else {
              this.expand();
            }
          }
          break;
        case 'md':
        case 'sm':
          if (hidden === true) {
            this.open();
          } else {
            this.hide();
          }
          break;
        case 'xs':
          if (hidden === true) {
            this.open();
          } else {
            this.hide();
          }
          break;
      }
    },
    update: function update() {
      this.manualScroller.update();
    },
    reset: function reset() {
      this.expanded = false;
      this.collapsed = false;
      this.hidden = false;
      $body.removeClass('menu-hide menu-open menu-collapsed menu-expanded');
    }
  };

  // Navigation Menu
  $.app.nav = {
    container: $('.navigation-main'),
    initialized: false,
    navItem: $('.navigation-main').find('li').not('.navigation-category'),
    TRANSITION_EVENTS: ['transitionend', 'webkitTransitionEnd', 'oTransitionEnd'],
    TRANSITION_PROPERTIES: ['transition', 'MozTransition', 'webkitTransition', 'WebkitTransition', 'OTransition'],
    config: {
      speed: 300
    },
    init: function init(config) {
      this.initialized = true; // Set to true when initialized
      $.extend(this.config, config);
      this.bind_events();
    },
    bind_events: function bind_events() {
      var menuObj = this;
      $('.navigation-main').on('mouseenter.app.menu', 'li', function () {
        var $this = $(this);
        // $('.hover', '.navigation-main').removeClass('hover');
        if ($body.hasClass('menu-collapsed') && $body.data('menu') != 'vertical-menu-modern') {
          $('.main-menu-content').children('span.menu-title').remove();
          $('.main-menu-content').children('a.menu-title').remove();
          $('.main-menu-content').children('ul.menu-content').remove();

          // Title
          var menuTitle = $this.find('span.menu-title').clone(),
            tempTitle,
            tempLink;
          if (!$this.hasClass('has-sub')) {
            tempTitle = $this.find('span.menu-title').text();
            tempLink = $this.children('a').attr('href');
            if (tempTitle !== '') {
              menuTitle = $('<a>');
              menuTitle.attr('href', tempLink);
              menuTitle.attr('title', tempTitle);
              menuTitle.text(tempTitle);
              menuTitle.addClass('menu-title');
            }
          }
          // menu_header_height = ($('.main-menu-header').length) ? $('.main-menu-header').height() : 0,
          // fromTop = menu_header_height + $this.position().top + parseInt($this.css( "border-top" ),10);
          var fromTop;
          if ($this.css('border-top')) {
            fromTop = $this.position().top + parseInt($this.css('border-top'), 10);
          } else {
            fromTop = $this.position().top;
          }
          if ($body.data('menu') !== 'vertical-compact-menu') {
            menuTitle.appendTo('.main-menu-content').css({
              position: 'fixed',
              top: fromTop
            });
          }

          // Content
          /* if ($this.hasClass('has-sub') && $this.hasClass('nav-item')) {
            var menuContent = $this.children('ul:first');
            menuObj.adjustSubmenu($this);
          } */
        }
        // $this.addClass('hover');
      }).on('mouseleave.app.menu', 'li', function () {
        // $(this).removeClass('hover');
      }).on('active.app.menu', 'li', function (e) {
        $(this).addClass('active');
        e.stopPropagation();
      }).on('deactive.app.menu', 'li.active', function (e) {
        $(this).removeClass('active');
        e.stopPropagation();
      }).on('open.app.menu', 'li', function (e) {
        var $listItem = $(this);
        menuObj.expand($listItem);
        // $listItem.addClass('open');

        // If menu collapsible then do not take any action
        if ($('.main-menu').hasClass('menu-collapsible')) {
          return false;
        }
        // If menu accordion then close all except clicked once
        else {
          $listItem.siblings('.open').find('li.open').trigger('close.app.menu');
          $listItem.siblings('.open').trigger('close.app.menu');
        }
        e.stopPropagation();
      }).on('close.app.menu', 'li.open', function (e) {
        var $listItem = $(this);
        menuObj.collapse($listItem);
        // $listItem.removeClass('open');

        e.stopPropagation();
      }).on('click.app.menu', 'li', function (e) {
        var $listItem = $(this);
        if ($listItem.is('.disabled')) {
          e.preventDefault();
        } else {
          if ($body.hasClass('menu-collapsed') && $body.data('menu') != 'vertical-menu-modern') {
            e.preventDefault();
          } else {
            if ($listItem.has('ul').length) {
              if ($listItem.is('.open')) {
                $listItem.trigger('close.app.menu');
              } else {
                $listItem.trigger('open.app.menu');
              }
            } else {
              if (!$listItem.is('.active')) {
                $listItem.siblings('.active').trigger('deactive.app.menu');
                $listItem.trigger('active.app.menu');
              }
            }
          }
        }
        e.stopPropagation();
      });
      $('.navbar-header, .main-menu').on('mouseenter', modernMenuExpand).on('mouseleave', modernMenuCollapse);
      function modernMenuExpand() {
        if ($body.data('menu') == 'vertical-menu-modern') {
          $('.main-menu, .navbar-header').addClass('expanded');
          if ($body.hasClass('menu-collapsed')) {
            if ($('.main-menu li.open').length === 0) {
              $('.main-menu-content').find('li.active').parents('li').addClass('open');
            }
            var $listItem = $('.main-menu li.menu-collapsed-open'),
              $subList = $listItem.children('ul');
            $subList.hide().slideDown(200, function () {
              $(this).css('display', '');
            });
            $listItem.addClass('open').removeClass('menu-collapsed-open');
            // $.app.menu.changeLogo('expand');
          }
        }
      }
      function modernMenuCollapse() {
        if ($body.hasClass('menu-collapsed') && $body.data('menu') == 'vertical-menu-modern') {
          setTimeout(function () {
            if ($('.main-menu:hover').length === 0 && $('.navbar-header:hover').length === 0) {
              $('.main-menu, .navbar-header').removeClass('expanded');
              if ($body.hasClass('menu-collapsed')) {
                var $listItem = $('.main-menu li.open'),
                  $subList = $listItem.children('ul');
                $listItem.addClass('menu-collapsed-open');
                $subList.show().slideUp(200, function () {
                  $(this).css('display', '');
                });
                $listItem.removeClass('open');
                // $.app.menu.changeLogo();
              }
            }
          }, 1);
        }
      }
      $('.main-menu-content').on('mouseleave', function () {
        if ($body.hasClass('menu-collapsed')) {
          $('.main-menu-content').children('span.menu-title').remove();
          $('.main-menu-content').children('a.menu-title').remove();
          $('.main-menu-content').children('ul.menu-content').remove();
        }
        $('.hover', '.navigation-main').removeClass('hover');
      });

      // If list item has sub menu items then prevent redirection.
      $('.navigation-main li.has-sub > a').on('click', function (e) {
        e.preventDefault();
      });
    },
    /**
     * Ensure an admin submenu is within the visual viewport.
     * @param {jQuery} $menuItem The parent menu item containing the submenu.
     */

    /* adjustSubmenu: function ($menuItem) {
      var menuHeaderHeight,
        menutop,
        topPos,
        winHeight,
        bottomOffset,
        subMenuHeight,
        popOutMenuHeight,
        borderWidth,
        scroll_theme,
        $submenu = $menuItem.children('ul:first'),
        ul = $submenu.clone(true);
        menuHeaderHeight = $('.main-menu-header').height();
      menutop = $menuItem.position().top;
      winHeight = $window.height() - $('.header-navbar').height();
      borderWidth = 0;
      subMenuHeight = $submenu.height();
        if (parseInt($menuItem.css('border-top'), 10) > 0) {
        borderWidth = parseInt($menuItem.css('border-top'), 10);
      }
        popOutMenuHeight = winHeight - menutop - $menuItem.height() - 30;
      scroll_theme = $('.main-menu').hasClass('menu-dark') ? 'light' : 'dark';
        topPos = menutop + $menuItem.height() + borderWidth;
        ul.addClass('menu-popout').appendTo('.main-menu-content').css({
        top: topPos,
        position: 'fixed',
        'max-height': popOutMenuHeight
      });
        var menu_content = new PerfectScrollbar('.main-menu-content > ul.menu-content', {
        wheelPropagation: false
      });
    }, */

    // Collapse Submenu With Transition (Height animation)
    collapse: function collapse($listItem, callback) {
      var subList = $listItem.children('ul'),
        toggleLink = $listItem.children().first(),
        linkHeight = $(toggleLink).outerHeight();
      $listItem.css({
        height: linkHeight + subList.outerHeight() + 'px',
        overflow: 'hidden'
      });
      $listItem.addClass('menu-item-animating');
      $listItem.addClass('menu-item-closing');
      $.app.nav._bindAnimationEndEvent($listItem, function () {
        $listItem.removeClass('open');
        $.app.nav._clearItemStyle($listItem);
      });
      setTimeout(function () {
        $listItem.css({
          height: linkHeight + 'px'
        });
      }, 50);
    },
    // Expand Submenu With Transition (Height animation)
    expand: function expand($listItem, callback) {
      var subList = $listItem.children('ul'),
        toggleLink = $listItem.children().first(),
        linkHeight = $(toggleLink).outerHeight();
      $listItem.addClass('menu-item-animating');
      $listItem.css({
        overflow: 'hidden',
        height: linkHeight + 'px'
      });
      $listItem.addClass('open');
      $.app.nav._bindAnimationEndEvent($listItem, function () {
        $.app.nav._clearItemStyle($listItem);
      });
      setTimeout(function () {
        $listItem.css({
          height: linkHeight + subList.outerHeight() + 'px'
        });
      }, 50);
    },
    _bindAnimationEndEvent: function _bindAnimationEndEvent(el, handler) {
      el = el[0];
      var cb = function cb(e) {
        if (e.target !== el) return;
        $.app.nav._unbindAnimationEndEvent(el);
        handler(e);
      };
      var duration = window.getComputedStyle(el).transitionDuration;
      duration = parseFloat(duration) * (duration.indexOf('ms') !== -1 ? 1 : 1000);
      el._menuAnimationEndEventCb = cb;
      $.app.nav.TRANSITION_EVENTS.forEach(function (ev) {
        el.addEventListener(ev, el._menuAnimationEndEventCb, false);
      });
      el._menuAnimationEndEventTimeout = setTimeout(function () {
        cb({
          target: el
        });
      }, duration + 50);
    },
    _unbindAnimationEndEvent: function _unbindAnimationEndEvent(el) {
      var cb = el._menuAnimationEndEventCb;
      if (el._menuAnimationEndEventTimeout) {
        clearTimeout(el._menuAnimationEndEventTimeout);
        el._menuAnimationEndEventTimeout = null;
      }
      if (!cb) return;
      $.app.nav.TRANSITION_EVENTS.forEach(function (ev) {
        el.removeEventListener(ev, cb, false);
      });
      el._menuAnimationEndEventCb = null;
    },
    _clearItemStyle: function _clearItemStyle($listItem) {
      $listItem.removeClass('menu-item-animating');
      $listItem.removeClass('menu-item-closing');
      $listItem.css({
        overflow: '',
        height: ''
      });
    },
    refresh: function refresh() {
      $.app.nav.container.find('.open').removeClass('open');
    }
  };

  // On href=# click page refresh issue resolve
  //? User should remove this code for their project to enable # click
  $(document).on('click', 'a[href="#"]', function (e) {
    e.preventDefault();
  });
})(window, document, jQuery);

// We listen to the resize event
window.addEventListener('resize', function () {
  // We execute the same script as before
  var vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', vh + 'px');
});
/******/ })()
;