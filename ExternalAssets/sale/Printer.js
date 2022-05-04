! function (h) {
    "use strict";

    function f(e, t, n) {
        for (var r, o, a, e = h(e), n = e.clone(t, n), i = e.find("textarea").add(e.filter("textarea")), l = n.find("textarea").add(n.filter("textarea")), c = e.find("select").add(e.filter("select")), d = n.find("select").add(n.filter("select")), s = e.find("canvas").add(e.filter("canvas")), f = n.find("canvas").add(n.filter("canvas")), p = 0, u = i.length; p < u; ++p) h(l[p]).val(h(i[p]).val());
        for (p = 0, u = c.length; p < u; ++p)
            for (r = 0, o = c[p].options.length; r < o; ++r) !0 === c[p].options[r].selected && (d[p].options[r].selected = !0);
        for (p = 0, u = s.length; p < u; ++p)(a = s[p].getContext("2d")) && (f[p].getContext("2d").drawImage(s[p], 0, 0), h(f[p]).attr("data-jquery-print", a.canvas.toDataURL()));
        return n
    }

    function p(t) {
        var n = h("");
        try {
            n = f(t)
        } catch (e) {
            n = h("<span />").html(t)
        }
        return n
    }

    function u(t, e, n) {
        var r = h.Deferred();
        try {
            t = t.contentWindow || t.contentDocument || t;
            try {
                t.resizeTo(window.innerWidth, window.innerHeight)
            } catch (e) {
                console.warn(e)
            }
            var o = t.document || t.contentDocument || t;
            n.doctype && o.write(n.doctype), o.write(e);
            try {
                for (var a = o.querySelectorAll("canvas"), i = 0; i < a.length; i++) {
                    var l = a[i].getContext("2d"),
                        c = new Image;
                    c.onload = function () {
                        l.drawImage(c, 0, 0)
                    }, c.src = a[i].getAttribute("data-jquery-print")
                }
            } catch (e) {
                console.warn(e)
            }
            o.close();
            var d = !1,
                s = function () {
                    if (!d) {
                        t.focus();
                        try {
                            t.document.execCommand("print", !1, null) || t.print(), h("body").focus()
                        } catch (e) {
                            t.print()
                        }
                        t.close(), d = !0, r.resolve()
                    }
                };
            h(t).on("load", s), setTimeout(s, n.timeout)
        } catch (e) {
            r.reject(e)
        }
        return r
    }

    function y(e, t) {
        return u(window.open(), e, t).always(function () {
            try {
                t.deferred.resolve()
            } catch (e) {
                console.warn("Error notifying deferred", e)
            }
        })
    }

    function m(e) {
        return "object" == typeof Node ? e instanceof Node : e && "object" == typeof e && "number" == typeof e.nodeType && "string" == typeof e.nodeName
    }
    h.print = h.fn.print = function () {
        var e = this;
        e instanceof h && (e = e.get(0)), m(e) ? (o = h(e), 0 < arguments.length && (t = arguments[0])) : 0 < arguments.length ? m((o = h(arguments[0]))[0]) ? 1 < arguments.length && (t = arguments[1]) : (t = arguments[0], o = h("html")) : o = h("html");
        var e = {
                globalStyles: !0,
                mediaPrint: !1,
                stylesheet: null,
                noPrintSelector: ".no-print",
                iframe: !0,
                append: null,
                prepend: null,
                manuallyCopyFormValues: !0,
                deferred: h.Deferred(),
                timeout: 750,
                title: null,
                doctype: "<!doctype html>"
            },
            t = h.extend({}, e, t || {}),
            n = h("");
        if (t.globalStyles ? n = h("style, link, meta, base, title") : t.mediaPrint && (n = h("link[media=print]")), t.stylesheet) {
            (h.isArray || Array.isArray)(t.stylesheet) || (t.stylesheet = [t.stylesheet]);
            for (var r = 0; r < t.stylesheet.length; r++) n = h.merge(n, h('<link rel="stylesheet" href="' + t.stylesheet[r] + '">'))
        }
        var o, a = f(o, !0, !0);
        (a = h("<span/>").append(a)).find(t.noPrintSelector).remove(), a.append(f(n)), t.title && (0 === (o = h("title", a)).length && (o = h("<title />"), a.append(o)), o.text(t.title)), a.append(p(t.append)), a.prepend(p(t.prepend)), t.manuallyCopyFormValues && (a.find("input").each(function () {
            var e = h(this);
            e.is("[type='radio']") || e.is("[type='checkbox']") ? e.prop("checked") && e.attr("checked", "checked") : e.attr("value", e.val())
        }), a.find("select").each(function () {
            h(this).find(":selected").attr("selected", "selected")
        }), a.find("textarea").each(function () {
            var e = h(this);
            e.text(e.val())
        }));
        var i, l, c, d, s = a.html();
        try {
            t.deferred.notify("generated_markup", s, a)
        } catch (e) {
            console.warn("Error notifying deferred", e)
        }
        if (a.remove(), t.iframe) try {
            i = s, c = h((l = t).iframe + ""), 0 === (d = c.length) && (c = h('<iframe height="0" width="0" border="0" wmode="Opaque"/>').prependTo("body").css({
                position: "absolute",
                top: -999,
                left: -999
            })), u(c.get(0), i, l).done(function () {
                setTimeout(function () {
                    0 === d && c.remove()
                }, 1e3)
            }).fail(function (e) {
                console.error("Failed to print from iframe", e), y(i, l)
            }).always(function () {
                try {
                    l.deferred.resolve()
                } catch (e) {
                    console.warn("Error notifying deferred", e)
                }
            })
        } catch (e) {
            console.error("Failed to print from iframe", e.stack, e.message), y(s, t)
        } else y(s, t);
        return this
    }
}(jQuery);
