function FormatNumberBy3(num, decpoint, sep) {
  if (arguments.length == 2) {
    sep = ",";
  }
  if (arguments.length == 1) {
    sep = ",";
    decpoint = ".";
  }
  num = num.toString();
  a = num.split(decpoint);
  x = a[0];
  y = a[1];
  z = "";

  if (typeof(x) != "undefined") {
    for (i=x.length-1;i>=0;i--)
      z += x.charAt(i);
    z = z.replace(/(\d{3})/g, "$1" + sep);
    if (z.slice(-sep.length) == sep)
      z = z.slice(0, -sep.length);
    x = "";
    for (i=z.length-1;i>=0;i--)
      x += z.charAt(i);
    if (typeof(y) != "undefined" && y.length > 0)
      x += decpoint + y;
  }
  return x;
}