define("zenjs/swp/utils", ["require"],
function(t) {
	function e() {
		this.__events = {}
	}
	var i = $.extend;
	e.prototype = {
		on: function(t, e) {
			return this.__events[t] || (this.__events[t] = []),
			this.__events[t].push(e),
			this
		},
		emit: function(t) {
			var e = this.__events[t],
			i = Array.prototype.slice.call(arguments, 1),
			n = this;
			e && e.forEach(function(t) {
				t.apply(n, i)
			})
		},
		removeListener: function(t, e) {
			if (void 0 != this.__events[t]) {
				var i;
				e ? (i = this.__events[t].indexOf(e), i > 0 && this.__events[t].splice(i, 1)) : delete this.__events[t]
			}
		}
	};
	var n = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame ||
	function(t, e) {
		return window.setTimeout(t, 1e3 / 60)
	},
	s = window.cancelAnimationFrame || window.mozCancelAnimationFrame || window.webkitCancelAnimationFrame || window.msRequestAnimationFrame ||
	function(t) {
		clearTimeout(t)
	};
	return {
		extend: i,
		EventEmitter: e,
		requestAnimationFrame: n,
		cancelAnimationFrame: s
	}
}),
define("zenjs/swp/input", ["require", "./utils"],
function(t) {
	function e(t, e) {
		n.apply(this, arguments),
		this.isStarting = !1,
		this.startPt = null,
		this.endPt = null,
		this.isDeaf = !1,
		this.options = s({
			listenMoving: !1
		},
		e),
		this.host = $(t),
		this.onTouchStart = this.onTouchStart.bind(this),
		this.onTouchMove = this.onTouchMove.bind(this),
		this.onTouchEnd = this.onTouchEnd.bind(this),
		this.bind(this.host)
	}
	var i = t("./utils"),
	n = i.EventEmitter,
	s = i.extend;
	return e.prototype = Object.create(new n),
	s(e.prototype, {
		bind: function(t) {
			var e = $(window);
			t.on("touchstart mousedown", this.onTouchStart),
			this.options.listenMoving && e.on("touchmove mousemove", this.onTouchMove),
			e.on("touchend mouseup touchcancel", this.onTouchEnd)
		},
		onTouchStart: function(t) {
			this.isDeaf || this.isStarting || (this.isStarting = !0, this.orgDirection = null, this.startPt = this.pointerEventToXY(t))
		},
		onTouchMove: function(t) {
			this.isStarting && this.caculate(t)
		},
		onTouchEnd: function(t) {
			this.isStarting && (this.isStarting = !1, this.caculate(t, !0))
		},
		caculate: function(t, e) {
			var i, n;
			this.endPt = this.pointerEventToXY(t),
			i = this.startPt.y - this.endPt.y,
			n = this.startPt.x - this.endPt.x,
			0 != i && this.emit(i > 0 ? "up": "down", i, e, t),
			0 != n && this.emit(n > 0 ? "left": "right", n, e, t),
			null == this.orgDirection && (this.orgDirection = Math.abs(n) > Math.abs(i)),
			this.emit("move", {
				x: n,
				y: i
			},
			e, t, {
				orgDirection: this.orgDirection
			})
		},
		pointerEventToXY: function(t) {
			var e = {
				x: 0,
				y: 0
			},
			i = t.type;
			if (t.originalEvent && (t = t.originalEvent), "touchstart" == i || "touchmove" == i || "touchend" == i || "touchcancel" == i) {
				var n = t.touches[0] || t.changedTouches[0];
				e.x = n.pageX,
				e.y = n.pageY
			} else("mousedown" == i || "mouseup" == i || "mousemove" == i || "mouseover" == i || "mouseout" == i || "mouseenter" == i || "mouseleave" == i) && (e.x = t.pageX, e.y = t.pageY);
			return e
		},
		deaf: function() {
			this.isDeaf = !0
		},
		undeaf: function() {
			this.isDeaf = !1
		},
		destroy: function() {
			var t = $(window);
			this.host.off("touchstart mousedown", this.onTouchStart),
			this.options.listenMoving && t.off("touchmove mousemove", this.onTouchMove),
			t.off("touchend mouseup touchcancel", this.onTouchEnd)
		}
	}),
	e
}),
define("zenjs/swp/scroll", ["require", "./utils"],
function(t) {
	function e(t, e) {
		n.apply(this, arguments),
		this.wrapElem = t,
		this.wrapSize = {
			width: t.width(),
			height: t.height()
		},
		this.options = s({
			loop: !0,
			autoPlay: !1,
			startIndex: 0
		},
		e),
		this.init.apply(this, arguments)
	}
	var i = t("./utils"),
	n = i.EventEmitter,
	s = i.extend;
	return e.prototype = Object.create(new n),
	s(e.prototype, {
		init: function() {
			var t;
			this.wrapElem;
			this.pages = this.wrapElem.find(".swp-page"),
			t = {
				position: "absolute",
				top: 0,
				left: 0,
				width: "100%",
				height: "100%",
				display: "block",
				"-webkit-transform": "translate3d(-9999px, 0, 0)"
			},
			this.pages.css(t),
			this.mCache = {
				dist: 0,
				offsetPage: 0
			},
			this.setCurrentPage(0),
			this.movePage(this.options.startIndex * this.wrapSize.width, !0)
		},
		getCurrentDist: function() {
			return this.mCache.currentDist
		},
		renderPage: function(t, e) {
			void 0 == t && (t = 0),
			void 0 == e && (e = 0);
			var i, n, s, o = this.wrapSize.width,
			a = e * o - t,
			r = a - o,
			h = a + o;
			i = this.getCurrentPage(),
			i.length && (i[0].style["-webkit-transform"] = "translate3d(" + a + "px, 0, 0)"),
			n = this.pages[this.mapLoopPage(e - 1)],
			n && (Math.abs(r) <= o ? n.style["-webkit-transform"] = "translate3d(" + r + "px, 0, 0)": this.pages.length > 2 && (n.style["-webkit-transform"] = "translate3d(-9999px, 0, 0)")),
			s = this.pages[this.mapLoopPage(e + 1)],
			s && (Math.abs(h) <= o ? s.style["-webkit-transform"] = "translate3d(" + h + "px, 0, 0)": this.pages.length > 2 && (s.style["-webkit-transform"] = "translate3d(-9999px, 0, 0)"))
		},
		movePage: function(t, e) {
			var i;
			this.mCache.currentDist = t + this.mCache.dist,
			e && (this.mCache.dist += t),
			i = Math.round(this.mCache.currentDist / this.wrapSize.width),
			i != this.mCache.offsetPage && (this.setCurrentPage(i), this.emit("pageChangeEnd", this.getCurrentPage(), this.currentIndex, this.mCache.offsetPage), this.mCache.offsetPage = i),
			this.renderPage(this.mCache.currentDist, i)
		},
		getCurrentPage: function() {
			return this.pages.eq(this.currentIndex)
		},
		mapLoopPage: function(t) {
			if (this.options.loop) {
				var e = 0 > t ? -1 : 1,
				i = this.pages.length;
				return Math.abs(i + e * Math.abs(t) % i) % i
			}
			return t >= this.pages.length || 0 > t ? this.pages.length: t
		},
		setCurrentPage: function(t) {
			this.currentIndex = this.mapLoopPage(t)
		}
	}),
	e
}),
define("zenjs/swp/spring_dummy", ["require", "./utils"],
function(t) {
	function e(t, e, s) {
		var o = t.wrapElem,
		a = this;
		n.apply(this, arguments),
		this.scroll = t,
		this.input = e,
		this.input.on("move", this.movementReact.bind(this)),
		this.wrapSize = {
			width: o.width(),
			height: o.height()
		},
		this.options = i.extend({
			intervalTween: 3e3,
			threshold: 20
		},
		s),
		this.scroll.options.autoPlay && this.initMove(),
		this.on("bounceEnd",
		function() {
			a.scroll.options.autoPlay && a.initMove(),
			a.input.undeaf()
		}).on("bounceStart",
		function() {
			a.input.deaf()
		})
	}
	var i = t("./utils"),
	n = i.EventEmitter,
	s = i.requestAnimationFrame,
	o = i.cancelAnimationFrame,
	a = i.extend;
	return e.prototype = Object.create(new n),
	a(e.prototype, {
		clearTransition: function() {
			o(this.transitionReq)
		},
		movementReact: function(t, e, i, n) {
			e && this.launch(n.orgDirection ? t.x: 0),
			this.clearMove()
		},
		launch: function(t) {
			var e = this,
			i = t / Math.abs(t),
			n = 0,
			s = e.wrapSize.width,
			o = Math.round(t / s),
			a = this.scroll.mCache.offsetPage;
			n = s * o,
			0 == n && Math.abs(t) > e.options.threshold && (n = s * i),
			e.scroll.options.loop || (0 >= a && (n = Math.abs(t) > e.options.threshold && i > 0 ? s * i: s * (o - a)), 1 == this.scroll.pages.length ? n = 0 : a >= this.scroll.pages.length - 1 && (n = Math.abs(t) > e.options.threshold && 0 > i ? s * i: s * (o - a + this.scroll.pages.length - 1))),
			this.initTween(n - t, 150, "bounce")
		},
		initTween: function(t, e, i) {
			function n() {
				return o = new Date - r,
				o > e ? (a.emit(i, {
					x: t
				},
				!0), void a.emit(i + "End")) : (a.emit(i, {
					x: t / e * o
				},
				!1), void(a.tweenRid = s(n)))
			}
			if (0 != t) {
				var o, a = this,
				r = new Date;
				this.cancelTween(),
				this.emit(i + "Start"),
				n()
			}
		},
		cancelTween: function() {
			o(this.tweenRid)
		},
		initMove: function() {
			function t() {
				i.currentIndex != i.pages.length - 1 || i.options.loop ? e.initTween(e.wrapSize.width, 200, "autoPlay") : e.initTween( - e.wrapSize.width * (i.pages.length - 1), 200, "autoPlay"),
				e.moveTid = setTimeout(t, n)
			}
			var e = this,
			i = this.scroll,
			n = e.options.intervalTween;
			this.clearMove(),
			e.moveTid = setTimeout(t, n)
		},
		clearMove: function() {
			clearTimeout(this.moveTid)
		}
	}),
	e
}),
define("zenjs/swp/swp", ["require", "./input", "./utils", "./scroll", "./spring_dummy"],
function(t) {
	function e(t, e) {
		this.wrapElem = t,
		this.options = e || {}
	}
	var i = t("./input"),
	n = t("./utils"),
	s = t("./scroll"),
	o = n.EventEmitter,
	a = n.extend,
	r = t("./spring_dummy");
	return e.prototype = Object.create(new o),
	a(e.prototype, {
		init: function() {
			if (!this.wrapElem.data("swp-init")) {
				this.wrapElem.data("swp-init", !0);
				var t, e = this;
				$(window).on("dragstart",
				function(t) {
					$(e.wrapElem).has(t.target).length > 0 && t.preventDefault()
				}),
				this.input = new i(this.wrapElem, {
					listenMoving: !0
				}),
				t = this.scroll = new s(this.wrapElem, this.options),
				this.input.on("move",
				function(e, i, n, s) {
					s.orgDirection && (n.preventDefault(), t.movePage(e.x, i))
				}),
				this.dummy = new r(this.scroll, this.input, this.options),
				this.dummy.on("bounce",
				function(e, i) {
					t.movePage(e.x, i)
				}).on("autoPlay",
				function(e, i) {
					t.movePage(e.x, i)
				}),
				t.on("pageChangeEnd",
				function(t, e, i) {
					this.emit("pageChangeEnd", t, e, i)
				}.bind(this)),
				this.initThumbnail()
			}
		},
		initThumbnail: function() {
			var t = this.options.thumbnailWrap;
			if (void 0 != t && !(this.scroll.pages.length <= 1)) {
				t.empty();
				var e = $('<ul class="swp-thumbnail-list">');
				this.scroll.pages.each(function() {
					e.append('<li class="swiper-pagination-switch">')
				}),
				t.append(e),
				this.scroll.on("pageChangeEnd",
				function(t, i, n) {
					var s;
					e.children().each(function() {
						s = $(this),
						s.toggleClass("swiper-active-switch", s.index() == i)
					})
				}),
				e.children().eq(this.scroll.currentIndex).addClass("swiper-active-switch")
			}
		},
		destroy: function() {
			this.input.destroy()
		}
	}),
	e
}),
define("zenjs/swp/resource_loader", ["require", "../util/image"],
function(t) {
	function e(t) {
		this.wrap = t
	}
	var i = t("../util/image");
	return e.prototype = {
		start: function() {
			var t = new $.Deferred,
			e = this;
			return "complete" == document.readyState && t.resolve(),
			$(window).on("load",
			function i() {
				t.resolve(),
				$(window).unbind("load", i)
			}),
			t.promise().then(function() {
				return e.loadRes()
			})
		},
		loadRes: function() {
			var t = this,
			e = [];
			return this.wrap.find(".js-res-load").each(function(n) {
				var s = $(this),
				o = new $.Deferred,
				a = s.data("src");
				a && (t.loadImage(s, i.toWebp(a),
				function() {
					o.resolve()
				}), e.push(o.promise()))
			}),
			$.when.apply(window, e)
		},
		loadImage: function(t, e, i) {
			$("<img>").attr("src", e).on("load",
			function() {
				$(this).remove(),
				"img" == t.prop("tagName").toLowerCase() ? t.attr("src", e) : t.css("background-image", "url(" + e + ")"),
				i && i()
			}).on("error",
			function() {
				i && i()
			})
		}
	},
	e
}),
require(["zenjs/swp/swp", "zenjs/swp/resource_loader"],
function(t, e) {
	$(".js-swp").each(function() {
		var i = $(this),
		n = i.find(".js-swp-wrap"),
		s = new e(n),
		o = s.start();
		if (! (n.find(".swp-page").length <= 1)) {
			var a = new t(n, {
				loop: !0,
				autoPlay: !0,
				thumbnailWrap: i.find(".js-swiper-pagination")
			});
			o.then(function() {
				a.init()
			})
		}
	})
}),
define("main",
function() {});