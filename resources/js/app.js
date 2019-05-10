// Utility function
function Util() {};

/* 
	class manipulation functions
*/
Util.hasClass = function (el, className) {
    if (el.classList) return el.classList.contains(className);
    else return !!el.className.match(new RegExp('(\\s|^)' + className + '(\\s|$)'));
};

Util.addClass = function (el, className) {
    var classList = className.split(' ');
    if (el.classList) el.classList.add(classList[0]);
    else if (!Util.hasClass(el, classList[0])) el.className += " " + classList[0];
    if (classList.length > 1) Util.addClass(el, classList.slice(1).join(' '));
};

Util.removeClass = function (el, className) {
    var classList = className.split(' ');
    if (el.classList) el.classList.remove(classList[0]);
    else if (Util.hasClass(el, classList[0])) {
        var reg = new RegExp('(\\s|^)' + classList[0] + '(\\s|$)');
        el.className = el.className.replace(reg, ' ');
    }
    if (classList.length > 1) Util.removeClass(el, classList.slice(1).join(' '));
};

Util.toggleClass = function (el, className, bool) {
    if (bool) Util.addClass(el, className);
    else Util.removeClass(el, className);
};

Util.setAttributes = function (el, attrs) {
    for (var key in attrs) {
        el.setAttribute(key, attrs[key]);
    }
};

/* 
  DOM manipulation
*/
Util.getChildrenByClassName = function (el, className) {
    var children = el.children,
        childrenByClass = [];
    for (var i = 0; i < el.children.length; i++) {
        if (Util.hasClass(el.children[i], className)) childrenByClass.push(el.children[i]);
    }
    return childrenByClass;
};

Util.is = function (elem, selector) {
    if (selector.nodeType) {
        return elem === selector;
    }

    var qa = (typeof (selector) === 'string' ? document.querySelectorAll(selector) : selector),
        length = qa.length,
        returnArr = [];

    while (length--) {
        if (qa[length] === elem) {
            return true;
        }
    }

    return false;
};

/* 
	Animate height of an element
*/
Util.setHeight = function (start, to, element, duration, cb) {
    var change = to - start,
        currentTime = null;

    var animateHeight = function (timestamp) {
        if (!currentTime) currentTime = timestamp;
        var progress = timestamp - currentTime;
        var val = parseInt((progress / duration) * change + start);
        element.style.height = val + "px";
        if (progress < duration) {
            window.requestAnimationFrame(animateHeight);
        } else {
            cb();
        }
    };

    //set the height of the element before starting animation -> fix bug on Safari
    element.style.height = start + "px";
    window.requestAnimationFrame(animateHeight);
};

/* 
	Smooth Scroll
*/

Util.scrollTo = function (final, duration, cb) {
    var start = window.scrollY || document.documentElement.scrollTop,
        currentTime = null;

    var animateScroll = function (timestamp) {
        if (!currentTime) currentTime = timestamp;
        var progress = timestamp - currentTime;
        if (progress > duration) progress = duration;
        var val = Math.easeInOutQuad(progress, start, final - start, duration);
        window.scrollTo(0, val);
        if (progress < duration) {
            window.requestAnimationFrame(animateScroll);
        } else {
            cb && cb();
        }
    };

    window.requestAnimationFrame(animateScroll);
};

/* 
  Focus utility classes
*/

//Move focus to an element
Util.moveFocus = function (element) {
    if (!element) element = document.getElementsByTagName("body")[0];
    element.focus();
    if (document.activeElement !== element) {
        element.setAttribute('tabindex', '-1');
        element.focus();
    }
};

/* 
  Misc
*/

Util.getIndexInArray = function (array, el) {
    return Array.prototype.indexOf.call(array, el);
};

Util.cssSupports = function (property, value) {
    if ('CSS' in window) {
        return CSS.supports(property, value);
    } else {
        var jsProperty = property.replace(/-([a-z])/g, function (g) {
            return g[1].toUpperCase();
        });
        return jsProperty in document.body.style;
    }
};

// merge a set of user options into plugin defaults
// https://gomakethings.com/vanilla-javascript-version-of-jquery-extend/
Util.extend = function () {
    // Variables
    var extended = {};
    var deep = false;
    var i = 0;
    var length = arguments.length;

    // Check if a deep merge
    if (Object.prototype.toString.call(arguments[0]) === '[object Boolean]') {
        deep = arguments[0];
        i++;
    }

    // Merge the object into the extended object
    var merge = function (obj) {
        for (var prop in obj) {
            if (Object.prototype.hasOwnProperty.call(obj, prop)) {
                // If deep merge and property is an object, merge properties
                if (deep && Object.prototype.toString.call(obj[prop]) === '[object Object]') {
                    extended[prop] = extend(true, extended[prop], obj[prop]);
                } else {
                    extended[prop] = obj[prop];
                }
            }
        }
    };

    // Loop through each object and conduct a merge
    for (; i < length; i++) {
        var obj = arguments[i];
        merge(obj);
    }

    return extended;
};

/* 
	Polyfills
*/
//Closest() method
if (!Element.prototype.matches) {
    Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
}

if (!Element.prototype.closest) {
    Element.prototype.closest = function (s) {
        var el = this;
        if (!document.documentElement.contains(el)) return null;
        do {
            if (el.matches(s)) return el;
            el = el.parentElement || el.parentNode;
        } while (el !== null && el.nodeType === 1);
        return null;
    };
}

//Custom Event() constructor
if (typeof window.CustomEvent !== "function") {

    function CustomEvent(event, params) {
        params = params || {
            bubbles: false,
            cancelable: false,
            detail: undefined
        };
        var evt = document.createEvent('CustomEvent');
        evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
        return evt;
    }

    CustomEvent.prototype = window.Event.prototype;

    window.CustomEvent = CustomEvent;
}

/* 
	Animation curves
*/
Math.easeInOutQuad = function (t, b, c, d) {
    t /= d / 2;
    if (t < 1) return c / 2 * t * t + b;
    t--;
    return -c / 2 * (t * (t - 2) - 1) + b;
};

(function () {
    var alertClose = document.getElementsByClassName('js-alert__close-btn');
    if (alertClose.length > 0) {
        for (var i = 0; i < alertClose.length; i++) {
            (function (i) {
                initAlertEvent(alertClose[i]);
            })(i);
        }
    };
}());

(function () {
    var menuAim = function (opts) {
        init(opts);
    };
    window.menuAim = menuAim;

    function init(opts) {
        var activeRow = null,
            mouseLocs = [],
            lastDelayLoc = null,
            timeoutId = null,
            options = Util.extend({
                menu: '',
                rows: false,
                submenuSelector: "*",
                submenuDirection: "right",
                tolerance: 75,
                enter: function () {},
                exit: function () {},
                activate: function () {},
                deactivate: function () {},
                exitMenu: function () {}
            }, opts),
            menu = options.menu;
        var MOUSE_LOCS_TRACKED = 3,
            DELAY = 300;
        var mousemoveDocument = function (e) {
            mouseLocs.push({
                x: e.pageX,
                y: e.pageY
            });
            if (mouseLocs.length > MOUSE_LOCS_TRACKED) {
                mouseLocs.shift();
            }
        };
        var mouseleaveMenu = function () {
            if (timeoutId) {
                clearTimeout(timeoutId);
            }
            if (options.exitMenu(this)) {
                if (activeRow) {
                    options.deactivate(activeRow);
                }
                activeRow = null;
            }
        };
        var mouseenterRow = function () {
                if (timeoutId) {
                    clearTimeout(timeoutId);
                }
                options.enter(this);
                possiblyActivate(this);
            },
            mouseleaveRow = function () {
                options.exit(this);
            };
        var clickRow = function () {
            activate(this);
        };
        var activate = function (row) {
            if (row == activeRow) {
                return;
            }
            if (activeRow) {
                options.deactivate(activeRow);
            }
            options.activate(row);
            activeRow = row;
        };
        var possiblyActivate = function (row) {
            var delay = activationDelay();
            if (delay) {
                timeoutId = setTimeout(function () {
                    possiblyActivate(row);
                }, delay);
            } else {
                activate(row);
            }
        };
        var activationDelay = function () {
            if (!activeRow || !Util.is(activeRow, options.submenuSelector)) {
                return 0;
            }

            function getOffset(element) {
                var rect = element.getBoundingClientRect();
                return {
                    top: rect.top + window.pageYOffset,
                    left: rect.left + window.pageXOffset
                };
            };
            var offset = getOffset(menu),
                upperLeft = {
                    x: offset.left,
                    y: offset.top - options.tolerance
                },
                upperRight = {
                    x: offset.left + menu.offsetWidth,
                    y: upperLeft.y
                },
                lowerLeft = {
                    x: offset.left,
                    y: offset.top + menu.offsetHeight + options.tolerance
                },
                lowerRight = {
                    x: offset.left + menu.offsetWidth,
                    y: lowerLeft.y
                },
                loc = mouseLocs[mouseLocs.length - 1],
                prevLoc = mouseLocs[0];
            if (!loc) {
                return 0;
            }
            if (!prevLoc) {
                prevLoc = loc;
            }
            if (prevLoc.x < offset.left || prevLoc.x > lowerRight.x || prevLoc.y < offset.top || prevLoc.y > lowerRight.y) {
                return 0;
            }
            if (lastDelayLoc && loc.x == lastDelayLoc.x && loc.y == lastDelayLoc.y) {
                return 0;
            }

            function slope(a, b) {
                return (b.y - a.y) / (b.x - a.x);
            };
            var decreasingCorner = upperRight,
                increasingCorner = lowerRight;
            if (options.submenuDirection == "left") {
                decreasingCorner = lowerLeft;
                increasingCorner = upperLeft;
            } else if (options.submenuDirection == "below") {
                decreasingCorner = lowerRight;
                increasingCorner = lowerLeft;
            } else if (options.submenuDirection == "above") {
                decreasingCorner = upperLeft;
                increasingCorner = upperRight;
            }
            var decreasingSlope = slope(loc, decreasingCorner),
                increasingSlope = slope(loc, increasingCorner),
                prevDecreasingSlope = slope(prevLoc, decreasingCorner),
                prevIncreasingSlope = slope(prevLoc, increasingCorner);
            if (decreasingSlope < prevDecreasingSlope && increasingSlope > prevIncreasingSlope) {
                lastDelayLoc = loc;
                return DELAY;
            }
            lastDelayLoc = null;
            return 0;
        };
        menu.addEventListener('mouseleave', mouseleaveMenu);
        var rows = (options.rows) ? options.rows : menu.children;
        if (rows.length > 0) {
            for (var i = 0; i < rows.length; i++) {
                (function (i) {
                    rows[i].addEventListener('mouseenter', mouseenterRow);
                    rows[i].addEventListener('mouseleave', mouseleaveRow);
                    rows[i].addEventListener('click', clickRow);
                })(i);
            }
        }
        document.addEventListener('mousemove', function (event) {
            (!window.requestAnimationFrame) ? mousemoveDocument(event): window.requestAnimationFrame(function () {
                mousemoveDocument(event);
            });
        });
    };
}());

// Alert
function initAlertEvent(element) {
    element.addEventListener('click', function (event) {
        event.preventDefault();
        Util.removeClass(element.closest('.js-alert'), 'alert--is-visible');
    });
};

// Dropdown
(function () {
    var Dropdown = function (element) {
        this.element = element;
        this.trigger = this.element.getElementsByClassName('dropdown__trigger')[0];
        this.dropdown = this.element.getElementsByClassName('dropdown__menu')[0];
        this.triggerFocus = false;
        this.dropdownFocus = false;
        this.hideInterval = false;
        // sublevels
        this.dropdownSubElements = this.element.getElementsByClassName('dropdown__sub-wrapperu');
        this.prevFocus = false; // store element that was in focus before focus changed
        this.addDropdownEvents();
    };

    Dropdown.prototype.addDropdownEvents = function () {
        // init dropdown
        this.initElementEvents(this.trigger, this.triggerFocus); // this is used to trigger the primary dropdown
        this.initElementEvents(this.dropdown, this.dropdownFocus); // this is used to trigger the primary dropdown
        // init sublevels
        this.initSublevels(); // if there are additional sublevels -> bind hover/focus events
    };

    Dropdown.prototype.initElementEvents = function (element, bool) {
        var self = this;
        element.addEventListener('mouseenter', function () {
            bool = true;
            self.showDropdown();
        });
        element.addEventListener('focus', function () {
            self.showDropdown();
        });
        element.addEventListener('mouseleave', function () {
            bool = false;
            self.hideDropdown();
        });
        element.addEventListener('focusout', function () {
            self.hideDropdown();
        });
    };

    Dropdown.prototype.showDropdown = function () {
        if (this.hideInterval) clearInterval(this.hideInterval);
        this.showLevel(this.dropdown, true);
    };

    Dropdown.prototype.hideDropdown = function () {
        var self = this;
        if (this.hideInterval) clearInterval(this.hideInterval);
        this.hideInterval = setTimeout(function () {
            var dropDownFocus = document.activeElement.closest('.js-dropdown'),
                inFocus = dropDownFocus && (dropDownFocus == self.element);
            // if not in focus and not hover -> hide
            if (!self.triggerFocus && !self.dropdownFocus && !inFocus) {
                self.hideLevel(self.dropdown);
                // make sure to hide sub/dropdown
                self.hideSubLevels();
                self.prevFocus = false;
            }
        }, 300);
    };

    Dropdown.prototype.initSublevels = function () {
        var self = this;
        var dropdownMenu = this.element.getElementsByClassName('dropdown__menu');
        for (var i = 0; i < dropdownMenu.length; i++) {
            var listItems = dropdownMenu[i].children;
            // bind hover
            new menuAim({
                menu: dropdownMenu[i],
                activate: function (row) {
                    var subList = row.getElementsByClassName('dropdown__menu')[0];
                    if (!subList) return;
                    Util.addClass(row.querySelector('a'), 'dropdown__item--hover');
                    self.showLevel(subList);
                },
                deactivate: function (row) {
                    var subList = row.getElementsByClassName('dropdown__menu')[0];
                    if (!subList) return;
                    Util.removeClass(row.querySelector('a'), 'dropdown__item--hover');
                    self.hideLevel(subList);
                },
                submenuSelector: '.dropdown__sub-wrapper',
            });
        }
        // store focus element before change in focus
        this.element.addEventListener('keydown', function (event) {
            if (event.keyCode && event.keyCode == 9 || event.key && event.key == 'Tab') {
                self.prevFocus = document.activeElement;
            }
        });
        // make sure that sublevel are visible when their items are in focus
        this.element.addEventListener('keyup', function (event) {
            if (event.keyCode && event.keyCode == 9 || event.key && event.key == 'Tab') {
                // focus has been moved -> make sure the proper classes are added to subnavigation
                var focusElement = document.activeElement,
                    focusElementParent = focusElement.closest('.dropdown__menu'),
                    focusElementSibling = focusElement.nextElementSibling;

                // if item in focus is inside submenu -> make sure it is visible
                if (focusElementParent && !Util.hasClass(focusElementParent, 'dropdown__menu--is-visible')) {
                    self.showLevel(focusElementParent);
                }
                // if item in focus triggers a submenu -> make sure it is visible
                if (focusElementSibling && !Util.hasClass(focusElementSibling, 'dropdown__menu--is-visible')) {
                    self.showLevel(focusElementSibling);
                }

                // check previous element in focus -> hide sublevel if required 
                if (!self.prevFocus) return;
                var prevFocusElementParent = self.prevFocus.closest('.dropdown__menu'),
                    prevFocusElementSibling = self.prevFocus.nextElementSibling;

                if (!prevFocusElementParent) return;

                // element in focus and element prev in focus are siblings
                if (focusElementParent && focusElementParent == prevFocusElementParent) {
                    if (prevFocusElementSibling) self.hideLevel(prevFocusElementSibling);
                    return;
                }

                // element in focus is inside submenu triggered by element prev in focus
                if (prevFocusElementSibling && focusElementParent && focusElementParent == prevFocusElementSibling) return;

                // shift tab -> element in focus triggers the submenu of the element prev in focus
                if (focusElementSibling && prevFocusElementParent && focusElementSibling == prevFocusElementParent) return;

                var focusElementParentParent = focusElementParent.parentNode.closest('.dropdown__menu');

                // shift tab -> element in focus is inside the dropdown triggered by a siblings of the element prev in focus
                if (focusElementParentParent && focusElementParentParent == prevFocusElementParent) {
                    if (prevFocusElementSibling) self.hideLevel(prevFocusElementSibling);
                    return;
                }

                if (prevFocusElementParent && Util.hasClass(prevFocusElementParent, 'dropdown__menu--is-visible')) {
                    self.hideLevel(prevFocusElementParent);
                }
            }
        });
    };

    Dropdown.prototype.hideSubLevels = function () {
        var visibleSubLevels = this.dropdown.getElementsByClassName('dropdown__menu--is-visible');
        if (visibleSubLevels.length == 0) return;
        while (visibleSubLevels[0]) {
            this.hideLevel(visibleSubLevels[0]);
        }
        var hoveredItems = this.dropdown.getElementsByClassName('dropdown__item--hover');
        while (hoveredItems[0]) {
            Util.removeClass(hoveredItems[0], 'dropdown__item--hover');
        }
    };

    Dropdown.prototype.showLevel = function (level, bool) {
        if (bool == undefined) {
            //check if the sublevel needs to be open to the left
            Util.removeClass(level, 'dropdown__menu--left');
            var boundingRect = level.getBoundingClientRect();
            if (window.innerWidth - boundingRect.right < 5 && boundingRect.left + window.scrollX > 2 * boundingRect.width) Util.addClass(level, 'dropdown__menu--left');
        }
        Util.addClass(level, 'dropdown__menu--is-visible');
        Util.removeClass(level, 'dropdown__menu--is-hidden');
    };

    Dropdown.prototype.hideLevel = function (level) {
        if (!Util.hasClass(level, 'dropdown__menu--is-visible')) return;
        Util.removeClass(level, 'dropdown__menu--is-visible');
        Util.addClass(level, 'dropdown__menu--is-hidden');

        level.addEventListener('animationend', function cb() {
            level.removeEventListener('animationend', cb);
            Util.removeClass(level, 'dropdown__menu--is-hidden dropdown__menu--left');
        });
    };


    var dropdown = document.getElementsByClassName('js-dropdown');
    if (dropdown.length > 0) { // init Dropdown objects
        for (var i = 0; i < dropdown.length; i++) {
            (function (i) {
                new Dropdown(dropdown[i]);
            })(i);
        }
    }
}());

// Menu
(function () {
    var Menu = function (element) {
        this.element = element;
        this.menu = this.element.getElementsByClassName('js-menu')[0];
        this.menuItems = this.menu.getElementsByClassName('js-menu__item');
        this.trigger = this.element.getElementsByClassName('js-menu-trigger')[0];
        this.initMenu();
        this.initMenuEvents();
    };

    Menu.prototype.initMenu = function () {
        // init aria-labels
        Util.setAttributes(this.trigger, {
            'aria-expanded': 'false',
            'aria-haspopup': 'true',
            'aria-controls': this.menu.getAttribute('id')
        });
    };

    Menu.prototype.initMenuEvents = function () {
        var self = this;
        this.trigger.addEventListener('click', function (event) {
            event.preventDefault();
            self.toggleMenu(!Util.hasClass(self.menu, 'menu--is-visible'), true);
        });
        // keyboard events
        this.element.addEventListener('keydown', function (event) {
            // use up/down arrow to navigate list of menu items
            if (!Util.hasClass(event.target, 'js-menu__item')) return;
            if ((event.keyCode && event.keyCode == 40) || (event.key && event.key.toLowerCase() == 'arrowdown')) {
                self.navigateItems(event, 'next');
            } else if ((event.keyCode && event.keyCode == 38) || (event.key && event.key.toLowerCase() == 'arrowup')) {
                self.navigateItems(event, 'prev');
            }
        });
    };

    Menu.prototype.toggleMenu = function (bool, moveFocus) {
        var self = this;
        // toggle menu visibility
        Util.toggleClass(this.menu, 'menu--is-visible', bool);
        if (bool) {
            this.trigger.setAttribute('aria-expanded', 'true');
            Util.moveFocus(this.menuItems[0]);
            this.menu.addEventListener("transitionend", function (event) {
                Util.moveFocus(self.menuItems[0]);
            }, {
                once: true
            });
        } else {
            this.trigger.setAttribute('aria-expanded', 'false');
            if (moveFocus) Util.moveFocus(this.trigger);
        }
    };

    Menu.prototype.navigateItems = function (event, direction) {
        event.preventDefault();
        var index = Util.getIndexInArray(this.menuItems, event.target),
            nextIndex = direction == 'next' ? index + 1 : index - 1;
        if (nextIndex < 0) nextIndex = this.menuItems.length - 1;
        if (nextIndex > this.menuItems.length - 1) nextIndex = 0;
        Util.moveFocus(this.menuItems[nextIndex]);
    };

    Menu.prototype.checkMenuFocus = function () {
        var menuParent = document.activeElement.closest('.js-menu');
        if (!menuParent || !this.element.contains(menuParent)) this.toggleMenu(false, false);
    };

    Menu.prototype.checkMenuClick = function (target) {
        if (!this.element.contains(target)) this.toggleMenu(false);
    };

    //initialize the Menu objects
    var menus = document.getElementsByClassName('js-menu-wrapper');
    if (menus.length > 0) {
        var menusArray = [];
        for (var i = 0; i < menus.length; i++) {
            (function (i) {
                menusArray.push(new Menu(menus[i]));
            })(i);
        }

        // listen for key events
        window.addEventListener('keyup', function (event) {
            if (event.keyCode && event.keyCode == 9 || event.key && event.key.toLowerCase() == 'tab') {
                //close menu if focus is outside menu element
                menusArray.forEach(function (element) {
                    element.checkMenuFocus();
                });
            } else if (event.keyCode && event.keyCode == 27 || event.key && event.key.toLowerCase() == 'escape') {
                // close menu on 'Esc'
                menusArray.forEach(function (element) {
                    element.toggleMenu(false, false);
                });
            }
        });
        // close menu when clicking outside it
        window.addEventListener('click', function (event) {
            menusArray.forEach(function (element) {
                element.checkMenuClick(event.target);
            });
        });
    }
}());

// Modal
(function () {
    var Modal = function (element) {
        this.element = element;
        this.triggers = document.querySelectorAll('[aria-controls="' + this.element.getAttribute('id') + '"]');
        this.firstFocusable = null;
        this.lastFocusable = null;
        this.selectedTrigger = null;
        this.showClass = "modal--is-visible";
        this.initModal();
    };

    Modal.prototype.initModal = function () {
        var self = this;
        //open modal when clicking on trigger buttons
        if (this.triggers) {
            for (var i = 0; i < this.triggers.length; i++) {
                this.triggers[i].addEventListener('click', function (event) {
                    event.preventDefault();
                    self.selectedTrigger = event.target;
                    self.showModal();
                    self.initModalEvents();
                });
            }
        }

        // listen to the openModal event -> open modal without a trigger button
        this.element.addEventListener('openModal', function (event) {
            if (event.detail) self.selectedTrigger = event.detail;
            self.showModal();
            self.initModalEvents();
        });
    };

    Modal.prototype.showModal = function () {
        var self = this;
        Util.addClass(this.element, this.showClass);
        this.getFocusableElements();
        this.firstFocusable.focus();
        // wait for the end of transitions before moving focus
        this.element.addEventListener("transitionend", function cb(event) {
            self.firstFocusable.focus();
            self.element.removeEventListener("transitionend", cb);
        });
        this.emitModalEvents('modalIsOpen');
    };

    Modal.prototype.closeModal = function () {
        Util.removeClass(this.element, this.showClass);
        this.firstFocusable = null;
        this.lastFocusable = null;
        if (this.selectedTrigger) this.selectedTrigger.focus();
        //remove listeners
        this.cancelModalEvents();
        this.emitModalEvents('modalIsClose');
    };

    Modal.prototype.initModalEvents = function () {
        //add event listeners
        this.element.addEventListener('keydown', this);
        this.element.addEventListener('click', this);
    };

    Modal.prototype.cancelModalEvents = function () {
        //remove event listeners
        this.element.removeEventListener('keydown', this);
        this.element.removeEventListener('click', this);
    };

    Modal.prototype.handleEvent = function (event) {
        switch (event.type) {
            case 'click': {
                this.initClick(event);
            }
            case 'keydown': {
                this.initKeyDown(event);
            }
        }
    };

    Modal.prototype.initKeyDown = function (event) {
        if (event.keyCode && event.keyCode == 27 || event.key && event.key == 'Escape') {
            //close modal window on esc
            this.closeModal();
        } else if (event.keyCode && event.keyCode == 9 || event.key && event.key == 'Tab') {
            //trap focus inside modal
            this.trapFocus(event);
        }
    };

    Modal.prototype.initClick = function (event) {
        //close modal when clicking on close button or modal bg layer 
        if (!event.target.closest('.js-modal__close') && !Util.hasClass(event.target, 'js-modal')) return;
        event.preventDefault();
        this.closeModal();
    };

    Modal.prototype.trapFocus = function (event) {
        if (this.firstFocusable == document.activeElement && event.shiftKey) {
            //on Shift+Tab -> focus last focusable element when focus moves out of modal
            event.preventDefault();
            this.lastFocusable.focus();
        }
        if (this.lastFocusable == document.activeElement && !event.shiftKey) {
            //on Tab -> focus first focusable element when focus moves out of modal
            event.preventDefault();
            this.firstFocusable.focus();
        }
    }

    Modal.prototype.getFocusableElements = function () {
        //get all focusable elements inside the modal
        var allFocusable = this.element.querySelectorAll('[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex]:not([tabindex="-1"]), [contenteditable], audio[controls], video[controls], summary');
        this.getFirstVisible(allFocusable);
        this.getLastVisible(allFocusable);
    };

    Modal.prototype.getFirstVisible = function (elements) {
        //get first visible focusable element inside the modal
        for (var i = 0; i < elements.length; i++) {
            if (elements[i].offsetWidth || elements[i].offsetHeight || elements[i].getClientRects().length) {
                this.firstFocusable = elements[i];
                return true;
            }
        }
    };

    Modal.prototype.getLastVisible = function (elements) {
        //get last visible focusable element inside the modal
        for (var i = elements.length - 1; i >= 0; i--) {
            if (elements[i].offsetWidth || elements[i].offsetHeight || elements[i].getClientRects().length) {
                this.lastFocusable = elements[i];
                return true;
            }
        }
    };

    Modal.prototype.emitModalEvents = function (eventName) {
        var event = new CustomEvent(eventName, {
            detail: this.selectedTrigger
        });
        this.element.dispatchEvent(event);
    };

    //initialize the Modal objects
    var modals = document.getElementsByClassName('js-modal');
    if (modals.length > 0) {
        for (var i = 0; i < modals.length; i++) {
            (function (i) {
                new Modal(modals[i]);
            })(i);
        }
    }
}());
