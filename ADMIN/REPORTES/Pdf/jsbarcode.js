function CODE128(c, p) {
  function m() {
    return -1 == c.search(r) ? !1 : !0;
  }
  function a(q, g, e, a) {
    var k;
    k = "" + b(e);
    k += g(q);
    k += b(a(q, e));
    return k + "1100011101011";
  }
  function l(q) {
    for (var g = "", e = 0; e < q.length; e++) {
      var a;
      a: {
        for (a = 0; a < h.length; a++)
          if (h[a][0] == q[e]) {
            a = h[a][1];
            break a;
          }
        a = "";
      }
      g += a;
    }
    return g;
  }
  function d(a) {
    for (var g = "", e = 0; e < a.length; e += 2)
      g += b(parseInt(a.substr(e, 2)));
    return g;
  }
  function f(a, g) {
    for (var e = 0, k = 0; k < a.length; k++) {
      var b;
      a: {
        for (b = 0; b < h.length; b++)
          if (h[b][0] == a[k]) {
            b = h[b][2];
            break a;
          }
        b = 0;
      }
      e += b * (k + 1);
    }
    return (e + g) % 103;
  }
  function n(a, g) {
    for (var e = 0, k = 1, b = 0; b < a.length; b += 2)
      (e += parseInt(a.substr(b, 2)) * k), k++;
    return (e + g) % 103;
  }
  function b(a) {
    for (var b = 0; b < h.length; b++) if (h[b][2] == a) return h[b][1];
    return "";
  }
  p = p || "B";
  this.string128 = c + "";
  this.valid = m;
  this.encoded = function () {
    return m(c) ? k["code128" + p](c) : "";
  };
  var h = [
      [" ", "11011001100", 0],
      ["!", "11001101100", 1],
      ['"', "11001100110", 2],
      ["#", "10010011000", 3],
      ["$", "10010001100", 4],
      ["%", "10001001100", 5],
      ["&", "10011001000", 6],
      ["'", "10011000100", 7],
      ["(", "10001100100", 8],
      [")", "11001001000", 9],
      ["*", "11001000100", 10],
      ["+", "11000100100", 11],
      [",", "10110011100", 12],
      ["-", "10011011100", 13],
      [".", "10011001110", 14],
      ["/", "10111001100", 15],
      ["0", "10011101100", 16],
      ["1", "10011100110", 17],
      ["2", "11001110010", 18],
      ["3", "11001011100", 19],
      ["4", "11001001110", 20],
      ["5", "11011100100", 21],
      ["6", "11001110100", 22],
      ["7", "11101101110", 23],
      ["8", "11101001100", 24],
      ["9", "11100101100", 25],
      [":", "11100100110", 26],
      [";", "11101100100", 27],
      ["<", "11100110100", 28],
      ["=", "11100110010", 29],
      [">", "11011011000", 30],
      ["?", "11011000110", 31],
      ["@", "11000110110", 32],
      ["A", "10100011000", 33],
      ["B", "10001011000", 34],
      ["C", "10001000110", 35],
      ["D", "10110001000", 36],
      ["E", "10001101000", 37],
      ["F", "10001100010", 38],
      ["G", "11010001000", 39],
      ["H", "11000101000", 40],
      ["I", "11000100010", 41],
      ["J", "10110111000", 42],
      ["K", "10110001110", 43],
      ["L", "10001101110", 44],
      ["M", "10111011000", 45],
      ["N", "10111000110", 46],
      ["O", "10001110110", 47],
      ["P", "11101110110", 48],
      ["Q", "11010001110", 49],
      ["R", "11000101110", 50],
      ["S", "11011101000", 51],
      ["T", "11011100010", 52],
      ["U", "11011101110", 53],
      ["V", "11101011000", 54],
      ["W", "11101000110", 55],
      ["X", "11100010110", 56],
      ["Y", "11101101000", 57],
      ["Z", "11101100010", 58],
      ["[", "11100011010", 59],
      ["\\", "11101111010", 60],
      ["]", "11001000010", 61],
      ["^", "11110001010", 62],
      ["_", "10100110000", 63],
      ["`", "10100001100", 64],
      ["a", "10010110000", 65],
      ["b", "10010000110", 66],
      ["c", "10000101100", 67],
      ["d", "10000100110", 68],
      ["e", "10110010000", 69],
      ["f", "10110000100", 70],
      ["g", "10011010000", 71],
      ["h", "10011000010", 72],
      ["i", "10000110100", 73],
      ["j", "10000110010", 74],
      ["k", "11000010010", 75],
      ["l", "11001010000", 76],
      ["m", "11110111010", 77],
      ["n", "11000010100", 78],
      ["o", "10001111010", 79],
      ["p", "10100111100", 80],
      ["q", "10010111100", 81],
      ["r", "10010011110", 82],
      ["s", "10111100100", 83],
      ["t", "10011110100", 84],
      ["u", "10011110010", 85],
      ["v", "11110100100", 86],
      ["w", "11110010100", 87],
      ["x", "11110010010", 88],
      ["y", "11011011110", 89],
      ["z", "11011110110", 90],
      ["{", "11110110110", 91],
      ["|", "10101111000", 92],
      ["}", "10100011110", 93],
      ["~", "10001011110", 94],
      [String.fromCharCode(127), "10111101000", 95],
      [String.fromCharCode(128), "10111100010", 96],
      [String.fromCharCode(129), "11110101000", 97],
      [String.fromCharCode(130), "11110100010", 98],
      [String.fromCharCode(131), "10111011110", 99],
      [String.fromCharCode(132), "10111101110", 100],
      [String.fromCharCode(133), "11101011110", 101],
      [String.fromCharCode(134), "11110101110", 102],
      [String.fromCharCode(135), "11010000100", 103],
      [String.fromCharCode(136), "11010010000", 104],
      [String.fromCharCode(137), "11010011100", 105],
    ],
    r = /^[!-~ ]+$/,
    k = {
      code128B: function (b) {
        return a(b, l, 104, f);
      },
      code128C: function (b) {
        b = b.replace(/ /g, "");
        return a(b, d, 105, n);
      },
    };
}
function CODE128B(c) {
  return new CODE128(c, "B");
}
function CODE128C(c) {
  return new CODE128(c, "C");
}
function CODE39(c) {
  function p() {
    return -1 == c.search(a) ? !1 : !0;
  }
  var m = [
    [0, "0", "101000111011101"],
    [1, "1", "111010001010111"],
    [2, "2", "101110001010111"],
    [3, "3", "111011100010101"],
    [4, "4", "101000111010111"],
    [5, "5", "111010001110101"],
    [6, "6", "101110001110101"],
    [7, "7", "101000101110111"],
    [8, "8", "111010001011101"],
    [9, "9", "101110001011101"],
    [10, "A", "111010100010111"],
    [11, "B", "101110100010111"],
    [12, "C", "111011101000101"],
    [13, "D", "101011100010111"],
    [14, "E", "111010111000101"],
    [15, "F", "101110111000101"],
    [16, "G", "101010001110111"],
    [17, "H", "111010100011101"],
    [18, "I", "101110100011101"],
    [19, "J", "101011100011101"],
    [20, "K", "111010101000111"],
    [21, "L", "101110101000111"],
    [22, "M", "111011101010001"],
    [23, "N", "101011101000111"],
    [24, "O", "111010111010001"],
    [25, "P", "101110111010001"],
    [26, "Q", "101010111000111"],
    [27, "R", "111010101110001"],
    [28, "S", "101110101110001"],
    [29, "T", "101011101110001"],
    [30, "U", "111000101010111"],
    [31, "V", "100011101010111"],
    [32, "W", "111000111010101"],
    [33, "X", "100010111010111"],
    [34, "Y", "111000101110101"],
    [35, "Z", "100011101110101"],
    [36, "-", "100010101110111"],
    [37, ".", "111000101011101"],
    [38, " ", "100011101011101"],
    [39, "$", "100010001000101"],
    [40, "/", "100010001010001"],
    [41, "+", "100010100010001"],
    [42, "%", "101000100010001"],
  ];
  this.valid = p;
  this.encoded = function () {
    if (p(c)) {
      var a = c,
        a = a.toUpperCase(),
        d;
      d = "1000101110111010";
      for (var f = 0; f < a.length; f++) {
        var n;
        a: {
          for (n = 0; n < m.length; n++)
            if (m[n][1] == a[f]) {
              n = m[n][2];
              break a;
            }
          n = "";
        }
        d += n + "0";
      }
      return d + "1000101110111010";
    }
    return "";
  };
  var a = /^[0-9a-zA-Z\-\.\ \$\/\+\%]+$/;
}
function EAN(c) {
  function p(b, h) {
    for (var g = "", e = 0; e < b.length; e++)
      "L" == h[e]
        ? (g += a[b[e]])
        : "G" == h[e]
        ? (g += l[b[e]])
        : "R" == h[e] && (g += d[b[e]]);
    return g;
  }
  function m(a) {
    if (-1 == a.search(r)) return !1;
    for (var b = a[12], g = 0, e = 0; 12 > e; e += 2) g += parseInt(a[e]);
    for (e = 1; 12 > e; e += 2) g += 3 * parseInt(a[e]);
    return b == (10 - (g % 10)) % 10;
  }
  this.EANnumber = c + "";
  this.valid = function () {
    return m(this.EANnumber);
  };
  this.encoded = function () {
    if (m(this.EANnumber)) {
      var a = this.EANnumber,
        d = "",
        g = a[0],
        e = a.substr(1, 7),
        a = a.substr(7, 6),
        d = d + n,
        d = d + p(e, f[g]),
        d = d + h,
        d = d + p(a, "RRRRRR");
      return (d += b);
    }
    return "";
  };
  var a = {
      0: "0001101",
      1: "0011001",
      2: "0010011",
      3: "0111101",
      4: "0100011",
      5: "0110001",
      6: "0101111",
      7: "0111011",
      8: "0110111",
      9: "0001011",
    },
    l = {
      0: "0100111",
      1: "0110011",
      2: "0011011",
      3: "0100001",
      4: "0011101",
      5: "0111001",
      6: "0000101",
      7: "0010001",
      8: "0001001",
      9: "0010111",
    },
    d = {
      0: "1110010",
      1: "1100110",
      2: "1101100",
      3: "1000010",
      4: "1011100",
      5: "1001110",
      6: "1010000",
      7: "1000100",
      8: "1001000",
      9: "1110100",
    },
    f = {
      0: "LLLLLL",
      1: "LLGLGG",
      2: "LLGGLG",
      3: "LLGGGL",
      4: "LGLLGG",
      5: "LGGLLG",
      6: "LGGGLL",
      7: "LGLGLG",
      8: "LGLGGL",
      9: "LGGLGL",
    },
    n = "101",
    b = "101",
    h = "01010",
    r = /^[0-9]{13}$/;
}
function UPC(c) {
  this.ean = new EAN("0" + c);
  this.valid = function () {
    return this.ean.valid();
  };
  this.encoded = function () {
    return this.ean.encoded();
  };
}
function ITF(c) {
  this.ITFNumber = c + "";
  this.valid = function () {
    return -1 !== this.ITFNumber.search(l);
  };
  this.encoded = function () {
    if (-1 !== this.ITFNumber.search(l)) {
      var d = this.ITFNumber,
        f;
      f = "" + m;
      for (var n = 0; n < d.length; n += 2) {
        for (
          var b = d.substr(n, 2), h = "", c = p[b[0]], b = p[b[1]], k = 0;
          5 > k;
          k++
        )
          (h += "1" == c[k] ? "111" : "1"), (h += "1" == b[k] ? "000" : "0");
        f += h;
      }
      return (f += a);
    }
    return "";
  };
  var p = {
      0: "00110",
      1: "10001",
      2: "01001",
      3: "11000",
      4: "00101",
      5: "10100",
      6: "01100",
      7: "00011",
      8: "10010",
      9: "01010",
    },
    m = "1010",
    a = "11101",
    l = /^([0-9][0-9])+$/;
}
function ITF14(c) {
  function p(a) {
    for (var b = 0, d = 0; 13 > d; d++) b += parseInt(a[d]) * (3 - (d % 2) * 2);
    return 10 - (b % 10);
  }
  function m(a) {
    return -1 == a.search(f) ? !1 : 14 == a.length ? a[13] == p(a) : !0;
  }
  this.ITF14number = c + "";
  this.valid = function () {
    return m(this.ITF14number);
  };
  this.encoded = function () {
    if (m(this.ITF14number)) {
      var f = this.ITF14number,
        b = "";
      13 == f.length && (f += p(f));
      for (var b = b + l, h = 0; 14 > h; h += 2) {
        for (
          var c = f.substr(h, 2), k = "", q = a[c[0]], c = a[c[1]], g = 0;
          5 > g;
          g++
        )
          (k += "1" == q[g] ? "111" : "1"), (k += "1" == c[g] ? "000" : "0");
        b += k;
      }
      return (b += d);
    }
    return "";
  };
  var a = {
      0: "00110",
      1: "10001",
      2: "01001",
      3: "11000",
      4: "00101",
      5: "10100",
      6: "01100",
      7: "00011",
      8: "10010",
      9: "01010",
    },
    l = "1010",
    d = "11101",
    f = /^[0-9]{13,14}$/;
}
function pharmacode(c) {
  function p(c, a) {
    if (0 == c.length) return "";
    var l,
      d = !1,
      f;
    l = c.length - 1;
    for (f = 0; "0" == c[l] || 0 > l; ) f++, l--;
    0 == f
      ? ((l = a ? "001" : "00111"), (d = a))
      : ((l = "001".repeat(f - (a ? 1 : 0))), (l += "00111"));
    return p(c.substr(0, c.length - f - 1), d) + l;
  }
  this.number = parseInt(c);
  this.encoded = function () {
    return this.valid(this.number)
      ? p(this.number.toString(2), !0).substr(2)
      : "";
  };
  this.valid = function () {
    return 3 <= this.number && 131070 >= this.number;
  };
  String.prototype.repeat = function (c) {
    return Array(c + 1).join(this);
  };
}
(function (c) {
  JsBarcode = function (c, m, a, l) {
    a = (function (a, b) {
      var c = {},
        d;
      for (d in a) c[d] = a[d];
      for (d in b) c[d] = b[d];
      return c;
    })(JsBarcode.defaults, a);
    var d = c;
    window.jQuery && d instanceof jQuery && (d = c.get(0));
    d instanceof HTMLCanvasElement || (d = document.createElement("canvas"));
    if (!d.getContext) return c;
    var f = new window[a.format](m);
    if (!f.valid()) return l && l(!1), this;
    var f = f.encoded(),
      n = function (c) {
        var f, g;
        g = a.height;
        b.font = a.fontSize + "px " + a.font;
        b.textBaseline = "bottom";
        b.textBaseline = "top";
        "left" == a.textAlign
          ? ((f = a.quite), (b.textAlign = "left"))
          : "right" == a.textAlign
          ? ((f = d.width - a.quite), (b.textAlign = "right"))
          : ((f = d.width / 2), (b.textAlign = "center"));
        b.fillText(c, f, g);
      },
      b = d.getContext("2d");
    d.width = f.length * a.width + 2 * a.quite;
    d.height = a.height + (a.displayValue ? 1.3 * a.fontSize : 0);
    b.clearRect(0, 0, d.width, d.height);
    a.backgroundColor &&
      ((b.fillStyle = a.backgroundColor), b.fillRect(0, 0, d.width, d.height));
    b.fillStyle = a.lineColor;
    for (var h = 0; h < f.length; h++) {
      var r = h * a.width + a.quite;
      "1" == f[h] && b.fillRect(r, 0, a.width, a.height);
    }
    a.displayValue && n(m);
    uri = d.toDataURL("image/png");
    window.jQuery && c instanceof jQuery
      ? c.get(0) instanceof HTMLCanvasElement || c.attr("src", uri)
      : c instanceof HTMLCanvasElement || c.setAttribute("src", uri);
    l && l(!0);
  };
  JsBarcode.defaults = {
    width: 2,
    height: 100,
    quite: 10,
    format: "CODE128",
    displayValue: !1,
    font: "monospace",
    textAlign: "center",
    fontSize: 12,
    backgroundColor: "",
    lineColor: "#000",
  };
  window.jQuery &&
    (c.fn.JsBarcode = function (c, m, a) {
      JsBarcode(this, c, m, a);
      return this;
    });
})(window.jQuery);
