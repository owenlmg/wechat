define("zenjs/util/cookie", [],
function() {
	var e = function() {
		var e = new Date,
		t = +e,
		n = 864e5,
		i = function(e) {
			var t = document.cookie,
			n = "\\b" + e + "=",
			i = t.search(n);
			if (0 > i) return "";
			i += n.length - 2;
			var o = t.indexOf(";", i);
			return 0 > o && (o = t.length),
			t.substring(i, o) || ""
		},
		o = function(e, t, n) {
			if (!e) return "";
			var i = [];
			for (var o in e) i.push(encodeURIComponent(o) + "=" + (n ? encodeURIComponent(e[o]) : e[o]));
			return i.join(t || ",")
		};
		return function(r, a) {
			if (void 0 === a) return i(r);
			if ("string" == typeof a || a instanceof String) {
				if (a) return document.cookie = r + "=" + a + ";",
				a;
				a = {
					expires: -100
				}
			}
			a = a || {};
			var s = r + "=" + (a.value || "") + ";";
			delete a.value,
			void 0 !== a.expires && (e.setTime(t + a.expires * n), a.expires = e.toGMTString()),
			s += o(a, ";"),
			document.cookie = s
		}
	} ();
	return e
}),
define("zenjs/util/image", ["require", "./cookie"],
function(e) {
	var t = e("./cookie"),
	n = {};
	return n.toWebp = function() {
		function e(e, t) {
			var n, i = /(\?imageView2\/\d\/w\/\d+\/h\/\d+\/q\/\d+\/format\/)(\w+)/;
			if (n = e, i.test(e)) {
				var o = e.match(i)[2];
				t ? "gif" !== o && "webp" !== o && (n = e.replace(i, "$1webp")) : "webp" === o && (n = e.replace(i, "$1jpg"))
			}
			return n
		}
		var t = /\.([^.!]+)\!([0-9]{1,4})x([0-9]{1,4})(\+2x)?\..+/,
		n = !1;
		try {
			n = "ok" === window.localStorage.getItem("canwebp")
		} catch(i) {}
		return function(i) {
			var o = i,
			r = 1,
			a = o.match(t);
			return n ? a && a.length >= 4 ? ("+2x" == a[4] && (r = 2), o = o.replace(t, ".") + a[1] + "?imageView2/2/w/" + parseInt(a[2], 10) * r + "/h/" + parseInt(a[3], 10) * r + "/q/75/format/" + ("gif" == a[1] ? "gif": "webp")) : o = e(o, !0) : a && a.length >= 4 ? ("+2x" == a[4] && (r = 2), o = o.replace(t, ".") + a[1] + "?imageView2/2/w/" + parseInt(a[2], 10) * r + "/h/" + parseInt(a[3], 10) * r + "/q/75/format/" + ("webp" === a[1] ? "jpg": a[1])) : o = e(o, !1),
			o
		}
	} (),
	n.checkCanWebp = function() {
		var e = function(e) {
			var t = new Image;
			t.onload = t.onerror = function() {
				e(2 == t.height)
			},
			t.src = "data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA"
		};
		return function(n) {
			if ("object" == typeof window.localStorage) try {
				var i = localStorage.getItem("canwebp");
				"ok" == i ? t("_canwebp", {
					value: "1",
					path: "/",
					domain: location.hostname,
					expires: 3650
				}) : "no" != i && e(function(e) {
					localStorage.setItem("canwebp", e ? "ok": "no"),
					e && t("_canwebp", {
						value: "1",
						path: "/",
						domain: location.hostname,
						expires: 3650
					})
				})
			} catch(o) {}
		}
	} (),
	n
}),
define("main",
function() {});