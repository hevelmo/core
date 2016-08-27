/*
 * 	Author:		Connect Group
 * 	Website:	connect-group.com
 *
 * 	Title:		LRDX
 * 	Build:		2015-01-19 11:11:32
 *
 */
!
function (a, b, c, d) {
	a.createComponent = function (b, c) {
		function e(a) {
			return "object" != typeof a || "Object" !== Object.prototype.toString.call(a).slice(8, -1)
		}
		function f(b, c, d) {
			var e, g = "";
			if (-1 !== c.indexOf(".")) g = ".";
			else {
				if (-1 === c.indexOf("#")) return;
				g = "#"
			}
			e = c.split(g), a(g + e[1], b.$element).off().on(e[0], function (a) {
				a.preventDefault(), b[d](a)
			}), b.registerEvent = f
		}
		function g(b) {
			b.uiElements = {}, b.ui = function (c) {
				return "undefined" != typeof b.uiElements[c] ? b.uiElements[c] : "undefined" != typeof b.uiSelectors[c] ? b.uiElements[c] = a(b.uiSelectors[c], b.$element) : null
			}
		}
		if ("string" != typeof b || !b) return void console.log("Error: you must specify a valid plugin name on the first parameter of the method.", b);
		if (c === d || !c || e(c)) return void console.log("Error: you must specify a valid plugin implementation on the second parameter of the method.", c);
		/*if ("function" == typeof a.fn[b]) return void console.log("Error: there's already a jQuery plugin defined with this name.", b, a.fn[b].constructor);
		"function" != typeof Object.create && (Object.create = function (a) {
			function b() {}
			return b.prototype = a, new b
		});*/
		var h = {
			_name: "",
			_defaults: {},
			_init: function (b, c, d) {
				var e = this;
				this._name = b, this.element = c, this.$element = a(c), this.options = a.extend({}, this._defaults, d), this.events && a.each(this.events, function (a, b) {
					f(e, a, b)
				}), this.uiSelectors && g(e), site.rtl === !0 && "function" == typeof this.init_rtl && this.init_rtl(), "function" == typeof this.init && this.init()
			}
		};
		a.fn[b] = function (e) {
			var f, g = Array.prototype.slice.call(arguments, 1);
			return this.each(function () {
				var d = this,
					i = (a(d), "component_" + b),
					j = a.data(d, i);
				if (!j) {
					var k = a.extend({}, h, c);
					j = a.data(d, i, Object.create(k)), j && "function" == typeof j._init && j._init.apply(j, [b, d, e])
				}
				if (j && "string" == typeof e && "_" !== e[0] && "init" !== e) {
					var l = "destroy" === e ? "_destroy" : e;
					"function" == typeof j[l] && (f = j[l].apply(j, g)), "destroy" === e && a.data(d, i, null)
				}
			}), f !== d ? f : this
		}
	}
}(window.jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		uiSelectors: {
			header: "h3"
		},
		init: function () {
			this._resizeText()
		},
		_resizeText: function () {
			var c = this,
				d = a(b);
			d.smartresize(function () {
				d.width() > site.breakpoints.small ? setTimeout(function () {
					c.ui("header").removeAttr("style").equalHeights()
				}, 1e3) : c.ui("header").removeAttr("style")
			}), c.ui("header").removeAttr("style").equalHeights()
		}
	};
	jQuery.createComponent("AtAGlance", c)
}(jQuery, window, document), function (a, b, c) {
	var d = {
		_defaults: {
			localData: null,
			dataURL: null,
			wrapper: !0,
			autoSubmit: !1,
			keyMatchTitle: "",
			youSearchedTitle: "",
			appendAfter: ""
		},
		_service: null,
		_results: [],
		_menuClass: "",
		_keypressTimer: null,
		init: function () {
			var b = this;
			b._menuClass = "acm-" + this._guid(), b.options.localData && this.$element.wrap("<div class='autoCompleteContainer'></div>");
			var c;
			c = "" === b.options.appendAfter ? b.$element : a(b.options.appendAfter), c.after("<div class='autoCompleteMenu " + b._menuClass + "'></div>"), b.options.localData ? b._service = b._populateLocalData : b.options.dataURL && (b._service = b._populateRemoteData), this._addEvents(), b._addKeyboardNavigation()
		},
		_populateRemoteData: function () {
			var b = this;
			clearTimeout(b._keypressTimer), b._keypressTimer = setTimeout(function () {
				var c = site.utils.removeHTMLTags(b.$element.val());
				a.getJSON(b.options.dataURL, {
					query: c
				}).done(function (a) {
					b._results = a, b._createSearchMenu()
				}).fail(function (a, b, c) {})
			}, 300)
		},
		_populateLocalData: function () {
			for (var a = this, b = 0; b < a.options.localData.length; b++) a.options.localData[b].toLowerCase().indexOf(a.$element.val().toLowerCase()) > -1 && a._results.push(a.options.localData[b]);
			a._createMenu()
		},
		_createMenu: function () {
			for (var b = this, c = a("." + b._menuClass), d = "", e = 0; e < b._results.length; e++) d += "<div class='autoCompleteItem'>" + b._results[e] + "</div>";
			c.html(d), a(".autoCompleteItem").on("click tap", function (d) {
				d.stopPropagation(), b.$element.val(a(this).text()), c.empty(), b.options.autoSubmit && b.$element.parents("form").submit()
			})
		},
		_createSearchMenu: function () {
			var b = this,
				c = a("." + b._menuClass),
				d = b.options.youSearchedTitle,
				e = "";
			e += "<a class='autoCompleteTitle' href='#'>" + d.replace("##searchTerm##", "'" + site.utils.removeHTMLTags(b.$element.val()) + "'") + "</a>";
			for (var f = b._results.keyMatches, g = 0; g < f.length; g++) e += "<a href='" + f[g].url + "' class='autoCompleteItem promoted'>" + f[g].title + "<span>" + b.options.keyMatchTitle + "</span></a>";
			for (var h = b._results.suggestions, i = 0; i < h.length; i++) e += "<a href='" + h[i].url + "' class='autoCompleteItem'>" + h[i].title + "</a>";
			c.html(e), a(".autoCompleteTitle").on("click tap", function (a) {
				a.stopPropagation(), b.$element.parents("form").submit()
			})
		},
		_addEvents: function () {
			var b = this,
				c = a("." + b._menuClass),
				d = "";
			d = b._inputSupport() ? "input" : "keyup", this.$element.on(d, function () {
				b._results = [], b.$element.val().length > 2 && b._service()
			}), a("html").on("click tap", function () {
				c.empty()
			})
		},
		_inputSupport: function () {
			var a = c.createElement("input"),
				b = "oninput" in a && !0;
			return b || (a.setAttribute("oninput", "return;"), b = "function" == typeof a.oninput && !0), b
		},
		_guid: function () {
			function a() {
				return Math.floor(65536 * (1 + Math.random())).toString(16).substring(1)
			}
			return a() + a() + "-" + a() + "-" + a()
		},
		_addKeyboardNavigation: function () {
			var b = this,
				c = b.$element,
				d = a("." + b._menuClass);
			c.keydown(function (a) {
				return 40 === a.keyCode ? (d.find("a:first").focus(), !1) : void 0
			}), d.keydown(function (b) {
				var d = a(this).find("a:first"),
					e = a(this).find("a:focus");
				return 40 === b.keyCode ? (e.next("a").focus(), !1) : 38 === b.keyCode ? (e.is(d) ? c.focus() : e.prev("a").focus(), !1) : void 0
			})
		}
	};
	jQuery.createComponent("AutoComplete", d)
}(jQuery, window, document), function () {
	var a = {
		_defaults: {},
		_foo: "bar",
		_blue: "blar",
		init: function () {},
		publicMethod: function () {},
		_privateMethod: function () {},
		_destroy: function () {}
	};
	jQuery.createComponent("ComponentName", a)
}(jQuery, window, document), function (a) {
	var b = {
		_defaults: {
			closeOnTapOutside: !1
		},
		_$toggleButton: null,
		_$dropdownList: null,
		_valueInTitle: !1,
		_height: 0,
		init: function () {
			var b = this;
			this._$toggleButton = a("> span", this.$element), this._$dropdownList = a("ul", this.$element), "undefined" != typeof this.$element.data("dropdownnav-close-on-tap-outside") && this.$element.data("dropdownnav-close-on-tap-outside") === !0 && (this.options.closeOnTapOutside = !0), "undefined" != typeof this.$element.data("dropdownnav-value-in-title") && (this._valueInTitle = !0), "undefined" != typeof this.$element.data("dropdownnav-stay-on-page") && (this._stayOnPage = !0), b._height = b._$dropdownList.height();
			var c = !1;
			if (b.$element.hasClass("active") ? (c = !0, b._$dropdownList.css({
				opacity: 1,
				height: "auto",
				"overflow-y": "hidden",
				display: "block"
			})) : b._$dropdownList.css({
				opacity: 0,
				height: 0,
				"overflow-y": "hidden",
				display: "none"
			}), this._valueInTitle === !0) {
				var d = a("li.active a span", this._$dropdownList).html();
				"" !== d && a("span", this._$toggleButton).html(d)
			}
			this._stayOnPage === !0 && a("li a", b._$dropdownList).on("click tap", function (c) {
				c.preventDefault(), b.changeSelected(a(this).parent()), b.$element.trigger("selected", a(this).parent())
			}), b.$element.Dropdown({
				timeout: 250,
				closeOnTapOutside: b.options.closeOnTapOutside,
				button: b._$toggleButton,
				buttonWithinMenu: !1,
				openByDefault: c,
				onOpen: function () {
					setTimeout(function () {
						if (!b.$element.hasClass("active")) {
							b.$element.trigger("open").addClass("active animating");
							var c = a(b.$element).clone().css({
								position: "absolute",
								visibility: "hidden",
								height: "auto",
								width: b.$element.width()
							}).addClass("dropdownClone").appendTo(b.$element.parent());
							a("ul", c).css({
								opacity: 1,
								height: "auto",
								"overflow-y": "hidden"
							}), b._height = a(".dropdownClone ul").height(), a(".dropdownClone").remove(), b._$dropdownList.show().transition({
								opacity: 1,
								height: b._height,
								duration: 400,
								easing: "ease"
							}, function () {
								b._$dropdownList.css({
									height: "auto"
								}), b.$element.removeClass("animating").trigger("opened")
							})
						}
					}, 50)
				},
				onClose: function () {
					b.$element.hasClass("active") && (b.$element.hasClass("animating") || (b.$element.trigger("close").addClass("animating"), b._height = b._$dropdownList.height(), b._$dropdownList.css({
						height: b._height
					}).show().transition({
						duration: 400,
						easing: "ease",
						height: 0,
						opacity: 0
					}, function () {
						b.$element.removeClass("animating active"), b._$dropdownList.hide(), b.$element.trigger("closed")
					})))
				}
			}), b._addKeyboardNavigation()
		},
		open: function () {
			this._$toggleButton.trigger("open")
		},
		changeSelected: function (b) {
			if (a("li.active", this._$dropdownList).removeClass("active"), b.addClass("active"), this._valueInTitle === !0) {
				var c = a("li.active a span", this._$dropdownList).html();
				"" !== c && a("span", this._$toggleButton).html(c)
			}
			this._$toggleButton.trigger("close")
		},
		_addKeyboardNavigation: function () {
			var b = this,
				c = b.$element,
				d = b._$toggleButton,
				e = a("ul", b.$element);
			b._$toggleButton.attr("tabindex", "0"), d.keydown(function (a) {
				var b = c.hasClass("active");
				if (b) {
					if (40 === a.keyCode) return e.find("li").not(":hidden").first().find("a").focus(), !1;
					13 === a.keyCode && d.trigger("close")
				} else if (40 === a.keyCode || 13 === a.keyCode) {
					d.trigger("open");
					var f = e.find("li.active > a");
					return f.focus(), !1
				}
			}), e.find("> li > a").keydown(function (b) {
				return 40 === b.keyCode ? (a(this).parent("li").nextAll("li").not(":hidden").first().find("a").focus(), !1) : 38 === b.keyCode ? (a(this).parent("li").prevAll("li").not(":hidden").first().find("a").focus(), !1) : void 0
			})
		}
	};
	jQuery.createComponent("DropdownNav", b)
}(jQuery, window, document), function (a, b, c, d) {
	var e = {
		_defaults: {},
		_selectNode: null,
		_dropdownWrapperElement: null,
		_dropdownSelectedElement: null,
		_dropdownListElement: null,
		_hasFlag: !1,
		init: function () {
			var a = this;
			a._selectNode = a.$element, a._createComponentElements(), a._populateElementsData(), a._assignSelectEvents(), a._assignListItemEvents(), a._addKeyboardNavigation()
		},
		_createComponentElements: function () {
			var b = this,
				c = a.grep(b._selectNode.attr("class").split(" "), function (a) {
					return 0 === a.indexOf("DropdownSelectTheme")
				}).join();
			b._selectNode.removeClass("DropdownSelect"), b._selectNode.removeClass(c), b._dropdownWrapperElement = b._selectNode.wrap("<div class='DropdownSelect " + c + "'></div>").parent(), b._dropdownWrapperElement.append('<span class="selected" tabindex="0">SELECTED</span>'), b._dropdownWrapperElement.append("<ul></ul>"), b._dropdownSelectedElement = a("span.selected", b._dropdownWrapperElement), b._dropdownListElement = a("ul", b._dropdownWrapperElement), b._dropdownWrapperElement.append('<div class="clickOff"></div>'), b._selectNode.hasClass("flagSelect") && (b._selectNode.removeClass("flagSelect"), b._dropdownWrapperElement.addClass("flagSelect"), b._hasFlag = !0)
		},
		_populateElementsData: function () {
			var b = this,
				c = a("option", b._selectNode);
			b._selectNode.attr("disabled") !== d ? b._dropdownWrapperElement.addClass("disabled") : b._dropdownWrapperElement.removeClass("disabled");
			var e = a("option:selected", b._selectNode),
				f = b._hasFlag ? '<div class="flag ' + e.attr("data-flag-img") + '"></div>' + e.first().text() : e.first().text();
			b._dropdownSelectedElement.html(f), b._dropdownListElement.children().remove();
			for (var g = 0; g < c.length; g++) {
				var h = a(c[g]),
					i = h.val(),
					j = h.text(),
					k = h.attr("disabled"),
					l = h.attr("data-flag-img");
				if (k === d) {
					var m = b._hasFlag ? '<li data-val="' + i + '" tabindex="0">' + j + '<div class="flag ' + l + '"></div></li>' : '<li data-val="' + i + '" tabindex="0">' + j + "</li>";
					b._dropdownListElement.append(m)
				}
			}
		},
		_assignSelectEvents: function () {
			var b = this;
			b._dropdownSelectedElement.on("click tap", function () {
				b._dropdownWrapperElement.hasClass("disabled") || (b._dropdownWrapperElement.hasClass("open") ? (b._dropdownWrapperElement.removeClass("open"), b._dropdownSelectedElement.trigger("blur")) : (b._dropdownWrapperElement.addClass("open"), b._dropdownListElement.scrollTop(0)))
			}), b._selectNode.on("update", function () {
				b._populateElementsData(), b._assignListItemEvents()
			}), b._selectNode.on("change", function () {
				var c = a("option:selected", b._selectNode),
					d = b._hasFlag ? '<div class="flag ' + c.attr("data-flag-img") + '"></div></li>' + c.text() : c.text();
				b._dropdownSelectedElement.html(d), b._dropdownWrapperElement.removeClass("open")
			}), a(".clickOff", b._dropdownWrapperElement).on("click tap", function () {
				b._dropdownWrapperElement.removeClass("open")
			}), b._dropdownListElement.on("DOMMouseScroll mousewheel", function (b) {
				var c = a(this),
					d = this.scrollTop,
					e = this.scrollHeight,
					f = c.height(),
					g = b.originalEvent.wheelDelta,
					h = g > 0,
					i = function () {
						return b.stopPropagation(), b.preventDefault(), b.returnValue = !1, !1
					};
				return !h && -g > e - f - d ? (c.scrollTop(e), i()) : h && g > d ? (c.scrollTop(0), i()) : void 0
			})
		},
		_assignListItemEvents: function () {
			var b = this;
			a("li", b._dropdownListElement).off("click tap").on("click tap", function () {
				var c = a(this).attr("data-val");
				b._selectNode.val(c).change()
			})
		},
		_addKeyboardNavigation: function () {
			var b = this,
				c = b._dropdownWrapperElement,
				d = b._dropdownSelectedElement,
				e = b._dropdownListElement,
				f = b._selectNode;
			d.keydown(function (b) {
				var g = e.find("li"),
					h = f.val();
				h = h ? h.toString() : h;
				var i = g.filter(function () {
					return a(this).data("val").toString() === h
				}),
					j = c.hasClass("open");
				if (40 === b.keyCode) {
					if (j) g.first().focus();
					else {
						var k = null;
						if (k = i.length > 0 ? i.next("li") : g.first(), k.length > 0) {
							var l = k.data("val");
							f.val(l).change(), d.text(a("option:selected", f).text())
						}
					}
					return !1
				}
				if (38 === b.keyCode) {
					if (j === !1) {
						var m = null;
						if (i.length > 0 && (m = i.prev("li"), m.length > 0)) {
							var n = m.data("val");
							f.val(n).change(), d.text(a("option:selected", f).text())
						}
					}
					return !1
				}
				13 === b.keyCode && (c.toggleClass("open"), i.focus())
			}), a(e).on("keydown", "li", function (b) {
				if (40 === b.keyCode) return a(this).next("li").focus(), !1;
				if (38 === b.keyCode) return a(this).prev("li").focus(), !1;
				if (13 === b.keyCode) {
					var e = a(this).data("val");
					f.val(e).change(), d.text(a("option:selected", f).text()), c.removeClass("open"), d.focus()
				}
			})
		}
	};
	jQuery.createComponent("DropdownSelect", e)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		_slider: null,
		_mode: null,
		_dragging: !1,
		_slidePosition: !1,
		_windowWidth: 0,
		_windowHeight: 0,
		_direction: "slideFromRight",
		init_rtl: function () {
			this._direction = "slideFromLeft"
		},
		init: function () {
			a(".royalSlider > div", this.element).length > 1 ? this._initSlider() : (a(".royalSlider", this.element).wrapInner('<div class="overflow"><div class="rsContainer"><div class="rsSlide"></div></div></div>'), a(".navigation", this.element).remove()), a(".TargetLinks", this.$element).each(function () {
				var b = a(this);
				"video" === b.attr("data-type") && a(this).append('<div class="playButton"></div>')
			});
			var c = a(".navigation > div a.prev", this.element);
			c.on("click.dfc tap", {
				that: this
			}, this._onPrev);
			var d = a(".navigation > div a.next", this.element);
			d.on("click.dfc tap", {
				that: this
			}, this._onNext), this._initEnquire(), a(b).on("resize", {
				that: this
			}, this._onResize), a(b).trigger("resize"), a(this.element).css("visibility", "visible")
		},
		_initSlider: function () {
			var c = this,
				d = 0;
			"slideFromLeft" === c._direction && (d = a(".royalSlider > div", c.$element).length - 1);
			var e = a(".royalSlider", this.$element).royalSlider({
				arrowsNav: !1,
				controlNavigation: "none",
				loop: !0,
				startSlideId: d,
				keyboardNavEnabled: !1,
				navigateByClick: !1,
				controlsInside: !1,
				imageScaleMode: "none",
				arrowsNavAutoHide: !1,
				thumbsFitInViewport: !1,
				numImagesToPreload: 1,
				slidesSpacing: 0
			}),
				f = this._slider = e.data("royalSlider");
			a(".rsOverflow", e).width("100%"), setTimeout(function () {
				b.picturefill()
			}, 50), setTimeout(function () {
				b.picturefill()
			}, 500), f.ev.on("rsBeforeAnimStart", {
				that: this
			}, this._updatePagination), f.ev.on("rsDragStart", {
				that: this
			}, this._onDragStart), f.ev.on("rsDragRelease", {
				that: this
			}, this._onDragStop), f.ev.on("rsAfterSlideChange", function () {
				b.picturefill(), c._onResize()
			}), this._updatePagination(), this._addKeyboardNavigation()
		},
		_onDragStart: function (b) {
			var c = b ? b.data.that : this;
			c._slidePosition = a(".rsContainer", c.$element).position().left
		},
		_onDragStop: function (b) {
			var c = b ? b.data.that : this,
				d = c._slidePosition,
				e = a(".rsContainer", c.$element).position().left;
			c._dragging = d === e ? !1 : !0
		},
		getDragging: function () {
			return this._dragging
		},
		_initEnquire: function () {
			var a = this;
			enquire.register("screen and (min-width: " + b.site.breakpoints.medium + "px)", {
				match: function () {
					a._convert("large")
				}
			}), enquire.register("screen and (min-width: " + (b.site.breakpoints.small + 1) + "px) and (max-width: " + (b.site.breakpoints.medium - 1) + "px)", {
				match: function () {
					a._convert("medium")
				}
			}), enquire.register("screen and (max-width: " + b.site.breakpoints.small + "px)", {
				match: function () {
					a._convert("small")
				}
			})
		},
		_convert: function (b) {
			this._mode = b;
			var c = a(".navigation", this.element),
				d = a(".royalSlider", this.element),
				e = a(".rsSlide .left", d),
				f = a(".rsSlide .right", d),
				g = a(".left > div > div > div", d);
			"large" === b && (c.removeAttr("style"), e.removeAttr("style"), g.removeAttr("style"), a(".top", f).removeAttr("style"))
		},
		_onResize: function (c) {
			function d() {
				n.each(function () {
					var b = a(this).height();
					b > r && (r = b)
				})
			}
			var e = c ? c.data.that : this,
				f = a(b).width(),
				g = a(b).height();
			e._windowWidth = f, e._windowHeight = g;
			var h, i = a(".navigation", e.element),
				j = i.height(),
				k = a(".royalSlider", e.element),
				l = a(".left", k),
				m = a(".right", k),
				n = a("> div > div > div", l),
				o = a("> p.title", m),
				p = e._mode,
				q = .5625,
				r = 0;
			if ("medium" === p || "small" === p) {
				var s = f * q;
				a(".top", k).height(s);
				var t = s;
				if ("small" === e._mode) t += o.outerHeight(), n.removeAttr("style");
				else {
					var u = (n.width(), 500),
						v = a("html").width(),
						w = 2 * parseInt(l.css("padding-left"), 10),
						x = (v - w - u) / 2;
					n.css("padding", "0 " + x + "px")
				}
				d(), r += 80, i.css("top", t), h = t + j + r
			} else {
				d(), r += 80;
				var y = 550,
					z = g - site.utils.getHeaderHeight(0);
				h = r > y ? r : y;
				var A = f / g;
				A > 2.3 ? (a(".bottomLeft", k).hide(), a(".bottomRight", k).hide(), a(".triple .top", k).css("height", "100%")) : (a(".bottomLeft", k).show(), a(".bottomRight", k).show(), a(".triple .top", k).removeAttr("style")), f > 1500 && (h = r > z ? r : z)
			}
			a(".rsOverflow", k).height(h), k.height(h), e._slider || a(".overflow", k).height(h)
		},
		_onPrev: function (a) {
			a.preventDefault();
			var b = a.data.that;
			b._slider.prev(), b._updateSlideLinks()
		},
		_onNext: function (a) {
			a.preventDefault();
			var b = a.data.that;
			b._slider.next(), b._updateSlideLinks()
		},
		_updatePagination: function (b) {
			var c = b ? b.data.that : this,
				d = c._slider,
				e = d.currSlideId + 1;
			"slideFromLeft" === c._direction && (e = d.numSlides - e + 1), a(".numbers", c.$element).html(e + "<span>/</span>" + d.numSlides), a(".TargetLinks").TargetLinks("setupListener")
		},
		_addKeyboardNavigation: function () {
			var b = this,
				c = b._slider,
				d = a(".royalSlider", b.$element),
				e = a(".navigation", b.$element);
			d.attr("tabindex", "0"), d.keydown(function (a) {
				39 === a.keyCode ? (c.next(), d.focus(), b._updateSlideLinks()) : 37 === a.keyCode && (c.prev(), d.focus(), b._updateSlideLinks())
			}), e.find("a").keydown(function (b) {
				39 === b.keyCode ? a(this).nextAll("a").first().focus() : 37 === b.keyCode && a(this).prevAll("a").first().focus()
			}), b._updateSlideLinks()
		},
		_updateSlideLinks: function () {
			var b = this,
				c = b._slider,
				d = (a(".royalSlider", b.$element), a(".rsSlide > div", b.$element)),
				e = c.currSlide.content;
			a("a", d).attr("tabindex", "-1"), a("a", e).attr("tabindex", ""), a(".ResponsiveLink").ResponsiveLink()
		}
	};
	jQuery.createComponent("DualFrameCarousel", c)
}(jQuery, window, document), function (a) {
	var b = {
		init: function () {
			var a = this;
			a._masonryLayout(), a._handleTelephoneClicks(), a._listEventHandlers()
		},
		_masonryLayout: function () {
			var b = this,
				c = a(".list", b.$element);
			c.lrdxMasonry({
				animate: !1
			}), c.lrdxMasonry("refresh")
		},
		_handleTelephoneClicks: function () {
			var b = this;
			a(".cardData .tel a", b.$element).click(function (a) {
				var b = site.utils.isBreakpointSmall() && site.utils.isMobileDevice();
				b || a.preventDefault()
			})
		},
		_listEventHandlers: function () {
			var b = this;
			a(".infoCardLRECentre .mobileStateBtn", b.$element).on("click tap", function (b) {
				b.preventDefault();
				var c = a(this).parents(".infoCardLRECentre"),
					d = c.find(".mobile");
				c.hasClass("openInfoCard") ? d.slideUp(300, function () {
					c.removeClass("openInfoCard")
				}) : d.slideDown(300, function () {
					c.addClass("openInfoCard")
				})
			})
		}
	};
	jQuery.createComponent("ExperienceCentres", b)
}(jQuery, window, document), function () {
	var a = {
		_defaults: {},
		init: function () {},
		_destroy: function () {}
	};
	jQuery.createComponent("ExperienceRegions", a)
}(jQuery, window, document), function (a) {
	var b = {
		init: function () {
			var a = this;
			a._masonryLayout(), a._handleTelephoneClicks(), a._listEventHandlers()
		},
		_masonryLayout: function () {
			var b = this,
				c = a(".list", b.$element),
				d = c.find("> li").length;
			d > 1 && (c.lrdxMasonry({
				animate: !1
			}), c.lrdxMasonry("refresh"))
		},
		_handleTelephoneClicks: function () {
			var b = this;
			a(".cardData .tel a", b.$element).click(function (a) {
				var b = site.utils.isBreakpointSmall() && site.utils.isMobileDevice();
				b || a.preventDefault()
			})
		},
		_listEventHandlers: function () {
			var b = this;
			a(".infoCardFABContact .mobileStateBtn", b.$element).on("click tap", function (b) {
				b.preventDefault();
				var c = a(this).parents(".infoCardFABContact"),
					d = c.find(".mobile");
				c.hasClass("openInfoCard") ? d.slideUp(300, function () {
					c.removeClass("openInfoCard")
				}) : d.slideDown(300, function () {
					c.addClass("openInfoCard")
				})
			})
		}
	};
	jQuery.createComponent("FleetAndBusinessContacts", b)
}(jQuery, window, document), function (a) {
	var b = {
		init: function () {
			a("body").keydown(function () {
				a(this).addClass("focusStylesOn")
			}), a("body").click(function () {
				a(this).removeClass("focusStylesOn")
			})
		}
	};
	jQuery.createComponent("FocusSwitcher", b)
}(jQuery, window, document), function (a, b, c) {
	var d = {
		_defaults: {},
		init: function () {
			{
				var c = this;
				a(".FooterNav .navWrapper").not(".hygieneLinks .navWrapper")
			}
			a(".toggle").unbind("click").click(function () {
				var b = a(this).next("ul"),
					c = a(this).children("i");
				return b.slideToggle(), a(this).toggleClass("active"), c.toggleClass("active"), !1
			}), c._initHygieneToggleEvents(), c._loadMarketSelector(), a(b).resize(function () {
				c._setFooterNavPadding()
			}), c._setFooterNavPadding()
		},
		_initHygieneToggleEvents: function () {
			var b = this,
				d = a(".toggleHandle", b.$element);
			d.on("click", function (b) {
				b.preventDefault(), b.stopPropagation();
				var c = a(this).parent();
				c.hasClass("open") ? d.parent().removeClass("open") : (d.parent().removeClass("open"), c.addClass("open"))
			}), a(c).on("click tap", function (b) {
				var c = a(b.target).parents("li.open").length;
				1 > c && d.parent().removeClass("open")
			}), b._addKeyboardNavigation()
		},
		_loadMarketSelector: function () {
			var b = this,
				c = a(".selectMarket a", b.$element).attr("href"),
				d = ".dropDownContainer",
				e = a(".marketSelectorContainer", b.$element);
			e.load(c + " " + d, function () {
				e.MarketSelector({
					geoLocate: !1
				}), a(".DropdownSelect", e).DropdownSelect()
			})
		},
		_setFooterNavPadding: function () {
			var b = a(".hygieneLinks").height(),
				c = a(".marketSelectorContainer", this.$element);
			a(".FooterNav").css("padding-bottom", b), c.css("bottom", b)
		},
		_addKeyboardNavigation: function () {
			var b = this,
				c = a(".toggleHandle", b.$element),
				d = c.parent(),
				e = d.find(".marketSelectorContainer");
			c.keydown(function (a) {
				var b = e.find("input, textarea, button, a, .focusable"),
					c = d.hasClass("open");
				return c && 38 === a.keyCode ? (b.first().focus(), !1) : void 0
			})
		}
	};
	jQuery.createComponent("FooterNav", d)
}(jQuery, window, document), function (a) {
	var b = {
		_defaults: {},
		init: function () {
			var b = a("#autoIframe", this.$element),
				c = site.utils.addParameterToURL(b.attr("data-src"), site.utils.campaignTrackingPersistance.getTracking("GoogleCampaign"));
			b.attr("src", c), site.utils.isIOS() || b.iframeHeight()
		}
	};
	jQuery.createComponent("FramedContent", b)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		_$window: a(b),
		init: function () {
			var a = this;
			a._$window.smartresize(function () {
				a._onResize(), a._increaseSize()
			}), a._onResize(), a._increaseSize()
		},
		_onResize: function () {
			var b = this,
				c = a(".imageContainer", this.$element);
			if (this.$element.hasClass("adaptive")) if (b._$window.width() >= 1e3) {
				var d = b._$window.height();
				c.css(d > 700 ? {
					height: d,
					"min-height": d
				} : {
					height: 700,
					"min-height": 700
				})
			} else c.removeAttr("style")
		},
		_increaseSize: function () {
			var b = this,
				c = a(".imageContainer", this.$element),
				d = a(".itemContent", this.$element),
				e = d.css("bottom"),
				f = "auto" === e ? 0 : parseInt(e, 10),
				g = d.css("top"),
				h = "auto" === g ? 0 : parseInt(g, 10),
				i = d.outerHeight() + f + h;
			b._$window.width() >= site.breakpoints.medium ? c.css(i >= this.$element.height() ? {
				height: i
			} : {
				height: "100%"
			}) : c.removeAttr("style")
		}
	};
	jQuery.createComponent("FullWidthImage", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		uiSelectors: {
			fullscreenHeader: ".fullscreenHeader",
			fullscreenFooter: ".fullscreenFooter"
		},
		aspectRatio: 16 / 9,
		_inOverlay: !1,
		init: function () {
			var c = this;
			1 === this.$element.parents(".mfp-content").length && (this._inOverlay = !0), this._inOverlay === !0 && this._setupGalleryCategoryButton(), c._setupCloseButton(), c._onResize(), a(b).resize(function () {
				c._onResize()
			}), c.initComponents()
		},
		initComponents: function () {
			var c = this;
			c.$element.find(".SocialSharing").SocialSharing(), c.$element.find(".Gallery").Gallery(), c.$element.find(".GalleryCategories").GalleryCategories(), c.$element.find(".VideoPlayerGalleryAsset").VideoPlayerGalleryAsset(), c.$element.find(".VideoPlayer").VideoPlayer({
				autoplay: !1,
				loop: !1
			}), a(b).trigger("resize")
		},
		destroyComponents: function () {
			var a = this;
			a.$element.find(".Gallery").Gallery("destroy"), a.$element.find(".GalleryCategories").GalleryCategories("destroy"), a.$element.find(".VideoPlayerGalleryAsset").VideoPlayerGalleryAsset("destroy"), a.$element.find(".VideoPlayer").VideoPlayer("destroy")
		},
		_setupGalleryCategoryButton: function () {
			var b = this;
			a(".galleryCategoriesBtn", this.$element).on("click tap", function (c) {
				c.preventDefault(), b.loadURL({
					url: a(this).attr("href"),
					type: "GalleryCategories"
				})
			})
		},
		_setupCloseButton: function () {
			if (site.utils.cookieManager.checkForCookie("JLR_previousURL") === !0) {
				var b = site.utils.cookieManager.readCookie("JLR_previousURL");
				null !== b && a(".mfp-close", this.$element).attr("href", b)
			}
		},
		_onResize: function () {
			var a = this;
			a._resizeHeader(), a._setGalleryPadding()
		},
		_resizeHeader: function () {
			var c = this.ui("fullscreenHeader").find(".logo").outerWidth() + a("#filmstripToggle").outerWidth() + this.ui("fullscreenHeader").find(".galleryCategoriesBtn").outerWidth() + this.ui("fullscreenHeader").find(".mfp-close").outerWidth() + this.ui("fullscreenHeader").find(".addThisMenu").outerWidth();
			this.ui("fullscreenHeader").find(".info").width(a(b).width() - c)
		},
		_setGalleryPadding: function () {
			var b = this,
				c = a(".Gallery", b.$element),
				d = a(".fullscreenFooter", b.$element).outerHeight();
			c.css({
				"padding-bottom": d
			})
		},
		loadURL: function (b) {
			var c = this;
			this.destroyComponents(), this.$element.find(".fullscreenContentWrapper").empty(), a.get(b.url, function (d) {
				switch (a(".info h4", c.$element).html(a(d).find(".info h4").html()), a(".info p", c.$element).html(a(d).find(".info p").html()), c.$element.find(".fullscreenContentWrapper").html(a(d).find(".fullscreenContentWrapper").html()), b.type) {
				case "GalleryCategories":
					c.$element.removeClass("hasGallery").addClass("hasGalleryCategories"), a(".galleryCategoriesBtn", c.$element).hide(), c.ui("fullscreenHeader").find("#filmstripToggle").remove();
					break;
				case "Gallery":
					c.$element.removeClass("hasGalleryCategories").addClass("hasGallery"), a(".galleryCategoriesBtn, #filmstripToggle", c.$element).show()
				}
				c.initComponents()
			})
		}
	};
	jQuery.createComponent("Fullscreen", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		_$filmstripToggle: null,
		_filmstripOpen: !1,
		_totalItems: null,
		_$currentSlide: null,
		_$currentSlideOnDrag: null,
		_userInteracting: !1,
		_slider: null,
		_slideChanging: !1,
		_fullScreen: !1,
		_textHidden: !1,
		_thumbPreviewTimeout: null,
		_direction: "slideFromRight",
		init_rtl: function () {
			this._direction = "slideFromLeft"
		},
		init: function () {
			var c = this;
			this._initGallery(), a(b).on("AddThisToggle", function (a, b) {
				b && c._filmstripOpen && (c._toggleFilmstrip(), clearTimeout(c._thumbPreviewTimeout))
			});
			var d = /(iPad|iPhone|iPod)/g.test(navigator.userAgent);
			a(b).width() < site.breakpoints.small && d && (b.scrollTo(0, 0), a(b).on("orientationchange", function () {
				b.scrollTo(0, 0)
			}))
		},
		_onSlideChange: function (a) {
			var b = this;
			this._slideChanging = !0, setTimeout(function () {
				b._slideChanging === !0 && b._userInteracting === !0 && a.target.dragSuccess && b._hideText()
			}, 150)
		},
		_onSlideChanged: function () {
			var c = this;
			this._slideChanging = !1, null !== this._$currentslide && this._$currentSlide.removeClass("current"), this._$currentSlide = a(this._slider.currSlide.holder), this._$currentSlide.addClass("current"), this._destroySlideComponents(), this._setupSlideComponents(), this._setVideoPlayer(), this._textHidden === !1 && c._hideText(), setTimeout(function () {
				c._switchText(), c._changeSlideNumber()
			}, 800), this._updateSharingURL(), a(".ResponsiveLink").ResponsiveLink(), a(b).trigger("resize")
		},
		_destroySlideComponents: function () {
			a("div:not(.current) > .YouTubeGalleryAsset > .YouTubePlayer", this.$element).YouTubePlayer("destroy")
		},
		_setupSlideComponents: function () {
			a(".YouTubePlayer", this._$currentSlide).YouTubePlayer({
				expandToWidthOnly: !1,
				inGallery: !0
			})
		},
		_setVideoPlayer: function () {
			a(".VideoPlayer", this._$element).VideoPlayer("pause")
		},
		_onSlideClicked: function () {
			this._switchText(), a(b).trigger("slideClicked"), this._filmstripOpen ? this._toggleFilmstrip() : this._fullScreen ? this._noFullScreen() : this._goFullScreen()
		},
		_goFullScreen: function () {
			a(b).width() <= site.breakpoints.medium && (this._fullScreen = !0, a(".fullscreenContentWrapper").transition({
				"padding-top": "0px",
				duration: 300
			}), a(".fullscreenHeader").transition({
				top: "-100px",
				duration: 300
			}), a(".fullscreenFooter").transition({
				bottom: "-100px",
				duration: 300
			}), this.$element.transition({
				"padding-bottom": "0px",
				duration: 300
			}))
		},
		_noFullScreen: function () {
			this._fullScreen = !1, a(".fullscreenContentWrapper").transition({
				"padding-top": "50px",
				duration: 300
			}), a(".fullscreenHeader").transition({
				top: "0px",
				duration: 300
			}), a(".fullscreenFooter").transition({
				bottom: "0px",
				duration: 300
			}), this.$element.transition({
				"padding-bottom": a(".fullscreenFooter").height(),
				duration: 300
			})
		},
		_initFilmStrip: function () {
			var b = this;
			this._$filmstripToggle = a("#filmstripToggle", this.$element), a(".fullscreenHeader").append(this._$filmstripToggle), this._$filmstripToggle.on("click tap", function () {
				b._toggleFilmstrip()
			})
		},
		_toggleFilmstrip: function () {
			this._filmstripOpen ? (a(".rsNav").transition({
				top: 0 - a(".rsNav", this.$element).outerHeight(),
				duration: 400
			}), this._$filmstripToggle.removeClass("on")) : (a(".rsNav").transition({
				top: 0,
				duration: 400
			}), this._$filmstripToggle.addClass("on"), b.setTimeout(function () {
				a(b).resize()
			}, 50)), this._filmstripOpen = !this._filmstripOpen, a(b).trigger("FilmstripToggle", [this._filmstripOpen])
		},
		_initGallery: function () {
			var c = this,
				d = !1;
			a(".rsTmb", this.$element).css({
				visibility: "visible"
			}), a(".galleryItem", this.$element).length > 1 && (d = !0);
			var e = a(".galleryItem", this.$element).index(a(".galleryItem[data-show]", this.$element));
			0 >= e && (e = 0, "slideFromLeft" === this._direction && (e = a(".royalSlider > div", c.$element).length - 1)), a(".royalSlider", this.$element).royalSlider({
				arrowsNav: !1,
				loop: !0,
				keyboardNavEnabled: !1,
				controlsInside: !1,
				imageScaleMode: "none",
				arrowsNavAutoHide: !1,
				autoHeight: !1,
				autoScaleSlider: !0,
				autoScaleSliderWidth: 0,
				autoScaleSliderHeight: 0,
				imgWidth: "100%",
				imgHeight: "100%",
				sliderDrag: d,
				sliderTouch: d,
				controlNavigation: "thumbnails",
				thumbsFitInViewport: !1,
				navigateByClick: !1,
				startSlideId: e,
				autoPlay: !1,
				transitionType: "move",
				numImagesToPreload: 1,
				thumbs: {
					autoCenter: !1,
					spacing: 30,
					arrows: !0
				},
				deeplinking: {
					enabled: !1,
					change: !1,
					prefix: "slide-"
				}
			}), setTimeout(function () {
				b.picturefill()
			}, 50), setTimeout(function () {
				b.picturefill()
			}, 500), this._slider = a(".royalSlider", this.$element).data("royalSlider"), c._addThumbnailOverlays(), a(".galleryItem", this.$element).length > 1 && (a(".directionArrow", this.$element).show(), a(".directionArrow.left", this.$element).on("click tap", function (a) {
				a.preventDefault(), c._hideText(), c._slider.prev()
			}), a(".directionArrow.right", this.$element).on("click tap", function (a) {
				a.preventDefault(), c._hideText(), c._slider.next()
			}), this._slider.ev.on("rsDragStart", function (a) {
				c._userInteracting = !0, c._$currentSlideOnDrag = c._$currentSlide, c._onSlideChange(a)
			}), this._slider.ev.on("rsBeforeAnimStart", function () {
				c._onSlideChanged()
			}), this._slider.ev.on("rsAfterSlideChange", function () {
				b.picturefill(), a(b).trigger("resize")
			}), c._initFilmStrip(), c._addKeyboardNavigation()), a(".royalSlider", this.$element).on("click tap", function (b) {
				0 === a(b.target).parents(".rsOverflow").length || a(b.target).hasClass("video") || null !== c._$currentSlideOnDrag && c._$currentSlideOnDrag[0] === a(c._slider.currSlide.holder)[0] && c._onSlideClicked(), c._userInteracting = !1
			}), this._initialiseSlides(), this._changeSlideNumber(), this._switchText(), a(b).on("resize", function () {
				c._resizeSlide()
			}), a(b).trigger("resize"), a(".rsThumbsContainer", this.$element).wrap("<div class='rsThumbsOuterContainer'><div>")
		},
		_initialiseSlides: function () {
			var c = this;
			c._$currentSlide = a(this._slider.currSlide.holder), c._$currentSlide.addClass("current"), this._setupSlideComponents(), b.setTimeout(function () {
				c._updateSharingURL()
			}, 1e3), setTimeout(function () {
				c._$currentSlide.waitForImages(function () {
					a(b).trigger("resize"), c._slider.updateSliderSize(!0)
				})
			}, 200)
		},
		_resizeSlide: function () {
			var c = this,
				d = a(".royalSlider", this.$element).height(),
				e = a(".royalSlider", this.$element).width();
			this._slider.updateSliderSize();
			var f = a(".galleryItem .image", this._slider.currSlide.holder),
				g = !1;
			"portrait" === f.data("orientation") && (g = !0);
			var h = e / d;
			return 0 === f.height() ? void setTimeout(function () {
				c._resizeSlide()
			}, 400) : (1 === f.length && f.css(g === !0 || a(b).width() < site.breakpoints.medium ? {
				"background-size": "contain"
			} : h > 1 ? {
				"background-size": "cover"
			} : {
				"background-size": "contain"
			}), void(this._filmstripOpen === !0 && (a(".rsThumbsContainer", this.$element).width() < a(".rsNav", this.$element).width() ? a(".rsThumbsArrow").addClass("arrowOff") : a(".rsThumbsArrow").removeClass("arrowOff"))))
		},
		_updateSharingURL: function () {
			if (b.addthis) {
				var c = a("> div", this._$currentSlide),
					d = c.data("id"),
					e = b.location.protocol + "//" + b.location.host + a(".gallery", this.$element).data("url") + d;
				e += e.indexOf("?") <= -1 ? "?shared=true" : "&shared=true", b.addthis.update("share", "url", e), b.addthis.toolbox(".addthis_toolbox", b.addthis_config, {
					url: e
				})
			}
		},
		_changeSlideNumber: function () {
			var a = this._slider.currSlideId + 1;
			"slideFromLeft" === this._direction && (a = this._slider.numSlides - a + 1), this._$filmstripToggle && this._slider && this._$filmstripToggle.text(a + " / " + this._slider.numSlides)
		},
		_hideText: function () {
			this._textHidden = !0, this._hide(a(".fullscreenHeader h4")), this._hide(a(".fullscreenHeader p")), this._hide(a(".fullscreenFooter h4")), this._hide(a(".fullscreenFooter p"))
		},
		_hide: function (a) {
			a.transition({
				opacity: 0,
				duration: 300
			})
		},
		_fadeIn: function (a, b) {
			a.transition({
				opacity: 1,
				duration: b
			})
		},
		_switchText: function () {
			this._textHidden = !1;
			var b = a(this._slider.currSlide.holder),
				c = a("h4", b).html(),
				d = a("p", b).html();
			this._fadeIn(a(".fullscreenHeader h4").html(c), 300), this._fadeIn(a(".fullscreenHeader p").html(d), 300), this._fadeIn(a(".fullscreenFooter h4").html(c), 300), this._fadeIn(a(".fullscreenFooter p").html(d), 300)
		},
		_addThumbnailOverlays: function () {
			var b = this;
			b._removeThumbnailOverlays();
			var c = a(".rsTmb", b.$element);
			if (c.length > 0) {
				var d, e = a('<div class="mediaOverlay mediaOverlayImage"><div class="mediaOverlayBg"></div><div class="mediaOverlayIcon"></div></div>'),
					f = a('<div class="mediaOverlay mediaOverlayVideo"><div class="mediaOverlayBg"></div><div class="mediaOverlayIcon"></div></div>');
				c.each(function () {
					d = null, d = a(this).hasClass("videoThumb") ? f.clone() : e.clone(), a(this).parent().append(d)
				})
			}
		},
		_removeThumbnailOverlays: function () {
			var b = this;
			a(".rsThumb .mediaOverlay", b.$element).remove()
		},
		_destroy: function () {
			this._slider.ev.off("rsDragStart"), this._slider.ev.off("rsBeforeAnimStart"), a(".royalSlider", this.$element).off("click tap"), this._$filmstripToggle && this._$filmstripToggle.off("click tap"), a(b).off("AddThisToggle"), a(".directionArrow.left", this.$element).off("click tap"), a(".directionArrow.right", this.$element).off("click tap"), a(".directionArrow.right", this.$element).off("hover"), a(".YouTubePlayer", this._$currentSlide).YouTubePlayer("destroy")
		},
		_addKeyboardNavigation: function () {
			var b = this,
				c = b._$filmstripToggle,
				d = a(".rsNav .rsTmb");
			d.attr("tabindex", "0"), c.keydown(function (a) {
				var c = b._filmstripOpen;
				c === !0 && 40 === a.keyCode && d.first().focus()
			}), d.keydown(function (b) {
				39 === b.keyCode ? a(this).parent(".rsThumb").next(".rsThumb").find(".rsTmb").focus() : 37 === b.keyCode ? a(this).parent(".rsThumb").prev(".rsThumb").find(".rsTmb").focus() : 13 === b.keyCode && a(this).trigger("click")
			})
		}
	};
	jQuery.createComponent("Gallery", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		_$fullscreenContentWrapper: a(".fullscreenContentWrapper"),
		_$fullscreenHeader: a(".fullscreenHeader"),
		_$fullscreenFooter: a(".fullscreenFooter"),
		_inOverlay: !1,
		_width: 0,
		_height: 0,
		init: function () {
			var c = this;
			if (1 === this.$element.parents(".mfp-content").length && (this._inOverlay = !0), this._inOverlay === !0) {
				this._setupCategoryLinks();
				var d = b.location.protocol + "//" + b.location.host + this.$element.data("url");
				d += d.indexOf("?") <= -1 ? "?shared=true" : "&shared=true", setTimeout(function () {
					"undefined" != typeof b.addthis && (b.addthis.update("share", "url", d), b.addthis.toolbox(".addthis_toolbox", b.addthis_config, {
						url: d
					}))
				}, 3e3)
			}
			a(b).on("scroll", {
				that: this
			}, c._onResize), a(b).on("resize", {
				that: this
			}, c._onResize), setTimeout(function () {
				a(b).trigger("resize")
			}, 500), c._hoverEvent(), setTimeout(function () {
				c.$element.addClass("show")
			}, 500)
		},
		_setupCategoryLinks: function () {
			a("li", this.$element).on("click tap", function (b) {
				b.preventDefault(), a(".Fullscreen").Fullscreen("loadURL", {
					url: a(this).find("a").attr("href"),
					type: "Gallery"
				})
			})
		},
		_hoverEvent: function () {
			a("li", this.$element).on({
				mouseenter: function () {
					a(this).addClass("hover")
				},
				mouseleave: function () {
					a(this).removeClass("hover")
				}
			})
		},
		_onResize: function (c) {
			var d = c ? c.data.that : this,
				e = a(b).width(),
				f = a(b).height();
			(e !== d._width || f !== d._height) && (d._width = e, d._height = f, setTimeout(function () {
				a(b).trigger("resize")
			}, 100));
			var g, h = d._$fullscreenContentWrapper.height();
			g = h > 0 ? d._$fullscreenFooter.height() > 0 ? h - d._$fullscreenFooter.outerHeight() : h : d._$fullscreenFooter.outerHeight(), d.$element.height(g), f > e ? d.$element.addClass("portrait") : d.$element.removeClass("portrait")
		},
		_destroy: function () {
			var c = this;
			a(b).off("scroll", c._onResize), a(b).off("resize", c._onResize), a("li", this.$element).off("click tap mouseenter mouseleave")
		}
	};
	jQuery.createComponent("GalleryCategories", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		stickyNavigationActive: !1,
		_$window: null,
		_$inPageNav: null,
		init: function () {
			var c = this;
			c._$window = a(b), c._$inPageNav = a(".InPageNavigation"), c._setNavType(), c._setBodyPadding(), c._setNavHeight(!0), c._setNavPosition(), c._adjustHeaderOnSearchActiveForIOS(), c._$window.resize(function () {
				c._setNavType(), c._setNavHeight(), c._setNavPosition(), c._setBodyPadding()
			}), c._$window.scroll(function () {
				c._setNavHeight(), c._setNavPosition()
			})
		},
		_setNavType: function () {
			var a = this,
				b = site.utils.getBreakpointSize();
			"large" !== b || !site.stickyNavigationEnabled || site.utils.isMobileDevice() && "landscape" === site.utils.getDeviceOrientation() ? (a.$element.removeClass("stickyNavigation"), a.stickyNavigationActive = !1) : (a.$element.addClass("stickyNavigation"), a.stickyNavigationActive = !0)
		},
		_setNavHeight: function (a) {
			var b = this;
			a = "boolean" != typeof a ? !1 : a;
			var c = b._$window.scrollTop(),
				d = b.$element;
			c > site.stickyNavigationTransitionPoint ? d.addClass("reducedStickyNavigation") : d.removeClass("reducedStickyNavigation"), 0 === c || a ? d.addClass("notransition") : d.removeClass("notransition")
		},
		_setNavPosition: function () {
			var a = this;
			if (a._$inPageNav.length > 0 && a._isFixedHeader()) {
				var b = "";
				if (a._$inPageNav.first().is(":visible")) {
					var c = a._$window.scrollTop(),
						d = a.$element.offset().top - c,
						e = d + a.$element.outerHeight(),
						f = a._$inPageNav.first().offset().top - c;
					b = d + (f - e), b = b > 0 ? 0 : b, b += "px"
				}
				a.$element.css("top", b)
			}
		},
		_setBodyPadding: function () {
			var b = this,
				c = 0;
			b._isFixedHeader() && (c = site.utils.getStickyNavHeight(0)), a("body").css("padding-top", c)
		},
		_adjustHeaderOnSearchActiveForIOS: function () {
			if (site.utils.isIOS() && site.stickyNavigationEnabled) {
				var b = this.$element,
					c = a(".searchText", b);
				c.on("focus", function () {
					b.addClass("searchActive")
				}), c.on("blur", function () {
					b.removeClass("searchActive")
				})
			}
		},
		_isFixedHeader: function () {
			var a = this;
			return "fixed" === a.$element.css("position")
		}
	};
	jQuery.createComponent("Header", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		_slider: null,
		_$currentSlide: null,
		_$subnav: a(".SubNavigation"),
		_bottomOfHero: 0,
		_scrollTimer: null,
		_offScreen: !1,
		_interactionTimer: null,
		_$window: a(b),
		_pageWidth: 0,
		_tallest: 0,
		_orientation: "portrait",
		_userInteracting: !1,
		_slideTimer: null,
		_firstVideo: null,
		_videoUsesFlash: !1,
		_singleItemCarousel: !1,
		_userInteracted: !1,
		_direction: "slideFromRight",
		init_rtl: function () {
			this._direction = "slideFromLeft"
		},
		init: function () {
			var c = this;
			c._$window.smartresize(function () {
				c._resizeSlide(!1)
			}), a(b).on("HeroCarouselForceResize", function () {
				c._resizeSlide(!0)
			}), "undefined" !== this.$element.data("total") && "1" === String(this.$element.data("total")) ? (c._singleItemCarousel = !0, c._$currentSlide = a(".heroItem", c.$element).first(), c._singleHeroContent(), c._setVideoOpacity(), c._setupSlideComponents(), c._resizeSlide(!0), c._$window.trigger("resize"), c.$element.addClass("loaded")) : this._initGallery(), a("html").hasClass("lt-ie9") ? c._resizeSlide(!0) : c._$window.scroll(function () {
				c._onScroll()
			});
			var d = "ontouchstart" in b || navigator.msMaxTouchPoints;
			d || (c._recalculateThirds(), this.$element.mousemove(function (a) {
				a.pageX <= c._leftThird ? c.$element.removeClass("right").addClass("left") : a.pageX >= c._rightThird ? c.$element.addClass("right").removeClass("left") : c.$element.removeClass("left right")
			})), c._$window.on("fullscreenOpened overlayOpened", {
				that: c
			}, c._pauseCarousel), c._$window.on("fullscreenClosed overlayClosed", {
				that: c
			}, c._playCarousel), c._is_firefox = navigator.userAgent.indexOf("Firefox") > -1, c._is_safari = !1, -1 !== navigator.userAgent.indexOf("Safari") && -1 === navigator.userAgent.indexOf("Chrome") && (c._is_safari = !0)
		},
		_recalculateThirds: function () {
			this._pageWidth = a(b).width(), this._leftThird = Math.ceil(this._pageWidth / 3), this._rightThird = 2 * this._leftThird
		},
		_onSlideChanged: function () {
			var b = this;
			a(".linkContainer a", this._$currentSlide).off("click tap mouseenter mouseleave"), null !== this._$currentSlide && this._$currentSlide.removeClass("current");
			var c = a(".VideoPlayer", this._$currentSlide);
			1 === c.length && (c.VideoPlayer("rewind"), c.off("videoEnded"), c.VideoPlayer("pause")), this._$currentSlide = a(this._slider.currSlide.holder), this._$currentSlide.addClass("current"), a(".heroContent", this.$element).removeClass("visible"), a(".linkContainer a", this._$currentSlide).on("click tap", function (a) {
				a.stopPropagation()
			}), b._setupSlideComponents(), b._hoverOverCTAs(), b._resizeSlide(!0), b._$window.trigger("resize"), setTimeout(function () {
				b._resizeSlide(!0), b._$window.trigger("resize")
			}, 1e3), b._updateSlideLinks()
		},
		_initGallery: function () {
			var c = this;
			this._$window.width() <= site.breakpoints.small && a(".heroItem", this.$element).each(function () {
				var b = a(this);
				b.height() > c._tallest && (c._tallest = b.height())
			});
			var d = 0;
			"slideFromLeft" === c._direction && (d = this.$element.data("total") - 1), a(".royalSlider", this.$element).royalSlider({
				arrowsNav: !1,
				loop: !0,
				keyboardNavEnabled: !1,
				controlsInside: !1,
				imageScaleMode: "none",
				arrowsNavAutoHide: !1,
				autoHeight: !1,
				autoScaleSlider: !0,
				autoScaleSliderWidth: 0,
				autoScaleSliderHeight: 0,
				slidesSpacing: 0,
				imgWidth: "100%",
				imgHeight: "100%",
				sliderDrag: !0,
				controlNavigation: "bullets",
				thumbsFitInViewport: !1,
				navigateByClick: !1,
				startSlideId: d,
				autoPlay: {
					enabled: !1
				},
				transitionType: "move",
				numImagesToPreload: 1
			}), setTimeout(function () {
				b.picturefill()
			}, 50), setTimeout(function () {
				c._resizeSlide(!0), c._$window.trigger("resize"), b.picturefill()
			}, 2e3), this._slider = a(".royalSlider", this.$element).data("royalSlider"), this._slider.ev.on("rsAfterSlideChange", function () {
				b.picturefill(), c._$currentSlide.index() !== a(c._slider.currSlide.holder).index() && c._onSlideChanged()
			}), a(".rsNavItem", this.$element).on("click", function () {
				c._userFinishedInteraction()
			}), this._slider.ev.on("rsDragRelease", function () {
				var b = a(".VideoPlayer", c._$currentSlide);
				1 === b.length && c._is_safari === !1 && c._is_firefox === !1 && b.VideoPlayer("play"), c._userFinishedInteraction()
			}), this._slider.ev.on("rsDragStart", function () {
				var b = a(".VideoPlayer", c._$currentSlide);
				1 === b.length && c._is_safari === !1 && c._is_firefox === !1 && b.VideoPlayer("pause")
			}), this._slider.ev.on("rsSlideClick", function () {
				var d = a(".VideoPlayer", c._$currentSlide),
					e = "ontouchstart" in b || navigator.msMaxTouchPoints;
				e || (c.$element.hasClass("left") ? (c._cancelSlideTo(), c._is_safari === !1 && c._is_firefox === !1 && d.VideoPlayer("pause"), c._slider.prev()) : c.$element.hasClass("right") && (c._cancelSlideTo(), c._is_safari === !1 && c._is_firefox === !1 && d.VideoPlayer("pause"), c._slider.next()))
			}), this._initialiseSlides(), this._addKeyboardNavigation()
		},
		_setVideoOpacity: function () {
			var b = this,
				c = a(".VideoPlayer", b.$element);
			c.transition({
				opacity: 0,
				duration: 0
			})
		},
		_initialiseSlides: function () {
			var b = this;
			b._resizeSlide(!0), b._$window.trigger("resize"), b._$currentSlide = a(this._slider.currSlide.holder), b._$currentSlide.addClass("current"), b._setVideoOpacity(), a(".linkContainer a", b._$currentSlide).on("click tap", function (a) {
				a.stopPropagation()
			}), b._hoverOverCTAs(), b._setupSlideComponents(), b._resizeSlide(!0), b._$window.trigger("resize"), setTimeout(function () {
				b._$currentSlide.waitForImages(function () {
					b._resizeSlide(!0), b._$window.trigger("resize"), b._slider.updateSliderSize(!0)
				})
			}, 200)
		},
		_hoverOverCTAs: function () {
			var b = this;
			a(".linkContainer a, .playButton", this._$currentSlide).on("mouseenter", function () {
				b._userInteracting = !0, b._cancelSlideTo()
			}).on("mouseleave", function () {
				b._userInteracting = !1;
				var c = a(".VideoPlayer", b._$currentSlide);
				b._slideToNextIn(1 === c.length ? 3e4 : 1e4)
			})
		},
		_onScroll: function () {
			var b = this;
			b._scrollTimer || (b._scrollTimer = setTimeout(function () {
				clearTimeout(b._scrollTimer), b._scrollTimer = null;
				b._$window.scrollTop() >= b._bottomOfHero ? b._offScreen === !1 && (b.$element.addClass("offScreen"), b.$element.append('<div class="disable"></div>'), a(".disable", b.$element).transit({
					opacity: .6
				}, 400), b._pauseCarousel(), b._offScreen = !0) : b._offScreen === !0 && (b.$element.removeClass("offScreen"), b._offScreen = !1, a(".disable", b.$element).transit({
					opacity: 0
				}, 400, function () {
					this.remove(), b._playCarousel()
				}))
			}, 250))
		},
		_slideToNextIn: function (b) {
			var c = this;
			null !== c._slider && (clearTimeout(c._slideTimer), 0 === a(".disable", c.$element).length && (c._slideTimer = setTimeout(function () {
				"slideFromRight" === c._direction ? c._slider.next() : c._slider.prev()
			}, b)))
		},
		_cancelSlideTo: function () {
			var a = this;
			null !== a._slider && clearTimeout(a._slideTimer)
		},
		_resizeSlide: function (c) {
			var d = this;
			if (c === !1 && d._$window.width() === d._windowWidth) return !1;
			d._windowWidth = d._$window.width(), d._windowHeight = d._$window.height();
			var e = 0;
			if (d._$window.width() >= site.breakpoints.medium) {
				var f = b.innerHeight ? b.innerHeight : d._$window.height();
				e = f - this.$element.offset().top, e > 450 && this.$element.css("height", e)
			} else this.$element.removeAttr("style");
			null !== this._slider && this._slider.updateSliderSize(), this._bottomOfHero = (this.$element.offset().top + this.$element.outerHeight()) / 2, this._$window.width() > this._$window.height() ? "portrait" === d._orientation && (d._orientation = "landscape", d._tallest = 0) : "landscape" === d._orientation && (d._orientation = "portrait", d._tallest = 0), this._$window.width() <= site.breakpoints.small ? (a(".rsContainer", this.$element).css({
				height: "100%"
			}), a(".heroItem", this.$element).each(function () {
				var b = a(this);
				b.height() > d._tallest && (d._tallest = b.height())
			}), a(".rsContainer", this.$element).css({
				height: d._tallest
			})) : a(".rsContainer", this.$element).css({
				height: "100%"
			}), d._singleItemCarousel === !0 && d._singleHeroContent(), d._videoSize(), d._recalculateThirds(), setTimeout(function () {
				d.$element.addClass("loaded")
			}, 800)
		},
		_userFinishedInteraction: function () {
			var a = this;
			a._userInteracted = !0, a._cancelSlideTo()
		},
		_destroySlideComponents: function () {
			a(".VideoPlayer", this._$currentSlide).VideoPlayer("destroy")
		},
		_setupSlideComponents: function () {
			var c = this,
				d = a(".VideoPlayer", c._$currentSlide),
				e = a(".heroContent", c._$currentSlide);
			if (1 === d.length) {
				var f = "ontouchstart" in b || navigator.msMaxTouchPoints;
				if (f) return a(".heroItem > .image", this._$currentSlide).show(), d.remove(), c._resizeSlide(!0), a(b).trigger("resize"), c._slideToNextIn(7e3), void c._noVideoInteraction();
				if (c._autoplayDisabled = !0, c._cancelSlideTo(), c._slideToNextIn(3e4), null === this._firstVideo || this._firstVideo === c._$currentSlide.index()) this._firstVideo = c._$currentSlide.index(), d.VideoPlayer({
					autoplay: !0,
					controls: [],
					loop: !0,
					muted: !0,
					clickToPlayPause: !1,
					pauseOtherPlayers: !1,
					onCanPlay: function (a) {
						(d.parents(".rsSlide")[0] === c._$currentSlide[0] || c._singleItemCarousel === !0) && d.fadeTo(700, 1, function () {
							e.addClass("visible")
						}), "flash" === a.pluginType && (c._videoUsesFlash = !0)
					}
				});
				else {
					if (c._videoUsesFlash !== !1) return a(".heroItem > .image", this._$currentSlide).show(), d.remove(), c._resizeSlide(!0), a(b).trigger("resize"), void c._slideToNextIn(7e3);
					d.VideoPlayer({
						autoplay: !0,
						controls: [],
						loop: !0,
						muted: !0,
						pauseOtherPlayers: !1,
						clickToPlayPause: !1,
						onCanPlay: function () {
							(d.parents(".rsSlide")[0] === c._$currentSlide[0] || c._singleItemCarousel === !0) && d.fadeTo(700, 1, function () {
								e.addClass("visible")
							})
						}
					})
				}
				d.VideoPlayer("canBeResumed") === !0 && e.addClass("visible"), d.VideoPlayer("play"), d.off("videoEnded").on("videoEnded", function () {
					c._userInteracting === !1 && c._slideToNextIn(1)
				}), c._videoMute()
			} else c._noVideoInteraction()
		},
		_noVideoInteraction: function () {
			var b = this,
				c = a(".heroContent", b._$currentSlide);
			c.addClass("visible"), b._userInteracted === !1 ? b._slideToNextIn(7e3) : (b._slideToNextIn(1e4), b._userInteracted = !1)
		},
		_videoSize: function () {
			var b = a("video", this.$element),
				c = b.outerWidth(),
				d = b.outerHeight(),
				e = a(this.$element),
				f = c / d,
				g = 0;
			null !== e && (g = e.width());
			var h = 0;
			null !== e && (h = e.height());
			var i = g / h;
			f > i ? b.height(h).width("auto").removeClass("is-vertical").addClass("is-horizontal").css("marginTop", 0).css("marginLeft", -(c / 2 | 0)) : i > f ? b.width(g).height("auto").removeClass("is-horizontal").css("marginLeft", 0).addClass("is-vertical").css("marginTop", -(d / 2 | 0)) : b.width("100%").height("auto").removeClass("is-horizontal").removeClass("is-vertical").css("margin", 0)
		},
		_videoMute: function () {
			var b = this,
				c = a(".playButton", b.$element);
			c.off("click tap").on("click tap", function (d) {
				d.stopPropagation(), c.hasClass("soundOn") ? (a(".VideoPlayer", b._$currentSlide).VideoPlayer("mute", !0), c.removeClass("soundOn")) : (a(".VideoPlayer", b._$currentSlide).VideoPlayer("mute", !1), c.addClass("soundOn"))
			})
		},
		_singleHeroContent: function () {
			var c = this.$element.filter('[data-total="1"]'),
				d = a(".heroContent", c),
				e = d.outerWidth(),
				f = d.outerHeight();
			a(b).width() > site.breakpoints.small ? d.css(a(".heroItem", c).hasClass("alignedText") ? {
				"margin-top": 0 - f / 2
			} : {
				"margin-top": 0 - f / 2,
				"margin-left": 0 - e / 2
			}) : d.removeAttr("style")
		},
		_addKeyboardNavigation: function () {
			var b = this,
				c = b._slider,
				d = a(".royalSlider", b.$element);
			d.attr("tabindex", "0"), d.keydown(function (a) {
				39 === a.keyCode ? (c.next(), d.focus(), b._updateSlideLinks()) : 37 === a.keyCode && (c.prev(), d.focus(), b._updateSlideLinks())
			}), b._updateSlideLinks()
		},
		_updateSlideLinks: function () {
			var b = this,
				c = b._slider,
				d = (a(".royalSlider", b.$element), a(".rsSlide", b.$element)),
				e = c.currSlide.content;
			a("a", d).attr("tabindex", "-1"), a("a", e).attr("tabindex", ""), a(".TargetLinks").TargetLinks("setupListener"), a(".ResponsiveLink").ResponsiveLink()
		},
		_pauseCarousel: function (b) {
			var c = this;
			if ("undefined" != typeof b && (c = b.data.that), c._offScreen !== !0) {
				var d = a(".VideoPlayer", c._$currentSlide);
				1 === d.length && d.VideoPlayer("pause"), setTimeout(function () {
					c._cancelSlideTo(), d = a(".VideoPlayer", c._$currentSlide), 1 === d.length && d.VideoPlayer("pause")
				}, 200)
			}
		},
		_playCarousel: function (b) {
			var c = this;
			if ("undefined" != typeof b && (c = b.data.that), c._offScreen !== !0) {
				var d = a(".VideoPlayer", c._$currentSlide);
				1 === d.length ? d.VideoPlayer("play") : c._slideToNextIn(7e3)
			}
		}
	};
	jQuery.createComponent("HeroCarousel", c)
}(jQuery, window, document), function (a, b, c) {
	var d = {
		_defaults: {},
		_ltie10: !1,
		_touchDevice: !1,
		_hoverTimer: null,
		_itemWidth: 0,
		_hasSharing: !1,
		_animationDuration: 400,
		_allOpen: !1,
		_tabletTapTimer: null,
		init: function () {
			var b = this;
			a("html").hasClass("lt-ie10") && (this._ltie10 = !0), ("ontouchstart" in c.documentElement || navigator.msMaxTouchPoints) && (this._touchDevice = !0), this._bindEvents();
			var d = a("> li.share", this.$element);
			if (1 === d.length) {
				b._hasSharing = !0;
				var e = a(".SocialSharing", d);
				e.SocialSharing({
					orientation: "horizontal",
					animateFrom: "right",
					visibleWhenClosed: !1,
					hasMenu: !1
				}), this._sharingWidth = 50 * a("> a", e).length, a("> span > a", d).hide(), e.width(this._sharingWidth), e.show()
			}
			this._calculateAnimationPositions();
			var f = site.utils.cookieManager.readCookie("JLR_IgniteBar"),
				g = b._getText();
			null === f ? b._openAllItems() : b._compareText(JSON.parse(f), g), b._updateCookie(g)
		},
		_generateHash: function (a) {
			for (var b = 0, c = a.length, d = 0; c > d; d++) b = 31 * b + a.charCodeAt(d), b &= b;
			return b
		},
		_bindEvents: function () {
			var b = this;
			a("> li > a, > li.share > span > a", this.$element).on("click tap", {
				that: b
			}, b._onBarClick), a("> li", this.$element).on("mouseenter", {
				that: b
			}, b._onHover), a("> li", this.$element).on("mouseleave", {
				that: b
			}, b._onBlur), a("> li.share span", this.$element).on("mouseenter", function () {
				a("> li.share", b.$element).addClass("hover")
			}), a("> li > a", this.$element).on("focus", function () {
				var b = a(this).parent("li");
				b.trigger("mouseenter")
			}), a("> li > a", this.$element).on("blur", function () {
				var b = a(this).parent("li");
				b.trigger("mouseleave")
			})
		},
		_equalWidthItems: function () {
			var b = this;
			if (0 === a("> li.active", b.$element).length) {
				a("> li > span", this.$element).css({
					visibility: "hidden",
					display: "block"
				}), a("> li:not(.share) > span", this.$element).css({
					width: "auto"
				}), this._itemWidth = 0, jQuery.each(a("> li > span", this.$element), function (c, d) {
					a(d).outerWidth() > b._itemWidth && (b._itemWidth = a(d).outerWidth())
				}), a("> li > span", this.$element).width(this._itemWidth), b._calculateAnimationPositions()
			}
		},
		_calculateAnimationPositions: function () {
			var b = this,
				c = {};
			jQuery.each(a("> li > span", this.$element), function (d, e) {
				var f = a(e),
					g = f.outerWidth();
				c = {
					x: g,
					duration: 0
				}, b._ltie10 === !0 && (c = {
					"margin-right": 0 - f.outerWidth(),
					duration: 0
				}), f.transition(c, function () {
					f.css({
						visibility: "hidden"
					})
				})
			})
		},
		_onBarClick: function (b) {
			var c = b.data.that,
				d = a(b.currentTarget).parent().parent();
			if (d.hasClass("share")) {
				if (d.hasClass("opening") || d.hasClass("closing")) return;
				return void(d.hasClass("active") && (b.stopImmediatePropagation(), b.preventDefault(), d.removeClass("hover").addClass("openOnceClosed"), c._closeItem(d), a(".SocialSharing", d).css({
					left: "0px"
				})))
			}
			d = a(b.currentTarget).parent(), (c._touchDevice === !0 || d.hasClass("share")) && (b.stopImmediatePropagation(), b.preventDefault()), clearTimeout(c._hoverTimer), d.hasClass("opening") || d.hasClass("closing") || (d.hasClass("active") ? (d.removeClass("hover"), c._closeItem(d), a("document").trigger("click")) : c._openItem(d))
		},
		_onHover: function (b) {
			var c = b.data.that;
			clearTimeout(c._hoverTimer);
			var d = 325;
			a(b.currentTarget).addClass("hover").removeClass("closedOnceOpened"), 0 !== a("> li.active", c.$element).length && (d = 0), c._hoverTimer = setTimeout(function () {
				c._openItem(a(b.currentTarget))
			}, d)
		},
		_onBlur: function (b) {
			var c = b.data.that;
			a(b.target).parent().parent().hasClass("share") && a(b.target).parent().parent().hasClass("closing") || (a(b.currentTarget).removeClass("hover"), c._allOpen !== !0 && (clearTimeout(c._hoverTimer), a(b.currentTarget).removeClass("openOnceClosed"), c._closeItem(a(b.currentTarget))))
		},
		_openItem: function (b) {
			var c = this,
				d = a("> span", b),
				e = 0;
			if (b.hasClass("active") && b.hasClass("closing")) return void b.addClass("openOnceClosed");
			if (!b.hasClass("opening")) {
				if (b.removeClass("openOnceClosed").addClass("active opening"), b.hasClass("share")) {
					e = 50 * a(".SocialSharing a", b).length;
					var f = a("> li.share", this.$element);
					f.addClass("hover"), a("> span > a", f).hide(), a("> span > div", f).show();
					var g = {
						x: a("> div", d).outerWidth(),
						duration: 0
					};
					c._ltie10 === !0 && (g = {
						"margin-right": 0 - a("> div", b).outerWidth(),
						duration: 0
					}), d.transition(g)
				}
				var h = 0;
				c._ltie10 === !0 ? (h = 50, d.css({
					visibility: "visible"
				}).animate({
					"margin-right": h
				}, c._animationDuration, function () {
					c._openedItem(b)
				})) : d.css({
					visibility: "visible"
				}).transition({
					x: h,
					duration: c._animationDuration,
					easing: "ease"
				}, function () {
					c._openedItem(b)
				})
			}
		},
		_openAllItems: function () {
			var b = this;
			b._allOpen = !0;
			var c = a("> li.share", this.$element);
			1 === c.length && (a("> span > a", c).show(), a("> span > div", c).hide()), this._equalWidthItems();
			var d = a("> li > span", this.$element);
			if (d.css({
				visibility: "hidden",
				display: "block"
			}), d.parent().addClass("active opening"), b._ltie10 === !0) d.css({
				visibility: "visible"
			}).animate({
				"margin-right": 50
			}, b._animationDuration, function () {
				jQuery.each(d, function (c, d) {
					b._openedItem(a(d).parent(), !0)
				})
			});
			else {
				var e = 0;
				d.css({
					visibility: "visible"
				}).transition({
					x: e,
					duration: b._animationDuration,
					easing: "ease"
				})
			}
			setTimeout(function () {
				jQuery.each(d, function (c, d) {
					b._openedItem(a(d).parent(), !0)
				})
			}, b._animationDuration + 20)
		},
		_openedItem: function (a, b) {
			var c = this;
			a.removeClass("opening"), b === !0 ? setTimeout(function () {
				c._allOpen = !1, c._closeItem(a)
			}, 5500) : a.hasClass("closeOnceOpened") && c._closeItem(a), this._touchDevice === !0 && (this._tabletTapTimer = setTimeout(function () {
				a.removeClass("hover"), c._closeItem(a)
			}, 5500))
		},
		_closeItem: function (b) {
			var c = this,
				d = a("> span", b);
			if (b.hasClass("active")) {
				if (b.hasClass("hover")) return;
				if (b.hasClass("opening")) b.addClass("closeOnceOpened");
				else if (b.removeClass("closeOnceOpened").addClass("closing"), this._ltie10 === !0) d.animate({
					"margin-right": 0 - d.width()
				}, c._animationDuration, function () {
					c._closedItem(b)
				});
				else {
					var e = d.outerWidth();
					d.parent().hasClass("share") && (e = a("> div", d).outerWidth()), d.transition({
						x: e,
						duration: c._animationDuration
					}, function () {
						c._closedItem(b)
					})
				}
			}
		},
		_closedItem: function (b) {
			var c = this;
			if (!b.hasClass("opening")) {
				clearTimeout(c._tabletTapTimer), b.removeClass("active closing opened closeOnceOpened");
				var d = a("> span", b);
				d.css({
					visibility: "hidden",
					width: "auto"
				}), b.hasClass("openOnceClosed") && c._openItem(b)
			}
		},
		_getText: function () {
			var b = this,
				c = a("> li:not(.share)", this.$element),
				d = {};
			return jQuery.each(c, function (c, e) {
				d[a("> a > div", e).attr("class")] = b._generateHash(a("> span > a", e).html())
			}), d
		},
		_updateCookie: function (a) {
			site.utils.cookieManager.createCookie("JLR_IgniteBar", JSON.stringify(a))
		},
		_compareText: function (a, b) {
			var c = !1;
			for (var d in b) {
				if ("undefined" == typeof a[d]) {
					c = !0;
					break
				}
				if (a[d] !== b[d]) {
					c = !0;
					break
				}
			}
			c === !0 && this._openAllItems()
		}
	};
	jQuery.createComponent("IgniteBar", d)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		init: function () {
			this._resizeText()
		},
		_resizeText: function () {
			var c = a("a", this.$element),
				d = a(b);
			d.smartresize(function () {
				setTimeout(function () {
					c.removeAttr("style").equalHeights()
				}, 1e3)
			}), c.removeAttr("style").equalHeights()
		}
	};
	jQuery.createComponent("IgniteBarDevice", c)
}(jQuery, window, document), function (a) {
	var b = {
		_defaults: {},
		init: function () {
			var b = this;
			a("form", b.$element).on("submit", function (c) {
				var d = a("input.postCode", b.$element),
					e = a("p.errorMessage", b.$element),
					f = new RegExp(b.$element.data("postcode-regex"));
				e.hide(), "" !== d.val() && d.val() !== d.attr("placeholder") && f.test(d.val()) || (c.preventDefault(), e.show(), d.css({
					border: "1px solid red"
				}))
			})
		}
	};
	jQuery.createComponent("InPageDealerLocator", b)
}(jQuery, window, document), function (a, b) {
	var c = {
		_$window: null,
		_$content: null,
		_$navBar: null,
		_$topLink: null,
		_$linksContainer: null,
		_$navLinkItems: null,
		_$navLinks: null,
		_$indicator: null,
		_scrollDuration: 800,
		_slideDuration: 400,
		_slideInTimeout: null,
		_scrollCompleteTimeout: null,
		_isTouchDevice: null,
		_isIe: null,
		_limitTop: null,
		_limitBottom: null,
		_navHeight: null,
		_waypoints: [],
		init: function () {
			var a = this;
			a._detectTouch(), a._isTouchDevice === !1 && (a._getElements(), a._detectIe(), a._setLinkCount(), a._calculations(), a._disableAnimation(), a._setNavPosition(), a._setActiveSection(), a._enableAnimation(), a._addEvents(), a._$window.on("resize", function () {
				a._calculations(), a._disableAnimation(), a._setNavPosition(), a._setActiveSection(), a._enableAnimation(), setTimeout(function () {
					a._calculations(), a._disableAnimation(), a._setNavPosition(), a._setActiveSection(), a._enableAnimation()
				}, 1e3)
			}), a._$window.on("scroll", function () {
				a._setNavPosition(), a._setActiveSection()
			}))
		},
		_detectTouch: function () {
			var a = this;
			site.utils.isMobileDevice() === !0 ? (a._isTouchDevice = !0, a.$element.addClass("touchDevice")) : a._isTouchDevice = !1
		},
		_detectIe: function () {
			var b = this;
			b._isIe = a("html").hasClass("ie")
		},
		_getElements: function () {
			var c = this;
			c._$window = a(b), c._$content = a("#content"), c._$navBar = a(".ipnBar", c.$element), c._$topLink = a(".ipnTopLink", c._$navBar), c._$linksContainer = a(".ipnLinksContainer", c._$navBar), c._$navLinkItems = a(".ipnLinks li", c._$linksContainer), c._$navLinks = a("a", c._$navLinkItems), c._$indicator = a(".ipnIndicator", c._$linksContainer)
		},
		_setLinkCount: function () {
			var a = this;
			a.$element.attr("data-total", a._$navLinks.length)
		},
		_enableAnimation: function () {
			var a = this;
			a.$element.removeClass("ipnNoAnimate")
		},
		_disableAnimation: function () {
			var a = this;
			a.$element.addClass("ipnNoAnimate")
		},
		_calculations: function () {
			var a = this;
			a._navCalculations(), a._waypointCalculations()
		},
		_navCalculations: function () {
			var a = this;
			a._limitTop = a.$element.offset().top, a._limitBottom = a._$content.offset().top + a._$content.outerHeight(), a._navHeight = a._$navBar.outerHeight(), a.$element.height(a._navHeight)
		},
		_waypointCalculations: function () {
			var b = this,
				c = [],
				d = b._$navBar.outerHeight();
			b._$navLinks.each(function () {
				var b = a(this),
					e = b.attr("href"),
					f = a(e);
				f.length > 0 && c.push({
					top: f.offset().top - d,
					link: b
				})
			}), c.sort(b._sortWaypoints), b._waypoints = c
		},
		_sortWaypoints: function (a, b) {
			return b.top - a.top
		},
		_addEvents: function () {
			var c = this;
			c._$topLink.on("click tap", function (a) {
				a.preventDefault(), site.utils.scrollTo(0)
			}), c._$navLinks.on("click tap", function (d) {
				d.preventDefault(), clearTimeout(c._slideInTimeout), clearTimeout(c._scrollCompleteTimeout);
				var e = a(this),
					f = e.attr("href"),
					g = a(f);
				if (g.length > 0) {
					c.$element.addClass("ipnScrollInProgress"), c._setActiveLink(e.parents("li").index());
					var h = g.first().offset().top;
					c._isIe && (h += 2), site.utils.scrollTo(h, c._scrollDuration), c._slideInTimeout = setTimeout(function () {
						c._slideIn()
					}, c._scrollDuration - c._slideDuration)
				} else b.location.href = f
			})
		},
		_setNavPosition: function () {
			var a = this;
			if (a.$element.hasClass("ipnScrollInProgress") === !1) {
				var b = a._$window.scrollTop();
				if (b >= a._limitTop) {
					a.$element.addClass("ipnSticky"), a.$element.addClass("ipnReversed");
					var c = b + a._navHeight;
					c > a._limitBottom ? a._$navBar.css("top", a._limitBottom - c) : a._$navBar.css("top", "")
				} else a.$element.removeClass("ipnSticky"), a.$element.removeClass("ipnReversed"), a._$indicator.removeAttr("data-active"), a._$navLinkItems.removeClass("active")
			}
		},
		_setActiveSection: function () {
			var b = this;
			if (b.$element.hasClass("ipnScrollInProgress") === !1) {
				var c = b._$window.scrollTop();
				a.each(b._waypoints, function (a, d) {
					return c >= d.top ? (b._setActiveLink(d.link.parents("li").index()), !1) : void 0
				})
			}
		},
		_setActiveLink: function (b) {
			var c = this,
				d = c._$navLinkItems.eq(b),
				e = c._$navLinkItems.filter(".active");
			if (d[0] !== e[0]) {
				var f = a("a", d);
				c._$navLinkItems.removeClass("active"), d.addClass("active");
				var g = c._$linksContainer.outerWidth(),
					h = c._$linksContainer.offset().left,
					i = h + g,
					j = f.offset().left,
					k = j + f.outerWidth(),
					l = c._$indicator.offset().left;
				l > j ? (c._$indicator.removeClass("ipnIndicatorAnimateRight"), c._$indicator.addClass("ipnIndicatorAnimateLeft")) : (c._$indicator.removeClass("ipnIndicatorAnimateLeft"), c._$indicator.addClass("ipnIndicatorAnimateRight"));
				var m = 100 * ((j - h) / g),
					n = 100 * ((i - k) / g);
				c._$indicator.css({
					left: m + "%",
					right: n + "%"
				})
			}
			c._$indicator.attr("data-active", b + 1)
		},
		_slideIn: function () {
			var a = this,
				b = a._$window.scrollTop(),
				c = a._$navBar.offset().top;
			if (b > c) {
				var d = c - b;
				d = d < -a._navHeight ? -a._navHeight : d, a._$navBar.css("top", d + "px"), a.$element.addClass("ipnSticky"), a._disableAnimation(), a.$element.addClass("ipnReversed"), a._$navBar.animate({
					top: 0
				}, {
					duration: a._slideDuration,
					easing: "easeOutSine",
					complete: function () {
						a._$navBar.css("top", ""), a.$element.removeClass("ipnScrollInProgress"), a._enableAnimation(), a._setNavPosition()
					}
				})
			} else a._scrollCompleteTimeout = setTimeout(function () {
				a.$element.removeClass("ipnScrollInProgress"), a._enableAnimation(), a._setNavPosition()
			}, a._slideDuration)
		}
	};
	jQuery.createComponent("InPageNavigation", c)
}(jQuery, window, document), function (a) {
	var b = {
		_defaults: {},
		_$dropdown: null,
		init: function () {
			this.$element.css({
				overflow: "hidden"
			}), this._$dropdown = a(".DropdownNav", this.$element), this.bindEvents()
		},
		bindEvents: function () {
			var b = this;
			a(".chooseModel > a", this.$element).on("click tap", function (a) {
				a.stopPropagation(), a.preventDefault(), b._open()
			})
		},
		_open: function () {
			var b = this,
				c = b.$element.height();
			b.$element.height(c), a(".modelsContainer", b.$element).show(), b.$element.transition({
				height: a(".modelsContainer", b.$element).height(),
				duration: 400
			}), a(".subNavWrapper", b.$element).transition({
				y: 0 - c,
				duration: 400
			}, function () {
				b.$element.addClass("modelsOpened")
			}), a(".subNavWrapper > ul > li > a", b.$element).attr("tabindex", "-1"), a(".modelsContainer .back", b.$element).on("click tap", function (a) {
				a.preventDefault(), b._close()
			}), a(".NavigationModelSwitcher").NavigationModelSwitcher("openOnRotate")
		},
		_close: function () {
			var b = this;
			b.$element.height("auto");
			var c = b.$element.height();
			b.$element.height(c);
			var d = c - a(".modelsContainer", b.$element).height();
			b.$element.transition({
				height: d,
				duration: 200
			}, function () {
				a(".subNavWrapper", b.$element).transition({
					y: 0,
					duration: 400
				}, function () {
					a(".modelsContainer", b.$element).hide(), b.$element.height("auto"), b.$element.removeClass("modelsOpened")
				})
			}), a(".subNavWrapper > ul > li > a", b.$element).attr("tabindex", ""), a(".NavigationModelSwitcher").NavigationModelSwitcher("fastClose"), a(".modelsContainer .back", b.$element).off("click tap")
		},
		openModelsOnRotate: function () {
			var a = this;
			a._openModelsOnRotate = !0, enquire.register("screen and (min-width: 1px) and (max-width: " + site.breakpoints.small + "px)", {
				setup: function () {
					a._openModelsOnRotate === !0 && (a._openModelsOnRotate = !1, a.$element.hasClass("modelsOpened") || (a._$dropdown.hasClass("active") ? a._open() : (a._$dropdown.DropdownNav("open"), setTimeout(function () {
						a._open()
					}, 500))))
				},
				deferSetup: !0
			})
		},
		closeModels: function () {
			var a = this;
			a._openModelsOnRotate = !1, this.$element.hasClass("modelsOpened") && a._close()
		}
	};
	jQuery.createComponent("InPageSubNavigation", b)
}(jQuery, window, document), function (a) {
	var b = {
		_defaults: {},
		init: function () {
			var b = this,
				c = a(".countrySelect", b.$element),
				d = a("p.errorMessage", b.$element);
			a("#countrySelectForm", b.$element).on("submit", function (a) {
				d.hide(), "0" === c.val() && (a.preventDefault(), d.show())
			}), c.on("change", function () {
				d.hide()
			})
		}
	};
	jQuery.createComponent("InternationalDealerLocator", b)
}(jQuery, window, document), function (a) {
	var b = {
		_defaults: {},
		init: function () {
			var b = this;
			site.utils.scrollTo(this.$element), a(".infoCardDealer .contactDetails .tel a", b.$element).click(function (a) {
				var b = site.utils.isBreakpointSmall() && site.utils.isMobileDevice();
				b || a.preventDefault()
			}), a(".list").lrdxMasonry({
				animate: !1
			}), a(".list").lrdxMasonry("refresh")
		}
	};
	jQuery.createComponent("InternationalDealerLocatorResults", b)
}(jQuery, window, document), function (a, b) {
	var c = {
		_cookieName: "JLR_marketCookie",
		_cookieLife: 30,
		init: function () {
			var c = this;
			a(".languageWrapper a", this.$element).on("click tap", function (d) {
				d.preventDefault();
				var e = a(this).attr("href");
				c._createCookie(e), b.location = e
			}), c._checkCookie()
		},
		_createCookie: function (b) {
			var c = this,
				d = a(".country", c.$element).data("country");
			site.utils.cookieManager.createCookie(c._cookieName, [d, b].join(","), c._cookieLife)
		},
		_checkCookie: function () {
			var a = this;
			if (site.utils.cookieManager.checkForCookie(a._cookieName) === !0) {
				var c = site.utils.cookieManager.readCookie(a._cookieName),
					d = c.split(",")[1];
				"undefined" != typeof d && (b.location = d)
			}
		}
	};
	jQuery.createComponent("LanguageSelector", c)
}(jQuery, window, document), function (a, b, c) {
	function d(b, c) {
		this.$element = a(b), this.options = a.extend({}, f, c), this._defaults = f, this._name = e, this._$searchContainer = a(".SearchButton", this.$element), this._$form = a(".MainNavSearchForm", this.$element), this._scrollDirection = "up", this._$searchButton = a(".searchButtonSearch", this.$element), this._$closeButton = a(".searchButtonClose", this.$element), this._$inactiveSearchButton = a("<div class='inactiveSearchButton'><span>SEARCH</span></div>"), this._$primaryNavLinks = a(".primaryNav li", this.$element), this._vehicleSelectorVisible = !1, this._vehicleSelectorContentLoaded = null, this._vehicleSelectorOverlayLoaded = !1, this.init(this)
	}
	var e = "MainNavigation",
		f = {};
	d.prototype = {
		init: function () {
			this._initSeachUi(this), a(".MainNavigation .MainNavSearchForm .searchText").on("input", function () {
				var b = a(this).val().toLowerCase();
				"youspinmerightroundbabyrightround" === b ? a("#logo").addClass("spinmebaby") : a("#logo").removeClass("spinmebaby")
			})
		},
		_initSeachUi: function (b) {
			a(".searchAutoComplete").AutoComplete({
				wrapper: !1,
				dataURL: a(".SearchButton input").attr("auto-complete-url"),
				keyMatchTitle: a(".SearchButton input").attr("promoted-title"),
				youSearchedTitle: a(".SearchButton input").attr("search-text"),
				appendAfter: ".MainNavigation",
				autoSubmit: !0
			}), a("#MainNavSearchForm", b.$element).on("submit", function () {
				var b = a(this).find("input");
				return b.val(site.utils.removeHTMLTags(b.val())), !0
			}), b._$searchButton.on("click tap", function (a) {
				a.preventDefault(), b._$searchButton.blur(), b._$form.hasClass("active") || (b._showSearchForm(b), b._$searchButton.hide().after(b._$inactiveSearchButton))
			}), b._$closeButton.on("click tap", function (a) {
				a.preventDefault(), b._$form.hasClass("active") && (b._hideSearchForm(b), b._$inactiveSearchButton.remove(), b._$searchButton.show())
			})
		},
		_showSearchForm: function (d) {
			a(c).off("click.MainNavigation");
			var e = a(d.$element).width(),
				f = a(d.$element).width() - 140;
			d._$form.css({
				width: f
			}).addClass("active"), d._$form.find(".searchText").focus().select(), d._$searchContainer.transition({
				width: e + "px"
			}, 400, "ease", function () {
				a(c).on("click", function (b) {
					-1 === a(b.target).parents().index(d._$searchContainer) && 0 === d._$form.find(".searchText").val().length ? (a(c).off("click.MainNavigation"), d._hideSearchForm(d), d._$inactiveSearchButton.remove(), d._$searchButton.show()) : (0 === d._$form.find(".searchText").val().length || -1 !== a(b.target).parents().index(d._$searchButton)) && d._$form.find(".searchText").focus().select().val(d._$form.find(".searchText").val())
				})
			}), d._$closeButton.attr("tabindex", ""), d._$form.find(".searchText").attr("tabindex", ""), d._$primaryNavLinks.find("a").attr("tabindex", "-1"), a(b).smartresize(function () {
				if (d._$form.hasClass("active")) {
					var b = a(d.$element).width();
					d._$searchContainer.css("width", b), d._$form.css("width", b - 140)
				}
			})
		},
		_hideSearchForm: function (b) {
			a(c).off("click"), b._$form.find(".searchText").val(""), b._$searchContainer.transition({
				width: "70px"
			}, 400, "ease"), b._$form.transition({
				width: "1px"
			}, 300, "linear", function () {
				b._$form.removeClass("active");
				var a = b._$form.find(".searchText");
				a.attr("readonly", "readonly"), a.attr("disabled", "true"), b._$closeButton.attr("tabindex", "-1"), b._$form.find(".searchText").attr("tabindex", "-1"), b._$primaryNavLinks.find("a").attr("tabindex", ""), b._$searchButton.focus(), setTimeout(function () {
					a.blur(), a.removeAttr("readonly"), a.removeAttr("disabled")
				}, 100)
			})
		}
	}, a.fn[e] = function (b) {
		return this.each(function () {
			a.data(this, "component_" + e) || a.data(this, "component_" + e, new d(this, b))
		})
	}
}(jQuery, window, document), function (a, b) {
	var c = {
		_$regionSelect: null,
		_$regionDropdown: null,
		_$countrySelect: null,
		_$countryDropdown: null,
		_$languageSelect: null,
		_$languageDropdown: null,
		_$continueButton: null,
		_countryOptions: null,
		_languageOptions: null,
		init: function () {
			var a = this;
			a._getElements(), a._cacheSelectOptions(), a._addEvents(), a._initDropdowns()
		},
		_getElements: function () {
			var b = this;
			b._$regionSelect = a(".regionSelect", b.$element), b._$regionDropdown = b._$regionSelect.parent(".DropdownSelect"), b._$countrySelect = a(".countrySelect", b.$element), b._$countryDropdown = b._$countrySelect.parent(".DropdownSelect"), b._$languageSelect = a(".languageSelect", b.$element), b._$languageDropdown = b._$languageSelect.parent(".DropdownSelect"), b._$continueButton = a(".continueButton", b.$element)
		},
		_cacheSelectOptions: function () {
			var a = this;
			a._countryOptions = a._$countrySelect.html(), a._languageOptions = a._$languageSelect.html().replace(/<!\[[^\0]*?\]\]>|<!-\-[^\0]*?-\->|(<[\w:](?:[^'">]*('|").*?\2)*[^>]*?)(=[^\s>]+)?>/g, function (a, b, c, d) {
				return d ? b + "='" + d.substring(1) + "'>" : a
			})
		},
		_addEvents: function () {
			var a = this;
			a._$regionSelect.on("change", function () {
				a._updateCountrySelect()
			}), a._$countrySelect.on("change", function () {
				a._updateLanguageSelect()
			}), a._$languageSelect.on("change", function () {
				a._updateContinueButton()
			}), a._$continueButton.on("click tap", function (b) {
				b.preventDefault(), a._redirectUser()
			})
		},
		_initDropdowns: function () {
			var a = this;
			a._$regionSelect.length > 0 ? a._$regionSelect.trigger("change") : a._$countrySelect.trigger("change")
		},
		_updateCountrySelect: function () {
			var b = this,
				c = b._$regionSelect.val();
			b._$countrySelect.html(b._countryOptions), a("option:first", b._$countrySelect).attr("selected", "selected");
			var d = a("optgroup", b._$countrySelect);
			d.each(function () {
				var b = a(this),
					d = b.data("region");
				d !== c && b.remove()
			}), null === c ? b._$countrySelect.attr("disabled", "disabled") : b._$countrySelect.removeAttr("disabled"), b._$countrySelect.trigger("update"), b._updateLanguageSelect()
		},
		_updateLanguageSelect: function () {
			var b = this,
				c = b._$countrySelect.val();
			b._$languageSelect.html(b._languageOptions), a("option:first", b._$languageSelect).attr("selected", "selected");
			var d = a("optgroup", b._$languageSelect);
			d.each(function () {
				var b = a(this),
					d = b.data("country");
				d !== c && b.remove()
			});
			var e = a("optgroup option", b._$languageSelect);
			1 === e.length && e.first().attr("selected", "selected"), null === c ? b._$languageSelect.attr("disabled", "disabled") : b._$languageSelect.removeAttr("disabled"), b._$languageSelect.trigger("update"), b._updateContinueButton()
		},
		_updateContinueButton: function () {
			var a = this,
				b = a._$languageSelect.val();
			null === b ? a._$continueButton.addClass("disabled") : a._$continueButton.removeClass("disabled")
		},
		_redirectUser: function () {
			var a = this;
			if (!a._$continueButton.hasClass("disabled")) {
				var c = a._$languageSelect.find(":selected").val();
				b.location = c
			}
		}
	};
	jQuery.createComponent("MarketPageSelector", c)
}(jQuery, window, document), function (a, b, c) {
	var d = {
		_defaults: {
			geoLocate: !0
		},
		_cookieName: "JLR_marketCookie",
		init: function () {
			var b = this;
			a("html").hasClass("lt-ie9") && 0 === a(".MainNavigation").length && a("body").addClass("ieMarketSelector"), b._assignSelectAndButtonEvents(), b.options.geoLocate && b._checkForCookiesAndGeoLocate()
		},
		_checkForCookiesAndGeoLocate: function () {
			var a, c, d = this,
				e = site.utils.cookieManager.readCookie(d._cookieName),
				f = d._checkReferrer(),
				g = site.utils.cookieManager.checkForCookie(d._cookieName);
			g && (a = "XI" !== e.split(",")[0], c = d._checkTimeStamp(e.split(",")[2])), f && g && a && c ? b.location = e.split(",")[1] : site.utils.geoLocationManager.getGeoLocation(function (a) {
				d._preSelectDropdown(a.country_code)
			})
		},
		_preSelectDropdown: function (b) {
			var c = this,
				d = a(".continentSelect", c.$element),
				e = a(".countrySelect", c.$element),
				f = e.find("option[value='country-" + b + "']", c.$element);
			f.length > 0 && (d.val(f.parent().attr("data-continent")), d.removeAttr("disabled"), d.trigger("update").trigger("change"), e.val("country-" + b), e.removeAttr("disabled"), e.trigger("update").trigger("change"))
		},
		_checkTimeStamp: function (a) {
			var b = !0,
				c = (Date.now() - Number(a)) / 1e3;
			return 20 > c && (b = !1), b
		},
		_checkReferrer: function () {
			var a = c.referrer,
				b = !0;
			return (-1 !== a.indexOf("landrover") || -1 !== a.indexOf("local")) && (b = !1), b
		},
		_assignSelectAndButtonEvents: function () {
			var c = this,
				d = a(".continentSelect", c.$element),
				e = a(".countrySelect", c.$element),
				f = e.html(),
				g = a(".languageSelect", c.$element),
				h = g.html(),
				i = a(".continueButton", c.$element);
			e.attr("disabled", "disabled"), e.trigger("update"), g.attr("disabled", "disabled"), g.trigger("update"), d.on("change", function () {
				a("option:first", g).attr("selected", "selected"), g.attr("disabled", "disabled"), g.trigger("update"), i.addClass("disabled"), e.html(f), a("option:first", e).attr("selected", "selected");
				for (var b = e.find("optgroup"), c = 0; c < b.length; c++) a(b[c]).attr("data-continent") === d.val() && (e.children("optgroup").remove(), e.append(a(b[c]).html()));
				e.removeAttr("disabled"), e.trigger("update")
			}), e.on("change", function () {
				g.html(h), i.addClass("disabled");
				for (var b = g.find("optgroup"), c = null, d = 0; d < b.length; d++) a(b[d]).attr("data-country") === e.val() && c !== e.val() && (c = e.val(), g.children("optgroup").remove(), g.append(a(b[d]).html()), g.children().length <= 2 && (a("option:nth-child(2)", g).attr("selected", "selected"), i.removeClass("disabled")));
				g.removeAttr("disabled"), g.trigger("update")
			}), g.on("change", function () {
				i.removeClass("disabled")
			}), i.on("click tap", function (d) {
				if (d.preventDefault(), !a(this).hasClass("disabled")) {
					var f = g.find(":selected").attr("data-market-url"),
						h = e.val().split("-")[1];
					site.utils.cookieManager.createCookie(c._cookieName, [h, f, Date.now()].join(","), 30), b.location = f
				}
			}), a(".visitInternational", c.$element).on("click tap", function (d) {
				d.preventDefault();
				var e = a(this).attr("href");
				site.utils.cookieManager.createCookie(c._cookieName, ["XI", e, Date.now()].join(","), 30), b.location = e
			})
		},
		_destroy: function () {
			var b = this;
			a(".continentSelect", b.$element).off("change"), a(".countrySelect", b.$element).off("change"), a(".languageSelect", b.$element).off("change")
		}
	};
	jQuery.createComponent("MarketSelector", d)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {
			url: "",
			overlay: !0
		},
		_tallestModel: 0,
		_windowWidth: 0,
		_$visibleTab: a(".visibleTab", this.$element),
		_touchEnabledDevice: "ontouchstart" in b || navigator.msMaxTouchPoints ? !0 : !1,
		init: function () {
			var c = this;
			this._windowWidth = a(b).width(), c._$tabFilter = a(".TabFilter", this.$element), a(b).smartresize(function () {
				c._onResize()
			}), "" !== this.options.url ? a.ajax({
				type: "GET",
				url: this.options.url,
				dataType: "html"
			}).done(function (b) {
				c.$element.html(a(".ModelSelector", b).html()), a(".ResponsiveLink").ResponsiveLink(), a(".ModelSelector", b).hasClass("withTabs") && c.$element.addClass("withTabs"), b = null, c._onOpen()
			}) : c._onOpen(), c._$tabFilter.on("changeTabs", function () {
				setTimeout(function () {
					c._recalculateModelHeights()
				}, 1e3)
			})
		},
		_onOpen: function () {
			var c = this;
			this._modelSelectorVisible = !0, b.picturefill(), a(".TabFilter", this.$element).TabFilter(), this._recalculateModelHeights(), c._windowWidth = a(b).width(), a(".TargetLinks").TargetLinks("setupListener"), this.options.overlay === !0 && a(".backButton", this.$element).on("click tap", function (a) {
				a.preventDefault(), c._closeModelSelector()
			}), c.$element.waitForImages(function () {
				a(b).trigger("resize")
			}), a(".selectorContentLink", this.$element).on("click tap", function (a) {
				c._touchEnabledDevice || a.preventDefault()
			}), this.$element.trigger("readyToOpen"), c._checkContentLinks()
		},
		_checkContentLinks: function () {
			if (this._touchEnabledDevice) {
				var b = a(".selectorContentLink", this._$vehicleSelector);
				a.each(b, function (b, c) {
					var d = a(c),
						e = d.html();
					d.replaceWith(a('<a href="' + d.attr("data-href") + '" class="selectorContentLink TargetLinks" tabindex="-1" data-href="' + d.attr("data-href") + '" data-target="' + d.attr("data-target") + '">' + e + "</div>")), a(".TargetLinks").TargetLinks("setupListener")
				})
			}
		},
		_onResize: function () {
			this._recalculateModelHeights()
		},
		_recalculateModelHeights: function () {
			var c = this;
			this._$visibleTab = a(".tabContent", this.$element), 0 !== a(".TabFilter", this.$element).length && (this._$visibleTab = a(".visibleTab", this.$element));
			var d = a(".el", this._$visibleTab),
				e = a(".modelWrapper", this._$visibleTab),
				f = e.find(".selectorContent p"),
				g = parseInt(this._$visibleTab.attr("data-total"), 10),
				h = 3,
				i = 1;
			if (f.css("height", "auto"), f.equalHeights(), 1 !== g && (a(b).width() > 1 && a(b).width() < site.breakpoints.small ? e.css({
				height: "auto"
			}) : a(b).width() > site.breakpoints.small && a(b).width() < site.breakpoints.medium ? h = 2 : a(b).width() > site.breakpoints.medium && (4 === g || 7 === g || 8 === g) && (h = 4), a(b).width() > site.breakpoints.small)) {
				var j = 0;
				d.each(function (b) {
					b++, h >= b && a(this).removeAttr("data-row").attr("data-row", i), b === h && (a(".el[data-row=" + i + "]", c._$visibleTab).find(".modelWrapper").css("height", "auto").equalHeights(), a(".el[data-row=" + i + "]", c._$visibleTab).find(".modelSelectorButtonOne").css("height", "auto").equalHeights(), a(".el[data-row=" + i + "]", c._$visibleTab).find(".modelSelectorButtonTwo").css("height", "auto").equalHeights(), i++, h *= i)
				}), j !== h && (a(".el[data-row=" + i + "]", c._$visibleTab).find(".modelWrapper").css("height", "auto").equalHeights(), a(".el[data-row=" + i + "]", c._$visibleTab).find(".modelSelectorButtonOne").css("height", "auto").equalHeights(), a(".el[data-row=" + i + "]", c._$visibleTab).find(".modelSelectorButtonTwo").css("height", "auto").equalHeights())
			}
		},
		_closeModelSelector: function () {
			this._unbindEvents(), this.$element.trigger("onClose")
		},
		_preloadImages: function (b) {
			a(b).each(function () {
				a("<img/>")[0].src = this
			})
		},
		_unbindEvents: function () {
			a(".backButton", this.$element).off("click tap"), a(".TabFilter", this.$element).TabFilter("destroy")
		},
		_destroy: function () {
			this._unbindEvents()
		}
	};
	jQuery.createComponent("ModelSelector", c)
}(jQuery, window, document), function (a, b, c) {
	var d = {
		_defaults: {},
		popupNode: ".mobileGeoLocationPopup",
		init: function () {
			var b = this;
			if (this._initSectionsToDropDown(), this._validatePostcode(), a(".DealerAutoComplete").AutoComplete({
				localData: dealerLocator_names
			}), b._scrollToResults(), site.utils.isBreakpointSmall()) {
				if (c.location.href.indexOf("?") > -1) return;
				site.utils.geoLocationManager.getNativeGeoLocation(function (a) {
					a.error || b._showPopupOverlay(a)
				})
			}
		},
		_scrollToResults: function () {
			setTimeout(function () {
				var b = a(".NationalDealerLocatorResults, .NationalDealerLocatorError");
				site.utils.scrollTo(b)
			}, 500)
		},
		_showPopupOverlay: function (d) {
			var e = this,
				f = a(e.popupNode),
				g = a("span.location", f),
				h = a(".locationYes", f),
				i = a(".locationNo", f);
			g.text(d.city), i.on("click tap", function (b) {
				b.preventDefault(), a.magnificPopup.close()
			}), h.on("click tap", function (e) {
				e.preventDefault(), a.magnificPopup.close(), b.location = c.location.href + "?lng=" + d.longitude + "&lat=" + d.latitude
			}), a.magnificPopup.open({
				items: {
					src: e.popupNode,
					type: "inline"
				},
				showCloseBtn: !1,
				closeOnBgClick: !1,
				fixedContentPos: !0,
				alignTop: !0,
				enableEscapeKey: !1
			})
		},
		_initSectionsToDropDown: function () {
			var b = this,
				c = a(".searchForms", b.$element);
			if (c.show(), !(a("form", c).length <= 1)) {
				c.addClass("multipleForms");
				var d = a(".selectHeader", c).hide().map(function () {
					return a(this).text()
				}).get();
				a(".searchSelectContainer", c).append('<div class="col"><select class="DropdownSelect searchSelect"></select></div>'), a.each(d, function (b) {
					a(".searchSelect", c).append('<option value="' + b + '">' + this.toUpperCase() + "</option>")
				}), a(".searchSelect", c).DropdownSelect(), a("form", c).hide().eq(0).show(), a(".seperator", c).hide(), a(".searchSelect", c).change(function () {
					a("form", c).hide().eq(this.value).show()
				}), a(".searchForms form", this.$element).each(function (d) {
					var e = a(this).find(".col:nth-child(2) input, .col:nth-child(2) select");
					b._searchQueryStringParameter(e.attr("name")) && (a(".searchSelect", c).val(d), a(".searchSelectContainer span.selected", c).text(a(this).find(".selectHeader").text()), a("form", c).hide(), a(this).show())
				})
			}
		},
		_searchQueryStringParameter: function (a) {
			var c = b.location.href;
			return -1 !== c.indexOf("?" + a + "=") ? !0 : -1 !== c.indexOf("&" + a + "=") ? !0 : !1
		},
		_validatePostcode: function () {
			var b = this;
			a(".postcode", b.$element).on("submit", function (c) {
				var d = a(".postcode input[type=text]", b.$element),
					e = a("p.errorMessage", b.$element),
					f = new RegExp(b.$element.data("postcode-regex"));
				e.hide(), "" !== d.val() && d.val() !== d.attr("placeholder") && f.test(d.val()) || (c.preventDefault(), e.show(), d.css({
					border: "1px solid red"
				}))
			})
		}
	};
	jQuery.createComponent("NationalDealerLocator", d)
}(jQuery, window, document), function () {
	var a = {
		_defaults: {},
		init: function () {}
	};
	jQuery.createComponent("NationalDealerLocatorError", a)
}(jQuery, window, document), function (a, b, c, d) {
	var e = {
		_map: null,
		_pinInfoboxs: null,
		_pushPins: null,
		_mapValues: {
			mapTop: null,
			mapLeft: null,
			mapHeight: null,
			containerBottom: null,
			containerHeight: null,
			scrollLimit: null
		},
		_isDesktopDevice: null,
		_scrollPosition: null,
		init: function () {
			var c = this;
			c._detectIOS(), c._detectDesktopDevice(), c._radiusFilter(), c._resizeDealerCards(), c._loadTheme(), c._getMap(), c._addPinsToMap(), c._initDirections(), c._listEventHandlers(), c._handleTelephoneClick(), c._mapHeight(), c._mapCalculations(), c._mapPosition(), c._mapInteractions(), a(b).smartresize(function () {
				c._resizeDealerCards(), c._mapHeight(), c._mapCalculations(), c._mapPosition(), c._mapInteractions()
			}), a(b).scroll(function () {
				c._mapPosition()
			}), a(".dealerSidebar", c.$element).resize(function () {
				c._mapCalculations(), c._mapPosition()
			})
		},
		_detectIOS: function () {
			site.utils.isIOS() && this.$element.addClass("iOS")
		},
		_detectDesktopDevice: function () {
			var a = this;
			site.utils.isMobileDevice() ? a._isDesktopDevice = !1 : (a.$element.addClass("desktop"), a._isDesktopDevice = !0)
		},
		_mapHeight: function () {
			var c, d = this,
				e = a(".dealerResults", d.$element),
				f = e.find(".bingMapContainer"),
				g = f.find(".bingMap"),
				h = site.utils.getBreakpointSize(),
				i = a(b).height();
			if ("small" === h) i -= 50, i += "px", c = "";
			else if (d._isDesktopDevice) {
				var j = parseInt(f.css("padding-top"), 10) + parseInt(f.css("padding-bottom"), 10);
				i -= j;
				var k = a("#header");
				if ("fixed" === k.css("position")) {
					var l = site.utils.getHeaderHeight(site.stickyNavigationTransitionPoint + 1);
					i -= l
				}
				c = i + j + "px", i += "px"
			} else i = "", c = "";
			g.css("height", i), e.css("min-height", c)
		},
		_mapCalculations: function () {
			var b = this;
			if (null !== b._map && b._isDesktopDevice) {
				var c = a(".bingMapContainer", b.$element),
					d = c.parents(".dealerResults"),
					e = c.css("position");
				c.css("position", "static"), c.css("width", "auto"), c.css("width", c.css("width")), b._mapValues.mapTop = c.offset().top, b._mapValues.mapLeft = c.offset().left, b._mapValues.mapHeight = c.outerHeight(), b._mapValues.containerHeight = d.innerHeight(), b._mapValues.containerBottom = d.offset().top + b._mapValues.containerHeight - parseInt(d.css("padding-bottom"), 10), b._mapValues.scrollLimit = b._mapValues.containerBottom - b._mapValues.mapHeight, c.css("position", e)
			}
		},
		_mapPosition: function () {
			var c = this;
			if (null !== c._map) {
				var d = a(b),
					e = a(".bingMapContainer", c.$element),
					f = a("#header"),
					g = d.scrollTop(),
					h = "fixed" === f.css("position"),
					i = f.outerHeight();
				h && (g += i);
				var j = "",
					k = "",
					l = "";
				c._isDesktopDevice && d.width() > site.breakpoints.small && g > c._mapValues.mapTop && (g > c._mapValues.scrollLimit ? (j = "absolute", k = c._mapValues.containerHeight - c._mapValues.mapHeight + "px") : (j = "fixed", k = c._mapValues.containerBottom - (c._mapValues.mapHeight + g), k = k > 0 ? 0 : k, k = h ? k + i : k)), e.css("position", j), e.css("top", k), e.css("left", l)
			}
		},
		_mapInteractions: function () {
			var a = this;
			if (null !== a._map) {
				var b;
				b = a._isDesktopDevice ? {
					disablePanning: !1,
					disableZooming: !0
				} : {
					disablePanning: !1,
					disableZooming: !1
				}, a._map.setOptions(b)
			}
		},
		_resizeDealerCards: function () {
			var b = this,
				c = a(".noMapResults .infoCardDealer");
			site.utils.isBreakpointSmall() ? c.css("height", "auto") : b._equaliseHeights(c)
		},
		_equaliseHeights: function (b) {
			var c = 0;
			b.css("height", "auto"), b.each(function () {
				var b = a(this).outerHeight();
				b > c && (c = b)
			}), b.css("height", c)
		},
		_radiusFilter: function () {
			a(".radius-frm .radiusSelect", this.$element).on("change", function () {
				a(".radius-frm", this.$element).submit()
			})
		},
		_loadTheme: function (a) {
			Microsoft.Maps.loadModule("Microsoft.Maps.Themes.BingTheme", {
				callback: a
			})
		},
		_listEventHandlers: function () {
			var b = this;
			a(".infoCardDealer").mouseenter(function () {
				var c = a(this).parent().index();
				b._setPushPin(c)
			}), a(".infoCardDealer").mouseleave(function () {
				a(this).hasClass("selected") || b._unSetPushPins()
			}), a(".infoCardDealer .viewOnMap", b.$element).on("click tap", function (c) {
				c.preventDefault();
				var d = a(this).parents(".infoCardDealer");
				a(".infoCardDealer", b.$element).removeClass("selected"), d.addClass("selected"), site.utils.isBreakpointSmall() && b._showFullMap();
				var e = new Microsoft.Maps.Location(d.data("lat"), d.data("lng"));
				b._map.setView({
					center: e
				}), b._setPushPin(d.parent().index())
			}), a(".infoCardDealer .mobileStateBtn", b.$element).on("click tap", function (b) {
				b.preventDefault();
				var c = a(this).parents(".infoCardDealer"),
					d = c.find(".mobile");
				c.hasClass("openInfoCard") ? (c.removeClass("openInfoCard"), d.slideUp(300)) : d.slideDown(300, function () {
					c.addClass("openInfoCard")
				})
			}), a(".infoCardDealer .cardTitle a", b.$element).on("click tap", function (b) {
				b.preventDefault(), a(this).parent().parent().find(".viewOnMap").trigger("click")
			}), a(".mapCloseButton", b.$element).on("click tap", function (a) {
				a.preventDefault(), b._hideFullMap()
			})
		},
		_handleTelephoneClick: function () {
			var b = this;
			a(".contactDetails .tel a", b.$element).click(function (a) {
				var b = site.utils.isBreakpointSmall() && site.utils.isMobileDevice();
				b || a.preventDefault()
			})
		},
		_getMap: function () {
			var b = this,
				c = a(".bingMap", b.$element);
			if (c.length > 0) {
				var d = {
					credentials: b.$element.attr("data-api-key"),
					mapTypeId: Microsoft.Maps.MapTypeId.road,
					zoom: 17,
					showBreadcrumb: !1,
					enableClickableLogo: !1,
					enableSearchLogo: !1,
					showMapTypeSelector: !1,
					showCopyright: !1
				};
				b._map = new Microsoft.Maps.Map(a(".bingMap", b.$element)[0], d), Microsoft.Maps.loadModule("Microsoft.Maps.Directions")
			}
		},
		_addPinsToMap: function () {
			var b = this;
			if (null !== b._map) {
				var c = [];
				a(".dealerResults .list .infoCardDealer", b.$element).each(function () {
					var b = {};
					b.Latitude = a(this).attr("data-lat"), b.Longitude = a(this).attr("data-lng"), b.title = a(".cardDetails .cardTitle", this).text(), b.des = a(this).find(".cardTitle .dealerNameText").html(), c.push(b)
				});
				var d = c[0].Latitude,
					e = c[0].Latitude,
					f = c[0].Longitude,
					g = c[0].Longitude;
				b._pushPins = new Microsoft.Maps.EntityCollection, b._pinInfoboxs = new Microsoft.Maps.EntityCollection;
				var h = '<div class="customInfoBox"><div class="infobox_content">{content}</div></div>';
				b._map.entities.clear();
				var i = c.length;
				a.each(c, function (a) {
					var j = new Microsoft.Maps.Location(c[a].Latitude, c[a].Longitude),
						k = i - a,
						l = new Microsoft.Maps.Infobox(j, {
							htmlContent: h.replace("{content}", c[a].des),
							showCloseButton: !1,
							visible: !1,
							zIndex: k,
							offset: {
								x: -125,
								y: 70
							}
						});
					b._pinInfoboxs.push(l);
					var m = (a + 1).toString();
					m = m.length < 2 ? ("00" + m).slice(-2) : m;
					var n = new Microsoft.Maps.Pushpin(j, {
						icon: "/resources/public/images/icons/pin.png",
						width: 48,
						height: 58,
						text: m,
						infobox: l,
						zIndex: k
					});
					n.x = a, b._pushPins.push(n), Microsoft.Maps.Events.addHandler(n, "click", function (a) {
						b._pinClickHandler(a)
					}), Microsoft.Maps.Events.addHandler(b._map, "click", function () {
						b._hideInfobox()
					}), c[a].Latitude > e ? e = c[a].Latitude : c[a].Latitude < d && (d = c[a].Latitude), c[a].Longitude > g ? g = c[a].Longitude : c[a].Longitude < f && (f = c[a].Longitude)
				});
				var j = new Microsoft.Maps.EntityCollection({
					zIndex: 0
				});
				j.push(b._pushPins), b._map.entities.push(j);
				var k = new Microsoft.Maps.EntityCollection({
					zIndex: 1
				});
				if (k.push(b._pinInfoboxs), b._map.entities.push(k), b._pushPins.getLength() > 1) {
					d -= 2e-4, e += 2e-4, f -= 2e-4, g += 2e-4;
					var l = Microsoft.Maps.LocationRect.fromLocations(new Microsoft.Maps.Location(d, f), new Microsoft.Maps.Location(e, g));
					b._map.setView({
						bounds: l
					})
				} else b._map.setView({
					center: b._pushPins.get(0).getLocation(),
					zoom: 16
				})
			}
		},
		_setPushPin: function (a) {
			var b = this;
			if (null !== b._map) {
				b._unSetPushPins();
				var c = b._pushPins.get(a);
				c.setOptions({
					icon: "/resources/public/images/icons/pin_hover.png",
					zIndex: 1e3
				});
				var d = c.getInfobox();
				d.setOptions({
					visible: !0,
					zIndex: 1e3
				})
			}
		},
		_unSetPushPins: function () {
			var a = this;
			if (null !== a._map) for (var b = a._pushPins.getLength(), c = 0; b > c; c++) {
				var d = b - c,
					e = a._pushPins.get(c);
				a._pushPins.get(c).setOptions({
					icon: "/resources/public/images/icons/pin.png",
					zIndex: d
				});
				var f = e.getInfobox();
				f.setOptions({
					visible: !1,
					zIndex: d
				})
			}
		},
		_infoBoxClickHandler: function () {},
		_pinClickHandler: function (a) {
			var b = this;
			b._setPushPin(a.target.x), b._map.setView({
				center: a.target._location
			}), b._scrollToDealerCard(a.target.x)
		},
		_scrollToDealerCard: function (c) {
			var d, e = this,
				f = a(b).width(),
				g = a(".list > li:eq(" + c + ")", e.$element);
			if (e._isDesktopDevice) d = g.offset().top, site.utils.scrollTo(d - 40, 300);
			else if (f > site.breakpoints.small) {
				var h = a(".list", e.$element),
					i = h.scrollTop();
				d = g.offset().top - h.offset().top + h.scrollTop();
				var j = Math.abs(d - i) / 2;
				a(".list").stop().animate({
					scrollTop: d
				}, j)
			}
		},
		_hideInfobox: function () {
			var a = this;
			a._unSetPushPins();
			for (var b = 0; b < a._pinInfoboxs.getLength(); b++) a._pinInfoboxs.get(b).setOptions({
				visible: !1
			})
		},
		_hideFullMap: function () {
			var c = this;
			c.$element.removeClass("mapOpen"), site.utils.isBreakpointSmall() && (a("html").removeClass("noScroll"), null !== c._scrollPosition && a(b).scrollTop(c._scrollPosition))
		},
		_showFullMap: function () {
			var b = this;
			site.utils.isBreakpointSmall() && (b._scrollPosition = a(c).scrollTop(), a("html").addClass("noScroll")), b.$element.addClass("mapOpen")
		},
		_initDirections: function () {
			var c = this;
			Microsoft.Maps.loadModule("Microsoft.Maps.Directions"), c._hideDirections(); {
				var d = a(".directions .address1", c.$element);
				a(".directions .address2", c.$element)
			}
			a("h2", this.$element).attr("data-title", a("h2", this.$element).text()), c.$element.attr("data-user-lat") && (d.val(a(".directions .address1", c.$element).attr("data-your-location")), d.attr("data-lat", c.$element.attr("data-user-lat")), d.attr("data-lng", c.$element.attr("data-user-lng"))), a("a.getDirections", c.$element).on("click tap", function (d) {
				a(b).width() > site.breakpoints.small && d.preventDefault(), c._directionsClickHandler(d)
			}), a(".backToDealer", c.$element).on("click tap", function (a) {
				a.preventDefault(), c._addPinsToMap(), c._hideDirections()
			}), a(".directions .getDirectionsList", c.$element).on("click tap", function (a) {
				a.preventDefault(), c._getDirections()
			}), a(".directions .getDirectionsMap", c.$element).on("click tap", function (a) {
				a.preventDefault(), c._showFullMap(), c._getDirections()
			}), a(".directions .address1, .directions .address2", c.$element).on("input", function () {
				a(this).attr("data-lat", "").attr("data-lng", "")
			})
		},
		_directionsClickHandler: function (b) {
			{
				var c = this,
					d = a(".directions .address2", c.$element),
					e = a(b.target).parents(".infoCardDealer");
				a(".directions", c.$element)
			}
			d.val(e.find(".address").text()), d.attr("data-lat", e.attr("data-lat")), d.attr("data-lng", e.attr("data-lng")), c._showDirections(), c._getDirections()
		},
		_showDirections: function () {
			var b = this,
				d = a(".dealerResults", b.$element),
				e = d.find(".listContainer"),
				f = d.find(".directionsContainer"),
				g = a(".dealerHeader", b.$element),
				h = a("h2", g),
				i = a("h3", g),
				j = d.find(".bingMap"),
				k = a(".radius-frm", b.$element);
			b._scrollPosition = a(c).scrollTop(), h.text(h.attr("data-directions-title")), j.addClass("directionsMap"), e.hide(0, function () {
				k.hide(0), i.hide(0), f.show(0, function () {
					site.utils.scrollTo(g), b._mapCalculations()
				})
			})
		},
		_hideDirections: function () {
			var c = this,
				d = a(".dealerResults", c.$element),
				e = d.find(".listContainer"),
				f = d.find(".directionsContainer"),
				g = a(".dealerHeader", c.$element),
				h = a("h2", g),
				i = a("h3", g),
				j = d.find(".bingMap"),
				k = a(".radius-frm", c.$element),
				l = a(".directions-list", c.$element);
			h.text(h.attr("data-title")), j.removeClass("directionsMap"), f.hide(0, function () {
				l.html(""), k.show(0), i.show(0), e.show(0, function () {
					c._mapCalculations(), null !== c._scrollPosition && a(b).scrollTop(c._scrollPosition)
				})
			})
		},
		_getDirections: function () {
			var b = this,
				e = a(".directions .address1", b.$element),
				f = a(".directions .address2", b.$element),
				g = e.val(),
				h = f.val();
			if (c.createElement("input").placeholder === d && g === e.attr("placeholder") && (g = ""), e.attr("data-lat") && e.attr("data-lat").toString().length > 0 && (g = e.attr("data-lat") + "," + e.attr("data-lng")), f.attr("data-lat") && f.attr("data-lat").toString().length > 0 && (h = f.attr("data-lat") + "," + f.attr("data-lng")), g.length > 0 && h.length > 0) {
				b._map.entities.clear();
				var i = new Microsoft.Maps.Directions.DirectionsManager(b._map),
					j = new Microsoft.Maps.Directions.Waypoint({
						address: g
					}),
					k = new Microsoft.Maps.Pushpin;
				k.setOptions({
					icon: "/resources/public/images/icons/pin_hover.png",
					width: 48,
					height: 58,
					text: "A"
				}), j.setOptions({
					pushpin: k
				});
				var l = new Microsoft.Maps.Directions.Waypoint({
					address: h
				}),
					m = new Microsoft.Maps.Pushpin;
				m.setOptions({
					icon: "/resources/public/images/icons/pin.png",
					width: 48,
					height: 58,
					text: "B"
				}), l.setOptions({
					pushpin: m
				}), i.addWaypoint(j), i.addWaypoint(l), a(".directions-list", b.$element).empty(), i.setRenderOptions({
					itineraryContainer: a(".directions-list", b.$element)[0],
					disambiguationPushpinOptions: {
						icon: "/resources/public/images/icons/pin.png",
						hoverIcon: "/resources/public/images/icons/pin_hover.png",
						width: 48,
						height: 58
					}
				}), Microsoft.Maps.Events.addHandler(i, "directionsError", b._displayDirectionsError), i.calculateDirections()
			}
		},
		_displayDirectionsError: function (a) {
			var b = this;
			a.responseCode === Microsoft.Maps.Directions.RouteResponseCode.waypointDisambiguation && b._directionsDisambiguation()
		},
		_directionsDisambiguation: function () {
			var a = "",
				b = directionsManager.getAllWaypoints(),
				c = 0;
			for (c = 0; c < b.length; c++) {
				var d = b[c].getDisambiguationResult();
				if (null !== d) if (a = a + "Address matches for " + b[c].getAddress() + ":\n", 0 !== d.businessSuggestions.length) {
					var e = 0;
					for (e = 0; e < d.businessSuggestions.length; e++) a = a + d.businessSuggestions[e].name + ", " + d.businessSuggestions[e].address + "\n"
				} else if (0 !== d.locationSuggestions.length) {
					var f = 0;
					for (f = 0; f < d.locationSuggestions.length; f++) a = a + d.locationSuggestions[f].suggestion + "\n"
				} else a = a + d.headerText + "\n"
			}
		}
	};
	jQuery.createComponent("NationalDealerLocatorResults", e)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {
			toggleButton: null
		},
		_$toggleButton: null,
		_isIE8: !1,
		_openOnRotate: !1,
		_menuOffset: 0,
		init: function () {
			var c = this;
			c._$toggleButton = a(".SubNavigation .navigationModelSwitcherButtonContainer");
			var d = a(".navigationModelSwitcherButton", c._$toggleButton).outerWidth(),
				e = a(".activeSwitcherButton", c._$toggleButton).outerWidth(),
				f = d;
			e > d && (f = e), c._$toggleButton.width(f), 0 !== a(".activeSwitcherButton", c._$toggleButton).length && (a("html").hasClass("lt-ie9") && (c._isIE8 = !0), c.$element.Dropdown({
				timeout: 250,
				closeOnTapOutside: !0,
				closeOnTapOutsideExclude: a(".SubNavigation .LessButton, .SubNavigation .MoreButton"),
				button: c._$toggleButton,
				buttonWithinMenu: !1,
				openByDefault: !1,
				onOpen: function () {
					if (c._menuOffset = a(".pageWrapper").offset().top, a("html").hasClass("lt-ie10")) {
						var d = a(b);
						d.smartresize(function () {
							d.width() > b.site.breakpoints.medium - 23 ? (c._menuOffset = 0, c.$element.css({
								top: c._menuOffset
							})) : (c._menuOffset = a("#header").height(), c.$element.css({
								top: c._menuOffset
							}))
						}), d.resize()
					} else enquire.register("screen and (max-width: " + b.site.breakpoints.medium + "px)", {
						match: function () {
							c._menuOffset = a("#header").height(), c.$element.css({
								top: c._menuOffset
							})
						}
					}), enquire.register("screen and (min-width: " + b.site.breakpoints.medium + "px)", {
						match: function () {
							c._menuOffset = 0, c.$element.css({
								top: c._menuOffset
							})
						}
					});
					setTimeout(function () {
						if (c._addKeyboardNavigation(), a(".activeSwitcherButton > a", c._$toggleButton).focus(), c._resizeToButton(), a(".SubNavigation").SubNavigation("isExpanded") === !0) return a(".SubNavigation").SubNavigation("fastClose"), void setTimeout(function () {
							c.fastOpen()
						}, 220);
						c.$element.css({
							top: c._menuOffset
						}), c.$element.addClass("active animating"), a(".activeSwitcherButton", c._$toggleButton).transition({
							opacity: 0,
							duration: 0
						}, function () {
							a(".activeSwitcherButton", c._$toggleButton).show()
						}), a(".navigationModelSwitcherButton", c._$toggleButton).transition({
							opacity: 1,
							duration: 0
						}).transition({
							opacity: 0,
							duration: 200
						}, function () {
							a(".activeSwitcherButton", c._$toggleButton).transition({
								opacity: 1,
								duration: 200
							})
						}), c._$toggleButton.addClass("active"), a(b).trigger("NavigationModelSwitcher", ["opened"]);
						a(c.$element).clone().css({
							visibility: "hidden",
							display: "block",
							height: "auto",
							width: c.$element.width()
						}).addClass("clone").appendTo(c.$element.parent());
						c._height = a(".clone").height(), a(".clone").remove();
						var d = {
							y: 0 - c._height,
							duration: 1
						};
						c._isIE8 === !0 && (d = {
							marginTop: 0 - c._height,
							duration: 1
						}), c.$element.transition(d, function () {
							d = {
								y: 0,
								duration: 400,
								easing: "ease"
							}, c._isIE8 === !0 && (d = {
								marginTop: 0,
								duration: 400,
								easing: "ease"
							}), c.$element.show().transition(d, function () {
								c.$element.removeClass("animating")
							})
						}), a(".InPageSubNavigation").InPageSubNavigation("openModelsOnRotate")
					}, 50)
				},
				onClose: function (b) {
					c._removeKeyboardNavigation(), a(".navigationModelSwitcherButton > a", c._$toggleButton).focus(), "undefined" == typeof b && (b = 400), c.$element.trigger("close").addClass("animating"), a(".activeSwitcherButton", c._$toggleButton).transition({
						opacity: 1,
						duration: 0
					}).transition({
						opacity: 0,
						duration: 200
					}, function () {
						a(".navigationModelSwitcherButton", c._$toggleButton).transition({
							opacity: 1,
							duration: 200
						}, function () {
							a(".activeSwitcherButton", c._$toggleButton).hide()
						})
					}), c._height = c.$element.height();
					var d = {
						y: 0,
						duration: 1
					};
					c._isIE8 === !0 && (d = {
						marginTop: 0,
						duration: 1
					}), c.$element.transition(d, function () {
						d = {
							y: 0 - c._height,
							duration: b,
							easing: "ease"
						}, c._isIE8 === !0 && (d = {
							marginTop: 0 - c._height,
							duration: b,
							easing: "ease"
						}), c.$element.show().transition(d, function () {
							c.$element.removeClass("animating active"), c._$toggleButton.removeClass("active"), c.$element.hide()
						})
					}), a(".InPageSubNavigation").InPageSubNavigation("closeModels")
				}
			}), a(b).on("SubNavigation", function (a, b) {
				"opened" === b && c.$element.hasClass("active") && c.$element.trigger("close")
			}), a(b).on("SlideOutMenuOpened", function () {
				c.$element.hasClass("active") && c.$element.trigger("close")
			}), a(b).on("ShoppingToolsDropdown", function (a, b) {
				"opened" === b && c.$element.hasClass("active") && c.$element.trigger("close")
			}))
		},
		isOpen: function () {
			return this.$element.hasClass("active")
		},
		fastOpen: function () {
			this.$element.trigger("open", 200)
		},
		fastClose: function () {
			this._openOnRotate = !1, this.$element.trigger("close", 200)
		},
		openOnRotate: function () {
			var a = this;
			a._openOnRotate = !0, enquire.register("screen and (min-width: " + site.breakpoints.small + "px)", {
				setup: function () {
					a._openOnRotate === !0 && (a._openOnRotate = !1, a.isOpen() || a.fastOpen())
				},
				deferSetup: !0
			})
		},
		_resizeToButton: function () {
			var b = a(".SubNavigation .navigationModelSwitcherButtonContainer").width();
			this.$element.css({
				width: b
			})
		},
		_letterSplitter: function (b) {
			var c = b.text().split(""),
				d = "";
			c.length && (a(c).each(function (a, b) {
				d += '<span class="char' + (a + 1) + '">' + b + "</span>"
			}), b.empty().append(d))
		},
		_addKeyboardNavigation: function () {
			var b = this,
				c = a("a", b._$toggleButton),
				d = a("a", b.$element);
			c.keydown(function (a) {
				return 40 === a.keyCode ? (d.first().focus(), !1) : void 0
			}), d.keydown(function (b) {
				var e = d.first(),
					f = a(this);
				if (40 === b.keyCode) return f.parent("li").next("li").find("a").focus(), !1;
				if (38 === b.keyCode) {
					if (!f.is(e)) return f.parent("li").prev("li").find("a").focus(), !1;
					c.focus()
				} else if (9 === b.keyCode) return !1
			})
		},
		_removeKeyboardNavigation: function () {
			var b = this,
				c = a("a", b._$toggleButton),
				d = a("a", b.$element);
			c.off("keydown"), d.off("keydown")
		}
	};
	jQuery.createComponent("NavigationModelSwitcher", c)
}(jQuery, window, document), function (a, b, c) {
	var d = {
		_defaults: {},
		_id: "",
		_viewState: "",
		init: function () {
			var d = b.site.breakpoints.medium,
				e = this.$element;
			this._id = e.hasClass("generalNotification") ? "JLR_cookies" : "JLR_browser";
			var f = this;
			enquire.register("screen and (min-width: " + d + "px)", {
				match: function () {
					f._convertToDesktopView()
				},
				unmatch: function () {
					f._convertToMobileView()
				}
			}), c.addEventListener || (a(b).smartresize(function () {
				a(b).width() > d ? "desktop" !== f._viewState && f._convertToDesktopView() : "mobile" !== f._viewState && f._convertToMobileView()
			}), a(b).trigger("resize")), this._shouldShow() === !1 ? "JLR_cookies" === this._id && (site.cookiesAccepted = !0) : (a("a.close", e).on("click.notification tap", {
				that: this
			}, this._onCloseClicked), e.show())
		},
		_convertToMobileView: function () {
			var b = this.$element;
			a(".top", b).prepend(a(".notificationHeader", b)), a(".top", b).append(a("a.close", b)), a(".bottom", b).append(a(".top .inner .left p", b)), a(".bottom", b).append(a("a.primaryLinkWithStyle", b)), a(".top .inner", b).remove(), this._viewState = "mobile"
		},
		_convertToDesktopView: function () {
			var b = this.$element;
			a(".top", b).prepend('<div class="inner"><div class="left"></div><div class="right"></div></div>'), a(".inner .left", b).append(a(".notificationHeader", b)), a(".inner .left", b).append(a(".bottom p", b)), a(".inner .right", b).append(a("a.primaryLinkWithStyle", b)), a(".notificationContainer", b).append(a("a.close", b)), this._viewState = "desktop"
		},
		_shouldShow: function () {
			var a = !0,
				b = site.utils.cookieManager.readCookie(this._id);
			switch (this._id) {
			case "JLR_cookies":
				"true" !== b ? "undefined" != typeof Storage && "true" === sessionStorage[this._id] && (a = !1) : a = !1;
				break;
			case "JLR_browser":
				a = !1
			}
			return a
		},
		_onCloseClicked: function (c) {
			c.preventDefault();
			var d = c.data.that;
			d._accept(), d._dismiss(), setTimeout(function () {
				a(b).trigger("closeNotificationBar"), a(b).trigger("HeroCarouselForceResize"), a(b).trigger("resize")
			}, 200)
		},
		_accept: function () {
			var a = this.$element,
				b = a.data("expires");
			if ("JLR_cookies" === this._id) {
				switch (!0) {
				case -1 === b:
					site.utils.cookieManager.createCookie(this._id, "true", "1825");
					break;
				case 0 === b:
					"undefined" != typeof Storage && (sessionStorage[this._id] = "true");
					break;
				default:
					site.utils.cookieManager.createCookie(this._id, "true", b)
				}
				site.cookiesAccepted = !0
			}
		},
		_dismiss: function () {
			if (a(b).width() < site.breakpoints.medium) {
				var c = a(".SubNavigation").height() + a(".headerWrapper").height();
				a("body").transition({
					paddingTop: c
				}, 400, "ease")
			}
			var d = this.$element;
			d.height(d.outerHeight()).transition({
				height: 0,
				duration: 400,
				easing: "ease"
			});
			var e = this;
			b.setTimeout(function () {
				e._destroy()
			}, 500)
		},
		_destroy: function () {
			this.$element.remove(), a(b).trigger("resize")
		}
	};
	jQuery.createComponent("NotificationBar", d)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		init: function () {
			var c = this,
				d = a(this.options.nextButton, this.$element);
			d.on("click tap", function (a) {
				a.preventDefault(), c.loadMoreItems()
			}), a(this.options.container, this.$element).wrap("<div class='progressiveResultsInner'></div>"), this.setButton(), this.addItemClickEvent(), site.utils.scrollTo(a(b).scrollTop())
		},
		addItemClickEvent: function () {
			var c = this;
			a(this.options.resultItems, this.$element).find("a").on("click tap", function (d) {
				c._currentPage && b.history.pushState && (d.preventDefault(), history.pushState({}, "", c._currentPage + "&all=true"), b.location = a(this).attr("href"))
			})
		},
		loadMoreItems: function () {
			var c = this,
				d = a(this.options.nextButton, this.$element);
			this._currentPage = d.attr("href"), a("<div class='progressiveResultsInner'></div>").insertAfter(a(".progressiveResultsInner", this.$element).last());
			var e = this.$element.find(".progressiveResultsInner").last();
			e.hide().load(d.attr("href") + " " + this.options.container, function () {
				c.addItemClickEvent(e), b.picturefill();
				var a = e.find("img");
				a.length > 0 ? e.find("img").waitForImages(function () {
					c.animateItems()
				}) : c.animateItems(), site.utils.scrollTo(e), c.setButton()
			})
		},
		setButton: function () {
			var b = this,
				c = a(this.options.nextButton, this.$element),
				d = this.$element.find(".progressiveResultsInner").last(),
				e = d.find(b.options.container).attr("data-next-url");
			"" !== e && e ? c.attr("href", e) : c.fadeOut()
		},
		animateItems: function () {
			var b = this,
				c = this.$element.find(".progressiveResultsInner").last();
			c.show(), c.find(b.options.resultItems).each(function (b) {
				a(this).css({
					opacity: 0,
					y: 80
				}).transition({
					opacity: 1,
					y: 0,
					delay: 100 * b
				})
			})
		}
	};
	jQuery.createComponent("ProgressiveResults", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		_windowWidth: 0,
		_windowHeight: 0,
		_$window: a(b),
		_hasImage: !1,
		init: function () {
			var b = this;
			b.$element.hasClass("withImage") && (b._hasImage = !0), b._$window.smartresize(function () {
				b._resizeImage()
			}), b._resizeImage(), a(".QuotePlayer", b.$element).on("QuotePlayer_playing", function () {
				a(".imageOverlay", b.$element).addClass("darken")
			}), a(".QuotePlayer", b.$element).on("QuotePlayer_paused", function () {
				a(".imageOverlay", b.$element).removeClass("darken")
			}), a(".QuotePlayer", b.$element).on("QuotePlayer_finished", function () {
				a(".imageOverlay", b.$element).removeClass("darken")
			})
		},
		_resizeImage: function () {
			var c = this;
			if (this._hasImage === !0) {
				if (c._$window.width() === c._windowWidth) return !1;
				if (c._windowWidth = c._$window.width(), c._windowHeight = c._$window.height(), c._windowWidth >= site.breakpoints.medium) {
					var d = b.innerHeight ? b.innerHeight : c._windowHeight,
						e = a(".SubNavigation");
					1 === e.length ? d = d - 50 - a(".SubNavigation").height() : d -= 50, this.$element.css("height", d)
				} else this.$element.removeAttr("style")
			}
		}
	};
	jQuery.createComponent("Quote", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		_centred: !1,
		_slidOff: !0,
		_rtl: !1,
		_player: null,
		_width: 0,
		init_rtl: function () {
			this._rtl = !0
		},
		init: function () {
			var c = this;
			c._player = a("audio", this.$element).mediaelementplayer({
				startVolume: .8,
				features: ["playpause", "progress", "current", "duration"],
				audioWidth: "100%",
				audioHeight: 40,
				success: function (a) {
					a.addEventListener("play", function (a) {
						c._onPlay(a)
					}), a.addEventListener("pause", function (a) {
						c._onPause(a)
					}), a.addEventListener("ended", function (a) {
						c._onEnded(a)
					})
				}
			}), this.$element.hasClass("centre") && (this._centred = !0), a(b).smartresize(function () {
				a(b).width() !== c._width && (c._width = a(b).width(), a(".mejs-time-rail").width(0), c._player[0].player.setControlsSize(), c._slidOff === !0 && c._slideOff(0))
			}).trigger("resize"), setTimeout(function () {
				a(b).trigger("resize")
			}, 2e3)
		},
		_onPause: function () {
			this.$element.trigger("QuotePlayer_paused"), this.$element.removeClass("playing").addClass("paused")
		},
		_onPlay: function () {
			this.$element.trigger("QuotePlayer_playing"), this.$element.removeClass("paused finished").addClass("playing"), this._slidOff = !1, this._slideOn(400)
		},
		_onEnded: function () {
			this.$element.trigger("QuotePlayer_finished"), this.$element.removeClass("playing").addClass("finished"), this._slidOff = !0, this._slideOff(400)
		},
		_slideOff: function (b) {
			var c = 0 - (a(".mejs-time-rail", this.$element).width() + 10),
				d = 0 - a(".mejs-time-total", this.$element).width(),
				e = (a(".mejs-controls", this.$element).width() - (a(".mejs-button", this.$element).outerWidth() + a(".mejs-time", this.$element).outerWidth())) / 2;
			a(".mejs-time", this.$element).transition({
				x: c,
				duration: b
			}), a(".mejs-time-total", this.$element).transition({
				x: d,
				duration: b
			}), this._rtl === !0 && this._centred === !1 && (e = a(".mejs-controls", this.$element).width() - (a(".mejs-button", this.$element).outerWidth() + a(".mejs-time", this.$element).outerWidth())), (this._rtl === !0 || this._centred === !0) && a(".mejs-container", this.$element).transition({
				x: e,
				duration: b
			})
		},
		_slideOn: function (b) {
			a(".mejs-time, .mejs-time-total, .mejs-container", this.$element).transition({
				x: "0px",
				duration: b
			})
		}
	};
	jQuery.createComponent("QuotePlayer", c)
}(jQuery, window, document), function (a, b) {
	function c(b, c) {
		this.$element = a(b), this.options = a.extend({}, e, c), this._defaults = e, this._name = d, this.init(this)
	}
	var d = "ReadyToGoBar",
		e = {};
	c.prototype = {
		init: function () {
			this.resizeLinkHeight(), this.resizeText()
		},
		resizeLinkHeight: function () {
			var c = a("ul li a", this.$element);
			c.equalHeightColumns("refresh"), a(b).smartresize(function () {
				c.css("height", "auto"), c.equalHeightColumns("refresh")
			})
		},
		resizeText: function () {
			var c = a("h2", this.$element),
				d = a(b);
			d.smartresize(function () {
				c.removeAttr("style").equalHeights()
			}), c.removeAttr("style").equalHeights()
		}
	}, a.fn[d] = function (b) {
		return this.each(function () {
			a.data(this, "component_" + d) || a.data(this, "component_" + d, new c(this, b))
		})
	}
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		_screenWidth: 0,
		_currentState: "",
		init: function () {
			var c = this;
			this._setupClickEvent(), a(b).smartresize(function () {
				c._onResize()
			}), this._onResize()
		},
		_onResize: function () {
			var c = a(b).width();
			c !== this._screenWidth && (this._screenWidth = c, this._determineBreakpoint())
		},
		_determineBreakpoint: function () {
			var a = this._currentState;
			this._currentState = this._screenWidth <= site.breakpoints.small ? "mobile" : this._screenWidth <= site.breakpoints.medium ? "tablet" : "desktop", a !== this._currentState && this._switchLink()
		},
		_switchLink: function () {
			var a = this.$element.data("link-" + this._currentState);
			"undefined" == typeof a && (a = this.$element.data("link-desktop")), this.$element.attr("href", a);
			var b = this.$element.data("link-" + this._currentState + "-window");
			"undefined" != typeof b ? this.$element.attr("target", "_blank") : this.$element.attr("target", "_self"), this._setupClickEvent()
		},
		_setupClickEvent: function () {
			var a = this;
			this.$element.off("click tap");
			var b = this.$element.data("link-event-" + this._currentState);
			b === !0 && this.$element.on("click tap", function (b) {
				b.preventDefault(), a.$element.trigger("ResponsiveLinkClicked", {
					el: b.target,
					state: a._currentState
				})
			})
		}
	};
	jQuery.createComponent("ResponsiveLink", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		_divided: !1,
		_$container: null,
		_containerType: "article",
		_rtl: !1,
		init_rtl: function () {
			this._rtl = !0
		},
		init: function () {
			var c = this;
			this.$element.wrap('<div><div class="ResponsiveTable"></div></div>'), this._$container = this.$element.parents(".ResponsiveTable"), c.$element.hasClass("alternativeRussianLayout") || (c.$element.parents(".Article").length > 0 ? this._containerType = "article" : this.$element.parents(".EngineSpecifications, .VehicleSpecifications").length > 0 && (this._containerType = "spectable"), this._checkWidths(), c._matchRowHeights(), c._stickToRight(), c._responsiveArrow(), a(b).smartresize(function () {
				c._checkWidths(), c._matchRowHeights(), c._stickToRight(), c._responsiveArrow()
			}), setTimeout(function () {
				c._matchRowHeights()
			}, 100))
		},
		_checkWidths: function () {
			this._$container.removeAttr("style").removeClass("stickToRight"), this._divided === !0 && this._combine(), this.$element.outerWidth() > this._$container.outerWidth() ? this._divided === !1 && this._divide() : this._divided === !0 && this._combine()
		},
		_matchRowHeights: function () {
			if (this._divided === !0) {
				var b = a(".pinned table tr", this._$container),
					c = a(".scrollable table tr", this._$container);
				b.each(function (b, d) {
					var e = a(d),
						f = a(c.get(b)),
						g = Math.max(e.height(), f.height());
					e.add(f).height(g)
				})
			}
		},
		_divide: function () {
			this.$element.wrap("<div class='tableWrapper' />"), this._$container.before("<div class='responsiveTableArrow clearfix'><div class='leftArrow'></div><div class='bar'>&nbsp;</div><div class='rightArrow'></div></div>");
			var a = this.$element.clone();
			a.find("td:not(:first-child), th:not(:first-child)").css("display", "none"), this.$element.closest(".tableWrapper").append(a), a.wrap("<div class='pinned' />"), this.$element.wrap("<div class='scrollable' />"), this.$element.attr("tabindex", "0"), this._divided = !0
		},
		_combine: function () {
			this.$element.closest(".tableWrapper").find(".pinned").remove(), this.$element.unwrap().unwrap(), a(".responsiveTableArrow", this._$container.parent()).remove(), this._divided = !1, this.$element.attr("tabindex", "")
		},
		_stickToRight: function () {
			var c = this;
			if (c._divided === !0) {
				if (a(b).width() < site.breakpoints.medium) {
					var d = 0;
					if ("article" === c._containerType) {
						{
							var e = this.$element.parents(".sectionWrapper"),
								f = a(b).width() - (e.offset().left + e.width());
							parseInt(e.css("padding-right"), 10), parseInt(e.css("margin-right"), 10)
						}
						d = f + parseInt(e.width(), 10)
					} else if ("spectable" === c._containerType) {
						var g = c._$container.parents(".GridListWrapper").width();
						d = g
					}
					c._$container.hasClass("stickToRight") || c._$container.addClass("stickToRight"), c._$container.css({
						width: d
					})
				}
			} else c._$container.removeAttr("style").removeClass("stickToRight")
		},
		_responsiveArrow: function () {
			var c = this;
			if (c._divided === !0) {
				var d = a(".responsiveTableArrow", this._$container.parent());
				d.show();
				var e = 0,
					f = 0,
					g = 0,
					h = 0,
					i = 0,
					j = null;
				c._rtl === !0 ? ("article" === c._containerType ? a(b).width() <= site.breakpoints.medium ? (g = a(".pinned", c._$container).offset().left, h = g, i = 0 - c._$container.parent().offset().left) : (f = c._$container.parent().width() - a(".pinned", c._$container).width(), g = a(".scrollable", c._$container).offset().left - c.$element.parent().offset().left, h = f - g) : "spectable" === c._containerType && (j = c._$container.parents(".GridListWrapper"), h = j.width() - a(".pinned", c._$container).width()), e = h - 10, a(".bar", d).css({
					width: e
				}), d.css({
					left: i,
					"padding-left": 0
				})) : ("article" === c._containerType ? (f = a(b).width() <= site.breakpoints.medium ? a(b).width() - a(".scrollable", c._$container).offset().left : c._$container.parent().width() - a(".pinned", c._$container).width(), g = a(".scrollable", c._$container).offset().left - c.$element.parent().offset().left) : "spectable" === c._containerType && (j = c._$container.parents(".GridListWrapper"), f = j.outerWidth() - parseInt(j.css("padding-right"), 10), g = a(".scrollable", c._$container).offset().left - j.offset().left), h = f - g, e = h - 10, a(".bar", d).css({
					width: e
				}), d.css({
					left: a(".pinned", c._$container).width() - 5,
					"padding-left": 0
				}))
			}
		}
	};
	jQuery.createComponent("ResponsiveTable", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		_$slider: null,
		_html: null,
		_imgRatio: 210 / 360,
		_dragging: !1,
		_slidePosition: !1,
		_direction: "slideFromRight",
		init_rtl: function () {
			this._direction = "slideFromLeft"
		},
		init: function () {
			var c = this;
			this._html = a(".carouselWrapper", this.$element).html(), a(b).smartresize(function () {
				c._resize()
			}), a(b).resize(), this._initEnquire()
		},
		_resetCarousel: function () {
			this._$slider = null, a(".carouselWrapper", this.$element).empty().html(this._html), this._removeControls()
		},
		_createCarousel: function (c) {
			var d = this;
			d._resetCarousel(), a(".carouselImageLink", this.$element).each(function () {
				var b = a(this);
				"video" === b.attr("data-type") && a(this).append('<div class="playButton"></div>')
			});
			var e = a(".carouselWrapper li", this.$element);
			if (e.length > c) {
				var f, g = 0;
				if ("slideFromRight" === d._direction) for (g = e.length, f = 0; f < e.length; f += c) a(".mediaCarousel > li:lt(" + c + ")", this.$element).wrapAll("<div class='slide'></div>");
				else {
					for (g = e.length - 1, f = g; f >= -3; f -= c) 0 > f ? a(".mediaCarousel > li", this.$element).wrapAll("<div class='slide'></div>") : a(".mediaCarousel > li:gt(" + f + ")", this.$element).wrapAll("<div class='slide'></div>");
					var h = a(".slide", this.$element).first();
					1 === a("li", h).length ? a("li", h).first().addClass("padLeft66Percent") : 2 === a("li", h).length && a("li", h).first().addClass("padLeft33Percent")
				}
				var i = 0;
				"slideFromLeft" === d._direction && (i = a(".slide", d.$element).length);
				var j = a(".carouselWrapper ul", this.$element).royalSlider({
					arrowsNav: !1,
					loop: !0,
					keyboardNavEnabled: !1,
					controlNavigation: !1,
					controlsInside: !1,
					imageScaleMode: "none",
					arrowsNavAutoHide: !1,
					autoHeight: !0,
					autoScaleSlider: !1,
					autoScaleSliderWidth: 0,
					autoScaleSliderHeight: 0,
					slidesSpacing: 1,
					imgWidth: "100%",
					imgHeight: "100%",
					sliderDrag: !0,
					thumbsFitInViewport: !1,
					navigateByClick: !1,
					startSlideId: i,
					autoPlay: {
						enabled: !1
					},
					transitionType: "move",
					numImagesToPreload: 1
				});
				setTimeout(function () {
					b.picturefill()
				}, 50), setTimeout(function () {
					b.picturefill()
				}, 500), d._$slider = j.data("royalSlider"), d._$slider.ev.on("rsBeforeAnimStart", {
					that: this
				}, this._updatePagination), d._$slider.ev.on("rsAfterSlideChange", {
					that: this
				}, this._slideChange), d._$slider.ev.on("rsDragStart", {
					that: this
				}, this._startDrag), d._$slider.ev.on("rsDragRelease", {
					that: this
				}, this._releaseDrag), setTimeout(function () {
					a(d._$slider.currSlide.holder).find("img").waitForImages(function () {
						d._resize()
					})
				}, 200), d._updatePagination(), d._addKeyboardNavigation(), d._initControls()
			} else if ("slideFromLeft" === d._direction) {
				var k = a(".mediaCarousel > li", this.$element).first();
				1 === a(".mediaCarousel > li", this.$element).length ? k.addClass("padLeft66Percent") : 2 === a(".mediaCarousel > li", this.$element).length && k.addClass("padLeft33Percent")
			}
			d._resize()
		},
		_slideChange: function (c) {
			var d = c ? c.data.that : this;
			d._resize(c), b.picturefill(), a(b).trigger("resize"), a(".TargetLinks").TargetLinks("setupListener"), a(".ResponsiveLink").ResponsiveLink()
		},
		_startDrag: function (b) {
			var c = b ? b.data.that : this;
			c._slidePosition = c._getSlidePosition(a(".rsContainer", c.$element))
		},
		_releaseDrag: function (b) {
			var c = b ? b.data.that : this,
				d = c._slidePosition,
				e = c._getSlidePosition(a(".rsContainer", c.$element));
			c._dragging = d === e ? !1 : !0
		},
		_getSlidePosition: function (a) {
			var b;
			return b = jQuery.support.transition ? this._getXPositionFromMatrix(a.css("transform")) : a.position().left
		},
		_getXPositionFromMatrix: function (a) {
			var b = a.toString().split(", ");
			return Number(b[4])
		},
		getDragging: function () {
			return this._dragging
		},
		_initEnquire: function () {
			var a = this;
			enquire.register("screen and (min-width: " + b.site.breakpoints.medium + "px)", {
				match: function () {
					a._createCarousel(3)
				}
			}), enquire.register("screen and (min-width: " + (b.site.breakpoints.small + 1) + "px) and (max-width: " + (b.site.breakpoints.medium - 1) + "px)", {
				match: function () {
					a._createCarousel(2)
				}
			}), enquire.register("screen and (max-width: " + b.site.breakpoints.small + "px)", {
				match: function () {
					a._createCarousel(1)
				}
			})
		},
		_resize: function (b) {
			var c = b ? b.data.that : this,
				d = a(".carouselWrapper li", this.$element);
			d.removeAttr("style"), d.find("h3").equalHeights(), d.find(" > span, > a").height(d.width() * c._imgRatio), d.equalHeights(), null !== c._$slider && c._$slider.updateSliderSize(!0), a(".rsOverflow", c.$element).width(a(".mediaCarousel", c.$element).width()), null !== c._$slider && setTimeout(function () {
				c._$slider.updateSliderSize(!0)
			}, 10)
		},
		_initControls: function () {
			var b = a(".carouselNavigation", this.element);
			b.css({
				display: "table"
			}), b.show(), a(".carouselNavigation > div a.prev", this.$element).on("click tap", {
				that: this
			}, this._onPrev), a(".carouselNavigation > div a.next", this.$element).on("click tap", {
				that: this
			}, this._onNext), this._updatePagination()
		},
		_removeControls: function () {
			a(".carouselNavigation", this.element).hide()
		},
		_onPrev: function (a) {
			a.preventDefault();
			var b = a.data.that;
			b._$slider.prev(), b._updateSlideLinks()
		},
		_onNext: function (a) {
			a.preventDefault();
			var b = a.data.that;
			b._$slider.next(), b._updateSlideLinks()
		},
		_updatePagination: function (b) {
			var c = b ? b.data.that : this,
				d = c._$slider,
				e = d.currSlideId + 1;
			"slideFromLeft" === c._direction && (e = d.numSlides - e + 1), a(".numbers", c.$element).html(e + "<span>/</span>" + d.numSlides)
		},
		_destroy: function () {},
		_addKeyboardNavigation: function () {
			var b = this,
				c = b._$slider,
				d = a(".carouselWrapper .mediaCarousel", b.$element),
				e = a(".carouselNavigation", b.$element);
			d.attr("tabindex", "0"), d.keydown(function (a) {
				39 === a.keyCode ? (c.next(), d.focus(), b._updateSlideLinks()) : 37 === a.keyCode && (c.prev(), d.focus(), b._updateSlideLinks())
			}), e.find("a").keydown(function (b) {
				39 === b.keyCode ? a(this).nextAll("a").first().focus() : 37 === b.keyCode && a(this).prevAll("a").first().focus()
			}), b._updateSlideLinks()
		},
		_updateSlideLinks: function () {
			var b = this,
				c = b._$slider,
				d = (a(".carouselWrapper .mediaCarousel", b.$element), a(".rsSlide > .slide", b.$element)),
				e = c.currSlide.content;
			a("a", d).attr("tabindex", "-1"), a("a", e).attr("tabindex", "")
		}
	};
	jQuery.createComponent("SameSizeCarousel", c)
}(jQuery, window, document), jQuery.support.transition = function () {
	var a = document.body || document.documentElement,
		b = a.style,
		c = void 0 !== b.transition || void 0 !== b.WebkitTransition || void 0 !== b.MozTransition || void 0 !== b.MsTransition || void 0 !== b.OTransition;
	return c
}(), function () {
	var a = {
		init: function () {
			var a = this;
			this.$element.on("click", function (b) {
				//b.preventDefault(), site.utils.scrollTo(a.$element.offset().top + a.$element.height() + 1);
				b.preventDefault(), site.utils.scrollTo(a.$element.offset().top - a.$element.height() - 1);
			})
		}
	};
	jQuery.createComponent("ScrollDown", a)
}(jQuery, window, document), function (a) {
	var b = {
		_defaults: {},
		init: function () {
			a(".searchPageAutoComplete").AutoComplete({
				dataURL: a(".SearchButton input").attr("auto-complete-url"),
				youSearchedTitle: a(".SearchButton input").attr("search-text"),
				keyMatchTitle: a(".SearchButton input").attr("promoted-title")
			}), a(".searchList", this.$element).ProgressiveResults({
				container: ".results",
				resultItems: "li",
				nextButton: ".loadMore"
			}), a(".searchHeader form").on("submit", function () {
				var b = a(this).find("input.textfield");
				return b.val(site.utils.removeHTMLTags(b.val())), !0
			})
		},
		_destroy: function () {}
	};
	jQuery.createComponent("SearchResults", b)
}(jQuery, window, document), function (a, b) {
	function c(b, c) {
		this.$element = a(b), this.options = a.extend({}, e, c), this._defaults = e, this._name = d, this._$desktopMenuButton = a(this.options.desktopMenuButton, this.$element), this._$deviceMenuButton = a(this.options.deviceMenuButton), this._$desktopMenu = a(this.options.desktopMenu, this.$element), this._defaultWidthOfMenu = 0, this._height = 0, this._dropdownTimer = null, this.init(this)
	}
	var d = "ShoppingToolsDropdown",
		e = {
			desktopMenuButton: ".ShoppingToolsButton > a",
			desktopMenu: ".ShoppingToolsDropdown"
		};
	c.prototype = {
		init: function () {
			var c = this;
			c._defaultWidthOfMenu = a(".links", c._$deviceMenu).outerWidth(), c._height = c._$desktopMenu.height(), c._$desktopMenu.css({
				height: 0,
				display: "none",
				overflow: "hidden"
			}), c._$desktopMenu.Dropdown({
				timeout: 250,
				button: c._$desktopMenuButton,
				buttonWithinMenu: !1,
				onOpen: function () {
					c._addKeyboardNavigation(), c._$desktopMenuButton.parent().addClass("active"), c._timerAutoClose(), c._$desktopMenu.addClass("animating").show().transition({
						duration: 400,
						easing: "ease",
						height: c._height
					}, function () {
						c._$desktopMenu.css({
							height: "auto"
						}), c._$desktopMenu.removeClass("animating")
					}), a(b).trigger("ShoppingToolsDropdown", ["opened"])
				},
				onClose: function () {
					clearTimeout(c._dropdownTimer), c.$element.off("mouseleave blur").off("mouseenter focus"), c._removeKeyboardNavigation(), c._$desktopMenu.addClass("animating"), c._height = c._$desktopMenu.height(), c._$desktopMenu.css({
						height: c._height
					}).show().transition({
						duration: 400,
						easing: "ease",
						height: 0
					}, function () {
						c._$desktopMenuButton.parent().removeClass("active"), c._$desktopMenu.removeClass("animating"), c._$desktopMenu.hide()
					})
				}
			}), a(b).on("NavigationModelSwitcher", function (a, b) {
				"opened" === b && c._$desktopMenuButton.parent().hasClass("active") && c._$desktopMenu.trigger("close")
			})
		},
		_addKeyboardNavigation: function () {
			var b = this,
				c = b._$desktopMenuButton,
				d = b._$desktopMenu.find("a");
			c.keydown(function (a) {
				return 40 === a.keyCode ? (d.first().focus(), !1) : void 0
			}), d.keydown(function (b) {
				var e = d.first(),
					f = a(this);
				if (40 === b.keyCode) return f.parent("li").next("li").find("a").focus(), !1;
				if (38 === b.keyCode) f.is(e) ? c.focus() : f.parent("li").prev("li").find("a").focus();
				else if (9 === b.keyCode) return !1
			})
		},
		_removeKeyboardNavigation: function () {
			var a = this;
			a._$desktopMenu.off("keydown"), a._$desktopMenuButton.off("keydown")
		},
		_timerAutoClose: function () {
			var b = this;
			a("html").hasClass("touchCapability") ? b._dropdownTimer = setTimeout(function () {
				b._$desktopMenu.trigger("close")
			}, 1e4) : this.$element.off("mouseleave blur").on("mouseleave blur", function () {
				b._dropdownTimer = setTimeout(function () {
					b._$desktopMenu.trigger("close")
				}, 5500)
			}).off("mouseenter focus").on("mouseenter focus", function () {
				clearTimeout(b._dropdownTimer)
			})
		}
	}, a.fn[d] = function (b) {
		return this.each(function () {
			a.data(this, "component_" + d) || a.data(this, "component_" + d, new c(this, b))
		})
	}
}(jQuery, window, document), function (a) {
	"use strict";

	function b() {
		this._componentName = c, this.init()
	}
	var c = "SidebarImage";
	b.prototype = {
		init: function () {}
	}, a.fn[c] = function (d) {
		var e = arguments,
			f = "component_" + c;
		return this.each(function () {
			var c = a.data(this, f);
			c && "string" == typeof d && "_" !== d.charAt(0) && c[d] && "function" == typeof c[d] ? c[d].apply(c, Array.prototype.slice.call(e, 1)) : c || "object" != typeof d && d || a.data(this, f, new b(this, d))
		})
	}
}(jQuery, window), function (a, b) {
	var c = {
		_defaults: {
			deviceMenuButton: ".MainNavigation .MoreButton > a, .SlideOutMenu .MoreButton > a"
		},
		_toggled: !1,
		_defaultWidthOfMenu: 0,
		_fromDirection: "left",
		_ulHeights: [],
		init_rtl: function () {
			this._fromDirection = "right"
		},
		init: function () {
			var c = this;
			c._$deviceMenuButton = a(this.options.deviceMenuButton), c._defaultWidthOfMenu = a(".links", c.$element).outerWidth(), a(c.$element).on("swipeMovement", function (b, d) {
				("right" === d && "left" === c.fromDirection || "left" === d && "right" === c.fromDirection) && a(".MainNavigation .MoreButton a").trigger("click")
			}), a(".links", c.$element).Dropdown({
				timeout: 250,
				button: c._$deviceMenuButton,
				buttonWithinMenu: !1,
				onOpen: function () {
					c._toggled = !0, a("html").addClass("noScroll"), a("body").addClass("hasSidebar").append('<div id="sidebarOverlay" class="overlay transparent">&nbsp;</div>'), a("#sidebarOverlay").transition({
						opacity: .6
					}), c._positionMenu(c), a(".MoreButton a").addClass("active"), a(".MoreButton", c.$element).on("click tap", function (a) {
						a.preventDefault()
					}), a(b).trigger("SlideOutMenuOpened"), a(b).trigger("overlayOpened"), a(b).smartresize(function () {
						c._toggled === !0 && c._positionMenu(c)
					})
				},
				onClose: function () {
					a("html").removeClass("noScroll"), a(".links", c.$element).addClass("animating"), a(".MoreButton", c.$element).off("click tap"), a("#sidebarOverlay").transition({
						opacity: 0,
						duration: 400,
						easing: "ease"
					}), a("#logo").transition({
						x: 0,
						duration: 400,
						easing: "ease"
					}), a(".MainNavigation").transition({
						x: 0,
						duration: 400,
						easing: "ease"
					}), a(".SubNavigation").transition({
						x: 0,
						duration: 400,
						easing: "ease"
					}), a(".NavigationModelSwitcher").transition({
						x: 0,
						duration: 400,
						easing: "ease"
					}), a(".notificationBars").transition({
						x: 0,
						duration: 400,
						easing: "ease"
					}), a("#content").transition({
						x: 0,
						duration: 400,
						easing: "ease"
					}, function () {
						this.removeAttr("style")
					}), a("#vehicleSelectorOverlay").transition({
						x: 0,
						duration: 400,
						easing: "ease"
					}), c.$element.transition({
						x: 0,
						duration: 400,
						easing: "ease"
					}, function () {
						c.$element.css("display", "none"), a("#sidebarOverlay").remove(), a("body").removeClass("hasSidebar"), a(".MoreButton a").removeClass("active"), c._toggled = !1, a(".links", c.$element).removeClass("animating")
					}), a(".FooterNav").transition({
						x: 0,
						duration: 400,
						easing: "ease"
					}), a(b).trigger("SlideOutMenuClosed"), a(b).trigger("overlayClosed")
				}
			}), enquire.register("screen and (min-width: 900px)", {
				match: function () {
					c._toggled === !0 && a(".MainNavigation .MoreButton a").trigger("click")
				}
			}), a(".searchSideAutoComplete").AutoComplete({
				wrapper: !1,
				dataURL: a(".SearchButton input").attr("auto-complete-url"),
				youSearchedTitle: a(".SearchButton input").attr("search-text"),
				keyMatchTitle: a(".SearchButton input").attr("promoted-title")
			}), c._accordionMenu(c), c._deviceSearch(c)
		},
		_positionMenu: function (c) {
			if (c._toggled === !0 && !a(".links", c.$element).hasClass("animating")) {
				a(".links", c.$element).addClass("animating");
				var d = a(b).width(),
					e = c._defaultWidthOfMenu;
				751 > d ? (e = d - 50, a(".links", c.$element).css("width", e), a(".navigation, .cover", c.$element).css("width", e)) : (a(".links", c.$element).css("width", c._defaultWidthOfMenu), a(".navigation, .cover", c.$element).css("width", c._defaultWidthOfMenu)), c.$element.css("left" === c._fromDirection ? {
					right: 0 - e,
					display: "block"
				} : {
					right: "auto",
					left: 0 - e,
					display: "block"
				});
				var f = -1 !== navigator.userAgent.indexOf("Lumia 920") ? 0 : 400,
					g = 0 - e;
				"right" === c._fromDirection && (g = e), c.$element.transition({
					duration: f,
					easing: "ease",
					x: g
				}), a("#logo").transition({
					duration: f,
					easing: "ease",
					x: g
				}), a(".MainNavigation").transition({
					duration: f,
					easing: "ease",
					x: g
				}), a(".SubNavigation").transition({
					duration: f,
					easing: "ease",
					x: g
				}), a(".NavigationModelSwitcher").transition({
					duration: f,
					easing: "ease",
					x: g
				}), a(".notificationBars").transition({
					duration: f,
					easing: "ease",
					x: g
				}), a("#vehicleSelectorOverlay").transition({
					duration: f,
					easing: "ease",
					x: g
				}), a("#content").transition({
					duration: f,
					easing: "ease",
					x: g
				}, function () {
					a(".links", c.$element).removeClass("animating")
				}), a(".FooterNav").transition({
					duration: f,
					easing: "ease",
					x: g
				})
			}
		},
		_accordionMenu: function (b) {
			b._ulHeights = [];
			var c = a("ul.first > li > ul", b.$element);
			if (jQuery.each(c, function (c, d) {
				b._ulHeights[c] = a(d).outerHeight()
			}), a("ul.first > li > ul").css({
				height: 0,
				"overflow-y": "hidden",
				"max-height": "9999px"
			}), a("ul.first > li > a", b.$element).on("click tap", function (c) {
				c.preventDefault();
				var d = a(this).parent(),
					e = d.index(),
					f = null;
				if (d.hasClass("active")) d.removeClass("active"), a("ul.first > li > a > .icon-plus", b.$element).show(), a("ul.first > li > a > .icon-minus", b.$element).hide(), f = d.index(), a("ul", d).css({
					height: b._ulHeights[f]
				}).transition({
					duration: 400,
					height: 0,
					easing: "ease"
				}).removeClass("open-content");
				else {
					f = a("ul.first > li.active", b.$element).index(), a("ul.first > li.active ul", b.$element).css({
						height: b._ulHeights[f]
					}).removeClass("open-content").transition({
						duration: 400,
						height: 0,
						easing: "ease"
					}), a("ul.first > li", b.$element).removeClass("active"), d.addClass("active"), a("ul.first > li > a > .icon-minus", b.$element).hide(), a("ul.first > li > a > .icon-plus", b.$element).show(), a(".icon-minus", this).show(), a(".icon-plus", this).hide(); {
						a("ul", d).clone().css({
							position: "absolute",
							visibility: "hidden",
							height: "auto",
							width: a(".links", b.$element).width()
						}).addClass("slideClone").appendTo(d)
					}
					b._ulHeights[e] = a(".slideClone").height(), a(".slideClone").remove(), a("ul", d).addClass("open-content").transition({
						duration: 400,
						height: b._ulHeights[e],
						easing: "ease"
					}, function () {
						a("ul", d).css({
							height: "auto"
						}), b._ulHeights[e] = a("ul", d).height()
					})
				}
			}), a("ul.first > li.open > a", b.$element).trigger("click"), 0 !== a("ul.first > li.active", b.$element).length) {
				var d = a("ul.first > li.active");
				a("ul.first > li > a > .icon-minus", b.$element).hide(), a("ul.first > li > a > .icon-plus", b.$element).show(), a(".icon-minus", d).show(), a(".icon-plus", d).hide(), a("> ul", d).css({
					height: "auto",
					"overflow-y": "hidden",
					"max-height": "9999px"
				}).addClass("open-content")
			}
		},
		_deviceSearch: function (b) {
			a(".search input", b.$element).on("focus", function () {
				var c = a(this).parent();
				c.transition({
					marginRight: "70px",
					easing: "ease"
				}, 200, function () {
					a(".search .btn", b.$element).show().transition({
						opacity: 1,
						easing: "ease"
					}, 200), a(".cover", b.$element).transition({
						height: a(".navigation", b.$element).height(),
						easing: "ease"
					}, 200)
				})
			}), a(".search input", b.$element).on("blur", function () {
				var c = a(this).parent();
				a(this).val(""), a(".search .btn", b.$element).transition({
					opacity: 0,
					easing: "ease"
				}, 200, function () {
					this.hide(), c.transition({
						marginRight: "0px",
						easing: "ease"
					}, 200), a(".cover", b.$element).transition({
						height: 0,
						easing: "ease"
					}, 200)
				})
			}), a("#SlideOutForm", b.$element).on("submit", function () {
				var b = a(this).find("input");
				return b.val(site.utils.removeHTMLTags(b.val())), !0
			})
		}
	};
	jQuery.createComponent("SlideOutMenu", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		uiSelectors: {},
		_html: null,
		_slider: null,
		_autoPlayTimeout: 1e4,
		_interactionTimeout: 3e4,
		_timeOutInterval: null,
		_direction: "slideFromRight",
		init_rtl: function () {
			this._direction = "slideFromLeft"
		},
		init: function () {
			var c = this;
			c._html = a(".gridHolder", c.$element).html(), a(b).smartresize(function () {
				c._onResize()
			}), c._initEnquire(), c._truncateContent()
		},
		_initEnquire: function () {
			var c = this,
				d = 1300;
			enquire.register("screen and (min-width: " + d + "px)", {
				match: function () {
					c._createCarousel(3)
				}
			}), enquire.register("screen and (min-width: " + (b.site.breakpoints.small + 1) + "px) and (max-width: " + (d - 1) + "px)", {
				match: function () {
					c._createCarousel(2)
				}
			}), enquire.register("screen and (max-width: " + b.site.breakpoints.small + "px)", {
				match: function () {
					c._createCarousel(1)
				}
			}), a("html").hasClass("lt-ie9") && c._createCarousel(3)
		},
		_resetCarousel: function () {
			this._$slider && this._$slider.destroy(), this._$slider = null, this._removeControls(), a(".gridHolder", this.$element).empty().html(this._html), this.$element.removeAttr("data-total")
		},
		_createCarousel: function (b) {
			var c = this;
			this._resetCarousel();
			var d = a(".grid", this.$element),
				e = a(".grid .gridItem", this.$element).length,
				f = a(".carouselNavigation", this.$element);
			if (b >= e) return void f.hide();
			for (var g = 0; e > g; g += b) {
				var h = g / b + 1;
				a(".grid > .gridItem:lt(" + b + ")", this.$element).wrapAll("<div class='slide' data-slideid='" + h + "'></div>")
			}
			var i = Math.ceil(e / b);
			this.$element.attr("data-total", i);
			var j = 0;
			"slideFromLeft" === this._direction && (j = a(".gridItem", this.$element).length - 1), d.royalSlider({
				arrowsNav: !1,
				loop: !0,
				keyboardNavEnabled: !1,
				controlsInside: !1,
				imageScaleMode: "none",
				arrowsNavAutoHide: !1,
				autoHeight: !1,
				autoScaleSlider: !0,
				autoScaleSliderWidth: 0,
				autoScaleSliderHeight: 0,
				slidesSpacing: 0,
				imgWidth: "100%",
				imgHeight: "100%",
				sliderDrag: !0,
				controlNavigation: "none",
				thumbsFitInViewport: !1,
				navigateByClick: !1,
				startSlideId: j,
				autoPlay: {
					enabled: !1,
					pauseOnHover: !1,
					stopAtAction: !1,
					delay: this._autoPlayTimeout
				},
				transitionType: "move",
				numImagesToPreload: 1
			}), this._slider = d.data("royalSlider"), this._updatePagination(), c._updateCurrentSlide(), this._slider.ev.on("rsBeforeAnimStart", {
				that: this
			}, this._onSlideChange), this._slider.ev.on("rsDragStart", {
				that: this
			}, this._onStartDrag), this._slider.ev.on("rsAfterSlideChange", function (a) {
				a.preventDefault(), c._updateCurrentSlide()
			}), this._initAutoPlay(!1), this._initCaroucelControls(), this._truncateContent(), this._addKeyboardNavigation()
		},
		_onStartDrag: function (a) {
			var b = a ? a.data.that : this;
			b._initAutoPlay(!0)
		},
		_initAutoPlay: function (a) {
			var c = this,
				d = a ? c._interactionTimeout : c._autoPlayTimeout;
			c._timeOutInterval && b.clearInterval(c._timeOutInterval), c._timeOutInterval = b.setInterval(function () {
				c._moveCarousel("slideFromLeft" === c._direction ? {
					that: c,
					direction: "prev"
				} : {
					that: c,
					direction: "next"
				})
			}, d)
		},
		_removeControls: function () {
			var b = a(".carouselNavigation", this.$element);
			b.find("a.prev").off("click tap", this._onNavigationClick), b.find("a.next").off("click tap", this._onNavigationClick)
		},
		_initCaroucelControls: function () {
			var b = a(".carouselNavigation", this.$element);
			b.show(), b.find("a.prev").on("click tap", {
				that: this,
				direction: "prev"
			}, this._onNavigationClick), b.find("a.next").on("click tap", {
				that: this,
				direction: "next"
			}, this._onNavigationClick)
		},
		_onNavigationClick: function (a) {
			a.preventDefault();
			var b = a.data.that;
			b._initAutoPlay(!0), b._moveCarousel(a.data)
		},
		_moveCarousel: function (a) {
			var b = this,
				c = a.direction;
			b._slider[c](), b._updateSlideLinks()
		},
		_onSlideChange: function (a) {
			var b = a.data.that;
			b._updatePagination(), b._truncateContent()
		},
		_updateCurrentSlide: function () {
			var b = this;
			a(".rsSlide", b.$element).removeClass("current"), a(b._slider.currSlide.holder).addClass("current")
		},
		_updatePagination: function () {
			var b = this,
				c = b._slider.currSlideId + 1;
			"slideFromLeft" === b._direction && (c = b._slider.numSlides - c + 1), a(".carouselNavigation", b.$element).find(".numbers").html(c + "<span>/</span>" + b._slider.numSlides)
		},
		_onResize: function () {
			var a = this;
			a._truncateContent()
		},
		_truncateContent: function () {
			var b = a(".messageContent", this.$element);
			b.trigger("destroy"), b.dotdotdot()
		},
		_addKeyboardNavigation: function () {
			var b = this,
				c = b._slider,
				d = a(".grid", b.$element),
				e = a(".carouselNavigation", b.$element);
			d.attr("tabindex", "0"), d.keydown(function (a) {
				39 === a.keyCode ? (c.next(), d.focus(), b._updateSlideLinks()) : 37 === a.keyCode && (c.prev(), d.focus(), b._updateSlideLinks())
			}), e.find("a").keydown(function (b) {
				39 === b.keyCode ? a(this).nextAll("a").first().focus() : 37 === b.keyCode ? a(this).prevAll("a").first().focus() : 13 === b.keyCode && (b.preventDefault(), a(this).trigger("click"))
			}), b._updateSlideLinks()
		},
		_updateSlideLinks: function () {
			var b = this,
				c = (b._slider, a(".carouselWrapper .mediaCarousel", b.$element), a(".rsSlide > .slide", b.$element)),
				d = b._slider.currSlide.content;
			a("a", c).attr("tabindex", "-1"), a("a", d).attr("tabindex", "")
		}
	};
	jQuery.createComponent("SocialFeed", c)
}(jQuery, window, document), function (a, b, c) {
	var d = {
		_defaults: {
			orientation: "vertical",
			animateFrom: "top",
			visibleWhenClosed: !1,
			hasMenu: !0,
			openedOnce: !1
		},
		_windowWidth: a(b).width(),
		_bitly_networks: "twitter,gmail,email,linkedin,google_plusone,facebook,google_plusone_share,_facebook_like,tumblr",
		_timer: null,
		open: !1,
		init: function () {
			var d = this;
			this.$element.addClass("orientation_" + this.options.orientation), this.options.visibleWhenClosed === !0 && this.$element.show();
			var e = [];
			a.each(a("> a", this.$element), function () {
				"undefined" != typeof a(this).attr("data-name") && e.push({
					name: a(this).attr("data-name"),
					url: a(this).attr("data-url"),
					icon: a(this).attr("data-icon")
				})
			}), b.addthis_config = {
				ui_use_css: !1,
				ui_click: !1,
				services_custom: e
			}, b.addthis_share = {
				url_transforms: {
					shorten: {}
				},
				shorteners: {
					bitly: {}
				}
			};
			var f = this._bitly_networks.split(",");
			for (var g in f) b.addthis_share.url_transforms.shorten[f[g]] = "bitly";
			if ("undefined" != typeof this.$element.data("url")) b.addthis_share.url = this.$element.data("url");
			else {
				var h = c.URL;
				h += h.indexOf("?") <= -1 ? "?shared=true" : "&shared=true", b.addthis_share.url = h
			}
			this.options.hasMenu === !0 && (this._initMenu(), a("> a", this.$element).on("click tap", {
				that: this
			}, function (a) {
				a.stopPropagation(), a.preventDefault(), d._onItemClick()
			}), a("> a", d.$element.parent()).on("click tap", function (a) {
				a.stopPropagation(), a.preventDefault(), d._toggleMenu()
			}).css("visibility", "visible")), a("> a", this.$element).on("click tap", {
				that: this
			}, function () {
				setTimeout(function () {
					a(b).focus()
				}, 500)
			}), d._loadAddThis(), a(b).on("FilmstripToggle", function (b, c) {
				c && d.open && a("> a", d.$element.parent()).trigger("click")
			}), a(b).on("slideClicked", function () {
				d.open && a("> a", d.$element.parent()).trigger("click")
			}), a(b).smartresize(function () {
				var c = a(b).width();
				d._windowWidth !== c && (d._initMenu(), d.$element.parent().removeClass("open"), d.open = !1, d._windowWidth = c)
			}), d._addKeyboardNavigation()
		},
		_initMenu: function () {
			"vertical" === this.options.orientation && this.$element.css("top", -this.$element.height() - 200)
		},
		_loadAddThis: function () {
			if ("undefined" == typeof b.addthis) {
				for (var d = c.querySelectorAll("addthis_button_compact"), e = function (a) {
					a.stopImmediatePropagation && a.stopImmediatePropagation(), a.stopPropagation && a.stopPropagation(), null !== a.cancelBubble && (a.cancelBubble = !0)
				}, f = d.length, g = 0; f > g; g++) d[g].addEventListener("mouseover", e, !1), d[g].addEventListener("focus", e, !1);
				var h = /(iPad|iPhone|iPod)/g.test(navigator.userAgent);
				h && a(".addthis_button_compact", this.$element).hide(), a.getScript("//s7.addthis.com/js/250/addthis_widget.js", function (a, c) {
					"success" === c && b.addthis && b.addthis.toolbox(".addthis_toolbox")
				})
			}
		},
		_toggleMenu: function () {
			this.$element.css("visibility", "visible"), this.$element.parent().hasClass("open") ? (this.closeMenu(), this.open = !1) : (this._openMenu(), this.open = !0), a(b).trigger("AddThisToggle", [this.open])
		},
		_openMenu: function () {
			var b = this;
			if (b.$element.parent().addClass("open").trigger("openSocialSharing"), a("html").hasClass("lt-ie9") && b.options.openedOnce === !1) {
				var d = c.getElementsByTagName("head")[0],
					e = c.createElement("style");
				e.type = "text/css", e.styleSheet.cssText = ":before,:after{content:none !important", d.appendChild(e), setTimeout(function () {
					d.removeChild(e)
				}, 0)
			}
			b.$element.css({
				top: b.$element.parent().find("> a").height()
			}), b.options.openedOnce = !0
		},
		_onItemClick: function (a) {
			var b = a ? a.data.that : this;
			b._toggleMenu()
		},
		closeMenu: function () {
			var a = this;
			a.$element.parent().removeClass("open").trigger("closeSocialSharing"), a.$element.css({
				top: -this.$element.height()
			})
		},
		_addKeyboardNavigation: function () {
			var b = this,
				c = null;
			c = b.options.hasMenu ? a("> a", b.$element.parent()) : a("> a", b.$element.parent().parent());
			var d = (c.parent(), a("> a", this.$element));
			c.keydown(function (a) {
				var c = b.options.orientation,
					e = b.options.animateFrom,
					f = b.$element.parent().hasClass("open");
				if ("vertical" === c) {
					if ("top" === e && 40 === a.keyCode) return f === !0 ? d.first().focus() : b._openMenu(), !1;
					if ("bottom" === e && 38 === a.keyCode) return f === !0 ? d.last().focus() : b._openMenu(), !1
				} else {
					if ("left" === e && 39 === a.keyCode) return d.first().focus(), !1;
					if ("right" === e && 37 === a.keyCode) return d.last().focus(), !1
				}
			}), d.keydown(function (d) {
				var e = b.options.orientation,
					f = b.options.animateFrom,
					g = null,
					h = null;
				if ("vertical" === e) {
					if (40 === d.keyCode) return g = a(this).next("a"), g.length > 0 ? g.focus() : "bottom" === f && c.focus(), !1;
					if (38 === d.keyCode) return h = a(this).prev("a"), h.length > 0 ? h.focus() : "top" === f && c.focus(), !1
				} else {
					if (39 === d.keyCode) return g = a(this).next("a"), g.length > 0 ? g.focus() : "right" === f && c.focus(), !1;
					if (37 === d.keyCode) return h = a(this).prev("a"), h.length > 0 ? h.focus() : "left" === f && c.focus(), !1
				}
			})
		},
		updateSharingURL: function () {
			"undefined" != typeof this.$element.data("url") && (b.addthis.update("share", "url", this.$element.data("url")), b.addthis.toolbox(".addthis_toolbox", b.addthis_config, {
				url: this.$element.data("url")
			}))
		}
	};
	jQuery.createComponent("SocialSharing", d)
}(jQuery, window, document), function (a, b) {
	var c = {
		init: function () {
			var c = a(b);
			c.smartresize(function () {
				a(".feature", this.$element).removeAttr("style").equalHeights()
			}), c.trigger("resize")
		}
	};
	jQuery.createComponent("SpecificationsAtAGlance", c)
}(jQuery, window, document), function (a) {
	var b = {
		_defaults: {},
		_currentPage: null,
		init: function () {
			a(".ProgressiveResults", this.$element).ProgressiveResults({
				container: ".items",
				resultItems: ".el",
				nextButton: ".moreResults"
			})
		}
	};
	jQuery.createComponent("StackedBlocks", b)
}(jQuery, window, document), function () {
	var a = {
		_defaults: {},
		_foo: "bar",
		_blue: "blar",
		init: function () {},
		publicMethod: function () {},
		_privateMethod: function () {},
		_destroy: function () {}
	};
	jQuery.createComponent("SubFooter", a)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {
			toggleButton: null
		},
		_$moreButton: null,
		_moreButtonDisplaying: !1,
		_$lessButton: null,
		_expanded: !1,
		_menuItemsFit: !0,
		_menuDivider: null,
		_rtl: !1,
		init_rtl: function () {
			this._rtl = !0
		},
		init: function () {
			var c = this,
				d = site.utils.cookieManager.readCookie("JLR_SubNavigation");
			this._$moreButton = a(".MoreButton", this.$element), this._$lessButton = a(".LessButton", this.$element), this._menuDivider = a(".SubNavigationDivider", this.$element), a(".SubNavigationContainer", c.$element).css({
				overflow: "hidden",
				height: "41px"
			}), this._menuDivider.hide(), this._recalculateSubNavWidth(this), a(b).smartresize(function () {
				c._recalculateSubNavWidth()
			}), this._subnavSetupInteractionEvents(), null !== d && this._showExpandedMenu(0, !1)
		},
		_subnavSetupInteractionEvents: function () {
			var c = this;
			c._$moreButton.on("click tap", function () {
				c._showExpandedMenu()
			}), c._$lessButton.on("click tap", function () {
				c._hideExpandedMenu(), c._$moreButton.css({
					display: "inline-block"
				}), c._moreButtonDisplaying = !0
			}), a(b).on("NavigationModelSwitcher", function (a, b) {
				"opened" === b && c._hideExpandedMenu()
			})
		},
		_recalculateSubNavWidth: function () {
			var b = this,
				c = b.$element.width(),
				d = a(".SubNavigationMainList li", b.$element),
				e = 0,
				f = a(".navigationModelSwitcherButtonContainer", b.$element);
			1 === f.length && (e = f.outerWidth()), b._menuItemsFit = !0, jQuery.each(d, function (d, f) {
				return e += a(f).outerWidth(), e > c ? (b._menuItemsFit = !1, !1) : void 0
			}), b._menuItemsFit === !1 ? b._expanded === !0 ? b._hideMoreButton() : b._showMoreButton(d) : (b._hideMoreButton(), a(".SubNavigationMainList").css(b._rtl === !0 ? {
				"margin-left": 0
			} : {
				"margin-right": 0
			}), b._hideExpandedMenu()), this.$element.css({
				overflow: "hidden"
			})
		},
		_showMoreButton: function () {
			var b = this;
			if (b._moreButtonDisplaying === !1) {
				b._moreButtonDisplaying = !0, b._$moreButton.css({
					display: "inline-block"
				});
				var c = b._$moreButton.outerWidth() + 10;
				a(".SubNavigationMainList").css(b._rtl === !0 ? {
					"margin-left": c
				} : {
					"margin-right": c
				})
			}
		},
		_hideMoreButton: function () {
			var a = this;
			a._moreButtonDisplaying === !0 && (a._moreButtonDisplaying = !1, a._$moreButton.css({
				display: "none"
			}))
		},
		_showExpandedMenu: function (c, d) {
			var e = this;
			if (e._expanded === !1) {
				if (a(".NavigationModelSwitcher").NavigationModelSwitcher("isOpen") === !0) return a(".NavigationModelSwitcher").NavigationModelSwitcher("fastClose"), void setTimeout(function () {
					e._showExpandedMenu(200)
				}, 220);
				if (e._expanded = !0, "undefined" == typeof c && (c = 400), e._menuDivider.show().transition({
					opacity: 1,
					duration: c
				}, "ease"), a(b).width() < site.breakpoints.medium) {
					var f = a(".notificationBars").height() + a(".headerWrapper").height() + 82;
					a("body").transition({
						"padding-top": f,
						duration: c
					}, "ease")
				}
				d === !1 ? a(".SubNavigationContainer", e.$element).css({
					height: "82px"
				}) : a(".SubNavigationContainer", e.$element).transition({
					height: "82px",
					duration: c
				}, "ease", function () {
					a(b).trigger("resize")
				}), e._$moreButton.hide(), e._$lessButton.css({
					display: "inline-block"
				});
				var g = e._$lessButton.outerWidth() + 10;
				a(".SubNavigationMainList").css({
					"margin-right": g
				}), site.utils.cookieManager.createCookie("JLR_SubNavigation", "true")
			}
		},
		_hideExpandedMenu: function (c) {
			var d = this;
			if (d._expanded === !0) {
				if (d._expanded = !1, "undefined" == typeof c && (c = 400), d._menuDivider.transition({
					opacity: 0
				}, c, "ease", function () {
					this.hide()
				}), a(b).width() < site.breakpoints.medium) {
					var e = a(".notificationBars").height() + a(".headerWrapper").height() + 41;
					a("body").transition({
						paddingTop: e
					}, c, "ease")
				}
				a(".SubNavigationContainer", d.$element).transition({
					height: "41px"
				}, c, "ease", function () {
					a(b).trigger("resize")
				}), d._$lessButton.hide(), site.utils.cookieManager.deleteCookie("JLR_SubNavigation")
			}
		},
		isExpanded: function () {
			return this._expanded
		},
		fastClose: function () {
			this._hideExpandedMenu(200)
		}
	};
	jQuery.createComponent("SubNavigation", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		_$currentTab: null,
		_group: "",
		init: function () {
			var c = this;
			this.$element.css({
				display: "table"
			}), this._group = this.$element.attr("data-group"), this._activateTab(a("a", a("li", this.$element).first()), !1), a("li a", this.$element).on("click tap", function (a) {
				a.preventDefault(), c._activateTab(this, !0)
			}), c._addKeyboardNavigation(), a(b).smartresize(function () {
				c._equalHeights()
			}), c._equalHeights()
		},
		_activateTab: function (c, d) {
			var e = this,
				f = a(c),
				g = f.parent();
			if (null === e._$currentTab || e._$currentTab[0] !== g[0]) {
				e._$currentTab = g, a("li", e.$element).removeClass("active"), g.addClass("active");
				var h = f.attr("href").substring(1),
					i = a('.tabContent[data-group="' + e._group + '"][data-tabid="' + h + '"]'),
					j = a('.tabContent[data-group="' + e._group + '"]:visible'),
					k = d === !0 ? 400 : 0;
				j.stop().fadeTo(k, 0, function () {
					a(this).hide().removeClass("visibleTab"), i.stop().show().fadeTo(k, 1).addClass("visibleTab"), a(b).trigger("resize")
				})
			}
			this.$element.trigger("changeTabs")
		},
		_destroy: function () {
			a("li a", this.$element).off("click tap")
		},
		_addKeyboardNavigation: function () {
			var b = this,
				c = b.$element.find("> li > a");
			c.keydown(function (b) {
				39 === b.keyCode ? a(this).parent("li").next("li").find("a").focus() : 37 === b.keyCode && a(this).parent("li").prev("li").find("a").focus()
			})
		},
		_equalHeights: function () {
			var b = this,
				c = [];
			a("li > a", b.$element).css({
				"padding-top": 0,
				"padding-bottom": 0,
				"margin-top": "10px",
				"margin-bottom": "10px"
			}).each(function () {
				c.push((a(this).parent().height() - a(this).height()) / 2)
			}).each(function (b) {
				a(this).removeAttr("style").css({
					"padding-top": c[b],
					"padding-bottom": c[b]
				})
			})
		}
	};
	jQuery.createComponent("TabFilter", c)
}(jQuery, window, document), function (a, b, c) {
	var d = {
		_defaults: {},
		_linkURL: null,
		init: function () {
			this.setupListener()
		},
		setupListener: function () {
			var a = this;
			a.$element.off("click.TargetLinks").on("click.TargetLinks", {
				that: this
			}, a.processLinkType)
		},
		processLinkType: function (c) {
			var d = c ? c.data.that : this;
			if (d._checkDragging(c)) {
				var e = a(this),
					f = e.attr("data-target"),
					g = site.utils.addParameterToURL(e.attr("href"), site.utils.campaignTrackingPersistance.getTracking("GoogleCampaign"));
				if (e.attr("href", g), null !== f) {
					switch (f) {
					case "overlay":
						c.preventDefault(), d._openLinkInOverlay(g);
						break;
					case "new":
						c.preventDefault(), b.open(g);
						break;
					case "fullscreen":
						c.preventDefault(), d._initFullscreen(g)
					}
					a(b).trigger("VideoPlayerPause", {
						videoid: null
					})
				}
			}
		},
		_openLinkInOverlay: function (c) {
			return site.utils.isBreakpointSmall() || site.utils.isMobileDevice() ? void b.open(c) : void a.magnificPopup.open({
				closeMarkup: '<a class="mfp-close" href=""></a>',
				closeOnBgClick: !0,
				fixedContentPos: !0,
				alignTop: !0,
				type: "iframe",
				items: {
					src: c
				}
			})
		},
		_checkDragging: function (b) {
			var c = !1;
			return a(b.target).parents(".SameSizeCarousel").length > 0 ? a(b.target).parents(".SameSizeCarousel").SameSizeCarousel("getDragging") ? b.preventDefault() : c = !0 : a(b.target).parents(".DualFrameCarousel").length > 0 && a(b.target).parents(".DualFrameCarousel").DualFrameCarousel("getDragging") ? b.preventDefault() : c = !0, c
		},
		_initFullscreen: function (d) {
			var e = this;
			a(b).width() <= site.breakpoints.medium || a("html").hasClass("lt-ie10") || a("html").hasClass("touchCapability") ? (site.utils.cookieManager.createCookie("JLR_previousURL", c.URL), b.location = d) : e._openFullscreen(d)
		},
		_openFullscreen: function (c) {
			a(b).trigger("fullscreenOpened"), a.magnificPopup.open({
				closeOnBgClick: !1,
				fixedContentPos: !0,
				alignTop: !0,
				type: "ajax",
				items: {
					src: c
				},
				callbacks: {
					beforeClose: function () {
						a(b).off("AddThisToggle"), a(b).off("FilmStripToggle"), a(b).trigger("fullscreenClosed"), a(".Fullscreen").Fullscreen("destroyComponents")
					},
					parseAjax: function (b) {
						b.data = a(b.data).find(".Fullscreen")
					},
					ajaxContentAdded: function () {
						a(".Fullscreen").Fullscreen(), a(".mfp-close").on("click", function (a) {
							a.preventDefault()
						})
					}
				}
			})
		},
		_destroy: function () {}
	};
	jQuery.createComponent("TargetLinks", d)
}(jQuery, window, document), function (a, b, c, d) {
	var e = {
		_defaults: {
			overlay: !0
		},
		_vehicleSelectorVisible: !1,
		_modelSelectorVisible: !1,
		_vehicleSelectorContentLoaded: null,
		_vehicleSelectorOverlayLoaded: !1,
		_$vehicleSelector: null,
		_$modelSelector: null,
		_tallestVehicle: 0,
		_tallestModel: 0,
		_windowWidth: 0,
		_ltie9: !1,
		_ltie10: !1,
		_touchEnabledDevice: "ontouchstart" in b || navigator.msMaxTouchPoints ? !0 : !1,
		_slideFromRight: !1,
		_stickyNavigationEnabled: null,
		init_rtl: function () {
			this._slideFromRight = !0
		},
		init: function () {
			var c = this;
			this._windowWidth = a(b).width(), a("html").hasClass("lt-ie9") && (this._ltie9 = !0, a(b).on("closeNotificationBar", function () {
				c._onResize()
			})), a("html").hasClass("lt-ie10") && (this._ltie10 = !0), c._stickyNavigationEnabled = site.stickyNavigationEnabled && !this._ltie9, this.options.overlay === !0 ? (this.$element.on("click tap", function (a) {
				a.preventDefault(), c._onVehicleSelectorToggle()
			}), setTimeout(function () {
				c._loadVehicleSelectorHTML()
			}, 3e3)) : (this._vehicleSelectorContentLoaded = !0, this._vehicleSelectorVisible = !0, this._vehicleSelectorOverlayLoaded = !0, c._loadVehicleSelector(), c._onResize(!0)), a(b).smartresize(function () {
				c._onResize(!0)
			}), c._checkContentLinks()
		},
		_checkContentLinks: function () {
			if (this._touchEnabledDevice) {
				var b = a(".selectorContentLink", this._$vehicleSelector);
				a.each(b, function (b, c) {
					var d = a(c),
						e = d.html();
					d.replaceWith(a('<a href="' + d.attr("data-href") + '" class="selectorContentLink TargetLinks" tabindex="-1" data-href="' + d.attr("data-href") + '" data-target="' + d.attr("data-target") + '">' + e + "</div>")), a(".TargetLinks").TargetLinks("setupListener")
				})
			}
		},
		_onResize: function (c) {
			var d = this;
			if (d._vehicleSelectorVisible === !0) {
				var e = a(".headerWrapper").offset().top - a(b).scrollTop() + a(".headerWrapper").outerHeight();
				d.options.overlay === !0 && (a("#vehicleSelectorOverlay").css({
					top: e
				}), a(".VehicleSelector").css({
					"padding-bottom": e
				}));
				var f = 0,
					g = 0;
				a(".VehicleSelectorWrapper", this._$vehicleSelector).removeClass("longLinks"), jQuery.each(a(".vehicleSelectorButtons span", this._$vehicleSelector), function (b, c) {
					g = a(c).outerHeight(), g > f && (f = g)
				}), f > 15 ? a(".VehicleSelectorWrapper", this._$vehicleSelector).addClass("longLinks") : a(".VehicleSelectorWrapper", this._$vehicleSelector).removeClass("longLinks"), d._recalculateVehicleHeights(), c === !0 && (setTimeout(function () {
					d._onResize(!1)
				}, 50), setTimeout(function () {
					d._onResize(!1)
				}, 100)), this._checkContentLinks()
			}
		},
		_loadVehicleSelectorHTML: function () {
			var b = this;
			null === this._vehicleSelectorContentLoaded && a.ajax({
				type: "GET",
				url: b.$element.attr("href"),
				dataType: "html"
			}).done(function (c) {
				b._vehicleSelectorContentLoaded = a(".VehicleSelector", c).html();
				var d = a(b._vehicleSelectorContentLoaded),
					e = a("span[data-picture]", d),
					f = [];
				a.each(e, function (c, d) {
					var e = a(d),
						g = a("> span", e),
						h = null;
					a.each(g, function (c, d) {
						var e = a(d),
							f = e.attr("data-media");
						"undefined" != typeof f && (f = f.substring(12).slice(0, -3), b._windowWidth >= f && (h = e))
					}), null !== h && f.push(h.attr("data-src"))
				}), b._preloadImages(f), b._loadVehicleSelector()
			})
		},
		_onVehicleSelectorToggle: function () {
			var c = this;
			if (this._vehicleSelectorVisible === !0) c._removeKeyboardNavigation(), a(".MainNavigation .primaryNav > ul").removeClass("activeOverlay"), this.$element.parent().removeClass("activeOverlay"), a(b).trigger("overlayClosed"), c._vehicleSelectorVisible = !1, this._modelSelectorVisible === !1 ? (c._modelSelectorVisible = !1, a("#vehicleSelectorOverlay").transition({
				opacity: "0"
			}, 400, "ease", function () {
				a(b).width() > site.breakpoints.medium && !c._stickyNavigationEnabled ? (a("html").removeClass("withVehicleSelector").height("auto"), site.utils.scrollTo(0)) : a("html").removeClass("withVehicleSelector").height("auto"), c._fadeOutOverlay()
			})) : this._$modelSelector.transition({
				opacity: "0"
			}, 400, "ease", function () {
				a(b).width() > site.breakpoints.medium && !c._stickyNavigationEnabled ? site.utils.scrollTo(0, 800, function () {
					a("html").height("auto")
				}) : a("html").height("auto"), a("html").removeClass("withVehicleSelector").height("auto"), c._$modelSelector.off("onClose"), c._$modelSelector.ModelSelector("destroy"), c._$modelSelector.html(""), c._fadeOutOverlay()
			});
			else {
				a("html").height("auto"), null === c._vehicleSelectorContentLoaded && a.ajax({
					type: "GET",
					url: c.$element.attr("href"),
					dataType: "html"
				}).done(function (b) {
					c._vehicleSelectorContentLoaded = a(".VehicleSelector", b).html(), c._loadVehicleSelector()
				});
				var d = a(b).scrollTop();
				0 !== d && a(b).width() > site.breakpoints.medium && !c._stickyNavigationEnabled ? a("body, html").stop().animate({
					scrollTop: 0
				}, 800, "easeOutSine", function () {
					c._createOverlay()
				}) : c._createOverlay()
			}
		},
		_createOverlay: function () {
			var c = this,
				d = a(".headerWrapper").offset().top + a(".headerWrapper").outerHeight();
			a("html").addClass("withVehicleSelector"), a(b).trigger("resize"), c._vehicleSelectorVisible = !0, a(".MainNavigation .primaryNav > ul").addClass("activeOverlay"), c.$element.parent().addClass("activeOverlay"), a(b).trigger("overlayOpened"), c._ltie10 === !0 && a("html").height(3e3), a("body").append('<div id="vehicleSelectorOverlay" class="overlay" style="display:none; top:' + d + 'px; z-index:9"></div>'), c.options.overlay === !0 && c._fadeInOverlay(), null !== c._vehicleSelectorContentLoaded && c._loadVehicleSelector()
		},
		_fadeInOverlay: function () {
			var b = this;
			a("html").addClass("noScroll"), this._ltie9 === !0 ? a("#vehicleSelectorOverlay").fadeIn(200, function () {
				b._vehicleSelectorOverlayLoaded = !0, b._loadVehicleSelector()
			}) : a("#vehicleSelectorOverlay").css({
				opacity: "0"
			}).show().transition({
				opacity: "1"
			}, 200, "ease", function () {
				b._vehicleSelectorOverlayLoaded = !0, b._loadVehicleSelector()
			})
		},
		_fadeOutOverlay: function () {
			var c = this;
			a("html").removeClass("noScroll"), this._ltie9 === !0 ? a("#vehicleSelectorOverlay").fadeOut(400, function () {
				c._unbindEvents(), a("#vehicleSelectorOverlay").remove(), c._vehicleSelectorVisible = !1, c._modelSelectorVisible = !1, a(b).trigger("resize")
			}) : a("#vehicleSelectorOverlay").transition({
				opacity: "0"
			}, 400, "ease", function () {
				c._unbindEvents(), a("#vehicleSelectorOverlay").remove(), c._vehicleSelectorVisible = !1, c._modelSelectorVisible = !1, a(b).trigger("resize")
			})
		},
		_loadVehicleSelector: function () {
			var c = this;
			this._vehicleSelectorOverlayLoaded === !0 && null !== this._vehicleSelectorContentLoaded && (this._vehicleSelectorOverlayLoaded = !1, this.options.overlay === !0 && (a("#vehicleSelectorOverlay").html('<div class="VehicleSelector">' + this._vehicleSelectorContentLoaded + "</div>"), b.picturefill()), this._$vehicleSelector = a(".VehicleSelector"), this._$vehicleSelector.waitForImages(function () {
				a(b).trigger("resize"), c._onResize()
			}), a(".selectorContentLink", this._$vehicleSelector).on("click tap", function (a) {
				c._touchEnabledDevice || a.preventDefault()
			}), this.options.overlay === !0 && (this._launchVehicleSelector(), c._addKeyboardNavigation()))
		},
		_recalculateVehicleHeights: function () {
			var b = 0,
				c = 0;
			a(".vehicleWrapper", this._$vehicleSelector).css("height", "auto"), jQuery.each(a(".vehicleWrapper", this._$vehicleSelector), function (d, e) {
				c = a(e).outerHeight(), c > b && (b = c)
			}), this._tallestVehicle = b, a(".vehicleWrapper", this._$vehicleSelector).height(b), this.options.overlay === !0 && 0 !== a(".VehicleSelector").length && a("html").height(a("#header").outerHeight() + a(".VehicleSelector").outerHeight())
		},
		_detectTapOnOverlay: function (b) {
			var c = b.data.that;
			(b.target === a("#vehicleSelectorOverlay")[0] || b.target === a(".VehicleSelectorWrapper", c._$vehicleSelector)[0]) && c._onVehicleSelectorToggle()
		},
		_launchVehicleSelector: function () {
			a(c).on("click tap", {
				that: this
			}, this._detectTapOnOverlay), a("#vehicleSelectorOverlay").on("click tap", function () {});
			var e = a(".VehicleSelectorWrapper .el", this._$vehicleSelector),
				f = e.length,
				g = 0,
				h = null;
			a(b).trigger("resize"), a(".VehicleSelectorWrapper", this._$vehicleSelector).addClass("showVehicles"), a.support.transition = function () {
				var a = c.body || c.documentElement,
					b = a.style,
					e = b.transition !== d || b.WebkitTransition !== d || b.MozTransition !== d || b.MsTransition !== d || b.OTransition !== d;
				return e
			}(), jQuery.support.transition || (this._ltie9 === !0 ? (e.css({
				opacity: "0",
				visibility: "visible"
			}), h = setInterval(function () {
				e.eq(g).animate({
					opacity: 1
				}, 400), g++, g >= f && clearInterval(h)
			}, 200)) : (e.css({
				opacity: "0",
				visibility: "visible"
			}).show(), h = setInterval(function () {
				e.eq(g).transition({
					opacity: "1"
				}, 400, "ease"), g++, g >= f && clearInterval(h)
			}, 200))), this._setupModelSelector()
		},
		_setupModelSelector: function () {
			var b = this;
			a(".selectorSlider", ".VehicleSelector:not(.inPageVehicleSelector)").append('<div class="ModelSelector VehicleSelectorWrapper clearfix"></div>'), a(".chooseModel", ".VehicleSelector:not(.inPageVehicleSelector)").on("click tap", function (c) {
				c.preventDefault(), b._openModelSelector(a(this).attr("href"))
			})
		},
		_openModelSelector: function (c) {
			var d = this;
			d._$modelSelector = a(".ModelSelector", this._$vehicleSelector), d._$modelSelector.ModelSelector({
				url: c
			}), d._$modelSelector.on("onClose", function () {
				d._closeModelSelector()
			}), d._$modelSelector.on("readyToOpen", function () {
				setTimeout(function () {
					d._$modelSelector.off("readyToOpen"), d._modelSelectorVisible = !0;
					var c = a(b);
					d._windowWidth = c.width();
					var e = a("#vehicleSelectorOverlay").scrollTop(),
						f = "";
					a("html").hasClass("lt-ie10") ? (f = "-100%", d._slideFromRight === !0 && (f = "100%"), a(".selectorSlider", d._$vehicleSelector).animate({
						left: f
					}, 700, function () {
						a(".VehicleSelectorWrapper", this._$vehicleSelector).addClass("hideVehicles")
					})) : (f = "-50%", d._slideFromRight === !0 && (f = "50%"), a(".VehicleSelector:not(.inPageVehicleSelector) .selectorSlider", this._$vehicleSelector).transition({
						x: f
					}, 700, "ease", function () {
						a(".VehicleSelector:not(.inPageVehicleSelector) .VehicleSelectorWrapper", this._$vehicleSelector).addClass("hideVehicles")
					})), d._windowWidth > site.breakpoints.medium && 0 !== e && a("#vehicleSelectorOverlay").stop().animate({
						scrollTop: 0
					}, 0)
				}, 100)
			})
		},
		_closeModelSelector: function () {
			var c = this;
			a(".VehicleSelectorWrapper", this._$vehicleSelector).removeClass("hideVehicles");
			var d = a(b);
			c._windowWidth = d.width();
			var e = a("#vehicleSelectorOverlay").scrollTop();
			d.trigger("resize"), setTimeout(function () {
				a("html").hasClass("lt-ie10") ? a(".selectorSlider", this._$vehicleSelector).animate({
					left: "0%"
				}, 700, function () {
					c._modelSelectorVisible = !1, c._$modelSelector.off("onClose"), c._$modelSelector.ModelSelector("destroy"), c._$modelSelector.html(""), d.trigger("resize")
				}) : a(".selectorSlider", this._$vehicleSelector).transition({
					x: 0
				}, 700, "ease", function () {
					c._modelSelectorVisible = !1, c._$modelSelector.off("onClose"), c._$modelSelector.ModelSelector("destroy"), c._$modelSelector.html(""), d.trigger("resize")
				}), c._windowWidth > site.breakpoints.medium && 0 !== e && a("#vehicleSelectorOverlay").stop().animate({
					scrollTop: 0
				}, 0)
			}, 100)
		},
		_preloadImages: function (b) {
			a(b).each(function () {
				a("<img/>")[0].src = this
			})
		},
		_unbindEvents: function () {
			a(c).off("click tap", this._detectTapOnOverlay), null !== this._$modelSelector && (this._$modelSelector.off("onClose"), this._$modelSelector.off("readyToOpen"), a("#vehicleSelectorOverlay").off("click tap"))
		},
		_addKeyboardNavigation: function () {
			var b = this,
				c = b.$element,
				d = a("#vehicleSelectorOverlay .selectorButton"),
				e = a("#vehicleSelectorOverlay .selectorButton:first");
			c.keydown(function (a) {
				return 40 === a.keyCode ? (e.focus(), !1) : void 0
			}), d.keydown(function (b) {
				var d = a(this);
				if (40 === b.keyCode || 39 === b.keyCode) {
					var f = d.next(".selectorButton");
					return f.length > 0 ? f.focus() : d.parents(".el").next(".el").find(".selectorButton:first").focus(), !1
				}
				if (38 === b.keyCode || 37 === b.keyCode) {
					if (!d.is(e)) {
						var g = d.prev(".selectorButton");
						return g.length > 0 ? g.focus() : d.parents(".el").prev(".el").find(".selectorButton:last").focus(), !1
					}
					c.focus()
				} else if (9 === b.keyCode) return !1
			})
		},
		_removeKeyboardNavigation: function () {
			var b = this,
				c = b.$element,
				d = a("#vehicleSelectorOverlay .selectorButton");
			c.off("keydown"), d.off("keydown")
		}
	};
	jQuery.createComponent("VehicleSelector", e)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		_loadingContent: !1,
		_body: "",
		_model: "",
		_openAccordions: [],
		_allOpen: !1,
		_animatingAll: !1,
		_$accordion: a(".specDetails", this.$element),
		init: function () {
			var c = this;
			this._setupAccordion(), a(".yourModel .model > a", this.$element).equalHeights(), a(b).smartresize(this._onResize), a(".DropdownNav", this.$element).css({
				position: "absolute"
			}), a(".DropdownNav > span", this.$element).css({
				display: "block"
			}), this._body = a(".yourModel .bodyStyle ul li.active", this.$element).attr("data-model"), this._model = a(".yourModel .model ul li.active", this.$element).attr("data-model"), a(".yourModel .bodyStyle", this.$element).on("selected", function (b, d) {
				d = a(d), c._filterByBodyStyle(d.attr("data-body-style")) && c._loadContent(d.attr("data-body-style"), a(".model ul li.active", c.$element).attr("data-model")), a("body").trigger("click tap")
			}), a(".yourModel .model", this.$element).on("selected", function (b, d) {
				d = a(d), c._model !== d.attr("data-model") && (c._model = d.attr("data-model"), c._loadContent(a(".yourModel .bodyStyle ul li.active", c.$element).attr("data-body-style"), d.attr("data-model"))), a("body").trigger("click tap")
			}), c._filterByBodyStyle(a(".bodyStyle ul li.active", c.$element).attr("data-body-style")), a(".yourModel .DropdownNav", this.$element).on("open", function () {
				var b = a(this);
				a(".yourModel .DropdownNav > span", c.$element).not(a("> span", b)).trigger("close")
			})
		},
		_filterByBodyStyle: function (b) {
			if (this._body !== b) {
				this._body = b, a('.model ul li[data-body-style="' + b + '"]', this.$element).show(), a('.model ul li:not([data-body-style="' + b + '"])', this.$element).hide();
				var c = a(".model ul li.active", this.$element).attr("data-model"),
					d = a('.model ul li[data-body-style="' + b + '"][data-model="' + c + '"]', this.$element);
				return 1 === d.length ? a("a", d).trigger("click") : a("a", a('.model ul li[data-body-style="' + b + '"]', this.$element).first()).trigger("click"), this._model = a(".yourModel .bodyStyle ul li.active", this.$element).attr("data-model"), !0
			}
			return !1
		},
		_updateVehicleHeader: function (b) {
			a(".specHeaderText", this.$element).text(b)
		},
		_loadContent: function (b, c) {
			var d = this;
			if (this._loadingContent === !1) {
				this._loadingContent = !0, setTimeout(function () {
					d._loadingContent = !1
				}, 100), a(".specDetails", this.$element).prepend('<div class="vehicleSpecificationsOverlay">&nbsp;</div>'), a(".vehicleSpecificationsOverlay").transition({
					duration: 400,
					easing: "ease",
					opacity: .73
				});
				var e = location.pathname + "?bodyStyle=" + encodeURIComponent(b) + "&model=" + encodeURIComponent(c);
				a.ajax({
					url: e,
					cache: !1
				}).done(function (b) {
					b = a(b);
					var c = a(".VehicleSpecifications .specDetails", b).children(),
						e = a(".VehicleSpecifications .specHeaderText", b).text();
					d._updateVehicleHeader(e), d._unbindAccordion(), d._openAccordions = [];
					var f = a(".specDetails ul li.active a", d.$element),
						g = "";
					jQuery.each(f, function (b, c) {
						g = a(c).text().replace(/<!--[\s\S]*?-->/g, ""), d._openAccordions.push(g)
					}), 1 === a(".specHeaderText", b).length && a(".specHeaderText", d.$element).html(a(".specHeaderText", b).html()), 1 === a(".price", b).length && a(".price", d.$element).html(a(".price", b).html()), a(".vehicleSpecificationsOverlay", d.$element).nextAll().remove(), a(".vehicleSpecificationsOverlay", d.$element).after(c), d._$accordion = a(".specDetails", d.$element), a("table", d._$accordion).ResponsiveTable(), d._setupAccordion(), d._openAccordions.length > 0 && a(".specDetails > ul > li > a").each(function () {
						a.inArray(a(this).text(), d._openAccordions) > -1 && a(this).parent().addClass("active").find("> div").css({
							"overflow-y": "hidden",
							height: "auto"
						})
					}), a(".vehicleSpecificationsOverlay", d.$element).transition({
						opacity: 0,
						duration: 400,
						easing: "ease"
					}, function () {
						a(this).remove()
					})
				})
			}
		},
		_onResize: function () {
			a(".yourModel .model > a", this.$element).css({
				height: "auto"
			}).equalHeights()
		},
		_setupAccordion: function () {
			{
				var c = this;
				a("> ul > li > div", this._$accordion).css({
					"overflow-y": "hidden",
					height: "0"
				})
			}
			c._updateOpenAllText(), a("ul > li > a", this._$accordion).off("click tap").on("click tap", function (d) {
				d.preventDefault();
				var e = a(this).parent();
				if (!e.hasClass("animating")) if (a(b).width() < site.breakpoints.small && a("ul > li.active", c._$accordion).each(function () {
					a(this).index() !== e.index() && a(this).find("a").trigger("click")
				}), e.hasClass("active")) e.addClass("animating"), a("> div", e).css({
					height: a("> div", e).outerHeight()
				}).transition({
					duration: 400,
					height: 0,
					easing: "ease"
				}, function () {
					e.removeClass("active animating"), 0 === a("ul > li.active > a", c._$accordion).length && (c._allOpen = !1, c._updateOpenAllText())
				});
				else {
					e.addClass("active animating");
					var f = (a("> div", e).clone().removeAttr("style").css({
						position: "absolute",
						visibility: "hidden",
						width: a(".specDetails", this.$element).width()
					}).addClass("slideClone").appendTo(e), a(".slideClone").outerHeight());
					a(".slideClone").remove(), a("> div", e).transition({
						duration: 400,
						height: f,
						easing: "ease"
					}, function () {
						this.css({
							height: "auto"
						}), e.removeClass("animating"), 0 === a("ul > li:not(.active) > a", c._$accordion).length && (c._allOpen = !0, c._updateOpenAllText()), a(b).width() < site.breakpoints.small && site.utils.scrollTo(e)
					})
				}
			}), a(".openAll", this.$element).off("click tap").on("click tap", function (b) {
				return b.preventDefault(), c._animatingAll === !0 ? !1 : (c._animatingAll = !0, setTimeout(function () {
					c._animatingAll = !1
				}, 500), c._allOpen === !1 ? (c._allOpen = !0, a("ul > li:not(.active) > a", c._$accordion).trigger("click")) : (c._allOpen = !1, a("ul > li.active > a", c._$accordion).trigger("click")), void c._updateOpenAllText())
			})
		},
		_updateOpenAllText: function () {
			var b = this;
			b._allOpen === !1 ? (a(".openAll .close", this.$element).hide(), a(".openAll .open", this.$element).show()) : (a(".openAll .open", this.$element).hide(), a(".openAll .close", this.$element).show())
		},
		_unbindAccordion: function () {
			a("ul > li > a", this._$accordion).off("click tap")
		}
	};
	jQuery.createComponent("VehicleSpecifications", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		_videoID: null,
		init: function () {
			var a = [location.protocol, "//", location.host, location.pathname].join("");
			this._videoID = this.$element.data("video").toString();
			var b = this._getVideoIDFromURL();
			if (b && b.toString() === this._videoID) {
				if (null !== site.utils.cookieManager.checkForCookie("JDX_VideoLauncher")) {
					var c = site.utils.cookieManager.readCookie("JDX_VideoLauncher");
					if (null !== c) {
						var d = c.split(",");
						if (d[0].toString() === this._videoID && a === d[1]) return
					}
				}
				site.utils.cookieManager.createCookie("JDX_VideoLauncher", this._videoID + "," + a), null !== site.utils.cookieManager.checkForCookie("VideoLauncher") && this._launchVideo()
			}
		},
		_getVideoIDFromURL: function () {
			for (var a = b.location.search.substring(1), c = a.split("&"), d = 0; d < c.length; d++) {
				var e = c[d].split("=");
				if ("video" === e[0]) return e[1]
			}
			return null
		},
		_launchVideo: function () {
			a(b).width() >= site.breakpoints.medium ? b.location.href = this.$element.attr("href") : site.utils.isIOS() ? b.location.href = this.$element.attr("href") : b.open(this.$element.attr("href"), "_blank")
		}
	};
	jQuery.createComponent("VideoLauncher", c)
}(jQuery, window, document), function (a, b, c) {
	var d = {
		_defaults: {
			autoplay: !1,
			muted: !1,
			loop: !1,
			controls: ["playpause", "progress", "current", "duration", "tracks", "volume", "fullscreen"],
			clickToPlayPause: !0,
			pauseOtherPlayers: !1,
			disableTracking: !1,
			aspectRatio: 16 / 9,
			onReady: function () {},
			onCanPlay: function () {}
		},
		_$video: null,
		_videoLoaded: !1,
		_playWhenLoaded: !1,
		_rewindWhenLoaded: !1,
		_media: null,
		_error: !1,
		_videoType: null,
		_startLanguage: "zz",
		_captions: !1,
		_firstTimePlay: !1,
		_delayedResize: null,
		_videoId: null,
		_isFullScreen: !1,
		_direction: "ltr",
		init_rtl: function () {
			this._direction = "rtl"
		},
		init: function () {
			var b = this;
			b._videoId = "VideoPlayer_" + Math.floor(99999 * Math.random()), b._$video = a("video", this.$element), 0 !== b._$video.length ? b._setupVideo() : (b.$element.data("autoplay") === !0 && b._initVideo(), a(".posterImage").on("ResponsiveLinkClicked", function (a, c) {
				"desktop" === c.state && b._initVideo()
			}))
		},
		_initVideo: function () {
			this._createVideoTag(), this._setupVideo()
		},
		_videoExists: function () {
			return 0 === this._$video.length ? !1 : !0
		},
		_createVideoTag: function () {
			var b = a("videoplaceholder", this.$element),
				c = b.clone(),
				d = c[0].outerHTML;
			d = d.replace(new RegExp("placeholder", "g"), ""), d = d.replace(new RegExp("data-data", "g"), "data"), d = d.replace(new RegExp("data-type", "g"), "type"), d = d.replace(new RegExp("<:", "g"), "<"), d = d.replace(new RegExp("</:", "g"), "</"), a(".playerWrapper", this.$element).append(d), a(".posterImage", this.$element).hide(), this._$video = a("video", this.$element)
		},
		_setupVideo: function () {
			var c = this;
			c._$video.css({
				visibility: "visible"
			}), 0 === this.options.controls.length && c._$video.removeAttr("controls"), this.options.autoplay === !0 && this._$video.attr("autoplay", "true");
			var d = a("track", this._$video);
			d.length > 0 && d.each(function () {
				return "undefined" != typeof a(this).data("autoplay") && a(this).data("autoplay") === !0 ? void(c._startLanguage = a(this).attr("srclang")) : void 0
			});
			var e = "100%",
				f = "100%";
			0 !== this.$element.parents(".HeroCarousel").length && c._detectHTML5Video() === !0 && (e = 640, f = 360), c._selectCorrectVideo(), c._$video.mediaelementplayer({
				videoWidth: e,
				videoHeight: f,
				enableAutosize: !0,
				plugins: ["flash"],
				pluginPath: "/resources/public/flash/mediaelement/",
				flashName: "flashmediaelement.swf",
				enableKeyboard: !1,
				pauseOtherPlayers: c.options.pauseOtherPlayers,
				clickToPlayPause: c.options.clickToPlayPause,
				keyActions: [],
				autoRewind: c.options.loop,
				alwaysShowControls: !1,
				iPadUseNativeControls: !0,
				iPhoneUseNativeControls: !0,
				AndroidUseNativeControls: !0,
				features: c.options.controls,
				autosizeProgress: !0,
				startVolume: .8,
				startLanguage: c._startLanguage,
				toggleCaptionsButtonWhenOnlyOne: !0,
				success: function (d) {
					c._addMediaOverlay(), c._media = d, d.addEventListener("loadstart", function (a) {
						c._onLoadStart(a)
					}), d.addEventListener("loadeddata", function (a) {
						c._onLoadedData(a)
					}), d.addEventListener("canplay", function (a) {
						c._detectHTML5Video() && c._onCanPlay(a), c.options.onCanPlay(d)
					}), d.addEventListener("play", function (a) {
						c._onPlay(a)
					}), d.addEventListener("pause", function (a) {
						c._onPause(a)
					}), d.addEventListener("ended", function (a) {
						c._onEnded(a)
					}), c.$element.addClass("paused"), c.options.muted === !0 && c.mute(!0), c.options.autoplay === !1 && a(".mejs-poster", c.$element).on("click tap", function () {
						c.play()
					}), c.options.onReady(d), setTimeout(function () {
						a(b).trigger("HeroCarouselForceResize"), a(b).trigger("resize")
					}, 200), c._addKeyboardNavigation()
				},
				error: function () {
					a(".me-cannotplay", c.$element).html(a(".fallbackImage", c.$element)), c._error = !0, b.picturefill(), a(b).trigger("HeroCarouselForceResize"), a(b).trigger("resize")
				}
			}), c._setFullScreenInGallery(), a(b).on("VideoPlayerPause", function (a, b) {
				null !== b.videoid && b.videoid !== c._videoId && c.pause()
			}), a(b).trigger("HeroCarouselForceResize"), a(b).trigger("resize")
		},
		_selectCorrectVideo: function () {
			var c = a("source", this.$element),
				d = a(b).width(),
				e = null;
			a.each(c, function (b, c) {
				e = a(c);
				var f = "";
				f = e.data(d > 1280 ? "1080" : d > 854 ? "720" : d > 640 ? "480" : "360"), e.attr("src", f)
			})
		},
		_onLoadStart: function () {
			a(b).trigger("HeroCarouselForceResize"), a(b).trigger("resize"), setTimeout(function () {
				a(b).trigger("HeroCarouselForceResize"), a(b).trigger("resize")
			}, 300), setTimeout(function () {
				a(b).trigger("HeroCarouselForceResize"), a(b).trigger("resize")
			}, 500), setTimeout(function () {
				a(b).trigger("HeroCarouselForceResize"), a(b).trigger("resize")
			}, 1e3)
		},
		_onLoadedData: function () {
			this._videoLoaded = !0
		},
		_onCanPlay: function () {
			a(b).trigger("HeroCarouselForceResize"), a(b).trigger("resize"), "rtl" === this._direction && a(".mejs-captions-layer", this.$element).attr("dir", "rtl"), this.options.autoplay === !0 ? this._rewindWhenLoaded === !0 ? this.rewind() : this._playWhenLoaded === !0 && this.play() : this._rewindWhenLoaded === !0 ? this.rewind() : this._playWhenLoaded === !0 && this.play()
		},
		_onPlay: function () {
			a(b).trigger("VideoPlayerPause", {
				videoid: this._videoId
			}), a(b).trigger("HeroCarouselForceResize"), a(b).trigger("resize"), this.$element.removeClass("paused"), this.$element.removeClass("finished"), this._firstTimePlay === !1 && (this._firstTimePlay = !0, this.options.disableTracking === !1 && site.tracking.video_play(this.$element.data("title")))
		},
		_onPause: function () {
			this.$element.addClass("paused")
		},
		_onEnded: function () {
			return this.$element.trigger("videoEnded"), this.options.disableTracking === !1 && site.tracking.video_ended(this.$element.data("title")), this.options.loop !== !1 ? void this.play() : (this.$element.addClass("finished"), void(this._$video[0].player.isFullScreen === !0 && this._$video[0].player.exitFullScreen()))
		},
		mute: function (a) {
			this._error === !1 && this._$video[0].player.setMuted(a)
		},
		play: function () {
			if (this._videoExists() === !0 && this._error === !1) {
				if (this._videoLoaded === !1) return void(this._playWhenLoaded = !0);
				this._playWhenLoaded = !1, this._$video[0].player.play()
			}
		},
		pause: function (a) {
			if (this._videoExists() === !0) {
				var b = a ? a.data.that : this;
				b._error === !1 && (b._playWhenLoaded = !1, b._$video[0].player.pause())
			}
		},
		rewind: function () {
			if (this._videoExists() === !0 && this._error === !1) {
				if (this._videoLoaded === !1) return void(this._rewindWhenLoaded = !0);
				this._rewindWhenLoaded = !1, this.setCurrentTime(0)
			}
		},
		setCurrentTime: function (a) {
			this._videoExists() === !0 && this._error === !1 && this._$video[0].player.setCurrentTime(a)
		},
		canBeResumed: function () {
			return this._videoExists() === !0 ? null === this._media ? !1 : this._media.paused === !0 && this._videoLoaded === !0 : void 0
		},
		_addMediaOverlay: function () {
			var b = this;
			b._removeMediaOverlay();
			var c = a('<div class="mediaOverlay mediaOverlayVideo"><div class="mediaOverlayBg"></div><div class="mediaOverlayIcon"></div></div>');
			a(".mejs-overlay-play", b.$element).append(c)
		},
		_removeMediaOverlay: function () {
			var b = this;
			a(".mediaOverlay", b.$element).remove()
		},
		_destroy: function () {
			var b = this;
			b._media.removeEventListener("loadstart"), b._media.removeEventListener("canplay"), b._media.removeEventListener("play"), b._media.removeEventListener("pause"), b._media.removeEventListener("ended"), a(".mejs-poster", b.$element).off("click tap")
		},
		_detectHTML5Video: function () {
			var a = this,
				b = c.createElement("video");
			return b.canPlayType && b.canPlayType('video/webm; codecs="vp8, vorbis"') ? (a._videoType = "webm", !0) : b.canPlayType && b.canPlayType("video/mp4").replace(/no/, "") ? (a._videoType = "mp4", !0) : (a._videoType = "flash", a.$element.addClass("flash"), !1)
		},
		_addKeyboardNavigation: function () {
			var b = this,
				c = a(".mejs-container", b.$element),
				d = a(".mediaOverlay", b.$element),
				e = a(".mejs-controls", c),
				f = a(".mejs-playpause-button button", e),
				g = a(".mejs-time-rail", e),
				h = a(".mejs-captions-button button", e),
				i = a(".mejs-volume-button button", e),
				j = a(".mejs-volume-button .mejs-volume-slider", e),
				k = a(".mejs-fullscreen-button button", e),
				l = b._$video[0].player;
			d.attr("tabindex", "0"), g.attr("tabindex", "0"), d.keydown(function (b) {
				(13 === b.keyCode || 32 === b.keyCode) && (b.preventDefault(), a(this).trigger("click"), setTimeout(function () {
					f.focus()
				}, 1))
			}), f.keydown(function (b) {
				(13 === b.keyCode || 32 === b.keyCode) && (b.preventDefault(), a(this).trigger("click"), setTimeout(function () {
					d.focus()
				}, 1))
			}), g.keydown(function (a) {
				if ((37 === a.keyCode || 39 === a.keyCode) && (a.preventDefault(), !isNaN(l.media.duration) && l.media.duration > 0)) {
					var b = 0;
					b = 37 === a.keyCode ? Math.max(l.media.currentTime - l.options.defaultSeekBackwardInterval(l.media), 0) : Math.min(l.media.currentTime + l.options.defaultSeekForwardInterval(l.media), l.media.duration), l.media.setCurrentTime(b)
				}
			}), h.keydown(function (b) {
				(13 === b.keyCode || 32 === b.keyCode) && (b.preventDefault(), a(this).trigger("click"))
			}), i.focus(function () {
				j.show()
			}), i.blur(function () {
				j.hide()
			}), i.keydown(function (a) {
				if (38 === a.keyCode || 40 === a.keyCode) {
					a.preventDefault();
					var b;
					b = 38 === a.keyCode ? Math.min(l.media.volume + .1, 1) : Math.max(l.media.volume - .1, 0), l.media.setVolume(b)
				}
			}), k.keydown(function (a) {
				(13 === a.keyCode || 32 === a.keyCode) && (a.preventDefault(), "undefined" != typeof l.enterFullScreen && (l.isFullScreen ? l.exitFullScreen() : l.enterFullScreen()))
			})
		},
		_setFullScreenInGallery: function () {
			var b = this,
				d = a(".mejs-container", b.$element),
				e = a(".mejs-controls", d),
				f = a(".mejs-fullscreen-button button", e);
			a("html").is(".ie10, .lt-ie10") && 0 !== b.$element.parents(".Fullscreen").length && (f.on("click", function () {
				b._toggleFullScreenIE()
			}), f.keydown(function (a) {
				(13 === a.keyCode || 32 === a.keyCode) && b._toggleFullScreenIE()
			}), a(c).keydown(function (a) {
				27 === a.keyCode && b._removeFullScreenIE()
			}))
		},
		_applyFullScreenIE: function () {
			var c = this;
			c.$element.parents(".Fullscreen").addClass("fullScreenVideo"), c.$element.css({
				height: a(b).height(),
				width: a(b).width()
			}), c._isFullScreen = !0
		},
		_removeFullScreenIE: function () {
			var a = this;
			a.$element.parents(".Fullscreen").removeClass("fullScreenVideo"), a.$element.css({
				height: "auto",
				width: "auto"
			}), a._isFullScreen = !1
		},
		_toggleFullScreenIE: function () {
			var a = this;
			a._isFullScreen === !1 ? a._applyFullScreenIE() : a._removeFullScreenIE()
		}
	};
	jQuery.createComponent("VideoPlayer", d)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		uiSelectors: {
			fullscreenHeader: ".fullscreenHeader",
			fullscreenFooter: ".fullscreenFooter"
		},
		init: function () {
			var c = this;
			c._onResize(), a(b).resize(function () {
				c._onResize()
			})
		},
		_onResize: function () {
			var b = this;
			0 !== a(".VideoPlayerGalleryAsset").length && b._setVideoWrapperDimensions()
		},
		_setVideoWrapperDimensions: function () {
			var c = this,
				d = a(b).width(),
				e = a(b).height() - this.ui("fullscreenHeader").height() - this.ui("fullscreenFooter").outerHeight();
			e -= 60, d -= 60;
			var f = a(".posterImage > span, .playerWrapper");
			c.aspectRatio > d / e ? f.width(d).height(d / c.aspectRatio) : f.height(e).width(e * c.aspectRatio)
		},
		_destroy: function () {}
	};
	jQuery.createComponent("VideoPlayerGalleryAsset", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		uiSelectors: {
			addThisMenu: ".addThisMenu",
			socialSharing: ".SocialSharing"
		},
		socialOpenTimer: null,
		_rtl: !1,
		init_rtl: function () {
			this._rtl = !0
		},
		init: function () {
			this._initSocialSharing()
		},
		_initSocialSharing: function () {
			var c = this;
			a.each(a(".videoThumbnail", this.$element), function (b, c) {
				var d = a(c),
					e = d.data("sharing-url");
				"undefined" != typeof e && a(".SocialSharing", d).attr("data-url", e)
			}), c.ui("addThisMenu").each(function () {
				a(this).find(".SocialSharing").css(c._rtl === !0 ? {
					right: 0 - a(this).find(".SocialSharing").width()
				} : {
					left: 0 - a(this).width()
				})
			}), c.ui("addThisMenu").on("closeSocialSharing", function () {
				c.socialOpenTimer && clearTimeout(c.socialOpenTimer)
			}), c.ui("addThisMenu").on("openSocialSharing", function () {
				var d = this;
				c.ui("addThisMenu").not(d).find(".SocialSharing").SocialSharing("closeMenu"), a(d).find(".SocialSharing").SocialSharing("updateSharingURL"), c.socialOpenTimer && b.clearTimeout(c.socialOpenTimer), c.socialOpenTimer = b.setTimeout(function () {
					a(d).find(".SocialSharing").SocialSharing("closeMenu")
				}, 7e3)
			})
		},
		_destroy: function () {}
	};
	jQuery.createComponent("VideoThumbnails", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {},
		_ajaxURL: function () {
			return site.localEnv ? "/_bin/VinRecall/" + this.ui("vinField").val().toLowerCase() + ".json" : b.location
		},
		_results: [],
		events: {
			"click tap .searchAgain": "_searchAgain",
			"submit .search form": "_searchSubmit"
		},
		uiSelectors: {
			borderContainer: ".borderContainer",
			responseNoResults: ".responseNoResults",
			responseProblem: ".responseProblem",
			responses: ".responses",
			responseInvalid: ".responseInvalid",
			results: ".results",
			resultsList: ".resultsList",
			resultsTemplate: ".resultsTemplate",
			resultsHeader: ".results .headings",
			vinField: "#vinField",
			vinError: ".vinError",
			searchBtn: "#searchBtn",
			vinLink: ".vinLink",
			vinInfo: ".vinInfo"
		},
		init: function () {
			var a = this;
			this._enableVinInfo(), this._toggleSearchButton(), this._hidePhoneNumbers(), this.ui("vinField").on("keyup paste blur focus", function () {
				setTimeout(function () {
					a._toggleSearchButton()
				}, 500)
			})
		},
		_searchAgain: function () {
			site.utils.scrollTo(this.$element)
		},
		_searchSubmit: function () {
			var a = this,
				b = this.ui("vinField").val();
			b && b !== this.ui("vinField").attr("placeholder") ? (this.ui("vinField").removeClass("error"), this.ui("vinError").hide(), a._getSearchResults(b)) : (this.ui("vinField").addClass("error"), this.ui("vinError").show())
		},
		_getSearchResults: function (b) {
			var c = this;
			c._hideErrors(), this._clearResultsList(), a.ajax({
				type: "GET",
				url: c._ajaxURL(),
				data: {
					view: "vinRecallQuery",
					vin: b
				},
				dataType: "json",
				beforeSend: function () {
					c._toggleUI(!0)
				},
				statusCode: {
					200: function (b) {
						if (!c._isLocalTests(b)) {
							if (204 === b.error) return void c._showResultsError(b);
							c._results = b.results, a("p", c.ui("resultsHeader")).html(b.totalRecalls), a("h3", c.ui("resultsHeader")).html(b.model + " " + b.vehicle), a("h5", c.ui("resultsHeader")).show().html(b.vin), c._renderResults(), c._animateDown()
						}
					},
					400: function (a) {
						c._showInvalidVinError(a)
					}
				}
			}).fail(function (a) {
				400 === a.status || 204 === a.status || site.localEnv || c._showServerError(a.responseText)
			}).always(function () {
				c._toggleUI(!1)
			})
		},
		_renderResults: function () {
			var b, c, d = this,
				e = "";
			this._clearResultsList(), this._hideErrors();
			for (b in d._results) c = "", "undefined" != typeof d._results[b].date && (c = this.ui("resultsTemplate").html().replace(/%NUMBER%/, d._results[b].number), c = c.replace(/%MANUFACTURERNUMBER%/, d._results[b].manufacturerRecallNumber), c = c.replace(/%DATE%/, d._results[b].date), c = c.replace(/%RECALLDESC%/, d._results[b].recallDesc), c = c.replace(/%SAFETYDESC%/, d._results[b].safetyDescription), c = c.replace(/%REPAIRDESC%/, d._results[b].repairDesc), c = c.replace(/%STATUS%/, d._results[b].status), e += c);
			this.ui("resultsList").html(e), this._hidePhoneNumbers(), a(".ResponsiveLink").ResponsiveLink()
		},
		_hidePhoneNumbers: function () {
			a("a[href^='tel:']", this.$element).addClass("phonenumber").off("click tap").on("click tap", function (c) {
				a(b).width() >= site.breakpoints.medium && c.preventDefault()
			})
		},
		_enableVinInfo: function () {
			var b = this.ui("vinLink").html();
			this.ui("vinLink").replaceWith(a('<a href="#" class="vinLink">' + b + "</a>")), this.registerEvent(this, "click tap .vinLink", "_toggleVinInfo")
		},
		_toggleVinInfo: function (b) {
			var c = a(b.target);
			this.ui("vinInfo").is(":animated") || (c.toggleClass("active"), c.next(".vinInfo").slideToggle())
		},
		_animateDown: function () {
			this.ui("results").show(), site.utils.scrollTo(this.ui("results"))
		},
		_getYearsForVehicle: function (b) {
			var c = this;
			a.ajax({
				type: "GET",
				url: c._yearsURL(),
				data: {
					view: "vinRecallYearsForVehicle",
					vehicle: this.ui("vehicleSelect").val()
				},
				dataType: "json",
				statusCode: {
					200: function (d) {
						if ("undefined" != typeof d.error) return void(204 === d.error ? c._showResultsError() : c._showServerError());
						var e = "";
						for (var f in d) e += '<option value="' + f + '">' + d[f] + "</option>";
						a("option:not(:first)", c.ui("yearSelect")).remove(), a("option", c.ui("yearSelect")).after(e), b()
					}
				}
			}).fail(function () {
				c._showServerError()
			})
		},
		_toggleSearchButton: function () {
			a.trim(this.ui("vinField").val()).length > 0 ? this.ui("searchBtn").removeAttr("disabled").removeClass("disabled") : (this.ui("searchBtn").attr("disabled", "disabled").addClass("disabled"), this.ui("vinField").removeClass("error"), this.ui("responseInvalid").hide())
		},
		_clearResultsList: function () {
			this.ui("resultsList").html("")
		},
		_hideErrors: function () {
			this.ui("responseNoResults").hide(), this.ui("responseProblem").hide(), this.ui("responses").hide(), this.ui("responseInvalid").hide(), this.ui("results").hide()
		},
		_showInvalidVinError: function (b) {
			this.ui("vinField").addClass("error"), a("h3", this.ui("responseInvalid")).html(b.errorTitle), a("p", this.ui("responseInvalid")).html(b.errorMessage), this.ui("responseInvalid").show(), this._hidePhoneNumbers()
		},
		_showResultsError: function (b) {
			var c = this;
			a("h3", c.ui("responseNoResults")).html(b.model + " " + b.vehicle), b.vin ? a("h5", this.ui("responseNoResults")).html(b.vin).show() : a("h5", this.ui("responseNoResults")).html("").hide(), this.ui("responseNoResults").show(), this.ui("responses").show(), site.utils.scrollTo(this.ui("responses")), this._hidePhoneNumbers()
		},
		_showServerError: function (b) {
			var c = {
				errorTitle: "Sorry, there seems to be a problem",
				errorMessage: "Please try again later"
			};
			b = b || c, a("h3", this.ui("responseProblem")).html(b.errorTitle), a("h5", this.ui("responseProblem")).html(b.errorMessage), this.ui("responseProblem").show(), this.ui("responses").show(), site.utils.scrollTo(this.ui("responses")), this._hidePhoneNumbers()
		},
		_toggleUI: function (a) {
			a ? (this.ui("borderContainer").toggleWrapper(!0, "#ddd"), this.ui("vinField").attr("disabled", "disabled")) : (this.ui("borderContainer").toggleWrapper(!1), this.ui("vinField").removeAttr("disabled"))
		},
		_isLocalTests: function (a) {
			return site.localEnv ? 204 === a.error ? (this._showResultsError(a), !0) : 400 === a.error ? (this._showInvalidVinError(a), !0) : 500 === a.error ? (this._showServerError(a), !0) : !1 : !1
		},
		_resetSearch: function () {
			var a = this;
			a.ui("vinField").val(""), a._toggleSearchButton()
		}
	};
	jQuery.createComponent("VinRecall", c)
}(jQuery, window, document), function (a, b) {
	var c = {
		_defaults: {
			expandToWidthOnly: !0,
			inGallery: !1
		},
		_touchDevice: !1,
		_onlyItem: !1,
		_aspectRatio: 16 / 9,
		_player: null,
		_waitingAPILoad: !1,
		_windowWidth: null,
		_windowHeight: null,
		init: function () {
			var c = this;
			"ontouchstart" in b ? this._touchDevice = !0 : navigator.msMaxTouchPoints && (this._touchDevice = !0), this._onlyItem = this.$element.parent().data("only-item"), this._deeplinkedItem = this.$element.parent().data("show"), "undefined" == typeof this._onlyItem && (this._onlyItem = !1), this._onlyItem === !0 || this._deeplinkedItem === !0 ? (this._addPlayer(1), this._hideCoverImage()) : this._touchDevice === !0 ? (this._addPlayer(0), this._hideCoverImage()) : this._bindCoverEvents(), this._onResize(), a(b).on("resize", function () {
				c._onResize()
			}), a(b).on("YouTubePlayerLoaded", function () {
				c._waitingAPILoad && c._addPlayer(1)
			}), a(b).on("VideoPlayerPause", function (b, d) {
				null !== d.videoid && d.videoid !== a(".placeholderVideo iframe", c.$element).attr("id") && "undefined" != typeof c._player && null !== c._player && c._player.pauseVideo()
			})
		},
		_addPlayer: function (c) {
			var d = this;
			if (d._player = null, site.youTubeIframeAPIReady) {
				var e = a(".placeholderVideo", this.$element),
					f = "https://www.youtube.com/embed/" + e.data("video-id") + "?autoplay=" + c + "&rel=0&showinfo=0&enablejsapi=1&wmode=opaque&iv_load_policy=3&color=white&probably_logged_in=0";
				navigator.userAgent.toLowerCase().indexOf("firefox") > -1 && (f += "&html5=1");
				var g = e.attr("id") + "Video";
				a(".placeholderVideo", this.$element).html('<iframe id="' + g + '" type="text/html" width="640" height="360" src="' + f + '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen>'), a(b).trigger("VideoPlayerPause", {
					videoid: g
				}), d._player = new YT.Player(g, {
					events: {
						onStateChange: function (c) {
							2 === c.data ? d.options.inGallery === !0 && site.utils.isIOS() && (a(".placeholderVideo", this.$element).empty(), d._addPlayer()) : c.data === YT.PlayerState.PLAYING && null !== g && a(b).trigger("VideoPlayerPause", {
								videoid: g
							})
						}
					}
				})
			} else d._waitingAPILoad = !0, a.getScript("//www.youtube.com/iframe_api");
			a("body").append('<div class="temp">&nbsp;</div>'), a("iframe").load(function () {
				a(".temp").remove()
			})
		},
		_onResize: function () {
			var b = this;
			if (b._windowSizeChanged() === !0) {
				a(".playerWrapper", this.$element).css({
					height: "auto",
					width: "auto"
				});
				var c = this.$element.width(),
					d = this.$element.height(),
					e = Math.ceil(c / this._aspectRatio),
					f = "auto";
				this.options.expandToWidthOnly === !1 && e > d && (e = d, f = Math.ceil(d * this._aspectRatio)), a(".playerWrapper", this.$element).css({
					height: e,
					width: f
				})
			}
		},
		_windowSizeChanged: function () {
			var c = this,
				d = a(b).width(),
				e = a(b).height(),
				f = c._windowWidth,
				g = c._windowHeight;
			return c._windowWidth = d, c._windowHeight = e, d !== f || e !== g
		},
		_hideCoverImage: function () {
			a(".playerWrapper > a", this.$element).hide()
		},
		_bindCoverEvents: function () {
			var b = this;
			a(".playerWrapper > a", this.$element).off("click tap").on("click tap", function (a) {
				a.preventDefault(), a.stopPropagation(), b._addPlayer(1), b._hideCoverImage()
			})
		},
		_destroy: function () {
			this._player = null, a(".playerWrapper > a", this.$element).off("click tap"), a("iframe", this.$element).remove(), this._touchDevice === !1 && a(".playerWrapper > a", this.$element).show()
		}
	};
	jQuery.createComponent("YouTubePlayer", c)
}(jQuery, window, document), ("undefined" == typeof console || "undefined" == typeof console.log) && (console = {}, console.log = function () {});
var site = {
	scrollPosition: 0,
	scrollDirection: "up",
	youTubeIframeAPIReady: !1,
	rtl: !1,
	breakpoints: {
		small: 740,
		medium: 900
	},
	stickyNavigationTransitionPoint: 200,
	stickyNavigationEnabled: !1,
	localEnv: "localhost" === window.location.hostname ? !0 : !1,
	cookiesAccepted: !1,
	googleMapsAPIKey: "",
	init: function () {
		if ($("html").hasClass("lt-ie9")) {
			var a = document.getElementsByTagName("head")[0],
				b = document.createElement("style");
			b.type = "text/css", b.styleSheet.cssText = ":before,:after{content:none !important", a.appendChild(b), setTimeout(function () {
				a.removeChild(b)
			}, 0)
		}
		10 === document.documentMode && (document.documentElement.className += " ie10"), (window.ActiveXObject || "ActiveXObject" in window) && $("html").addClass("ie"), site.utils.isMobileDevice() && $("html").addClass("touchCapability"), $("html").hasClass("rtl") && (site.rtl = !0), Date.now = Date.now ||
		function () {
			return +new Date
		}, window.picturefill(), $("body").FocusSwitcher(), $(".NotificationBar").NotificationBar();
		var c = $("#header");
		site.stickyNavigationEnabled = "sticky" === c.attr("data-nav-type"), c.Header(), $(".MainNavigation").MainNavigation(), $(".SubNavigation").SubNavigation(), $(".DropdownNav").DropdownNav(), $(".InPageSubNavigation").InPageSubNavigation(), $(".InPageNavigation").InPageNavigation(), $(".DropdownSelect").DropdownSelect(), $(".ShoppingToolsMenu").ShoppingToolsDropdown({
			desktopMenuButton: ".ShoppingToolsButton > a",
			desktopMenu: ".ShoppingToolsDropdown"
		}), $(".SlideOutMenu").SlideOutMenu({
			deviceMenuButton: ".MainNavigation .MoreButton > a, .SlideOutMenu .MoreButton > a"
		}).on("swiperight", function (a) {
			a.preventDefault(), $(this).trigger("swipeMovement", "right")
		}).on("movestart", function (a) {
			(a.distX > a.distY && a.distX < -a.distY || a.distX < a.distY && a.distX > -a.distY) && a.preventDefault()
		}), $(".IgniteBar").IgniteBar(), $(".IgniteBarDevice").IgniteBarDevice(), $(".NavigationModelSwitcher").NavigationModelSwitcher({
			toggleButton: ".navigationModelSwitcherButton"
		});
		var d = $(".VehicleSelector:not(.inPageVehicleSelector)"),
			e = $(".VehicleSelector.inPageVehicleSelector"),
			f = $(".ModelSelector"),
			g = !0;
		1 === d.length && (g = !1, d.VehicleSelector({
			overlay: !1
		})), 0 !== e.length && e.VehicleSelector({
			overlay: !1
		}), g === !0 && 0 === $(".ModelSelector:not(.inPageModelSelector)").length && $(".MainNavigation .vehicles a").VehicleSelector({
			overlay: !0
		}), f.ModelSelector({
			overlay: !1
		}), d = null, f = null, $(".ReadyToGoBar").ReadyToGoBar(), $(".HeroCarousel").HeroCarousel(), $(".ScrollDown").ScrollDown(), $(".SidebarImage").SidebarImage(), $(".SameSizeCarousel").SameSizeCarousel(), $(".DualFrameCarousel").DualFrameCarousel(), $("table").filter(function () {
			return !$(this).hasClass("nonResponsive")
		}).ResponsiveTable(), $(".TabFilter", this.$element).TabFilter(), $(".FooterNav").FooterNav(), $(".MarketSelector").MarketSelector(), $(".MarketPageSelector").MarketPageSelector(), $(".FleetAndBusinessContacts").FleetAndBusinessContacts(), $(".LanguageSelector").LanguageSelector(), $(".InternationalDealerLocator").InternationalDealerLocator(), $(".InternationalDealerLocatorResults").InternationalDealerLocatorResults(), $(".NationalDealerLocator").NationalDealerLocator(), $(".InPageDealerLocator").InPageDealerLocator(), $(".NationalDealerLocatorResults").NationalDealerLocatorResults(), $(".VehicleSpecifications").VehicleSpecifications(), $(".SpecificationsAtAGlance").SpecificationsAtAGlance(), $(".AtAGlance").AtAGlance(), $(".StackedBlocks").StackedBlocks(), $(".VideoThumbnails").VideoThumbnails(), $(".Fullscreen").Fullscreen(), $(".SocialSharing").SocialSharing(), $(".Gallery").Gallery(), $(".Quote").Quote(), $(".QuotePlayer").QuotePlayer(), $(".YouTubePlayer").filter(function () {
			return 0 === $(this).parent(".galleryItem").length
		}).YouTubePlayer(), window.onYouTubeIframeAPIReady = function () {
			site.youTubeIframeAPIReady = !0, $(window).trigger("YouTubePlayerLoaded")
		}, $(".SearchResults").SearchResults(), $(".VideoPlayer").filter(function () {
			return $(this).parents(".heroItem").length < 1
		}).VideoPlayer({
			autoplay: !1,
			loop: !1
		}), site.utils.campaignTrackingPersistance.setTracking("GoogleCampaign", ["utm_source", "utm_medium", "utm_term", "keywords", "utm_content", "utm_campaign"]), $(".VinRecall").VinRecall(), $(".FramedContent").FramedContent(), $(".FullWidthImage").FullWidthImage(), $(".ResponsiveLink").ResponsiveLink(), $(".TargetLinks").TargetLinks(), $(".VideoLauncher").VideoLauncher(), $(".SocialFeed").SocialFeed(), $(".ExperienceCentres").ExperienceCentres(), $(window).debounce("scroll", function (a) {
			$(window).trigger({
				type: "throttledScroll",
				event: a
			})
		}, 250), $(window).smartresize(function () {
			window.picturefill()
		}), $(document).on("webkitfullscreenchange mozfullscreenchange fullscreenchange", function () {
			var a = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen;
			a ? $("#header, .FooterNav, .IgniteBar").hide() : $("#header, .FooterNav, .IgniteBar").show(), $(window).trigger("resize")
		}), deepLink.init()
	}
};
if (window.onpageshow = function (a) {
	a.persisted && window.location.reload()
}, "undefined" == typeof dataLayer) var dataLayer = {
	push: function () {}
};
site.tracking = {
	video_play: function (a) {
		var b = {
			event: "video",
			action: "play",
			video_id: a
		};
		dataLayer.push(b), console.log(b)
	},
	video_ended: function (a) {
		var b = {
			event: "video",
			action: "complete",
			video_id: a
		};
		dataLayer.push(b), console.log(b)
	}
}, site.utils = {
	cookieManager: {
		checkForCookie: function (a) {
			var b = this,
				c = b.readCookie(a);
			return null !== c ? !0 : !1
		},
		readCookie: function (a) {
			var b = document.cookie.split(";");
			if (b.length < 1) return null;
			for (var c = 0; c < b.length; c++) {
				var d = b[c].split("=");
				if (d[0].replace(/\s/g, "") == a) return d[1]
			}
			return null
		},
		createCookie: function (a, b, c) {
			var d = "";
			if (c) {
				var e = new Date;
				e.setTime(e.getTime() + 24 * c * 60 * 60 * 1e3), d = "; expires=" + e.toGMTString()
			} else d = "";
			document.cookie = a + "=" + b + d + "; path=/"
		},
		deleteCookie: function (a) {
			var b = this;
			b.createCookie(a, "", -1)
		}
	},
	geoLocationManager: {
		isGeoAvailable: function () {
			var a = this;
			return a._getIpGeoLocationData(), site.utils.isBreakpointSmall() && navigator.geolocation ? !0 : a._isServerGeoLocationAvailable()
		},
		getGeoLocation: function (a) {
			var b = this;
			site.utils.isBreakpointSmall() && navigator.geolocation ? navigator.geolocation.getCurrentPosition(function (c) {
				b._resolveLongLatLocation(c.coords.latitude, c.coords.longitude, a)
			}, function () {
				b._getIpGeoLocationData(a)
			}) : b._getIpGeoLocationData(a)
		},
		getNativeGeoLocation: function (a) {
			var b = this;
			navigator.geolocation && navigator.geolocation.getCurrentPosition(function (c) {
				b._resolveLongLatLocation(c.coords.latitude, c.coords.longitude, a)
			}, function () {
				a({
					error: "Geo location permission denied."
				})
			})
		},
		_getIpGeoLocationData: function (a) {
			var b = "//js.maxmind.com/js/apis/geoip2/v2.0/geoip2.js";
			$.getScript(b, function () {
				geoip2.country(function (b) {
					a({
						country_code: b.country.iso_code,
						country_name: b.country.names.en
					})
				}, function (a) {
					console.log(a)
				})
			})
		},
		_resolveLongLatLocation: function (a, b, c) {
			var d = this;
			$.ajax({
				url: window.location.protocol + "//maps.googleapis.com/maps/api/geocode/json?address=" + a + "," + b + "&key=" + site.googleMapsAPIKey + "&sensor=false",
				success: function (e) {
					if (e.results.length > 0) {
						var f = {};
						f.longitude = b, f.latitude = a;
						for (var g in e.results)"street_address" === e.results[g].types[0] && (f.city = e.results[g].formatted_address), "country" === e.results[g].types[0] && (f.country_code = e.results[g].address_components[0].short_name, f.country_name = e.results[g].address_components[0].long_name);
						c(f)
					} else d._getServerGeoLocationData(c)
				}
			})
		}
	},
	scrollTo: function (a, b, c) {
		var d = this,
			e = 0;
		b = "number" != typeof b ? 800 : b, c = "function" != typeof c ? null : c, "number" == typeof a ? e = a : ($targetEl = a || $("body"), e = $targetEl.offset().top), e -= d.getStickyNavHeight(e), $("html, body").stop().animate({
			scrollTop: e
		}, b, "easeOutSine", c)
	},
	getStickyNavHeight: function (a) {
		var b = this;
		a = "number" != typeof a ? 0 : a;
		var c = $("#header"),
			d = $(".InPageNavigation"),
			e = 0,
			f = (b.getBreakpointSize(), c.length > 0 ? "fixed" === c.css("position") : !1),
			g = d.length > 0 ? d.offset().top : null;
		return null !== g && a >= g ? e = d.outerHeight() : f && ($headerClone = c.clone(), $headerClone.css("position", "fixed"), $headerClone.css("left", "-99999px"), a > site.stickyNavigationTransitionPoint ? $headerClone.addClass("reducedStickyNavigation") : $headerClone.removeClass("reducedStickyNavigation"), $headerClone.appendTo("body"), e = $headerClone.outerHeight(), $headerClone.remove()), e
	},
	getHeaderHeight: function (a) {
		var b = this;
		a = "number" != typeof a ? 0 : a;
		var c = 0,
			d = $("#header"),
			e = b.getBreakpointSize(),
			f = site.stickyNavigationEnabled;
		return d && ("large" === e && f ? ($headerClone = d.clone(), $headerClone.css("position", "fixed"), $headerClone.css("left", "-99999px"), a > site.stickyNavigationTransitionPoint ? $headerClone.addClass("reducedStickyNavigation") : $headerClone.removeClass("reducedStickyNavigation"), $headerClone.appendTo("body"), c = $headerClone.outerHeight(), $headerClone.remove()) : c = d.height()), c
	},
	getDeviceOrientation: function () {
		var a = $(window),
			b = "portrait";
		return a.width() > a.height() && (b = "landscape"), b
	},
	getBreakpointSize: function () {
		var a = $(window).width();
		return a <= site.breakpoints.small ? "small" : a <= site.breakpoints.medium ? "medium" : "large"
	},
	isBreakpointSmall: function () {
		var a = this;
		return "small" == a.getBreakpointSize() ? !0 : !1
	},
	isBreakpointMedium: function () {
		var a = this;
		return "medium" == a.getBreakpointSize() ? !0 : !1
	},
	isMobileDevice: function () {
		var a;
		return a = "ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch || navigator.msMaxTouchPoints ? !0 : !1
	},
	isIOS: function () {
		return /(ipad|iphone|ipod)/i.test(navigator.userAgent.toLowerCase())
	},
	removeHTMLTags: function (a) {
		var b = a.toString().replace(/[<>=;]/g, "");
		return b
	},
	getUrlParameter: function (a) {
		for (var b = window.location.search.substring(1), c = b.split("&"), d = 0; d < c.length; d++) {
			var e, f = c[d].split("=");
			if (f[0] === a) {
				e = f[1];
				break
			}
			e = !1
		}
		return e
	},
	addParameterToURL: function (a, b) {
		return "" != b && (a += (a.split("?")[1] ? "&" : "?") + b), a
	},
	campaignTrackingPersistance: {
		setTracking: function (a, b) {
			for (var c = {}, d = 0; d < b.length; d++) {
				var e = b[d],
					f = site.utils.getUrlParameter(e);
				f && (c[e] = f)
			}
			if (site.utils.getObjectKeys(c).length > 0) {
				var g = "JLR_Campaign_Tracking_" + a;
				site.utils.cookieManager.deleteCookie(g), site.utils.cookieManager.createCookie(g, JSON.stringify(c))
			}
		},
		getTracking: function (a) {
			var b = "JLR_Campaign_Tracking_" + a,
				c = "";
			return site.utils.cookieManager.readCookie(b) && (c = $.param($.parseJSON(site.utils.cookieManager.readCookie(b)))), c
		}
	},
	getObjectKeys: function (a) {
		var b = [];
		for (var c in a) a.hasOwnProperty(c) && b.push(c);
		return b
	}
};
