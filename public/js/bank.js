!function(e){function t(a){if(n[a])return n[a].exports;var r=n[a]={i:a,l:!1,exports:{}};return e[a].call(r.exports,r,r.exports,t),r.l=!0,r.exports}var n={};t.m=e,t.c=n,t.i=function(e){return e},t.d=function(e,n,a){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:a})},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=241)}({13:function(e,t){function n(e,t,n){for(e.empty(),t.current_page>1?e.append(a("&laquo;",1,null,n)):e.append(a("&laquo;",null,"disabled",n)),t.current_page>1?e.append(a("&lsaquo;",t.current_page-1,null,n)):e.append(a("&lsaquo;",null,"disabled",n)),i=2+Math.max(2-(t.last_page-t.current_page),0);i>=1;i--)t.current_page>i&&e.append(a(t.current_page-i,t.current_page-i,null,n));for(e.append(a(t.current_page,null,"active",n)),i=1;i<=2+Math.max(0,3-t.current_page);i++)t.current_page+i-1<t.last_page&&e.append(a(t.current_page+i,t.current_page+i,null,n));t.current_page<t.last_page?e.append(a("&rsaquo;",t.current_page+1,null,n)):e.append(a("&rsaquo;",null,"disabled",n)),t.current_page<t.last_page?e.append(a("&raquo;",t.last_page,null,n)):e.append(a("&raquo;",null,"disabled",n))}function a(e,t,n,a){var r=$("<li>").addClass("page-item");return null!=t?r.append($("<a>").addClass("page-link").attr("href","javascript:;").html(e).on("click",function(){a(t)})):r.append($("<span>").addClass("page-link").html(e)),null!=n&&r.addClass(n),r}e.exports={updatePagination:n}},144:function(e,t,n){function a(){$.get("bank/todayStats",function(e){e.numberOfPersonsServed?$("#stats").html("Today, we served <strong>"+e.numberOfPersonsServed+"</strong> persons, handing out <strong> "+e.transactionValue+"</strong> drachmas."):$("#stats").html("We did not yet serve any persons today."),$("#stats").fadeIn("fast")})}function r(){filterField.val("").change().focus(),s(),l(),$.post(resetFilterUrl,{_token:csrfToken})}function i(e){if(h!=e){$("#stats").hide(),""!=e?(filterReset.removeAttr("disabled"),filterReset.addClass("bg-primary text-light")):(filterReset.attr("disabled","disabled"),filterReset.removeClass("bg-primary text-light"));var t=e.trim();""!=t?c(t,1):(table.hide(),a(),s(),l()),h=e}}function o(e){statusContainer.html(e)}function l(){statusContainer.html(""),paginator.empty(),paginationInfo.empty()}function p(e,t){alertContainer.html(e),alertContainer.addClass("alert alert-"+t);var n="danger"==t?"warning":"info-circle";alertContainer.prepend($("<i>").addClass("fa fa-"+n).append("&nbsp;")),alertContainer.show()}function s(){alertContainer.hide(),alertContainer.removeClass()}function d(e){c(filterField.val().trim(),e)}function c(e,t){paginator.empty(),paginationInfo.empty(),o("Searching..."),$.post(filterUrl,{_token:csrfToken,filter:e,page:t},function(e){var t=table.children("tbody");if(e.results.length>0)t.empty(),$.each(e.results,function(e,n){t.append(u(n))}),table.show(),s(),l(),pagination.updatePagination(paginator,e,d),paginationInfo.html(e.from+" - "+e.to+" of "+e.total);else{table.hide(),a(),l();p($("<span>").text("No results. ").append($("<a>").attr("href",createNewRecordUrl+(e.register?"?"+e.register:"")).append("Register new person")),"info")}}).fail(function(e,t,n){table.hide(),a(),l(),p(t+": "+n,"danger")})}function u(e){var t=$("<td>");e.today>0?t.text(e.today).append(" &nbsp; ").append($("<a>").attr("href","javascript:;").append($("<i>").addClass("fa fa-pencil")).on("click",function(){var n=$("<input>").attr("type","number").attr("min",0).attr("max",transactionMaxAmount).attr("value",e.today).addClass("form-control form-control-sm").on("focus",function(){$(this).select()}).on("keypress",function(t){13==t.keyCode&&f(e.id,$(this).val()-e.today)});t.empty(),t.append(n),n.focus()})):(t.append($("<a>").attr("href","#").addClass("btn btn-secondary btn-sm").text("2").on("click",function(t){$(this).parent().html('<i class="fa fa-spinner fa-spin">'),f(e.id,2),t.preventDefault()})),t.append(" &nbsp; "),t.append($("<a>").attr("href","#").addClass("btn btn-secondary btn-sm").text("1").on("click",function(t){$(this).parent().html('<i class="fa fa-spinner fa-spin">'),f(e.id,1),t.preventDefault()})));var n="";return"f"==e.gender&&(n="female"),"m"==e.gender&&(n="male"),$("<tr>").attr("id","person-"+e.id).addClass(e.today>0?"table-success":null).append($("<td>").html(""!=n?'<i class="fa fa-'+n+'"></i>':"")).append($("<td>").append($("<a>").attr("href","people/"+e.id).text(e.family_name))).append($("<td>").append($("<a>").attr("href","people/"+e.id).text(e.name))).append($("<td>").text(e.age)).append($("<td>").text(e.police_no)).append($("<td>").text(e.case_no)).append($("<td>").text(e.medical_no)).append($("<td>").text(e.registration_no)).append($("<td>").text(e.section_card_no)).append($("<td>").text(e.temp_no)).append($("<td>").text(e.nationality)).append($("<td>").text(e.remarks)).append($("<td>").html(function(){return e.boutique_coupon?e.boutique_coupon:$("<a>").attr("href","javascript:;").text("Give coupon").on("click",function(){confirm("Give coupon to "+e.family_name+" "+e.name+"?")&&$.post(giveBouqiqueCouponUrl,{_token:csrfToken,person_id:e.id},function(t){g(e.id),filterField.select()}).fail(function(e,t){alert(extStatus)})})})).append($("<td>").html(function(){return e.diapers_coupon?e.diapers_coupon:$("<a>").attr("href","javascript:;").text("Give coupon").on("click",function(){confirm("Give coupon to "+e.family_name+" "+e.name+"?")&&$.post(giveDiapersCouponUrl,{_token:csrfToken,person_id:e.id},function(t){g(e.id),filterField.select()}).fail(function(e,t){alert(extStatus)})})})).append(t)}function f(e,t){$.post(storeTransactionUrl,{_token:csrfToken,person_id:e,value:t},function(t){$("tr#person-"+e).replaceWith(u(t)),filterField.select()}).fail(function(e,t){alert(t+": "+e.responseJSON)})}function g(e){$.get("bank/person/"+e,function(t){$("tr#person-"+e).replaceWith(u(t))}).fail(function(e,t){alert(t)})}pagination=n(13);var m,h="";$(function(){filterField.on("change paste propertychange input",function(e){"input"==e.type||"propertychange"==e.type?(clearTimeout(m),m=setTimeout(function(){i(filterField.val())},250)):i(filterField.val())}),filterField.on("keydown",function(e){var t=!1,n=!1;"key"in e?(t="Escape"==e.key||"Esc"==e.key,n="Enter"==e.key):(t=27==e.keyCode,n=13==e.keyCode),t?r():n&&(i(filterField.val()),filterField.blur())}),filterReset.on("click",function(){r()}),addFilterElem.on("click",function(){var e=$(this).attr("data-filter"),t=filterField.val();t.trim().split(" ").includes(e.trim())?filterField.focus().val(t):filterField.focus().val(e+t).change()}),filterField.select().change(),a()})},241:function(e,t,n){e.exports=n(144)}});