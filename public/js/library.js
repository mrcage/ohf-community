!function(e){var t={};function n(a){if(t[a])return t[a].exports;var r=t[a]={i:a,l:!1,exports:{}};return e[a].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,a){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(n.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(a,r,function(t){return e[t]}.bind(null,r));return a},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=0)}({0:function(e,t,n){n("b/UH"),e.exports=n("LG8y")},"2mDf":function(e,t){function n(){}n.prototype.validate=(e=>{if("X"===(e=(e=String(e)).split(""))[9]&&(e[9]="10"),10===e.length){let t=e=>{let t=0;return e.forEach((e,n)=>{e=parseInt(e),t+=e*(n+1)}),t%11==0},n=e=>{let t=parseInt(e.pop()),n=0;return(e=e.reverse()).forEach((e,t)=>{n+=parseInt(e)*(t+2)}),(n=(11-n%11)%11)===t};return t(e)&&t(e.reverse())&&n(e)}if(13===e.length){return(e=>{let t=parseInt(e.pop()),n=0;return e.forEach((e,t)=>{n+=++t%2==0?3*parseInt(e):parseInt(e)}),n%10===t||10-n%10===t})(e)}return!1}),e.exports=new n},LG8y:function(e,t){},"b/UH":function(e,t,n){var a=n("2mDf");$(function(){$("#lendBookModal").on("shown.bs.modal",function(e){$('input[name="book_id"]').val("").trigger("change"),$('input[name="book_id_search"]').val("").focus(),$('input[name="person_id"]').val("").trigger("change"),$('input[name="person_id_search"]').val("").focus()}),$("#registerBookModal").on("shown.bs.modal",function(e){$('input[name="isbn"]').focus();var t=$('input[name="book_id_search"]').val().toUpperCase().replace(/[^+0-9X]/gi,"");a.validate(t)&&$('input[name="isbn"]').val(t).trigger("propertychange")}),$('input[name="isbn"]').on("input propertychange",function(){$(this).removeClass("is-valid").removeClass("is-invalid");var e=$(this).val().toUpperCase().replace(/[^+0-9X]/gi,"");/^(97(8|9))?\d{9}(\d|X)$/.test(e)&&a.validate(e)?($(this).addClass("is-valid"),$('input[name="title"]').val(""),$('input[name="author"]').val(""),$('input[name="language"]').val(""),$('input[name="title"]').attr("placeholder","Searching for title..."),$('input[name="author"]').attr("placeholder","Searching for author..."),$('input[name="language"]').attr("placeholder","Searching for language..."),$.get("/library/books/findIsbn/"+e,function(e){$('input[name="title"]').val(e.title),$('input[name="author"]').val(e.author),$('input[name="language"]').val(e.language)}).fail(function(){$('input[name="title"]').attr("placeholder","Title"),$('input[name="author"]').attr("placeholder","Author"),$('input[name="language"]').attr("placeholder","Language")})):$(this).val().length>0&&$(this).addClass("is-invalid")})})}});
//# sourceMappingURL=library.js.map