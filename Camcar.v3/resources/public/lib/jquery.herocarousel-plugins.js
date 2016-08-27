/*
 * 	Author:		Connect Group
 * 	Website:	connect-group.com
 *
 * 	Title:		LRDX
 * 	Build:		2015-01-19 11:11:33
 *
 */
function onYouTubePlayerAPIReady() {
	mejs.YouTubeApi.iFrameReady()
}
function onYouTubePlayerReady(a) {
	mejs.YouTubeApi.flashReady(a)
}!
function (a) {
	var b = 0,
		c = {
			resizeMaxTry: 4,
			resizeWaitTime: 50,
			minimumHeight: 50,
			defaultHeight: 1500,
			heightOffset: 0,
			exceptPages: "",
			debugMode: !1,
			visibilitybeforeload: !1,
			blockCrossDomain: !1,
			externalHeightName: "bodyHeight",
			onMessageFunctionName: "getHeight",
			domainName: "*",
			watcher: !1,
			watcherTime: 400
		};
	a.iframeHeight = function (c, d) {
		var e = this;
		e.resizeEventsOnce = !1, a.iframeHeight.resizeTimeout = null, a.iframeHeight.resizeCount = 0, e.$el = a(c), e.el = c, e.$el.before("<div id='iframeHeight-Container-" + b + "' style='padding: 0; margin: 0; border: none; background-color: transparent;'></div>"), e.$el.appendTo("#iframeHeight-Container-" + b), e.$container = a("#iframeHeight-Container-" + b), e.$el.data("iframeHeight", e), e.watcher = null, e.debug = {
			FirstTime: !0,
			Init: function () {
				"console" in window || (console = {}), "log info warn error dir clear".replace(/\w+/g, function (a) {
					a in console || (console[a] = console.log || new Function)
				})
			},
			Log: function (a) {
				this.FirstTime && this.FirstTime === !0 && (this.Init(), this.FirstTime = !1), e.options.debugMode && e.options.debugMode === !0 && console && (null !== a || "" !== a) && console.log("Iframe Plugin : " + a)
			},
			GetBrowserInfo: function (a) {
				var b, c, d = function (a) {
					a = a.toLowerCase();
					var b = /(chrome)[ \/]([\w.]+)/.exec(a) || /(webkit)[ \/]([\w.]+)/.exec(a) || /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(a) || /(msie) ([\w.]+)/.exec(a) || a.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(a) || [];
					return {
						browserObj: b[1] || "",
						version: b[2] || "0"
					}
				};
				return b = d(navigator.userAgent), c = {
					chrome: !1,
					safari: !1,
					mozilla: !1,
					msie: !1,
					webkit: !1
				}, b.browserObj && (c[b.browserObj] = !0, c.version = b.version), c.chrome ? c.webkit = !0 : c.webkit && (c.safari = !0), a = c
			}(this.GetBrowserInfo || {})
		};
		var f = function () {
			try {
				var a;
				return a = e.debug.GetBrowserInfo.msie && "7.0" == e.debug.GetBrowserInfo.version ? e.$el.get(0).contentWindow.location.href : e.$el.get(0).contentDocument.location.href, e.debug.Log("This page is non-Cross Domain - " + a), !1
			} catch (b) {
				return e.debug.Log("This page is Cross Domain"), !0
			}
		};
		e.resetIframe = function () {
			!e.options.visibilitybeforeload || e.debug.GetBrowserInfo.msie && "7.0" == e.debug.GetBrowserInfo.version || e.$el.css("visibility", "hidden"), e.debug.Log("Old Height is " + e.$el.height() + "px"), e.$el.css("height", "").removeAttr("height"), e.debug.Log("Reset iframe"), e.debug.Log("Height is " + e.$el.height() + "px after reset")
		}, e.resizeFromOutside = function (b) {
			if (e.options.blockCrossDomain) return e.debug.Log("Blocked cross domain fix"), !1;
			if ("undefined" == typeof b) return !1;
			if ("string" != typeof b.data) return !1;
			if ("reset" == b.data) e.$el.css("height", "").removeAttr("height");
			else {
				if (!/^ifh*/.test(b.data)) return !1;
				if (e.resizeEventsOnce || (e.resizeEventsOnce = !0, a(window).resize(function () {
					e.$el.trigger("updateIframe")
				}), window.setTimeout(function () {
					e.resetIframe(), e.$el.trigger("updateIframe")
				}, 100)), e.$el.attr("scrolling", "no"), e.debug.Log("resizeFromOutside " + b.data), "number" != typeof parseInt(b.data.substring(3))) return !1;
				var c = parseInt(b.data.substring(3)) + parseInt(e.options.heightOffset);
				!e.options.visibilitybeforeload || e.debug.GetBrowserInfo.msie && "7.0" == e.debug.GetBrowserInfo.version || e.$el.css("visibility", "hidden"), e.$el.css("height", "").removeAttr("height"), e.debug.Log("resizeFromOutside " + c), e.resetIframe(), e.setIframeHeight(c)
			}
			return !0
		}, e.checkMessageEvent = function () {
			if (e.options.blockCrossDomain || e.debug.GetBrowserInfo.msie && "7.0" == e.debug.GetBrowserInfo.version) return e.debug.Log("Blocked cross domain fix"), !1;
			!e.options.visibilitybeforeload || e.debug.GetBrowserInfo.msie && "7.0" == e.debug.GetBrowserInfo.version || e.$el.css("visibility", "visible"), window.addEventListener ? window.addEventListener("message", e.resizeFromOutside, !1) : window.attachEvent && window.attachEvent("onmessage", e.resizeFromOutside), e.$el.id || (e.$el.id = "iframe-id-" + ++b);
			var a = document.getElementById(e.$el.attr("id")),
				c = e.options.onMessageFunctionName;
			return a.contentWindow.postMessage ? (a.contentWindow.postMessage(c, "*"), e.debug.Log("Cross Domain Iframe started"), !0) : (e.debug.Log("Your browser does not support the postMessage method!"), !1)
		};
		var g = function () {
			a.iframeHeight.resizeCount <= e.options.resizeMaxTry ? (a.iframeHeight.resizeCount++, a.iframeHeight.resizeTimeout = setTimeout(a.iframeHeight.resizeIframe, e.options.resizeWaitTime), e.debug.Log(a.iframeHeight.resizeCount + " time(s) tried")) : (clearTimeout(a.iframeHeight.resizeTimeout), a.iframeHeight.resizeCount = 0, e.debug.Log("set default height for iframe"), e.setIframeHeight(e.options.defaultHeight + e.options.heightOffset))
		};
		e.sendInfotoTop = function () {
			if (top.length > 0 && "undefined" != typeof JSON) {
				var b = {};
				b[e.options.externalHeightName].value = a(document).height();
				var c = "*";
				return b = JSON.stringify(b), top.postMessage(b, c), e.debug.Log("sent info to top page"), !1
			}
			return !0
		}, e.setIframeHeight = function (a) {
			e.$el.height(a).css("height", a), e.$el.data("iframeheight") != a && e.$container.height(a).css("height", a), !e.options.visibilitybeforeload || e.debug.GetBrowserInfo.msie && "7.0" == e.debug.GetBrowserInfo.version || e.$el.css("visibility", "visible"), e.debug.Log("Now iframe height is " + a + "px"), e.$el.data("iframeheight", a)
		}, a.iframeHeight.resizeIframe = function () {
			if (f()) e.debug.Log("options height : " + e.options.defaultHeight), !e.options.visibilitybeforeload || e.debug.GetBrowserInfo.msie && "7.0" == e.debug.GetBrowserInfo.version || e.$el.css("visibility", "visible"), e.checkMessageEvent();
			else if (e.$el.css("height") === e.options.minimumHeight + "px", null !== e.$el.get(0).contentWindow.document.body) {
				e.debug.Log("This page has body info");
				var b = a(e.$el.get(0).contentWindow.document).height(),
					c = e.$el.get(0).contentWindow.document.location.pathname.substring(e.$el.get(0).contentWindow.document.location.pathname.lastIndexOf("/") + 1).toLowerCase();
				e.debug.Log("page height : " + b + "px || page name : " + c), b <= e.options.minimumHeight && -1 == e.options.exceptPages.indexOf(c) ? g() : b > e.options.minimumHeight && -1 == e.options.exceptPages.indexOf(c) && e.setIframeHeight(b + e.options.heightOffset)
			} else e.debug.Log("This page has not body info"), g()
		}, this.$el.bind("updateIframe", function () {
			a.iframeHeight.resizeIframe(), e.debug.Log("Updated Iframe Manually")
		}), this.$el.bind("killWatcher", function () {
			window.clearInterval(e.watcher), e.debug.Log("Killed Watcher")
		}), e.init = function () {
			return e.options = a.extend({}, a.iframeHeight.defaultOptions, d), 1 == e.options.watcher && (e.options.blockCrossDomain = !0), e.debug.Log(e.options), void 0 === e.$el.get(0).tagName || "iframe" !== e.$el.get(0).tagName.toLowerCase() ? (e.debug.Log("This element is not iframe!"), !1) : (a.iframeHeight.resizeIframe(), e.$el.load(function () {
				a.iframeHeight.resizeIframe()
			}), e.options.watcher && (e.watcher = setInterval(function () {
				e.debug.Log("Checked Iframe")
			}, e.options.watcherTime)), !0)
		}, e.init()
	}, a.iframeHeight.defaultOptions = c, a.fn.iframeHeight = function (b) {
		return this.each(function () {
			new a.iframeHeight(this, b)
		})
	}, a.iframeHeightExternal = function () {
		function b(b) {
			var d;
			if ("domain" in b && (d = b.domain), "origin" in b && (base.debug.Log(b.origin), d = b.origin), "*" !== c.domainName && d !== c.domainName) return void a.iframeHeight.debug.Log("It's not same domain. Blocked!");
			if (b.data == c.onMessageFunctionName) {
				var e = "ifh" + a(document).height();
				b.source.postMessage(e, b.origin)
			}
		}
		return 1 === arguments.length && a.isPlainObject(arguments[0]) && (c = arguments[0]), window.addEventListener ? window.addEventListener("message", b, !1) : window.attachEvent && window.attachEvent("onmessage", b), {
			update: function () {
				this.reset(), window.__domainname = c.domainName, setTimeout(function () {
					var b = "ifh" + a(document).height();
					parent.postMessage(b, window.__domainname)
				}, 90)
			},
			reset: function () {
				parent.postMessage("reset", c.domainName)
			}
		}
	}
}(jQuery), function (a) {
	function b(a, b) {
		var c, d, e = this;
		return function () {
			return d = Array.prototype.slice.call(arguments, 0), c = clearTimeout(c, d), c = setTimeout(function () {
				a.apply(e, d), c = 0
			}, b), this
		}
	}
	a.extend(a.fn, {
		debounce: function (a, c, d) {
			this.bind(a, b.apply(this, [c, d]))
		}
	})
}(jQuery), function (a, b, c) {
	function d(b, c) {
		this.$element = a(b), this.options = a.extend({}, f, c), this._defaults = f, this._name = e, this._$button = this.options.buttonWithinMenu === !0 ? a(this.options.button, this.$element) : a(this.options.button), this._menuitem = null, this.init(this)
	} {
		var e = "Dropdown",
			f = {
				timeout: 500,
				button: null,
				buttonWithinMenu: !1,
				closeOnTapOutside: !0,
				closeOnTapOutsideExclude: null,
				openByDefault: !1,
				onClose: function () {},
				onOpen: function () {}
			};
		"ontouchstart" in b || b.DocumentTouch && c instanceof DocumentTouch
	}
	d.prototype = {
		init: function () {
			var a = this;
			a.options.openByDefault === !0 && (a._menuitem = a.$element), a._$button.on("click tap", function (b) {
				b.preventDefault(), a._toggle(a), b.stopPropagation()
			}), a.$element.on("open", function () {
				a._openMenu(a)
			}), a.$element.on("close", {
				that: a
			}, function (b, c) {
				a._closeMenu(a, c)
			})
		},
		_openMenu: function (b) {
			b.$element.hasClass("animating") || (b._menuitem = b.$element, b.options.onOpen(), b.options.closeOnTapOutside === !0 && a("body").children().on("click tap touchstart", {
				that: b
			}, function (c) {
				0 !== a(c.target).not(b.options.closeOnTapOutsideExclude).length && setTimeout(function () {
					b._closeMenu(c)
				}, 100)
			}))
		},
		_closeMenu: function (b, c) {
			if ("undefined" != typeof b) {
				var d = null;
				if (d = "undefined" != typeof b.data ? b.data.that : b, "undefined" != typeof d.$element && !d.$element.hasClass("animating") && null !== d._menuitem) {
					if ("undefined" != typeof b.target) {
						var e = !1;
						return jQuery.each(d._$button, function (c, d) {
							a(b.target)[0] == d && (e = !0)
						}), e === !0 ? void b.stopPropagation() : a(b.target).closest(d.$element).length > 0 ? void b.stopPropagation() : (b.stopPropagation(), a("body").children().off("click tap touchstart", d._closeMenu), d._menuitem = null, void d.options.onClose(c))
					}
					a("body").children().off("click tap touchstart", d._closeMenu), d._menuitem = null, d.options.onClose(c)
				}
			}
		},
		_toggle: function (a) {
			null !== a._menuitem ? a._closeMenu(a) : a._openMenu(a)
		}
	}, a.fn[e] = function (b) {
		return this.each(function () {
			a.data(this, e) || a.data(this, e, new d(this, b))
		})
	}
}(jQuery, window, document), function (a) {
	function b() {
		this.isField = !0, this.down = !1, this.inFocus = !1, this.disabled = !1, this.cutOff = !1, this.hasLabel = !1, this.keyboardMode = !1, this.nativeTouch = !0, this.wrapperClass = "dropdown", this.onChange = null
	}
	b.prototype = {
		constructor: b,
		instances: {},
		init: function (b, c) {
			var d = this;
			a.extend(d, c), d.$select = a(b), d.id = b.id, d.options = [], d.$options = d.$select.find("option"), d.isTouch = "ontouchend" in document, d.$select.removeClass(d.wrapperClass + " dropdown"), d.$select.is(":disabled") && (d.disabled = !0), d.$options.length && (d.$options.each(function (b) {
				var c = a(this);
				c.is(":selected") && (d.selected = {
					index: b,
					title: c.text()
				}, d.focusIndex = b), c.hasClass("label") && 0 == b ? (d.hasLabel = !0, d.label = c.text(), c.attr("value", "")) : d.options.push({
					domNode: c[0],
					title: c.text(),
					value: c.val(),
					selected: c.is(":selected")
				})
			}), d.selected || (d.selected = {
				index: 0,
				title: d.$options.eq(0).text()
			}, d.focusIndex = 0), d.render())
		},
		render: function () {
			var b = this,
				c = b.isTouch && b.nativeTouch ? " touch" : "",
				d = b.disabled ? " disabled" : "";
			b.$container = b.$select.wrap('<div class="' + b.wrapperClass + c + d + '"><span class="old"/></div>').parent().parent(), b.$active = a('<span class="selected">' + b.selected.title + "</span>").appendTo(b.$container), b.$iconUp = a('<i class="icon-chevron-up"/>').appendTo(b.$container), b.$iconDown = a('<i class="icon-chevron-down"/>').appendTo(b.$container), b.$scrollWrapper = a("<div><ul/></div>").appendTo(b.$container), b.$dropDown = b.$scrollWrapper.find("ul"), b.$form = b.$container.closest("form"), a.each(b.options, function () {
				var a = this,
					c = a.selected ? ' class="active"' : "";
				b.$dropDown.append("<li" + c + ">" + a.title + "</li>")
			}), b.$items = b.$dropDown.find("li"), b.cutOff && b.$items.length > b.cutOff && b.$container.addClass("scrollable"), b.getMaxHeight(), b.isTouch && b.nativeTouch ? b.bindTouchHandlers() : b.bindHandlers()
		},
		getMaxHeight: function () {
			var a = this;
			for (a.maxHeight = 0, i = 0; i < a.$items.length; i++) {
				var b = a.$items.eq(i);
				if (a.maxHeight += b.outerHeight(), a.cutOff == i + 1) break
			}
		},
		bindTouchHandlers: function () {
			var b = this;
			b.$container.on("click.easyDropDown", function () {
				b.$select.focus()
			}), b.$select.on({
				change: function () {
					var c = a(this).find("option:selected"),
						d = c.text(),
						e = c.val();
					b.$active.text(d), "function" == typeof b.onChange && b.onChange.call(b.$select[0], {
						title: d,
						value: e
					})
				},
				focus: function () {
					b.$container.addClass("focus")
				},
				blur: function () {
					b.$container.removeClass("focus")
				}
			})
		},
		bindHandlers: function () {
			var b = this;
			b.query = "", b.$container.on({
				"click.easyDropDown": function () {
					b.down || b.disabled ? b.close() : b.open()
				},
				"mousemove.easyDropDown": function () {
					b.keyboardMode && (b.keyboardMode = !1)
				}
			}), a("body").on("click.easyDropDown." + b.id, function (c) {
				var d = a(c.target),
					e = b.wrapperClass.split(" ").join(".");
				!d.closest("." + e).length && b.down && b.close()
			}), b.$items.on({
				"click.easyDropDown": function () {
					var c = a(this).index();
					b.select(c), b.$select.focus()
				},
				"mouseover.easyDropDown": function () {
					if (!b.keyboardMode) {
						var c = a(this);
						c.addClass("focus").siblings().removeClass("focus"), b.focusIndex = c.index()
					}
				},
				"mouseout.easyDropDown": function () {
					b.keyboardMode || a(this).removeClass("focus")
				}
			}), b.$select.on({
				"focus.easyDropDown": function () {
					b.$container.addClass("focus"), b.inFocus = !0
				},
				"blur.easyDropDown": function () {
					b.$container.removeClass("focus"), b.inFocus = !1
				},
				"keydown.easyDropDown": function (a) {
					if (b.inFocus) {
						b.keyboardMode = !0;
						var c = a.keyCode;
						if ((38 == c || 40 == c || 32 == c) && (a.preventDefault(), 38 == c ? (b.focusIndex--, b.focusIndex = b.focusIndex < 0 ? b.$items.length - 1 : b.focusIndex) : 40 == c && (b.focusIndex++, b.focusIndex = b.focusIndex > b.$items.length - 1 ? 0 : b.focusIndex), b.down || b.open(), b.$items.removeClass("focus").eq(b.focusIndex).addClass("focus"), b.cutOff && b.scrollToView(), b.query = ""), b.down) if (9 == c || 27 == c) b.close();
						else {
							if (13 == c) return a.preventDefault(), b.select(b.focusIndex), b.close(), !1;
							if (8 == c) return a.preventDefault(), b.query = b.query.slice(0, -1), b.search(), clearTimeout(b.resetQuery), !1;
							if (38 != c && 40 != c) {
								var d = String.fromCharCode(c);
								b.query += d, b.search(), clearTimeout(b.resetQuery)
							}
						}
					}
				},
				"keyup.easyDropDown": function () {
					b.resetQuery = setTimeout(function () {
						b.query = ""
					}, 1200)
				}
			}), b.$dropDown.on("scroll.easyDropDown", function () {
				b.$dropDown[0].scrollTop >= b.$dropDown[0].scrollHeight - b.maxHeight ? b.$container.addClass("bottom") : b.$container.removeClass("bottom")
			}), b.$form.length && b.$form.on("reset.easyDropDown", function () {
				var a = b.hasLabel ? b.label : b.options[0].title;
				b.$active.text(a)
			})
		},
		unbindHandlers: function () {
			var b = this;
			b.$container.add(b.$select).add(b.$items).add(b.$form).add(b.$dropDown).off(".easyDropDown"), a("body").off("." + b.id)
		},
		open: function () {
			{
				var a = this;
				window.scrollY || document.documentElement.scrollTop, window.scrollX || document.documentElement.scrollLeft
			}
			a.closeAll(), a.getMaxHeight(), a.$select.focus(), a.$container.addClass("open"), a.$scrollWrapper.css("height", a.maxHeight + "px"), a.down = !0
		},
		close: function () {
			var a = this;
			a.$iconUp.css("display", "none"), a.$iconDown.css("display", "block"), a.$container.removeClass("open"), a.$scrollWrapper.css("height", "0px"), a.focusIndex = a.selected.index, a.query = "", a.down = !1
		},
		closeAll: function () {
			var a = this,
				b = Object.getPrototypeOf(a).instances;
			for (var c in b) {
				var d = b[c];
				d.close()
			}
		},
		select: function (a) {
			var b = this;
			"string" == typeof a && (a = b.$select.find("option[value=" + a + "]").index() - 1);
			var c = b.options[a],
				d = b.hasLabel ? a + 1 : a;
			b.$items.removeClass("active").eq(a).addClass("active"), b.$active.text(c.title), b.$select.find("option").removeAttr("selected").eq(d).prop("selected", !0).parent().trigger("change"), b.selected = {
				index: a,
				title: c.title
			}, b.focusIndex = i, "function" == typeof b.onChange && b.onChange.call(b.$select[0], {
				title: c.title,
				value: c.value
			})
		},
		search: function () {
			var a = this,
				b = function (b) {
					a.focusIndex = b, a.$items.removeClass("focus").eq(a.focusIndex).addClass("focus"), a.scrollToView()
				},
				c = function (b) {
					return a.options[b].title.toUpperCase()
				};
			for (i = 0; i < a.options.length; i++) {
				var d = c(i);
				if (0 == d.indexOf(a.query)) return void b(i)
			}
			for (i = 0; i < a.options.length; i++) {
				var d = c(i);
				if (d.indexOf(a.query) > -1) {
					b(i);
					break
				}
			}
		},
		scrollToView: function () {
			var a = this;
			if (a.focusIndex >= a.cutOff) {
				var b = a.$items.eq(a.focusIndex),
					c = b.outerHeight() * (a.focusIndex + 1) - a.maxHeight;
				a.$dropDown.scrollTop(c)
			}
		},
		notInViewport: function (a) {
			var b = this,
				c = {
					min: a,
					max: a + (window.innerHeight || document.documentElement.clientHeight)
				},
				d = b.$dropDown.offset().top + b.maxHeight;
			return d >= c.min && d <= c.max ? 0 : d - c.max + 5
		},
		destroy: function () {
			var a = this;
			a.unbindHandlers(), a.$select.unwrap().siblings().remove(), a.$select.unwrap(), delete Object.getPrototypeOf(a).instances[a.$select[0].id]
		},
		disable: function () {
			var a = this;
			a.disabled = !0, a.$container.addClass("disabled"), a.$select.attr("disabled", !0), a.down || a.close()
		},
		enable: function () {
			var a = this;
			a.disabled = !1, a.$container.removeClass("disabled"), a.$select.attr("disabled", !1)
		}
	};
	var c = function (a, c) {
		a.id = a.id ? a.id : "EasyDropDown" + d();
		var e = new b;
		e.instances[a.id] || (e.instances[a.id] = e, e.init(a, c))
	},
		d = function () {
			return ("00000" + (16777216 * Math.random() << 0).toString(16)).substr(-6).toUpperCase()
		};
	a.fn.easyDropDown = function () {
		var a, d = arguments,
			e = [];
		return a = this.each(function () {
			if (d && "string" == typeof d[0]) {
				var a = b.prototype.instances[this.id][d[0]](d[1], d[2]);
				a && e.push(a)
			} else c(this, d[0])
		}), e.length ? e.length > 1 ? e : e[0] : a
	}, a(function () {
		"function" != typeof Object.getPrototypeOf && (Object.getPrototypeOf = "object" == typeof "test".__proto__ ?
		function (a) {
			return a.__proto__
		} : function (a) {
			return a.constructor.prototype
		}), a("select.dropdown").each(function () {
			var b = a(this).attr("data-settings");
			settings = b ? a.parseJSON(b) : {}, c(this, settings)
		})
	})
}(jQuery), jQuery.easing.jswing = jQuery.easing.swing, jQuery.extend(jQuery.easing, {
	def: "easeOutQuad",
	easeOutSine: function (a, b, c, d, e) {
		return d * Math.sin(b / e * (Math.PI / 2)) + c
	}
});
var deepLink = function (a, b) {
	var c, d, e = function () {
		_getElement(), _jumpToElement(), _startUpdating(), _addTimeout(), _addEvents()
	};
	_getElement = function () {
		location.hash && ($element = $(location.hash), $element.length > 0 && (c = $element))
	}, _jumpToElement = function () {
		c && site.utils.scrollTo(c, 0)
	}, _startUpdating = function () {
		c && (d = setInterval(_jumpToElement, 10))
	}, _stopUpdating = function () {
		clearInterval(d), _removeEvents()
	}, _addEvents = function () {
		$(b).on("click tap mousewheel", _stopUpdating)
	}, _removeEvents = function () {
		$(b).off("click tap mousewheel", _stopUpdating)
	}, _addTimeout = function () {
		setTimeout(_stopUpdating, 1e3)
	};
	var f = {
		init: e
	};
	return f
}(jQuery, window, document);
if (function (a) {
	a.fn.equalHeightColumns = function (b) {
		var c, d;
		return b = a.extend({}, a.equalHeightColumns.defaults, b), c = b.height, d = a(this), a(this).each(function () {
			b.children && (d = a(this).children(b.children)), b.height || (b.children ? d.each(function () {
				a(this).height() > c && (c = a(this).height())
			}) : a(this).height() > c && (c = a(this).height()))
		}), b.minHeight && c < b.minHeight && (c = b.minHeight), b.maxHeight && c > b.maxHeight && (c = b.maxHeight), d.animate({
			height: c
		}, b.speed), a(this)
	}, a.equalHeightColumns = {
		version: 1,
		defaults: {
			children: !1,
			height: 0,
			minHeight: 0,
			maxHeight: 0,
			speed: 0
		}
	}
}(jQuery), function (a) {
	a.fn.equalHeights = function () {
		var b = 0,
			c = a(this);
		return c.each(function () {
			var c = a(this).innerHeight();
			c > b && (b = c)
		}), c.css("height", b)
	}, a("[data-equal]").each(function () {
		var b = a(this),
			c = b.data("equal");
		b.find(c).equalHeights()
	})
}(jQuery), function (a) {
	"function" == typeof define && define.amd ? define(["jquery"], a) : a(jQuery)
}(function (a, b) {
	function c(a) {
		function b() {
			d ? (c(), J(b), e = !0, d = !1) : e = !1
		}
		var c = a,
			d = !1,
			e = !1;
		this.kick = function () {
			d = !0, e || b()
		}, this.end = function (a) {
			var b = c;
			a && (e ? (c = d ?
			function () {
				b(), a()
			} : a, d = !0) : a())
		}
	}
	function d() {
		return !0
	}
	function e() {
		return !1
	}
	function f(a) {
		a.preventDefault()
	}
	function g(a) {
		K[a.target.tagName.toLowerCase()] || a.preventDefault()
	}
	function h(a) {
		return 1 === a.which && !a.ctrlKey && !a.altKey
	}
	function i(a, b) {
		var c, d;
		if (a.identifiedTouch) return a.identifiedTouch(b);
		for (c = -1, d = a.length; ++c < d;) if (a[c].identifier === b) return a[c]
	}
	function j(a, b) {
		var c = i(a.changedTouches, b.identifier);
		if (c && (c.pageX !== b.pageX || c.pageY !== b.pageY)) return c
	}
	function k(a) {
		var b;
		h(a) && (b = {
			target: a.target,
			startX: a.pageX,
			startY: a.pageY,
			timeStamp: a.timeStamp
		}, G(document, L.move, l, b), G(document, L.cancel, m, b))
	}
	function l(a) {
		var b = a.data;
		s(a, b, a, n)
	}
	function m() {
		n()
	}
	function n() {
		H(document, L.move, l), H(document, L.cancel, m)
	}
	function o(a) {
		var b, c;
		K[a.target.tagName.toLowerCase()] || (b = a.changedTouches[0], c = {
			target: b.target,
			startX: b.pageX,
			startY: b.pageY,
			timeStamp: a.timeStamp,
			identifier: b.identifier
		}, G(document, M.move + "." + b.identifier, p, c), G(document, M.cancel + "." + b.identifier, q, c))
	}
	function p(a) {
		var b = a.data,
			c = j(a, b);
		c && s(a, b, c, r)
	}
	function q(a) {
		var b = a.data,
			c = i(a.changedTouches, b.identifier);
		c && r(b.identifier)
	}
	function r(a) {
		H(document, "." + a, p), H(document, "." + a, q)
	}
	function s(a, b, c, d) {
		var e = c.pageX - b.startX,
			f = c.pageY - b.startY;
		F * F > e * e + f * f || v(a, b, c, e, f, d)
	}
	function t() {
		return this._handled = d, !1
	}
	function u(a) {
		a._handled()
	}
	function v(a, b, c, d, e, f) {
		{
			var g, h;
			b.target
		}
		g = a.targetTouches, h = a.timeStamp - b.timeStamp, b.type = "movestart", b.distX = d, b.distY = e, b.deltaX = d, b.deltaY = e, b.pageX = c.pageX, b.pageY = c.pageY, b.velocityX = d / h, b.velocityY = e / h, b.targetTouches = g, b.finger = g ? g.length : 1, b._handled = t, b._preventTouchmoveDefault = function () {
			a.preventDefault()
		}, I(b.target, b), f(b.identifier)
	}
	function w(a) {
		var b = a.data.event,
			c = a.data.timer,
			d = j(a, b);
		d && (a.preventDefault(), b.targetTouches = a.targetTouches, z(b, d, a.timeStamp, c))
	}
	function x(a) {
		var b = a.data.event,
			c = a.data.timer,
			d = i(a.changedTouches, b.identifier);
		d && (y(b), A(b, c))
	}
	function y(a) {
		H(document, "." + a.identifier, w), H(document, "." + a.identifier, x)
	}
	function z(a, b, c, d) {
		var e = c - a.timeStamp;
		a.type = "move", a.distX = b.pageX - a.startX, a.distY = b.pageY - a.startY, a.deltaX = b.pageX - a.pageX, a.deltaY = b.pageY - a.pageY, a.velocityX = .3 * a.velocityX + .7 * a.deltaX / e, a.velocityY = .3 * a.velocityY + .7 * a.deltaY / e, a.pageX = b.pageX, a.pageY = b.pageY, d.kick()
	}
	function A(a, b, c) {
		b.end(function () {
			return a.type = "moveend", I(a.target, a), c && c()
		})
	}
	function B() {
		return G(this, "movestart.move", u), !0
	}
	function C() {
		return H(this, "dragstart drag", f), H(this, "mousedown touchstart", g), H(this, "movestart", u), !0
	}
	function D(a) {
		"move" !== a.namespace && "moveend" !== a.namespace && G(this, "dragstart." + a.guid + " drag." + a.guid, f, b, a.selector)
	}
	function E(a) {
		"move" !== a.namespace && "moveend" !== a.namespace && (H(this, "dragstart." + a.guid + " drag." + a.guid), H(this, "mousedown." + a.guid))
	}
	var F = 6,
		G = a.event.add,
		H = a.event.remove,
		I = function (b, c, d) {
			a.event.trigger(c, d, b)
		},
		J = function () {
			return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||
			function (a) {
				return window.setTimeout(function () {
					a()
				}, 25)
			}
		}(),
		K = {
			textarea: !0,
			input: !0,
			select: !0,
			button: !0
		},
		L = {
			move: "mousemove",
			cancel: "mouseup dragstart",
			end: "mouseup"
		},
		M = {
			move: "touchmove",
			cancel: "touchend",
			end: "touchend"
		};
	a.event.special.movestart = {
		setup: B,
		teardown: C,
		add: D,
		remove: E,
		_default: function (a) {
			var d, f;
			a._handled() && (d = {
				target: a.target,
				startX: a.startX,
				startY: a.startY,
				pageX: a.pageX,
				pageY: a.pageY,
				distX: a.distX,
				distY: a.distY,
				deltaX: a.deltaX,
				deltaY: a.deltaY,
				velocityX: a.velocityX,
				velocityY: a.velocityY,
				timeStamp: a.timeStamp,
				identifier: a.identifier,
				targetTouches: a.targetTouches,
				finger: a.finger
			}, f = {
				event: d,
				timer: new c(function () {
					I(a.target, d)
				})
			}, a.identifier === b ? G(a.target, "click", e) : (a._preventTouchmoveDefault(), G(document, M.move + "." + a.identifier, w, f), G(document, M.end + "." + a.identifier, x, f)))
		}
	}, a.event.special.move = {
		setup: function () {
			G(this, "movestart.move", a.noop)
		},
		teardown: function () {
			H(this, "movestart.move", a.noop)
		}
	}, a.event.special.moveend = {
		setup: function () {
			G(this, "movestart.moveend", a.noop)
		},
		teardown: function () {
			H(this, "movestart.moveend", a.noop)
		}
	}, G(document, "mousedown.move", k), G(document, "touchstart.move", o), "function" == typeof Array.prototype.indexOf && !
	function (a) {
		for (var b = ["changedTouches", "targetTouches"], c = b.length; c--;) - 1 === a.event.props.indexOf(b[c]) && a.event.props.push(b[c])
	}(a)
}), function (a) {
	"function" == typeof define && define.amd ? define(["jquery"], a) : a(jQuery)
}(function (a) {
	function b(a) {
		var b, c, d;
		b = a.target.offsetWidth, c = a.target.offsetHeight, d = {
			distX: a.distX,
			distY: a.distY,
			velocityX: a.velocityX,
			velocityY: a.velocityY,
			finger: a.finger
		}, a.distX > a.distY ? a.distX > -a.distY ? (a.distX / b > g.threshold || a.velocityX * a.distX / b * g.sensitivity > 1) && (d.type = "swiperight", f(a.currentTarget, d)) : (-a.distY / c > g.threshold || a.velocityY * a.distY / b * g.sensitivity > 1) && (d.type = "swipeup", f(a.currentTarget, d)) : a.distX > -a.distY ? (a.distY / c > g.threshold || a.velocityY * a.distY / b * g.sensitivity > 1) && (d.type = "swipedown", f(a.currentTarget, d)) : (-a.distX / b > g.threshold || a.velocityX * a.distX / b * g.sensitivity > 1) && (d.type = "swipeleft", f(a.currentTarget, d))
	}
	function c(b) {
		var c = a.data(b, "event_swipe");
		return c || (c = {
			count: 0
		}, a.data(b, "event_swipe", c)), c
	}
	var d = a.event.add,
		e = a.event.remove,
		f = function (b, c, d) {
			a.event.trigger(c, d, b)
		},
		g = {
			threshold: .4,
			sensitivity: 6
		};
	a.event.special.swipe = a.event.special.swipeleft = a.event.special.swiperight = a.event.special.swipeup = a.event.special.swipedown = {
		setup: function (a) {
			var a = c(this);
			if (!(a.count++ > 0)) return d(this, "moveend", b), !0
		},
		teardown: function () {
			var a = c(this);
			if (!(--a.count > 0)) return e(this, "moveend", b), !0
		},
		settings: g
	}
}), $(document).ready(function () {
	$("label.inlined + input.inlinedInputText").each(function () {
		setTimeout(function () {
			$("input.inlinedInputText").val() || $(this).prev().addClass("has-text")
		}, 200), $(this).keydown(function () {
			$(this).prev("label.inlined").addClass("has-text")
		}), $(this).blur(function () {
			"" === $(this).val() && $(this).prev("label.inlined").removeClass("has-text")
		})
	})
}), function (a, b, c) {
	"$:nomunge";

	function d() {
		e = b[h](function () {
			f.each(function () {
				var b = a(this),
					c = b.width(),
					d = b.height(),
					e = a.data(this, j);
				(c !== e.w || d !== e.h) && b.trigger(i, [e.w = c, e.h = d])
			}), d()
		}, g[k])
	}
	var e, f = a([]),
		g = a.resize = a.extend(a.resize, {}),
		h = "setTimeout",
		i = "resize",
		j = i + "-special-event",
		k = "delay",
		l = "throttleWindow";
	g[k] = 250, g[l] = !0, a.event.special[i] = {
		setup: function () {
			if (!g[l] && this[h]) return !1;
			var b = a(this);
			f = f.add(b), a.data(this, j, {
				w: b.width(),
				h: b.height()
			}), 1 === f.length && d()
		},
		teardown: function () {
			if (!g[l] && this[h]) return !1;
			var b = a(this);
			f = f.not(b), b.removeData(j), f.length || clearTimeout(e)
		},
		add: function (b) {
			function d(b, d, f) {
				var g = a(this),
					h = a.data(this, j);
				h.w = d !== c ? d : g.width(), h.h = f !== c ? f : g.height(), e.apply(this, arguments)
			}
			if (!g[l] && this[h]) return !1;
			var e;
			return a.isFunction(b) ? (e = b, d) : (e = b.handler, void(b.handler = d))
		}
	}
}(jQuery, this), function (a, b) {
	function c(a, b, c) {
		var d = a.children(),
			e = !1;
		a.empty();
		for (var g = 0, h = d.length; h > g; g++) {
			var i = d.eq(g);
			if (a.append(i), c && a.append(c), f(a, b)) {
				i.remove(), e = !0;
				break
			}
			c && c.detach()
		}
		return e
	}
	function d(b, c, g, h, i) {
		var j = !1,
			k = "table, thead, tbody, tfoot, tr, col, colgroup, object, embed, param, ol, ul, dl, blockquote, select, optgroup, option, textarea, script, style",
			l = "script, .dotdotdot-keep";
		return b.contents().detach().each(function () {
			var m = this,
				n = a(m);
			if ("undefined" == typeof m || 3 == m.nodeType && 0 == a.trim(m.data).length) return !0;
			if (n.is(l)) b.append(n);
			else {
				if (j) return !0;
				b.append(n), i && b[b.is(k) ? "after" : "append"](i), f(g, h) && (j = 3 == m.nodeType ? e(n, c, g, h, i) : d(n, c, g, h, i), j || (n.detach(), j = !0)), j || i && i.detach()
			}
		}), j
	}
	function e(b, c, d, e, h) {
		var k = b[0];
		if (!k) return !1;
		var m = j(k),
			n = -1 !== m.indexOf(" ") ? " " : "　",
			o = "letter" == e.wrap ? "" : n,
			p = m.split(o),
			q = -1,
			r = -1,
			s = 0,
			t = p.length - 1;
		for (e.fallbackToLetter && 0 == s && 0 == t && (o = "", p = m.split(o), t = p.length - 1); t >= s && (0 != s || 0 != t);) {
			var u = Math.floor((s + t) / 2);
			if (u == r) break;
			r = u, i(k, p.slice(0, r + 1).join(o) + e.ellipsis), f(d, e) ? (t = r, e.fallbackToLetter && 0 == s && 0 == t && (o = "", p = p[0].split(o), q = -1, r = -1, s = 0, t = p.length - 1)) : (q = r, s = r)
		}
		if (-1 == q || 1 == p.length && 0 == p[0].length) {
			var v = b.parent();
			b.detach();
			var w = h && h.closest(v).length ? h.length : 0;
			v.contents().length > w ? k = l(v.contents().eq(-1 - w), c) : (k = l(v, c, !0), w || v.detach()), k && (m = g(j(k), e), i(k, m), w && h && a(k).parent().append(h))
		} else m = g(p.slice(0, q + 1).join(o), e), i(k, m);
		return !0
	}
	function f(a, b) {
		return a.innerHeight() > b.maxHeight
	}
	function g(b, c) {
		for (; a.inArray(b.slice(-1), c.lastCharacter.remove) > -1;) b = b.slice(0, -1);
		return a.inArray(b.slice(-1), c.lastCharacter.noEllipsis) < 0 && (b += c.ellipsis), b
	}
	function h(a) {
		return {
			width: a.innerWidth(),
			height: a.innerHeight()
		}
	}
	function i(a, b) {
		a.innerText ? a.innerText = b : a.nodeValue ? a.nodeValue = b : a.textContent && (a.textContent = b)
	}
	function j(a) {
		return a.innerText ? a.innerText : a.nodeValue ? a.nodeValue : a.textContent ? a.textContent : ""
	}
	function k(a) {
		do a = a.previousSibling;
		while (a && 1 !== a.nodeType && 3 !== a.nodeType);
		return a
	}
	function l(b, c, d) {
		var e, f = b && b[0];
		if (f) {
			if (!d) {
				if (3 === f.nodeType) return f;
				if (a.trim(b.text())) return l(b.contents().last(), c)
			}
			for (e = k(f); !e;) {
				if (b = b.parent(), b.is(c) || !b.length) return !1;
				e = k(b[0])
			}
			if (e) return l(a(e), c)
		}
		return !1
	}
	function m(b, c) {
		return b ? "string" == typeof b ? (b = a(b, c), b.length ? b : !1) : b.jquery ? b : !1 : !1
	}
	function n(a) {
		for (var b = a.innerHeight(), c = ["paddingTop", "paddingBottom"], d = 0, e = c.length; e > d; d++) {
			var f = parseInt(a.css(c[d]), 10);
			isNaN(f) && (f = 0), b -= f
		}
		return b
	}
	if (!a.fn.dotdotdot) {
		a.fn.dotdotdot = function (b) {
			if (0 == this.length) return a.fn.dotdotdot.debug('No element found for "' + this.selector + '".'), this;
			if (this.length > 1) return this.each(function () {
				a(this).dotdotdot(b)
			});
			var e = this;
			e.data("dotdotdot") && e.trigger("destroy.dot"), e.data("dotdotdot-style", e.attr("style") || ""), e.css("word-wrap", "break-word"), "nowrap" === e.css("white-space") && e.css("white-space", "normal"), e.bind_events = function () {
				return e.bind("update.dot", function (b, h) {
					b.preventDefault(), b.stopPropagation(), i.maxHeight = "number" == typeof i.height ? i.height : n(e), i.maxHeight += i.tolerance, "undefined" != typeof h && (("string" == typeof h || h instanceof HTMLElement) && (h = a("<div />").append(h).contents()), h instanceof a && (g = h)), p = e.wrapInner('<div class="dotdotdot" />').children(), p.contents().detach().end().append(g.clone(!0)).find("br").replaceWith("  <br />  ").end().css({
						height: "auto",
						width: "auto",
						border: "none",
						padding: 0,
						margin: 0
					});
					var k = !1,
						l = !1;
					return j.afterElement && (k = j.afterElement.clone(!0), k.show(), j.afterElement.detach()), f(p, i) && (l = "children" == i.wrap ? c(p, i, k) : d(p, e, p, i, k)), p.replaceWith(p.contents()), p = null, a.isFunction(i.callback) && i.callback.call(e[0], l, g), j.isTruncated = l, l
				}).bind("isTruncated.dot", function (a, b) {
					return a.preventDefault(), a.stopPropagation(), "function" == typeof b && b.call(e[0], j.isTruncated), j.isTruncated
				}).bind("originalContent.dot", function (a, b) {
					return a.preventDefault(), a.stopPropagation(), "function" == typeof b && b.call(e[0], g), g
				}).bind("destroy.dot", function (a) {
					a.preventDefault(), a.stopPropagation(), e.unwatch().unbind_events().contents().detach().end().append(g).attr("style", e.data("dotdotdot-style") || "").data("dotdotdot", !1)
				}), e
			}, e.unbind_events = function () {
				return e.unbind(".dot"), e
			}, e.watch = function () {
				if (e.unwatch(), "window" == i.watch) {
					var b = a(window),
						c = b.width(),
						d = b.height();
					b.bind("resize.dot" + j.dotId, function () {
						c == b.width() && d == b.height() && i.windowResizeFix || (c = b.width(), d = b.height(), l && clearInterval(l), l = setTimeout(function () {
							e.trigger("update.dot")
						}, 100))
					})
				} else k = h(e), l = setInterval(function () {
					if (e.is(":visible")) {
						var a = h(e);
						(k.width != a.width || k.height != a.height) && (e.trigger("update.dot"), k = a)
					}
				}, 500);
				return e
			}, e.unwatch = function () {
				return a(window).unbind("resize.dot" + j.dotId), l && clearInterval(l), e
			};
			var g = e.contents(),
				i = a.extend(!0, {}, a.fn.dotdotdot.defaults, b),
				j = {},
				k = {},
				l = null,
				p = null;
			return i.lastCharacter.remove instanceof Array || (i.lastCharacter.remove = a.fn.dotdotdot.defaultArrays.lastCharacter.remove), i.lastCharacter.noEllipsis instanceof Array || (i.lastCharacter.noEllipsis = a.fn.dotdotdot.defaultArrays.lastCharacter.noEllipsis), j.afterElement = m(i.after, e), j.isTruncated = !1, j.dotId = o++, e.data("dotdotdot", !0).bind_events().trigger("update.dot"), i.watch && e.watch(), e
		}, a.fn.dotdotdot.defaults = {
			ellipsis: "... ",
			wrap: "word",
			fallbackToLetter: !0,
			lastCharacter: {},
			tolerance: 0,
			callback: null,
			after: null,
			height: null,
			watch: !1,
			windowResizeFix: !0
		}, a.fn.dotdotdot.defaultArrays = {
			lastCharacter: {
				remove: [" ", "　", ",", ";", ".", "!", "?"],
				noEllipsis: []
			}
		}, a.fn.dotdotdot.debug = function () {};
		var o = 1,
			p = a.fn.html;
		a.fn.html = function (c) {
			return c != b && !a.isFunction(c) && this.data("dotdotdot") ? this.trigger("update", [c]) : p.apply(this, arguments)
		};
		var q = a.fn.text;
		a.fn.text = function (c) {
			return c != b && !a.isFunction(c) && this.data("dotdotdot") ? (c = a("<div />").text(c).html(), this.trigger("update", [c])) : q.apply(this, arguments)
		}
	}
}(jQuery), function (a) {
	"function" == typeof define && define.amd ? define(["jquery"], a) : "object" == typeof exports ? module.exports = a : a(jQuery)
}(function (a) {
	function b(b) {
		var g = b || window.event,
			h = i.call(arguments, 1),
			j = 0,
			l = 0,
			m = 0,
			n = 0,
			o = 0,
			p = 0;
		if (b = a.event.fix(g), b.type = "mousewheel", "detail" in g && (m = -1 * g.detail), "wheelDelta" in g && (m = g.wheelDelta), "wheelDeltaY" in g && (m = g.wheelDeltaY), "wheelDeltaX" in g && (l = -1 * g.wheelDeltaX), "axis" in g && g.axis === g.HORIZONTAL_AXIS && (l = -1 * m, m = 0), j = 0 === m ? l : m, "deltaY" in g && (m = -1 * g.deltaY, j = m), "deltaX" in g && (l = g.deltaX, 0 === m && (j = -1 * l)), 0 !== m || 0 !== l) {
			if (1 === g.deltaMode) {
				var q = a.data(this, "mousewheel-line-height");
				j *= q, m *= q, l *= q
			} else if (2 === g.deltaMode) {
				var r = a.data(this, "mousewheel-page-height");
				j *= r, m *= r, l *= r
			}
			if (n = Math.max(Math.abs(m), Math.abs(l)), (!f || f > n) && (f = n, d(g, n) && (f /= 40)), d(g, n) && (j /= 40, l /= 40, m /= 40), j = Math[j >= 1 ? "floor" : "ceil"](j / f), l = Math[l >= 1 ? "floor" : "ceil"](l / f), m = Math[m >= 1 ? "floor" : "ceil"](m / f), k.settings.normalizeOffset && this.getBoundingClientRect) {
				var s = this.getBoundingClientRect();
				o = b.clientX - s.left, p = b.clientY - s.top
			}
			return b.deltaX = l, b.deltaY = m, b.deltaFactor = f, b.offsetX = o, b.offsetY = p, b.deltaMode = 0, h.unshift(b, j, l, m), e && clearTimeout(e), e = setTimeout(c, 200), (a.event.dispatch || a.event.handle).apply(this, h)
		}
	}
	function c() {
		f = null
	}
	function d(a, b) {
		return k.settings.adjustOldDeltas && "mousewheel" === a.type && b % 120 === 0
	}
	var e, f, g = ["wheel", "mousewheel", "DOMMouseScroll", "MozMousePixelScroll"],
		h = "onwheel" in document || document.documentMode >= 9 ? ["wheel"] : ["mousewheel", "DomMouseScroll", "MozMousePixelScroll"],
		i = Array.prototype.slice;
	if (a.event.fixHooks) for (var j = g.length; j;) a.event.fixHooks[g[--j]] = a.event.mouseHooks;
	var k = a.event.special.mousewheel = {
		version: "3.1.12",
		setup: function () {
			if (this.addEventListener) for (var c = h.length; c;) this.addEventListener(h[--c], b, !1);
			else this.onmousewheel = b;
			a.data(this, "mousewheel-line-height", k.getLineHeight(this)), a.data(this, "mousewheel-page-height", k.getPageHeight(this))
		},
		teardown: function () {
			if (this.removeEventListener) for (var c = h.length; c;) this.removeEventListener(h[--c], b, !1);
			else this.onmousewheel = null;
			a.removeData(this, "mousewheel-line-height"), a.removeData(this, "mousewheel-page-height")
		},
		getLineHeight: function (b) {
			var c = a(b),
				d = c["offsetParent" in a.fn ? "offsetParent" : "parent"]();
			return d.length || (d = a("body")), parseInt(d.css("fontSize"), 10) || parseInt(c.css("fontSize"), 10) || 16
		},
		getPageHeight: function (b) {
			return a(b).height()
		},
		settings: {
			adjustOldDeltas: !0,
			normalizeOffset: !0
		}
	};
	a.fn.extend({
		mousewheel: function (a) {
			return a ? this.bind("mousewheel", a) : this.trigger("mousewheel")
		},
		unmousewheel: function (a) {
			return this.unbind("mousewheel", a)
		}
	})
}), function (a) {
	function b(b) {
		var c = Math.min.apply(Math, b);
		return a.inArray(c, b)
	}
	function c(a) {
		for (var b = [], c = 0; a > c; c++) b.push(0);
		return b
	}
	function d(b) {
		var c = a(b).outerWidth(),
			d = a(b).offsetParent().width();
		return {
			width: 100 * c / d,
			num: Math.floor(d / c)
		}
	}
	Array.max = function (a) {
		return Math.max.apply(Math, a)
	}, a.easing.__Slide = function (a, b, c, d, e) {
		return d * Math.sqrt(1 - (b = b / e - 1) * b) + c
	}, a.lrdxMasonry = function (e, f) {
		var g = {
			animate: !1,
			easing: "__Slide",
			timeout: 800
		},
			h = a.extend({}, g, f),
			i = a(e),
			j = this;
		a.extend(j, {
			refresh: function () {
				var b = a("img", e),
					c = b.length,
					d = 0;
				b.length > 0 && i.addClass("sm-images-waiting").removeClass("sm-images-loaded"), b.on("load", function () {
					d++, d == c && (j.resize(), i.removeClass("sm-images-waiting").addClass("sm-images-loaded"))
				}), j.resize()
			},
			resize: function () {
				var e = i.children(),
					f = d(e[0]),
					g = f.width,
					j = f.num,
					k = c(j),
					l = "rtl" === i.css("direction") ? "right" : "left";
				if (j > 1) {
					var m = function (c) {
						var d = a(this).outerHeight(),
							e = b(k);
						if (e > 0 && c >= j) {
							var f = Array.max(k),
								i = k[e];.5 * d > f - i && (e = 0)
						}
						var m = Math.round(e * g * 10) / 10,
							n = {};
						n[l] = m + "%", n.top = k[e] + "px", a(this).css({
							position: "absolute"
						}).stop(), h.animate ? a(this).animate(n, h.timeout, h.easing) : a(this).css(n), k[e] += d
					};
					e.css({
						overflow: "hidden",
						zoom: "1"
					}).each(m), i.css({
						position: "relative",
						height: Array.max(k) + "px"
					})
				} else e.removeAttr("style"), i.removeAttr("style")
			}
		}), a(window).resize(j.resize), i.addClass("sm-loaded"), j.refresh()
	}, a.fn.lrdxMasonry = function (b) {
		if ("string" != typeof b) return this.each(function () {
			if (void 0 == a(this).data("lrdxMasonry")) {
				var c = new a.lrdxMasonry(this, b);
				a(this).data("lrdxMasonry", c)
			}
		});
		var c = a(this).data("lrdxMasonry"),
			d = Array.prototype.slice.call(arguments, 1);
		return c[b] ? c[b].apply(c, d) : void 0
	}
}(jQuery), function (a) {
	var b, c, d, e, f, g, h, i = "Close",
		j = "BeforeClose",
		k = "AfterClose",
		l = "BeforeAppend",
		m = "MarkupParse",
		n = "Open",
		o = "Change",
		p = "mfp",
		q = "." + p,
		r = "mfp-ready",
		s = "mfp-removing",
		t = "mfp-prevent-close",
		u = function () {},
		v = !! window.jQuery,
		w = a(window),
		x = function (a, c) {
			b.ev.on(p + a + q, c)
		},
		y = function (b, c, d, e) {
			var f = document.createElement("div");
			return f.className = "mfp-" + b, d && (f.innerHTML = d), e ? c && c.appendChild(f) : (f = a(f), c && f.appendTo(c)), f
		},
		z = function (c, d) {
			b.ev.triggerHandler(p + c, d), b.st.callbacks && (c = c.charAt(0).toLowerCase() + c.slice(1), b.st.callbacks[c] && b.st.callbacks[c].apply(b, a.isArray(d) ? d : [d]))
		},
		A = function (c) {
			return c === h && b.currTemplate.closeBtn || (b.currTemplate.closeBtn = a(b.st.closeMarkup.replace("%title%", b.st.tClose)), h = c), b.currTemplate.closeBtn
		},
		B = function () {
			a.magnificPopup.instance || (b = new u, b.init(), a.magnificPopup.instance = b)
		},
		C = function () {
			var a = document.createElement("p").style,
				b = ["ms", "O", "Moz", "Webkit"];
			if (void 0 !== a.transition) return !0;
			for (; b.length;) if (b.pop() + "Transition" in a) return !0;
			return !1
		};
	u.prototype = {
		constructor: u,
		init: function () {
			var c = navigator.appVersion;
			b.isIE7 = -1 !== c.indexOf("MSIE 7."), b.isIE8 = -1 !== c.indexOf("MSIE 8."), b.isLowIE = b.isIE7 || b.isIE8, b.isAndroid = /android/gi.test(c), b.isIOS = /iphone|ipad|ipod/gi.test(c), b.supportsTransition = C(), b.probablyMobile = b.isAndroid || b.isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent), e = a(document), b.popupsCache = {}
		},
		open: function (c) {
			d || (d = a(document.body));
			var f;
			if (c.isObj === !1) {
				b.items = c.items.toArray(), b.index = 0;
				var h, i = c.items;
				for (f = 0; f < i.length; f++) if (h = i[f], h.parsed && (h = h.el[0]), h === c.el[0]) {
					b.index = f;
					break
				}
			} else b.items = a.isArray(c.items) ? c.items : [c.items], b.index = c.index || 0;
			if (b.isOpen) return void b.updateItemHTML();
			b.types = [], g = "", b.ev = c.mainEl && c.mainEl.length ? c.mainEl.eq(0) : e, c.key ? (b.popupsCache[c.key] || (b.popupsCache[c.key] = {}), b.currTemplate = b.popupsCache[c.key]) : b.currTemplate = {}, b.st = a.extend(!0, {}, a.magnificPopup.defaults, c), b.fixedContentPos = "auto" === b.st.fixedContentPos ? !b.probablyMobile : b.st.fixedContentPos, b.st.modal && (b.st.closeOnContentClick = !1, b.st.closeOnBgClick = !1, b.st.showCloseBtn = !1, b.st.enableEscapeKey = !1), b.bgOverlay || (b.bgOverlay = y("bg").on("click" + q, function () {
				b.close()
			}), b.wrap = y("wrap").attr("tabindex", -1).on("click" + q, function (a) {
				a.preventDefault(), b._checkIfClose(a.target) && b.close()
			}), b.container = y("container", b.wrap)), b.contentContainer = y("content"), b.st.preloader && (b.preloader = y("preloader", b.container, b.st.tLoading));
			var j = a.magnificPopup.modules;
			for (f = 0; f < j.length; f++) {
				var k = j[f];
				k = k.charAt(0).toUpperCase() + k.slice(1), b["init" + k].call(b)
			}
			z("BeforeOpen"), b.st.showCloseBtn && (b.st.closeBtnInside ? (x(m, function (a, b, c, d) {
				c.close_replaceWith = A(d.type)
			}), g += " mfp-close-btn-in") : b.wrap.append(A())), b.st.alignTop && (g += " mfp-align-top"), b.wrap.css(b.fixedContentPos ? {
				overflow: b.st.overflowY,
				overflowX: "hidden",
				overflowY: b.st.overflowY
			} : {
				top: w.scrollTop(),
				position: "absolute"
			}), (b.st.fixedBgPos === !1 || "auto" === b.st.fixedBgPos && !b.fixedContentPos) && b.bgOverlay.css({
				height: e.height(),
				position: "absolute"
			}), b.st.enableEscapeKey && e.on("keyup" + q, function (a) {
				27 === a.keyCode && b.close()
			}), w.on("resize" + q, function () {
				b.updateSize()
			}), b.st.closeOnContentClick || (g += " mfp-auto-cursor"), g && b.wrap.addClass(g);
			var l = b.wH = w.height(),
				o = {};
			if (b.fixedContentPos && b._hasScrollBar(l)) {
				var p = b._getScrollbarSize();
				p && (o.marginRight = p)
			}
			b.fixedContentPos && (b.isIE7 ? a("body, html").css("overflow", "hidden") : o.overflow = "hidden");
			var s = b.st.mainClass;
			return b.isIE7 && (s += " mfp-ie7"), s && b._addClassToMFP(s), b.updateItemHTML(), z("BuildControls"), a("html").css(o), b.bgOverlay.add(b.wrap).prependTo(b.st.prependTo || d), b._lastFocusedEl = document.activeElement, setTimeout(function () {
				b.content ? (b._addClassToMFP(r), b._setFocus()) : b.bgOverlay.addClass(r), e.on("focusin" + q, b._onFocusIn)
			}, 16), b.isOpen = !0, b.updateSize(l), z(n), c
		},
		close: function () {
			b.isOpen && (z(j), b.isOpen = !1, b.st.removalDelay && !b.isLowIE && b.supportsTransition ? (b._addClassToMFP(s), setTimeout(function () {
				b._close()
			}, b.st.removalDelay)) : b._close())
		},
		_close: function () {
			z(i);
			var c = s + " " + r + " ";
			if (b.bgOverlay.detach(), b.wrap.detach(), b.container.empty(), b.st.mainClass && (c += b.st.mainClass + " "), b._removeClassFromMFP(c), b.fixedContentPos) {
				var d = {
					marginRight: ""
				};
				b.isIE7 ? a("body, html").css("overflow", "") : d.overflow = "", a("html").css(d)
			}
			e.off("keyup" + q + " focusin" + q), b.ev.off(q), b.wrap.attr("class", "mfp-wrap").removeAttr("style"), b.bgOverlay.attr("class", "mfp-bg"), b.container.attr("class", "mfp-container"), !b.st.showCloseBtn || b.st.closeBtnInside && b.currTemplate[b.currItem.type] !== !0 || b.currTemplate.closeBtn && b.currTemplate.closeBtn.detach(), b._lastFocusedEl && a(b._lastFocusedEl).focus(), b.currItem = null, b.content = null, b.currTemplate = null, b.prevHeight = 0, z(k)
		},
		updateSize: function (a) {
			if (b.isIOS) {
				var c = document.documentElement.clientWidth / window.innerWidth,
					d = window.innerHeight * c;
				b.wrap.css("height", d), b.wH = d
			} else b.wH = a || w.height();
			b.fixedContentPos || b.wrap.css("height", b.wH), z("Resize")
		},
		updateItemHTML: function () {
			var c = b.items[b.index];
			b.contentContainer.detach(), b.content && b.content.detach(), c.parsed || (c = b.parseEl(b.index));
			var d = c.type;
			if (z("BeforeChange", [b.currItem ? b.currItem.type : "", d]), b.currItem = c, !b.currTemplate[d]) {
				var e = b.st[d] ? b.st[d].markup : !1;
				z("FirstMarkupParse", e), b.currTemplate[d] = e ? a(e) : !0
			}
			f && f !== c.type && b.container.removeClass("mfp-" + f + "-holder");
			var g = b["get" + d.charAt(0).toUpperCase() + d.slice(1)](c, b.currTemplate[d]);
			b.appendContent(g, d), c.preloaded = !0, z(o, c), f = c.type, b.container.prepend(b.contentContainer), z("AfterChange")
		},
		appendContent: function (a, c) {
			b.content = a, a ? b.st.showCloseBtn && b.st.closeBtnInside && b.currTemplate[c] === !0 ? b.content.find(".mfp-close").length || b.content.append(A()) : b.content = a : b.content = "", z(l), b.container.addClass("mfp-" + c + "-holder"), b.contentContainer.append(b.content)
		},
		parseEl: function (c) {
			var d, e = b.items[c];
			if (e.tagName ? e = {
				el: a(e)
			} : (d = e.type, e = {
				data: e,
				src: e.src
			}), e.el) {
				for (var f = b.types, g = 0; g < f.length; g++) if (e.el.hasClass("mfp-" + f[g])) {
					d = f[g];
					break
				}
				e.src = e.el.attr("data-mfp-src"), e.src || (e.src = e.el.attr("href"))
			}
			return e.type = d || b.st.type || "inline", e.index = c, e.parsed = !0, b.items[c] = e, z("ElementParse", e), b.items[c]
		},
		addGroup: function (a, c) {
			var d = function (d) {
				d.mfpEl = this, b._openClick(d, a, c)
			};
			c || (c = {});
			var e = "click.magnificPopup";
			c.mainEl = a, c.items ? (c.isObj = !0, a.off(e).on(e, d)) : (c.isObj = !1, c.delegate ? a.off(e).on(e, c.delegate, d) : (c.items = a, a.off(e).on(e, d)))
		},
		_openClick: function (c, d, e) {
			var f = void 0 !== e.midClick ? e.midClick : a.magnificPopup.defaults.midClick;
			if (f || 2 !== c.which && !c.ctrlKey && !c.metaKey) {
				var g = void 0 !== e.disableOn ? e.disableOn : a.magnificPopup.defaults.disableOn;
				if (g) if (a.isFunction(g)) {
					if (!g.call(b)) return !0
				} else if (w.width() < g) return !0;
				c.type && (c.preventDefault(), b.isOpen && c.stopPropagation()), e.el = a(c.mfpEl), e.delegate && (e.items = d.find(e.delegate)), b.open(e)
			}
		},
		updateStatus: function (a, d) {
			if (b.preloader) {
				c !== a && b.container.removeClass("mfp-s-" + c), d || "loading" !== a || (d = b.st.tLoading);
				var e = {
					status: a,
					text: d
				};
				z("UpdateStatus", e), a = e.status, d = e.text, b.preloader.html(d), b.preloader.find("a").on("click", function (a) {
					a.stopImmediatePropagation()
				}), b.container.addClass("mfp-s-" + a), c = a
			}
		},
		_checkIfClose: function (c) {
			if (!a(c).hasClass(t)) {
				var d = b.st.closeOnContentClick,
					e = b.st.closeOnBgClick;
				if (d && e) return !0;
				if (!b.content || a(c).hasClass("mfp-close") || b.preloader && c === b.preloader[0]) return !0;
				if (c === b.content[0] || a.contains(b.content[0], c)) {
					if (d) return !0
				} else if (e && a.contains(document, c)) return !0;
				return !1
			}
		},
		_addClassToMFP: function (a) {
			b.bgOverlay.addClass(a), b.wrap.addClass(a)
		},
		_removeClassFromMFP: function (a) {
			this.bgOverlay.removeClass(a), b.wrap.removeClass(a)
		},
		_hasScrollBar: function (a) {
			return (b.isIE7 ? e.height() : document.body.scrollHeight) > (a || w.height())
		},
		_setFocus: function () {
			(b.st.focus ? b.content.find(b.st.focus).eq(0) : b.wrap).focus()
		},
		_onFocusIn: function (c) {
			return c.target === b.wrap[0] || a.contains(b.wrap[0], c.target) ? void 0 : (b._setFocus(), !1)
		},
		_parseMarkup: function (b, c, d) {
			var e;
			d.data && (c = a.extend(d.data, c)), z(m, [b, c, d]), a.each(c, function (a, c) {
				if (void 0 === c || c === !1) return !0;
				if (e = a.split("_"), e.length > 1) {
					var d = b.find(q + "-" + e[0]);
					if (d.length > 0) {
						var f = e[1];
						"replaceWith" === f ? d[0] !== c[0] && d.replaceWith(c) : "img" === f ? d.is("img") ? d.attr("src", c) : d.replaceWith('<img src="' + c + '" class="' + d.attr("class") + '" />') : d.attr(e[1], c)
					}
				} else b.find(q + "-" + a).html(c)
			})
		},
		_getScrollbarSize: function () {
			if (void 0 === b.scrollbarSize) {
				var a = document.createElement("div");
				a.id = "mfp-sbm", a.style.cssText = "width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;", document.body.appendChild(a), b.scrollbarSize = a.offsetWidth - a.clientWidth, document.body.removeChild(a)
			}
			return b.scrollbarSize
		}
	}, a.magnificPopup = {
		instance: null,
		proto: u.prototype,
		modules: [],
		open: function (b, c) {
			return B(), b = b ? a.extend(!0, {}, b) : {}, b.isObj = !0, b.index = c || 0, this.instance.open(b)
		},
		close: function () {
			return a.magnificPopup.instance && a.magnificPopup.instance.close()
		},
		registerModule: function (b, c) {
			c.options && (a.magnificPopup.defaults[b] = c.options), a.extend(this.proto, c.proto), this.modules.push(b)
		},
		defaults: {
			disableOn: 0,
			key: null,
			midClick: !1,
			mainClass: "",
			preloader: !0,
			focus: "",
			closeOnContentClick: !1,
			closeOnBgClick: !0,
			closeBtnInside: !0,
			showCloseBtn: !0,
			enableEscapeKey: !0,
			modal: !1,
			alignTop: !1,
			removalDelay: 0,
			prependTo: null,
			fixedContentPos: "auto",
			fixedBgPos: "auto",
			overflowY: "auto",
			closeMarkup: '<button title="%title%" type="button" class="mfp-close">&times;</button>',
			tClose: "Close (Esc)",
			tLoading: "Loading..."
		}
	}, a.fn.magnificPopup = function (c) {
		B();
		var d = a(this);
		if ("string" == typeof c) if ("open" === c) {
			var e, f = v ? d.data("magnificPopup") : d[0].magnificPopup,
				g = parseInt(arguments[1], 10) || 0;
			f.items ? e = f.items[g] : (e = d, f.delegate && (e = e.find(f.delegate)), e = e.eq(g)), b._openClick({
				mfpEl: e
			}, d, f)
		} else b.isOpen && b[c].apply(b, Array.prototype.slice.call(arguments, 1));
		else c = a.extend(!0, {}, c), v ? d.data("magnificPopup", c) : d[0].magnificPopup = c, b.addGroup(d, c);
		return d
	};
	var D, E, F, G = "inline",
		H = function () {
			F && (E.after(F.addClass(D)).detach(), F = null)
		};
	a.magnificPopup.registerModule(G, {
		options: {
			hiddenClass: "hide",
			markup: "",
			tNotFound: "Content not found"
		},
		proto: {
			initInline: function () {
				b.types.push(G), x(i + "." + G, function () {
					H()
				})
			},
			getInline: function (c, d) {
				if (H(), c.src) {
					var e = b.st.inline,
						f = a(c.src);
					if (f.length) {
						var g = f[0].parentNode;
						g && g.tagName && (E || (D = e.hiddenClass, E = y(D), D = "mfp-" + D), F = f.after(E).detach().removeClass(D)), b.updateStatus("ready")
					} else b.updateStatus("error", e.tNotFound), f = a("<div>");
					return c.inlineElement = f, f
				}
				return b.updateStatus("ready"), b._parseMarkup(d, {}, c), d
			}
		}
	});
	var I, J = "ajax",
		K = function () {
			I && d.removeClass(I)
		},
		L = function () {
			K(), b.req && b.req.abort()
		};
	a.magnificPopup.registerModule(J, {
		options: {
			settings: null,
			cursor: "mfp-ajax-cur",
			tError: '<a href="%url%">The content</a> could not be loaded.'
		},
		proto: {
			initAjax: function () {
				b.types.push(J), I = b.st.ajax.cursor, x(i + "." + J, L), x("BeforeChange." + J, L)
			},
			getAjax: function (c) {
				I && d.addClass(I), b.updateStatus("loading");
				var e = a.extend({
					url: c.src,
					success: function (d, e, f) {
						var g = {
							data: d,
							xhr: f
						};
						z("ParseAjax", g), b.appendContent(a(g.data), J), c.finished = !0, K(), b._setFocus(), setTimeout(function () {
							b.wrap.addClass(r)
						}, 16), b.updateStatus("ready"), z("AjaxContentAdded")
					},
					error: function () {
						K(), c.finished = c.loadError = !0, b.updateStatus("error", b.st.ajax.tError.replace("%url%", c.src))
					}
				}, b.st.ajax.settings);
				return b.req = a.ajax(e), ""
			}
		}
	});
	var M, N = function (c) {
		if (c.data && void 0 !== c.data.title) return c.data.title;
		var d = b.st.image.titleSrc;
		if (d) {
			if (a.isFunction(d)) return d.call(b, c);
			if (c.el) return c.el.attr(d) || ""
		}
		return ""
	};
	a.magnificPopup.registerModule("image", {
		options: {
			markup: '<div class="mfp-figure"><div class="mfp-close"></div><figure><div class="mfp-img"></div><figcaption><div class="mfp-bottom-bar"><div class="mfp-title"></div><div class="mfp-counter"></div></div></figcaption></figure></div>',
			cursor: "mfp-zoom-out-cur",
			titleSrc: "title",
			verticalFit: !0,
			tError: '<a href="%url%">The image</a> could not be loaded.'
		},
		proto: {
			initImage: function () {
				var a = b.st.image,
					c = ".image";
				b.types.push("image"), x(n + c, function () {
					"image" === b.currItem.type && a.cursor && d.addClass(a.cursor)
				}), x(i + c, function () {
					a.cursor && d.removeClass(a.cursor), w.off("resize" + q)
				}), x("Resize" + c, b.resizeImage), b.isLowIE && x("AfterChange", b.resizeImage)
			},
			resizeImage: function () {
				var a = b.currItem;
				if (a && a.img && b.st.image.verticalFit) {
					var c = 0;
					b.isLowIE && (c = parseInt(a.img.css("padding-top"), 10) + parseInt(a.img.css("padding-bottom"), 10)), a.img.css("max-height", b.wH - c)
				}
			},
			_onImageHasSize: function (a) {
				a.img && (a.hasSize = !0, M && clearInterval(M), a.isCheckingImgSize = !1, z("ImageHasSize", a), a.imgHidden && (b.content && b.content.removeClass("mfp-loading"), a.imgHidden = !1))
			},
			findImageSize: function (a) {
				var c = 0,
					d = a.img[0],
					e = function (f) {
						M && clearInterval(M), M = setInterval(function () {
							return d.naturalWidth > 0 ? void b._onImageHasSize(a) : (c > 200 && clearInterval(M), c++, void(3 === c ? e(10) : 40 === c ? e(50) : 100 === c && e(500)))
						}, f)
					};
				e(1)
			},
			getImage: function (c, d) {
				var e = 0,
					f = function () {
						c && (c.img[0].complete ? (c.img.off(".mfploader"), c === b.currItem && (b._onImageHasSize(c), b.updateStatus("ready")), c.hasSize = !0, c.loaded = !0, z("ImageLoadComplete")) : (e++, 200 > e ? setTimeout(f, 100) : g()))
					},
					g = function () {
						c && (c.img.off(".mfploader"), c === b.currItem && (b._onImageHasSize(c), b.updateStatus("error", h.tError.replace("%url%", c.src))), c.hasSize = !0, c.loaded = !0, c.loadError = !0)
					},
					h = b.st.image,
					i = d.find(".mfp-img");
				if (i.length) {
					var j = document.createElement("img");
					j.className = "mfp-img", c.img = a(j).on("load.mfploader", f).on("error.mfploader", g), j.src = c.src, i.is("img") && (c.img = c.img.clone()), j = c.img[0], j.naturalWidth > 0 ? c.hasSize = !0 : j.width || (c.hasSize = !1)
				}
				return b._parseMarkup(d, {
					title: N(c),
					img_replaceWith: c.img
				}, c), b.resizeImage(), c.hasSize ? (M && clearInterval(M), c.loadError ? (d.addClass("mfp-loading"), b.updateStatus("error", h.tError.replace("%url%", c.src))) : (d.removeClass("mfp-loading"), b.updateStatus("ready")), d) : (b.updateStatus("loading"), c.loading = !0, c.hasSize || (c.imgHidden = !0, d.addClass("mfp-loading"), b.findImageSize(c)), d)
			}
		}
	});
	var O, P = function () {
		return void 0 === O && (O = void 0 !== document.createElement("p").style.MozTransform), O
	};
	a.magnificPopup.registerModule("zoom", {
		options: {
			enabled: !1,
			easing: "ease-in-out",
			duration: 300,
			opener: function (a) {
				return a.is("img") ? a : a.find("img")
			}
		},
		proto: {
			initZoom: function () {
				var a, c = b.st.zoom,
					d = ".zoom";
				if (c.enabled && b.supportsTransition) {
					var e, f, g = c.duration,
						h = function (a) {
							var b = a.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),
								d = "all " + c.duration / 1e3 + "s " + c.easing,
								e = {
									position: "fixed",
									zIndex: 9999,
									left: 0,
									top: 0,
									"-webkit-backface-visibility": "hidden"
								},
								f = "transition";
							return e["-webkit-" + f] = e["-moz-" + f] = e["-o-" + f] = e[f] = d, b.css(e), b
						},
						k = function () {
							b.content.css("visibility", "visible")
						};
					x("BuildControls" + d, function () {
						if (b._allowZoom()) {
							if (clearTimeout(e), b.content.css("visibility", "hidden"), a = b._getItemToZoom(), !a) return void k();
							f = h(a), f.css(b._getOffset()), b.wrap.append(f), e = setTimeout(function () {
								f.css(b._getOffset(!0)), e = setTimeout(function () {
									k(), setTimeout(function () {
										f.remove(), a = f = null, z("ZoomAnimationEnded")
									}, 16)
								}, g)
							}, 16)
						}
					}), x(j + d, function () {
						if (b._allowZoom()) {
							if (clearTimeout(e), b.st.removalDelay = g, !a) {
								if (a = b._getItemToZoom(), !a) return;
								f = h(a)
							}
							f.css(b._getOffset(!0)), b.wrap.append(f), b.content.css("visibility", "hidden"), setTimeout(function () {
								f.css(b._getOffset())
							}, 16)
						}
					}), x(i + d, function () {
						b._allowZoom() && (k(), f && f.remove(), a = null)
					})
				}
			},
			_allowZoom: function () {
				return "image" === b.currItem.type
			},
			_getItemToZoom: function () {
				return b.currItem.hasSize ? b.currItem.img : !1
			},
			_getOffset: function (c) {
				var d;
				d = c ? b.currItem.img : b.st.zoom.opener(b.currItem.el || b.currItem);
				var e = d.offset(),
					f = parseInt(d.css("padding-top"), 10),
					g = parseInt(d.css("padding-bottom"), 10);
				e.top -= a(window).scrollTop() - f;
				var h = {
					width: d.width(),
					height: (v ? d.innerHeight() : d[0].offsetHeight) - g - f
				};
				return P() ? h["-moz-transform"] = h.transform = "translate(" + e.left + "px," + e.top + "px)" : (h.left = e.left, h.top = e.top), h
			}
		}
	});
	var Q = "iframe",
		R = "//about:blank",
		S = function (a) {
			if (b.currTemplate[Q]) {
				var c = b.currTemplate[Q].find("iframe");
				c.length && (a || (c[0].src = R), b.isIE8 && c.css("display", a ? "block" : "none"))
			}
		};
	a.magnificPopup.registerModule(Q, {
		options: {
			markup: '<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe></div>',
			srcAction: "iframe_src",
			patterns: {
				youtube: {
					index: "youtube.com",
					id: "v=",
					src: "//www.youtube.com/embed/%id%?autoplay=1"
				},
				vimeo: {
					index: "vimeo.com/",
					id: "/",
					src: "//player.vimeo.com/video/%id%?autoplay=1"
				},
				gmaps: {
					index: "//maps.google.",
					src: "%id%&output=embed"
				}
			}
		},
		proto: {
			initIframe: function () {
				b.types.push(Q), x("BeforeChange", function (a, b, c) {
					b !== c && (b === Q ? S() : c === Q && S(!0))
				}), x(i + "." + Q, function () {
					S()
				})
			},
			getIframe: function (c, d) {
				var e = c.src,
					f = b.st.iframe;
				a.each(f.patterns, function () {
					return e.indexOf(this.index) > -1 ? (this.id && (e = "string" == typeof this.id ? e.substr(e.lastIndexOf(this.id) + this.id.length, e.length) : this.id.call(this, e)), e = this.src.replace("%id%", e), !1) : void 0
				});
				var g = {};
				return f.srcAction && (g[f.srcAction] = e), b._parseMarkup(d, g, c), b.updateStatus("ready"), d
			}
		}
	});
	var T = function (a) {
		var c = b.items.length;
		return a > c - 1 ? a - c : 0 > a ? c + a : a
	},
		U = function (a, b, c) {
			return a.replace(/%curr%/gi, b + 1).replace(/%total%/gi, c)
		};
	a.magnificPopup.registerModule("gallery", {
		options: {
			enabled: !1,
			arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
			preload: [0, 2],
			navigateByImgClick: !0,
			arrows: !0,
			tPrev: "Previous (Left arrow key)",
			tNext: "Next (Right arrow key)",
			tCounter: "%curr% of %total%"
		},
		proto: {
			initGallery: function () {
				var c = b.st.gallery,
					d = ".mfp-gallery",
					f = Boolean(a.fn.mfpFastClick);
				return b.direction = !0, c && c.enabled ? (g += " mfp-gallery", x(n + d, function () {
					c.navigateByImgClick && b.wrap.on("click" + d, ".mfp-img", function () {
						return b.items.length > 1 ? (b.next(), !1) : void 0
					}), e.on("keydown" + d, function (a) {
						37 === a.keyCode ? b.prev() : 39 === a.keyCode && b.next()
					})
				}), x("UpdateStatus" + d, function (a, c) {
					c.text && (c.text = U(c.text, b.currItem.index, b.items.length))
				}), x(m + d, function (a, d, e, f) {
					var g = b.items.length;
					e.counter = g > 1 ? U(c.tCounter, f.index, g) : ""
				}), x("BuildControls" + d, function () {
					if (b.items.length > 1 && c.arrows && !b.arrowLeft) {
						var d = c.arrowMarkup,
							e = b.arrowLeft = a(d.replace(/%title%/gi, c.tPrev).replace(/%dir%/gi, "left")).addClass(t),
							g = b.arrowRight = a(d.replace(/%title%/gi, c.tNext).replace(/%dir%/gi, "right")).addClass(t),
							h = f ? "mfpFastClick" : "click";
						e[h](function () {
							b.prev()
						}), g[h](function () {
							b.next()
						}), b.isIE7 && (y("b", e[0], !1, !0), y("a", e[0], !1, !0), y("b", g[0], !1, !0), y("a", g[0], !1, !0)), b.container.append(e.add(g))
					}
				}), x(o + d, function () {
					b._preloadTimeout && clearTimeout(b._preloadTimeout), b._preloadTimeout = setTimeout(function () {
						b.preloadNearbyImages(), b._preloadTimeout = null
					}, 16)
				}), void x(i + d, function () {
					e.off(d), b.wrap.off("click" + d), b.arrowLeft && f && b.arrowLeft.add(b.arrowRight).destroyMfpFastClick(), b.arrowRight = b.arrowLeft = null
				})) : !1
			},
			next: function () {
				b.direction = !0, b.index = T(b.index + 1), b.updateItemHTML()
			},
			prev: function () {
				b.direction = !1, b.index = T(b.index - 1), b.updateItemHTML()
			},
			goTo: function (a) {
				b.direction = a >= b.index, b.index = a, b.updateItemHTML()
			},
			preloadNearbyImages: function () {
				var a, c = b.st.gallery.preload,
					d = Math.min(c[0], b.items.length),
					e = Math.min(c[1], b.items.length);
				for (a = 1; a <= (b.direction ? e : d); a++) b._preloadItem(b.index + a);
				for (a = 1; a <= (b.direction ? d : e); a++) b._preloadItem(b.index - a)
			},
			_preloadItem: function (c) {
				if (c = T(c), !b.items[c].preloaded) {
					var d = b.items[c];
					d.parsed || (d = b.parseEl(c)), z("LazyLoad", d), "image" === d.type && (d.img = a('<img class="mfp-img" />').on("load.mfploader", function () {
						d.hasSize = !0
					}).on("error.mfploader", function () {
						d.hasSize = !0, d.loadError = !0, z("LazyLoadError", d)
					}).attr("src", d.src)), d.preloaded = !0
				}
			}
		}
	});
	var V = "retina";
	a.magnificPopup.registerModule(V, {
		options: {
			replaceSrc: function (a) {
				return a.src.replace(/\.\w+$/, function (a) {
					return "@2x" + a
				})
			},
			ratio: 1
		},
		proto: {
			initRetina: function () {
				if (window.devicePixelRatio > 1) {
					var a = b.st.retina,
						c = a.ratio;
					c = isNaN(c) ? c() : c, c > 1 && (x("ImageHasSize." + V, function (a, b) {
						b.img.css({
							"max-width": b.img[0].naturalWidth / c,
							width: "100%"
						})
					}), x("ElementParse." + V, function (b, d) {
						d.src = a.replaceSrc(d, c)
					}))
				}
			}
		}
	}), function () {
		var b = 1e3,
			c = "ontouchstart" in window,
			d = function () {
				w.off("touchmove" + f + " touchend" + f)
			},
			e = "mfpFastClick",
			f = "." + e;
		a.fn.mfpFastClick = function (e) {
			return a(this).each(function () {
				var g, h = a(this);
				if (c) {
					var i, j, k, l, m, n;
					h.on("touchstart" + f, function (a) {
						l = !1, n = 1, m = a.originalEvent ? a.originalEvent.touches[0] : a.touches[0], j = m.clientX, k = m.clientY, w.on("touchmove" + f, function (a) {
							m = a.originalEvent ? a.originalEvent.touches : a.touches, n = m.length, m = m[0], (Math.abs(m.clientX - j) > 10 || Math.abs(m.clientY - k) > 10) && (l = !0, d())
						}).on("touchend" + f, function (a) {
							d(), l || n > 1 || (g = !0, a.preventDefault(), clearTimeout(i), i = setTimeout(function () {
								g = !1
							}, b), e())
						})
					})
				}
				h.on("click" + f, function () {
					g || e()
				})
			})
		}, a.fn.destroyMfpFastClick = function () {
			a(this).off("touchstart" + f + " click" + f), c && w.off("touchmove" + f + " touchend" + f)
		}
	}(), B()
}(window.jQuery || window.Zepto), window.matchMedia || (window.matchMedia = function (a) {
	"use strict";
	var b = a.document,
		c = b.documentElement,
		d = [],
		e = 0,
		f = "",
		g = {},
		h = /\s*(only|not)?\s*(screen|print|[a-z\-]+)\s*(and)?\s*/i,
		i = /^\s*\(\s*(-[a-z]+-)?(min-|max-)?([a-z\-]+)\s*(:?\s*([0-9]+(\.[0-9]+)?|portrait|landscape)(px|em|dppx|dpcm|rem|%|in|cm|mm|ex|pt|pc|\/([0-9]+(\.[0-9]+)?))?)?\s*\)\s*$/,
		j = 0,
		k = function (a) {
			var b = -1 !== a.indexOf(",") && a.split(",") || [a],
				c = b.length - 1,
				d = c,
				e = null,
				j = null,
				k = "",
				l = 0,
				m = !1,
				n = "",
				o = "",
				p = null,
				q = 0,
				r = 0,
				s = null,
				t = "",
				u = "",
				v = "",
				w = "",
				x = "",
				y = !1;
			if ("" === a) return !0;
			do
			if (e = b[d - c], m = !1, j = e.match(h), j && (k = j[0], l = j.index), !j || -1 === e.substring(0, l).indexOf("(") && (l || !j[3] && k !== j.input)) y = !1;
			else {
				if (o = e, m = "not" === j[1], l || (n = j[2], o = e.substring(k.length)), y = n === f || "all" === n || "" === n, p = -1 !== o.indexOf(" and ") && o.split(" and ") || [o], q = p.length - 1, r = q, y && q >= 0 && "" !== o) do {
					if (s = p[q].match(i), !s || !g[s[3]]) {
						y = !1;
						break
					}
					if (t = s[2], u = s[5], w = u, v = s[7], x = g[s[3]], v && (w = "px" === v ? Number(u) : "em" === v || "rem" === v ? 16 * u : s[8] ? (u / s[8]).toFixed(2) : "dppx" === v ? 96 * u : "dpcm" === v ? .3937 * u : Number(u)), y = "min-" === t && w ? x >= w : "max-" === t && w ? w >= x : w ? x === w : !! x, !y) break
				} while (q--);
				if (y) break
			}
			while (c--);
			return m ? !y : y
		},
		l = function () {
			var b = a.innerWidth || c.clientWidth,
				d = a.innerHeight || c.clientHeight,
				e = a.screen.width,
				f = a.screen.height,
				h = a.screen.colorDepth,
				i = a.devicePixelRatio;
			g.width = b, g.height = d, g["aspect-ratio"] = (b / d).toFixed(2), g["device-width"] = e, g["device-height"] = f, g["device-aspect-ratio"] = (e / f).toFixed(2), g.color = h, g["color-index"] = Math.pow(2, h), g.orientation = d >= b ? "portrait" : "landscape", g.resolution = i && 96 * i || a.screen.deviceXDPI || 96, g["device-pixel-ratio"] = i || 1
		},
		m = function () {
			clearTimeout(j), j = setTimeout(function () {
				var b = null,
					c = e - 1,
					f = c,
					g = !1;
				if (c >= 0) {
					l();
					do
					if (b = d[f - c], b && (g = k(b.mql.media), (g && !b.mql.matches || !g && b.mql.matches) && (b.mql.matches = g, b.listeners))) for (var h = 0, i = b.listeners.length; i > h; h++) b.listeners[h] && b.listeners[h].call(a, b.mql);
					while (c--)
				}
			}, 10)
		},
		n = function () {
			var c = b.getElementsByTagName("head")[0],
				d = b.createElement("style"),
				e = null,
				g = ["screen", "print", "speech", "projection", "handheld", "tv", "braille", "embossed", "tty"],
				h = 0,
				i = g.length,
				j = "#mediamatchjs { position: relative; z-index: 0; }",
				k = "",
				n = a.addEventListener || (k = "on") && a.attachEvent;
			for (d.type = "text/css", d.id = "mediamatchjs", c.appendChild(d), e = a.getComputedStyle && a.getComputedStyle(d) || d.currentStyle; i > h; h++) j += "@media " + g[h] + " { #mediamatchjs { position: relative; z-index: " + h + " } }";
			d.styleSheet ? d.styleSheet.cssText = j : d.textContent = j, f = g[1 * e.zIndex || 0], c.removeChild(d), l(), n(k + "resize", m), n(k + "orientationchange", m)
		};
	return n(), function (a) {
		var b = e,
			c = {
				matches: !1,
				media: a,
				addListener: function (a) {
					d[b].listeners || (d[b].listeners = []), a && d[b].listeners.push(a)
				},
				removeListener: function (a) {
					var c = d[b],
						e = 0,
						f = 0;
					if (c) for (f = c.listeners.length; f > e; e++) c.listeners[e] === a && c.listeners.splice(e, 1)
				}
			};
		return "" === a ? (c.matches = !0, c) : (c.matches = k(a), e = d.push({
			mql: c,
			listeners: null
		}), c)
	}
}(window)), function (a, b, c) {
	var d = window.matchMedia;
	"undefined" != typeof module && module.exports ? module.exports = c(d) : "function" == typeof define && define.amd ? define(function () {
		return b[a] = c(d)
	}) : b[a] = c(d)
}("enquire", this, function (a) {
	"use strict";

	function b(a, b) {
		var c, d = 0,
			e = a.length;
		for (d; e > d && (c = b(a[d], d), c !== !1); d++);
	}
	function c(a) {
		return "[object Array]" === Object.prototype.toString.apply(a)
	}
	function d(a) {
		return "function" == typeof a
	}
	function e(a) {
		this.options = a, !a.deferSetup && this.setup()
	}
	function f(b, c) {
		this.query = b, this.isUnconditional = c, this.handlers = [], this.mql = a(b);
		var d = this;
		this.listener = function (a) {
			d.mql = a, d.assess()
		}, this.mql.addListener(this.listener)
	}
	function g() {
		if (!a) throw new Error("matchMedia not present, legacy browsers require a polyfill");
		this.queries = {}, this.browserIsIncapable = !a("only all").matches
	}
	return e.prototype = {
		setup: function () {
			this.options.setup && this.options.setup(), this.initialised = !0
		},
		on: function () {
			!this.initialised && this.setup(), this.options.match && this.options.match()
		},
		off: function () {
			this.options.unmatch && this.options.unmatch()
		},
		destroy: function () {
			this.options.destroy ? this.options.destroy() : this.off()
		},
		equals: function (a) {
			return this.options === a || this.options.match === a
		}
	}, f.prototype = {
		addHandler: function (a) {
			var b = new e(a);
			this.handlers.push(b), this.matches() && b.on()
		},
		removeHandler: function (a) {
			var c = this.handlers;
			b(c, function (b, d) {
				return b.equals(a) ? (b.destroy(), !c.splice(d, 1)) : void 0
			})
		},
		matches: function () {
			return this.mql.matches || this.isUnconditional
		},
		clear: function () {
			b(this.handlers, function (a) {
				a.destroy()
			}), this.mql.removeListener(this.listener), this.handlers.length = 0
		},
		assess: function () {
			var a = this.matches() ? "on" : "off";
			b(this.handlers, function (b) {
				b[a]()
			})
		}
	}, g.prototype = {
		register: function (a, e, g) {
			var h = this.queries,
				i = g && this.browserIsIncapable;
			return h[a] || (h[a] = new f(a, i)), d(e) && (e = {
				match: e
			}), c(e) || (e = [e]), b(e, function (b) {
				h[a].addHandler(b)
			}), this
		},
		unregister: function (a, b) {
			var c = this.queries[a];
			return c && (b ? c.removeHandler(b) : (c.clear(), delete this.queries[a])), this
		}
	}, new g
}), function (a) {
	"use strict";
	a.picturefill = function () {
		var b = $("span[data-picture]"),
			c = !1;
		$.each(b, function (b, d) {
			var e = $(d),
				f = e.parents(".royalSlider");
			if (1 === f.length) if (1 === f.parent().data("total"));
			else if (0 === e.parents(".rsContainer").length) return !0;
			var g = null;
			if ("true" === e.attr("data-filterby-orientation")) {
				var h = "landscape";
				e.height() > e.width() && (h = "portrait"), g = $("> span[data-orientation='" + h + "']", e)
			} else g = $("> span", e);
			var i = [];
			$.each(g, function (b, c) {
				var d = $(c),
					e = d.attr("data-media");
				(!e || a.matchMedia && a.matchMedia(e).matches) && i.push(d)
			});
			var j = $(".image", e),
				k = null;
			if (0 !== i.length) {
				var l = i.pop(),
					m = !0;
				if (e.hasClass("backgroundImage")) {
					var n = location.protocol + "//" + location.host,
						o = e.css("background-image"),
						p = '"',
						q = new RegExp(p, "g");
					o = o.replace(q, ""), p = "'", q = new RegExp(p, "g"), o = o.replace(q, ""), "none" === o ? m = !1 : (o === "url(" + l.attr("data-src") + ")" || o === "url(" + n + l.attr("data-src") + ")") && (m = !1)
				} else if (0 !== j.length) {
					var r = $(j[0]);
					r.parent()[0] !== l[0] ? r.remove() : m = !1
				}
				if (m === !0) {
					if (c = !0, "" === l.attr("data-src")) return void(c = !1);
					if ("undefined" != typeof e.attr("data-background-image")) {
						"data:" === e.css("background-image").substring(5, 10) && (c = !1), e.addClass("image backgroundImage").css({
							"background-image": "url(" + l.attr("data-src") + ")"
						});
						var s = e.data("align");
						"undefined" !== s && e.css("background-position", s)
					} else l.append('<img class="image" />'), k = $("img.image", l), k.attr("alt", e.attr("data-alt")), k.attr("src", l.attr("data-src"))
				}
			}
		}), c === !0 && $(window).trigger("resize")
	}
}(this), function (a) {
	"use strict";

	function b(a, b, c) {
		return a.addEventListener ? a.addEventListener(b, c, !1) : a.attachEvent ? a.attachEvent("on" + b, c) : void 0
	}
	function c(a, b) {
		var c, d;
		for (c = 0, d = a.length; d > c; c++) if (a[c] === b) return !0;
		return !1
	}
	function d(a, b) {
		var c;
		a.createTextRange ? (c = a.createTextRange(), c.move("character", b), c.select()) : a.selectionStart && (a.focus(), a.setSelectionRange(b, b))
	}
	function e(a, b) {
		try {
			return a.type = b, !0
		} catch (c) {
			return !1
		}
	}
	a.Placeholders = {
		Utils: {
			addEventListener: b,
			inArray: c,
			moveCaret: d,
			changeType: e
		}
	}
}(this), function (a) {
	"use strict";

	function b() {}
	function c() {
		try {
			return document.activeElement
		} catch (a) {}
	}
	function d(a, b) {
		var c, d, e = !! b && a.value !== b,
			f = a.value === a.getAttribute(H);
		return (e || f) && "true" === a.getAttribute(I) ? (a.removeAttribute(I), a.value = a.value.replace(a.getAttribute(H), ""), a.className = a.className.replace(G, ""), d = a.getAttribute(O), parseInt(d, 10) >= 0 && (a.setAttribute("maxLength", d), a.removeAttribute(O)), c = a.getAttribute(J), c && (a.type = c), !0) : !1
	}
	function e(a) {
		var b, c, d = a.getAttribute(H);
		return "" === a.value && d ? (a.setAttribute(I, "true"), a.value = d, a.className += " " + F, c = a.getAttribute(O), c || (a.setAttribute(O, a.maxLength), a.removeAttribute("maxLength")), b = a.getAttribute(J), b ? a.type = "text" : "password" === a.type && T.changeType(a, "text") && a.setAttribute(J, "password"), !0) : !1
	}
	function f(a, b) {
		var c, d, e, f, g, h, i;
		if (a && a.getAttribute(H)) b(a);
		else for (e = a ? a.getElementsByTagName("input") : p, f = a ? a.getElementsByTagName("textarea") : q, c = e ? e.length : 0, d = f ? f.length : 0, i = 0, h = c + d; h > i; i++) g = c > i ? e[i] : f[i - c], b(g)
	}
	function g(a) {
		f(a, d)
	}
	function h(a) {
		f(a, e)
	}
	function i(a) {
		return function () {
			r && a.value === a.getAttribute(H) && "true" === a.getAttribute(I) ? T.moveCaret(a, 0) : d(a)
		}
	}
	function j(a) {
		return function () {
			e(a)
		}
	}
	function k(a) {
		return function (b) {
			return t = a.value, "true" === a.getAttribute(I) && t === a.getAttribute(H) && T.inArray(D, b.keyCode) ? (b.preventDefault && b.preventDefault(), !1) : void 0
		}
	}
	function l(a) {
		return function () {
			d(a, t), "" === a.value && (a.blur(), T.moveCaret(a, 0))
		}
	}
	function m(a) {
		return function () {
			a === c() && a.value === a.getAttribute(H) && "true" === a.getAttribute(I) && T.moveCaret(a, 0)
		}
	}
	function n(a) {
		return function () {
			g(a)
		}
	}
	function o(a) {
		a.form && (y = a.form, "string" == typeof y && (y = document.getElementById(y)), y.getAttribute(K) || (T.addEventListener(y, "submit", n(y)), y.setAttribute(K, "true"))), T.addEventListener(a, "focus", i(a)), T.addEventListener(a, "blur", j(a)), r && (T.addEventListener(a, "keydown", k(a)), T.addEventListener(a, "keyup", l(a)), T.addEventListener(a, "click", m(a))), a.setAttribute(L, "true"), a.setAttribute(H, w), (r || a !== c()) && e(a)
	}
	var p, q, r, s, t, u, v, w, x, y, z, A, B, C = ["text", "search", "url", "tel", "email", "password", "number", "textarea"],
		D = [27, 33, 34, 35, 36, 37, 38, 39, 40, 8, 46],
		E = "#ccc",
		F = "placeholdersjs",
		G = new RegExp("(?:^|\\s)" + F + "(?!\\S)"),
		H = "data-placeholder-value",
		I = "data-placeholder-active",
		J = "data-placeholder-type",
		K = "data-placeholder-submit",
		L = "data-placeholder-bound",
		M = "data-placeholder-focus",
		N = "data-placeholder-live",
		O = "data-placeholder-maxlength",
		P = document.createElement("input"),
		Q = document.getElementsByTagName("head")[0],
		R = document.documentElement,
		S = a.Placeholders,
		T = S.Utils;
	if (S.nativeSupport = void 0 !== P.placeholder, !S.nativeSupport) {
		for (p = document.getElementsByTagName("input"), q = document.getElementsByTagName("textarea"), r = "false" === R.getAttribute(M), s = "false" !== R.getAttribute(N), u = document.createElement("style"), u.type = "text/css", v = document.createTextNode("." + F + " { color:" + E + "; }"), u.styleSheet ? u.styleSheet.cssText = v.nodeValue : u.appendChild(v), Q.insertBefore(u, Q.firstChild), B = 0, A = p.length + q.length; A > B; B++) z = B < p.length ? p[B] : q[B - p.length], w = z.attributes.placeholder, w && (w = w.nodeValue, w && T.inArray(C, z.type) && o(z));
		x = setInterval(function () {
			for (B = 0, A = p.length + q.length; A > B; B++) z = B < p.length ? p[B] : q[B - p.length], w = z.attributes.placeholder, w ? (w = w.nodeValue, w && T.inArray(C, z.type) && (z.getAttribute(L) || o(z), (w !== z.getAttribute(H) || "password" === z.type && !z.getAttribute(J)) && ("password" === z.type && !z.getAttribute(J) && T.changeType(z, "text") && z.setAttribute(J, "password"), z.value === z.getAttribute(H) && (z.value = w), z.setAttribute(H, w)))) : z.getAttribute(I) && (d(z), z.removeAttribute(H));
			s || clearInterval(x)
		}, 100)
	}
	T.addEventListener(a, "beforeunload", function () {
		S.disable()
	}), S.disable = S.nativeSupport ? b : g, S.enable = S.nativeSupport ? b : h
}(this), "createTouch" in document) try {
	var pattern = /:hover\b/,
		sheet, rule, selectors, newSelector, selectorAdded, newRule, i, j, k;
	for (i = 0; i < document.styleSheets.length; i++) for (sheet = document.styleSheets[i], j = sheet.cssRules.length - 1; j >= 0; j--) if (rule = sheet.cssRules[j], rule.type === CSSRule.STYLE_RULE && pattern.test(rule.selectorText)) {
		for (selectors = rule.selectorText.split(","), newSelector = "", selectorAdded = !1, k = 0; k < selectors.length; k++) pattern.test(selectors[k]) || (selectorAdded ? newSelector += ", " + selectors[k] : (newSelector += selectors[k], selectorAdded = !0));
		selectorAdded ? (newRule = rule.cssText.replace(/([^{]*)?/, newSelector + " "), sheet.deleteRule(j), sheet.insertRule(newRule, j)) : sheet.deleteRule(j)
	}
} catch (e) {}!
function (a) {
	"use strict";

	function b() {
		v(!0)
	}
	var c = {};
	a.respond = c, c.update = function () {};
	var d = [],
		e = function () {
			var b = !1;
			try {
				b = new a.XMLHttpRequest
			} catch (c) {
				b = new a.ActiveXObject("Microsoft.XMLHTTP")
			}
			return function () {
				return b
			}
		}(),
		f = function (a, b) {
			var c = e();
			c && (c.open("GET", a, !0), c.onreadystatechange = function () {
				4 !== c.readyState || 200 !== c.status && 304 !== c.status || b(c.responseText)
			}, 4 !== c.readyState && c.send(null))
		},
		g = function (a) {
			return a.replace(c.regex.minmaxwh, "").match(c.regex.other)
		};
	if (c.ajax = f, c.queue = d, c.unsupportedmq = g, c.regex = {
		media: /@media[^\{]+\{([^\{\}]*\{[^\}\{]*\})+/gi,
		keyframes: /@(?:\-(?:o|moz|webkit)\-)?keyframes[^\{]+\{(?:[^\{\}]*\{[^\}\{]*\})+[^\}]*\}/gi,
		comments: /\/\*[^*]*\*+([^/][^*]*\*+)*\//gi,
		urls: /(url\()['"]?([^\/\)'"][^:\)'"]+)['"]?(\))/g,
		findStyles: /@media *([^\{]+)\{([\S\s]+?)$/,
		only: /(only\s+)?([a-zA-Z]+)\s?/,
		minw: /\(\s*min\-width\s*:\s*(\s*[0-9\.]+)(px|em)\s*\)/,
		maxw: /\(\s*max\-width\s*:\s*(\s*[0-9\.]+)(px|em)\s*\)/,
		minmaxwh: /\(\s*m(in|ax)\-(height|width)\s*:\s*(\s*[0-9\.]+)(px|em)\s*\)/gi,
		other: /\([^\)]*\)/g
	}, c.mediaQueriesSupported = a.matchMedia && null !== a.matchMedia("only all") && a.matchMedia("only all").matches, !c.mediaQueriesSupported) {
		var h, i, j, k = a.document,
			l = k.documentElement,
			m = [],
			n = [],
			o = [],
			p = {},
			q = 30,
			r = k.getElementsByTagName("head")[0] || l,
			s = k.getElementsByTagName("base")[0],
			t = r.getElementsByTagName("link"),
			u = function () {
				var a, b = k.createElement("div"),
					c = k.body,
					d = l.style.fontSize,
					e = c && c.style.fontSize,
					f = !1;
				return b.style.cssText = "position:absolute;font-size:1em;width:1em", c || (c = f = k.createElement("body"), c.style.background = "none"), l.style.fontSize = "100%", c.style.fontSize = "100%", c.appendChild(b), f && l.insertBefore(c, l.firstChild), a = b.offsetWidth, f ? l.removeChild(c) : c.removeChild(b), l.style.fontSize = d, e && (c.style.fontSize = e), a = j = parseFloat(a)
			},
			v = function (b) {
				var c = "clientWidth",
					d = l[c],
					e = "CSS1Compat" === k.compatMode && d || k.body[c] || d,
					f = {},
					g = t[t.length - 1],
					p = (new Date).getTime();
				if (b && h && q > p - h) return a.clearTimeout(i), void(i = a.setTimeout(v, q));
				h = p;
				for (var s in m) if (m.hasOwnProperty(s)) {
					var w = m[s],
						x = w.minw,
						y = w.maxw,
						z = null === x,
						A = null === y,
						B = "em";
					x && (x = parseFloat(x) * (x.indexOf(B) > -1 ? j || u() : 1)), y && (y = parseFloat(y) * (y.indexOf(B) > -1 ? j || u() : 1)), w.hasquery && (z && A || !(z || e >= x) || !(A || y >= e)) || (f[w.media] || (f[w.media] = []), f[w.media].push(n[w.rules]))
				}
				for (var C in o) o.hasOwnProperty(C) && o[C] && o[C].parentNode === r && r.removeChild(o[C]);
				o.length = 0;
				for (var D in f) if (f.hasOwnProperty(D)) {
					var E = k.createElement("style"),
						F = f[D].join("\n");
					E.type = "text/css", E.media = D, r.insertBefore(E, g.nextSibling), E.styleSheet ? E.styleSheet.cssText = F : E.appendChild(k.createTextNode(F)), o.push(E)
				}
			},
			w = function (a, b, d) {
				var e = a.replace(c.regex.comments, "").replace(c.regex.keyframes, "").match(c.regex.media),
					f = e && e.length || 0;
				b = b.substring(0, b.lastIndexOf("/"));
				var h = function (a) {
					return a.replace(c.regex.urls, "$1" + b + "$2$3")
				},
					i = !f && d;
				b.length && (b += "/"), i && (f = 1);
				for (var j = 0; f > j; j++) {
					var k, l, o, p;
					i ? (k = d, n.push(h(a))) : (k = e[j].match(c.regex.findStyles) && RegExp.$1, n.push(RegExp.$2 && h(RegExp.$2))), o = k.split(","), p = o.length;
					for (var q = 0; p > q; q++) l = o[q], g(l) || m.push({
						media: l.split("(")[0].match(c.regex.only) && RegExp.$2 || "all",
						rules: n.length - 1,
						hasquery: l.indexOf("(") > -1,
						minw: l.match(c.regex.minw) && parseFloat(RegExp.$1) + (RegExp.$2 || ""),
						maxw: l.match(c.regex.maxw) && parseFloat(RegExp.$1) + (RegExp.$2 || "")
					})
				}
				v()
			},
			x = function () {
				if (d.length) {
					var b = d.shift();
					f(b.href, function (c) {
						w(c, b.href, b.media), p[b.href] = !0, a.setTimeout(function () {
							x()
						}, 0)
					})
				}
			},
			y = function () {
				for (var b = 0; b < t.length; b++) {
					var c = t[b],
						e = c.href,
						f = c.media,
						g = c.rel && "stylesheet" === c.rel.toLowerCase();
					e && g && !p[e] && (c.styleSheet && c.styleSheet.rawCssText ? (w(c.styleSheet.rawCssText, e, f), p[e] = !0) : (!/^([a-zA-Z:]*\/\/)/.test(e) && !s || e.replace(RegExp.$1, "").split("/")[0] === a.location.host) && ("//" === e.substring(0, 2) && (e = a.location.protocol + e), d.push({
						href: e,
						media: f
					})))
				}
				x()
			};
		y(), c.update = y, c.getEmValue = u, a.addEventListener ? a.addEventListener("resize", b, !1) : a.attachEvent && a.attachEvent("onresize", b)
	}
}(this), function (a) {
	return
}(this), function (a, b) {
	var c = function (a, b, c) {
		var d;
		return function () {
			function e() {
				c || a.apply(f, g), d = null
			}
			var f = this,
				g = arguments;
			d ? clearTimeout(d) : c && a.apply(f, g), d = setTimeout(e, b || 100)
		}
	};
	jQuery.fn[b] = a("html").hasClass("lt-ie9") ?
	function (a) {
		return a ? this.bind("ieResize", c(a)) : this.trigger(b)
	} : function (a) {
		return a ? this.bind("resize", c(a)) : this.trigger(b)
	}
}(jQuery, "smartresize");
var smartresize_windowWidth = 0,
	smartresize_windowHeight = 0;
$("html").hasClass("lt-ie9") && (document.body.onresize = function () {
	(smartresize_windowWidth !== document.documentElement.clientWidth || smartresize_windowHeight !== document.documentElement.clientHeight) && (smartresize_windowWidth = document.documentElement.clientWidth, smartresize_windowHeight = document.documentElement.clientHeight, $(window).trigger("ieResize"))
}), function (a, b) {
	"$:nomunge";
	var c, d = a.jQuery || a.Cowboy || (a.Cowboy = {});
	d.throttle = c = function (a, c, e, f) {
		function g() {
			function d() {
				i = +new Date, e.apply(j, l)
			}
			function g() {
				h = b
			}
			var j = this,
				k = +new Date - i,
				l = arguments;
			f && !h && d(), h && clearTimeout(h), f === b && k > a ? d() : c !== !0 && (h = setTimeout(f ? g : d, f === b ? a - k : a))
		}
		var h, i = 0;
		return "boolean" != typeof c && (f = e, e = c, c = b), d.guid && (g.guid = e.guid = e.guid || d.guid++), g
	}, d.debounce = function (a, d, e) {
		return e === b ? c(a, d, !1) : c(a, e, d !== !1)
	}
}(this), function (a) {
	function b(a) {
		if (a in l.style) return a;
		var b = ["Moz", "Webkit", "O", "ms"],
			c = a.charAt(0).toUpperCase() + a.substr(1);
		if (a in l.style) return a;
		for (var d = 0; d < b.length; ++d) {
			var e = b[d] + c;
			if (e in l.style) return e
		}
	}
	function c() {
		return l.style[m.transform] = "", l.style[m.transform] = "rotateY(90deg)", "" !== l.style[m.transform]
	}
	function d(a) {
		return "string" == typeof a && this.parse(a), this
	}
	function e(a, b, c) {
		b === !0 ? a.queue(c) : b ? a.queue(b, c) : c()
	}
	function f(b) {
		var c = [];
		return a.each(b, function (b) {
			b = a.camelCase(b), b = a.transit.propertyMap[b] || a.cssProps[b] || b, b = i(b), m[b] && (b = i(m[b])), -1 === a.inArray(b, c) && c.push(b)
		}), c
	}
	function g(b, c, d, e) {
		var g = f(b);
		a.cssEase[d] && (d = a.cssEase[d]);
		var h = "" + k(c) + " " + d;
		parseInt(e, 10) > 0 && (h += " " + k(e));
		var i = [];
		return a.each(g, function (a, b) {
			i.push(b + " " + h)
		}), i.join(", ")
	}
	function h(b, c) {
		c || (a.cssNumber[b] = !0), a.transit.propertyMap[b] = m.transform, a.cssHooks[b] = {
			get: function (c) {
				var d = a(c).css("transit:transform");
				return d.get(b)
			},
			set: function (c, d) {
				var e = a(c).css("transit:transform");
				e.setFromString(b, d), a(c).css({
					"transit:transform": e
				})
			}
		}
	}
	function i(a) {
		return a.replace(/([A-Z])/g, function (a) {
			return "-" + a.toLowerCase()
		})
	}
	function j(a, b) {
		return "string" != typeof a || a.match(/^[\-0-9\.]+$/) ? "" + a + b : a
	}
	function k(b) {
		var c = b;
		return "string" != typeof c || c.match(/^[\-0-9\.]+/) || (c = a.fx.speeds[c] || a.fx.speeds._default), j(c, "ms")
	}
	a.transit = {
		version: "0.9.9",
		propertyMap: {
			marginLeft: "margin",
			marginRight: "margin",
			marginBottom: "margin",
			marginTop: "margin",
			paddingLeft: "padding",
			paddingRight: "padding",
			paddingBottom: "padding",
			paddingTop: "padding"
		},
		enabled: !0,
		useTransitionEnd: !1
	};
	var l = document.createElement("div"),
		m = {},
		n = navigator.userAgent.toLowerCase().indexOf("chrome") > -1;
	m.transition = b("transition"), m.transitionDelay = b("transitionDelay"), m.transform = b("transform"), m.transformOrigin = b("transformOrigin"), m.filter = b("Filter"), m.transform3d = c();
	var o = {
		transition: "transitionEnd",
		MozTransition: "transitionend",
		OTransition: "oTransitionEnd",
		WebkitTransition: "webkitTransitionEnd",
		msTransition: "MSTransitionEnd"
	},
		p = m.transitionEnd = o[m.transition] || null;
	for (var q in m) m.hasOwnProperty(q) && "undefined" == typeof a.support[q] && (a.support[q] = m[q]);
	l = null, a.cssEase = {
		_default: "ease",
		"in": "ease-in",
		out: "ease-out",
		"in-out": "ease-in-out",
		snap: "cubic-bezier(0,1,.5,1)",
		easeOutCubic: "cubic-bezier(.215,.61,.355,1)",
		easeInOutCubic: "cubic-bezier(.645,.045,.355,1)",
		easeInCirc: "cubic-bezier(.6,.04,.98,.335)",
		easeOutCirc: "cubic-bezier(.075,.82,.165,1)",
		easeInOutCirc: "cubic-bezier(.785,.135,.15,.86)",
		easeInExpo: "cubic-bezier(.95,.05,.795,.035)",
		easeOutExpo: "cubic-bezier(.19,1,.22,1)",
		easeInOutExpo: "cubic-bezier(1,0,0,1)",
		easeInQuad: "cubic-bezier(.55,.085,.68,.53)",
		easeOutQuad: "cubic-bezier(.25,.46,.45,.94)",
		easeInOutQuad: "cubic-bezier(.455,.03,.515,.955)",
		easeInQuart: "cubic-bezier(.895,.03,.685,.22)",
		easeOutQuart: "cubic-bezier(.165,.84,.44,1)",
		easeInOutQuart: "cubic-bezier(.77,0,.175,1)",
		easeInQuint: "cubic-bezier(.755,.05,.855,.06)",
		easeOutQuint: "cubic-bezier(.23,1,.32,1)",
		easeInOutQuint: "cubic-bezier(.86,0,.07,1)",
		easeInSine: "cubic-bezier(.47,0,.745,.715)",
		easeOutSine: "cubic-bezier(.39,.575,.565,1)",
		easeInOutSine: "cubic-bezier(.445,.05,.55,.95)",
		easeInBack: "cubic-bezier(.6,-.28,.735,.045)",
		easeOutBack: "cubic-bezier(.175, .885,.32,1.275)",
		easeInOutBack: "cubic-bezier(.68,-.55,.265,1.55)"
	}, a.cssHooks["transit:transform"] = {
		get: function (b) {
			return a(b).data("transform") || new d
		},
		set: function (b, c) {
			var e = c;
			e instanceof d || (e = new d(e)), b.style[m.transform] = "WebkitTransform" !== m.transform || n ? e.toString() : e.toString(!0), a(b).data("transform", e)
		}
	}, a.cssHooks.transform = {
		set: a.cssHooks["transit:transform"].set
	}, a.cssHooks.filter = {
		get: function (a) {
			return a.style[m.filter]
		},
		set: function (a, b) {
			a.style[m.filter] = b
		}
	}, a.fn.jquery < "1.8" && (a.cssHooks.transformOrigin = {
		get: function (a) {
			return a.style[m.transformOrigin]
		},
		set: function (a, b) {
			a.style[m.transformOrigin] = b
		}
	}, a.cssHooks.transition = {
		get: function (a) {
			return a.style[m.transition]
		},
		set: function (a, b) {
			a.style[m.transition] = b
		}
	}), h("scale"), h("translate"), h("rotate"), h("rotateX"), h("rotateY"), h("rotate3d"), h("perspective"), h("skewX"), h("skewY"), h("x", !0), h("y", !0), d.prototype = {
		setFromString: function (a, b) {
			var c = "string" == typeof b ? b.split(",") : b.constructor === Array ? b : [b];
			c.unshift(a), d.prototype.set.apply(this, c)
		},
		set: function (a) {
			var b = Array.prototype.slice.apply(arguments, [1]);
			this.setter[a] ? this.setter[a].apply(this, b) : this[a] = b.join(",")
		},
		get: function (a) {
			return this.getter[a] ? this.getter[a].apply(this) : this[a] || 0
		},
		setter: {
			rotate: function (a) {
				this.rotate = j(a, "deg")
			},
			rotateX: function (a) {
				this.rotateX = j(a, "deg")
			},
			rotateY: function (a) {
				this.rotateY = j(a, "deg")
			},
			scale: function (a, b) {
				void 0 === b && (b = a), this.scale = a + "," + b
			},
			skewX: function (a) {
				this.skewX = j(a, "deg")
			},
			skewY: function (a) {
				this.skewY = j(a, "deg")
			},
			perspective: function (a) {
				this.perspective = j(a, "px")
			},
			x: function (a) {
				this.set("translate", a, null)
			},
			y: function (a) {
				this.set("translate", null, a)
			},
			translate: function (a, b) {
				void 0 === this._translateX && (this._translateX = 0), void 0 === this._translateY && (this._translateY = 0), null !== a && void 0 !== a && (this._translateX = j(a, "px")), null !== b && void 0 !== b && (this._translateY = j(b, "px")), this.translate = this._translateX + "," + this._translateY
			}
		},
		getter: {
			x: function () {
				return this._translateX || 0
			},
			y: function () {
				return this._translateY || 0
			},
			scale: function () {
				var a = (this.scale || "1,1").split(",");
				return a[0] && (a[0] = parseFloat(a[0])), a[1] && (a[1] = parseFloat(a[1])), a[0] === a[1] ? a[0] : a
			},
			rotate3d: function () {
				for (var a = (this.rotate3d || "0,0,0,0deg").split(","), b = 0; 3 >= b; ++b) a[b] && (a[b] = parseFloat(a[b]));
				return a[3] && (a[3] = j(a[3], "deg")), a
			}
		},
		parse: function (a) {
			var b = this;
			a.replace(/([a-zA-Z0-9]+)\((.*?)\)/g, function (a, c, d) {
				b.setFromString(c, d)
			})
		},
		toString: function (a) {
			var b = [];
			for (var c in this) if (this.hasOwnProperty(c)) {
				if (!m.transform3d && ("rotateX" === c || "rotateY" === c || "perspective" === c || "transformOrigin" === c)) continue;
				"_" !== c[0] && b.push(a && "scale" === c ? c + "3d(" + this[c] + ",1)" : a && "translate" === c ? c + "3d(" + this[c] + ",0)" : c + "(" + this[c] + ")")
			}
			return b.join(" ")
		}
	}, a.fn.transition = a.fn.transit = function (b, c, d, f) {
		var h = this,
			i = 0,
			j = !0,
			l = jQuery.extend(!0, {}, b);
		"function" == typeof c && (f = c, c = void 0), "object" == typeof c && (d = c.easing, i = c.delay || 0, j = c.queue || !0, f = c.complete, c = c.duration), "function" == typeof d && (f = d, d = void 0), "undefined" != typeof l.easing && (d = l.easing, delete l.easing), "undefined" != typeof l.duration && (c = l.duration, delete l.duration), "undefined" != typeof l.complete && (f = l.complete, delete l.complete), "undefined" != typeof l.queue && (j = l.queue, delete l.queue), "undefined" != typeof l.delay && (i = l.delay, delete l.delay), "undefined" == typeof c && (c = a.fx.speeds._default), "undefined" == typeof d && (d = a.cssEase._default), c = k(c);
		var n = g(l, c, d, i),
			o = a.transit.enabled && m.transition,
			q = o ? parseInt(c, 10) + parseInt(i, 10) : 0;
		if (0 === q) {
			var r = function (a) {
				h.css(l), f && f.apply(h), a && a()
			};
			return e(h, j, r), h
		}
		var s = {},
			t = function (c) {
				var d = !1,
					e = function () {
						d && h.unbind(p, e), q > 0 && h.each(function () {
							this.style[m.transition] = s[this] || null
						}), "function" == typeof f && f.apply(h), "function" == typeof c && c()
					};
				q > 0 && p && a.transit.useTransitionEnd ? (d = !0, h.bind(p, e)) : window.setTimeout(e, q), h.each(function () {
					q > 0 && (this.style[m.transition] = n), a(this).css(b)
				})
			},
			u = function (a) {
				this.offsetWidth, t(a)
			};
		return e(h, j, u), this
	}, a.transit.getTransitionValue = g
}(jQuery), function (a) {
	var b = "waitForImages";
	a.waitForImages = {
		hasImageProperties: ["backgroundImage", "listStyleImage", "borderImage", "borderCornerImage", "cursor"]
	}, a.expr[":"].uncached = function (b) {
		if (!a(b).is('img[src!=""]')) return !1;
		var c = new Image;
		return c.src = b.src, !c.complete
	}, a.fn.waitForImages = function (c, d, e) {
		var f = 0,
			g = 0;
		if (a.isPlainObject(arguments[0]) && (e = arguments[0].waitForAll, d = arguments[0].each, c = arguments[0].finished), c = c || a.noop, d = d || a.noop, e = !! e, !a.isFunction(c) || !a.isFunction(d)) throw new TypeError("An invalid callback was supplied.");
		return this.each(function () {
			var h = a(this),
				i = [],
				j = a.waitForImages.hasImageProperties || [],
				k = /url\(\s*(['"]?)(.*?)\1\s*\)/g;
			e ? h.find("*").addBack().each(function () {
				var b = a(this);
				b.is("img:uncached") && i.push({
					src: b.attr("src"),
					element: b[0]
				}), a.each(j, function (a, c) {
					var d, e = b.css(c);
					if (!e) return !0;
					for (; d = k.exec(e);) i.push({
						src: d[2],
						element: b[0]
					})
				})
			}) : h.find("img:uncached").each(function () {
				i.push({
					src: this.src,
					element: this
				})
			}), f = i.length, g = 0, 0 === f && c.call(h[0]), a.each(i, function (e, i) {
				var j = new Image;
				a(j).on("load." + b + " error." + b, function (a) {
					return g++, d.call(i.element, g, f, "load" == a.type), g == f ? (c.call(h[0]), !1) : void 0
				}), j.src = i.src
			})
		})
	}
}(jQuery), function (a) {
	function b(b, c) {
		var d, e = this,
			f = window.navigator,
			g = f.userAgent.toLowerCase();
		e.uid = a.rsModules.uid++, e.ns = ".rs" + e.uid;
		var h, i = document.createElement("div").style,
			j = ["webkit", "Moz", "ms", "O"],
			k = "",
			l = 0;
		for (d = 0; d < j.length; d++) h = j[d], !k && h + "Transform" in i && (k = h), h = h.toLowerCase(), window.requestAnimationFrame || (window.requestAnimationFrame = window[h + "RequestAnimationFrame"], window.cancelAnimationFrame = window[h + "CancelAnimationFrame"] || window[h + "CancelRequestAnimationFrame"]);
		window.requestAnimationFrame || (window.requestAnimationFrame = function (a) {
			var b = (new Date).getTime(),
				c = Math.max(0, 16 - (b - l)),
				d = window.setTimeout(function () {
					a(b + c)
				}, c);
			return l = b + c, d
		}), window.cancelAnimationFrame || (window.cancelAnimationFrame = function (a) {
			clearTimeout(a)
		}), e.isIPAD = g.match(/(ipad)/), e.isIOS = e.isIPAD || g.match(/(iphone|ipod)/), d = function (a) {
			return a = /(chrome)[ \/]([\w.]+)/.exec(a) || /(webkit)[ \/]([\w.]+)/.exec(a) || /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(a) || /(msie) ([\w.]+)/.exec(a) || 0 > a.indexOf("compatible") && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(a) || [], {
				browser: a[1] || "",
				version: a[2] || "0"
			}
		}(g), j = {}, d.browser && (j[d.browser] = !0, j.version = d.version), j.chrome && (j.webkit = !0), e._a = j, e.isAndroid = -1 < g.indexOf("android"), e.slider = a(b), e.ev = a(e), e._b = a(document), e.st = a.extend({}, a.fn.royalSlider.defaults, c), e._c = e.st.transitionSpeed, e._d = 0, !e.st.allowCSS3 || j.webkit && !e.st.allowCSS3OnWebkit || (d = k + (k ? "T" : "t"), e._e = d + "ransform" in i && d + "ransition" in i, e._e && (e._f = k + (k ? "P" : "p") + "erspective" in i)), k = k.toLowerCase(), e._g = "-" + k + "-", e._h = "vertical" === e.st.slidesOrientation ? !1 : !0, e._i = e._h ? "left" : "top", e._j = e._h ? "width" : "height", e._k = -1, e._l = "fade" === e.st.transitionType ? !1 : !0, e._l || (e.st.sliderDrag = !1, e._m = 10), e._n = "z-index:0; display:none; opacity:0;", e._o = 0, e._p = 0, e._q = 0, a.each(a.rsModules, function (a, b) {
			"uid" !== a && b.call(e)
		}), e.slides = [], e._r = 0, (e.st.slides ? a(e.st.slides) : e.slider.children().detach()).each(function () {
			e._s(this, !0)
		}), e.st.randomizeSlides && e.slides.sort(function () {
			return.5 - Math.random()
		}), e.numSlides = e.slides.length, e._t(), e.st.startSlideId ? e.st.startSlideId > e.numSlides - 1 && (e.st.startSlideId = e.numSlides - 1) : e.st.startSlideId = 0, e._o = e.staticSlideId = e.currSlideId = e._u = e.st.startSlideId, e.currSlide = e.slides[e.currSlideId], e._v = 0, e.pointerMultitouch = !1, e.slider.addClass((e._h ? "rsHor" : "rsVer") + (e._l ? "" : " rsFade")), i = '<div class="rsOverflow"><div class="rsContainer">', e.slidesSpacing = e.st.slidesSpacing, e._w = (e._h ? e.slider.width() : e.slider.height()) + e.st.slidesSpacing, e._x = Boolean(0 < e._y), 1 >= e.numSlides && (e._z = !1), e._a1 = e._z && e._l ? 2 === e.numSlides ? 1 : 2 : 0, e._b1 = 6 > e.numSlides ? e.numSlides : 6, e._c1 = 0, e._d1 = 0, e.slidesJQ = [];
		for (d = 0; d < e.numSlides; d++) e.slidesJQ.push(a('<div style="' + (e._l ? "" : d !== e.currSlideId ? e._n : "z-index:0;") + '" class="rsSlide "></div>'));
		e._e1 = i = a(i + "</div></div>");
		var m = e.ns,
			k = function (a, b, c, d, f) {
				e._j1 = a + b + m, e._k1 = a + c + m, e._l1 = a + d + m, f && (e._m1 = a + f + m)
			};
		d = f.pointerEnabled, e.pointerEnabled = d || f.msPointerEnabled, e.pointerEnabled ? (e.hasTouch = !1, e._n1 = .2, e.pointerMultitouch = Boolean(1 < f[(d ? "m" : "msM") + "axTouchPoints"]), d ? k("pointer", "down", "move", "up", "cancel") : k("MSPointer", "Down", "Move", "Up", "Cancel")) : (e.isIOS ? e._j1 = e._k1 = e._l1 = e._m1 = "" : k("mouse", "down", "move", "up"), "ontouchstart" in window || "createTouch" in document ? (e.hasTouch = !0, e._j1 += " touchstart" + m, e._k1 += " touchmove" + m, e._l1 += " touchend" + m, e._m1 += " touchcancel" + m, e._n1 = .5, e.st.sliderTouch && (e._f1 = !0)) : (e.hasTouch = !1, e._n1 = .2)), e.st.sliderDrag && (e._f1 = !0, j.msie || j.opera ? e._g1 = e._h1 = "move" : j.mozilla ? (e._g1 = "-moz-grab", e._h1 = "-moz-grabbing") : j.webkit && -1 != f.platform.indexOf("Mac") && (e._g1 = "-webkit-grab", e._h1 = "-webkit-grabbing"), e._i1()), e.slider.html(i), e._o1 = e.st.controlsInside ? e._e1 : e.slider, e._p1 = e._e1.children(".rsContainer"), e.pointerEnabled && e._p1.css((d ? "" : "-ms-") + "touch-action", e._h ? "pan-y" : "pan-x"), e._q1 = a('<div class="rsPreloader"></div>'), f = e._p1.children(".rsSlide"), e._r1 = e.slidesJQ[e.currSlideId], e._s1 = 0, e._e ? (e._t1 = "transition-property", e._u1 = "transition-duration", e._v1 = "transition-timing-function", e._w1 = e._x1 = e._g + "transform", e._f ? (j.webkit && !j.chrome && e.slider.addClass("rsWebkit3d"), e._y1 = "translate3d(", e._z1 = "px, ", e._a2 = "px, 0px)") : (e._y1 = "translate(", e._z1 = "px, ", e._a2 = "px)"), e._l ? e._p1[e._g + e._t1] = e._g + "transform" : (j = {}, j[e._g + e._t1] = "opacity", j[e._g + e._u1] = e.st.transitionSpeed + "ms", j[e._g + e._v1] = e.st.css3easeInOut, f.css(j))) : (e._x1 = "left", e._w1 = "top");
		var n;
		a(window).on("resize" + e.ns, function () {
			n && clearTimeout(n), n = setTimeout(function () {
				e.updateSliderSize()
			}, 50)
		}), e.ev.trigger("rsAfterPropsSetup"), e.updateSliderSize(), e.st.keyboardNavEnabled && e._b2(), e.st.arrowsNavHideOnTouch && (e.hasTouch || e.pointerMultitouch) && (e.st.arrowsNav = !1), e.st.arrowsNav && (f = e._o1, a('<div class="rsArrow rsArrowLeft"><div class="rsArrowIcn"></div></div><div class="rsArrow rsArrowRight"><div class="rsArrowIcn"></div></div>').appendTo(f), e._c2 = f.children(".rsArrowLeft").click(function (a) {
			a.preventDefault(), e.prev()
		}), e._d2 = f.children(".rsArrowRight").click(function (a) {
			a.preventDefault(), e.next()
		}), e.st.arrowsNavAutoHide && !e.hasTouch && (e._c2.addClass("rsHidden"), e._d2.addClass("rsHidden"), f.one("mousemove.arrowshover", function () {
			e._c2.removeClass("rsHidden"), e._d2.removeClass("rsHidden")
		}), f.hover(function () {
			e._e2 || (e._c2.removeClass("rsHidden"), e._d2.removeClass("rsHidden"))
		}, function () {
			e._e2 || (e._c2.addClass("rsHidden"), e._d2.addClass("rsHidden"))
		})), e.ev.on("rsOnUpdateNav", function () {
			e._f2()
		}), e._f2()), e._f1 ? e._p1.on(e._j1, function (a) {
			e._g2(a)
		}) : e.dragSuccess = !1;
		var o = ["rsPlayBtnIcon", "rsPlayBtn", "rsCloseVideoBtn", "rsCloseVideoIcn"];
		e._p1.click(function (b) {
			if (!e.dragSuccess) {
				var c = a(b.target).attr("class");
				if (-1 !== a.inArray(c, o) && e.toggleVideo()) return !1;
				if (e.st.navigateByClick && !e._h2) {
					if (a(b.target).closest(".rsNoDrag", e._r1).length) return !0;
					e._i2(b)
				}
				e.ev.trigger("rsSlideClick", b)
			}
		}).on("click.rs", "a", function () {
			return e.dragSuccess ? !1 : (e._h2 = !0, void setTimeout(function () {
				e._h2 = !1
			}, 3))
		}), e.ev.trigger("rsAfterInit")
	}
	a.rsModules || (a.rsModules = {
		uid: 0
	}), b.prototype = {
		constructor: b,
		_i2: function (a) {
			a = a[this._h ? "pageX" : "pageY"] - this._j2, a >= this._q ? this.next() : 0 > a && this.prev()
		},
		_t: function () {
			var a;
			a = this.st.numImagesToPreload, (this._z = this.st.loop) && (2 === this.numSlides ? (this._z = !1, this.st.loopRewind = !0) : 2 > this.numSlides && (this.st.loopRewind = this._z = !1)), this._z && a > 0 && (4 >= this.numSlides ? a = 1 : this.st.numImagesToPreload > (this.numSlides - 1) / 2 && (a = Math.floor((this.numSlides - 1) / 2))), this._y = a
		},
		_s: function (b, c) {
			function d(a, b) {
				if (h.images.push(b ? a.attr(b) : a.text()), i) {
					i = !1, h.caption = "src" === b ? a.attr("alt") : a.contents(), h.image = h.images[0], h.videoURL = a.attr("data-rsVideo");
					var c = a.attr("data-rsw"),
						d = a.attr("data-rsh");
					"undefined" != typeof c && !1 !== c && "undefined" != typeof d && !1 !== d ? (h.iW = parseInt(c, 10), h.iH = parseInt(d, 10)) : g.st.imgWidth && g.st.imgHeight && (h.iW = g.st.imgWidth, h.iH = g.st.imgHeight)
				}
			}
			var e, f, g = this,
				h = {},
				i = !0;
			return b = a(b), g._k2 = b, g.ev.trigger("rsBeforeParseNode", [b, h]), h.stopParsing ? void 0 : (b = g._k2, h.id = g._r, h.contentAdded = !1, g._r++, h.images = [], h.isBig = !1, h.hasCover || (b.hasClass("rsImg") ? (f = b, e = !0) : (f = b.find(".rsImg"), f.length && (e = !0)), e ? (h.bigImage = f.eq(0).attr("data-rsBigImg"), f.each(function () {
				var b = a(this);
				b.is("a") ? d(b, "href") : b.is("img") ? d(b, "src") : d(b)
			})) : b.is("img") && (b.addClass("rsImg rsMainSlideImage"), d(b, "src"))), f = b.find(".rsCaption"), f.length && (h.caption = f.remove()), h.content = b, g.ev.trigger("rsAfterParseNode", [b, h]), c && g.slides.push(h), 0 === h.images.length && (h.isLoaded = !0, h.isRendered = !1, h.isLoading = !1, h.images = null), h)
		},
		_b2: function () {
			var a, b, c = this,
				d = function (a) {
					37 === a ? c.prev() : 39 === a && c.next()
				};
			c._b.on("keydown" + c.ns, function (e) {
				c._l2 || (b = e.keyCode, 37 !== b && 39 !== b || a || (d(b), a = setInterval(function () {
					d(b)
				}, 700)))
			}).on("keyup" + c.ns, function () {
				a && (clearInterval(a), a = null)
			})
		},
		goTo: function (a, b) {
			a !== this.currSlideId && this._m2(a, this.st.transitionSpeed, !0, !b)
		},
		destroy: function (b) {
			this.ev.trigger("rsBeforeDestroy"), this._b.off("keydown" + this.ns + " keyup" + this.ns + " " + this._k1 + " " + this._l1), this._p1.off(this._j1 + " click"), this.slider.data("royalSlider", null), a.removeData(this.slider, "royalSlider"), a(window).off("resize" + this.ns), this.loadingTimeout && clearTimeout(this.loadingTimeout), b && this.slider.remove(), this.ev = this.slider = this.slides = null
		},
		_n2: function (b, c) {
			function d(c, d, g) {
				c.isAdded ? (e(d, c), f(d, c)) : (g || (g = j.slidesJQ[d]), c.holder ? g = c.holder : (g = j.slidesJQ[d] = a(g), c.holder = g), c.appendOnLoaded = !1, f(d, c, g), e(d, c), j._p2(c, g, b), c.isAdded = !0)
			}
			function e(a, c) {
				c.contentAdded || (j.setItemHtml(c, b), b || (c.contentAdded = !0))
			}
			function f(a, b, c) {
				j._l && (c || (c = j.slidesJQ[a]), c.css(j._i, (a + j._d1 + m) * j._w))
			}
			function g(a) {
				if (k) {
					if (a > l - 1) return g(a - l);
					if (0 > a) return g(l + a)
				}
				return a
			}
			var h, i, j = this,
				k = j._z,
				l = j.numSlides;
			if (!isNaN(c)) return g(c);
			var m, n, o = j.currSlideId,
				p = b ? Math.abs(j._o2 - j.currSlideId) >= j.numSlides - 1 ? 0 : 1 : j._y,
				q = Math.min(2, p),
				r = !1,
				s = !1;
			for (i = o; o + 1 + q > i; i++) if (n = g(i), (h = j.slides[n]) && (!h.isAdded || !h.positionSet)) {
				r = !0;
				break
			}
			for (i = o - 1; i > o - 1 - q; i--) if (n = g(i), (h = j.slides[n]) && (!h.isAdded || !h.positionSet)) {
				s = !0;
				break
			}
			if (r) for (i = o; o + p + 1 > i; i++) n = g(i), m = Math.floor((j._u - (o - i)) / j.numSlides) * j.numSlides, (h = j.slides[n]) && d(h, n);
			if (s) for (i = o - 1; i > o - 1 - p; i--) n = g(i), m = Math.floor((j._u - (o - i)) / l) * l, (h = j.slides[n]) && d(h, n);
			if (!b) for (q = g(o - p), o = g(o + p), p = q > o ? 0 : q, i = 0; l > i; i++) q > o && i > q - 1 || !(p > i || i > o) || (h = j.slides[i]) && h.holder && (h.holder.detach(), h.isAdded = !1)
		},
		setItemHtml: function (b, c) {
			var d = this,
				e = function () {
					if (b.images) {
						if (!b.isLoading) {
							var c, e;
							if (b.content.hasClass("rsImg") ? (c = b.content, e = !0) : c = b.content.find(".rsImg:not(img)"), c && !c.is("img") && c.each(function () {
								var c = a(this),
									d = '<img class="rsImg" src="' + (c.is("a") ? c.attr("href") : c.text()) + '" />';
								e ? b.content = a(d) : c.replaceWith(d)
							}), c = e ? b.content : b.content.find("img.rsImg"), j(), c.eq(0).addClass("rsMainSlideImage"), b.iW && b.iH && (b.isLoaded || d._q2(b), h()), b.isLoading = !0, b.isBig) a("<img />").on("load.rs error.rs", function () {
								a(this).off("load.rs error.rs"), f([this], !0)
							}).attr("src", b.image);
							else {
								b.loaded = [], b.numStartedLoad = 0, c = function () {
									a(this).off("load.rs error.rs"), b.loaded.push(this), b.loaded.length === b.numStartedLoad && f(b.loaded, !1)
								};
								for (var g = 0; g < b.images.length; g++) {
									var i = a("<img />");
									b.numStartedLoad++, i.on("load.rs error.rs", c).attr("src", b.images[g])
								}
							}
						}
					} else b.isRendered = !0, b.isLoaded = !0, b.isLoading = !1, h(!0)
				},
				f = function (a, c) {
					if (a.length) {
						var d = a[0];
						if (c !== b.isBig)(d = b.holder.children()) && 1 < d.length && k();
						else if (b.iW && b.iH) g();
						else if (b.iW = d.width, b.iH = d.height, b.iW && b.iH) g();
						else {
							var e = new Image;
							e.onload = function () {
								e.width ? (b.iW = e.width, b.iH = e.height, g()) : setTimeout(function () {
									e.width && (b.iW = e.width, b.iH = e.height), g()
								}, 1e3)
							}, e.src = d.src
						}
					} else g()
				},
				g = function () {
					b.isLoaded = !0, b.isLoading = !1, h(), k(), i()
				},
				h = function () {
					if (!b.isAppended && d.ev) {
						var a = d.st.visibleNearby,
							e = b.id - d._o;
						c || b.appendOnLoaded || !d.st.fadeinLoadedSlide || 0 !== e && (!(a || d._r2 || d._l2) || -1 !== e && 1 !== e) || (a = {
							visibility: "visible",
							opacity: 0
						}, a[d._g + "transition"] = "opacity 400ms ease-in-out", b.content.css(a), setTimeout(function () {
							b.content.css("opacity", 1)
						}, 16)), b.holder.find(".rsPreloader").length ? b.holder.append(b.content) : b.holder.html(b.content), b.isAppended = !0, b.isLoaded && (d._q2(b), i()), b.sizeReady || (b.sizeReady = !0, setTimeout(function () {
							d.ev.trigger("rsMaybeSizeReady", b)
						}, 100))
					}
				},
				i = function () {
					!b.loadedTriggered && d.ev && (b.isLoaded = b.loadedTriggered = !0, b.holder.trigger("rsAfterContentSet"), d.ev.trigger("rsAfterContentSet", b))
				},
				j = function () {
					d.st.usePreloader && b.holder.html(d._q1.clone())
				},
				k = function (a) {
					d.st.usePreloader && (a = b.holder.find(".rsPreloader"), a.length && a.remove())
				};
			b.isLoaded ? h() : c ? !d._l && b.images && b.iW && b.iH ? e() : (b.holder.isWaiting = !0, j(), b.holder.slideId = -99) : e()
		},
		_p2: function (a) {
			this._p1.append(a.holder), a.appendOnLoaded = !1
		},
		_g2: function (b, c) {
			var d, e = this,
				f = "touchstart" === b.type;
			if (e._s2 = f, e.ev.trigger("rsDragStart"), a(b.target).closest(".rsNoDrag", e._r1).length) return e.dragSuccess = !1, !0;
			if (!c && e._r2 && (e._t2 = !0, e._u2()), e.dragSuccess = !1, e._l2) f && (e._v2 = !0);
			else {
				if (f && (e._v2 = !1), e._w2(), f) {
					var g = b.originalEvent.touches;
					if (!(g && 0 < g.length)) return;
					d = g[0], 1 < g.length && (e._v2 = !0)
				} else b.preventDefault(), d = b, e.pointerEnabled && (d = d.originalEvent);
				e._l2 = !0, e._b.on(e._k1, function (a) {
					e._x2(a, c)
				}).on(e._l1, function (a) {
					e._y2(a, c)
				}), e._z2 = "", e._a3 = !1, e._b3 = d.pageX, e._c3 = d.pageY, e._d3 = e._v = (c ? e._e3 : e._h) ? d.pageX : d.pageY, e._f3 = 0, e._g3 = 0, e._h3 = c ? e._i3 : e._p, e._j3 = (new Date).getTime(), f && e._e1.on(e._m1, function (a) {
					e._y2(a, c)
				})
			}
		},
		_k3: function (a, b) {
			if (this._l3) {
				var c = this._m3,
					d = a.pageX - this._b3,
					e = a.pageY - this._c3,
					f = this._h3 + d,
					g = this._h3 + e,
					h = b ? this._e3 : this._h,
					f = h ? f : g,
					g = this._z2;
				this._a3 = !0, this._b3 = a.pageX, this._c3 = a.pageY, "x" === g && 0 !== d ? this._f3 = d > 0 ? 1 : -1 : "y" === g && 0 !== e && (this._g3 = e > 0 ? 1 : -1), g = h ? this._b3 : this._c3, d = h ? d : e, b ? f > this._n3 ? f = this._h3 + d * this._n1 : f < this._o3 && (f = this._h3 + d * this._n1) : this._z || (0 >= this.currSlideId && 0 < g - this._d3 && (f = this._h3 + d * this._n1), this.currSlideId >= this.numSlides - 1 && 0 > g - this._d3 && (f = this._h3 + d * this._n1)), this._h3 = f, 200 < c - this._j3 && (this._j3 = c, this._v = g), b ? this._q3(this._h3) : this._l && this._p3(this._h3)
			}
		},
		_x2: function (a, b) {
			var c, d = this,
				e = "touchmove" === a.type;
			if (!d._s2 || e) {
				if (e) {
					if (d._r3) return;
					var f = a.originalEvent.touches;
					if (!f) return;
					if (1 < f.length) return;
					c = f[0]
				} else c = a, d.pointerEnabled && (c = c.originalEvent);
				if (d._a3 || (d._e && (b ? d._s3 : d._p1).css(d._g + d._u1, "0s"), function g() {
					d._l2 && (d._t3 = requestAnimationFrame(g), d._u3 && d._k3(d._u3, b))
				}()), d._l3) a.preventDefault(), d._m3 = (new Date).getTime(), d._u3 = c;
				else if (f = b ? d._e3 : d._h, c = Math.abs(c.pageX - d._b3) - Math.abs(c.pageY - d._c3) - (f ? -7 : 7), c > 7) {
					if (f) a.preventDefault(), d._z2 = "x";
					else if (e) return void d._v3(a);
					d._l3 = !0
				} else if (-7 > c) {
					if (f) {
						if (e) return void d._v3(a)
					} else a.preventDefault(), d._z2 = "y";
					d._l3 = !0
				}
			}
		},
		_v3: function (a) {
			this._r3 = !0, this._a3 = this._l2 = !1, this._y2(a)
		},
		_y2: function (b, c) {
			function d(a) {
				return 100 > a ? 100 : a > 500 ? 500 : a
			}
			function e(a, b) {
				(j._l || c) && (h = (-j._u - j._d1) * j._w, i = Math.abs(j._p - h), j._c = i / b, a && (j._c += 250), j._c = d(j._c), j._x3(h, !1))
			}
			var f, g, h, i, j = this;
			if (f = -1 < b.type.indexOf("touch"), !j._s2 || f) if (j._s2 = !1, j.ev.trigger("rsDragRelease"), j._u3 = null, j._l2 = !1, j._r3 = !1, j._l3 = !1, j._m3 = 0, cancelAnimationFrame(j._t3), j._a3 && (c ? j._q3(j._h3) : j._l && j._p3(j._h3)), j._b.off(j._k1).off(j._l1), f && j._e1.off(j._m1), j._i1(), !j._a3 && !j._v2 && c && j._w3) {
				var k = a(b.target).closest(".rsNavItem");
				k.length && j.goTo(k.index())
			} else {
				if (g = c ? j._e3 : j._h, !j._a3 || "y" === j._z2 && g || "x" === j._z2 && !g) {
					if (c || !j._t2) return j._t2 = !1, void(j.dragSuccess = !1);
					if (j._t2 = !1, j.st.navigateByClick) return j._i2(j.pointerEnabled ? b.originalEvent : b), void(j.dragSuccess = !0);
					j.dragSuccess = !0
				} else j.dragSuccess = !0;
				j._t2 = !1, j._z2 = "";
				var l = j.st.minSlideOffset;
				f = f ? b.originalEvent.changedTouches[0] : j.pointerEnabled ? b.originalEvent : b;
				var m = g ? f.pageX : f.pageY,
					n = j._d3;
				f = j._v;
				var o = j.currSlideId,
					p = j.numSlides,
					q = g ? j._f3 : j._g3,
					r = j._z;
				if (Math.abs(m - n), f = m - f, g = (new Date).getTime() - j._j3, g = Math.abs(f) / g, 0 === q || 1 >= p) e(!0, g);
				else {
					if (!r && !c) if (0 >= o) {
						if (q > 0) return void e(!0, g)
					} else if (o >= p - 1 && 0 > q) return void e(!0, g);
					if (c) {
						if (h = j._i3, h > j._n3) h = j._n3;
						else if (h < j._o3) h = j._o3;
						else {
							if (m = g * g / .006, k = -j._i3, n = j._y3 - j._z3 + j._i3, f > 0 && m > k ? (k += j._z3 / (15 / (m / g * .003)), g = g * k / m, m = k) : 0 > f && m > n && (n += j._z3 / (15 / (m / g * .003)), g = g * n / m, m = n), k = Math.max(Math.round(g / .003), 50), h += m * (0 > f ? -1 : 1), h > j._n3) return void j._a4(h, k, !0, j._n3, 200);
							if (h < j._o3) return void j._a4(h, k, !0, j._o3, 200)
						}
						j._a4(h, k, !0)
					} else k = function (a) {
						var b = Math.floor(a / j._w);
						return a - b * j._w > l && b++, b
					}, m > n + l ? 0 > q ? e(!1, g) : (k = k(m - n), j._m2(j.currSlideId - k, d(Math.abs(j._p - (-j._u - j._d1 + k) * j._w) / g), !1, !0, !0)) : n - l > m ? q > 0 ? e(!1, g) : (k = k(n - m), j._m2(j.currSlideId + k, d(Math.abs(j._p - (-j._u - j._d1 - k) * j._w) / g), !1, !0, !0)) : e(!1, g)
				}
			}
		},
		_p3: function (a) {
			a = this._p = a, this._e ? this._p1.css(this._x1, this._y1 + (this._h ? a + this._z1 + 0 : 0 + this._z1 + a) + this._a2) : this._p1.css(this._h ? this._x1 : this._w1, a)
		},
		updateSliderSize: function (a) {
			var b, c;
			if (this.st.autoScaleSlider) {
				var d = this.st.autoScaleSliderWidth,
					e = this.st.autoScaleSliderHeight;
				this.st.autoScaleHeight ? (b = this.slider.width(), b != this.width && (this.slider.css("height", e / d * b), b = this.slider.width()), c = this.slider.height()) : (c = this.slider.height(), c != this.height && (this.slider.css("width", d / e * c), c = this.slider.height()), b = this.slider.width())
			} else b = this.slider.width(), c = this.slider.height();
			if (a || b != this.width || c != this.height) {
				for (this.width = b, this.height = c, this._b4 = b, this._c4 = c, this.ev.trigger("rsBeforeSizeSet"), this.ev.trigger("rsAfterSizePropSet"), this._e1.css({
					width: this._b4,
					height: this._c4
				}), this._w = (this._h ? this._b4 : this._c4) + this.st.slidesSpacing, this._d4 = this.st.imageScalePadding, b = 0; b < this.slides.length; b++) a = this.slides[b], a.positionSet = !1, a && a.images && a.isLoaded && (a.isRendered = !1, this._q2(a));
				if (this._e4) for (b = 0; b < this._e4.length; b++) a = this._e4[b], a.holder.css(this._i, (a.id + this._d1) * this._w);
				this._n2(), this._l && (this._e && this._p1.css(this._g + "transition-duration", "0s"), this._p3((-this._u - this._d1) * this._w)), this.ev.trigger("rsOnUpdateNav")
			}
			this._j2 = this._e1.offset(), this._j2 = this._j2[this._i]
		},
		appendSlide: function (b, c) {
			var d = this._s(b);
			(isNaN(c) || c > this.numSlides) && (c = this.numSlides), this.slides.splice(c, 0, d), this.slidesJQ.splice(c, 0, a('<div style="' + (this._l ? "position:absolute;" : this._n) + '" class="rsSlide"></div>')), c < this.currSlideId && this.currSlideId++, this.ev.trigger("rsOnAppendSlide", [d, c]), this._f4(c), c === this.currSlideId && this.ev.trigger("rsAfterSlideChange")
		},
		removeSlide: function (a) {
			var b = this.slides[a];
			b && (b.holder && b.holder.remove(), a < this.currSlideId && this.currSlideId--, this.slides.splice(a, 1), this.slidesJQ.splice(a, 1), this.ev.trigger("rsOnRemoveSlide", [a]), this._f4(a), a === this.currSlideId && this.ev.trigger("rsAfterSlideChange"))
		},
		_f4: function (a) {
			var b = this;
			for (a = b.numSlides, a = 0 >= b._u ? 0 : Math.floor(b._u / a), b.numSlides = b.slides.length, 0 === b.numSlides ? (b.currSlideId = b._d1 = b._u = 0, b.currSlide = b._g4 = null) : b._u = a * b.numSlides + b.currSlideId, a = 0; a < b.numSlides; a++) b.slides[a].id = a;
			b.currSlide = b.slides[b.currSlideId], b._r1 = b.slidesJQ[b.currSlideId], b.currSlideId >= b.numSlides ? b.goTo(b.numSlides - 1) : 0 > b.currSlideId && b.goTo(0), b._t(), b._l && b._z && b._p1.css(b._g + b._u1, "0ms"), b._h4 && clearTimeout(b._h4), b._h4 = setTimeout(function () {
				b._l && b._p3((-b._u - b._d1) * b._w), b._n2(), b._l || b._r1.css({
					display: "block",
					opacity: 1
				})
			}, 14), b.ev.trigger("rsOnUpdateNav")
		},
		_i1: function () {
			this._f1 && this._l && (this._g1 ? this._e1.css("cursor", this._g1) : (this._e1.removeClass("grabbing-cursor"), this._e1.addClass("grab-cursor")))
		},
		_w2: function () {
			this._f1 && this._l && (this._h1 ? this._e1.css("cursor", this._h1) : (this._e1.removeClass("grab-cursor"), this._e1.addClass("grabbing-cursor")))
		},
		next: function (a) {
			this._m2("next", this.st.transitionSpeed, !0, !a)
		},
		prev: function (a) {
			this._m2("prev", this.st.transitionSpeed, !0, !a)
		},
		_m2: function (a, b, c, d, e) {
			var f, g, h, i = this;
			if (i.ev.trigger("rsBeforeMove", [a, d]), h = "next" === a ? i.currSlideId + 1 : "prev" === a ? i.currSlideId - 1 : a = parseInt(a, 10), !i._z) {
				if (0 > h) return void i._i4("left", !d);
				if (h >= i.numSlides) return void i._i4("right", !d)
			}
			i._r2 && (i._u2(!0), c = !1), g = h - i.currSlideId, h = i._o2 = i.currSlideId;
			var j = i.currSlideId + g;
			d = i._u;
			var k;
			i._z ? (j = i._n2(!1, j), d += g) : d = j, i._o = j, i._g4 = i.slidesJQ[i.currSlideId], i._u = d, i.currSlideId = i._o, i.currSlide = i.slides[i.currSlideId], i._r1 = i.slidesJQ[i.currSlideId];
			var j = i.st.slidesDiff,
				l = Boolean(g > 0);
			g = Math.abs(g);
			var m = Math.floor(h / i._y),
				n = Math.floor((h + (l ? j : -j)) / i._y),
				m = (l ? Math.max(m, n) : Math.min(m, n)) * i._y + (l ? i._y - 1 : 0);
			if (m > i.numSlides - 1 ? m = i.numSlides - 1 : 0 > m && (m = 0), h = l ? m - h : h - m, h > i._y && (h = i._y), g > h + j) for (i._d1 += (g - (h + j)) * (l ? -1 : 1), b *= 1.4, h = 0; h < i.numSlides; h++) i.slides[h].positionSet = !1;
			i._c = b, i._n2(!0), e || (k = !0), f = (-d - i._d1) * i._w, k ? setTimeout(function () {
				i._j4 = !1, i._x3(f, a, !1, c), i.ev.trigger("rsOnUpdateNav")
			}, 0) : (i._x3(f, a, !1, c), i.ev.trigger("rsOnUpdateNav"))
		},
		_f2: function () {
			this.st.arrowsNav && (1 >= this.numSlides ? (this._c2.css("display", "none"), this._d2.css("display", "none")) : (this._c2.css("display", "block"), this._d2.css("display", "block"), this._z || this.st.loopRewind || (0 === this.currSlideId ? this._c2.addClass("rsArrowDisabled") : this._c2.removeClass("rsArrowDisabled"), this.currSlideId === this.numSlides - 1 ? this._d2.addClass("rsArrowDisabled") : this._d2.removeClass("rsArrowDisabled"))))
		},
		_x3: function (b, c, d, e, f) {
			function g() {
				var a;
				h && (a = h.data("rsTimeout")) && (h !== i && h.css({
					opacity: 0,
					display: "none",
					zIndex: 0
				}), clearTimeout(a), h.data("rsTimeout", "")), (a = i.data("rsTimeout")) && (clearTimeout(a), i.data("rsTimeout", ""))
			}
			var h, i, j = this,
				k = {};
			isNaN(j._c) && (j._c = 400), j._p = j._h3 = b, j.ev.trigger("rsBeforeAnimStart"), j._e ? j._l ? (j._c = parseInt(j._c, 10), d = j._g + j._v1, k[j._g + j._u1] = j._c + "ms", k[d] = e ? a.rsCSS3Easing[j.st.easeInOut] : a.rsCSS3Easing[j.st.easeOut], j._p1.css(k), e || !j.hasTouch ? setTimeout(function () {
				j._p3(b)
			}, 5) : j._p3(b)) : (j._c = j.st.transitionSpeed, h = j._g4, i = j._r1, i.data("rsTimeout") && i.css("opacity", 0), g(), h && h.data("rsTimeout", setTimeout(function () {
				k[j._g + j._u1] = "0ms", k.zIndex = 0, k.display = "none", h.data("rsTimeout", ""), h.css(k), setTimeout(function () {
					h.css("opacity", 0)
				}, 16)
			}, j._c + 60)), k.display = "block", k.zIndex = j._m, k.opacity = 0, k[j._g + j._u1] = "0ms", k[j._g + j._v1] = a.rsCSS3Easing[j.st.easeInOut], i.css(k), i.data("rsTimeout", setTimeout(function () {
				i.css(j._g + j._u1, j._c + "ms"), i.data("rsTimeout", setTimeout(function () {
					i.css("opacity", 1), i.data("rsTimeout", "")
				}, 20))
			}, 20))) : j._l ? (k[j._h ? j._x1 : j._w1] = b + "px", j._p1.animate(k, j._c, e ? j.st.easeInOut : j.st.easeOut)) : (h = j._g4, i = j._r1, i.stop(!0, !0).css({
				opacity: 0,
				display: "block",
				zIndex: j._m
			}), j._c = j.st.transitionSpeed, i.animate({
				opacity: 1
			}, j._c, j.st.easeInOut), g(), h && h.data("rsTimeout", setTimeout(function () {
				h.stop(!0, !0).css({
					opacity: 0,
					display: "none",
					zIndex: 0
				})
			}, j._c + 60))), j._r2 = !0, j.loadingTimeout && clearTimeout(j.loadingTimeout), j.loadingTimeout = f ? setTimeout(function () {
				j.loadingTimeout = null, f.call()
			}, j._c + 60) : setTimeout(function () {
				j.loadingTimeout = null, j._k4(c)
			}, j._c + 60)
		},
		_u2: function (a) {
			if (this._r2 = !1, clearTimeout(this.loadingTimeout), this._l) if (this._e) {
				if (!a) {
					a = this._p;
					var b = this._h3 = this._l4();
					this._p1.css(this._g + this._u1, "0ms"), a !== b && this._p3(b)
				}
			} else this._p1.stop(!0), this._p = parseInt(this._p1.css(this._x1), 10);
			else 20 < this._m ? this._m = 10 : this._m++
		},
		_l4: function () {
			var a = window.getComputedStyle(this._p1.get(0), null).getPropertyValue(this._g + "transform").replace(/^matrix\(/i, "").split(/, |\)$/g),
				b = 0 === a[0].indexOf("matrix3d");
			return parseInt(a[this._h ? b ? 12 : 4 : b ? 13 : 5], 10)
		},
		_m4: function (a, b) {
			return this._e ? this._y1 + (b ? a + this._z1 + 0 : 0 + this._z1 + a) + this._a2 : a
		},
		_k4: function () {
			this._l || (this._r1.css("z-index", 0), this._m = 10), this._r2 = !1, this.staticSlideId = this.currSlideId, this._n2(), this._n4 = !1, this.ev.trigger("rsAfterSlideChange")
		},
		_i4: function (a, b) {
			var c = this,
				d = (-c._u - c._d1) * c._w;
			if (0 !== c.numSlides && !c._r2) if (c.st.loopRewind) c.goTo("left" === a ? c.numSlides - 1 : 0, b);
			else if (c._l) {
				c._c = 200;
				var e = function () {
					c._r2 = !1
				};
				c._x3(d + ("left" === a ? 30 : -30), "", !1, !0, function () {
					c._r2 = !1, c._x3(d, "", !1, !0, e)
				})
			}
		},
		_q2: function (a) {
			if (!a.isRendered) {
				var b, c, d = a.content,
					e = "rsMainSlideImage",
					f = this.st.imageAlignCenter,
					g = this.st.imageScaleMode;
				if (a.videoURL && (e = "rsVideoContainer", "fill" !== g ? b = !0 : (c = d, c.hasClass(e) || (c = c.find("." + e)), c.css({
					width: "100%",
					height: "100%"
				}), e = "rsMainSlideImage")), d.hasClass(e) || (d = d.find("." + e)), d) {
					var h = a.iW,
						i = a.iH;
					if (a.isRendered = !0, "none" !== g || f) {
						e = "fill" !== g ? this._d4 : 0, c = this._b4 - 2 * e;
						var j, k, l = this._c4 - 2 * e,
							m = {};
						"fit-if-smaller" === g && (h > c || i > l) && (g = "fit"), ("fill" === g || "fit" === g) && (j = c / h, k = l / i, j = "fill" == g ? j > k ? j : k : "fit" == g ? k > j ? j : k : 1, h = Math.ceil(h * j, 10), i = Math.ceil(i * j, 10)), "none" !== g && (m.width = h, m.height = i, b && d.find(".rsImg").css({
							width: "100%",
							height: "100%"
						})), f && (m.marginLeft = Math.floor((c - h) / 2) + e, m.marginTop = Math.floor((l - i) / 2) + e), d.css(m)
					}
				}
			}
		}
	}, a.rsProto = b.prototype, a.fn.royalSlider = function (c) {
		var d = arguments;
		return this.each(function () {
			var e = a(this);
			if ("object" != typeof c && c) {
				if ((e = e.data("royalSlider")) && e[c]) return e[c].apply(e, Array.prototype.slice.call(d, 1))
			} else e.data("royalSlider") || e.data("royalSlider", new b(e, c))
		})
	}, a.fn.royalSlider.defaults = {
		slidesSpacing: 8,
		startSlideId: 0,
		loop: !1,
		loopRewind: !1,
		numImagesToPreload: 4,
		fadeinLoadedSlide: !0,
		slidesOrientation: "horizontal",
		transitionType: "move",
		transitionSpeed: 600,
		controlNavigation: "bullets",
		controlsInside: !0,
		arrowsNav: !0,
		arrowsNavAutoHide: !0,
		navigateByClick: !0,
		randomizeSlides: !1,
		sliderDrag: !0,
		sliderTouch: !0,
		keyboardNavEnabled: !1,
		fadeInAfterLoaded: !0,
		allowCSS3: !0,
		allowCSS3OnWebkit: !0,
		addActiveClass: !1,
		autoHeight: !1,
		easeOut: "easeOutSine",
		easeInOut: "easeInOutSine",
		minSlideOffset: 10,
		imageScaleMode: "fit-if-smaller",
		imageAlignCenter: !0,
		imageScalePadding: 4,
		usePreloader: !0,
		autoScaleSlider: !1,
		autoScaleSliderWidth: 800,
		autoScaleSliderHeight: 400,
		autoScaleHeight: !0,
		arrowsNavHideOnTouch: !1,
		globalCaption: !1,
		slidesDiff: 2
	}, a.rsCSS3Easing = {
		easeOutSine: "cubic-bezier(0.390, 0.575, 0.565, 1.000)",
		easeInOutSine: "cubic-bezier(0.445, 0.050, 0.550, 0.950)"
	}, a.extend(jQuery.easing, {
		easeInOutSine: function (a, b, c, d, e) {
			return -d / 2 * (Math.cos(Math.PI * b / e) - 1) + c
		},
		easeOutSine: function (a, b, c, d, e) {
			return d * Math.sin(b / e * (Math.PI / 2)) + c
		},
		easeOutCubic: function (a, b, c, d, e) {
			return d * ((b = b / e - 1) * b * b + 1) + c
		}
	})
}(jQuery, window), function (a) {
	a.extend(a.rsProto, {
		_i5: function () {
			var b = this;
			"bullets" === b.st.controlNavigation && (b.ev.one("rsAfterPropsSetup", function () {
				b._j5 = !0, b.slider.addClass("rsWithBullets");
				for (var c = '<div class="rsNav rsBullets">', d = 0; d < b.numSlides; d++) c += '<div class="rsNavItem rsBullet"><span></span></div>';
				b._k5 = c = a(c + "</div>"), b._l5 = c.appendTo(b.slider).children(), b._k5.on("click.rs", ".rsNavItem", function () {
					b._m5 || b.goTo(a(this).index())
				})
			}), b.ev.on("rsOnAppendSlide", function (a, c, d) {
				d >= b.numSlides ? b._k5.append('<div class="rsNavItem rsBullet"><span></span></div>') : b._l5.eq(d).before('<div class="rsNavItem rsBullet"><span></span></div>'), b._l5 = b._k5.children()
			}), b.ev.on("rsOnRemoveSlide", function (a, c) {
				var d = b._l5.eq(c);
				d && d.length && (d.remove(), b._l5 = b._k5.children())
			}), b.ev.on("rsOnUpdateNav", function () {
				var a = b.currSlideId;
				b._n5 && b._n5.removeClass("rsNavSelected"), a = b._l5.eq(a), a.addClass("rsNavSelected"), b._n5 = a
			}))
		}
	}), a.rsModules.bullets = a.rsProto._i5
}(jQuery), function (a) {
	a.extend(a.rsProto, {
		_h6: function () {
			var b = this;
			"thumbnails" === b.st.controlNavigation && (b._i6 = {
				drag: !0,
				touch: !0,
				orientation: "horizontal",
				navigation: !0,
				arrows: !0,
				arrowLeft: null,
				arrowRight: null,
				spacing: 4,
				arrowsAutoHide: !1,
				appendSpan: !1,
				transitionSpeed: 600,
				autoCenter: !0,
				fitInViewport: !0,
				firstMargin: !0,
				paddingTop: 0,
				paddingBottom: 0
			}, b.st.thumbs = a.extend({}, b._i6, b.st.thumbs), b._j6 = !0, !1 === b.st.thumbs.firstMargin ? b.st.thumbs.firstMargin = 0 : !0 === b.st.thumbs.firstMargin && (b.st.thumbs.firstMargin = b.st.thumbs.spacing), b.ev.on("rsBeforeParseNode", function (b, c, d) {
				c = a(c), d.thumbnail = c.find(".rsTmb").remove(), d.thumbnail.length ? d.thumbnail = a(document.createElement("div")).append(d.thumbnail).html() : (d.thumbnail = c.attr("data-rsTmb"), d.thumbnail || (d.thumbnail = c.find(".rsImg").attr("data-rsTmb")), d.thumbnail = d.thumbnail ? '<img src="' + d.thumbnail + '"/>' : "")
			}), b.ev.one("rsAfterPropsSetup", function () {
				b._k6()
			}), b._n5 = null, b.ev.on("rsOnUpdateNav", function () {
				var c = a(b._l5[b.currSlideId]);
				c !== b._n5 && (b._n5 && (b._n5.removeClass("rsNavSelected"), b._n5 = null), b._l6 && b._m6(b.currSlideId), b._n5 = c.addClass("rsNavSelected"))
			}), b.ev.on("rsOnAppendSlide", function (a, c, d) {
				a = "<div" + b._n6 + ' class="rsNavItem rsThumb">' + b._o6 + c.thumbnail + "</div>", d >= b.numSlides ? b._s3.append(a) : b._l5.eq(d).before(a), b._l5 = b._s3.children(), b.updateThumbsSize()
			}), b.ev.on("rsOnRemoveSlide", function (a, c) {
				var d = b._l5.eq(c);
				d && (d.remove(), b._l5 = b._s3.children(), b.updateThumbsSize())
			}))
		},
		_k6: function () {
			var b, c, d = this,
				e = "rsThumbs",
				f = d.st.thumbs,
				g = "",
				h = f.spacing;
			d._j5 = !0, d._e3 = "vertical" === f.orientation ? !1 : !0, d._n6 = b = h ? ' style="margin-' + (d._e3 ? "right" : "bottom") + ":" + h + 'px;"' : "", d._i3 = 0, d._p6 = !1, d._m5 = !1, d._l6 = !1, d._q6 = f.arrows && f.navigation, c = d._e3 ? "Hor" : "Ver", d.slider.addClass("rsWithThumbs rsWithThumbs" + c), g += '<div class="rsNav rsThumbs rsThumbs' + c + '"><div class="' + e + 'Container">', d._o6 = f.appendSpan ? '<span class="thumbIco"></span>' : "";
			for (var i = 0; i < d.numSlides; i++) c = d.slides[i], g += "<div" + b + ' class="rsNavItem rsThumb">' + c.thumbnail + d._o6 + "</div>";
			g = a(g + "</div></div>"), b = {}, f.paddingTop && (b[d._e3 ? "paddingTop" : "paddingLeft"] = f.paddingTop), f.paddingBottom && (b[d._e3 ? "paddingBottom" : "paddingRight"] = f.paddingBottom), g.css(b), d._s3 = a(g).find("." + e + "Container"), d._q6 && (e += "Arrow", f.arrowLeft ? d._r6 = f.arrowLeft : (d._r6 = a('<div class="' + e + " " + e + 'Left"><div class="' + e + 'Icn"></div></div>'), g.append(d._r6)), f.arrowRight ? d._s6 = f.arrowRight : (d._s6 = a('<div class="' + e + " " + e + 'Right"><div class="' + e + 'Icn"></div></div>'), g.append(d._s6)), d._r6.click(function () {
				var a = (Math.floor(d._i3 / d._t6) + d._u6) * d._t6 + d._v6;
				d._a4(a > d._n3 ? d._n3 : a)
			}), d._s6.click(function () {
				var a = (Math.floor(d._i3 / d._t6) - d._u6) * d._t6 + d._v6;
				d._a4(a < d._o3 ? d._o3 : a)
			}), f.arrowsAutoHide && !d.hasTouch && (d._r6.css("opacity", 0), d._s6.css("opacity", 0), g.one("mousemove.rsarrowshover", function () {
				d._l6 && (d._r6.css("opacity", 1), d._s6.css("opacity", 1))
			}), g.hover(function () {
				d._l6 && (d._r6.css("opacity", 1), d._s6.css("opacity", 1))
			}, function () {
				d._l6 && (d._r6.css("opacity", 0), d._s6.css("opacity", 0))
			}))), d._k5 = g, d._l5 = d._s3.children(), d.msEnabled && d.st.thumbs.navigation && d._s3.css("-ms-touch-action", d._e3 ? "pan-y" : "pan-x"), d.slider.append(g), d._w3 = !0, d._v6 = h, f.navigation && d._e && d._s3.css(d._g + "transition-property", d._g + "transform"), d._k5.on("click.rs", ".rsNavItem", function () {
				d._m5 || d.goTo(a(this).index())
			}), d.ev.off("rsBeforeSizeSet.thumbs").on("rsBeforeSizeSet.thumbs", function () {
				d._w6 = d._e3 ? d._c4 : d._b4, d.updateThumbsSize(!0)
			}), d.ev.off("rsAutoHeightChange.thumbs").on("rsAutoHeightChange.thumbs", function (a, b) {
				d.updateThumbsSize(!0, b)
			})
		},
		updateThumbsSize: function (a, b) {
			var c = this,
				d = c._l5.first(),
				e = {},
				f = c._l5.length;
			c._t6 = (c._e3 ? d.outerWidth() : d.outerHeight()) + c._v6, c._y3 = f * c._t6 - c._v6, e[c._e3 ? "width" : "height"] = c._y3 + c._v6, c._z3 = c._e3 ? c._k5.width() : void 0 !== b ? b : c._k5.height(), c._w3 && (c.isFullscreen || c.st.thumbs.fitInViewport) && (c._e3 ? c._c4 = c._w6 - c._k5.outerHeight() : c._b4 = c._w6 - c._k5.outerWidth()), c._z3 && (c._o3 = -(c._y3 - c._z3) - c.st.thumbs.firstMargin, c._n3 = c.st.thumbs.firstMargin, c._u6 = Math.floor(c._z3 / c._t6), c._y3 < c._z3 ? (c.st.thumbs.autoCenter && c._q3((c._z3 - c._y3) / 2), c.st.thumbs.arrows && c._r6 && (c._r6.addClass("rsThumbsArrowDisabled"), c._s6.addClass("rsThumbsArrowDisabled")), c._l6 = !1, c._m5 = !1, c._k5.off(c._j1)) : c.st.thumbs.navigation && !c._l6 && (c._l6 = !0, !c.hasTouch && c.st.thumbs.drag || c.hasTouch && c.st.thumbs.touch) && (c._m5 = !0, c._k5.on(c._j1, function (a) {
				c._g2(a, !0)
			})), c._s3.css(e), a && b && c._m6(c.currSlideId), c._e && (e[c._g + "transition-duration"] = "0ms"))
		},
		setThumbsOrientation: function (a, b) {
			this._w3 && (this.st.thumbs.orientation = a, this._k5.remove(), this.slider.removeClass("rsWithThumbsHor rsWithThumbsVer"), this._k6(), this._k5.off(this._j1), b || this.updateSliderSize(!0))
		},
		_q3: function (a) {
			this._i3 = a, this._e ? this._s3.css(this._x1, this._y1 + (this._e3 ? a + this._z1 + 0 : 0 + this._z1 + a) + this._a2) : this._s3.css(this._e3 ? this._x1 : this._w1, a)
		},
		_a4: function (b, c, d, e, f) {
			var g = this;
			if (g._l6) {
				c || (c = g.st.thumbs.transitionSpeed), g._i3 = b, g._x6 && clearTimeout(g._x6), g._p6 && (g._e || g._s3.stop(), d = !0);
				var h = {};
				g._p6 = !0, g._e ? (h[g._g + "transition-duration"] = c + "ms", h[g._g + "transition-timing-function"] = d ? a.rsCSS3Easing[g.st.easeOut] : a.rsCSS3Easing[g.st.easeInOut], g._s3.css(h), g._q3(b)) : (h[g._e3 ? g._x1 : g._w1] = b + "px", g._s3.animate(h, c, d ? "easeOutCubic" : g.st.easeInOut)), e && (g._i3 = e), g._y6(), g._x6 = setTimeout(function () {
					g._p6 = !1, f && (g._a4(e, f, !0), f = null)
				}, c)
			}
		},
		_y6: function () {
			this._q6 && (this._i3 === this._n3 ? this._r6.addClass("rsThumbsArrowDisabled") : this._r6.removeClass("rsThumbsArrowDisabled"), this._i3 === this._o3 ? this._s6.addClass("rsThumbsArrowDisabled") : this._s6.removeClass("rsThumbsArrowDisabled"))
		},
		_m6: function (a, b) {
			var c, d = 0,
				e = a * this._t6 + 2 * this._t6 - this._v6 + this._n3,
				f = Math.floor(this._i3 / this._t6);
			this._l6 && (this._j6 && (b = !0, this._j6 = !1), e + this._i3 > this._z3 ? (a === this.numSlides - 1 && (d = 1), f = -a + this._u6 - 2 + d, c = f * this._t6 + this._z3 % this._t6 + this._v6 - this._n3) : 0 !== a ? (a - 1) * this._t6 <= -this._i3 + this._n3 && a - 1 <= this.numSlides - this._u6 && (c = (-a + 1) * this._t6 + this._n3) : c = this._n3, c !== this._i3 && (d = void 0 === c ? this._i3 : c, d > this._n3 ? this._q3(this._n3) : d < this._o3 ? this._q3(this._o3) : void 0 !== c && (b ? this._q3(c) : this._a4(c))), this._y6())
		}
	}), a.rsModules.thumbnails = a.rsProto._h6
}(jQuery), function (a) {
	a.extend(a.rsProto, {
		_f6: function () {
			var b = this;
			"tabs" === b.st.controlNavigation && (b.ev.on("rsBeforeParseNode", function (b, c, d) {
				c = a(c), d.thumbnail = c.find(".rsTmb").remove(), d.thumbnail.length ? d.thumbnail = a(document.createElement("div")).append(d.thumbnail).html() : (d.thumbnail = c.attr("data-rsTmb"), d.thumbnail || (d.thumbnail = c.find(".rsImg").attr("data-rsTmb")), d.thumbnail = d.thumbnail ? '<img src="' + d.thumbnail + '"/>' : "")
			}), b.ev.one("rsAfterPropsSetup", function () {
				b._g6()
			}), b.ev.on("rsOnAppendSlide", function (a, c, d) {
				d >= b.numSlides ? b._k5.append('<div class="rsNavItem rsTab">' + c.thumbnail + "</div>") : b._l5.eq(d).before('<div class="rsNavItem rsTab">' + item.thumbnail + "</div>"), b._l5 = b._k5.children()
			}), b.ev.on("rsOnRemoveSlide", function (a, c) {
				var d = b._l5.eq(c);
				d && (d.remove(), b._l5 = b._k5.children())
			}), b.ev.on("rsOnUpdateNav", function () {
				var a = b.currSlideId;
				b._n5 && b._n5.removeClass("rsNavSelected"), a = b._l5.eq(a), a.addClass("rsNavSelected"), b._n5 = a
			}))
		},
		_g6: function () {
			var b, c = this;
			c._j5 = !0, b = '<div class="rsNav rsTabs">';
			for (var d = 0; d < c.numSlides; d++) b += '<div class="rsNavItem rsTab">' + c.slides[d].thumbnail + "</div>";
			b = a(b + "</div>"), c._k5 = b, c._l5 = b.children(".rsNavItem"), c.slider.append(b), c._k5.click(function (b) {
				b = a(b.target).closest(".rsNavItem"), b.length && c.goTo(b.index())
			})
		}
	}), a.rsModules.tabs = a.rsProto._f6
}(jQuery), function (a) {
	a.extend(a.rsProto, {
		_q5: function () {
			var b = this;
			b._r5 = {
				enabled: !1,
				keyboardNav: !0,
				buttonFS: !0,
				nativeFS: !1,
				doubleTap: !0
			}, b.st.fullscreen = a.extend({}, b._r5, b.st.fullscreen), b.st.fullscreen.enabled && b.ev.one("rsBeforeSizeSet", function () {
				b._s5()
			})
		},
		_s5: function () {
			var b = this;
			if (b._t5 = !b.st.keyboardNavEnabled && b.st.fullscreen.keyboardNav, b.st.fullscreen.nativeFS) {
				b._u5 = {
					supportsFullScreen: !1,
					isFullScreen: function () {
						return !1
					},
					requestFullScreen: function () {},
					cancelFullScreen: function () {},
					fullScreenEventName: "",
					prefix: ""
				};
				var c = ["webkit", "moz", "o", "ms", "khtml"];
				if (!b.isAndroid) if ("undefined" != typeof document.cancelFullScreen) b._u5.supportsFullScreen = !0;
				else for (var d = 0; d < c.length; d++) if (b._u5.prefix = c[d], "undefined" != typeof document[b._u5.prefix + "CancelFullScreen"]) {
					b._u5.supportsFullScreen = !0;
					break
				}
				b._u5.supportsFullScreen ? (b.nativeFS = !0, b._u5.fullScreenEventName = b._u5.prefix + "fullscreenchange" + b.ns, b._u5.isFullScreen = function () {
					switch (this.prefix) {
					case "":
						return document.fullScreen;
					case "webkit":
						return document.webkitIsFullScreen;
					default:
						return document[this.prefix + "FullScreen"]
					}
				}, b._u5.requestFullScreen = function (a) {
					return "" === this.prefix ? a.requestFullScreen() : a[this.prefix + "RequestFullScreen"]()
				}, b._u5.cancelFullScreen = function () {
					return "" === this.prefix ? document.cancelFullScreen() : document[this.prefix + "CancelFullScreen"]()
				}) : b._u5 = !1
			}
			b.st.fullscreen.buttonFS && (b._v5 = a('<div class="rsFullscreenBtn"><div class="rsFullscreenIcn"></div></div>').appendTo(b._o1).on("click.rs", function () {
				b.isFullscreen ? b.exitFullscreen() : b.enterFullscreen()
			}))
		},
		enterFullscreen: function (b) {
			var c = this;
			if (c._u5) {
				if (!b) return c._b.on(c._u5.fullScreenEventName, function () {
					c._u5.isFullScreen() ? c.enterFullscreen(!0) : c.exitFullscreen(!0)
				}), void c._u5.requestFullScreen(a("html")[0]);
				c._u5.requestFullScreen(a("html")[0])
			}
			if (!c._w5) {
				c._w5 = !0, c._b.on("keyup" + c.ns + "fullscreen", function (a) {
					27 === a.keyCode && c.exitFullscreen()
				}), c._t5 && c._b2(), b = a(window), c._x5 = b.scrollTop(), c._y5 = b.scrollLeft(), c._z5 = a("html").attr("style"), c._a6 = a("body").attr("style"), c._b6 = c.slider.attr("style"), a("body, html").css({
					overflow: "hidden",
					height: "100%",
					width: "100%",
					margin: "0",
					padding: "0"
				}), c.slider.addClass("rsFullscreen");
				var d;
				for (d = 0; d < c.numSlides; d++) b = c.slides[d], b.isRendered = !1, b.bigImage && (b.isBig = !0, b.isMedLoaded = b.isLoaded, b.isMedLoading = b.isLoading, b.medImage = b.image, b.medIW = b.iW, b.medIH = b.iH, b.slideId = -99, b.bigImage !== b.medImage && (b.sizeType = "big"), b.isLoaded = b.isBigLoaded, b.isLoading = !1, b.image = b.bigImage, b.images[0] = b.bigImage, b.iW = b.bigIW, b.iH = b.bigIH, b.isAppended = b.contentAdded = !1, c._c6(b));
				c.isFullscreen = !0, c._w5 = !1, c.updateSliderSize(), c.ev.trigger("rsEnterFullscreen")
			}
		},
		exitFullscreen: function (b) {
			var c = this;
			if (c._u5) {
				if (!b) return void c._u5.cancelFullScreen(a("html")[0]);
				c._b.off(c._u5.fullScreenEventName)
			}
			if (!c._w5) {
				c._w5 = !0, c._b.off("keyup" + c.ns + "fullscreen"), c._t5 && c._b.off("keydown" + c.ns), a("html").attr("style", c._z5 || ""), a("body").attr("style", c._a6 || "");
				var d;
				for (d = 0; d < c.numSlides; d++) b = c.slides[d], b.isRendered = !1, b.bigImage && (b.isBig = !1, b.slideId = -99, b.isBigLoaded = b.isLoaded, b.isBigLoading = b.isLoading, b.bigImage = b.image, b.bigIW = b.iW, b.bigIH = b.iH, b.isLoaded = b.isMedLoaded, b.isLoading = !1, b.image = b.medImage, b.images[0] = b.medImage, b.iW = b.medIW, b.iH = b.medIH, b.isAppended = b.contentAdded = !1, c._c6(b, !0), b.bigImage !== b.medImage && (b.sizeType = "med"));
				c.isFullscreen = !1, b = a(window), b.scrollTop(c._x5), b.scrollLeft(c._y5), c._w5 = !1, c.slider.removeClass("rsFullscreen"), c.updateSliderSize(), setTimeout(function () {
					c.updateSliderSize()
				}, 1), c.ev.trigger("rsExitFullscreen")
			}
		},
		_c6: function (b) {
			var c = b.isLoaded || b.isLoading ? '<img class="rsImg rsMainSlideImage" src="' + b.image + '"/>' : '<a class="rsImg rsMainSlideImage" href="' + b.image + '"></a>';
			b.content.hasClass("rsImg") ? b.content = a(c) : b.content.find(".rsImg").eq(0).replaceWith(c), b.isLoaded || b.isLoading || !b.holder || b.holder.html(b.content)
		}
	}), a.rsModules.fullscreen = a.rsProto._q5
}(jQuery), function (a) {
	a.extend(a.rsProto, {
		_x4: function () {
			var b, c = this;
			c._y4 = {
				enabled: !1,
				stopAtAction: !0,
				pauseOnHover: !0,
				delay: 2e3
			}, !c.st.autoPlay && c.st.autoplay && (c.st.autoPlay = c.st.autoplay), c.st.autoPlay = a.extend({}, c._y4, c.st.autoPlay), c.st.autoPlay.enabled && (c.ev.on("rsBeforeParseNode", function (c, d, e) {
				d = a(d), (b = d.attr("data-rsDelay")) && (e.customDelay = parseInt(b, 10))
			}), c.ev.one("rsAfterInit", function () {
				c._z4()
			}), c.ev.on("rsBeforeDestroy", function () {
				c.stopAutoPlay(), c.slider.off("mouseenter mouseleave"), a(window).off("blur" + c.ns + " focus" + c.ns)
			}))
		},
		_z4: function () {
			var b = this;
			b.startAutoPlay(), b.ev.on("rsAfterContentSet", function (a, c) {
				b._l2 || b._r2 || !b._a5 || c !== b.currSlide || b._b5()
			}), b.ev.on("rsDragRelease", function () {
				b._a5 && b._c5 && (b._c5 = !1, b._b5())
			}), b.ev.on("rsAfterSlideChange", function () {
				b._a5 && b._c5 && (b._c5 = !1, b.currSlide.isLoaded && b._b5())
			}), b.ev.on("rsDragStart", function () {
				b._a5 && (b.st.autoPlay.stopAtAction ? b.stopAutoPlay() : (b._c5 = !0, b._d5()))
			}), b.ev.on("rsBeforeMove", function (a, c, d) {
				b._a5 && (d && b.st.autoPlay.stopAtAction ? b.stopAutoPlay() : (b._c5 = !0, b._d5()))
			}), b._e5 = !1, b.ev.on("rsVideoStop", function () {
				b._a5 && (b._e5 = !1, b._b5())
			}), b.ev.on("rsVideoPlay", function () {
				b._a5 && (b._c5 = !1, b._d5(), b._e5 = !0)
			}), a(window).on("blur" + b.ns, function () {
				b._a5 && (b._c5 = !0, b._d5())
			}).on("focus" + b.ns, function () {
				b._a5 && b._c5 && (b._c5 = !1, b._b5())
			}), b.st.autoPlay.pauseOnHover && (b._f5 = !1, b.slider.hover(function () {
				b._a5 && (b._c5 = !1, b._d5(), b._f5 = !0)
			}, function () {
				b._a5 && (b._f5 = !1, b._b5())
			}))
		},
		toggleAutoPlay: function () {
			this._a5 ? this.stopAutoPlay() : this.startAutoPlay()
		},
		startAutoPlay: function () {
			this._a5 = !0, this.currSlide.isLoaded && this._b5()
		},
		stopAutoPlay: function () {
			this._e5 = this._f5 = this._c5 = this._a5 = !1, this._d5()
		},
		_b5: function () {
			var a = this;
			a._f5 || a._e5 || (a._g5 = !0, a._h5 && clearTimeout(a._h5), a._h5 = setTimeout(function () {
				var b;
				a._z || a.st.loopRewind || (b = !0, a.st.loopRewind = !0), a.next(!0), b && (a.st.loopRewind = !1)
			}, a.currSlide.customDelay ? a.currSlide.customDelay : a.st.autoPlay.delay))
		},
		_d5: function () {
			this._f5 || this._e5 || (this._g5 = !1, this._h5 && (clearTimeout(this._h5), this._h5 = null))
		}
	}), a.rsModules.autoplay = a.rsProto._x4
}(jQuery), function (a) {
	a.extend(a.rsProto, {
		_z6: function () {
			var b = this;
			b._a7 = {
				autoHideArrows: !0,
				autoHideControlNav: !1,
				autoHideBlocks: !1,
				autoHideCaption: !1,
				disableCSS3inFF: !0,
				youTubeCode: '<iframe src="http://www.youtube.com/embed/%id%?rel=1&showinfo=0&autoplay=1&wmode=transparent" frameborder="no"></iframe>',
				vimeoCode: '<iframe src="http://player.vimeo.com/video/%id%?byline=0&portrait=0&autoplay=1" frameborder="no" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'
			}, b.st.video = a.extend({}, b._a7, b.st.video), b.ev.on("rsBeforeSizeSet", function () {
				b._b7 && setTimeout(function () {
					var a = b._r1,
						a = a.hasClass("rsVideoContainer") ? a : a.find(".rsVideoContainer");
					b._c7 && b._c7.css({
						width: a.width(),
						height: a.height()
					})
				}, 32)
			});
			var c = b._a.mozilla;
			b.ev.on("rsAfterParseNode", function (d, e, f) {
				if (d = a(e), f.videoURL) {
					b.st.video.disableCSS3inFF && c && (b._e = b._f = !1), e = a('<div class="rsVideoContainer"></div>');
					var g = a('<div class="rsBtnCenterer"><div class="rsPlayBtn"><div class="rsPlayBtnIcon"></div></div></div>');
					d.hasClass("rsImg") ? f.content = e.append(d).append(g) : f.content.find(".rsImg").wrap(e).after(g)
				}
			}), b.ev.on("rsAfterSlideChange", function () {
				b.stopVideo()
			})
		},
		toggleVideo: function () {
			return this._b7 ? this.stopVideo() : this.playVideo()
		},
		playVideo: function () {
			var b = this;
			if (!b._b7) {
				var c = b.currSlide;
				if (!c.videoURL) return !1;
				b._d7 = c;
				var d, e, f = b._e7 = c.content,
					c = c.videoURL;
				return c.match(/youtu\.be/i) || c.match(/youtube\.com/i) ? (e = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/, (e = c.match(e)) && 11 == e[7].length && (d = e[7]), void 0 !== d && (b._c7 = b.st.video.youTubeCode.replace("%id%", d))) : c.match(/vimeo\.com/i) && (e = /(www\.)?vimeo.com\/(\d+)($|\/)/, (e = c.match(e)) && (d = e[2]), void 0 !== d && (b._c7 = b.st.video.vimeoCode.replace("%id%", d))), b.videoObj = a(b._c7), b.ev.trigger("rsOnCreateVideoElement", [c]), b.videoObj.length && (b._c7 = a('<div class="rsVideoFrameHolder"><div class="rsPreloader"></div><div class="rsCloseVideoBtn"><div class="rsCloseVideoIcn"></div></div></div>'), b._c7.find(".rsPreloader").after(b.videoObj), f = f.hasClass("rsVideoContainer") ? f : f.find(".rsVideoContainer"), b._c7.css({
					width: f.width(),
					height: f.height()
				}).find(".rsCloseVideoBtn").off("click.rsv").on("click.rsv", function (a) {
					return b.stopVideo(), a.preventDefault(), a.stopPropagation(), !1
				}), f.append(b._c7), b.isIPAD && f.addClass("rsIOSVideo"), b._f7(!1), setTimeout(function () {
					b._c7.addClass("rsVideoActive")
				}, 10), b.ev.trigger("rsVideoPlay"), b._b7 = !0), !0
			}
			return !1
		},
		stopVideo: function () {
			var a = this;
			return a._b7 ? (a.isIPAD && a.slider.find(".rsCloseVideoBtn").remove(), a._f7(!0), setTimeout(function () {
				a.ev.trigger("rsOnDestroyVideoElement", [a.videoObj]);
				var b = a._c7.find("iframe");
				if (b.length) try {
					b.attr("src", "")
				} catch (c) {}
				a._c7.remove(), a._c7 = null
			}, 16), a.ev.trigger("rsVideoStop"), a._b7 = !1, !0) : !1
		},
		_f7: function (a) {
			var b = [],
				c = this.st.video;
			if (c.autoHideArrows && (this._c2 && (b.push(this._c2, this._d2), this._e2 = !a), this._v5 && b.push(this._v5)), c.autoHideControlNav && this._k5 && b.push(this._k5), c.autoHideBlocks && this._d7.animBlocks && b.push(this._d7.animBlocks), c.autoHideCaption && this.globalCaption && b.push(this.globalCaption), this.slider[a ? "removeClass" : "addClass"]("rsVideoPlaying"), b.length) for (c = 0; c < b.length; c++) a ? b[c].removeClass("rsHidden") : b[c].addClass("rsHidden")
		}
	}), a.rsModules.video = a.rsProto._z6
}(jQuery), function (a) {
	a.extend(a.rsProto, {
		_p4: function () {
			function b() {
				var a = d.currSlide;
				if (d.currSlide && d.currSlide.isLoaded && d._t4 !== a) {
					if (0 < d._s4.length) {
						for (c = 0; c < d._s4.length; c++) clearTimeout(d._s4[c]);
						d._s4 = []
					}
					if (0 < d._r4.length) {
						var b;
						for (c = 0; c < d._r4.length; c++)(b = d._r4[c]) && (d._e ? (b.block.css(d._g + d._u1, "0s"), b.block.css(b.css)) : b.block.stop(!0).css(b.css), d._t4 = null, a.animBlocksDisplayed = !1);
						d._r4 = []
					}
					a.animBlocks && (a.animBlocksDisplayed = !0, d._t4 = a, d._u4(a.animBlocks))
				}
			}
			var c, d = this;
			d._q4 = {
				fadeEffect: !0,
				moveEffect: "top",
				moveOffset: 20,
				speed: 400,
				easing: "easeOutSine",
				delay: 200
			}, d.st.block = a.extend({}, d._q4, d.st.block), d._r4 = [], d._s4 = [], d.ev.on("rsAfterInit", function () {
				b()
			}), d.ev.on("rsBeforeParseNode", function (b, c, d) {
				c = a(c), d.animBlocks = c.find(".rsABlock").css("display", "none"), d.animBlocks.length || (d.animBlocks = c.hasClass("rsABlock") ? c.css("display", "none") : !1)
			}), d.ev.on("rsAfterContentSet", function (a, c) {
				c.id === d.slides[d.currSlideId].id && setTimeout(function () {
					b()
				}, d.st.fadeinLoadedSlide ? 300 : 0)
			}), d.ev.on("rsAfterSlideChange", function () {
				b()
			})
		},
		_v4: function (a, b) {
			setTimeout(function () {
				a.css(b)
			}, 6)
		},
		_u4: function (b) {
			var c, d, e, f, g, h, i, j = this;
			j._s4 = [], b.each(function (b) {
				c = a(this), d = {}, e = {}, f = null;
				var k = c.attr("data-move-offset"),
					k = k ? parseInt(k, 10) : j.st.block.moveOffset;
				if (k > 0 && ((h = c.data("move-effect")) ? (h = h.toLowerCase(), "none" === h ? h = !1 : "left" !== h && "top" !== h && "bottom" !== h && "right" !== h && (h = j.st.block.moveEffect, "none" === h && (h = !1))) : h = j.st.block.moveEffect, h && "none" !== h)) {
					var l;
					l = "right" === h || "left" === h ? !0 : !1;
					var m;
					i = !1, j._e ? (m = 0, g = j._x1) : (l ? isNaN(parseInt(c.css("right"), 10)) ? g = "left" : (g = "right", i = !0) : isNaN(parseInt(c.css("bottom"), 10)) ? g = "top" : (g = "bottom", i = !0), g = "margin-" + g, i && (k = -k), j._e ? m = parseInt(c.css(g), 10) : (m = c.data("rs-start-move-prop"), void 0 === m && (m = parseInt(c.css(g), 10), isNaN(m) && (m = 0), c.data("rs-start-move-prop", m)))), e[g] = j._m4("top" === h || "left" === h ? m - k : m + k, l), d[g] = j._m4(m, l)
				}
				k = c.attr("data-fade-effect"), k ? ("none" === k.toLowerCase() || "false" === k.toLowerCase()) && (k = !1) : k = j.st.block.fadeEffect, k && (e.opacity = 0, d.opacity = 1), (k || h) && (f = {}, f.hasFade = Boolean(k), Boolean(h) && (f.moveProp = g, f.hasMove = !0), f.speed = c.data("speed"), isNaN(f.speed) && (f.speed = j.st.block.speed), f.easing = c.data("easing"), f.easing || (f.easing = j.st.block.easing), f.css3Easing = a.rsCSS3Easing[f.easing], f.delay = c.data("delay"), isNaN(f.delay) && (f.delay = j.st.block.delay * b)), k = {}, j._e && (k[j._g + j._u1] = "0ms"), k.moveProp = d.moveProp, k.opacity = d.opacity, k.display = "none", j._r4.push({
					block: c,
					css: k
				}), j._v4(c, e), j._s4.push(setTimeout(function (a, b, c, d) {
					return function () {
						if (a.css("display", "block"), c) {
							var e = {};
							if (j._e) {
								var f = "";
								c.hasMove && (f += c.moveProp), c.hasFade && (c.hasMove && (f += ", "), f += "opacity"), e[j._g + j._t1] = f, e[j._g + j._u1] = c.speed + "ms", e[j._g + j._v1] = c.css3Easing, a.css(e), setTimeout(function () {
									a.css(b)
								}, 24)
							} else setTimeout(function () {
								a.animate(b, c.speed, c.easing)
							}, 16)
						}
						delete j._s4[d]
					}
				}(c, d, f, b), 6 >= f.delay ? 12 : f.delay))
			})
		}
	}), a.rsModules.animatedBlocks = a.rsProto._p4
}(jQuery), function (a) {
	a.extend(a.rsProto, {
		_w4: function () {
			var a = this;
			if (a.st.autoHeight) {
				var b, c, d, e = !0,
					f = function (f) {
						d = a.slides[a.currSlideId], (b = d.holder) && (c = b.height()) && void 0 !== c && c > (a.st.minAutoHeight || 30) && (a._c4 = c, a._e || !f ? a._e1.css("height", c) : a._e1.stop(!0, !0).animate({
							height: c
						}, a.st.transitionSpeed), a.ev.trigger("rsAutoHeightChange", c), e && (a._e && setTimeout(function () {
							a._e1.css(a._g + "transition", "height " + a.st.transitionSpeed + "ms ease-in-out")
						}, 16), e = !1))
					};
				a.ev.on("rsMaybeSizeReady.rsAutoHeight", function (a, b) {
					d === b && f()
				}), a.ev.on("rsAfterContentSet.rsAutoHeight", function (a, b) {
					d === b && f()
				}), a.slider.addClass("rsAutoHeight"), a.ev.one("rsAfterInit", function () {
					setTimeout(function () {
						f(!1), setTimeout(function () {
							a.slider.append('<div style="clear:both; float: none;"></div>')
						}, 16)
					}, 16)
				}), a.ev.on("rsBeforeAnimStart", function () {
					f(!0)
				}), a.ev.on("rsBeforeSizeSet", function () {
					setTimeout(function () {
						f(!1)
					}, 16)
				})
			}
		}
	}), a.rsModules.autoHeight = a.rsProto._w4
}(jQuery), function (a) {
	a.extend(a.rsProto, {
		_d6: function () {
			var b = this;
			b.st.globalCaption && (b.ev.on("rsAfterInit", function () {
				b.globalCaption = a('<div class="rsGCaption"></div>').appendTo(b.st.globalCaptionInside ? b._e1 : b.slider), b.globalCaption.html(b.currSlide.caption)
			}), b.ev.on("rsBeforeAnimStart", function () {
				b.globalCaption.html(b.currSlide.caption)
			}))
		}
	}), a.rsModules.globalCaption = a.rsProto._d6
}(jQuery), function (a) {
	a.rsProto._o4 = function () {
		var a, b = this;
		b.st.addActiveClass && b.ev.on("rsOnUpdateNav", function () {
			a && clearTimeout(a), a = setTimeout(function () {
				b._g4 && b._g4.removeClass("rsActiveSlide"), b._r1 && b._r1.addClass("rsActiveSlide"), a = null
			}, 50)
		})
	}, a.rsModules.activeClass = a.rsProto._o4
}(jQuery), function (a) {
	a.extend(a.rsProto, {
		_o5: function () {
			var b, c, d, e = this;
			if (e._p5 = {
				enabled: !1,
				change: !1,
				prefix: ""
			}, e.st.deeplinking = a.extend({}, e._p5, e.st.deeplinking), e.st.deeplinking.enabled) {
				var f = e.st.deeplinking.change,
					g = e.st.deeplinking.prefix,
					h = "#" + g,
					i = function () {
						var a = window.location.hash;
						return a && 0 < a.indexOf(g) && (a = parseInt(a.substring(h.length), 10), a >= 0) ? a - 1 : -1
					},
					j = i(); - 1 !== j && (e.st.startSlideId = j), f && (a(window).on("hashchange" + e.ns, function (a) {
					b || (a = i(), 0 > a || (a > e.numSlides - 1 && (a = e.numSlides - 1), e.goTo(a)))
				}), e.ev.on("rsBeforeAnimStart", function () {
					c && clearTimeout(c), d && clearTimeout(d)
				}), e.ev.on("rsAfterSlideChange", function () {
					c && clearTimeout(c), d && clearTimeout(d), d = setTimeout(function () {
						b = !0, window.location.replace(("" + window.location).split("#")[0] + h + (e.currSlideId + 1)), c = setTimeout(function () {
							b = !1, c = null
						}, 60)
					}, 400)
				})), e.ev.on("rsBeforeDestroy", function () {
					c = d = null, f && a(window).off("hashchange" + e.ns)
				})
			}
		}
	}), a.rsModules.deeplinking = a.rsProto._o5
}(jQuery), function (a, b, c) {
	function d(a) {
		return a = a || location.href, "#" + a.replace(/^[^#]*#?(.*)$/, "$1")
	}
	var e, f = "hashchange",
		g = document,
		h = a.event.special,
		i = g.documentMode,
		j = "on" + f in b && (i === c || i > 7);
	a.fn[f] = function (a) {
		return a ? this.bind(f, a) : this.trigger(f)
	}, a.fn[f].delay = 50, h[f] = a.extend(h[f], {
		setup: function () {
			return j ? !1 : void a(e.start)
		},
		teardown: function () {
			return j ? !1 : void a(e.stop)
		}
	}), e = function () {
		function e() {
			var c = d(),
				g = n(k);
			c !== k ? (m(k = c, g), a(b).trigger(f)) : g !== k && (location.href = location.href.replace(/#.*/, "") + g), h = setTimeout(e, a.fn[f].delay)
		}
		var h, i = {},
			k = d(),
			l = function (a) {
				return a
			},
			m = l,
			n = l;
		return i.start = function () {
			h || e()
		}, i.stop = function () {
			h && clearTimeout(h), h = c
		}, b.attachEvent && !b.addEventListener && !j &&
		function () {
			var b, c;
			i.start = function () {
				b || (c = (c = a.fn[f].src) && c + d(), b = a('<iframe tabindex="-1" title="empty"/>').hide().one("load", function () {
					c || m(d()), e()
				}).attr("src", c || "javascript:0").insertAfter("body")[0].contentWindow, g.onpropertychange = function () {
					try {
						"title" === event.propertyName && (b.document.title = g.title)
					} catch (a) {}
				})
			}, i.stop = l, n = function () {
				return d(b.location.href)
			}, m = function (c, d) {
				var e = b.document,
					h = a.fn[f].domain;
				c !== d && (e.title = g.title, e.open(), h && e.write('<script>document.domain="' + h + '"</script>'), e.close(), b.location.hash = c)
			}
		}(), i
	}()
}(jQuery, this), function (a) {
	a.rsProto._g7 = function () {
		var b = this;
		b.st.visibleNearby && b.st.visibleNearby.enabled && (b._h7 = {
			enabled: !0,
			centerArea: .6,
			center: !0,
			breakpoint: 0,
			breakpointCenterArea: .8,
			hiddenOverflow: !0,
			navigateByCenterClick: !1
		}, b.st.visibleNearby = a.extend({}, b._h7, b.st.visibleNearby), b.ev.one("rsAfterPropsSetup", function () {
			b._i7 = b._e1.css("overflow", "visible").wrap('<div class="rsVisibleNearbyWrap"></div>').parent(), b.st.visibleNearby.hiddenOverflow || b._i7.css("overflow", "visible"), b._o1 = b.st.controlsInside ? b._i7 : b.slider
		}), b.ev.on("rsAfterSizePropSet", function () {
			var a, c = b.st.visibleNearby;
			a = c.breakpoint && b.width < c.breakpoint ? c.breakpointCenterArea : c.centerArea, b._h ? (b._b4 *= a, b._i7.css({
				height: b._c4,
				width: b._b4 / a
			}), b._d = b._b4 * (1 - a) / 2 / a) : (b._c4 *= a, b._i7.css({
				height: b._c4 / a,
				width: b._b4
			}), b._d = b._c4 * (1 - a) / 2 / a), c.navigateByCenterClick || (b._q = b._h ? b._b4 : b._c4), c.center && b._e1.css("margin-" + (b._h ? "left" : "top"), b._d)
		}))
	}, a.rsModules.visibleNearby = a.rsProto._g7
}(jQuery);
var mejs = mejs || {};
mejs.version = "2.13.2", mejs.meIndex = 0, mejs.plugins = {
	silverlight: [{
		version: [3, 0],
		types: ["video/mp4", "video/m4v", "video/mov", "video/wmv", "audio/wma", "audio/m4a", "audio/mp3", "audio/wav", "audio/mpeg"]
	}],
	flash: [{
		version: [9, 0, 124],
		types: ["video/mp4", "video/m4v", "video/mov", "video/flv", "video/rtmp", "video/x-flv", "audio/flv", "audio/x-flv", "audio/mp3", "audio/m4a", "audio/mpeg", "video/youtube", "video/x-youtube"]
	}],
	youtube: [{
		version: null,
		types: ["video/youtube", "video/x-youtube", "audio/youtube", "audio/x-youtube"]
	}],
	vimeo: [{
		version: null,
		types: ["video/vimeo", "video/x-vimeo"]
	}]
}, mejs.Utility = {
	encodeUrl: function (a) {
		return encodeURIComponent(a)
	},
	escapeHTML: function (a) {
		return a.toString().split("&").join("&amp;").split("<").join("&lt;").split('"').join("&quot;")
	},
	absolutizeUrl: function (a) {
		var b = document.createElement("div");
		return b.innerHTML = '<a href="' + this.escapeHTML(a) + '">x</a>', b.firstChild.href
	},
	getScriptPath: function (a) {
		for (var b, c, d, e, f, g, h = 0, i = "", j = "", k = document.getElementsByTagName("script"), l = k.length, m = a.length; l > h; h++) {
			for (e = k[h].src, c = e.lastIndexOf("/"), c > -1 ? (g = e.substring(c + 1), f = e.substring(0, c + 1)) : (g = e, f = ""), b = 0; m > b; b++) if (j = a[b], d = g.indexOf(j), d > -1) {
				i = f;
				break
			}
			if ("" !== i) break
		}
		return i
	},
	secondsToTimeCode: function (a, b, c, d) {
		"undefined" == typeof c ? c = !1 : "undefined" == typeof d && (d = 25);
		var e = Math.floor(a / 3600) % 24,
			f = Math.floor(a / 60) % 60,
			g = Math.floor(a % 60),
			h = Math.floor((a % 1 * d).toFixed(3)),
			i = (b || e > 0 ? (10 > e ? "0" + e : e) + ":" : "") + (10 > f ? "0" + f : f) + ":" + (10 > g ? "0" + g : g) + (c ? ":" + (10 > h ? "0" + h : h) : "");
		return i
	},
	timeCodeToSeconds: function (a, b, c, d) {
		"undefined" == typeof c ? c = !1 : "undefined" == typeof d && (d = 25);
		var e = a.split(":"),
			f = parseInt(e[0], 10),
			g = parseInt(e[1], 10),
			h = parseInt(e[2], 10),
			i = 0,
			j = 0;
		return c && (i = parseInt(e[3]) / d), j = 3600 * f + 60 * g + h + i
	},
	convertSMPTEtoSeconds: function (a) {
		if ("string" != typeof a) return !1;
		a = a.replace(",", ".");
		var b = 0,
			c = -1 != a.indexOf(".") ? a.split(".")[1].length : 0,
			d = 1;
		a = a.split(":").reverse();
		for (var e = 0; e < a.length; e++) d = 1, e > 0 && (d = Math.pow(60, e)), b += Number(a[e]) * d;
		return Number(b.toFixed(c))
	},
	removeSwf: function (a) {
		var b = document.getElementById(a);
		b && /object|embed/i.test(b.nodeName) && (mejs.MediaFeatures.isIE ? (b.style.display = "none", function () {
			4 == b.readyState ? mejs.Utility.removeObjectInIE(a) : setTimeout(arguments.callee, 10)
		}()) : b.parentNode.removeChild(b))
	},
	removeObjectInIE: function (a) {
		var b = document.getElementById(a);
		if (b) {
			for (var c in b)"function" == typeof b[c] && (b[c] = null);
			b.parentNode.removeChild(b)
		}
	}
}, mejs.PluginDetector = {
	hasPluginVersion: function (a, b) {
		var c = this.plugins[a];
		return b[1] = b[1] || 0, b[2] = b[2] || 0, c[0] > b[0] || c[0] == b[0] && c[1] > b[1] || c[0] == b[0] && c[1] == b[1] && c[2] >= b[2] ? !0 : !1
	},
	nav: window.navigator,
	ua: window.navigator.userAgent.toLowerCase(),
	plugins: [],
	addPlugin: function (a, b, c, d, e) {
		this.plugins[a] = this.detectPlugin(b, c, d, e)
	},
	detectPlugin: function (a, b, c, d) {
		var e, f, g, h = [0, 0, 0];
		if ("undefined" != typeof this.nav.plugins && "object" == typeof this.nav.plugins[a]) {
			if (e = this.nav.plugins[a].description, e && ("undefined" == typeof this.nav.mimeTypes || !this.nav.mimeTypes[b] || this.nav.mimeTypes[b].enabledPlugin)) for (h = e.replace(a, "").replace(/^\s+/, "").replace(/\sr/gi, ".").split("."), f = 0; f < h.length; f++) h[f] = parseInt(h[f].match(/\d+/), 10)
		} else if ("undefined" != typeof window.ActiveXObject) try {
			g = new ActiveXObject(c), g && (h = d(g))
		} catch (i) {}
		return h
	}
}, mejs.PluginDetector.addPlugin("flash", "Shockwave Flash", "application/x-shockwave-flash", "ShockwaveFlash.ShockwaveFlash", function (a) {
	var b = [],
		c = a.GetVariable("$version");
	return c && (c = c.split(" ")[1].split(","), b = [parseInt(c[0], 10), parseInt(c[1], 10), parseInt(c[2], 10)]), b
}), mejs.PluginDetector.addPlugin("silverlight", "Silverlight Plug-In", "application/x-silverlight-2", "AgControl.AgControl", function (a) {
	var b = [0, 0, 0, 0],
		c = function (a, b, c, d) {
			for (; a.isVersionSupported(b[0] + "." + b[1] + "." + b[2] + "." + b[3]);) b[c] += d;
			b[c] -= d
		};
	return c(a, b, 0, 1), c(a, b, 1, 1), c(a, b, 2, 1e4), c(a, b, 2, 1e3), c(a, b, 2, 100), c(a, b, 2, 10), c(a, b, 2, 1), c(a, b, 3, 1), b
}), mejs.MediaFeatures = {
	init: function () {
		var a, b, c = this,
			d = document,
			e = mejs.PluginDetector.nav,
			f = mejs.PluginDetector.ua.toLowerCase(),
			g = ["source", "track", "audio", "video"];
		c.isiPad = null !== f.match(/ipad/i), c.isiPhone = null !== f.match(/iphone/i), c.isiOS = c.isiPhone || c.isiPad, c.isAndroid = null !== f.match(/android/i), c.isBustedAndroid = null !== f.match(/android 2\.[12]/), c.isBustedNativeHTTPS = "https:" === location.protocol && (null !== f.match(/android [12]\./) || null !== f.match(/macintosh.* version.* safari/)), c.isIE = -1 != e.appName.toLowerCase().indexOf("microsoft") || null !== e.appName.toLowerCase().match(/trident/gi), c.isChrome = null !== f.match(/chrome/gi), c.isFirefox = null !== f.match(/firefox/gi), c.isWebkit = null !== f.match(/webkit/gi), c.isGecko = null !== f.match(/gecko/gi) && !c.isWebkit && !c.isIE, c.isOpera = null !== f.match(/opera/gi), c.hasTouch = "ontouchstart" in window, c.svg = !! document.createElementNS && !! document.createElementNS("http://www.w3.org/2000/svg", "svg").createSVGRect;
		for (a = 0; a < g.length; a++) b = document.createElement(g[a]);
		c.supportsMediaTag = "undefined" != typeof b.canPlayType || c.isBustedAndroid;
		try {
			b.canPlayType("video/mp4")
		} catch (h) {
			c.supportsMediaTag = !1
		}
		c.hasSemiNativeFullScreen = "undefined" != typeof b.webkitEnterFullscreen, c.hasNativeFullscreen = "undefined" != typeof b.requestFullscreen, c.hasWebkitNativeFullScreen = "undefined" != typeof b.webkitRequestFullScreen, c.hasMozNativeFullScreen = "undefined" != typeof b.mozRequestFullScreen, c.hasMsNativeFullScreen = "undefined" != typeof b.msRequestFullscreen, c.hasTrueNativeFullScreen = c.hasWebkitNativeFullScreen || c.hasMozNativeFullScreen || c.hasMsNativeFullScreen, c.nativeFullScreenEnabled = c.hasTrueNativeFullScreen, c.hasMozNativeFullScreen ? c.nativeFullScreenEnabled = document.mozFullScreenEnabled : c.hasMsNativeFullScreen && (c.nativeFullScreenEnabled = document.msFullscreenEnabled), c.isChrome && (c.hasSemiNativeFullScreen = !1), c.hasTrueNativeFullScreen && (c.fullScreenEventName = "", c.hasWebkitNativeFullScreen ? c.fullScreenEventName = "webkitfullscreenchange" : c.hasMozNativeFullScreen ? c.fullScreenEventName = "mozfullscreenchange" : c.hasMsNativeFullScreen && (c.fullScreenEventName = "MSFullscreenChange"), c.isFullScreen = function () {
			return b.mozRequestFullScreen ? d.mozFullScreen : b.webkitRequestFullScreen ? d.webkitIsFullScreen : b.hasMsNativeFullScreen ? null !== d.msFullscreenElement : void 0
		}, c.requestFullScreen = function (a) {
			c.hasWebkitNativeFullScreen ? a.webkitRequestFullScreen() : c.hasMozNativeFullScreen ? a.mozRequestFullScreen() : c.hasMsNativeFullScreen && a.msRequestFullscreen()
		}, c.cancelFullScreen = function () {
			c.hasWebkitNativeFullScreen ? document.webkitCancelFullScreen() : c.hasMozNativeFullScreen ? document.mozCancelFullScreen() : c.hasMsNativeFullScreen && document.msExitFullscreen()
		}), c.hasSemiNativeFullScreen && f.match(/mac os x 10_5/i) && (c.hasNativeFullScreen = !1, c.hasSemiNativeFullScreen = !1)
	}
}, mejs.MediaFeatures.init(), mejs.HtmlMediaElement = {
	pluginType: "native",
	isFullScreen: !1,
	setCurrentTime: function (a) {
		this.currentTime = a
	},
	setMuted: function (a) {
		this.muted = a
	},
	setVolume: function (a) {
		this.volume = a
	},
	stop: function () {
		this.pause()
	},
	setSrc: function (a) {
		for (var b = this.getElementsByTagName("source"); b.length > 0;) this.removeChild(b[0]);
		if ("string" == typeof a) this.src = a;
		else {
			var c, d;
			for (c = 0; c < a.length; c++) if (d = a[c], this.canPlayType(d.type)) {
				this.src = d.src;
				break
			}
		}
	},
	setVideoSize: function (a, b) {
		this.width = a, this.height = b
	}
}, mejs.PluginMediaElement = function (a, b, c) {
	this.id = a, this.pluginType = b, this.src = c, this.events = {}, this.attributes = {}
}, mejs.PluginMediaElement.prototype = {
	pluginElement: null,
	pluginType: "",
	isFullScreen: !1,
	playbackRate: -1,
	defaultPlaybackRate: -1,
	seekable: [],
	played: [],
	paused: !0,
	ended: !1,
	seeking: !1,
	duration: 0,
	error: null,
	tagName: "",
	muted: !1,
	volume: 1,
	currentTime: 0,
	play: function () {
		null != this.pluginApi && ("youtube" == this.pluginType ? this.pluginApi.playVideo() : this.pluginApi.playMedia(), this.paused = !1)
	},
	load: function () {
		null != this.pluginApi && ("youtube" == this.pluginType || this.pluginApi.loadMedia(), this.paused = !1)
	},
	pause: function () {
		null != this.pluginApi && ("youtube" == this.pluginType ? this.pluginApi.pauseVideo() : this.pluginApi.pauseMedia(), this.paused = !0)
	},
	stop: function () {
		null != this.pluginApi && ("youtube" == this.pluginType ? this.pluginApi.stopVideo() : this.pluginApi.stopMedia(), this.paused = !0)
	},
	canPlayType: function (a) {
		var b, c, d, e = mejs.plugins[this.pluginType];
		for (b = 0; b < e.length; b++) if (d = e[b], mejs.PluginDetector.hasPluginVersion(this.pluginType, d.version)) for (c = 0; c < d.types.length; c++) if (a == d.types[c]) return "probably";
		return ""
	},
	positionFullscreenButton: function (a, b, c) {
		null != this.pluginApi && this.pluginApi.positionFullscreenButton && this.pluginApi.positionFullscreenButton(Math.floor(a), Math.floor(b), c)
	},
	hideFullscreenButton: function () {
		null != this.pluginApi && this.pluginApi.hideFullscreenButton && this.pluginApi.hideFullscreenButton()
	},
	setSrc: function (a) {
		if ("string" == typeof a) this.pluginApi.setSrc(mejs.Utility.absolutizeUrl(a)), this.src = mejs.Utility.absolutizeUrl(a);
		else {
			var b, c;
			for (b = 0; b < a.length; b++) if (c = a[b], this.canPlayType(c.type)) {
				this.pluginApi.setSrc(mejs.Utility.absolutizeUrl(c.src)), this.src = mejs.Utility.absolutizeUrl(a);
				break
			}
		}
	},
	setCurrentTime: function (a) {
		null != this.pluginApi && ("youtube" == this.pluginType ? this.pluginApi.seekTo(a) : this.pluginApi.setCurrentTime(a), this.currentTime = a)
	},
	setVolume: function (a) {
		null != this.pluginApi && (this.pluginApi.setVolume("youtube" == this.pluginType ? 100 * a : a), this.volume = a)
	},
	setMuted: function (a) {
		null != this.pluginApi && ("youtube" == this.pluginType ? (a ? this.pluginApi.mute() : this.pluginApi.unMute(), this.muted = a, this.dispatchEvent("volumechange")) : this.pluginApi.setMuted(a), this.muted = a)
	},
	setVideoSize: function (a, b) {
		this.pluginElement.style && (this.pluginElement.style.width = a + "px", this.pluginElement.style.height = b + "px"), null != this.pluginApi && this.pluginApi.setVideoSize && this.pluginApi.setVideoSize(a, b)
	},
	setFullscreen: function (a) {
		null != this.pluginApi && this.pluginApi.setFullscreen && this.pluginApi.setFullscreen(a)
	},
	enterFullScreen: function () {
		null != this.pluginApi && this.pluginApi.setFullscreen && this.setFullscreen(!0)
	},
	exitFullScreen: function () {
		null != this.pluginApi && this.pluginApi.setFullscreen && this.setFullscreen(!1)
	},
	addEventListener: function (a, b) {
		this.events[a] = this.events[a] || [], this.events[a].push(b)
	},
	removeEventListener: function (a, b) {
		if (!a) return this.events = {}, !0;
		var c = this.events[a];
		if (!c) return !0;
		if (!b) return this.events[a] = [], !0;
		for (i = 0; i < c.length; i++) if (c[i] === b) return this.events[a].splice(i, 1), !0;
		return !1
	},
	dispatchEvent: function (a) {
		var b, c, d = this.events[a];
		if (d) for (c = Array.prototype.slice.call(arguments, 1), b = 0; b < d.length; b++) d[b].apply(null, c)
	},
	hasAttribute: function (a) {
		return a in this.attributes
	},
	removeAttribute: function (a) {
		delete this.attributes[a]
	},
	getAttribute: function (a) {
		return this.hasAttribute(a) ? this.attributes[a] : ""
	},
	setAttribute: function (a, b) {
		this.attributes[a] = b
	},
	remove: function () {
		mejs.Utility.removeSwf(this.pluginElement.id), mejs.MediaPluginBridge.unregisterPluginElement(this.pluginElement.id)
	}
}, mejs.MediaPluginBridge = {
	pluginMediaElements: {},
	htmlMediaElements: {},
	registerPluginElement: function (a, b, c) {
		this.pluginMediaElements[a] = b, this.htmlMediaElements[a] = c
	},
	unregisterPluginElement: function (a) {
		delete this.pluginMediaElements[a], delete this.htmlMediaElements[a]
	},
	initPlugin: function (a) {
		var b = this.pluginMediaElements[a],
			c = this.htmlMediaElements[a];
		if (b) {
			switch (b.pluginType) {
			case "flash":
				b.pluginElement = b.pluginApi = document.getElementById(a);
				break;
			case "silverlight":
				b.pluginElement = document.getElementById(b.id), b.pluginApi = b.pluginElement.Content.MediaElementJS
			}
			null != b.pluginApi && b.success && b.success(b, c)
		}
	},
	fireEvent: function (a, b, c) {
		var d, e, f, g = this.pluginMediaElements[a];
		if (g) {
			d = {
				type: b,
				target: g
			};
			for (e in c) g[e] = c[e], d[e] = c[e];
			f = c.bufferedTime || 0, d.target.buffered = d.buffered = {
				start: function () {
					return 0
				},
				end: function () {
					return f
				},
				length: 1
			}, g.dispatchEvent(d.type, d)
		}
	}
}, mejs.MediaElementDefaults = {
	mode: "auto",
	plugins: ["flash", "silverlight", "youtube", "vimeo"],
	enablePluginDebug: !1,
	httpsBasicAuthSite: !1,
	type: "",
	pluginPath: mejs.Utility.getScriptPath(["mediaelement.js", "mediaelement.min.js", "mediaelement-and-player.js", "mediaelement-and-player.min.js"]),
	flashName: "flashmediaelement.swf",
	flashStreamer: "",
	enablePluginSmoothing: !1,
	enablePseudoStreaming: !1,
	pseudoStreamingStartQueryParam: "start",
	silverlightName: "silverlightmediaelement.xap",
	defaultVideoWidth: 480,
	defaultVideoHeight: 270,
	pluginWidth: -1,
	pluginHeight: -1,
	pluginVars: [],
	timerRate: 250,
	startVolume: .8,
	success: function () {},
	error: function () {}
}, mejs.MediaElement = function (a, b) {
	return mejs.HtmlMediaElementShim.create(a, b)
}, mejs.HtmlMediaElementShim = {
	create: function (a, b) {
		var c, d, e = mejs.MediaElementDefaults,
			f = "string" == typeof a ? document.getElementById(a) : a,
			g = f.tagName.toLowerCase(),
			h = "audio" === g || "video" === g,
			i = f.getAttribute(h ? "src" : "href"),
			j = f.getAttribute("poster"),
			k = f.getAttribute("autoplay"),
			l = f.getAttribute("preload"),
			m = f.getAttribute("controls");
		for (d in b) e[d] = b[d];
		return i = "undefined" == typeof i || null === i || "" == i ? null : i, j = "undefined" == typeof j || null === j ? "" : j, l = "undefined" == typeof l || null === l || "false" === l ? "none" : l, k = !("undefined" == typeof k || null === k || "false" === k), m = !("undefined" == typeof m || null === m || "false" === m), c = this.determinePlayback(f, e, mejs.MediaFeatures.supportsMediaTag, h, i), c.url = null !== c.url ? mejs.Utility.absolutizeUrl(c.url) : "", "native" == c.method ? (mejs.MediaFeatures.isBustedAndroid && (f.src = c.url, f.addEventListener("click", function () {
			f.play()
		}, !1)), this.updateNative(c, e, k, l)) : "" !== c.method ? this.createPlugin(c, e, j, k, l, m) : (this.createErrorMessage(c, e, j), this)
	},
	determinePlayback: function (a, b, c, d, e) {
		var f, g, h, i, j, k, l, m, n, o, p, q = [],
			r = {
				method: "",
				url: "",
				htmlMediaElement: a,
				isVideo: "audio" != a.tagName.toLowerCase()
			};
		if ("undefined" != typeof b.type && "" !== b.type) if ("string" == typeof b.type) q.push({
			type: b.type,
			url: e
		});
		else for (f = 0; f < b.type.length; f++) q.push({
			type: b.type[f],
			url: e
		});
		else if (null !== e) k = this.formatType(e, a.getAttribute("type")), q.push({
			type: k,
			url: e
		});
		else for (f = 0; f < a.childNodes.length; f++) j = a.childNodes[f], 1 == j.nodeType && "source" == j.tagName.toLowerCase() && (e = j.getAttribute("src"), k = this.formatType(e, j.getAttribute("type")), p = j.getAttribute("media"), (!p || !window.matchMedia || window.matchMedia && window.matchMedia(p).matches) && q.push({
			type: k,
			url: e
		}));
		if (!d && q.length > 0 && null !== q[0].url && this.getTypeFromFile(q[0].url).indexOf("audio") > -1 && (r.isVideo = !1), mejs.MediaFeatures.isBustedAndroid && (a.canPlayType = function (a) {
			return null !== a.match(/video\/(mp4|m4v)/gi) ? "maybe" : ""
		}), !(!c || "auto" !== b.mode && "auto_plugin" !== b.mode && "native" !== b.mode || mejs.MediaFeatures.isBustedNativeHTTPS && b.httpsBasicAuthSite === !0)) {
			for (d || (o = document.createElement(r.isVideo ? "video" : "audio"), a.parentNode.insertBefore(o, a), a.style.display = "none", r.htmlMediaElement = a = o), f = 0; f < q.length; f++) if ("" !== a.canPlayType(q[f].type).replace(/no/, "") || "" !== a.canPlayType(q[f].type.replace(/mp3/, "mpeg")).replace(/no/, "")) {
				r.method = "native", r.url = q[f].url;
				break
			}
			if ("native" === r.method && (null !== r.url && (a.src = r.url), "auto_plugin" !== b.mode)) return r
		}
		if ("auto" === b.mode || "auto_plugin" === b.mode || "shim" === b.mode) for (f = 0; f < q.length; f++) for (k = q[f].type, g = 0; g < b.plugins.length; g++) for (l = b.plugins[g], m = mejs.plugins[l], h = 0; h < m.length; h++) if (n = m[h], null == n.version || mejs.PluginDetector.hasPluginVersion(l, n.version)) for (i = 0; i < n.types.length; i++) if (k == n.types[i]) return r.method = l, r.url = q[f].url, r;
		return "auto_plugin" === b.mode && "native" === r.method ? r : ("" === r.method && q.length > 0 && (r.url = q[0].url), r)
	},
	formatType: function (a, b) {
		return a && !b ? this.getTypeFromFile(a) : b && ~b.indexOf(";") ? b.substr(0, b.indexOf(";")) : b
	},
	getTypeFromFile: function (a) {
		a = a.split("?")[0];
		var b = a.substring(a.lastIndexOf(".") + 1).toLowerCase();
		return (/(mp4|m4v|ogg|ogv|webm|webmv|flv|wmv|mpeg|mov)/gi.test(b) ? "video" : "audio") + "/" + this.getTypeFromExtension(b)
	},
	getTypeFromExtension: function (a) {
		switch (a) {
		case "mp4":
		case "m4v":
			return "mp4";
		case "webm":
		case "webma":
		case "webmv":
			return "webm";
		case "ogg":
		case "oga":
		case "ogv":
			return "ogg";
		default:
			return a
		}
	},
	createErrorMessage: function (a, b, c) {
		var d = a.htmlMediaElement,
			e = document.createElement("div");
		e.className = "me-cannotplay";
		try {
			e.style.width = d.width + "px", e.style.height = d.height + "px"
		} catch (f) {}
		e.innerHTML = b.customError ? b.customError : "" !== c ? '<a href="' + a.url + '"><img src="' + c + '" width="100%" height="100%" /></a>' : '<a href="' + a.url + '"><span>' + mejs.i18n.t("Download File") + "</span></a>", d.parentNode.insertBefore(e, d), d.style.display = "none", b.error(d)
	},
	createPlugin: function (a, b, c, d, e, f) {
		var g, h, i, j = a.htmlMediaElement,
			k = 1,
			l = 1,
			m = "me_" + a.method + "_" + mejs.meIndex++,
			n = new mejs.PluginMediaElement(m, a.method, a.url),
			o = document.createElement("div");
		n.tagName = j.tagName;
		for (var p = 0; p < j.attributes.length; p++) {
			var q = j.attributes[p];
			1 == q.specified && n.setAttribute(q.name, q.value)
		}
		for (h = j.parentNode; null !== h && "body" != h.tagName.toLowerCase();) {
			if ("p" == h.parentNode.tagName.toLowerCase()) {
				h.parentNode.parentNode.insertBefore(h, h.parentNode);
				break
			}
			h = h.parentNode
		}
		switch (a.isVideo ? (k = b.pluginWidth > 0 ? b.pluginWidth : b.videoWidth > 0 ? b.videoWidth : null !== j.getAttribute("width") ? j.getAttribute("width") : b.defaultVideoWidth, l = b.pluginHeight > 0 ? b.pluginHeight : b.videoHeight > 0 ? b.videoHeight : null !== j.getAttribute("height") ? j.getAttribute("height") : b.defaultVideoHeight, k = mejs.Utility.encodeUrl(k), l = mejs.Utility.encodeUrl(l)) : b.enablePluginDebug && (k = 320, l = 240), n.success = b.success, mejs.MediaPluginBridge.registerPluginElement(m, n, j), o.className = "me-plugin", o.id = m + "_container", a.isVideo ? j.parentNode.insertBefore(o, j) : document.body.insertBefore(o, document.body.childNodes[0]), i = ["id=" + m, "isvideo=" + (a.isVideo ? "true" : "false"), "autoplay=" + (d ? "true" : "false"), "preload=" + e, "width=" + k, "startvolume=" + b.startVolume, "timerrate=" + b.timerRate, "flashstreamer=" + b.flashStreamer, "height=" + l, "pseudostreamstart=" + b.pseudoStreamingStartQueryParam], null !== a.url && i.push("flash" == a.method ? "file=" + mejs.Utility.encodeUrl(a.url) : "file=" + a.url), b.enablePluginDebug && i.push("debug=true"), b.enablePluginSmoothing && i.push("smoothing=true"), b.enablePseudoStreaming && i.push("pseudostreaming=true"), f && i.push("controls=true"), b.pluginVars && (i = i.concat(b.pluginVars)), a.method) {
		case "silverlight":
			o.innerHTML = '<object data="data:application/x-silverlight-2," type="application/x-silverlight-2" id="' + m + '" name="' + m + '" width="' + k + '" height="' + l + '" class="mejs-shim"><param name="initParams" value="' + i.join(",") + '" /><param name="windowless" value="true" /><param name="background" value="black" /><param name="minRuntimeVersion" value="3.0.0.0" /><param name="autoUpgrade" value="true" /><param name="source" value="' + b.pluginPath + b.silverlightName + '" /></object>';
			break;
		case "flash":
			mejs.MediaFeatures.isIE ? (g = document.createElement("div"), o.appendChild(g), g.outerHTML = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="//download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab" id="' + m + '" width="' + k + '" height="' + l + '" class="mejs-shim"><param name="movie" value="' + b.pluginPath + b.flashName + "?x=" + new Date + '" /><param name="flashvars" value="' + i.join("&amp;") + '" /><param name="quality" value="high" /><param name="bgcolor" value="#000000" /><param name="wmode" value="transparent" /><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="true" /><param name="scale" value="default" /></object>') : o.innerHTML = '<embed id="' + m + '" name="' + m + '" play="true" loop="false" quality="high" bgcolor="#000000" wmode="transparent" allowScriptAccess="always" allowFullScreen="true" type="application/x-shockwave-flash" pluginspage="//www.macromedia.com/go/getflashplayer" src="' + b.pluginPath + b.flashName + '" flashvars="' + i.join("&") + '" width="' + k + '" height="' + l + '" scale="default"class="mejs-shim"></embed>';
			break;
		case "youtube":
			var r = a.url.substr(a.url.lastIndexOf("=") + 1);
			youtubeSettings = {
				container: o,
				containerId: o.id,
				pluginMediaElement: n,
				pluginId: m,
				videoId: r,
				height: l,
				width: k
			}, mejs.PluginDetector.hasPluginVersion("flash", [10, 0, 0]) ? mejs.YouTubeApi.createFlash(youtubeSettings) : mejs.YouTubeApi.enqueueIframe(youtubeSettings);
			break;
		case "vimeo":
			n.vimeoid = a.url.substr(a.url.lastIndexOf("/") + 1), o.innerHTML = '<iframe src="http://player.vimeo.com/video/' + n.vimeoid + '?portrait=0&byline=0&title=0" width="' + k + '" height="' + l + '" frameborder="0" class="mejs-shim"></iframe>'
		}
		return j.style.display = "none", j.removeAttribute("autoplay"), n
	},
	updateNative: function (a, b) {
		var c, d = a.htmlMediaElement;
		for (c in mejs.HtmlMediaElement) d[c] = mejs.HtmlMediaElement[c];
		return b.success(d, d), d
	}
}, mejs.YouTubeApi = {
	isIframeStarted: !1,
	isIframeLoaded: !1,
	loadIframeApi: function () {
		if (!this.isIframeStarted) {
			var a = document.createElement("script");
			a.src = "//www.youtube.com/player_api";
			var b = document.getElementsByTagName("script")[0];
			b.parentNode.insertBefore(a, b), this.isIframeStarted = !0
		}
	},
	iframeQueue: [],
	enqueueIframe: function (a) {
		this.isLoaded ? this.createIframe(a) : (this.loadIframeApi(), this.iframeQueue.push(a))
	},
	createIframe: function (a) {
		var b = a.pluginMediaElement,
			c = new YT.Player(a.containerId, {
				height: a.height,
				width: a.width,
				videoId: a.videoId,
				playerVars: {
					controls: 0
				},
				events: {
					onReady: function () {
						a.pluginMediaElement.pluginApi = c, mejs.MediaPluginBridge.initPlugin(a.pluginId), setInterval(function () {
							mejs.YouTubeApi.createEvent(c, b, "timeupdate")
						}, 250)
					},
					onStateChange: function (a) {
						mejs.YouTubeApi.handleStateChange(a.data, c, b)
					}
				}
			})
	},
	createEvent: function (a, b, c) {
		var d = {
			type: c,
			target: b
		};
		if (a && a.getDuration) {
			b.currentTime = d.currentTime = a.getCurrentTime(), b.duration = d.duration = a.getDuration(), d.paused = b.paused, d.ended = b.ended, d.muted = a.isMuted(), d.volume = a.getVolume() / 100, d.bytesTotal = a.getVideoBytesTotal(), d.bufferedBytes = a.getVideoBytesLoaded();
			var e = d.bufferedBytes / d.bytesTotal * d.duration;
			d.target.buffered = d.buffered = {
				start: function () {
					return 0
				},
				end: function () {
					return e
				},
				length: 1
			}
		}
		b.dispatchEvent(d.type, d)
	},
	iFrameReady: function () {
		for (this.isLoaded = !0, this.isIframeLoaded = !0; this.iframeQueue.length > 0;) {
			var a = this.iframeQueue.pop();
			this.createIframe(a)
		}
	},
	flashPlayers: {},
	createFlash: function (a) {
		this.flashPlayers[a.pluginId] = a;
		var b, c = "//www.youtube.com/apiplayer?enablejsapi=1&amp;playerapiid=" + a.pluginId + "&amp;version=3&amp;autoplay=0&amp;controls=0&amp;modestbranding=1&loop=0";
		mejs.MediaFeatures.isIE ? (b = document.createElement("div"), a.container.appendChild(b), b.outerHTML = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="//download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab" id="' + a.pluginId + '" width="' + a.width + '" height="' + a.height + '" class="mejs-shim"><param name="movie" value="' + c + '" /><param name="wmode" value="transparent" /><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="true" /></object>') : a.container.innerHTML = '<object type="application/x-shockwave-flash" id="' + a.pluginId + '" data="' + c + '" width="' + a.width + '" height="' + a.height + '" style="visibility: visible; " class="mejs-shim"><param name="allowScriptAccess" value="always"><param name="wmode" value="transparent"></object>'
	},
	flashReady: function (a) {
		var b = this.flashPlayers[a],
			c = document.getElementById(a),
			d = b.pluginMediaElement;
		d.pluginApi = d.pluginElement = c, mejs.MediaPluginBridge.initPlugin(a), c.cueVideoById(b.videoId);
		var e = b.containerId + "_callback";
		window[e] = function (a) {
			mejs.YouTubeApi.handleStateChange(a, c, d)
		}, c.addEventListener("onStateChange", e), setInterval(function () {
			mejs.YouTubeApi.createEvent(c, d, "timeupdate")
		}, 250)
	},
	handleStateChange: function (a, b, c) {
		switch (a) {
		case -1:
			c.paused = !0, c.ended = !0, mejs.YouTubeApi.createEvent(b, c, "loadedmetadata");
			break;
		case 0:
			c.paused = !1, c.ended = !0, mejs.YouTubeApi.createEvent(b, c, "ended");
			break;
		case 1:
			c.paused = !1, c.ended = !1, mejs.YouTubeApi.createEvent(b, c, "play"), mejs.YouTubeApi.createEvent(b, c, "playing");
			break;
		case 2:
			c.paused = !0, c.ended = !1, mejs.YouTubeApi.createEvent(b, c, "pause");
			break;
		case 3:
			mejs.YouTubeApi.createEvent(b, c, "progress");
			break;
		case 5:
		}
	}
}, window.mejs = mejs, window.MediaElement = mejs.MediaElement, function (a, b) {
	"use strict";
	var c = {
		locale: {
			language: "",
			strings: {}
		},
		methods: {}
	};
	c.getLanguage = function () {
		var a = c.locale.language || window.navigator.userLanguage || window.navigator.language;
		return a.substr(0, 2).toLowerCase()
	}, "undefined" != typeof mejsL10n && (c.locale.language = mejsL10n.language), c.methods.checkPlain = function (a) {
		var b, c, d = {
			"&": "&amp;",
			'"': "&quot;",
			"<": "&lt;",
			">": "&gt;"
		};
		a = String(a);
		for (b in d) d.hasOwnProperty(b) && (c = new RegExp(b, "g"), a = a.replace(c, d[b]));
		return a
	}, c.methods.t = function (a, b) {
		return c.locale.strings && c.locale.strings[b.context] && c.locale.strings[b.context][a] && (a = c.locale.strings[b.context][a]), c.methods.checkPlain(a)
	}, c.t = function (a, b) {
		if ("string" == typeof a && a.length > 0) {
			var d = c.getLanguage();
			return b = b || {
				context: d
			}, c.methods.t(a, b)
		}
		throw {
			name: "InvalidArgumentException",
			message: "First argument is either not a string or empty."
		}
	}, b.i18n = c
}(document, mejs), function (a) {
	"use strict";
	"undefined" != typeof mejsL10n && (a[mejsL10n.language] = mejsL10n.strings)
}(mejs.i18n.locale.strings), function (a) {
	"use strict";
	"undefined" == typeof a.de && (a.de = {
		Fullscreen: "Vollbild",
		"Go Fullscreen": "Vollbild an",
		"Turn off Fullscreen": "Vollbild aus",
		Close: "Schließen"
	})
}(mejs.i18n.locale.strings), function (a) {
	"use strict";
	"undefined" == typeof a.zh && (a.zh = {
		Fullscreen: "全螢幕",
		"Go Fullscreen": "全屏模式",
		"Turn off Fullscreen": "退出全屏模式",
		Close: "關閉"
	})
}(mejs.i18n.locale.strings), "undefined" != typeof jQuery ? mejs.$ = jQuery : "undefined" != typeof ender && (mejs.$ = ender), function (a) {
	mejs.MepDefaults = {
		poster: "",
		showPosterWhenEnded: !1,
		defaultVideoWidth: 480,
		defaultVideoHeight: 270,
		videoWidth: -1,
		videoHeight: -1,
		defaultAudioWidth: 400,
		defaultAudioHeight: 30,
		defaultSeekBackwardInterval: function (a) {
			return.05 * a.duration
		},
		defaultSeekForwardInterval: function (a) {
			return.05 * a.duration
		},
		audioWidth: -1,
		audioHeight: -1,
		startVolume: .8,
		loop: !1,
		autoRewind: !0,
		enableAutosize: !0,
		alwaysShowHours: !1,
		showTimecodeFrameCount: !1,
		framesPerSecond: 25,
		autosizeProgress: !0,
		alwaysShowControls: !1,
		hideVideoControlsOnLoad: !1,
		clickToPlayPause: !0,
		iPadUseNativeControls: !1,
		iPhoneUseNativeControls: !1,
		AndroidUseNativeControls: !1,
		features: ["playpause", "current", "progress", "duration", "tracks", "volume", "fullscreen"],
		isVideo: !0,
		enableKeyboard: !0,
		pauseOtherPlayers: !0,
		keyActions: [{
			keys: [32, 179],
			action: function (a, b) {
				b.paused || b.ended ? a.play() : a.pause()
			}
		},
		{
			keys: [38],
			action: function (a, b) {
				var c = Math.min(b.volume + .1, 1);
				b.setVolume(c)
			}
		},
		{
			keys: [40],
			action: function (a, b) {
				var c = Math.max(b.volume - .1, 0);
				b.setVolume(c)
			}
		},
		{
			keys: [37, 227],
			action: function (a, b) {
				if (!isNaN(b.duration) && b.duration > 0) {
					a.isVideo && (a.showControls(), a.startControlsTimer());
					var c = Math.max(b.currentTime - a.options.defaultSeekBackwardInterval(b), 0);
					b.setCurrentTime(c)
				}
			}
		},
		{
			keys: [39, 228],
			action: function (a, b) {
				if (!isNaN(b.duration) && b.duration > 0) {
					a.isVideo && (a.showControls(), a.startControlsTimer());
					var c = Math.min(b.currentTime + a.options.defaultSeekForwardInterval(b), b.duration);
					b.setCurrentTime(c)
				}
			}
		},
		{
			keys: [70],
			action: function (a) {
				"undefined" != typeof a.enterFullScreen && (a.isFullScreen ? a.exitFullScreen() : a.enterFullScreen())
			}
		}]
	}, mejs.mepIndex = 0, mejs.players = {}, mejs.MediaElementPlayer = function (b, c) {
		if (!(this instanceof mejs.MediaElementPlayer)) return new mejs.MediaElementPlayer(b, c);
		var d = this;
		return d.$media = d.$node = a(b), d.node = d.media = d.$media[0], "undefined" != typeof d.node.player ? d.node.player : (d.node.player = d, "undefined" == typeof c && (c = d.$node.data("mejsoptions")), d.options = a.extend({}, mejs.MepDefaults, c), d.id = "mep_" + mejs.mepIndex++, mejs.players[d.id] = d, d.init(), d)
	}, mejs.MediaElementPlayer.prototype = {
		hasFocus: !1,
		controlsAreVisible: !0,
		init: function () {
			var b = this,
				c = mejs.MediaFeatures,
				d = a.extend(!0, {}, b.options, {
					success: function (a, c) {
						b.meReady(a, c)
					},
					error: function (a) {
						b.handleError(a)
					}
				}),
				e = b.media.tagName.toLowerCase();
			if (b.isDynamic = "audio" !== e && "video" !== e, b.isVideo = b.isDynamic ? b.options.isVideo : "audio" !== e && b.options.isVideo, c.isiPad && b.options.iPadUseNativeControls || c.isiPhone && b.options.iPhoneUseNativeControls) b.$media.attr("controls", "controls"), c.isiPad && null !== b.media.getAttribute("autoplay") && b.play();
			else if (c.isAndroid && b.options.AndroidUseNativeControls);
			else {
				if (b.$media.removeAttr("controls"), b.container = a('<div id="' + b.id + '" class="mejs-container ' + (mejs.MediaFeatures.svg ? "svg" : "no-svg") + '"><div class="mejs-inner"><div class="mejs-mediaelement"></div><div class="mejs-layers"></div><div class="mejs-controls"></div><div class="mejs-clear"></div></div></div>').addClass(b.$media[0].className).insertBefore(b.$media), b.container.addClass((c.isAndroid ? "mejs-android " : "") + (c.isiOS ? "mejs-ios " : "") + (c.isiPad ? "mejs-ipad " : "") + (c.isiPhone ? "mejs-iphone " : "") + (b.isVideo ? "mejs-video " : "mejs-audio ")), c.isiOS) {
					var f = b.$media.clone();
					b.container.find(".mejs-mediaelement").append(f), b.$media.remove(), b.$node = b.$media = f, b.node = b.media = f[0]
				} else b.container.find(".mejs-mediaelement").append(b.$media);
				b.controls = b.container.find(".mejs-controls"), b.layers = b.container.find(".mejs-layers");
				var g = b.isVideo ? "video" : "audio",
					h = g.substring(0, 1).toUpperCase() + g.substring(1);
				b.width = b.options[g + "Width"] > 0 || b.options[g + "Width"].toString().indexOf("%") > -1 ? b.options[g + "Width"] : "" !== b.media.style.width && null !== b.media.style.width ? b.media.style.width : null !== b.media.getAttribute("width") ? b.$media.attr("width") : b.options["default" + h + "Width"], b.height = b.options[g + "Height"] > 0 || b.options[g + "Height"].toString().indexOf("%") > -1 ? b.options[g + "Height"] : "" !== b.media.style.height && null !== b.media.style.height ? b.media.style.height : null !== b.$media[0].getAttribute("height") ? b.$media.attr("height") : b.options["default" + h + "Height"], b.setPlayerSize(b.width, b.height), d.pluginWidth = b.width, d.pluginHeight = b.height
			}
			mejs.MediaElement(b.$media[0], d), "undefined" != typeof b.container && b.controlsAreVisible && b.container.trigger("controlsshown")
		},
		showControls: function (a) {
			var b = this;
			a = "undefined" == typeof a || a, b.controlsAreVisible || (a ? (b.controls.css("visibility", "visible").stop(!0, !0).fadeIn(200, function () {
				b.controlsAreVisible = !0, b.container.trigger("controlsshown")
			}), b.container.find(".mejs-control").css("visibility", "visible").stop(!0, !0).fadeIn(200, function () {
				b.controlsAreVisible = !0
			})) : (b.controls.css("visibility", "visible").css("display", "block"), b.container.find(".mejs-control").css("visibility", "visible").css("display", "block"), b.controlsAreVisible = !0, b.container.trigger("controlsshown")), b.setControlsSize())
		},
		hideControls: function (b) {
			var c = this;
			b = "undefined" == typeof b || b, c.controlsAreVisible && !c.options.alwaysShowControls && (b ? (c.controls.stop(!0, !0).fadeOut(200, function () {
				a(this).css("visibility", "hidden").css("display", "block"), c.controlsAreVisible = !1, c.container.trigger("controlshidden")
			}), c.container.find(".mejs-control").stop(!0, !0).fadeOut(200, function () {
				a(this).css("visibility", "hidden").css("display", "block")
			})) : (c.controls.css("visibility", "hidden").css("display", "block"), c.container.find(".mejs-control").css("visibility", "hidden").css("display", "block"), c.controlsAreVisible = !1, c.container.trigger("controlshidden")))
		},
		controlsTimer: null,
		startControlsTimer: function (a) {
			var b = this;
			a = "undefined" != typeof a ? a : 1500, b.killControlsTimer("start"), b.controlsTimer = setTimeout(function () {
				b.hideControls(), b.killControlsTimer("hide")
			}, a)
		},
		killControlsTimer: function () {
			var a = this;
			null !== a.controlsTimer && (clearTimeout(a.controlsTimer), delete a.controlsTimer, a.controlsTimer = null)
		},
		controlsEnabled: !0,
		disableControls: function () {
			var a = this;
			a.killControlsTimer(), a.hideControls(!1), this.controlsEnabled = !1
		},
		enableControls: function () {
			var a = this;
			a.showControls(!1), a.controlsEnabled = !0
		},
		meReady: function (a, b) {
			var c, d, e = this,
				f = mejs.MediaFeatures,
				g = b.getAttribute("autoplay"),
				h = !("undefined" == typeof g || null === g || "false" === g);
			if (!e.created) {
				if (e.created = !0, e.media = a, e.domNode = b, !(f.isAndroid && e.options.AndroidUseNativeControls || f.isiPad && e.options.iPadUseNativeControls || f.isiPhone && e.options.iPhoneUseNativeControls)) {
					e.buildposter(e, e.controls, e.layers, e.media), e.buildkeyboard(e, e.controls, e.layers, e.media), e.buildoverlays(e, e.controls, e.layers, e.media), e.findTracks();
					for (c in e.options.features) if (d = e.options.features[c], e["build" + d]) try {
						e["build" + d](e, e.controls, e.layers, e.media)
					} catch (i) {}
					e.container.trigger("controlsready"), e.setPlayerSize(e.width, e.height), e.setControlsSize(), e.isVideo && (mejs.MediaFeatures.hasTouch ? e.$media.bind("touchstart", function () {
						e.controlsAreVisible ? e.hideControls(!1) : e.controlsEnabled && e.showControls(!1)
					}) : (mejs.MediaElementPlayer.prototype.clickToPlayPauseCallback = function () {
						e.options.clickToPlayPause && (e.media.paused ? e.play() : e.pause())
					}, e.media.addEventListener("click", e.clickToPlayPauseCallback, !1), e.container.bind("mouseenter mouseover", function () {
						e.controlsEnabled && (e.options.alwaysShowControls || (e.killControlsTimer("enter"), e.showControls(), e.startControlsTimer(2500)))
					}).bind("mousemove", function () {
						e.controlsEnabled && (e.controlsAreVisible || e.showControls(), e.options.alwaysShowControls || e.startControlsTimer(2500))
					}).bind("mouseleave", function () {
						e.controlsEnabled && (e.media.paused || e.options.alwaysShowControls || e.startControlsTimer(1e3))
					})), e.options.hideVideoControlsOnLoad && e.hideControls(!1), h && !e.options.alwaysShowControls && e.hideControls(), e.options.enableAutosize && e.media.addEventListener("loadedmetadata", function (a) {
						e.options.videoHeight <= 0 && null === e.domNode.getAttribute("height") && !isNaN(a.target.videoHeight) && (e.setPlayerSize(a.target.videoWidth, a.target.videoHeight), e.setControlsSize(), e.media.setVideoSize(a.target.videoWidth, a.target.videoHeight))
					}, !1)), a.addEventListener("play", function () {
						var a;
						for (a in mejs.players) {
							var b = mejs.players[a];
							b.id == e.id || !e.options.pauseOtherPlayers || b.paused || b.ended || b.pause(), b.hasFocus = !1
						}
						e.hasFocus = !0
					}, !1), e.media.addEventListener("ended", function () {
						if (e.options.autoRewind) try {
							e.media.setCurrentTime(0)
						} catch (a) {}
						e.media.pause(), e.setProgressRail && e.setProgressRail(), e.setCurrentRail && e.setCurrentRail(), e.options.loop ? e.play() : !e.options.alwaysShowControls && e.controlsEnabled && e.showControls()
					}, !1), e.media.addEventListener("loadedmetadata", function () {
						e.updateDuration && e.updateDuration(), e.updateCurrent && e.updateCurrent(), e.isFullScreen || (e.setPlayerSize(e.width, e.height), e.setControlsSize())
					}, !1), setTimeout(function () {
						e.setPlayerSize(e.width, e.height), e.setControlsSize()
					}, 50), e.globalBind("resize", function () {
						e.isFullScreen || mejs.MediaFeatures.hasTrueNativeFullScreen && document.webkitIsFullScreen || e.setPlayerSize(e.width, e.height), e.setControlsSize()
					}), "youtube" == e.media.pluginType && e.container.find(".mejs-overlay-play").hide()
				}
				h && "native" == a.pluginType && e.play(), e.options.success && ("string" == typeof e.options.success ? window[e.options.success](e.media, e.domNode, e) : e.options.success(e.media, e.domNode, e))
			}
		},
		handleError: function (a) {
			var b = this;
			b.controls.hide(), b.options.error && b.options.error(a)
		},
		setPlayerSize: function (b, c) {
			var d = this;
			if ("undefined" != typeof b && (d.width = b), "undefined" != typeof c && (d.height = c), d.height.toString().indexOf("%") > 0 || "100%" === d.$node.css("max-width") || parseInt(d.$node.css("max-width").replace(/px/, ""), 10) / d.$node.offsetParent().width() === 1 || d.$node[0].currentStyle && "100%" === d.$node[0].currentStyle.maxWidth) {
				var e = d.isVideo ? d.media.videoWidth && d.media.videoWidth > 0 ? d.media.videoWidth : d.options.defaultVideoWidth : d.options.defaultAudioWidth,
					f = d.isVideo ? d.media.videoHeight && d.media.videoHeight > 0 ? d.media.videoHeight : d.options.defaultVideoHeight : d.options.defaultAudioHeight,
					g = d.container.parent().closest(":visible").width(),
					h = d.isVideo || !d.options.autosizeProgress ? parseInt(g * f / e, 10) : f;
				"body" === d.container.parent()[0].tagName.toLowerCase() && (g = a(window).width(), h = a(window).height()), 0 != h && 0 != g && (d.container.width(g).height(h), d.$media.add(d.container.find(".mejs-shim")).width("100%").height("100%"), d.isVideo && d.media.setVideoSize && d.media.setVideoSize(g, h), d.layers.children(".mejs-layer").width("100%").height("100%"))
			} else d.container.width(d.width).height(d.height), d.layers.children(".mejs-layer").width(d.width).height(d.height);
			var i = d.layers.find(".mejs-overlay-play"),
				j = i.find(".mejs-overlay-button");
			i.height(d.container.height() - d.controls.height()), j.css("margin-top", "-" + (j.height() / 2 - d.controls.height() / 2).toString() + "px")
		},
		setControlsSize: function () {
			var b = this,
				c = 0,
				d = 0,
				e = b.controls.find(".mejs-time-rail"),
				f = b.controls.find(".mejs-time-total"),
				g = (b.controls.find(".mejs-time-current"), b.controls.find(".mejs-time-loaded"), e.siblings());
			b.options && !b.options.autosizeProgress && (d = parseInt(e.css("width"))), 0 !== d && d || (g.each(function () {
				var b = a(this);
				"absolute" != b.css("position") && b.is(":visible") && (c += a(this).outerWidth(!0))
			}), d = b.controls.width() - c - (e.outerWidth(!0) - e.width())), d -= 2, e.width(d), f.width(d - (f.outerWidth(!0) - f.width())), b.setProgressRail && b.setProgressRail(), b.setCurrentRail && b.setCurrentRail()
		},
		buildposter: function (b, c, d, e) {
			var f = this,
				g = a('<div class="mejs-poster mejs-layer"></div>').appendTo(d),
				h = b.$media.attr("poster");
			"" !== b.options.poster && (h = b.options.poster), "" !== h && null != h ? f.setPoster(h) : g.hide(), e.addEventListener("play", function () {
				g.hide()
			}, !1), b.options.showPosterWhenEnded && b.options.autoRewind && e.addEventListener("ended", function () {
				g.show()
			}, !1)
		},
		setPoster: function (b) {
			var c = this,
				d = c.container.find(".mejs-poster"),
				e = d.find("img");
			0 == e.length && (e = a('<img width="100%" height="100%" />').appendTo(d)), e.attr("src", b), d.css({
				"background-image": "url(" + b + ")"
			})
		},
		buildoverlays: function (b, c, d, e) {
			var f = this;
			if (b.isVideo) {
				var g = a('<div class="mejs-overlay mejs-layer"><div class="mejs-overlay-loading"><span></span></div></div>').hide().appendTo(d),
					h = a('<div class="mejs-overlay mejs-layer"><div class="mejs-overlay-error"></div></div>').hide().appendTo(d),
					i = a('<div class="mejs-overlay mejs-layer mejs-overlay-play"><div class="mejs-overlay-button"></div></div>').appendTo(d).bind("click touchstart", function () {
						f.options.clickToPlayPause && e.paused && f.play()
					});
				e.addEventListener("play", function () {
					i.hide(), g.hide(), c.find(".mejs-time-buffering").hide(), h.hide()
				}, !1), e.addEventListener("playing", function () {
					i.hide(), g.hide(), c.find(".mejs-time-buffering").hide(), h.hide()
				}, !1), e.addEventListener("seeking", function () {
					g.show(), c.find(".mejs-time-buffering").show()
				}, !1), e.addEventListener("seeked", function () {
					g.hide(), c.find(".mejs-time-buffering").hide()
				}, !1), e.addEventListener("pause", function () {
					mejs.MediaFeatures.isiPhone || i.show()
				}, !1), e.addEventListener("waiting", function () {
					g.show(), c.find(".mejs-time-buffering").show()
				}, !1), e.addEventListener("loadeddata", function () {
					g.show(), c.find(".mejs-time-buffering").show()
				}, !1), e.addEventListener("canplay", function () {
					g.hide(), c.find(".mejs-time-buffering").hide()
				}, !1), e.addEventListener("error", function () {
					g.hide(), c.find(".mejs-time-buffering").hide(), h.show(), h.find("mejs-overlay-error").html("Error loading this resource")
				}, !1)
			}
		},
		buildkeyboard: function (b, c, d, e) {
			var f = this;
			f.globalBind("keydown", function (a) {
				if (b.hasFocus && b.options.enableKeyboard) for (var c = 0, d = b.options.keyActions.length; d > c; c++) for (var f = b.options.keyActions[c], g = 0, h = f.keys.length; h > g; g++) if (a.keyCode == f.keys[g]) return a.preventDefault(), f.action(b, e, a.keyCode), !1;
				return !0
			}), f.globalBind("click", function (c) {
				0 == a(c.target).closest(".mejs-container").length && (b.hasFocus = !1)
			})
		},
		findTracks: function () {
			var b = this,
				c = b.$media.find("track");
			b.tracks = [], c.each(function (c, d) {
				d = a(d), b.tracks.push({
					srclang: d.attr("srclang") ? d.attr("srclang").toLowerCase() : "",
					src: d.attr("src"),
					kind: d.attr("kind"),
					label: d.attr("label") || "",
					entries: [],
					isLoaded: !1
				})
			})
		},
		changeSkin: function (a) {
			this.container[0].className = "mejs-container " + a, this.setPlayerSize(this.width, this.height), this.setControlsSize()
		},
		play: function () {
			this.load(), this.media.play()
		},
		pause: function () {
			try {
				this.media.pause()
			} catch (a) {}
		},
		load: function () {
			this.isLoaded || this.media.load(), this.isLoaded = !0
		},
		setMuted: function (a) {
			this.media.setMuted(a)
		},
		setCurrentTime: function (a) {
			this.media.setCurrentTime(a)
		},
		getCurrentTime: function () {
			return this.media.currentTime
		},
		setVolume: function (a) {
			this.media.setVolume(a)
		},
		getVolume: function () {
			return this.media.volume
		},
		setSrc: function (a) {
			this.media.setSrc(a)
		},
		remove: function () {
			var a, b, c = this;
			for (a in c.options.features) if (b = c.options.features[a], c["clean" + b]) try {
				c["clean" + b](c)
			} catch (d) {}
			c.isDynamic ? c.$node.insertBefore(c.container) : (c.$media.prop("controls", !0), c.$node.clone().show().insertBefore(c.container), c.$node.remove()), "native" !== c.media.pluginType && c.media.remove(), delete mejs.players[c.id], c.container.remove(), c.globalUnbind(), delete c.node.player
		}
	}, function () {
		function b(b, d) {
			var e = {
				d: [],
				w: []
			};
			return a.each((b || "").split(" "), function (a, b) {
				var f = b + "." + d;
				0 === f.indexOf(".") ? (e.d.push(f), e.w.push(f)) : e[c.test(b) ? "w" : "d"].push(f)
			}), e.d = e.d.join(" "), e.w = e.w.join(" "), e
		}
		var c = /^((after|before)print|(before)?unload|hashchange|message|o(ff|n)line|page(hide|show)|popstate|resize|storage)\b/;
		mejs.MediaElementPlayer.prototype.globalBind = function (c, d, e) {
			var f = this;
			c = b(c, f.id), c.d && a(document).bind(c.d, d, e), c.w && a(window).bind(c.w, d, e)
		}, mejs.MediaElementPlayer.prototype.globalUnbind = function (c, d) {
			var e = this;
			c = b(c, e.id), c.d && a(document).unbind(c.d, d), c.w && a(window).unbind(c.w, d)
		}
	}(), "undefined" != typeof jQuery && (jQuery.fn.mediaelementplayer = function (a) {
		return this.each(a === !1 ?
		function () {
			var a = jQuery(this).data("mediaelementplayer");
			a && a.remove(), jQuery(this).removeData("mediaelementplayer")
		} : function () {
			jQuery(this).data("mediaelementplayer", new mejs.MediaElementPlayer(this, a))
		}), this
	}), a(document).ready(function () {
		a(".mejs-player").mediaelementplayer()
	}), window.MediaElementPlayer = mejs.MediaElementPlayer
}(mejs.$), function (a) {
	a.extend(mejs.MepDefaults, {
		playpauseText: mejs.i18n.t("Play/Pause")
	}), a.extend(MediaElementPlayer.prototype, {
		buildplaypause: function (b, c, d, e) {
			var f = this,
				g = a('<div class="mejs-button mejs-playpause-button mejs-play" ><button type="button" aria-controls="' + f.id + '" title="' + f.options.playpauseText + '" aria-label="' + f.options.playpauseText + '"></button></div>').appendTo(c).click(function (a) {
					return a.preventDefault(), e.paused ? e.play() : e.pause(), !1
				});
			e.addEventListener("play", function () {
				g.removeClass("mejs-play").addClass("mejs-pause")
			}, !1), e.addEventListener("playing", function () {
				g.removeClass("mejs-play").addClass("mejs-pause")
			}, !1), e.addEventListener("pause", function () {
				g.removeClass("mejs-pause").addClass("mejs-play")
			}, !1), e.addEventListener("paused", function () {
				g.removeClass("mejs-pause").addClass("mejs-play")
			}, !1)
		}
	})
}(mejs.$), function (a) {
	a.extend(mejs.MepDefaults, {
		stopText: "Stop"
	}), a.extend(MediaElementPlayer.prototype, {
		buildstop: function (b, c, d, e) {
			{
				var f = this;
				a('<div class="mejs-button mejs-stop-button mejs-stop"><button type="button" aria-controls="' + f.id + '" title="' + f.options.stopText + '" aria-label="' + f.options.stopText + '"></button></div>').appendTo(c).click(function () {
					e.paused || e.pause(), e.currentTime > 0 && (e.setCurrentTime(0), e.pause(), c.find(".mejs-time-current").width("0px"), c.find(".mejs-time-handle").css("left", "0px"), c.find(".mejs-time-float-current").html(mejs.Utility.secondsToTimeCode(0)), c.find(".mejs-currenttime").html(mejs.Utility.secondsToTimeCode(0)), d.find(".mejs-poster").show())
				})
			}
		}
	})
}(mejs.$), function (a) {
	a.extend(MediaElementPlayer.prototype, {
		buildprogress: function (b, c, d, e) {
			a('<div class="mejs-time-rail"><span class="mejs-time-total"><span class="mejs-time-buffering"></span><span class="mejs-time-loaded"></span><span class="mejs-time-current"></span><span class="mejs-time-handle"></span><span class="mejs-time-float"><span class="mejs-time-float-current">00:00</span><span class="mejs-time-float-corner"></span></span></span></div>').appendTo(c), c.find(".mejs-time-buffering").hide();
			var f = this,
				g = c.find(".mejs-time-total"),
				h = c.find(".mejs-time-loaded"),
				i = c.find(".mejs-time-current"),
				j = c.find(".mejs-time-handle"),
				k = c.find(".mejs-time-float"),
				l = c.find(".mejs-time-float-current"),
				m = function (a) {
					var b = a.pageX,
						c = g.offset(),
						d = g.outerWidth(!0),
						f = 0,
						h = 0,
						i = 0;
					e.duration && (b < c.left ? b = c.left : b > d + c.left && (b = d + c.left), i = b - c.left, f = i / d, h = .02 >= f ? 0 : f * e.duration, n && h !== e.currentTime && e.setCurrentTime(h), mejs.MediaFeatures.hasTouch || (k.css("left", i), l.html(mejs.Utility.secondsToTimeCode(h)), k.show()))
				},
				n = !1,
				o = !1;
			g.bind("mousedown", function (a) {
				return 1 === a.which ? (n = !0, m(a), f.globalBind("mousemove.dur", function (a) {
					m(a)
				}), f.globalBind("mouseup.dur", function () {
					n = !1, k.hide(), f.globalUnbind(".dur")
				}), !1) : void 0
			}).bind("mouseenter", function () {
				o = !0, f.globalBind("mousemove.dur", function (a) {
					m(a)
				}), mejs.MediaFeatures.hasTouch || k.show()
			}).bind("mouseleave", function () {
				o = !1, n || (f.globalUnbind(".dur"), k.hide())
			}), e.addEventListener("progress", function (a) {
				b.setProgressRail(a), b.setCurrentRail(a)
			}, !1), e.addEventListener("timeupdate", function (a) {
				b.setProgressRail(a), b.setCurrentRail(a)
			}, !1), f.loaded = h, f.total = g, f.current = i, f.handle = j
		},
		setProgressRail: function (a) {
			var b = this,
				c = void 0 != a ? a.target : b.media,
				d = null;
			c && c.buffered && c.buffered.length > 0 && c.buffered.end && c.duration ? d = c.buffered.end(0) / c.duration : c && void 0 != c.bytesTotal && c.bytesTotal > 0 && void 0 != c.bufferedBytes ? d = c.bufferedBytes / c.bytesTotal : a && a.lengthComputable && 0 != a.total && (d = a.loaded / a.total), null !== d && (d = Math.min(1, Math.max(0, d)), b.loaded && b.total && b.loaded.width(b.total.width() * d))
		},
		setCurrentRail: function () {
			var a = this;
			if (void 0 != a.media.currentTime && a.media.duration && a.total && a.handle) {
				var b = Math.round(a.total.width() * a.media.currentTime / a.media.duration),
					c = b - Math.round(a.handle.outerWidth(!0) / 2);
				a.current.width(b), a.handle.css("left", c)
			}
		}
	})
}(mejs.$), function (a) {
	a.extend(mejs.MepDefaults, {
		duration: -1,
		timeAndDurationSeparator: "<span> | </span>"
	}), a.extend(MediaElementPlayer.prototype, {
		buildcurrent: function (b, c, d, e) {
			var f = this;
			a('<div class="mejs-time"><span class="mejs-currenttime">' + (b.options.alwaysShowHours ? "00:" : "") + (b.options.showTimecodeFrameCount ? "00:00:00" : "00:00") + "</span></div>").appendTo(c), f.currenttime = f.controls.find(".mejs-currenttime"), e.addEventListener("timeupdate", function () {
				b.updateCurrent()
			}, !1)
		},
		buildduration: function (b, c, d, e) {
			var f = this;
			c.children().last().find(".mejs-currenttime").length > 0 ? a(f.options.timeAndDurationSeparator + '<span class="mejs-duration">' + (f.options.duration > 0 ? mejs.Utility.secondsToTimeCode(f.options.duration, f.options.alwaysShowHours || f.media.duration > 3600, f.options.showTimecodeFrameCount, f.options.framesPerSecond || 25) : (b.options.alwaysShowHours ? "00:" : "") + (b.options.showTimecodeFrameCount ? "00:00:00" : "00:00")) + "</span>").appendTo(c.find(".mejs-time")) : (c.find(".mejs-currenttime").parent().addClass("mejs-currenttime-container"), a('<div class="mejs-time mejs-duration-container"><span class="mejs-duration">' + (f.options.duration > 0 ? mejs.Utility.secondsToTimeCode(f.options.duration, f.options.alwaysShowHours || f.media.duration > 3600, f.options.showTimecodeFrameCount, f.options.framesPerSecond || 25) : (b.options.alwaysShowHours ? "00:" : "") + (b.options.showTimecodeFrameCount ? "00:00:00" : "00:00")) + "</span></div>").appendTo(c)), f.durationD = f.controls.find(".mejs-duration"), e.addEventListener("timeupdate", function () {
				b.updateDuration()
			}, !1)
		},
		updateCurrent: function () {
			var a = this;
			a.currenttime && a.currenttime.html(mejs.Utility.secondsToTimeCode(a.media.currentTime, a.options.alwaysShowHours || a.media.duration > 3600, a.options.showTimecodeFrameCount, a.options.framesPerSecond || 25))
		},
		updateDuration: function () {
			var a = this;
			a.container.toggleClass("mejs-long-video", a.media.duration > 3600), a.durationD && (a.options.duration > 0 || a.media.duration) && a.durationD.html(mejs.Utility.secondsToTimeCode(a.options.duration > 0 ? a.options.duration : a.media.duration, a.options.alwaysShowHours, a.options.showTimecodeFrameCount, a.options.framesPerSecond || 25))
		}
	})
}(mejs.$), function (a) {
	a.extend(mejs.MepDefaults, {
		muteText: mejs.i18n.t("Mute Toggle"),
		hideVolumeOnTouchDevices: !0,
		audioVolume: "horizontal",
		videoVolume: "vertical"
	}), a.extend(MediaElementPlayer.prototype, {
		buildvolume: function (b, c, d, e) {
			if (!mejs.MediaFeatures.hasTouch || !this.options.hideVolumeOnTouchDevices) {
				var f = this,
					g = f.isVideo ? f.options.videoVolume : f.options.audioVolume,
					h = "horizontal" == g ? a('<div class="mejs-button mejs-volume-button mejs-mute"><button type="button" aria-controls="' + f.id + '" title="' + f.options.muteText + '" aria-label="' + f.options.muteText + '"></button></div><div class="mejs-horizontal-volume-slider"><div class="mejs-horizontal-volume-total"></div><div class="mejs-horizontal-volume-current"></div><div class="mejs-horizontal-volume-handle"></div></div>').appendTo(c) : a('<div class="mejs-button mejs-volume-button mejs-mute"><button type="button" aria-controls="' + f.id + '" title="' + f.options.muteText + '" aria-label="' + f.options.muteText + '"></button><div class="mejs-volume-slider"><div class="mejs-volume-total"></div><div class="mejs-volume-current"></div><div class="mejs-volume-handle"></div></div></div>').appendTo(c),
					i = f.container.find(".mejs-volume-slider, .mejs-horizontal-volume-slider"),
					j = f.container.find(".mejs-volume-total, .mejs-horizontal-volume-total"),
					k = f.container.find(".mejs-volume-current, .mejs-horizontal-volume-current"),
					l = f.container.find(".mejs-volume-handle, .mejs-horizontal-volume-handle"),
					m = function (a, b) {
						if (!i.is(":visible") && "undefined" == typeof b) return i.show(), m(a, !0), void i.hide();
						if (a = Math.max(0, a), a = Math.min(a, 1), 0 == a ? h.removeClass("mejs-mute").addClass("mejs-unmute") : h.removeClass("mejs-unmute").addClass("mejs-mute"), "vertical" == g) {
							var c = j.height(),
								d = j.position(),
								e = c - c * a;
							l.css("top", Math.round(d.top + e - l.height() / 2)), k.height(c - e), k.css("top", d.top + e)
						} else {
							var f = j.width(),
								d = j.position(),
								n = f * a;
							l.css("left", Math.round(d.left + n - l.width() / 2)), k.width(Math.round(n))
						}
					},
					n = function (a) {
						var b = null,
							c = j.offset();
						if ("vertical" == g) {
							var d = j.height(),
								f = (parseInt(j.css("top").replace(/px/, ""), 10), a.pageY - c.top);
							if (b = (d - f) / d, 0 == c.top || 0 == c.left) return
						} else {
							var h = j.width(),
								i = a.pageX - c.left;
							b = i / h
						}
						b = Math.max(0, b), b = Math.min(b, 1), m(b), e.setMuted(0 == b ? !0 : !1), e.setVolume(b)
					},
					o = !1,
					p = !1;
				h.hover(function () {
					i.show(), p = !0
				}, function () {
					p = !1, o || "vertical" != g || i.hide()
				}), i.bind("mouseover", function () {
					p = !0
				}).bind("mousedown", function (a) {
					return n(a), f.globalBind("mousemove.vol", function (a) {
						n(a)
					}), f.globalBind("mouseup.vol", function () {
						o = !1, f.globalUnbind(".vol"), p || "vertical" != g || i.hide()
					}), o = !0, !1
				}), h.find("button").click(function () {
					e.setMuted(!e.muted)
				}), e.addEventListener("volumechange", function () {
					o || (e.muted ? (m(0), h.removeClass("mejs-mute").addClass("mejs-unmute")) : (m(e.volume), h.removeClass("mejs-unmute").addClass("mejs-mute")))
				}, !1), f.container.is(":visible") && (m(b.options.startVolume), 0 === b.options.startVolume && e.setMuted(!0), "native" === e.pluginType && e.setVolume(b.options.startVolume))
			}
		}
	})
}(mejs.$), function (a) {
	a.extend(mejs.MepDefaults, {
		usePluginFullScreen: !0,
		newWindowCallback: function () {
			return ""
		},
		fullscreenText: mejs.i18n.t("Fullscreen")
	}), a.extend(MediaElementPlayer.prototype, {
		isFullScreen: !1,
		isNativeFullScreen: !1,
		isInIframe: !1,
		buildfullscreen: function (b, c, d, e) {
			if (b.isVideo) {
				if (b.isInIframe = window.location != window.parent.location, mejs.MediaFeatures.hasTrueNativeFullScreen) {
					var f = function () {
						b.isFullScreen && (mejs.MediaFeatures.isFullScreen() ? (b.isNativeFullScreen = !0, b.setControlsSize()) : (b.isNativeFullScreen = !1, b.exitFullScreen()))
					};
					mejs.MediaFeatures.hasMozNativeFullScreen ? b.globalBind(mejs.MediaFeatures.fullScreenEventName, f) : b.container.bind(mejs.MediaFeatures.fullScreenEventName, f)
				}
				var g = this,
					h = (b.container, a('<div class="mejs-button mejs-fullscreen-button"><button type="button" aria-controls="' + g.id + '" title="' + g.options.fullscreenText + '" aria-label="' + g.options.fullscreenText + '"></button></div>').appendTo(c));
				if ("native" === g.media.pluginType || !g.options.usePluginFullScreen && !mejs.MediaFeatures.isFirefox) h.click(function () {
					var a = mejs.MediaFeatures.hasTrueNativeFullScreen && mejs.MediaFeatures.isFullScreen() || b.isFullScreen;
					a ? b.exitFullScreen() : b.enterFullScreen()
				});
				else {
					var i = null,
						j = function () {
							var a, b = document.createElement("x"),
								c = document.documentElement,
								d = window.getComputedStyle;
							return "pointerEvents" in b.style ? (b.style.pointerEvents = "auto", b.style.pointerEvents = "x", c.appendChild(b), a = d && "auto" === d(b, "").pointerEvents, c.removeChild(b), !! a) : !1
						}();
					if (j && !mejs.MediaFeatures.isOpera) {
						var k, l, m = !1,
							n = function () {
								if (m) {
									for (var a in o) o[a].hide();
									h.css("pointer-events", ""), g.controls.css("pointer-events", ""), g.media.removeEventListener("click", g.clickToPlayPauseCallback), m = !1
								}
							},
							o = {},
							p = ["top", "left", "right", "bottom"],
							q = function () {
								var a = h.offset().left - g.container.offset().left,
									b = h.offset().top - g.container.offset().top,
									c = h.outerWidth(!0),
									d = h.outerHeight(!0),
									e = g.container.width(),
									f = g.container.height();
								for (k in o) o[k].css({
									position: "absolute",
									top: 0,
									left: 0
								});
								o.top.width(e).height(b), o.left.width(a).height(d).css({
									top: b
								}), o.right.width(e - a - c).height(d).css({
									top: b,
									left: a + c
								}), o.bottom.width(e).height(f - d - b).css({
									top: b + d
								})
							};
						for (g.globalBind("resize", function () {
							q()
						}), k = 0, l = p.length; l > k; k++) o[p[k]] = a('<div class="mejs-fullscreen-hover" />').appendTo(g.container).mouseover(n).hide();
						h.on("mouseover", function () {
							if (!g.isFullScreen) {
								var a = h.offset(),
									c = b.container.offset();
								e.positionFullscreenButton(a.left - c.left, a.top - c.top, !1), h.css("pointer-events", "none"), g.controls.css("pointer-events", "none"), g.media.addEventListener("click", g.clickToPlayPauseCallback);
								for (k in o) o[k].show();
								q(), m = !0
							}
						}), e.addEventListener("fullscreenchange", function () {
							g.isFullScreen = !g.isFullScreen, g.isFullScreen ? g.media.removeEventListener("click", g.clickToPlayPauseCallback) : g.media.addEventListener("click", g.clickToPlayPauseCallback), n()
						}), g.globalBind("mousemove", function (a) {
							if (m) {
								var b = h.offset();
								(a.pageY < b.top || a.pageY > b.top + h.outerHeight(!0) || a.pageX < b.left || a.pageX > b.left + h.outerWidth(!0)) && (h.css("pointer-events", ""), g.controls.css("pointer-events", ""), m = !1)
							}
						})
					} else h.on("mouseover", function () {
						null !== i && (clearTimeout(i), delete i);
						var a = h.offset(),
							c = b.container.offset();
						e.positionFullscreenButton(a.left - c.left, a.top - c.top, !0)
					}).on("mouseout", function () {
						null !== i && (clearTimeout(i), delete i), i = setTimeout(function () {
							e.hideFullscreenButton()
						}, 1500)
					})
				}
				b.fullscreenBtn = h, g.globalBind("keydown", function (a) {
					(mejs.MediaFeatures.hasTrueNativeFullScreen && mejs.MediaFeatures.isFullScreen() || g.isFullScreen) && 27 == a.keyCode && b.exitFullScreen()
				})
			}
		},
		cleanfullscreen: function (a) {
			a.exitFullScreen()
		},
		containerSizeTimeout: null,
		enterFullScreen: function () {
			var b = this;
			if ("native" === b.media.pluginType || !mejs.MediaFeatures.isFirefox && !b.options.usePluginFullScreen) {
				if (a(document.documentElement).addClass("mejs-fullscreen"), normalHeight = b.container.height(), normalWidth = b.container.width(), "native" === b.media.pluginType) if (mejs.MediaFeatures.hasTrueNativeFullScreen) mejs.MediaFeatures.requestFullScreen(b.container[0]), b.isInIframe && setTimeout(function d() {
					b.isNativeFullScreen && (a(window).width() !== screen.width ? b.exitFullScreen() : setTimeout(d, 500))
				}, 500);
				else if (mejs.MediaFeatures.hasSemiNativeFullScreen) return void b.media.webkitEnterFullscreen();
				if (b.isInIframe) {
					var c = b.options.newWindowCallback(this);
					if ("" !== c) {
						if (!mejs.MediaFeatures.hasTrueNativeFullScreen) return b.pause(), void window.open(c, b.id, "top=0,left=0,width=" + screen.availWidth + ",height=" + screen.availHeight + ",resizable=yes,scrollbars=no,status=no,toolbar=no");
						setTimeout(function () {
							b.isNativeFullScreen || (b.pause(), window.open(c, b.id, "top=0,left=0,width=" + screen.availWidth + ",height=" + screen.availHeight + ",resizable=yes,scrollbars=no,status=no,toolbar=no"))
						}, 250)
					}
				}
				b.container.addClass("mejs-container-fullscreen").width("100%").height("100%"), b.containerSizeTimeout = setTimeout(function () {
					b.container.css({
						width: "100%",
						height: "100%"
					}), b.setControlsSize()
				}, 500), "native" === b.media.pluginType ? b.$media.width("100%").height("100%") : (b.container.find(".mejs-shim").width("100%").height("100%"), b.media.setVideoSize(a(window).width(), a(window).height())), b.layers.children("div").width("100%").height("100%"), b.fullscreenBtn && b.fullscreenBtn.removeClass("mejs-fullscreen").addClass("mejs-unfullscreen"), b.setControlsSize(), b.isFullScreen = !0, a(window).trigger("resize")
			}
		},
		exitFullScreen: function () {
			var b = this;
			return clearTimeout(b.containerSizeTimeout), "native" !== b.media.pluginType && mejs.MediaFeatures.isFirefox ? void b.media.setFullscreen(!1) : (mejs.MediaFeatures.hasTrueNativeFullScreen && (mejs.MediaFeatures.isFullScreen() || b.isFullScreen) && mejs.MediaFeatures.cancelFullScreen(), a(document.documentElement).removeClass("mejs-fullscreen"), b.container.removeClass("mejs-container-fullscreen").width(normalWidth).height(normalHeight), "native" === b.media.pluginType ? b.$media.width(normalWidth).height(normalHeight) : (b.container.find(".mejs-shim").width(normalWidth).height(normalHeight), b.media.setVideoSize(normalWidth, normalHeight)), b.layers.children("div").width(normalWidth).height(normalHeight), b.fullscreenBtn.removeClass("mejs-unfullscreen").addClass("mejs-fullscreen"), b.setControlsSize(), b.isFullScreen = !1, void a(window).trigger("resize"))
		}
	})
}(mejs.$), function (a) {
	a.extend(mejs.MepDefaults, {
		startLanguage: "",
		tracksText: mejs.i18n.t("Captions/Subtitles"),
		hideCaptionsButtonWhenEmpty: !0,
		toggleCaptionsButtonWhenOnlyOne: !1,
		slidesSelector: ""
	}), a.extend(MediaElementPlayer.prototype, {
		hasChapters: !1,
		buildtracks: function (b, c, d, e) {
			if (0 != b.tracks.length) {
				var f, g = this;
				if (g.domNode.textTracks) for (var f = g.domNode.textTracks.length - 1; f >= 0; f--) g.domNode.textTracks[f].mode = "hidden";
				b.chapters = a('<div class="mejs-chapters mejs-layer"></div>').prependTo(d).hide(), b.captions = a('<div class="mejs-captions-layer mejs-layer"><div class="mejs-captions-position mejs-captions-position-hover"><span class="mejs-captions-text"></span></div></div>').prependTo(d).hide(), b.captionsText = b.captions.find(".mejs-captions-text"), b.captionsButton = a('<div class="mejs-button mejs-captions-button"><button type="button" aria-controls="' + g.id + '" title="' + g.options.tracksText + '" aria-label="' + g.options.tracksText + '"></button><div class="mejs-captions-selector"><ul><li><input type="radio" name="' + b.id + '_captions" id="' + b.id + '_captions_none" value="none" checked="checked" /><label for="' + b.id + '_captions_none">' + mejs.i18n.t("None") + "</label></li></ul></div></div>").appendTo(c);
				var h = 0;
				for (f = 0; f < b.tracks.length; f++)"subtitles" == b.tracks[f].kind && h++;
				for (g.options.toggleCaptionsButtonWhenOnlyOne && 1 == h ? b.captionsButton.on("click", function () {
					if (null == b.selectedTrack) var a = b.tracks[0].srclang;
					else var a = "none";
					b.setTrack(a)
				}) : b.captionsButton.hover(function () {
					a(this).find(".mejs-captions-selector").css("visibility", "visible")
				}, function () {
					a(this).find(".mejs-captions-selector").css("visibility", "hidden")
				}).on("click", "input[type=radio]", function () {
					lang = this.value, b.setTrack(lang)
				}), b.options.alwaysShowControls ? b.container.find(".mejs-captions-position").addClass("mejs-captions-position-hover") : b.container.bind("controlsshown", function () {
					b.container.find(".mejs-captions-position").addClass("mejs-captions-position-hover")
				}).bind("controlshidden", function () {
					e.paused || b.container.find(".mejs-captions-position").removeClass("mejs-captions-position-hover")
				}), b.trackToLoad = -1, b.selectedTrack = null, b.isLoadingTrack = !1, f = 0; f < b.tracks.length; f++)"subtitles" == b.tracks[f].kind && b.addTrackButton(b.tracks[f].srclang, b.tracks[f].label);
				b.loadNextTrack(), e.addEventListener("timeupdate", function () {
					b.displayCaptions()
				}, !1), "" != b.options.slidesSelector && (b.slidesContainer = a(b.options.slidesSelector), e.addEventListener("timeupdate", function () {
					b.displaySlides()
				}, !1)), e.addEventListener("loadedmetadata", function () {
					b.displayChapters()
				}, !1), b.container.hover(function () {
					b.hasChapters && (b.chapters.css("visibility", "visible"), b.chapters.fadeIn(200).height(b.chapters.find(".mejs-chapter").outerHeight()))
				}, function () {
					b.hasChapters && !e.paused && b.chapters.fadeOut(200, function () {
						a(this).css("visibility", "hidden"), a(this).css("display", "block")
					})
				}), null !== b.node.getAttribute("autoplay") && b.chapters.css("visibility", "hidden")
			}
		},
		setTrack: function (a) {
			var b, c = this;
			if ("none" == a) c.selectedTrack = null, c.captionsButton.removeClass("mejs-captions-enabled");
			else for (b = 0; b < c.tracks.length; b++) if (c.tracks[b].srclang == a) {
				null == c.selectedTrack && c.captionsButton.addClass("mejs-captions-enabled"), c.selectedTrack = c.tracks[b], c.captions.attr("lang", c.selectedTrack.srclang), c.displayCaptions();
				break
			}
		},
		loadNextTrack: function () {
			var a = this;
			a.trackToLoad++, a.trackToLoad < a.tracks.length ? (a.isLoadingTrack = !0, a.loadTrack(a.trackToLoad)) : (a.isLoadingTrack = !1, a.checkForTracks())
		},
		loadTrack: function (b) {
			var c = this,
				d = c.tracks[b],
				e = function () {
					d.isLoaded = !0, c.enableTrackButton(d.srclang, d.label), c.loadNextTrack()
				};
			a.ajax({
				url: d.src,
				dataType: "text",
				success: function (a) {
					d.entries = "string" == typeof a && /<tt\s+xml/gi.exec(a) ? mejs.TrackFormatParser.dfxp.parse(a) : mejs.TrackFormatParser.webvvt.parse(a), e(), "chapters" == d.kind && c.media.addEventListener("play", function () {
						c.media.duration > 0 && c.displayChapters(d)
					}, !1), "slides" == d.kind && c.setupSlides(d)
				},
				error: function () {
					c.loadNextTrack()
				}
			})
		},
		enableTrackButton: function (b, c) {
			var d = this;
			"" === c && (c = mejs.language.codes[b] || b), d.captionsButton.find("input[value=" + b + "]").prop("disabled", !1).siblings("label").html(c), d.options.startLanguage == b && a("#" + d.id + "_captions_" + b).click(), d.adjustLanguageBox()
		},
		addTrackButton: function (b, c) {
			var d = this;
			"" === c && (c = mejs.language.codes[b] || b), d.captionsButton.find("ul").append(a('<li><input type="radio" name="' + d.id + '_captions" id="' + d.id + "_captions_" + b + '" value="' + b + '" disabled="disabled" /><label for="' + d.id + "_captions_" + b + '">' + c + " (loading)</label></li>")), d.adjustLanguageBox(), d.container.find(".mejs-captions-translations option[value=" + b + "]").remove()
		},
		adjustLanguageBox: function () {
			var a = this;
			a.captionsButton.find(".mejs-captions-selector").height(a.captionsButton.find(".mejs-captions-selector ul").outerHeight(!0) + a.captionsButton.find(".mejs-captions-translations").outerHeight(!0))
		},
		checkForTracks: function () {
			var a = this,
				b = !1;
			if (a.options.hideCaptionsButtonWhenEmpty) {
				for (i = 0; i < a.tracks.length; i++) if ("subtitles" == a.tracks[i].kind) {
					b = !0;
					break
				}
				b || (a.captionsButton.hide(), a.setControlsSize())
			}
		},
		displayCaptions: function () {
			if ("undefined" != typeof this.tracks) {
				var a, b = this,
					c = b.selectedTrack;
				if (null != c && c.isLoaded) {
					for (a = 0; a < c.entries.times.length; a++) if (b.media.currentTime >= c.entries.times[a].start && b.media.currentTime <= c.entries.times[a].stop) return b.captionsText.html(c.entries.text[a]), void b.captions.show().height(0);
					b.captions.hide()
				} else b.captions.hide()
			}
		},
		setupSlides: function (a) {
			var b = this;
			b.slides = a, b.slides.entries.imgs = [b.slides.entries.text.length], b.showSlide(0)
		},
		showSlide: function (b) {
			if ("undefined" != typeof this.tracks && "undefined" != typeof this.slidesContainer) {
				var c = this,
					d = c.slides.entries.text[b],
					e = c.slides.entries.imgs[b];
				"undefined" == typeof e || "undefined" == typeof e.fadeIn ? c.slides.entries.imgs[b] = e = a('<img src="' + d + '">').on("load", function () {
					e.appendTo(c.slidesContainer).hide().fadeIn().siblings(":visible").fadeOut()
				}) : e.is(":visible") || e.is(":animated") || e.fadeIn().siblings(":visible").fadeOut()
			}
		},
		displaySlides: function () {
			if ("undefined" != typeof this.slides) {
				var a, b = this,
					c = b.slides;
				for (a = 0; a < c.entries.times.length; a++) if (b.media.currentTime >= c.entries.times[a].start && b.media.currentTime <= c.entries.times[a].stop) return void b.showSlide(a)
			}
		},
		displayChapters: function () {
			var a, b = this;
			for (a = 0; a < b.tracks.length; a++) if ("chapters" == b.tracks[a].kind && b.tracks[a].isLoaded) {
				b.drawChapters(b.tracks[a]), b.hasChapters = !0;
				break
			}
		},
		drawChapters: function (b) {
			var c, d, e = this,
				f = 0,
				g = 0;
			for (e.chapters.empty(), c = 0; c < b.entries.times.length; c++) d = b.entries.times[c].stop - b.entries.times[c].start, f = Math.floor(d / e.media.duration * 100), (f + g > 100 || c == b.entries.times.length - 1 && 100 > f + g) && (f = 100 - g), e.chapters.append(a('<div class="mejs-chapter" rel="' + b.entries.times[c].start + '" style="left: ' + g.toString() + "%;width: " + f.toString() + '%;"><div class="mejs-chapter-block' + (c == b.entries.times.length - 1 ? " mejs-chapter-block-last" : "") + '"><span class="ch-title">' + b.entries.text[c] + '</span><span class="ch-time">' + mejs.Utility.secondsToTimeCode(b.entries.times[c].start) + "&ndash;" + mejs.Utility.secondsToTimeCode(b.entries.times[c].stop) + "</span></div></div>")), g += f;
			e.chapters.find("div.mejs-chapter").click(function () {
				e.media.setCurrentTime(parseFloat(a(this).attr("rel"))), e.media.paused && e.media.play()
			}), e.chapters.show()
		}
	}), mejs.language = {
		codes: {
			af: "Afrikaans",
			sq: "Albanian",
			ar: "Arabic",
			be: "Belarusian",
			bg: "Bulgarian",
			ca: "Catalan",
			zh: "Chinese",
			"zh-cn": "Chinese Simplified",
			"zh-tw": "Chinese Traditional",
			hr: "Croatian",
			cs: "Czech",
			da: "Danish",
			nl: "Dutch",
			en: "English",
			et: "Estonian",
			tl: "Filipino",
			fi: "Finnish",
			fr: "French",
			gl: "Galician",
			de: "German",
			el: "Greek",
			ht: "Haitian Creole",
			iw: "Hebrew",
			hi: "Hindi",
			hu: "Hungarian",
			is: "Icelandic",
			id: "Indonesian",
			ga: "Irish",
			it: "Italian",
			ja: "Japanese",
			ko: "Korean",
			lv: "Latvian",
			lt: "Lithuanian",
			mk: "Macedonian",
			ms: "Malay",
			mt: "Maltese",
			no: "Norwegian",
			fa: "Persian",
			pl: "Polish",
			pt: "Portuguese",
			ro: "Romanian",
			ru: "Russian",
			sr: "Serbian",
			sk: "Slovak",
			sl: "Slovenian",
			es: "Spanish",
			sw: "Swahili",
			sv: "Swedish",
			tl: "Tagalog",
			th: "Thai",
			tr: "Turkish",
			uk: "Ukrainian",
			vi: "Vietnamese",
			cy: "Welsh",
			yi: "Yiddish"
		}
	}, mejs.TrackFormatParser = {
		webvvt: {
			pattern_identifier: /^([a-zA-z]+-)?[0-9]+$/,
			pattern_timecode: /^([0-9]{2}:[0-9]{2}:[0-9]{2}([,.][0-9]{1,3})?) --\> ([0-9]{2}:[0-9]{2}:[0-9]{2}([,.][0-9]{3})?)(.*)$/,
			parse: function (b) {
				for (var c, d, e = 0, f = mejs.TrackFormatParser.split2(b, /\r?\n/), g = {
					text: [],
					times: []
				}; e < f.length; e++) if (this.pattern_identifier.exec(f[e]) && (e++, c = this.pattern_timecode.exec(f[e]), c && e < f.length)) {
					for (e++, d = f[e], e++;
					"" !== f[e] && e < f.length;) d = d + "\n" + f[e], e++;
					d = a.trim(d).replace(/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gi, "<a href='$1' target='_blank'>$1</a>"), g.text.push(d), g.times.push({
						start: 0 == mejs.Utility.convertSMPTEtoSeconds(c[1]) ? .2 : mejs.Utility.convertSMPTEtoSeconds(c[1]),
						stop: mejs.Utility.convertSMPTEtoSeconds(c[3]),
						settings: c[5]
					})
				}
				return g
			}
		},
		dfxp: {
			parse: function (b) {
				b = a(b).filter("tt");
				var c, d, e = 0,
					f = b.children("div").eq(0),
					g = f.find("p"),
					h = b.find("#" + f.attr("style")),
					i = {
						text: [],
						times: []
					};
				if (h.length) {
					var j = h.removeAttr("id").get(0).attributes;
					if (j.length) for (c = {}, e = 0; e < j.length; e++) c[j[e].name.split(":")[1]] = j[e].value
				}
				for (e = 0; e < g.length; e++) {
					var k, l = {
						start: null,
						stop: null,
						style: null
					};
					if (g.eq(e).attr("begin") && (l.start = mejs.Utility.convertSMPTEtoSeconds(g.eq(e).attr("begin"))), !l.start && g.eq(e - 1).attr("end") && (l.start = mejs.Utility.convertSMPTEtoSeconds(g.eq(e - 1).attr("end"))), g.eq(e).attr("end") && (l.stop = mejs.Utility.convertSMPTEtoSeconds(g.eq(e).attr("end"))), !l.stop && g.eq(e + 1).attr("begin") && (l.stop = mejs.Utility.convertSMPTEtoSeconds(g.eq(e + 1).attr("begin"))), c) {
						k = "";
						for (var m in c) k += m + ":" + c[m] + ";"
					}
					k && (l.style = k), 0 == l.start && (l.start = .2), i.times.push(l), d = a.trim(g.eq(e).html()).replace(/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gi, "<a href='$1' target='_blank'>$1</a>"), i.text.push(d), 0 == i.times.start && (i.times.start = 2)
				}
				return i
			}
		},
		split2: function (a, b) {
			return a.split(b)
		}
	}, 3 != "x\n\ny".split(/\n/gi).length && (mejs.TrackFormatParser.split2 = function (a, b) {
		var c, d = [],
			e = "";
		for (c = 0; c < a.length; c++) e += a.substring(c, c + 1), b.test(e) && (d.push(e.replace(b, "")), e = "");
		return d.push(e), d
	})
}(mejs.$), function (a) {
	a.extend(mejs.MepDefaults, {
		contextMenuItems: [{
			render: function (a) {
				return "undefined" == typeof a.enterFullScreen ? null : mejs.i18n.t(a.isFullScreen ? "Turn off Fullscreen" : "Go Fullscreen")
			},
			click: function (a) {
				a.isFullScreen ? a.exitFullScreen() : a.enterFullScreen()
			}
		},
		{
			render: function (a) {
				return mejs.i18n.t(a.media.muted ? "Unmute" : "Mute")
			},
			click: function (a) {
				a.setMuted(a.media.muted ? !1 : !0)
			}
		},
		{
			isSeparator: !0
		},
		{
			render: function () {
				return mejs.i18n.t("Download Video")
			},
			click: function (a) {
				window.location.href = a.media.currentSrc
			}
		}]
	}), a.extend(MediaElementPlayer.prototype, {
		buildcontextmenu: function (b) {
			b.contextMenu = a('<div class="mejs-contextmenu"></div>').appendTo(a("body")).hide(), b.container.bind("contextmenu", function (a) {
				return b.isContextMenuEnabled ? (a.preventDefault(), b.renderContextMenu(a.clientX - 1, a.clientY - 1), !1) : void 0
			}), b.container.bind("click", function () {
				b.contextMenu.hide()
			}), b.contextMenu.bind("mouseleave", function () {
				b.startContextMenuTimer()
			})
		},
		cleancontextmenu: function (a) {
			a.contextMenu.remove()
		},
		isContextMenuEnabled: !0,
		enableContextMenu: function () {
			this.isContextMenuEnabled = !0
		},
		disableContextMenu: function () {
			this.isContextMenuEnabled = !1
		},
		contextMenuTimeout: null,
		startContextMenuTimer: function () {
			var a = this;
			a.killContextMenuTimer(), a.contextMenuTimer = setTimeout(function () {
				a.hideContextMenu(), a.killContextMenuTimer()
			}, 750)
		},
		killContextMenuTimer: function () {
			var a = this.contextMenuTimer;
			null != a && (clearTimeout(a), delete a, a = null)
		},
		hideContextMenu: function () {
			this.contextMenu.hide()
		},
		renderContextMenu: function (b, c) {
			for (var d = this, e = "", f = d.options.contextMenuItems, g = 0, h = f.length; h > g; g++) if (f[g].isSeparator) e += '<div class="mejs-contextmenu-separator"></div>';
			else {
				var i = f[g].render(d);
				null != i && (e += '<div class="mejs-contextmenu-item" data-itemindex="' + g + '" id="element-' + 1e6 * Math.random() + '">' + i + "</div>")
			}
			d.contextMenu.empty().append(a(e)).css({
				top: c,
				left: b
			}).show(), d.contextMenu.find(".mejs-contextmenu-item").each(function () {
				var b = a(this),
					c = parseInt(b.data("itemindex"), 10),
					e = d.options.contextMenuItems[c];
				"undefined" != typeof e.show && e.show(b, d), b.click(function () {
					"undefined" != typeof e.click && e.click(d), d.contextMenu.hide()
				})
			}), setTimeout(function () {
				d.killControlsTimer("rev3")
			}, 100)
		}
	})
}(mejs.$), function (a) {
	a.extend(mejs.MepDefaults, {
		postrollCloseText: mejs.i18n.t("Close")
	}), a.extend(MediaElementPlayer.prototype, {
		buildpostroll: function (b, c, d) {
			var e = this,
				f = e.container.find('link[rel="postroll"]').attr("href");
			"undefined" != typeof f && (b.postroll = a('<div class="mejs-postroll-layer mejs-layer"><a class="mejs-postroll-close" onclick="$(this).parent().hide();return false;">' + e.options.postrollCloseText + '</a><div class="mejs-postroll-layer-content"></div></div>').prependTo(d).hide(), e.media.addEventListener("ended", function () {
				a.ajax({
					dataType: "html",
					url: f,
					success: function (a) {
						d.find(".mejs-postroll-layer-content").html(a)
					}
				}), b.postroll.show()
			}, !1))
		}
	})
}(mejs.$), function (a) {
	a.fn.toggleWrapper = function (b, c) {
		if (b) {
			this.css("position", "relative");
			var d = a("<div>");
			d.attr("data-wrapper", !0).css({
				display: "none",
				position: "absolute",
				top: "0",
				left: "0",
				"z-index": "4",
				"background-color": c ? c : "white",
				width: "100%",
				height: "100%",
				opacity: "0.4"
			}).fadeIn(250), this.append(d)
		} else {
			var e = this,
				f = this.find("[data-wrapper]");
			f.delay(250).fadeOut(250, function () {
				e.removeAttr("style"), f.remove()
			})
		}
	}
}(jQuery, window, document);
