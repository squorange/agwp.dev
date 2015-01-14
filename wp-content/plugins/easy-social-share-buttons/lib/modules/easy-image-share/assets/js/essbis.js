! function(a) {
    String.format || (String.format = function(a) {
        var b = Array.prototype.slice.call(arguments, 1);
        return a.replace(/{(\d+)}/g, function(a, c) {
            return "undefined" != typeof b[c] ? b[c] : a
        })
    }), window.essbis = function() {
        var b = {
                beforeReady: 0,
                afterReady: 1
            },
            c = {
                state: b.beforeReady
            },
            d = {};
        d.attr = {}, d.attr.prefix = "data-essbis", d.attr.type = d.attr.prefix + "Type", d.attr.postTitle = d.attr.prefix + "PostTitle", d.attr.postUrl = d.attr.prefix + "PostUrl", d.attr.imageUrl = d.attr.prefix + "ImageUrl", d.attr.imageAlt = d.attr.prefix + "ImageAlt", d.attr.imageTitle = d.attr.prefix + "ImageTitle", d.attr.imageDescription = d.attr.prefix + "ImageDescription", d.attr.buttonSet = d.attr.prefix + "ButtonSet", d.attr.theme = d.attr.prefix + "Theme", d.attr.align = d.attr.prefix + "Align", d.cssClass = {}, d.cssClass.prefix = "essbis-", d.cssClass.container = d.cssClass.prefix + "container", d.cssClass.iconPrefix = d.cssClass.prefix + "icon-", d.cssClass.alignLeft = d.cssClass.prefix + "left", d.cssClass.alignCenter = d.cssClass.prefix + "center", d.cssClass.alignRight = d.cssClass.prefix + "right", d.buttonTypes = {
            pinterestShare: "pinterest",
            twitterShare: "twitter",
            facebookShare: "facebook"
        }, d.debug = function(a) {
            console.log("ESSBIS.log"), console.log(a)
        }, d.init = function() {
            var a = window.console = window.console || {};
            a.log || (a.log = function() {}), d.main.settings.debug = -1 != window.location.search.indexOf("essbisdebug")
        }, d.themes = {}, d.getTheme = function(a) {
            return d.themes.hasOwnProperty(a) ? d.themes[a] : d.themes.default48
        }, d.addTheme = function(a, b) {
            d.themes[a] = b
        };
        var e = {
            buttons: {}
        };
        return e.buttons[d.buttonTypes.pinterestShare] = {
            height: 48,
            width: 48
        }, e.buttons[d.buttonTypes.twitterShare] = {
            height: 48,
            width: 48
        }, e.buttons[d.buttonTypes.facebookShare] = {
            height: 48,
            width: 48
        }, d.addTheme("default48", e), d.buttonSets = {}, d.getButtonSet = function(a) {
            return d.buttonSets.hasOwnProperty(a) ? d.buttonSets[a] : d.buttonSets["default"]
        }, d.addButtonSet = function(a, b) {
            d.buttonSets[a] = b
        }, d.addButtonSet("default", [d.buttonTypes.pinterestShare, d.buttonTypes.facebookShare, d.buttonTypes.twitterShare]), d.getAlignmentClass = function(a) {
            switch (a) {
                case "right":
                    return d.cssClass.alignRight;
                case "center":
                    return d.cssClass.alignCenter;
                case "left":
                default:
                    return d.cssClass.alignLeft
            }
        }, d.moduleNames = {
            main: "main",
            hover: "hover",
            lightbox: "lightbox",
            shortcode: "shortcode",
            buttonSettings: "buttonSettings"
        }, d.module = {}, d.main = d.module[d.moduleNames.main] = function() {
            var b = {
                    debug: 1
                },
                c = {};
            return c.settings = b, c.setSettings = function(c) {
                b = a.extend(b, c)
            }, c
        }(), d.setSettings = function(a) {
            d.debug(a);
            for (var b in a.buttonSets) a.buttonSets.hasOwnProperty(b) && d.addButtonSet(b, a.buttonSets[b]);
            for (var c in a.themes) a.themes.hasOwnProperty(c) && d.addTheme(c, a.themes[c]);
            for (var e in a.modules) a.modules.hasOwnProperty(e) && d.module.hasOwnProperty(e) && d.module[e].setSettings(a.modules[e])
        }, d.triggerActiveModules = function(a) {
            for (var b in d.module) d.module.hasOwnProperty(b) && "function" == typeof d.module[b][a] && -1 != d.main.settings.activeModules.indexOf(b) && d.module[b][a]()
        }, d.call = function(e, f, g) {
            return c.state == b.beforeReady ? void a(this).bind("essbisReady", function() {
                d.call(e, f, g)
            }) : void(d.module.hasOwnProperty(e) && "function" == typeof d.module[e][f] && -1 != d.main.settings.activeModules.indexOf(e) && d.module[e][f].call(d.module[e], g))
        }, d.onReady = function() {
            d.debug("onReady"), d.triggerActiveModules("onReady"), c.state = b.afterReady, a(this).triggerHandler("essbisReady")
        }, d.onResize = function() {
            d.debug("onResize"), d.triggerActiveModules("onResize")
        }, d
    }(), a(function() {
        essbis.init(), essbis.setSettings(ESSBISSettings), essbis.onReady(), a(window).resize(essbis.onResize)
    })
}(jQuery),
function(a) {
    essbis.functions = {
        transferDataAttributes: function(a, b) {
            var c = a.data();
            for (var d in c) c.hasOwnProperty(d) && b.attr("data-" + d, c[d])
        },
        uniqueArray: function(b) {
            var c = [];
            return a.each(b, function(b, d) {
                -1 == a.inArray(d, c) && c.push(d)
            }), c
        },
        getUrlExtension: function(a) {
            var b = a.split(".");
            return 1 == b.length ? "" : b.pop().split(/\#|\?/)[0]
        },
        isInCurrentDomain: function(a) {
            var b = document.domain.replace(/^www./, "");
            return -1 != a.indexOf(b)
        },
        isImageExtension: function(a) {
            for (var b = ["jpg", "jpeg", "png", "bmp", "gif"], c = 0; c < b.length; c++)
                if (a == b[c].toLowerCase()) return !0;
            return !1
        },
        getLinkedImage: function(a) {
            var b = a.parents("a").first();
            if (b.length) {
                var c = b.attr("href"),
                    d = !!c,
                    e = essbis.functions.getUrlExtension(c);
                if (d && essbis.functions.isImageExtension(e) && essbis.functions.isInCurrentDomain(c)) return c
            }
            return ""
        }
    }
}(jQuery),
function(a) {
    essbis.baseClasses = {}, essbis.baseClasses.BaseElement = function() {
        this.$element = null
    }, essbis.baseClasses.BaseElement.prototype.addAttr = function(a, b) {
        this.$element.attr(a, b)
    }, essbis.baseClasses.BaseElement.prototype.addClass = function(a) {
        this.$element.addClass(a)
    }, essbis.baseClasses.BaseElement.prototype.click = function(a) {
        this.$element.click(a)
    }, essbis.baseClasses.Icon = function(b, c, d) {
        essbis.baseClasses.BaseElement.call(this), this.width = b, this.height = c, this.$element = a("<a/>"), this.addAttr(essbis.attr.type, d), this.addAttr("href", "#"), this.$iconElement = a("<div/>").addClass(essbis.cssClass.iconPrefix + d), this.$iconElement.html(a("<div/>").addClass(essbis.cssClass.prefix + "inner"))
    }, essbis.baseClasses.Icon.prototype = new essbis.baseClasses.BaseElement, essbis.baseClasses.Icon.prototype.createElement = function() {
        return this.$element.html(this.$iconElement)
    }, essbis.baseClasses.BaseContainer = function(b) {
        switch (this.icons = [], this.width = 0, this.height = 0, this.$element = a("<div/>"), b) {
            case "vertical":
                this.updateContainerSize = this.updateSizeVertical;
                break;
            case "horizontal":
                this.updateContainerSize = this.updateSizeHorizontal
        }
        this.addClass(essbis.cssClass.container)
    }, essbis.baseClasses.BaseContainer.prototype = new essbis.baseClasses.BaseElement, essbis.baseClasses.BaseContainer.prototype.updateSizeHorizontal = function(a, b) {
        this.width += a, this.height = b > this.height ? b : this.height
    }, essbis.baseClasses.BaseContainer.prototype.updateSizeVertical = function(a, b) {
        this.height += b, this.width = a > this.width ? a : this.width
    }, essbis.baseClasses.BaseContainer.prototype.createContainer = function() {
        for (var a = [], b = 0; b < this.icons.length; b++) a.push(this.icons[b].createElement());
        return this.$element.css("min-height", this.height + "px").css("min-width", this.width + "px").html(a)
    }, essbis.baseClasses.BaseContainer.prototype.addIcon = function(a) {
        return this.icons.push(a), this.updateContainerSize(a.width, a.height), this
    }, essbis.baseClasses.ClickHandlerArg = function() {
        this.url = "", this.imageAttributes = {
            src: "",
            title: "",
            alt: "",
            description: ""
        }, this.articleAttributes = {
            title: ""
        }
    }
}(jQuery),
function(a) {
    essbis.buttons = essbis.module[essbis.moduleNames.buttonSettings] = function() {
        function b(a, b, c, d) {
            var e = Math.round(screen.height / 2 - d / 2),
                f = Math.round(screen.width / 2 - c / 2),
                g = String.format("width={0},height={1},status=0,toolbar=0,menubar=0,location=1,scrollbars=1,top={2},left={3}", c, d, e, f);
            window.open(a, b, g)
        }

        function c(a, c) {
            var d = e.hasOwnProperty(a) ? e[a] : !1;
            return d && b(d.createLink(c), d.windowTitle, d.windowWidth, d.windowHeight), !1
        }
        var d = {
                pinterestImageDescription: ["titleAttribute", "altAttribute"],
                pinterestPinFullImages: "1",
                twitterHandle: ""
            },
            e = {};
        e[essbis.buttonTypes.pinterestShare] = {
            windowWidth: 632,
            windowHeight: 453,
            windowTitle: "Pinterest",
            createLink: function(a) {
                function b(a, b) {
                    switch (b) {
                        case "titleAttribute":
                            return a.imageAttributes.title;
                        case "altAttribute":
                            return a.imageAttributes.alt;
                        case "mediaLibraryDescription":
                            return a.imageAttributes.description;
                        case "postTitle":
                            return a.articleAttributes.title;
                        default:
                            return ""
                    }
                }
                for (var c = "", e = 0; e < d.pinterestImageDescription.length && !c; e++) c = b(a, d.pinterestImageDescription[e]);
                return String.format("http://pinterest.com/pin/create/bookmarklet/?is_video=false&url={0}&media={1}&description={2}", encodeURIComponent(a.url), encodeURIComponent(a.imageAttributes.src), encodeURIComponent(c))
            }
        }, e[essbis.buttonTypes.twitterShare] = {
            windowWidth: 550,
            windowHeight: 470,
            windowTitle: "Twitter",
            createLink: function(a) {
                var b = "";
                return d.twitterHandle && (b = String.format("&via={0}", d.twitterHandle)), String.format("https://twitter.com/intent/tweet?text={0}&url={1}{2}", encodeURIComponent(a.articleAttributes.title), encodeURIComponent(a.url), b)
            }
        }, e[essbis.buttonTypes.facebookShare] = {
            windowWidth: 550,
            windowHeight: 420,
            windowTitle: "Facebook",
            createLink: function(a) {
                return String.format("https://www.facebook.com/sharer/sharer.php?u={0}&display=popup", encodeURIComponent(a.url))
            }
        };
        var f = {};
        return f.settings = d, f.setSettings = function(b) {
            d = a.extend(d, b)
        }, f.handleClick = function(a, b) {
            return c(a, b)
        }, f
    }()
}(jQuery),
function(a) {
    essbis[essbis.moduleNames.hover] = essbis.module[essbis.moduleNames.hover] = function() {
        function b(a, b) {
            essbis.baseClasses.BaseContainer.call(this, a), this.addClass(t.overlay), this.addAttr(s.index, b)
        }

        function c() {
            return ++r
        }

        function d(a) {
            return a[0].clientHeight >= u.minImageHeight && a[0].clientWidth >= u.minImageWidth && a.not(u.disabledClasses).length > 0 && a.filter(u.enabledClasses).length > 0
        }

        function e(a, b, c) {
            var d = a.parents(String.format("[{0}]", s.postContainer));
            return d.attr(b) || c
        }

        function f(a) {
            return e(a, essbis.attr.postUrl, document.URL)
        }

        function g(a) {
            return e(a, essbis.attr.postTitle, document.title)
        }

        function h(a, b) {
            var c = 0,
                d = 0,
                e = function() {
                    return Math.round(a.height / 2 - b.height / 2)
                },
                f = function() {
                    return Math.round(a.height - b.height)
                },
                g = function() {
                    return Math.round(a.width / 2 - b.width / 2)
                },
                h = function() {
                    return Math.round(a.width - b.width)
                };
            switch (u.hoverPanelPosition) {
                case "top-left":
                    c = 0, d = 0;
                    break;
                case "top-middle":
                    c = 0, d = g();
                    break;
                case "top-right":
                    c = 0, d = h();
                    break;
                case "middle-left":
                    c = e(), d = 0;
                    break;
                case "middle-middle":
                    c = e(), d = g();
                    break;
                case "middle-right":
                    c = e(), d = h();
                    break;
                case "bottom-left":
                    c = f(), d = 0;
                    break;
                case "bottom-middle":
                    c = f(), d = g();
                    break;
                case "bottom-right":
                    c = f(), d = h()
            }
            return {
                top: c + u.hoverPanelOffsetTop,
                left: d + u.hoverPanelOffsetLeft
            }
        }

        function i(a) {
            return void 0 !== a ? String.format('div.{0}[{1}="{2}"]', t.overlay, s.index, a) : String.format("div.{0}", t.overlay)
        }

        function j() {
            var a = [];
            return "1" == u.showOnLightbox && a.push("img.cboxPhoto"), "" !== u.imageSelector && a.push(String.format("{0}:not([{1}])", u.imageSelector, s.ignore)), a.join(",")
        }

        function k(b) {
            var c = b.prop("tagName"),
                d = "",
                e = "";
            switch (c.toLowerCase()) {
                case "div":
                case "span":
                    d = b.css("background-image").replace(/^url\(["']?/, "").replace(/["']?\)$/, "");
                    break;
                case "img":
                    d = a.fn.prop && b.prop("src") || b.attr("src");
                    break;
                default:
                    return ""
            }
            return "1" == essbis.buttons.settings.generalUseFullImages && (e = essbis.functions.getLinkedImage(b) || d), "" != e ? e : d
        }

        function l(a) {
            var c = u.theme,
                d = essbis.getButtonSet(u.buttonSet),
                e = essbis.getTheme(c),
                f = new b(u.orientation, a);
            f.addClass("essbis-" + c);
            for (var g = 0; g < d.length; g++) {
                var h = new essbis.baseClasses.Icon(e.buttons[d[g]].width, e.buttons[d[g]].height, d[g]);
                h.click(p), f.addIcon(h)
            }
            return f
        }

        function m() {
            var b = a(this);
            !b.attr(s.index) && d(b) && b.attr(s.index, c());
            var e = b.attr(s.index);
            if (!e) return void b.attr(s.ignore, "");
            var f = a(i(e));
            if (0 === f.length) {
                var g = l(e),
                    j = g.createContainer(),
                    k = h({
                        height: b[0].clientHeight,
                        width: b[0].clientWidth
                    }, {
                        height: g.height,
                        width: g.width
                    }),
                    m = b.offset(),
                    n = {
                        top: m.top + k.top,
                        left: m.left + k.left
                    };
                b.after(j), j.offset(n).addClass(t.visible)
            } else o(f)
        }

        function n(a) {
            var b = setTimeout(function() {
                a.removeClass(t.visible), a.attr(s.timeoutId2, setTimeout(function() {
                    a.remove()
                }, 600))
            }, 100);
            a.attr(s.timeoutId, b)
        }

        function o(a) {
            clearTimeout(a.attr(s.timeoutId2)), clearTimeout(a.attr(s.timeoutId)), a.addClass(t.visible)
        }

        function p() {
            var b = a(this),
                c = b.attr(essbis.attr.type),
                d = b.parent(String.format("div.{0}", essbis.cssClass.container)).attr(s.index),
                e = a(String.format('[{0}="{1}"]', s.index, d)),
                h = new essbis.baseClasses.ClickHandlerArg;
            return h.url = f(e), h.imageAttributes.src = k(e), h.imageAttributes.alt = e.attr("alt"), h.imageAttributes.title = e.attr("title"), h.imageAttributes.description = e.attr(essbis.attr.imageDescription), h.articleAttributes.title = g(e), essbis.buttons.handleClick(c, h)
        }

        function q() {
            var b = a(this),
                c = a();
            if (u.parentContainerSelector && (c = b.parents(u.parentContainerSelector).first()), 0 === c.length) {
                c = b;
                for (var d = 0; d < u.parentContainerLevel; d++) c = c.parent()
            }
            c.length > 0 && (essbis.functions.transferDataAttributes(b, c), c.addClass(t.container))
        }
        var r = 0,
            s = {
                ignore: essbis.attr.prefix + "Ignore",
                index: essbis.attr.prefix + "Index",
                postContainer: essbis.attr.prefix + "HoverContainer",
                timeoutId: essbis.attr.prefix + "TimeoutId",
                timeoutId2: essbis.attr.prefix + "TimeoutId2"
            },
            t = {
                visible: "visible",
                overlay: essbis.cssClass.prefix + "hover-overlay",
                container: essbis.cssClass.prefix + "hover-container"
            },
            u = {
                theme: "default48",
                buttonSet: "default",
                orientation: "horizontal",
                hoverPanelPosition: "middle-middle",
                imageSelector: String.format(".[0] img", t.container),
                minImageHeight: 100,
                minImageWidth: 100,
                descriptionSource: ["titleAttribute", "altAttribute"],
                disabledClasses: ".wp-smiley",
                showOnLightbox: "1",
                enabledClasses: "*",
                parentContainerSelector: "",
                parentContainerLevel: 2,
                hoverPanelOffsetLeft: 0,
                hoverPanelOffsetTop: 0
            };
        b.prototype = new essbis.baseClasses.BaseContainer;
        var v = {};
        return v.onReady = function() {
            a(String.format("input[{0}]", s.postContainer)).each(q), a(document).delegate(j(), "mouseenter", m), a(document).delegate(j(), "mouseleave", function() {
                var b = a(this).attr(s.index),
                    c = a(i(b));
                n(c)
            }), a(document).delegate(i(), "mouseenter", function() {
                o(a(this))
            }), a(document).delegate(i(), "mouseleave", function() {
                n(a(this))
            })
        }, v.onResize = function() {
            a(String.format("[{0}]", s.ignore)).each(function() {
                a(this).removeAttr(s.ignore)
            }), a(String.format("[{0}]", s.index)).each(function() {
                a(this).removeAttr(s.index)
            })
        }, v.setSettings = function(b) {
            u = a.extend(u, b)
        }, v.settings = u, v.getActiveButtons = function() {
            return essbis.getButtonSet(u.buttonSet)
        }, v
    }()
}(jQuery),
function(a) {
    essbis[essbis.moduleNames.lightbox] = essbis.module[essbis.moduleNames.lightbox] = function() {
        function b(a, b) {
            switch (b) {
                case "titleAttribute":
                    return a.attr("title");
                case "altAttribute":
                    return a.attr("alt");
                default:
                    return ""
            }
        }

        function c(a) {
            for (var c = "", e = 0; e < d.descriptionSource.length && !c; e++) c = b(a, d.descriptionSource[e]);
            return c
        }
        var d = {
                pluginExists: "undefined" != a.fn.colorbox,
                descriptionSource: ["titleAttribute", "altAttribute"],
                colorBoxSettings: {}
            },
            e = {
                maxWidth: "95%",
                maxHeight: "95%",
                current: "{current} of {total}"
            },
            f = {
                groupPrefix: essbis.cssClass.prefix + "group-"
            },
            g = {};
        return g.settings = d, g.setSettings = function(b) {
            d = a.extend(d, b)
        }, g.onReady = function() {
            d.pluginExists && a(String.format("a:has(img[class*={0}])", f.groupPrefix)).each(function() {
                var b = a(this).find("img"),
                    g = b.attr("class").match(String.format("{0}[0-9]+", f.groupPrefix)),
                    h = c(b),
                    i = {
                        rel: g[0],
                        title: h,
                        onComplete: function() {
                            a("img.cboxPhoto").attr({
                                alt: b.attr("alt"),
                                title: b.attr("title")
                            }), a("#cboxTitle").hide();
                            var c = '<p class="cboxBelowImageContent">' + a("#cboxTitle").html() + "</p>";
                            a("#cboxLoadedContent").append(c).css({
                                color: a("#cboxTitle").css("color")
                            }), a.fn.colorbox.resize()
                        }
                    },
                    j = a.extend(a.extend(e, d.colorBoxSettings), i);
                a(this).colorbox(j)
            })
        }, g
    }()
}(jQuery),
function(a) {
    essbis.module[essbis.moduleNames.shortcode] = function() {
        function b() {
            essbis.baseClasses.BaseContainer.call(this, "horizontal"), this.addClass(g.containerInner), this.$outerContainer = a("<div/>", {
                "class": g.containerOuter
            })
        }

        function c(a) {
            return a.parents(String.format(".{0}", g.containerInner))
        }

        function d(b) {
            if ("0" == essbis.buttons.settings.generalUseFullImages) return b;
            var c = a(String.format('img[src="{0}"]', b)),
                d = c.length ? essbis.functions.getLinkedImage(c.first()) : "";
            return "" != d ? d : b
        }

        function e(c) {
            a(String.format(".{0}.{1}{2}", g.container, g.prefix, c)).each(function() {
                var c = a(this),
                    d = essbis.getButtonSet(c.attr(essbis.attr.buttonSet)),
                    e = c.attr(essbis.attr.theme),
                    h = essbis.getTheme(e),
                    i = new b;
                i.addClass(essbis.cssClass.prefix + e), i.$outerContainer.addClass(essbis.getAlignmentClass(c.attr(essbis.attr.align)));
                for (var j = !!c.attr(essbis.attr.imageUrl), k = 0; k < d.length; k++)
                    if (d[k] != essbis.buttonTypes.pinterestShare || j) {
                        var l = new essbis.baseClasses.Icon(h.buttons[d[k]].width, h.buttons[d[k]].height, d[k]);
                        l.click(f), i.addIcon(l)
                    }
                var m = i.createContainer();
                essbis.functions.transferDataAttributes(c, m.find(String.format(".{0}", g.containerInner))), c.after(m), c.remove()
            })
        }

        function f() {
            var b = a(this),
                e = b.attr(essbis.attr.type),
                f = c(b),
                g = new essbis.baseClasses.ClickHandlerArg;
            return g.url = f.attr(essbis.attr.postUrl), g.articleAttributes.title = f.attr(essbis.attr.postTitle), g.imageAttributes.alt = f.attr(essbis.attr.imageAlt), g.imageAttributes.title = f.attr(essbis.attr.imageTitle), g.imageAttributes.description = f.attr(essbis.attr.imageDescription), g.imageAttributes.src = d(f.attr(essbis.attr.imageUrl)), essbis.buttons.handleClick(e, g)
        }
        var g = {
            prefix: essbis.cssClass.prefix + "shortcode-",
            container: essbis.cssClass.prefix + "shortcode-container",
            containerOuter: essbis.cssClass.prefix + "shortcode-container-outer",
            containerInner: essbis.cssClass.prefix + "shortcode-container-inner"
        };
        b.prototype = new essbis.baseClasses.BaseContainer, b.prototype.createContainer = function() {
            var a = essbis.baseClasses.BaseContainer.prototype.createContainer.call(this);
            return this.$outerContainer.html(a)
        };
        var h = {};
        return h.onReady = function() {}, h.render = function(a) {
            e(a)
        }, h.setSettings = function() {}, h
    }()
}(jQuery);