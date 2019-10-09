!function(e){var t={};function r(o){if(t[o])return t[o].exports;var n=t[o]={i:o,l:!1,exports:{}};return e[o].call(n.exports,n,n.exports,r),n.l=!0,n.exports}r.m=e,r.c=t,r.d=function(e,t,o){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(r.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)r.d(o,n,function(t){return e[t]}.bind(null,n));return o},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="/",r(r.s=0)}({0:function(e,t,r){r("b/UH"),e.exports=r("LG8y")},LG8y:function(e,t){},"b/UH":function(e,t){function r(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){if(!(Symbol.iterator in Object(e)||"[object Arguments]"===Object.prototype.toString.call(e)))return;var r=[],o=!0,n=!1,a=void 0;try{for(var l,i=e[Symbol.iterator]();!(o=(l=i.next()).done)&&(r.push(l.value),!t||r.length!==t);o=!0);}catch(e){n=!0,a=e}finally{try{o||null==i.return||i.return()}finally{if(n)throw a}}return r}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance")}()}var o=null,n=function(e){var t;e.response.data.message&&(t=e.response.data.message),e.response.data.errors?t+="\n"+Object.entries(e.response.data.errors).map((function(e){var t=r(e,2);t[0];return t[1].join(". ")})):e.response.data.error&&(t=e.response.data.error),alert("Error: "+t)};$(document).ready((function(){var e=$("#calendar"),t=$("#eventModal"),r=$("#resourceModal"),a=$("#event_editor_title"),l=$("#event_editor_description"),i=$("#event_editor_date_start"),u=$("#event_editor_date_end"),s=$("#event_editor_resource_id"),d=$("#event_editor_delete"),c=t.find('button[type="submit"]'),f=$("#event_editor_credits"),m=$("#resource_editor_title"),v=$("#resource_editor_group"),p=$("#resource_editor_color"),h=$("#resource_editor_delete"),b=r.find('button[type="submit"]');function y(e,t,r){axios.patch(e.updateDateUrl,{start:e.start.format(),end:e.end?e.end.format():null,resourceId:e.resourceId}).catch((function(e){n(e),r()}))}function g(e){var t="00:00:00"==e.format("HH:mm:ss");return e.format(t?"LL":"LLL")}function x(e,t){if(e.isSame(t,"day"))return" - "+t.format("LT");var r="00:00:00"==e.format("HH:mm:ss"),o="00:00:00"==t.format("HH:mm:ss");if(r&&o){var n=t.clone().subtract(1,"day");return e.isSame(n,"day")?"":" - "+n.format("LL")}return" - "+t.format("LLL")}function w(t,r){var o=e.fullCalendar("getResources");s.empty();var n={};$.each(o,(function(e,t){s.append($("<option>",{value:t.id,text:t.title})),n[t.id]=t.eventColor})),s.val(t).change().prop("disabled",r);var a=function(){var e=n[s.val()];s.siblings().find("label").css("color",e||"inherit")};s.off("change").on("change",a),a()}t.on("shown.bs.modal",(function(e){a.focus()})),r.on("shown.bs.modal",(function(e){m.focus()})),e.fullCalendar({themeSystem:"bootstrap4",height:"auto",locale:locale,slotLabelFormat:"H:mm",minTime:"08:00",header:{left:manageResourcesAllowed?"prev,next today promptResource":"prev,next today",center:"title",right:"agendaDay,agendaWeek,month,listWeek,timelineDay"},customButtons:{promptResource:{text:"+ Resource",click:function(){r.find(".modal-title").text("Create Resource"),m.val(""),v.val(o||""),p.val(function(){for(var e="#",t=0;t<6;t++)e+="0123456789ABCDEF"[Math.floor(16*Math.random())];return e}()),h.hide(),b.show(),r.parent("form").off().on("submit",(function(){axios.post(storeResourceUrl,{title:m.val(),group:v.val(),color:p.val()}).then((function(t){o=v.val(),r.modal("hide"),e.fullCalendar("addResource",t.data,!0)})).catch(n)})),r.modal("show"),m.focus()}}},resourceLabelText:"Resources",resourceRender:function(t,o){manageResourcesAllowed&&o.on("click",(function(){!function(t){r.find(".modal-title").text("Edit Resource"),m.val(t.title),v.val(t.group),p.val(t.eventColor),h.show(),b.show(),r.parent("form").off().on("submit",(function(){axios.put(t.url,{title:m.val(),group:v.val(),color:p.val()}).then((function(){r.modal("hide"),e.fullCalendar("refetchResources")})).catch(n)})),h.off().on("click",(function(){confirm("Are you sure you want to delete thre resource '"+t.title+"'?")&&axios.delete(t.url).then((function(){r.modal("hide"),e.fullCalendar("removeResource",t)})).catch(n)})),r.modal("show"),m.focus()}(t)}))},views:{agendaDay:{buttonText:"Day"},agendaWeek:{buttonText:"Week"},month:{buttonText:"Month"},listWeek:{buttonText:"List"},timelineDay:{buttonText:"Timeline"}},defaultView:localStorage.getItem("calendar-view-name")?localStorage.getItem("calendar-view-name"):"agendaWeek",viewRender:function(e,t){localStorage.setItem("calendar-view-name",e.name)},firstDay:1,weekends:!0,weekNumbers:!0,weekNumbersWithinDays:!0,businessHours:{dow:[1,2,3,4,5,6],start:"10:00",end:"19:00"},navLinks:!0,eventLimit:!0,events:listEventsUrl,editable:!1,eventDrop:y,eventResize:y,selectable:createEventAllowed,selectHelper:!1,select:function(r,o,m,v,p){var h=e.fullCalendar("getResources");if(0==h.length)return alert("Please add a resource first before creating an event!"),void e.fullCalendar("unselect");t.find(".modal-title").text("Create Event"),i.text(g(r)),u.text(x(r,o)),a.val("").prop("readonly",!1),l.val("").prop("readonly",!1),w(p?p.id:h[0].id,!1),d.hide(),c.show(),f.hide(),t.on("hide.bs.modal",(function(t){e.fullCalendar("unselect")})),t.parent("form").off().on("submit",(function(){axios.post(storeEventUrl,{title:a.val(),description:l.val(),resourceId:s.val(),start:r.format(),end:o?o.format():null}).then((function(r){t.modal("hide"),e.fullCalendar("renderEvent",r.data,!0)})).catch(n)})),t.modal("show"),a.focus()},unselectAuto:!1,eventClick:function(r,o,m){if(!r.editable)return function(e){t.find(".modal-title").text("View Event"),i.text(g(e.start)),u.text(x(e.start,e.end)),a.val(e.title).prop("readonly",!0),l.val(e.description).prop("readonly",!0),w(e.resourceId,!0),d.hide(),c.hide(),e.user.id!=currentUserId?(f.find('[rel="author"]').text(e.user.name),f.show()):f.hide();return t.modal("show"),!1}(r);t.find(".modal-title").text("Edit Event"),i.text(g(r.start)),u.text(x(r.start,r.end)),a.val(r.title).prop("readonly",!1),l.val(r.description).prop("readonly",!1),w(r.resourceId,!1),d.show(),c.show(),r.user.id!=currentUserId?(f.find('[rel="author"]').text(r.user.name),f.show()):f.hide();return t.parent("form").off().on("submit",(function(){axios.put(r.url,{title:a.val(),description:l.val(),resourceId:s.val()}).then((function(){t.modal("hide"),r.title=a.val(),r.description=l.val(),r.resourceId=s.val(),e.fullCalendar("updateEvent",r)})).catch(n)})),d.off().on("click",(function(){confirm("Really delete event '"+r.title+"'?")&&axios.delete(r.url).then((function(){t.modal("hide"),e.fullCalendar("removeEvents",r.id)})).catch(n)})),t.modal("show"),a.select(),!1},schedulerLicenseKey:"CC-Attribution-NonCommercial-NoDerivatives",resources:listResourcesUrl,resourceOrder:"title",resourceGroupField:"group"})}))}});
//# sourceMappingURL=calendar.js.map