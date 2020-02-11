function page_loader(flag) {
    let loaderHtml = '<div class="ajaxloader"><svg class="lds-spinner cssload-speeding-wheel" width="200px"  height="200px"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" style="background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%;"><g transform="rotate(0 50 50)">' +
    '<rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#fdfdfd">' +
      '<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.9166666666666666s" repeatCount="indefinite"></animate>' +
    '</rect>' +
  '</g><g transform="rotate(30 50 50)">' +
    '<rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#fdfdfd">' +
      '<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.8333333333333334s" repeatCount="indefinite"></animate>' +
    '</rect>' +
  '</g><g transform="rotate(60 50 50)">' +
    '<rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#fdfdfd">' +
      '<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.75s" repeatCount="indefinite"></animate>' +
    '</rect>' +
  '</g><g transform="rotate(90 50 50)">' +
    '<rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#fdfdfd">' +
      '<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.6666666666666666s" repeatCount="indefinite"></animate>' +
    '</rect>' +
  '</g><g transform="rotate(120 50 50)">' +
    '<rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#fdfdfd">' +
      '<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5833333333333334s" repeatCount="indefinite"></animate>' +
    '</rect>' +
  '</g><g transform="rotate(150 50 50)">' +
   ' <rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#fdfdfd">' +
      '<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5s" repeatCount="indefinite"></animate>' +
    '</rect>' +
  '</g><g transform="rotate(180 50 50)">' +
    '<rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#fdfdfd">' +
     ' <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.4166666666666667s" repeatCount="indefinite"></animate>' +
    '</rect>' +
  '</g><g transform="rotate(210 50 50)">' +
    '<rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#fdfdfd">' +
      '<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.3333333333333333s" repeatCount="indefinite"></animate>' +
    '</rect>' +
  '</g><g transform="rotate(240 50 50)">' +
    '<rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#fdfdfd">' +
      '<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.25s" repeatCount="indefinite"></animate>' +
    '</rect>' +
  '</g><g transform="rotate(270 50 50)">' +
    '<rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#fdfdfd">' +
      '<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.16666666666666666s" repeatCount="indefinite"></animate>' +
    '</rect>' +
  '</g><g transform="rotate(300 50 50)">' +
    '<rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#fdfdfd">' +
      '<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.08333333333333333s" repeatCount="indefinite"></animate>' +
    '</rect>' +
  '</g><g transform="rotate(330 50 50)">' +
    '<rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#fdfdfd">' +
      '<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite"></animate>' +
    '</rect>' +
  '</g></svg></div>';
  if (flag == true) {
    if ($("body .ajaxloader").length == 0) {
        $("body").prepend(loaderHtml);
    }
  } else {
    $("body .ajaxloader").remove();
  }
}
function number_format(number, decimals, dec_point, thousands_sep) {
    // * example 1: number_format(1234.5678, 2, '.', '');
    // * returns 1: 1234.57
    number = number.toString().replace(/[(,)|(.)]/g, "");

    var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
    var d = dec_point == undefined ? "," : dec_point;
    var t = thousands_sep == undefined ? "." : thousands_sep, s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;

    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}