!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=178)}({178:function(e,t,n){e.exports=n(179)},179:function(e,t){$(document).ready((function(){$("#editor").summernote({toolbar:[["style",["bold","italic","underline","clear"]],["para",["style","ul","ol"]],["color",["forecolor"]],["insert",["link","lfm","video","table"]],["misc",["undo","redo","fullscreen","codeview"]]],styleTags:["p","h3","h4"],buttons:{lfm:function(e){return $.summernote.ui.button({contents:'<i class="note-icon-picture"></i> ',tooltip:"Insert image with filemanager",click:function(){var t,n,r;n=function(t,n){Array.isArray(t)?t.forEach((function(t){e.invoke("insertImage",t.url)})):e.invoke("insertImage",t)},r=(t={type:"image",prefix:"/laravel-filemanager"})&&t.prefix?t.prefix:"/laravel-filemanager",window.open(r+"?type="+t.type||"file","FileManager","width=900,height=600"),window.SetUrl=n}}).render()}},dialogsInBody:!0})}))}});
//# sourceMappingURL=editor.js.map