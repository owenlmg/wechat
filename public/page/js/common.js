var Zepto = function() {
	function t(t) {
		return null == t ? String(t) : B[J.call(t)] || "object"
	}
	function e(e) {
		return "function" == t(e)
	}
	function n(t) {
		return null != t && t == t.window
	}
	function r(t) {
		return null != t && t.nodeType == t.DOCUMENT_NODE
	}
	function i(e) {
		return "object" == t(e)
	}
	function o(t) {
		return i(t) && !n(t) && Object.getPrototypeOf(t) == Object.prototype
	}
	function a(t) {
		return "number" == typeof t.length
	}
	function u(t) {
		return Z.call(t,
		function(t) {
			return null != t
		})
	}
	function s(t) {
		return t.length > 0 ? E.fn.concat.apply([], t) : t
	}
	function c(t) {
		return t.replace(/::/g, "/").replace(/([A-Z]+)([A-Z][a-z])/g, "$1_$2").replace(/([a-z\d])([A-Z])/g, "$1_$2").replace(/_/g, "-").toLowerCase()
	}
	function f(t) {
		return t in A ? A[t] : A[t] = new RegExp("(^|\\s)" + t + "(\\s|$)")
	}
	function l(t, e) {
		return "number" != typeof e || q[c(t)] ? e: e + "px"
	}
	function h(t) {
		var e, n;
		return k[t] || (e = P.createElement(t), P.body.appendChild(e), n = getComputedStyle(e, "").getPropertyValue("display"), e.parentNode.removeChild(e), "none" == n && (n = "block"), k[t] = n),
		k[t]
	}
	function p(t) {
		return "children" in t ? O.call(t.children) : E.map(t.childNodes,
		function(t) {
			return 1 == t.nodeType ? t: void 0
		})
	}
	function d(t, e, n) {
		for (j in e) n && (o(e[j]) || Y(e[j])) ? (o(e[j]) && !o(t[j]) && (t[j] = {}), Y(e[j]) && !Y(t[j]) && (t[j] = []), d(t[j], e[j], n)) : e[j] !== b && (t[j] = e[j])
	}
	function m(t, e) {
		return null == e ? E(t) : E(t).filter(e)
	}
	function v(t, n, r, i) {
		return e(n) ? n.call(t, r, i) : n
	}
	function g(t, e, n) {
		null == n ? t.removeAttribute(e) : t.setAttribute(e, n)
	}
	function y(t, e) {
		var n = t.className || "",
		r = n && n.baseVal !== b;
		return e === b ? r ? n.baseVal: n: void(r ? n.baseVal = e: t.className = e)
	}
	function w(t) {
		try {
			return t ? "true" == t || ("false" == t ? !1 : "null" == t ? null: +t + "" == t ? +t: /^[\[\{]/.test(t) ? E.parseJSON(t) : t) : t
		} catch(e) {
			return t
		}
	}
	function x(t, e) {
		e(t);
		for (var n = 0,
		r = t.childNodes.length; r > n; n++) x(t.childNodes[n], e)
	}
	var b, j, E, C, T, N, S = [],
	O = S.slice,
	Z = S.filter,
	P = window.document,
	k = {},
	A = {},
	q = {
		"column-count": 1,
		columns: 1,
		"font-weight": 1,
		"line-height": 1,
		opacity: 1,
		"z-index": 1,
		zoom: 1
	},
	_ = /^\s*<(\w+|!)[^>]*>/,
	D = /^<(\w+)\s*\/?>(?:<\/\1>|)$/,
	$ = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,
	L = /^(?:body|html)$/i,
	F = /([A-Z])/g,
	M = ["val", "css", "html", "text", "data", "width", "height", "offset"],
	z = ["after", "prepend", "before", "append"],
	R = P.createElement("table"),
	W = P.createElement("tr"),
	H = {
		tr: P.createElement("tbody"),
		tbody: R,
		thead: R,
		tfoot: R,
		td: W,
		th: W,
		"*": P.createElement("div")
	},
	V = /complete|loaded|interactive/,
	I = /^[\w-]*$/,
	B = {},
	J = B.toString,
	U = {},
	X = P.createElement("div"),
	Q = {
		tabindex: "tabIndex",
		readonly: "readOnly",
		"for": "htmlFor",
		"class": "className",
		maxlength: "maxLength",
		cellspacing: "cellSpacing",
		cellpadding: "cellPadding",
		rowspan: "rowSpan",
		colspan: "colSpan",
		usemap: "useMap",
		frameborder: "frameBorder",
		contenteditable: "contentEditable"
	},
	Y = Array.isArray ||
	function(t) {
		return t instanceof Array
	};
	return U.matches = function(t, e) {
		if (!e || !t || 1 !== t.nodeType) return ! 1;
		var n = t.webkitMatchesSelector || t.mozMatchesSelector || t.oMatchesSelector || t.matchesSelector;
		if (n) return n.call(t, e);
		var r, i = t.parentNode,
		o = !i;
		return o && (i = X).appendChild(t),
		r = ~U.qsa(i, e).indexOf(t),
		o && X.removeChild(t),
		r
	},
	T = function(t) {
		return t.replace(/-+(.)?/g,
		function(t, e) {
			return e ? e.toUpperCase() : ""
		})
	},
	N = function(t) {
		return Z.call(t,
		function(e, n) {
			return t.indexOf(e) == n
		})
	},
	U.fragment = function(t, e, n) {
		var r, i, a;
		return D.test(t) && (r = E(P.createElement(RegExp.$1))),
		r || (t.replace && (t = t.replace($, "<$1></$2>")), e === b && (e = _.test(t) && RegExp.$1), e in H || (e = "*"), a = H[e], a.innerHTML = "" + t, r = E.each(O.call(a.childNodes),
		function() {
			a.removeChild(this)
		})),
		o(n) && (i = E(r), E.each(n,
		function(t, e) {
			M.indexOf(t) > -1 ? i[t](e) : i.attr(t, e)
		})),
		r
	},
	U.Z = function(t, e) {
		return t = t || [],
		t.__proto__ = E.fn,
		t.selector = e || "",
		t
	},
	U.isZ = function(t) {
		return t instanceof U.Z
	},
	U.init = function(t, n) {
		var r;
		if (!t) return U.Z();
		if ("string" == typeof t) if (t = t.trim(), "<" == t[0] && _.test(t)) r = U.fragment(t, RegExp.$1, n),
		t = null;
		else {
			if (n !== b) return E(n).find(t);
			r = U.qsa(P, t)
		} else {
			if (e(t)) return E(P).ready(t);
			if (U.isZ(t)) return t;
			if (Y(t)) r = u(t);
			else if (i(t)) r = [t],
			t = null;
			else if (_.test(t)) r = U.fragment(t.trim(), RegExp.$1, n),
			t = null;
			else {
				if (n !== b) return E(n).find(t);
				r = U.qsa(P, t)
			}
		}
		return U.Z(r, t)
	},
	E = function(t, e) {
		return U.init(t, e)
	},
	E.extend = function(t) {
		var e, n = O.call(arguments, 1);
		return "boolean" == typeof t && (e = t, t = n.shift()),
		n.forEach(function(n) {
			d(t, n, e)
		}),
		t
	},
	U.qsa = function(t, e) {
		var n, i = "#" == e[0],
		o = !i && "." == e[0],
		a = i || o ? e.slice(1) : e,
		u = I.test(a);
		return r(t) && u && i ? (n = t.getElementById(a)) ? [n] : [] : 1 !== t.nodeType && 9 !== t.nodeType ? [] : O.call(u && !i ? o ? t.getElementsByClassName(a) : t.getElementsByTagName(e) : t.querySelectorAll(e))
	},
	E.contains = P.documentElement.contains ?
	function(t, e) {
		return t !== e && t.contains(e)
	}: function(t, e) {
		for (; e && (e = e.parentNode);) if (e === t) return ! 0;
		return ! 1
	},
	E.type = t,
	E.isFunction = e,
	E.isWindow = n,
	E.isArray = Y,
	E.isPlainObject = o,
	E.isEmptyObject = function(t) {
		var e;
		for (e in t) return ! 1;
		return ! 0
	},
	E.inArray = function(t, e, n) {
		return S.indexOf.call(e, t, n)
	},
	E.camelCase = T,
	E.trim = function(t) {
		return null == t ? "": String.prototype.trim.call(t)
	},
	E.uuid = 0,
	E.support = {},
	E.expr = {},
	E.map = function(t, e) {
		var n, r, i, o = [];
		if (a(t)) for (r = 0; r < t.length; r++) n = e(t[r], r),
		null != n && o.push(n);
		else for (i in t) n = e(t[i], i),
		null != n && o.push(n);
		return s(o)
	},
	E.each = function(t, e) {
		var n, r;
		if (a(t)) {
			for (n = 0; n < t.length; n++) if (e.call(t[n], n, t[n]) === !1) return t
		} else for (r in t) if (e.call(t[r], r, t[r]) === !1) return t;
		return t
	},
	E.grep = function(t, e) {
		return Z.call(t, e)
	},
	window.JSON && (E.parseJSON = JSON.parse),
	E.each("Boolean Number String Function Array Date RegExp Object Error".split(" "),
	function(t, e) {
		B["[object " + e + "]"] = e.toLowerCase()
	}),
	E.fn = {
		forEach: S.forEach,
		reduce: S.reduce,
		push: S.push,
		sort: S.sort,
		indexOf: S.indexOf,
		concat: S.concat,
		map: function(t) {
			return E(E.map(this,
			function(e, n) {
				return t.call(e, n, e)
			}))
		},
		slice: function() {
			return E(O.apply(this, arguments))
		},
		ready: function(t) {
			return V.test(P.readyState) && P.body ? t(E) : P.addEventListener("DOMContentLoaded",
			function() {
				t(E)
			},
			!1),
			this
		},
		get: function(t) {
			return t === b ? O.call(this) : this[t >= 0 ? t: t + this.length]
		},
		toArray: function() {
			return this.get()
		},
		size: function() {
			return this.length
		},
		remove: function() {
			return this.each(function() {
				null != this.parentNode && this.parentNode.removeChild(this)
			})
		},
		each: function(t) {
			return S.every.call(this,
			function(e, n) {
				return t.call(e, n, e) !== !1
			}),
			this
		},
		filter: function(t) {
			return e(t) ? this.not(this.not(t)) : E(Z.call(this,
			function(e) {
				return U.matches(e, t)
			}))
		},
		add: function(t, e) {
			return E(N(this.concat(E(t, e))))
		},
		is: function(t) {
			return this.length > 0 && U.matches(this[0], t)
		},
		not: function(t) {
			var n = [];
			if (e(t) && t.call !== b) this.each(function(e) {
				t.call(this, e) || n.push(this)
			});
			else {
				var r = "string" == typeof t ? this.filter(t) : a(t) && e(t.item) ? O.call(t) : E(t);
				this.forEach(function(t) {
					r.indexOf(t) < 0 && n.push(t)
				})
			}
			return E(n)
		},
		has: function(t) {
			return this.filter(function() {
				return i(t) ? E.contains(this, t) : E(this).find(t).size()
			})
		},
		eq: function(t) {
			return - 1 === t ? this.slice(t) : this.slice(t, +t + 1)
		},
		first: function() {
			var t = this[0];
			return t && !i(t) ? t: E(t)
		},
		last: function() {
			var t = this[this.length - 1];
			return t && !i(t) ? t: E(t)
		},
		find: function(t) {
			var e, n = this;
			return e = t ? "object" == typeof t ? E(t).filter(function() {
				var t = this;
				return S.some.call(n,
				function(e) {
					return E.contains(e, t)
				})
			}) : 1 == this.length ? E(U.qsa(this[0], t)) : this.map(function() {
				return U.qsa(this, t)
			}) : E()
		},
		closest: function(t, e) {
			var n = this[0],
			i = !1;
			for ("object" == typeof t && (i = E(t)); n && !(i ? i.indexOf(n) >= 0 : U.matches(n, t));) n = n !== e && !r(n) && n.parentNode;
			return E(n)
		},
		parents: function(t) {
			for (var e = [], n = this; n.length > 0;) n = E.map(n,
			function(t) {
				return (t = t.parentNode) && !r(t) && e.indexOf(t) < 0 ? (e.push(t), t) : void 0
			});
			return m(e, t)
		},
		parent: function(t) {
			return m(N(this.pluck("parentNode")), t)
		},
		children: function(t) {
			return m(this.map(function() {
				return p(this)
			}), t)
		},
		contents: function() {
			return this.map(function() {
				return O.call(this.childNodes)
			})
		},
		siblings: function(t) {
			return m(this.map(function(t, e) {
				return Z.call(p(e.parentNode),
				function(t) {
					return t !== e
				})
			}), t)
		},
		empty: function() {
			return this.each(function() {
				this.innerHTML = ""
			})
		},
		pluck: function(t) {
			return E.map(this,
			function(e) {
				return e[t]
			})
		},
		show: function() {
			return this.each(function() {
				"none" == this.style.display && (this.style.display = ""),
				"none" == getComputedStyle(this, "").getPropertyValue("display") && (this.style.display = h(this.nodeName))
			})
		},
		replaceWith: function(t) {
			return this.before(t).remove()
		},
		wrap: function(t) {
			var n = e(t);
			if (this[0] && !n) var r = E(t).get(0),
			i = r.parentNode || this.length > 1;
			return this.each(function(e) {
				E(this).wrapAll(n ? t.call(this, e) : i ? r.cloneNode(!0) : r)
			})
		},
		wrapAll: function(t) {
			if (this[0]) {
				E(this[0]).before(t = E(t));
				for (var e; (e = t.children()).length;) t = e.first();
				E(t).append(this)
			}
			return this
		},
		wrapInner: function(t) {
			var n = e(t);
			return this.each(function(e) {
				var r = E(this),
				i = r.contents(),
				o = n ? t.call(this, e) : t;
				i.length ? i.wrapAll(o) : r.append(o)
			})
		},
		unwrap: function() {
			return this.parent().each(function() {
				E(this).replaceWith(E(this).children())
			}),
			this
		},
		clone: function() {
			return this.map(function() {
				return this.cloneNode(!0)
			})
		},
		hide: function() {
			return this.css("display", "none")
		},
		toggle: function(t) {
			return this.each(function() {
				var e = E(this); (t === b ? "none" == e.css("display") : t) ? e.show() : e.hide()
			})
		},
		prev: function(t) {
			return E(this.pluck("previousElementSibling")).filter(t || "*")
		},
		next: function(t) {
			return E(this.pluck("nextElementSibling")).filter(t || "*")
		},
		html: function(t) {
			return 0 in arguments ? this.each(function(e) {
				var n = this.innerHTML;
				E(this).empty().append(v(this, t, e, n))
			}) : 0 in this ? this[0].innerHTML: null
		},
		text: function(t) {
			return 0 in arguments ? this.each(function(e) {
				var n = v(this, t, e, this.textContent);
				this.textContent = null == n ? "": "" + n
			}) : 0 in this ? this[0].textContent: null
		},
		attr: function(t, e) {
			var n;
			return "string" != typeof t || 1 in arguments ? this.each(function(n) {
				if (1 === this.nodeType) if (i(t)) for (j in t) g(this, j, t[j]);
				else g(this, t, v(this, e, n, this.getAttribute(t)))
			}) : this.length && 1 === this[0].nodeType ? !(n = this[0].getAttribute(t)) && t in this[0] ? this[0][t] : n: b
		},
		removeAttr: function(t) {
			return this.each(function() {
				1 === this.nodeType && t.split(" ").forEach(function(t) {
					g(this, t)
				},
				this)
			})
		},
		prop: function(t, e) {
			return t = Q[t] || t,
			1 in arguments ? this.each(function(n) {
				this[t] = v(this, e, n, this[t])
			}) : this[0] && this[0][t]
		},
		data: function(t, e) {
			var n = "data-" + t.replace(F, "-$1").toLowerCase(),
			r = 1 in arguments ? this.attr(n, e) : this.attr(n);
			return null !== r ? w(r) : b
		},
		val: function(t) {
			return 0 in arguments ? this.each(function(e) {
				this.value = v(this, t, e, this.value)
			}) : this[0] && (this[0].multiple ? E(this[0]).find("option").filter(function() {
				return this.selected
			}).pluck("value") : this[0].value)
		},
		offset: function(t) {
			if (t) return this.each(function(e) {
				var n = E(this),
				r = v(this, t, e, n.offset()),
				i = n.offsetParent().offset(),
				o = {
					top: r.top - i.top,
					left: r.left - i.left
				};
				"static" == n.css("position") && (o.position = "relative"),
				n.css(o)
			});
			if (!this.length) return null;
			var e = this[0].getBoundingClientRect();
			return {
				left: e.left + window.pageXOffset,
				top: e.top + window.pageYOffset,
				width: Math.round(e.width),
				height: Math.round(e.height)
			}
		},
		css: function(e, n) {
			if (arguments.length < 2) {
				var r, i = this[0];
				if (!i) return;
				if (r = getComputedStyle(i, ""), "string" == typeof e) return i.style[T(e)] || r.getPropertyValue(e);
				if (Y(e)) {
					var o = {};
					return E.each(e,
					function(t, e) {
						o[e] = i.style[T(e)] || r.getPropertyValue(e)
					}),
					o
				}
			}
			var a = "";
			if ("string" == t(e)) n || 0 === n ? a = c(e) + ":" + l(e, n) : this.each(function() {
				this.style.removeProperty(c(e))
			});
			else for (j in e) e[j] || 0 === e[j] ? a += c(j) + ":" + l(j, e[j]) + ";": this.each(function() {
				this.style.removeProperty(c(j))
			});
			return this.each(function() {
				this.style.cssText += ";" + a
			})
		},
		index: function(t) {
			return t ? this.indexOf(E(t)[0]) : this.parent().children().indexOf(this[0])
		},
		hasClass: function(t) {
			return t ? S.some.call(this,
			function(t) {
				return this.test(y(t))
			},
			f(t)) : !1
		},
		addClass: function(t) {
			return t ? this.each(function(e) {
				if ("className" in this) {
					C = [];
					var n = y(this),
					r = v(this, t, e, n);
					r.split(/\s+/g).forEach(function(t) {
						E(this).hasClass(t) || C.push(t)
					},
					this),
					C.length && y(this, n + (n ? " ": "") + C.join(" "))
				}
			}) : this
		},
		removeClass: function(t) {
			return this.each(function(e) {
				if ("className" in this) {
					if (t === b) return y(this, "");
					C = y(this),
					v(this, t, e, C).split(/\s+/g).forEach(function(t) {
						C = C.replace(f(t), " ")
					}),
					y(this, C.trim())
				}
			})
		},
		toggleClass: function(t, e) {
			return t ? this.each(function(n) {
				var r = E(this),
				i = v(this, t, n, y(this));
				i.split(/\s+/g).forEach(function(t) { (e === b ? !r.hasClass(t) : e) ? r.addClass(t) : r.removeClass(t)
				})
			}) : this
		},
		scrollTop: function(t) {
			if (this.length) {
				var e = "scrollTop" in this[0];
				return t === b ? e ? this[0].scrollTop: this[0].pageYOffset: this.each(e ?
				function() {
					this.scrollTop = t
				}: function() {
					this.scrollTo(this.scrollX, t)
				})
			}
		},
		scrollLeft: function(t) {
			if (this.length) {
				var e = "scrollLeft" in this[0];
				return t === b ? e ? this[0].scrollLeft: this[0].pageXOffset: this.each(e ?
				function() {
					this.scrollLeft = t
				}: function() {
					this.scrollTo(t, this.scrollY)
				})
			}
		},
		position: function() {
			if (this.length) {
				var t = this[0],
				e = this.offsetParent(),
				n = this.offset(),
				r = L.test(e[0].nodeName) ? {
					top: 0,
					left: 0
				}: e.offset();
				return n.top -= parseFloat(E(t).css("margin-top")) || 0,
				n.left -= parseFloat(E(t).css("margin-left")) || 0,
				r.top += parseFloat(E(e[0]).css("border-top-width")) || 0,
				r.left += parseFloat(E(e[0]).css("border-left-width")) || 0,
				{
					top: n.top - r.top,
					left: n.left - r.left
				}
			}
		},
		offsetParent: function() {
			return this.map(function() {
				for (var t = this.offsetParent || P.body; t && !L.test(t.nodeName) && "static" == E(t).css("position");) t = t.offsetParent;
				return t
			})
		}
	},
	E.fn.detach = E.fn.remove,
	["width", "height"].forEach(function(t) {
		var e = t.replace(/./,
		function(t) {
			return t[0].toUpperCase()
		});
		E.fn[t] = function(i) {
			var o, a = this[0];
			return i === b ? n(a) ? a["inner" + e] : r(a) ? a.documentElement["scroll" + e] : (o = this.offset()) && o[t] : this.each(function(e) {
				a = E(this),
				a.css(t, v(this, i, e, a[t]()))
			})
		}
	}),
	z.forEach(function(e, n) {
		var r = n % 2;
		E.fn[e] = function() {
			var e, i, o = E.map(arguments,
			function(n) {
				return e = t(n),
				"object" == e || "array" == e || null == n ? n: U.fragment(n)
			}),
			a = this.length > 1;
			return o.length < 1 ? this: this.each(function(t, e) {
				i = r ? e: e.parentNode,
				e = 0 == n ? e.nextSibling: 1 == n ? e.firstChild: 2 == n ? e: null;
				var u = E.contains(P.documentElement, i);
				o.forEach(function(t) {
					if (a) t = t.cloneNode(!0);
					else if (!i) return E(t).remove();
					i.insertBefore(t, e),
					u && x(t,
					function(t) {
						null == t.nodeName || "SCRIPT" !== t.nodeName.toUpperCase() || t.type && "text/javascript" !== t.type || t.src || window.eval.call(window, t.innerHTML)
					})
				})
			})
		},
		E.fn[r ? e + "To": "insert" + (n ? "Before": "After")] = function(t) {
			return E(t)[e](this),
			this
		}
	}),
	U.Z.prototype = E.fn,
	U.uniq = N,
	U.deserializeValue = w,
	E.zepto = U,
	E
} ();
window.Zepto = Zepto,
void 0 === window.$ && (window.$ = Zepto),
window.Zepto &&
function(t) {
	function e(t) {
		return t._zid || (t._zid = h++)
	}
	function n(t, n, o, a) {
		if (n = r(n), n.ns) var u = i(n.ns);
		return (v[e(t)] || []).filter(function(t) {
			return t && (!n.e || t.e == n.e) && (!n.ns || u.test(t.ns)) && (!o || e(t.fn) === e(o)) && (!a || t.sel == a)
		})
	}
	function r(t) {
		var e = ("" + t).split(".");
		return {
			e: e[0],
			ns: e.slice(1).sort().join(" ")
		}
	}
	function i(t) {
		return new RegExp("(?:^| )" + t.replace(" ", " .* ?") + "(?: |$)")
	}
	function o(t, e) {
		return t.del && !y && t.e in w || !!e
	}
	function a(t) {
		return x[t] || y && w[t] || t
	}
	function u(n, i, u, s, f, h, p) {
		var d = e(n),
		m = v[d] || (v[d] = []);
		i.split(/\s/).forEach(function(e) {
			if ("ready" == e) return t(document).ready(u);
			var i = r(e);
			i.fn = u,
			i.sel = f,
			i.e in x && (u = function(e) {
				var n = e.relatedTarget;
				return ! n || n !== this && !t.contains(this, n) ? i.fn.apply(this, arguments) : void 0
			}),
			i.del = h;
			var d = h || u;
			i.proxy = function(t) {
				if (t = c(t), !t.isImmediatePropagationStopped()) {
					t.data = s;
					var e = d.apply(n, t._args == l ? [t] : [t].concat(t._args));
					return e === !1 && (t.preventDefault(), t.stopPropagation()),
					e
				}
			},
			i.i = m.length,
			m.push(i),
			"addEventListener" in n && n.addEventListener(a(i.e), i.proxy, o(i, p))
		})
	}
	function s(t, r, i, u, s) {
		var c = e(t); (r || "").split(/\s/).forEach(function(e) {
			n(t, e, i, u).forEach(function(e) {
				delete v[c][e.i],
				"removeEventListener" in t && t.removeEventListener(a(e.e), e.proxy, o(e, s))
			})
		})
	}
	function c(e, n) {
		return (n || !e.isDefaultPrevented) && (n || (n = e), t.each(C,
		function(t, r) {
			var i = n[t];
			e[t] = function() {
				return this[r] = b,
				i && i.apply(n, arguments)
			},
			e[r] = j
		}), (n.defaultPrevented !== l ? n.defaultPrevented: "returnValue" in n ? n.returnValue === !1 : n.getPreventDefault && n.getPreventDefault()) && (e.isDefaultPrevented = b)),
		e
	}
	function f(t) {
		var e, n = {
			originalEvent: t
		};
		for (e in t) E.test(e) || t[e] === l || (n[e] = t[e]);
		return c(n, t)
	}
	var l, h = 1,
	p = Array.prototype.slice,
	d = t.isFunction,
	m = function(t) {
		return "string" == typeof t
	},
	v = {},
	g = {},
	y = "onfocusin" in window,
	w = {
		focus: "focusin",
		blur: "focusout"
	},
	x = {
		mouseenter: "mouseover",
		mouseleave: "mouseout"
	};
	g.click = g.mousedown = g.mouseup = g.mousemove = "MouseEvents",
	t.event = {
		add: u,
		remove: s
	},
	t.proxy = function(n, r) {
		var i = 2 in arguments && p.call(arguments, 2);
		if (d(n)) {
			var o = function() {
				return n.apply(r, i ? i.concat(p.call(arguments)) : arguments)
			};
			return o._zid = e(n),
			o
		}
		if (m(r)) return i ? (i.unshift(n[r], n), t.proxy.apply(null, i)) : t.proxy(n[r], n);
		throw new TypeError("expected function")
	},
	t.fn.bind = function(t, e, n) {
		return this.on(t, e, n)
	},
	t.fn.unbind = function(t, e) {
		return this.off(t, e)
	},
	t.fn.one = function(t, e, n, r) {
		return this.on(t, e, n, r, 1)
	};
	var b = function() {
		return ! 0
	},
	j = function() {
		return ! 1
	},
	E = /^([A-Z]|returnValue$|layer[XY]$)/,
	C = {
		preventDefault: "isDefaultPrevented",
		stopImmediatePropagation: "isImmediatePropagationStopped",
		stopPropagation: "isPropagationStopped"
	};
	t.fn.delegate = function(t, e, n) {
		return this.on(e, t, n)
	},
	t.fn.undelegate = function(t, e, n) {
		return this.off(e, t, n)
	},
	t.fn.live = function(e, n) {
		return t(document.body).delegate(this.selector, e, n),
		this
	},
	t.fn.die = function(e, n) {
		return t(document.body).undelegate(this.selector, e, n),
		this
	},
	t.fn.on = function(e, n, r, i, o) {
		var a, c, h = this;
		return e && !m(e) ? (t.each(e,
		function(t, e) {
			h.on(t, n, r, e, o)
		}), h) : (m(n) || d(i) || i === !1 || (i = r, r = n, n = l), (d(r) || r === !1) && (i = r, r = l), i === !1 && (i = j), h.each(function(l, h) {
			o && (a = function(t) {
				return s(h, t.type, i),
				i.apply(this, arguments)
			}),
			n && (c = function(e) {
				var r, o = t(e.target).closest(n, h).get(0);
				return o && o !== h ? (r = t.extend(f(e), {
					currentTarget: o,
					liveFired: h
				}), (a || i).apply(o, [r].concat(p.call(arguments, 1)))) : void 0
			}),
			u(h, e, i, r, n, c || a)
		}))
	},
	t.fn.off = function(e, n, r) {
		var i = this;
		return e && !m(e) ? (t.each(e,
		function(t, e) {
			i.off(t, n, e)
		}), i) : (m(n) || d(r) || r === !1 || (r = n, n = l), r === !1 && (r = j), i.each(function() {
			s(this, e, r, n)
		}))
	},
	t.fn.trigger = function(e, n) {
		return e = m(e) || t.isPlainObject(e) ? t.Event(e) : c(e),
		e._args = n,
		this.each(function() {
			e.type in w && "function" == typeof this[e.type] ? this[e.type]() : "dispatchEvent" in this ? this.dispatchEvent(e) : t(this).triggerHandler(e, n)
		})
	},
	t.fn.triggerHandler = function(e, r) {
		var i, o;
		return this.each(function(a, u) {
			i = f(m(e) ? t.Event(e) : e),
			i._args = r,
			i.target = u,
			t.each(n(u, e.type || e),
			function(t, e) {
				return o = e.proxy(i),
				i.isImmediatePropagationStopped() ? !1 : void 0
			})
		}),
		o
	},
	"focusin focusout focus blur load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select keydown keypress keyup error".split(" ").forEach(function(e) {
		t.fn[e] = function(t) {
			return 0 in arguments ? this.bind(e, t) : this.trigger(e)
		}
	}),
	t.Event = function(t, e) {
		m(t) || (e = t, t = e.type);
		var n = document.createEvent(g[t] || "Events"),
		r = !0;
		if (e) for (var i in e)"bubbles" == i ? r = !!e[i] : n[i] = e[i];
		return n.initEvent(t, r, !0),
		c(n)
	}
} (Zepto),
window.Zepto &&
function(t) {
	function e(e, n, r) {
		var i = t.Event(n);
		return t(e).trigger(i, r),
		!i.isDefaultPrevented()
	}
	function n(t, n, r, i) {
		return t.global ? e(n || y, r, i) : void 0
	}
	function r(e) {
		e.global && 0 === t.active++&&n(e, null, "ajaxStart")
	}
	function i(e) {
		e.global && !--t.active && n(e, null, "ajaxStop")
	}
	function o(t, e) {
		var r = e.context;
		return e.beforeSend.call(r, t, e) === !1 || n(e, r, "ajaxBeforeSend", [t, e]) === !1 ? !1 : void n(e, r, "ajaxSend", [t, e])
	}
	function a(t, e, r, i) {
		var o = r.context,
		a = "success";
		r.success.call(o, t, a, e),
		i && i.resolveWith(o, [t, a, e]),
		n(r, o, "ajaxSuccess", [e, r, t]),
		s(a, e, r)
	}
	function u(t, e, r, i, o) {
		var a = i.context;
		i.error.call(a, r, e, t),
		o && o.rejectWith(a, [r, e, t]),
		n(i, a, "ajaxError", [r, i, t || e]),
		s(e, r, i)
	}
	function s(t, e, r) {
		var o = r.context;
		r.complete.call(o, e, t),
		n(r, o, "ajaxComplete", [e, r]),
		i(r)
	}
	function c() {}
	function f(t) {
		return t && (t = t.split(";", 2)[0]),
		t && (t == E ? "html": t == j ? "json": x.test(t) ? "script": b.test(t) && "xml") || "text"
	}
	function l(t, e) {
		return "" == e ? t: (t + "&" + e).replace(/[&?]{1,2}/, "?")
	}
	function h(e) {
		e.processData && e.data && "string" != t.type(e.data) && (e.data = t.param(e.data, e.traditional)),
		!e.data || e.type && "GET" != e.type.toUpperCase() || (e.url = l(e.url, e.data), e.data = void 0)
	}
	function p(e, n, r, i) {
		return t.isFunction(n) && (i = r, r = n, n = void 0),
		t.isFunction(r) || (i = r, r = void 0),
		{
			url: e,
			data: n,
			success: r,
			dataType: i
		}
	}
	function d(e, n, r, i) {
		var o, a = t.isArray(n),
		u = t.isPlainObject(n);
		t.each(n,
		function(n, s) {
			o = t.type(s),
			i && (n = r ? i: i + "[" + (u || "object" == o || "array" == o ? n: "") + "]"),
			!i && a ? e.add(s.name, s.value) : "array" == o || !r && "object" == o ? d(e, s, r, n) : e.add(n, s)
		})
	}
	var m, v, g = 0,
	y = window.document,
	w = /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,
	x = /^(?:text|application)\/javascript/i,
	b = /^(?:text|application)\/xml/i,
	j = "application/json",
	E = "text/html",
	C = /^\s*$/,
	T = y.createElement("a");
	T.href = window.location.href,
	t.active = 0,
	t.ajaxJSONP = function(e, n) {
		if (! ("type" in e)) return t.ajax(e);
		var r, i, s = e.jsonpCallback,
		c = (t.isFunction(s) ? s() : s) || "jsonp" + ++g,
		f = y.createElement("script"),
		l = window[c],
		h = function(e) {
			t(f).triggerHandler("error", e || "abort")
		},
		p = {
			abort: h
		};
		return n && n.promise(p),
		t(f).on("load error",
		function(o, s) {
			clearTimeout(i),
			t(f).off().remove(),
			"error" != o.type && r ? a(r[0], p, e, n) : u(null, s || "error", p, e, n),
			window[c] = l,
			r && t.isFunction(l) && l(r[0]),
			l = r = void 0
		}),
		o(p, e) === !1 ? (h("abort"), p) : (window[c] = function() {
			r = arguments
		},
		f.src = e.url.replace(/\?(.+)=\?/, "?$1=" + c), y.head.appendChild(f), e.timeout > 0 && (i = setTimeout(function() {
			h("timeout")
		},
		e.timeout)), p)
	},
	t.ajaxSettings = {
		type: "GET",
		beforeSend: c,
		success: c,
		error: c,
		complete: c,
		context: null,
		global: !0,
		xhr: function() {
			return new window.XMLHttpRequest
		},
		accepts: {
			script: "text/javascript, application/javascript, application/x-javascript",

			json: j,
			xml: "application/xml, text/xml",
			html: E,
			text: "text/plain"
		},
		crossDomain: !1,
		timeout: 0,
		processData: !0,
		cache: !0
	},
	t.ajax = function(e) {
		var n, i = t.extend({},
		e || {}),
		s = t.Deferred && t.Deferred();
		for (m in t.ajaxSettings) void 0 === i[m] && (i[m] = t.ajaxSettings[m]);
		r(i),
		i.crossDomain || (n = y.createElement("a"), n.href = i.url, n.href = n.href, i.crossDomain = T.protocol + "//" + T.host != n.protocol + "//" + n.host),
		i.url || (i.url = window.location.toString()),
		h(i);
		var p = i.dataType,
		d = /\?.+=\?/.test(i.url);
		if (d && (p = "jsonp"), i.cache !== !1 && (e && e.cache === !0 || "script" != p && "jsonp" != p) || (i.url = l(i.url, "_=" + Date.now())), "jsonp" == p) return d || (i.url = l(i.url, i.jsonp ? i.jsonp + "=?": i.jsonp === !1 ? "": "callback=?")),
		t.ajaxJSONP(i, s);
		var g, w = i.accepts[p],
		x = {},
		b = function(t, e) {
			x[t.toLowerCase()] = [t, e]
		},
		j = /^([\w-]+:)\/\//.test(i.url) ? RegExp.$1: window.location.protocol,
		E = i.xhr(),
		N = E.setRequestHeader;
		if (s && s.promise(E), i.crossDomain || b("X-Requested-With", "XMLHttpRequest"), b("Accept", w || "*/*"), (w = i.mimeType || w) && (w.indexOf(",") > -1 && (w = w.split(",", 2)[0]), E.overrideMimeType && E.overrideMimeType(w)), (i.contentType || i.contentType !== !1 && i.data && "GET" != i.type.toUpperCase()) && b("Content-Type", i.contentType || "application/x-www-form-urlencoded"), i.headers) for (v in i.headers) b(v, i.headers[v]);
		E.setRequestHeader = b;
		var S = "async" in i ? i.async: !0;
		if (E.open(i.type, i.url, S, i.username, i.password), E.onreadystatechange = function() {
			if (4 == E.readyState) {
				E.onreadystatechange = c,
				clearTimeout(g);
				var e, n = !1;
				if (E.status >= 200 && E.status < 300 || 304 == E.status || 0 == E.status && "file:" == j) {
					p = p || f(i.mimeType || E.getResponseHeader("content-type")),
					e = E.responseText;
					try {
						"script" == p ? (1, eval)(e) : "xml" == p ? e = E.responseXML: "json" == p && (e = C.test(e) ? null: t.parseJSON(e))
					} catch(r) {
						n = r
					}
					n ? u(n, "parsererror", E, i, s) : a(e, E, i, s)
				} else u(E.statusText || null, E.status ? "error": "abort", E, i, s)
			}
		},
		o(E, i) === !1) return E.abort(),
		u(null, "abort", E, i, s),
		E;
		if (i.xhrFields) for (v in i.xhrFields) E[v] = i.xhrFields[v];
		for (v in x) N.apply(E, x[v]);
		return i.timeout > 0 && (g = setTimeout(function() {
			E.onreadystatechange = c,
			E.abort(),
			u(null, "timeout", E, i, s)
		},
		i.timeout)),
		E.send(i.data ? i.data: null),
		E
	},
	t.get = function() {
		return t.ajax(p.apply(null, arguments))
	},
	t.post = function() {
		var e = p.apply(null, arguments);
		return e.type = "POST",
		t.ajax(e)
	},
	t.getJSON = function() {
		var e = p.apply(null, arguments);
		return e.dataType = "json",
		t.ajax(e)
	},
	t.fn.load = function(e, n, r) {
		if (!this.length) return this;
		var i, o = this,
		a = e.split(/\s/),
		u = p(e, n, r),
		s = u.success;
		return a.length > 1 && (u.url = a[0], i = a[1]),
		u.success = function(e) {
			o.html(i ? t("<div>").html(e.replace(w, "")).find(i) : e),
			s && s.apply(o, arguments)
		},
		t.ajax(u),
		this
	};
	var N = encodeURIComponent;
	t.param = function(e, n) {
		var r = [];
		return r.add = function(e, n) {
			t.isFunction(n) && (n = n()),
			null == n && (n = ""),
			this.push(N(e) + "=" + N(n))
		},
		d(r, e, n),
		r.join("&").replace(/%20/g, "+")
	}
} (Zepto),
window.Zepto &&
function(t) {
	function e(e, r) {
		var s = e[u],
		c = s && i[s];
		if (void 0 === r) return c || n(e);
		if (c) {
			if (r in c) return c[r];
			var f = a(r);
			if (f in c) return c[f]
		}
		return o.call(t(e), r)
	}
	function n(e, n, o) {
		var s = e[u] || (e[u] = ++t.uuid),
		c = i[s] || (i[s] = r(e));
		return void 0 !== n && (c[a(n)] = o),
		c
	}
	function r(e) {
		var n = {};
		return t.each(e.attributes || s,
		function(e, r) {
			0 == r.name.indexOf("data-") && (n[a(r.name.replace("data-", ""))] = t.zepto.deserializeValue(r.value))
		}),
		n
	}
	var i = {},
	o = t.fn.data,
	a = t.camelCase,
	u = t.expando = "Zepto" + +new Date,
	s = [];
	t.fn.data = function(r, i) {
		return void 0 === i ? t.isPlainObject(r) ? this.each(function(e, i) {
			t.each(r,
			function(t, e) {
				n(i, t, e)
			})
		}) : 0 in this ? e(this[0], r) : void 0 : this.each(function() {
			n(this, r, i)
		})
	},
	t.fn.removeData = function(e) {
		return "string" == typeof e && (e = e.split(/\s+/)),
		this.each(function() {
			var n = this[u],
			r = n && i[n];
			r && t.each(e || r,
			function(t) {
				delete r[e ? a(this) : t]
			})
		})
	},
	["remove", "empty"].forEach(function(e) {
		var n = t.fn[e];
		t.fn[e] = function() {
			var t = this.find("*");
			return "remove" === e && (t = t.add(this)),
			t.removeData(),
			n.call(this)
		}
	})
} (Zepto),
window.Zepto &&
function(t) {
	function e(e) {
		return e = t(e),
		!(!e.width() && !e.height()) && "none" !== e.css("display")
	}
	function n(t, e) {
		t = t.replace(/=#\]/g, '="#"]');
		var n, r, i = u.exec(t);
		if (i && i[2] in a && (n = a[i[2]], r = i[3], t = i[1], r)) {
			var o = Number(r);
			r = isNaN(o) ? r.replace(/^["']|["']$/g, "") : o
		}
		return e(t, n, r)
	}
	var r = t.zepto,
	i = r.qsa,
	o = r.matches,
	a = t.expr[":"] = {
		visible: function() {
			return e(this) ? this: void 0
		},
		hidden: function() {
			return e(this) ? void 0 : this
		},
		selected: function() {
			return this.selected ? this: void 0
		},
		checked: function() {
			return this.checked ? this: void 0
		},
		parent: function() {
			return this.parentNode
		},
		first: function(t) {
			return 0 === t ? this: void 0
		},
		last: function(t, e) {
			return t === e.length - 1 ? this: void 0
		},
		eq: function(t, e, n) {
			return t === n ? this: void 0
		},
		contains: function(e, n, r) {
			return t(this).text().indexOf(r) > -1 ? this: void 0
		},
		has: function(t, e, n) {
			return r.qsa(this, n).length ? this: void 0
		}
	},
	u = new RegExp("(.*):(\\w+)(?:\\(([^)]+)\\))?$\\s*"),
	s = /^\s*>/,
	c = "Zepto" + +new Date;
	r.qsa = function(e, o) {
		return n(o,
		function(n, o, a) {
			try {
				var u; ! n && o ? n = "*": s.test(n) && (u = t(e).addClass(c), n = "." + c + " " + n);
				var f = i(e, n)
			} catch(l) {
				throw l
			} finally {
				u && u.removeClass(c)
			}
			return o ? r.uniq(t.map(f,
			function(t, e) {
				return o.call(t, e, f, a)
			})) : f
		})
	},
	r.matches = function(t, e) {
		return n(e,
		function(e, n, r) {
			return (!e || o(t, e)) && (!n || n.call(t, null, r) === t)
		})
	}
} (Zepto),
window.Zepto &&
function(t) {
	t.Callbacks = function(e) {
		e = t.extend({},
		e);
		var n, r, i, o, a, u, s = [],
		c = !e.once && [],
		f = function(t) {
			for (n = e.memory && t, r = !0, u = o || 0, o = 0, a = s.length, i = !0; s && a > u; ++u) if (s[u].apply(t[0], t[1]) === !1 && e.stopOnFalse) {
				n = !1;
				break
			}
			i = !1,
			s && (c ? c.length && f(c.shift()) : n ? s.length = 0 : l.disable())
		},
		l = {
			add: function() {
				if (s) {
					var r = s.length,
					u = function(n) {
						t.each(n,
						function(t, n) {
							"function" == typeof n ? e.unique && l.has(n) || s.push(n) : n && n.length && "string" != typeof n && u(n)
						})
					};
					u(arguments),
					i ? a = s.length: n && (o = r, f(n))
				}
				return this
			},
			remove: function() {
				return s && t.each(arguments,
				function(e, n) {
					for (var r; (r = t.inArray(n, s, r)) > -1;) s.splice(r, 1),
					i && (a >= r && --a, u >= r && --u)
				}),
				this
			},
			has: function(e) {
				return ! (!s || !(e ? t.inArray(e, s) > -1 : s.length))
			},
			empty: function() {
				return a = s.length = 0,
				this
			},
			disable: function() {
				return s = c = n = void 0,
				this
			},
			disabled: function() {
				return ! s
			},
			lock: function() {
				return c = void 0,
				n || l.disable(),
				this
			},
			locked: function() {
				return ! c
			},
			fireWith: function(t, e) {
				return ! s || r && !c || (e = e || [], e = [t, e.slice ? e.slice() : e], i ? c.push(e) : f(e)),
				this
			},
			fire: function() {
				return l.fireWith(this, arguments)
			},
			fired: function() {
				return !! r
			}
		};
		return l
	}
} (Zepto),
window.Zepto &&
function(t) {
	function e(n) {
		var r = [["resolve", "done", t.Callbacks({
			once: 1,
			memory: 1
		}), "resolved"], ["reject", "fail", t.Callbacks({
			once: 1,
			memory: 1
		}), "rejected"], ["notify", "progress", t.Callbacks({
			memory: 1
		})]],
		i = "pending",
		o = {
			state: function() {
				return i
			},
			always: function() {
				return a.done(arguments).fail(arguments),
				this
			},
			then: function() {
				var n = arguments;
				return e(function(e) {
					t.each(r,
					function(r, i) {
						var u = t.isFunction(n[r]) && n[r];
						a[i[1]](function() {
							var n = u && u.apply(this, arguments);
							if (n && t.isFunction(n.promise)) n.promise().done(e.resolve).fail(e.reject).progress(e.notify);
							else {
								var r = this === o ? e.promise() : this,
								a = u ? [n] : arguments;
								e[i[0] + "With"](r, a)
							}
						})
					}),
					n = null
				}).promise()
			},
			promise: function(e) {
				return null != e ? t.extend(e, o) : o
			}
		},
		a = {};
		return t.each(r,
		function(t, e) {
			var n = e[2],
			u = e[3];
			o[e[1]] = n.add,
			u && n.add(function() {
				i = u
			},
			r[1 ^ t][2].disable, r[2][2].lock),
			a[e[0]] = function() {
				return a[e[0] + "With"](this === a ? o: this, arguments),
				this
			},
			a[e[0] + "With"] = n.fireWith
		}),
		o.promise(a),
		n && n.call(a, a),
		a
	}
	var n = Array.prototype.slice;
	t.when = function(r) {
		var i, o, a, u = n.call(arguments),
		s = u.length,
		c = 0,
		f = 1 !== s || r && t.isFunction(r.promise) ? s: 0,
		l = 1 === f ? r: e(),
		h = function(t, e, r) {
			return function(o) {
				e[t] = this,
				r[t] = arguments.length > 1 ? n.call(arguments) : o,
				r === i ? l.notifyWith(e, r) : --f || l.resolveWith(e, r)
			}
		};
		if (s > 1) for (i = new Array(s), o = new Array(s), a = new Array(s); s > c; ++c) u[c] && t.isFunction(u[c].promise) ? u[c].promise().done(h(c, a, u)).fail(l.reject).progress(h(c, o, i)) : --f;
		return f || l.resolveWith(a, u),
		l.promise()
	},
	t.Deferred = e
} (Zepto),
window.Zepto &&
function(t) { ["width", "height"].forEach(function(e) {
		var n = e.replace(/./,
		function(t) {
			return t[0].toUpperCase()
		});
		t.fn["outer" + n] = function(t) {
			var n = this;
			if (n && n.length > 0) {
				var r = n[e](),
				i = {
					width: ["left", "right"],
					height: ["top", "bottom"]
				};
				return i[e].forEach(function(e) {
					t && (r += parseInt(n.css("margin-" + e), 10))
				}),
				r
			}
			return null
		}
	})
} (Zepto),
(window.Zepto || window.jQuery) &&
function(t) {
	"use strict";
	if (!t._ajax) {
		var e = ["motify", "console"],
		n = function(t) {
			for (var n = 0,
			r = e.length; r > n; n++) {
				var i = e[n],
				o = window[i];
				if ("object" == typeof o && "function" == typeof o.log) {
					o.log(t);
					break
				}
			}
		};
		t._ajaxSettings = {
			defaultError: !0,
			dataType: "json",
			error: function(t, e) {
				t.defaultError && (e = "服务器出了点问题，请稍后再试 : (", n(e))
			}
		},
		t._ajax = function(e, n) {
			n = n || {},
			"object" == typeof e ? (n = e, e = void 0) : n.url = e,
			n = t.extend({},
			t._ajaxSettings, n);
			var r = (window._global || {}).csrf_token;
			r && (n.data = t.extend({
				csrf_token: r
			},
			n.data));
			var i = t.ajax(n);
			return i.defaultError = n.defaultError,
			["fail", "error"].forEach(function(t) {
				var e = i[t];
				"function" == typeof e && (i[t] = function(t) {
					return this.defaultError = !1,
					e(t),
					this
				})
			}),
			i
		},
		t.ajaxAdapter = t._ajax
	}
} (window.Zepto || window.jQuery);
var requirejs, require, define; !
function(t) {
	function e(t, e) {
		return g.call(t, e)
	}
	function n(t, e) {
		var n, r, i, o, a, u, s, c, f, l, h, p = e && e.split("/"),
		d = m.map,
		v = d && d["*"] || {};
		if (t && "." === t.charAt(0)) if (e) {
			for (p = p.slice(0, p.length - 1), t = t.split("/"), a = t.length - 1, m.nodeIdCompat && w.test(t[a]) && (t[a] = t[a].replace(w, "")), t = p.concat(t), f = 0; f < t.length; f += 1) if (h = t[f], "." === h) t.splice(f, 1),
			f -= 1;
			else if (".." === h) {
				if (1 === f && (".." === t[2] || ".." === t[0])) break;
				f > 0 && (t.splice(f - 1, 2), f -= 2)
			}
			t = t.join("/")
		} else 0 === t.indexOf("./") && (t = t.substring(2));
		if ((p || v) && d) {
			for (n = t.split("/"), f = n.length; f > 0; f -= 1) {
				if (r = n.slice(0, f).join("/"), p) for (l = p.length; l > 0; l -= 1) if (i = d[p.slice(0, l).join("/")], i && (i = i[r])) {
					o = i,
					u = f;
					break
				}
				if (o) break; ! s && v && v[r] && (s = v[r], c = f)
			} ! o && s && (o = s, u = c),
			o && (n.splice(0, u, o), t = n.join("/"))
		}
		return t
	}
	function r(e, n) {
		return function() {
			var r = y.call(arguments, 0);
			return "string" != typeof r[0] && 1 === r.length && r.push(null),
			f.apply(t, r.concat([e, n]))
		}
	}
	function i(t) {
		return function(e) {
			return n(e, t)
		}
	}
	function o(t) {
		return function(e) {
			p[t] = e
		}
	}
	function a(n) {
		if (e(d, n)) {
			var r = d[n];
			delete d[n],
			v[n] = !0,
			c.apply(t, r)
		}
		if (!e(p, n) && !e(v, n)) throw new Error("No " + n);
		return p[n]
	}
	function u(t) {
		var e, n = t ? t.indexOf("!") : -1;
		return n > -1 && (e = t.substring(0, n), t = t.substring(n + 1, t.length)),
		[e, t]
	}
	function s(t) {
		return function() {
			return m && m.config && m.config[t] || {}
		}
	}
	var c, f, l, h, p = {},
	d = {},
	m = {},
	v = {},
	g = Object.prototype.hasOwnProperty,
	y = [].slice,
	w = /\.js$/;
	l = function(t, e) {
		var r, o = u(t),
		s = o[0];
		return t = o[1],
		s && (s = n(s, e), r = a(s)),
		s ? t = r && r.normalize ? r.normalize(t, i(e)) : n(t, e) : (t = n(t, e), o = u(t), s = o[0], t = o[1], s && (r = a(s))),
		{
			f: s ? s + "!" + t: t,
			n: t,
			pr: s,
			p: r
		}
	},
	h = {
		require: function(t) {
			return r(t)
		},
		exports: function(t) {
			var e = p[t];
			return "undefined" != typeof e ? e: p[t] = {}
		},
		module: function(t) {
			return {
				id: t,
				uri: "",
				exports: p[t],
				config: s(t)
			}
		}
	},
	c = function(n, i, u, s) {
		var c, f, m, g, y, w, x = [],
		b = typeof u;
		if (s = s || n, "undefined" === b || "function" === b) {
			for (i = !i.length && u.length ? ["require", "exports", "module"] : i, y = 0; y < i.length; y += 1) if (g = l(i[y], s), f = g.f, "require" === f) x[y] = h.require(n);
			else if ("exports" === f) x[y] = h.exports(n),
			w = !0;
			else if ("module" === f) c = x[y] = h.module(n);
			else if (e(p, f) || e(d, f) || e(v, f)) x[y] = a(f);
			else {
				if (!g.p) throw new Error(n + " missing " + f);
				g.p.load(g.n, r(s, !0), o(f), {}),
				x[y] = p[f]
			}
			m = u ? u.apply(p[n], x) : void 0,
			n && (c && c.exports !== t && c.exports !== p[n] ? p[n] = c.exports: m === t && w || (p[n] = m))
		} else n && (p[n] = u)
	},
	requirejs = require = f = function(e, n, r, i, o) {
		if ("string" == typeof e) return h[e] ? h[e](n) : a(l(e, n).f);
		if (!e.splice) {
			if (m = e, m.deps && f(m.deps, m.callback), !n) return;
			n.splice ? (e = n, n = r, r = null) : e = t
		}
		return n = n ||
		function() {},
		"function" == typeof r && (r = i, i = o),
		i ? c(t, e, n, r) : setTimeout(function() {
			c(t, e, n, r)
		},
		4),
		f
	},
	f.config = function(t) {
		return f(t)
	},
	requirejs._defined = p,
	define = function(t, n, r) {
		n.splice || (r = n, n = []),
		e(p, t) || e(d, t) || (d[t] = [t, n, r])
	},
	define.amd = {
		jQuery: !0
	}
} (),
define("text", [],
function() {}),
define("backbone", [],
function() {
	return Backbone
}),
define("underscore", [],
function() {
	return _
}),
define("Zepto", [],
function() {
	return window.Zepto || window.jQuery
}),
define("jquery", [],
function() {
	return window.Zepto || window.jQuery
}),
define("bower_components/ajax/ajax", [],
function() {
	return window.Zepto || window.jQuery
});

function openMap(address, title, mobile, phone) {
    let tel = mobile ? mobile : (phone ? phone : '');
    let data = {
        address: address,
        key: "XPDBZ-CDJ6G-PYCQA-IM72W-DP7G2-SEBKY",
        output: "jsonp"
    }
    $.ajax({
        url: "https://apis.map.qq.com/ws/geocoder/v1/",
        data: data,
        dataType: 'jsonp',
        success: (res) => {
            if (res && res.status == 0) {
                let location = res.result.location;
                let lat = location.lat;
                let lng = location.lng;
                window.open("http://apis.map.qq.com/uri/v1/geocoder?marker=coord:" + lat + "," + lng + ";addr:" + address + ";title:" + title + ";tel:" + tel);
            }
        }
    })
}