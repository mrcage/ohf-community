(window.webpackJsonp=window.webpackJsonp||[]).push([[10],{4:function(t,e,r){t.exports=r("DaNJ")},DaNJ:function(t,e,r){"use strict";r.r(e);var n=r("XuX8"),a=r.n(n),o=r("1QPe"),s=r("X1uE"),i=r("fxIy"),u=r("jE9Z"),l=r("o0o1"),c=r.n(l),d=r("wd/R"),_=r.n(d),p=r("8D1c");function b(t,e,r,n,a,o,s){try{var i=t[o](s),u=i.value}catch(t){return void r(t)}i.done?e(u):Promise.resolve(u).then(n,a)}function h(t){return function(){var e=this,r=arguments;return new Promise((function(n,a){var o=t.apply(e,r);function s(t){b(o,n,a,s,i,"next",t)}function i(t){b(o,n,a,s,i,"throw",t)}s(void 0)}))}}var v={components:{},data:function(){return{dailyFields:[{key:"day",label:this.$t("app.date")},{key:"visitors",label:this.$t("visitors.visitors"),class:"text-right"},{key:"participants",label:this.$t("visitors.participants"),class:"text-right"},{key:"staff",label:this.$t("visitors.volunteers_staff"),class:"text-right"},{key:"external",label:this.$t("visitors.external_visitors"),class:"text-right"},{key:"total",label:this.$t("app.total"),class:"text-right"}],monthlyFields:[{key:"date",label:this.$t("app.date"),formatter:function(t,e,r){return _()({year:r.year,month:r.month-1}).format("MMMM YYYY")}},{key:"visitors",label:this.$t("visitors.visitors"),class:"text-right"},{key:"participants",label:this.$t("visitors.participants"),class:"text-right"},{key:"staff",label:this.$t("visitors.volunteers_staff"),class:"text-right"},{key:"external",label:this.$t("visitors.external_visitors"),class:"text-right"},{key:"total",label:this.$t("app.total"),class:"text-right"}]}},methods:{dailyitemProvider:function(t){return h(c.a.mark((function t(){var e;return c.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,p.a.dailyVisitors();case 2:return e=t.sent,t.abrupt("return",e||[]);case 4:case"end":return t.stop()}}),t)})))()},monthlyItemProvider:function(t){return h(c.a.mark((function t(){var e;return c.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,p.a.monthlyVisitors();case 2:return e=t.sent,t.abrupt("return",e||[]);case 4:case"end":return t.stop()}}),t)})))()}}},g=r("KHd+"),f=Object(g.a)(v,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[r("h3",[t._v(t._s(t.$t("visitors.visitors_by_day")))]),t._v(" "),r("b-table",{attrs:{items:t.dailyitemProvider,fields:t.dailyFields,hover:"",responsive:"","show-empty":!0,"empty-text":t.$t("app.no_data_registered"),caption:t.$t("app.showing_latest_n_active_days",{days:30}),"tbody-class":"bg-white","thead-class":"bg-white"}},[r("div",{staticClass:"text-center my-2",attrs:{slot:"table-busy"},slot:"table-busy"},[r("b-spinner",{staticClass:"align-middle"}),t._v(" "),r("strong",[t._v(t._s(t.$t("app.loading")))])],1)]),t._v(" "),r("h3",[t._v(t._s(t.$t("visitors.visitors_by_month")))]),t._v(" "),r("b-table",{staticClass:"bg-white",attrs:{items:t.monthlyItemProvider,fields:t.monthlyFields,hover:"",responsive:"","show-empty":!0,"empty-text":t.$t("app.no_data_registered")}},[r("div",{staticClass:"text-center my-2",attrs:{slot:"table-busy"},slot:"table-busy"},[r("b-spinner",{staticClass:"align-middle"}),t._v(" "),r("strong",[t._v(t._s(t.$t("app.loading")))])],1)])],1)}),[],!1,null,null,null).exports,m=r("7t2G"),y=r("o0O0");function w(t,e,r,n,a,o,s){try{var i=t[o](s),u=i.value}catch(t){return void r(t)}i.done?e(u):Promise.resolve(u).then(n,a)}var x={components:{GenderLabel:r("gZRc").a},data:function(){return{loaded:!1,borrwer_count:null,borrowers_currently_borrowed_count:null,borrowers_currently_overdue_count:null,borrwer_lendings_top:null,borrwer_nationalities:null,borrwer_genders:null,book_count:null,books_currently_borrowed_count:null,books_currently_overdue_count:null,book_lendings_unique_count:null,book_lendings_all_count:null,book_lendings_top:null,book_languages:null}},computed:{book_languages_defined:function(){return this.book_languages.filter((function(t){return null!=t.language_code}))},book_languages_undefined_count:function(){return this.book_languages.filter((function(t){return null==t.language_code})).reduce((function(t,e){return t+e.quantity}),0)}},created:function(){this.loadData()},methods:{loadData:function(){var t,e=this;return(t=c.a.mark((function t(){var r;return c.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.prev=0,t.next=3,m.a.fetchReportData();case 3:r=t.sent,e.borrwer_count=r.borrwer_count,e.borrowers_currently_borrowed_count=r.borrowers_currently_borrowed_count,e.borrowers_currently_overdue_count=r.borrowers_currently_overdue_count,e.borrwer_lendings_top=r.borrwer_lendings_top,e.borrwer_nationalities=r.borrwer_nationalities,e.borrwer_genders=r.borrwer_genders,e.book_count=r.book_count,e.books_currently_borrowed_count=r.books_currently_borrowed_count,e.books_currently_overdue_count=r.books_currently_overdue_count,e.book_lendings_unique_count=r.book_lendings_unique_count,e.book_lendings_all_count=r.book_lendings_all_count,e.book_lendings_top=r.book_lendings_top,e.book_languages=r.book_languages,e.loaded=!0,t.next=23;break;case 20:t.prev=20,t.t0=t.catch(0),alert(t.t0);case 23:case"end":return t.stop()}}),t,null,[[0,20]])})),function(){var e=this,r=arguments;return new Promise((function(n,a){var o=t.apply(e,r);function s(t){w(o,n,a,s,i,"next",t)}function i(t){w(o,n,a,s,i,"throw",t)}s(void 0)}))})()},roundWithDecimals:y.f,truncate:function(t,e){return null==t?null:t.length>e?t.substr(0,e-1)+"&hellip;":t}}},k=Object(g.a)(x,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return t.loaded?r("b-row",[r("b-col",{attrs:{md:""}},[r("h2",[t._v("\n            "+t._s(t.$t("library.borrowers"))+"\n            "),r("small",[t._v(t._s(t.borrwer_count))])]),t._v(" "),t.borrwer_count>0?[r("p",[r("strong",[t._v(t._s(t.$t("library.currently_borrowing"))+":")]),t._v("\n                "+t._s(t.borrowers_currently_borrowed_count)+"\n                "),t.borrowers_currently_borrowed_count>0?[r("strong",[t._v(t._s(t.$t("library.have_overdue_books"))+":")]),t._v("\n                    "+t._s(t.borrowers_currently_overdue_count)+"\n                    ("+t._s(t.roundWithDecimals(t.borrowers_currently_overdue_count/t.borrowers_currently_borrowed_count*100,1))+" %)\n                ")]:t._e()],2),t._v(" "),r("b-card",{staticClass:"shadow-sm mb-4",attrs:{header:t.$t("app.regulars"),"no-body":""}},[r("b-table-simple",{staticClass:"bg-white mb-0",attrs:{hover:"",responsive:""}},[r("b-thead",[r("b-tr",[r("b-th",[t._v(t._s(t.$t("app.title")))]),t._v(" "),r("b-th",[t._v(t._s(t.$t("people.age")))]),t._v(" "),r("b-th",[t._v(t._s(t.$t("people.nationality")))]),t._v(" "),r("b-th",{staticClass:"text-center"},[t._v(t._s(t.$t("people.gender")))]),t._v(" "),r("b-th",{staticClass:"text-right"},[t._v(t._s(t.$t("library.lendings")))])],1)],1),t._v(" "),r("b-tbody",t._l(t.borrwer_lendings_top,(function(e,n){return r("b-tr",{key:n},[r("b-td",[t._v("\n                                "+t._s(e.collapsed_name)+"\n                            ")]),t._v(" "),r("b-td",[t._v(t._s(e.age))]),t._v(" "),r("b-td",[t._v(t._s(e.nationality))]),t._v(" "),r("b-td",{staticClass:"text-center"},[r("gender-label",{attrs:{value:e.gender,"icon-only":""}})],1),t._v(" "),r("b-td",{staticClass:"text-right"},[t._v("\n                                "+t._s(e.quantity)+"\n                            ")])],1)})),1)],1)],1),t._v(" "),r("b-card",{staticClass:"shadow-sm mb-4",attrs:{header:t.$t("people.nationalities"),"no-body":""}},[r("b-table-simple",{staticClass:"bg-white mb-0",attrs:{hover:"",responsive:""}},[r("b-thead",[r("b-tr",[r("b-th",[t._v(t._s(t.$t("app.country")))]),t._v(" "),r("b-th",{staticClass:"text-right"},[t._v(t._s(t.$t("app.quantity")))]),t._v(" "),r("b-th",{staticClass:"text-right"},[t._v(t._s(t.$t("app.percentage")))])],1)],1),t._v(" "),r("b-tbody",t._l(t.borrwer_nationalities,(function(e){return r("b-tr",{key:e.nationality},[r("b-td",[t._v(t._s(e.nationality?e.nationality:t.$t("app.unspecified")))]),t._v(" "),r("b-td",{staticClass:"text-right"},[t._v(t._s(e.quantity))]),t._v(" "),r("b-td",{staticClass:"text-right"},[t._v(t._s(t.roundWithDecimals(e.quantity/t.borrwer_count*100,1))+" %")])],1)})),1)],1)],1),t._v(" "),r("b-card",{staticClass:"shadow-sm mb-4",attrs:{header:t.$t("people.gender"),"no-body":""}},[r("b-table-simple",{staticClass:"bg-white mb-0",attrs:{hover:"",responsive:""}},[r("b-thead",[r("b-tr",[r("b-th",[t._v(t._s(t.$t("people.gender")))]),t._v(" "),r("b-th",{staticClass:"text-right"},[t._v(t._s(t.$t("app.quantity")))]),t._v(" "),r("b-th",{staticClass:"text-right"},[t._v(t._s(t.$t("app.percentage")))])],1)],1),t._v(" "),r("b-tbody",t._l(t.borrwer_genders,(function(e){return r("b-tr",{key:e.gender},[r("b-td",[r("gender-label",{attrs:{value:e.gender,"icon-only":""}})],1),t._v(" "),r("b-td",{staticClass:"text-right"},[t._v(t._s(e.quantity))]),t._v(" "),r("b-td",{staticClass:"text-right"},[t._v(t._s(t.roundWithDecimals(e.quantity/t.borrwer_count*100,1))+" %")])],1)})),1)],1)],1)]:t._e()],2),t._v(" "),r("b-col",{attrs:{md:""}},[r("h2",[t._v("\n            "+t._s(t.$t("library.books"))+"\n            "),r("small",[t._v(t._s(t.book_count))])]),t._v(" "),r("p",[r("strong",[t._v(t._s(t.$t("library.currently_borrowed"))+":")]),t._v(" "+t._s(t.books_currently_borrowed_count)+"\n            "),t.books_currently_borrowed_count>0?[r("strong",[t._v(t._s(t.$t("library.overdue"))+":")]),t._v("\n                "+t._s(t.books_currently_overdue_count)+"\n                ("+t._s(t.roundWithDecimals(t.books_currently_overdue_count/t.books_currently_borrowed_count*100,1))+" %)\n            ")]:t._e(),t._v(" "),r("br"),t._v(" "),r("strong",[t._v(t._s(t.$t("library.books_lent"))+":")]),t._v("\n            "+t._s(t.book_lendings_unique_count)+" ("+t._s(t.$t("library.percentage_of_all_books",{percentage:t.roundWithDecimals(t.book_lendings_unique_count/t.book_count*100,1)}))+")"),r("br"),t._v(" "),r("strong",[t._v(t._s(t.$t("library.number_of_times_book_lent"))+":")]),t._v("\n            "+t._s(t.book_lendings_all_count)+"\n        ")],2),t._v(" "),t.book_lendings_top.length>0?[r("b-card",{staticClass:"shadow-sm mb-4",attrs:{header:t.$t("app.popular"),"no-body":""}},[r("b-table-simple",{staticClass:"bg-white mb-0",attrs:{hover:"",responsive:""}},[r("b-thead",[r("b-tr",[r("b-th",[t._v(t._s(t.$t("app.title")))]),t._v(" "),r("b-th",[t._v(t._s(t.$t("library.author")))]),t._v(" "),r("b-th",[t._v(t._s(t.$t("app.language")))]),t._v(" "),r("b-th",{staticClass:"text-right"},[t._v("# "+t._s(t.$t("library.lendings")))])],1)],1),t._v(" "),r("b-tbody",t._l(t.book_lendings_top,(function(e,n){return r("b-tr",{key:n},[r("b-td",{domProps:{innerHTML:t._s(t.truncate(e.title,40))}}),t._v(" "),r("b-td",{domProps:{innerHTML:t._s(t.truncate(e.author,40))}}),t._v(" "),r("b-td",[t._v(t._s(e.language))]),t._v(" "),r("b-td",{staticClass:"text-right"},[t._v(t._s(e.quantity))])],1)})),1)],1)],1)]:t._e(),t._v(" "),t.book_count>0?[t.book_languages_undefined_count>0?r("p",[r("em",[t._v(t._s(t.$t("library.books_without_language_specified",{count:t.book_languages_undefined_count,percentage:t.roundWithDecimals(t.book_languages_undefined_count/t.book_count*100,1)})))])]):t._e(),t._v(" "),r("b-card",{staticClass:"shadow-sm mb-4",attrs:{header:t.$t("app.languages"),"no-body":""}},[r("b-table-simple",{staticClass:"bg-white mb-0",attrs:{hover:"",responsive:""}},[r("b-thead",[r("b-tr",[r("b-th",[t._v(t._s(t.$t("app.language")))]),t._v(" "),r("b-th",{staticClass:"text-right"},[t._v(t._s(t.$t("app.quantity")))]),t._v(" "),r("b-th",{staticClass:"text-right"},[t._v(t._s(t.$t("app.percentage")))])],1)],1),t._v(" "),r("b-tbody",t._l(t.book_languages_defined,(function(e){return r("b-tr",{key:e.language},[r("b-td",[t._v(t._s(e.language?e.language:t.$t("app.unspecified")))]),t._v(" "),r("b-td",{staticClass:"text-right"},[t._v(t._s(e.quantity))]),t._v(" "),r("b-td",{staticClass:"text-right"},[t._v(t._s(t.roundWithDecimals(e.quantity/(t.book_count-t.book_languages_undefined_count)*100,1))+" %")])],1)})),1)],1)],1)]:t._e()],2)],1):r("p",[t._v("\n    "+t._s(t.$t("app.loading"))+"\n")])}),[],!1,null,null,null).exports,$={props:{header:{type:String},headerAddon:{required:!1,type:String},items:{required:!0,type:Array},loading:Boolean,error:{required:!1,type:String}}},C=Object(g.a)($,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("b-card",{staticClass:"mb-4",attrs:{"no-body":!t.loading,header:t.loading?t.header:null}},[!t.loading&&t.header?r("b-card-header",{attrs:{"header-class":"d-flex justify-content-between align-items-center"}},[r("span",[t._v(t._s(t.header))]),t._v(" "),t.headerAddon?r("small",[t._v(t._s(t.headerAddon))]):t._e()]):t._e(),t._v(" "),t.error?r("b-card-text",[t.error?r("em",{staticClass:"text-danger"},[t._v(t._s(t.error))]):t._e()]):t.loading?r("b-card-text",[r("em",[t._v(t._s(t.$t("app.loading")))])]):[r("b-list-group",{attrs:{flush:""}},t._l(t.items,(function(e){return r("b-list-group-item",{key:e.name,staticClass:"d-flex justify-content-between"},[r("span",[t._v(t._s(e.name))]),t._v(" "),r("span",[t._v(t._s(e.value))])])})),1)]],2)}),[],!1,null,null,null).exports,D=r("slm/"),R={mixins:[D.a],props:{header:{required:!0,type:String},items:{required:!0,type:Array},limit:{requireD:!1,type:Number,default:10},loading:Boolean,error:{required:!1,type:String}},data:function(){return{topTen:!0}},computed:{totalAmount:function(){return this.items.reduce((function(t,e){return t+e.amount}),0)},selectedItems:function(){return this.topTen?this.items.slice(0,this.limit):this.items},unselectedItemsAmount:function(){return this.topTen?this.items.slice(this.limit).reduce((function(t,e){return t+e.amount}),0):0}}},E=Object(g.a)(R,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("b-card",{staticClass:"mb-4",attrs:{"no-body":!t.loading&&t.items.length>0,header:t.loading||0==t.items.length?t.header:null}},[t.error?r("b-card-text",[t.error?r("em",{staticClass:"text-danger"},[t._v(t._s(t.error))]):t._e()]):t.loading?r("b-card-text",[r("em",[t._v(t._s(t.$t("app.loading")))])]):0==t.items.length?r("b-card-text",[r("em",[t._v(t._s(t.$t("app.no_data_registered")))])]):[r("b-card-header",{attrs:{"header-class":"d-flex justify-content-between"}},[r("span",[t._v(t._s(t.header))]),t._v(" "),t.items.length>this.limit?r("a",{attrs:{href:"javascript:;"},on:{click:function(e){t.topTen=!t.topTen}}},[t._v("\n                "+t._s(t.topTen?t.$t("app.show_all_x",{num:t.items.length}):t.$t("app.shop_top_x",{num:t.limit}))+"\n            ")]):t._e()]),t._v(" "),r("b-list-group",{attrs:{flush:""}},[t._l(t.selectedItems,(function(e){return r("b-list-group-item",{key:e.name,staticClass:"d-flex justify-content-between align-items-center"},[r("span",[t._v(t._s(e.name))]),t._v(" "),r("span",[t._v("\n                    "+t._s(e.amount)+"  \n                    "),r("small",{staticClass:"text-muted"},[t._v(t._s(t.roundWithDecimals(e.amount/t.totalAmount*100,1))+"%")])])])})),t._v(" "),t.topTen&&t.items.length>t.limit?r("b-list-group-item",{staticClass:"d-flex justify-content-between align-items-center",attrs:{href:"javascript:;"},on:{click:function(e){t.topTen=!t.topTen}}},[r("em",[t._v(t._s(t.$t("app.others")))]),t._v(" "),r("span",[t._v("\n                    "+t._s(t.unselectedItemsAmount)+"  \n                    "),r("small",{staticClass:"text-muted"},[t._v(t._s(t.roundWithDecimals(t.unselectedItemsAmount/t.totalAmount*100,1))+"%")])])]):t._e()],2)]],2)}),[],!1,null,null,null).exports,j=r("H8ri"),A=j.d.reactiveProp,q={extends:j.a,mixins:[A],props:{options:{type:Object,required:!0}},mounted:function(){this.renderChart(this.chartData,this.options)}},T=Object(g.a)(q,void 0,void 0,!1,null,null,null).exports,O=j.d.reactiveProp,Y={extends:j.c,mixins:[O],props:{options:{type:Object,required:!0}},mounted:function(){this.renderChart(this.chartData,this.options)}},S=Object(g.a)(Y,void 0,void 0,!1,null,null,null).exports,M=r("NmYn"),L=r.n(M);function P(t,e){return function(t){if(Array.isArray(t))return t}(t)||function(t,e){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(t)))return;var r=[],n=!0,a=!1,o=void 0;try{for(var s,i=t[Symbol.iterator]();!(n=(s=i.next()).done)&&(r.push(s.value),!e||r.length!==e);n=!0);}catch(t){a=!0,o=t}finally{try{n||null==i.return||i.return()}finally{if(a)throw o}}return r}(t,e)||W(t,e)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function W(t,e){if(t){if("string"==typeof t)return F(t,e);var r=Object.prototype.toString.call(t).slice(8,-1);return"Object"===r&&t.constructor&&(r=t.constructor.name),"Map"===r||"Set"===r?Array.from(t):"Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r)?F(t,e):void 0}}function F(t,e){(null==e||e>t.length)&&(e=t.length);for(var r=0,n=new Array(e);r<e;r++)n[r]=t[r];return n}function I(t,e,r,n,a,o,s){try{var i=t[o](s),u=i.value}catch(t){return void r(t)}i.done?e(u):Promise.resolve(u).then(n,a)}var G={components:{ReactiveBarChart:T,ReactiveLineChart:S},mixins:[D.a],props:{title:{type:String,required:!0},data:{type:[Function,Object],required:!1},error:{type:String,required:!1},dateFrom:{type:String,required:!0},dateTo:{type:String,required:!0},granularity:{type:String,required:!1,value:"days"},height:{type:Number,required:!1,default:350},cumulative:Boolean},data:function(){return{loaded:!1,asyncError:null,chartData:{},units:new Map}},computed:{options:function(){var t,e,r,n=this;switch(this.granularity){case"years":t="year",e="YYYY",r="YYYY";break;case"months":t="month",e="MMMM YYYY",r="YYYY-MM";break;case"weeks":t="week",e="[W]WW GGGG",r=void 0;break;default:t="day",e="dddd, LL",r="YYYY-MM-DD"}return{title:{display:!0,text:this.title},legend:{display:!0,position:"bottom"},scales:{xAxes:[{display:!0,type:"time",time:{tooltipFormat:e,unit:t,parser:r,minUnit:"day",isoWeekday:!0,displayFormats:{day:"ll",week:"[W]WW GGGG"}},ticks:{min:this.dateFrom,max:this.dateTo},gridLines:{display:!0},scaleLabel:{display:!0,labelString:this.$t("app.date")}}],yAxes:this.yAxes()},responsive:!0,maintainAspectRatio:!1,animation:{duration:500},tooltips:{callbacks:{label:function(t,e){var r=e.datasets[t.datasetIndex].label||"";return"".concat(r,": ").concat(n.numberFormat(t.yLabel))}}}}}},watch:{granularity:function(){this.loadData()},dateFrom:function(){this.loadData()},dateTo:function(){this.loadData()},data:function(){this.loadData()}},mounted:function(){_.a.locale(this.$i18n.locale),this.loadData()},methods:{loadData:function(){var t,e=this;return(t=c.a.mark((function t(){var r;return c.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:if(e.asyncError=null,e.loaded=!1,!e.data){t.next=18;break}if(t.prev=3,"function"!=typeof e.data){t.next=10;break}return t.next=7,e.data(e.granularity,e.dateFrom,e.dateTo);case 7:r=t.sent,t.next=11;break;case 10:r=e.data;case 11:e.chartData=e.chartDataFromResponse(r),e.loaded=!0,t.next=18;break;case 15:t.prev=15,t.t0=t.catch(3),e.asyncError=t.t0;case 18:case"end":return t.stop()}}),t,null,[[3,15]])})),function(){var e=this,r=arguments;return new Promise((function(n,a){var o=t.apply(e,r);function s(t){I(o,n,a,s,i,"next",t)}function i(t){I(o,n,a,s,i,"throw",t)}s(void 0)}))})()},chartDataFromResponse:function(t){var e=this,r={labels:t.labels,datasets:[]},n=new Map;return t.datasets.forEach((function(t){var a=L()(t.unit),o=t.data;if(e.cumulative)for(var s=0,i=0;i<o.length;i++)o[i]&&(o[i]+=s,s=o[i]);r.datasets.push({label:t.label,data:o,yAxisID:a}),n.set(a,t.unit)})),this.units=n,Object(y.a)(r.datasets),r},yAxes:function(){var t,e=[],r=0,n=function(t,e){var r;if("undefined"==typeof Symbol||null==t[Symbol.iterator]){if(Array.isArray(t)||(r=W(t))||e&&t&&"number"==typeof t.length){r&&(t=r);var n=0,a=function(){};return{s:a,n:function(){return n>=t.length?{done:!0}:{done:!1,value:t[n++]}},e:function(t){throw t},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var o,s=!0,i=!1;return{s:function(){r=t[Symbol.iterator]()},n:function(){var t=r.next();return s=t.done,t},e:function(t){i=!0,o=t},f:function(){try{s||null==r.return||r.return()}finally{if(i)throw o}}}}(this.units);try{for(n.s();!(t=n.n()).done;){var a=P(t.value,2),o=a[0],s=a[1];e.push({display:!0,id:o,position:r++%2==1?"right":"left",gridLines:{display:!0},scaleLabel:{display:!0,labelString:s},ticks:{suggestedMin:0,precision:0,callback:this.numberFormat}})}}catch(t){n.e(t)}finally{n.f()}return e}}},H=Object(g.a)(G,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return t.asyncError||t.error||!t.loaded?r("div",{staticClass:"d-flex border",style:"height: "+t.height+"px"},[r("p",{staticClass:"justify-content-center align-self-center text-center w-100"},[t.asyncError||t.error?r("em",{staticClass:"text-danger"},[t._v(t._s(t.asyncError)+" "+t._s(t.error))]):r("em",[t._v(t._s(t.$t("app.loading")))])])]):r(t.cumulative?"reactive-line-chart":"reactive-bar-chart",{tag:"component",staticClass:"border",attrs:{"chart-data":t.chartData,options:t.options,height:t.height}})}),[],!1,null,null,null).exports,N=r("CN0g"),B=r("ihdb"),J=r("OJ8O");function U(t,e,r,n,a,o,s){try{var i=t[o](s),u=i.value}catch(t){return void r(t)}i.done?e(u):Promise.resolve(u).then(n,a)}function X(t){return function(){var e=this,r=arguments;return new Promise((function(n,a){var o=t.apply(e,r);function s(t){U(o,n,a,s,i,"next",t)}function i(t){U(o,n,a,s,i,"throw",t)}s(void 0)}))}}var Z={getCount:function(t){return X(c.a.mark((function e(){var r;return c.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return r="".concat(Object(J.c)("api.fundraising.report.donors.count"),"?date=").concat(t),e.next=3,J.a.get(r);case 3:return e.abrupt("return",e.sent);case 4:case"end":return e.stop()}}),e)})))()},getCountries:function(t){return X(c.a.mark((function e(){var r;return c.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return r="".concat(Object(J.c)("api.fundraising.report.donors.countries"),"?date=").concat(t),e.next=3,J.a.get(r);case 3:return e.abrupt("return",e.sent);case 4:case"end":return e.stop()}}),e)})))()},getLanguages:function(t){return X(c.a.mark((function e(){var r;return c.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return r="".concat(Object(J.c)("api.fundraising.report.donors.languages"),"?date=").concat(t),e.next=3,J.a.get(r);case 3:return e.abrupt("return",e.sent);case 4:case"end":return e.stop()}}),e)})))()},fetchDonorRegistrations:function(t,e,r){return X(c.a.mark((function n(){var a,o;return c.a.wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return a={granularity:t,from:e,to:r},o=Object(J.c)("api.fundraising.report.donors.registrations",a),n.next=4,J.a.get(o);case 4:return n.abrupt("return",n.sent);case 5:case"end":return n.stop()}}),n)})))()},fetchDonationRegistrations:function(t,e,r){return X(c.a.mark((function n(){var a,o;return c.a.wrap((function(n){for(;;)switch(n.prev=n.next){case 0:return a={granularity:t,from:e,to:r},o=Object(J.c)("api.fundraising.report.donations.registrations",a),n.next=4,J.a.get(o);case 4:return n.abrupt("return",n.sent);case 5:case"end":return n.stop()}}),n)})))()},fechCurrencyDistribution:function(){return X(c.a.mark((function t(){var e;return c.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e=Object(J.c)("api.fundraising.report.donations.currencies"),t.next=3,J.a.get(e);case 3:return t.abrupt("return",t.sent);case 4:case"end":return t.stop()}}),t)})))()},fetchChannelDistribution:function(){return X(c.a.mark((function t(){var e;return c.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return e=Object(J.c)("api.fundraising.report.donations.channels"),t.next=3,J.a.get(e);case 3:return t.abrupt("return",t.sent);case 4:case"end":return t.stop()}}),t)})))()}};function V(t,e,r,n,a,o,s){try{var i=t[o](s),u=i.value}catch(t){return void r(t)}i.done?e(u):Promise.resolve(u).then(n,a)}function K(t){return function(){var e=this,r=arguments;return new Promise((function(n,a){var o=t.apply(e,r);function s(t){V(o,n,a,s,i,"next",t)}function i(t){V(o,n,a,s,i,"throw",t)}s(void 0)}))}}var Q={components:{SimpleTwoColumnListCard:C,AdvancedTwoColumnListCard:E,TimeBarChart:H,DoughnutChartTableDistributionWidget:N.a,DateRangeSelect:B.a},data:function(){return{firstDonorRegistration:null,count:null,countError:null,countries:null,countriesError:null,languages:null,languagesError:null,donationRegistrations:null,donationRegistrationsError:null,dateRange:{from:_()().subtract(3,"months").format(_.a.HTML5_FMT.DATE),to:_()().format(_.a.HTML5_FMT.DATE),granularity:"days"},reportApi:Z}},watch:{dateRange:function(){this.loadData()}},created:function(){this.loadData()},methods:{loadData:function(){this.loadCount(),this.loadCountries(),this.loadLanguages(),this.fetchDonationRegistrations()},loadCount:function(){var t=this;return K(c.a.mark((function e(){var r;return c.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.countError=null,e.prev=1,e.next=4,Z.getCount(t.dateRange.to);case 4:r=e.sent,t.count=t.mapCountData(r),e.next=11;break;case 8:e.prev=8,e.t0=e.catch(1),t.countError=e.t0;case 11:case"end":return e.stop()}}),e,null,[[1,8]])})))()},mapCountData:function(t){return this.firstDonorRegistration=_()(t.first).format("LL"),[{name:this.$t("app.total"),value:t.total},{name:this.$t("app.individual_persons"),value:t.persons},{name:this.$t("app.companies"),value:t.companies},{name:this.$t("app.with_registered_address"),value:t.with_address},{name:this.$t("app.with_registered_email"),value:t.with_email},{name:this.$t("app.with_registered_phone"),value:t.with_phone}]},loadCountries:function(){var t=this;return K(c.a.mark((function e(){var r;return c.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.countriesError=null,e.prev=1,e.next=4,Z.getCountries(t.dateRange.to);case 4:r=e.sent,t.countries=r,e.next=11;break;case 8:e.prev=8,e.t0=e.catch(1),t.countriesError=e.t0;case 11:case"end":return e.stop()}}),e,null,[[1,8]])})))()},loadLanguages:function(){var t=this;return K(c.a.mark((function e(){var r;return c.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.languagesError=null,e.prev=1,e.next=4,Z.getLanguages(t.dateRange.to);case 4:r=e.sent,t.languages=r,e.next=11;break;case 8:e.prev=8,e.t0=e.catch(1),t.languagesError=e.t0;case 11:case"end":return e.stop()}}),e,null,[[1,8]])})))()},fetchDonationRegistrations:function(){var t=this;return K(c.a.mark((function e(){var r;return c.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.donationRegistrationsError=null,e.prev=1,e.next=4,Z.fetchDonationRegistrations(t.granularity,t.dateRange.from,t.dateRange.to);case 4:r=e.sent,t.donationRegistrations=r,e.next=11;break;case 8:e.prev=8,e.t0=e.catch(1),t.donationRegistrationsError=e.t0;case 11:case"end":return e.stop()}}),e,null,[[1,8]])})))()}}},z=Object(g.a)(Q,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[r("date-range-select",{model:{value:t.dateRange,callback:function(e){t.dateRange=e},expression:"dateRange"}}),t._v(" "),r("h2",[t._v("\n        "+t._s(t.$t("fundraising.donors"))+"\n    ")]),t._v(" "),r("div",{staticClass:"row"},[r("div",{staticClass:"col-md"},[r("simple-two-column-list-card",{attrs:{header:t.$t("fundraising.registered_donors"),headerAddon:t.$t("app.since_date",{date:t.firstDonorRegistration}),items:t.count?t.count:[],loading:!t.count,error:t.countError}})],1),t._v(" "),r("div",{staticClass:"col-md"},[r("advanced-two-column-list-card",{attrs:{header:t.$t("app.countries"),items:t.countries?t.countries:[],limit:5,loading:!t.countries,error:t.countriesError}})],1),t._v(" "),r("div",{staticClass:"col-md"},[r("advanced-two-column-list-card",{attrs:{header:t.$t("app.languages"),items:t.languages?t.languages:[],limit:5,loading:!t.languages,error:t.languagesError}})],1)]),t._v(" "),r("time-bar-chart",{staticClass:"mb-3",attrs:{title:t.$t("fundraising.new_donors_registered"),data:t.reportApi.fetchDonorRegistrations,"date-from":this.dateRange.from,"date-to":this.dateRange.to,granularity:this.dateRange.granularity}}),t._v(" "),r("h2",[t._v("\n        "+t._s(t.$t("fundraising.donations"))+"\n    ")]),t._v(" "),r("time-bar-chart",{staticClass:"mb-3",attrs:{title:t.$t("fundraising.donations_made"),data:t.donationRegistrations,error:t.donationRegistrationsError,"date-from":this.dateRange.from,"date-to":this.dateRange.to,granularity:this.dateRange.granularity}}),t._v(" "),r("time-bar-chart",{staticClass:"mb-3",attrs:{title:t.$t("fundraising.total_donations_made"),data:t.donationRegistrations,error:t.donationRegistrationsError,"date-from":this.dateRange.from,"date-to":this.dateRange.to,granularity:this.dateRange.granularity,cumulative:!0}}),t._v(" "),r("b-row",[r("b-col",{attrs:{md:""}},[r("doughnut-chart-table-distribution-widget",{attrs:{title:t.$t("fundraising.currencies"),data:t.reportApi.fechCurrencyDistribution}})],1),t._v(" "),r("b-col",{attrs:{md:""}},[r("doughnut-chart-table-distribution-widget",{attrs:{title:t.$t("fundraising.channels"),data:t.reportApi.fetchChannelDistribution}})],1)],1)],1)}),[],!1,null,null,null).exports,tt=r("E4rW");a.a.use(u.a);var et=new u.a({mode:"history",base:"/reports/",routes:[{path:"/",redirect:{name:"visitors.listCurrent"}},{path:"/visitors/checkins",name:"reports.visitors.checkins",components:{default:f}},{path:"/library/books",name:"reports.library.books",components:{default:k}},{path:"/fundraising/donations",name:"reports.fundraising.donations",components:{default:z}},{path:"*",component:tt.a}]}),rt=(r("l/fe"),r("UvZm")),nt=Object(g.a)({},(function(){var t=this.$createElement,e=this._self._c||t;return e("div",[e("router-view")],1)}),[],!1,null,null,null).exports;a.a.component("font-awesome-icon",o.a),a.a.use(s.a),a.a.mixin(rt.a),a.a.config.productionTip=!1,new a.a({el:"#reports-app",router:et,i18n:i.a,components:{ReportsApp:nt}})}},[[4,0,1]]]);
//# sourceMappingURL=reports.js.map