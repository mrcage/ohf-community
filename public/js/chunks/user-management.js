(self.webpackChunk=self.webpackChunk||[]).push([[218],{892:(e,t,r)=>{"use strict";r.d(t,{hi:()=>y,BC:()=>v});var n=r(7757),s=r.n(n),a=r(9669),o=r.n(a),i=r(4865),u=r.n(i);o().defaults.headers.common["X-Requested-With"]="XMLHttpRequest";var l=document.head.querySelector('meta[name="csrf-token"]');l?o().defaults.headers.common["X-CSRF-TOKEN"]=l.content:console.error("CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"),u().configure({showSpinner:!1}),o().interceptors.request.use((function(e){return u().start(),e})),o().interceptors.response.use((function(e){return u().done(),e}),(function(e){return u().done(),Promise.reject(e)}));const c=o();function f(e,t,r,n,s,a,o){try{var i=e[a](o),u=i.value}catch(e){return void r(e)}i.done?t(u):Promise.resolve(u).then(n,s)}function p(e){return function(){var t=this,r=arguments;return new Promise((function(n,s){var a=e.apply(t,r);function o(e){f(a,n,s,o,i,"next",e)}function i(e){f(a,n,s,o,i,"throw",e)}o(void 0)}))}}function d(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){var r=e&&("undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"]);if(null==r)return;var n,s,a=[],o=!0,i=!1;try{for(r=r.call(e);!(o=(n=r.next()).done)&&(a.push(n.value),!t||a.length!==t);o=!0);}catch(e){i=!0,s=e}finally{try{o||null==r.return||r.return()}finally{if(i)throw s}}return a}(e,t)||function(e,t){if(!e)return;if("string"==typeof e)return m(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);"Object"===r&&e.constructor&&(r=e.constructor.name);if("Map"===r||"Set"===r)return Array.from(e);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return m(e,t)}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function m(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,n=new Array(t);r<t;r++)n[r]=e[r];return n}var v=r(9643).Z.methods.route,h=function(e){throw console.error(e),function(e){var t;return e.response?(e.response.data.message&&(t=e.response.data.message),e.response.data.errors?t+="\n"+Object.entries(e.response.data.errors).map((function(e){var t=d(e,2);return t[0],t[1].join(". ")})):e.response.data.error&&(t=e.response.data.error),t||(t="Error ".concat(e.response.status,": ").concat(e.response.statusText))):t=e,t}(e)},y={getNoCatch:function(e){return p(s().mark((function t(){var r;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,c.get(e);case 2:return r=t.sent,t.abrupt("return",r.data);case 4:case"end":return t.stop()}}),t)})))()},get:function(e){return p(s().mark((function t(){var r;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,c.get(e);case 3:return r=t.sent,t.abrupt("return",r.data);case 7:t.prev=7,t.t0=t.catch(0),h(t.t0);case 10:case"end":return t.stop()}}),t,null,[[0,7]])})))()},post:function(e,t){return p(s().mark((function r(){var n;return s().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.prev=0,r.next=3,c.post(e,t);case 3:return n=r.sent,r.abrupt("return",n.data);case 7:r.prev=7,r.t0=r.catch(0),h(r.t0);case 10:case"end":return r.stop()}}),r,null,[[0,7]])})))()},postFormData:function(e,t){return p(s().mark((function r(){var n;return s().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.prev=0,r.next=3,c.post(e,t,{headers:{"Content-Type":"multipart/form-data"}});case 3:return n=r.sent,r.abrupt("return",n.data);case 7:r.prev=7,r.t0=r.catch(0),h(r.t0);case 10:case"end":return r.stop()}}),r,null,[[0,7]])})))()},put:function(e,t){return p(s().mark((function r(){var n;return s().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.prev=0,r.next=3,c.put(e,t);case 3:return n=r.sent,r.abrupt("return",n.data);case 7:r.prev=7,r.t0=r.catch(0),h(r.t0);case 10:case"end":return r.stop()}}),r,null,[[0,7]])})))()},patch:function(e,t){return p(s().mark((function r(){var n;return s().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.prev=0,r.next=3,c.patch(e,t);case 3:return n=r.sent,r.abrupt("return",n.data);case 7:r.prev=7,r.t0=r.catch(0),h(r.t0);case 10:case"end":return r.stop()}}),r,null,[[0,7]])})))()},delete:function(e){return p(s().mark((function t(){var r;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,c.delete(e);case 3:return r=t.sent,t.abrupt("return",r.data);case 7:t.prev=7,t.t0=t.catch(0),h(t.t0);case 10:case"end":return t.stop()}}),t,null,[[0,7]])})))()}}},2851:(e,t,r)=>{"use strict";r.d(t,{Z:()=>s});const n={props:["value"]};const s=(0,r(1900).Z)(n,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("b-alert",{attrs:{variant:"danger",show:null!=e.value}},[r("b-row",{attrs:{"align-v":"center"}},[r("b-col",[r("font-awesome-icon",{attrs:{icon:"times-circle"}}),e._v("\n            "+e._s(e.$t("Error: {err}",{err:e.value}))+"\n        ")],1),e._v(" "),r("b-col",{attrs:{sm:"auto"}},[r("b-button",{staticClass:"float-right",attrs:{variant:"danger",size:"sm"},on:{click:function(t){return e.$emit("retry")}}},[r("font-awesome-icon",{attrs:{icon:"redo"}}),e._v("\n                "+e._s(e.$t("Retry"))+"\n            ")],1)],1)],1)],1)}),[],!1,null,null,null).exports},8158:(e,t,r)=>{"use strict";r.d(t,{Z:()=>s});const n={props:{value:{required:!0,type:String},iconOnly:Boolean,labelOnly:Boolean},computed:{mailToHref:function(){return"mailto:".concat(this.value)}}};const s=(0,r(1900).Z)(n,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("span",[e.iconOnly?r("a",{staticClass:"btn btn-light btn-sm",attrs:{href:e.mailToHref}},[r("font-awesome-icon",{attrs:{icon:"envelope"}})],1):[e.labelOnly?e._e():r("font-awesome-icon",{attrs:{icon:"envelope"}}),e._v(" "),r("a",{attrs:{href:e.mailToHref}},[e._v(e._s(e.value))])]],2)}),[],!1,null,null,null).exports},299:(e,t,r)=>{"use strict";r.d(t,{Z:()=>c});var n=r(7757),s=r.n(n),a=r(2851),o=r(505),i=r(6281);function u(e,t,r,n,s,a,o){try{var i=e[a](o),u=i.value}catch(e){return void r(e)}i.done?t(u):Promise.resolve(u).then(n,s)}const l={components:{AlertWithRetry:a.Z,TableFilter:o.Z,TablePagination:i.Z},props:{id:{required:!0,type:String},fields:{required:!1,type:Array},apiMethod:{required:!0,type:Function},defaultSortBy:{required:!0,type:String},defaultSortDesc:{required:!1,type:Boolean,default:!1},emptyText:{required:!1,type:String},itemsPerPage:{required:!1,type:Number,default:25},filterPlaceholder:{require:!1,type:String,default:function(){return this.$t("Type to search...")}},loadingLabel:{type:String,required:!1,default:function(){return this.$t("Loading...")}},noFilter:Boolean},data:function(){return{isBusy:!1,sortBy:sessionStorage.getItem(this.id+".sortBy")?sessionStorage.getItem(this.id+".sortBy"):this.defaultSortBy,sortDesc:sessionStorage.getItem(this.id+".sortDesc")?"true"==sessionStorage.getItem(this.id+".sortDesc"):this.defaultSortDesc,currentPage:sessionStorage.getItem(this.id+".currentPage")?parseInt(sessionStorage.getItem(this.id+".currentPage")):1,perPage:this.itemsPerPage,totalRows:0,errorText:null,filter:sessionStorage.getItem(this.id+".filter")?sessionStorage.getItem(this.id+".filter"):""}},watch:{filter:function(){this.currentPage=1}},methods:{itemProvider:function(e){var t,r=this;return(t=s().mark((function t(){var n,a;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return r.errorText=null,n={filter:e.filter,page:e.currentPage,pageSize:e.perPage,sortBy:e.sortBy,sortDirection:e.sortDesc?"desc":"asc"},t.prev=2,t.next=5,r.apiMethod(n);case 5:return a=t.sent,r.totalRows=a.meta.total,r.$emit("metadata",a.meta),sessionStorage.setItem(r.id+".sortBy",e.sortBy),sessionStorage.setItem(r.id+".sortDesc",e.sortDesc),sessionStorage.setItem(r.id+".currentPage",e.currentPage),e.filter.length>0?sessionStorage.setItem(r.id+".filter",e.filter):sessionStorage.removeItem(r.id+".filter"),t.abrupt("return",a.data||[]);case 15:return t.prev=15,t.t0=t.catch(2),r.errorText=t.t0,r.totalRows=0,sessionStorage.removeItem(r.id+".sortBy"),sessionStorage.removeItem(r.id+".sortDesc"),sessionStorage.removeItem(r.id+".currentPage"),sessionStorage.removeItem(r.id+".filter"),t.abrupt("return",[]);case 24:case"end":return t.stop()}}),t,null,[[2,15]])})),function(){var e=this,r=arguments;return new Promise((function(n,s){var a=t.apply(e,r);function o(e){u(a,n,s,o,i,"next",e)}function i(e){u(a,n,s,o,i,"throw",e)}o(void 0)}))})()},refresh:function(){this.$root.$emit("bv::refresh::table",this.id)}}};const c=(0,r(1900).Z)(l,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",[r("alert-with-retry",{attrs:{value:e.errorText},on:{retry:e.refresh}}),e._v(" "),e._t("top"),e._v(" "),r("b-form-row",[e.$slots["filter-prepend"]?r("b-col",{attrs:{cols:"auto"}},[e._t("filter-prepend")],2):e._e(),e._v(" "),r("b-col",[e.noFilter?e._e():r("table-filter",{attrs:{placeholder:e.filterPlaceholder,"is-busy":e.isBusy,"total-rows":e.totalRows},model:{value:e.filter,callback:function(t){e.filter=t},expression:"filter"}})],1),e._v(" "),e.$slots["filter-append"]?r("b-col",{attrs:{cols:"auto"}},[e._t("filter-append")],2):e._e()],1),e._v(" "),r("b-table",{staticClass:"bg-white shadow-sm",attrs:{id:e.id,hover:"",responsive:"",items:e.itemProvider,fields:e.fields,"primary-key":"id",busy:e.isBusy,"sort-by":e.sortBy,"sort-desc":e.sortDesc,"per-page":e.perPage,"current-page":e.currentPage,"show-empty":!0,"empty-text":e.emptyText,"empty-filtered-text":e.$t("There are no records matching your request."),"no-sort-reset":!0,filter:e.filter},on:{"update:busy":function(t){e.isBusy=t},"update:sortBy":function(t){e.sortBy=t},"update:sort-by":function(t){e.sortBy=t},"update:sortDesc":function(t){e.sortDesc=t},"update:sort-desc":function(t){e.sortDesc=t}},scopedSlots:e._u([e._l(e.$scopedSlots,(function(t,r){return{key:r,fn:function(t){return[e._t(r,null,null,t)]}}})),{key:"empty",fn:function(t){return[r("em",[e._v(e._s(t.emptyText))])]}},{key:"emptyfiltered",fn:function(t){return[r("em",[e._v(e._s(t.emptyFilteredText))])]}}],null,!0)},[e._v(" "),r("div",{staticClass:"text-center my-2",attrs:{slot:"table-busy"},slot:"table-busy"},[r("b-spinner",{staticClass:"align-middle"}),e._v(" "),r("strong",[e._v(e._s(e.loadingLabel))])],1)]),e._v(" "),r("table-pagination",{attrs:{"total-rows":e.totalRows,"per-page":e.perPage,disabled:e.isBusy},model:{value:e.currentPage,callback:function(t){e.currentPage=t},expression:"currentPage"}})],2)}),[],!1,null,null,null).exports},505:(e,t,r)=>{"use strict";r.d(t,{Z:()=>s});const n={props:{value:{required:!0},placeholder:{required:!1,type:String,default:function(){return this.$t("Type to search...")}},totalRows:{type:Number},isBusy:Boolean},computed:{filterText:{get:function(){return this.value},set:function(e){this.$emit("input",e)}}}};const s=(0,r(1900).Z)(n,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("b-input-group",{staticClass:"mb-3"},[r("b-form-input",{attrs:{debounce:400,trim:"",type:"search",placeholder:e.placeholder,autocomplete:"off"},on:{keyup:function(t){if(!t.type.indexOf("key")&&e._k(t.keyCode,"esc",27,t.key,["Esc","Escape"]))return null;e.filterText=""}},model:{value:e.filterText,callback:function(t){e.filterText=t},expression:"filterText"}}),e._v(" "),r("b-input-group-append",{staticClass:"d-none d-sm-block"},[e.isBusy?r("b-input-group-text",[e._v("\n            ...\n        ")]):r("b-input-group-text",[e._v("\n            "+e._s(e.$t("{num} results",{num:e.totalRows}))+"\n        ")])],1)],1)}),[],!1,null,null,null).exports},6281:(e,t,r)=>{"use strict";r.d(t,{Z:()=>s});const n={props:{value:Number,totalRows:Number,perPage:Number,disabled:Boolean},computed:{currentPage:{get:function(){return this.value},set:function(e){this.$emit("input",e)}},itemsStart:function(){return(this.currentPage-1)*this.perPage+1},itemsEnd:function(){return Math.min(this.currentPage*this.perPage,this.totalRows)}}};const s=(0,r(1900).Z)(n,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("b-row",{staticClass:"mb-3",attrs:{"align-v":"center"}},[r("b-col",[e.totalRows>0?r("b-pagination",{staticClass:"mb-0",attrs:{size:"sm","total-rows":e.totalRows,"per-page":e.perPage,disabled:e.disabled},model:{value:e.currentPage,callback:function(t){e.currentPage=t},expression:"currentPage"}}):e._e()],1),e._v(" "),r("b-col",{staticClass:"text-right",attrs:{sm:"auto"}},[r("small",[e._v("\n            "+e._s(e.$t("{x} out of {y}",{x:e.itemsStart+" - "+e.itemsEnd,y:e.totalRows}))+"\n        ")])])],1)}),[],!1,null,null,null).exports},4658:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>y});var n=r(381),s=r.n(n),a=r(299),o=r(8158);const i={props:{url:{required:!0},size:{required:!1,default:48}}};var u=r(1900);const l=(0,u.Z)(i,(function(){var e=this,t=e.$createElement;return(e._self._c||t)("img",{staticClass:"avatar",attrs:{src:e.url,width:e.size,height:e.size,alt:"Avatar"}})}),[],!1,null,null,null).exports;var c=r(7757),f=r.n(c),p=r(892);function d(e,t,r,n,s,a,o){try{var i=e[a](o),u=i.value}catch(e){return void r(e)}i.done?t(u):Promise.resolve(u).then(n,s)}function m(e){return function(){var t=this,r=arguments;return new Promise((function(n,s){var a=e.apply(t,r);function o(e){d(a,n,s,o,i,"next",e)}function i(e){d(a,n,s,o,i,"throw",e)}o(void 0)}))}}const v={list:function(e){return m(f().mark((function t(){var r;return f().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return r=(0,p.BC)("api.users.index",e),t.next=3,p.hi.get(r);case 3:return t.abrupt("return",t.sent);case 4:case"end":return t.stop()}}),t)})))()},listWithRoles:function(e){return m(f().mark((function t(){var r;return f().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e||(e={}),e.include="roles",r=(0,p.BC)("api.users.index",e),t.next=5,p.hi.get(r);case 5:return t.abrupt("return",t.sent);case 6:case"end":return t.stop()}}),t)})))()},store:function(e){return m(f().mark((function t(){var r;return f().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return r=(0,p.BC)("api.users.store"),t.next=3,p.hi.post(r,e);case 3:return t.abrupt("return",t.sent);case 4:case"end":return t.stop()}}),t)})))()},find:function(e){return m(f().mark((function t(){var r;return f().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return r=(0,p.BC)("api.users.show",e),t.next=3,p.hi.get(r);case 3:return t.abrupt("return",t.sent);case 4:case"end":return t.stop()}}),t)})))()},update:function(e,t){return m(f().mark((function r(){var n;return f().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return n=(0,p.BC)("api.users.update",e),r.next=3,p.hi.put(n,t);case 3:return r.abrupt("return",r.sent);case 4:case"end":return r.stop()}}),r)})))()},delete:function(e){return m(f().mark((function t(){var r;return f().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return r=(0,p.BC)("api.users.destroy",e),t.next=3,p.hi.delete(r);case 3:return t.abrupt("return",t.sent);case 4:case"end":return t.stop()}}),t)})))()}},h={components:{BaseTable:a.Z,EmailLink:o.Z,UserAvatar:l},data:function(){return{fields:[{key:"avatar_url",label:this.$t("Avatar"),class:"fit align-middle text-center"},{key:"name",label:this.$t("Name"),sortable:!0,class:"align-middle"},{key:"email",label:this.$t("E-Mail Address"),class:"align-middle d-none d-sm-table-cell"},{key:"roles",label:this.$t("Roles"),class:"align-middle d-none d-sm-table-cell"},{key:"provider_name",label:this.$t("OAuth"),class:"align-middle fit d-none d-md-table-cell",sortable:!0},{key:"is_2fa_enabled",label:this.$t("2FA"),class:"align-middle d-none d-md-table-cell text-center fit"},{key:"is_super_admin",label:this.$t("Admin"),class:"align-middle d-none d-md-table-cell text-center fit",sortable:!0,sortDirection:"desc"},{key:"created_at",label:this.$t("Registered"),class:"d-none d-sm-table-cell fit",tdClass:"align-middle",sortable:!0,sortDirection:"desc",formatter:function(e){return s()(e).fromNow()}}]}},methods:{list:v.listWithRoles}};const y=(0,u.Z)(h,(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("base-table",{attrs:{id:"usersTable",fields:e.fields,"api-method":e.list,"default-sort-by":"name","empty-text":e.$t("No users found."),"items-per-page":25},scopedSlots:e._u([{key:"cell(avatar_url)",fn:function(e){return[r("user-avatar",{attrs:{url:e.value,size:"30"}})]}},{key:"cell(name)",fn:function(t){return[r("a",{attrs:{href:t.item.links.show}},[e._v("\n            "+e._s(t.value)+"\n        ")])]}},{key:"cell(email)",fn:function(t){return[t.item.email?r("email-link",{attrs:{value:t.item.email,"label-only":""}}):e._e()]}},{key:"cell(roles)",fn:function(t){return e._l(t.item.relationships.roles.data,(function(t){return r("span",{key:t.id},[r("a",{attrs:{href:t.links.show}},[e._v("\n                "+e._s(t.name)+"\n            ")]),e._v(" "),r("br")])}))}},{key:"cell(is_2fa_enabled)",fn:function(e){return[r("span",{class:e.value?"text-success":"text-muted"},[r("font-awesome-icon",{attrs:{icon:e.value?"check":"times"}})],1)]}},{key:"cell(is_super_admin)",fn:function(e){return[r("span",{class:e.value?"text-info":"text-muted"},[r("font-awesome-icon",{attrs:{icon:e.value?"check":"times"}})],1)]}}])})}),[],!1,null,null,null).exports}}]);
//# sourceMappingURL=user-management.js.map