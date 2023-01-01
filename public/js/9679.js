/*! For license information please see 9679.js.LICENSE.txt */
"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[9679],{7101:(t,r,e)=>{e.d(r,{Z:()=>s});var n=e(4015),o=e.n(n),a=e(3645),i=e.n(a)()(o());i.push([t.id,".tr-selected{background-color:rgba(0,0,255,.2);border:1px dashed #444;color:blue;font-weight:600}","",{version:3,sources:["webpack://./resources/js/Pages/Inventario/Components/RegistrosComponent.vue"],names:[],mappings:"AA+JA,aACA,iCAAA,CACA,sBAAA,CACA,UAAA,CACA,eACA",sourcesContent:['<template>\r\n    <v-dialog v-model="dialog" fullscreen scrollable>\r\n        <template v-slot:activator="{ on, attrs }">\r\n            <v-btn block v-bind="attrs" v-on="on">\r\n                Mis Registros <v-icon right>mdi-format-list-checks</v-icon>\r\n            </v-btn>\r\n        </template>\r\n\r\n        <v-card tile>\r\n            <v-toolbar>\r\n                <v-app-bar-nav-icon @click="dialog = false">\r\n                    <v-icon>mdi-arrow-left</v-icon>\r\n                </v-app-bar-nav-icon>\r\n\r\n                <v-toolbar-title>Bienes Registrados</v-toolbar-title>\r\n            </v-toolbar>\r\n\r\n            <div class="text-center">\r\n                <small>*Doble toque para seleccionar</small>\r\n            </div>\r\n\r\n            <v-card-text style="height: 90vh">\r\n                <v-row class="mt-3">\r\n                    <v-col cols="12" class="pb-1 pt-0"> </v-col>\r\n                </v-row>\r\n\r\n                <v-card tile>\r\n                    <v-overlay absolute :value="loading_table">\r\n                        <v-progress-circular\r\n                            indeterminate\r\n                            size="64"\r\n                        ></v-progress-circular>\r\n                    </v-overlay>\r\n\r\n                    <v-divider></v-divider>\r\n\r\n                    <v-simple-table>\r\n                        <template v-slot:default>\r\n                            <thead class="grey lighten-3">\r\n                                <tr>\r\n                                    <th class="text-left">Inventario</th>\r\n                                    <th class="text-left">Codigo</th>\r\n                                    <th class="text-left">Descripcion</th>\r\n                                    <th class="text-left">Dependencia</th>\r\n                                    <th class="text-left">Sticker</th>\r\n                                </tr>\r\n                            </thead>\r\n                            <tbody>\r\n                                <tr\r\n                                    v-for="(item, index) in bienes_result"\r\n                                    :key="index"\r\n                                    @dblclick="onSelectColumDobleClik(item)"\r\n                                >\r\n                                    <td>\r\n                                        <template v-if="item.idbienk">\r\n                                            {{ item.idbienk }}\r\n                                        </template>\r\n                                        <template v-else>\r\n                                            <v-chip\r\n                                                small\r\n                                                class="ma-2"\r\n                                                color="green"\r\n                                                text-color="white"\r\n                                            >\r\n                                                Nuevo\r\n                                            </v-chip>\r\n                                        </template>\r\n                                    </td>\r\n                                    <td>{{ item.codigo }}</td>\r\n                                    <td>{{ item.descripcion }}</td>\r\n\r\n                                    <td>\r\n                                        <strong>{{ item.dependencia }}</strong>\r\n                                        -\r\n                                        {{ item.nombre }}\r\n                                    </td>\r\n\r\n                                    <td>\r\n                                        {{ item.corr_area }}\r\n                                        -\r\n                                        {{ item.corr_num }}\r\n                                    </td>\r\n                                </tr>\r\n                            </tbody>\r\n                        </template>\r\n                    </v-simple-table>\r\n                    <v-card-actions>\r\n                        <v-spacer></v-spacer>\r\n                        <v-pagination\r\n                            v-model="page"\r\n                            class=""\r\n                            :length="pages"\r\n                            :total-visible="5"\r\n                        ></v-pagination>\r\n                        <v-spacer></v-spacer>\r\n                    </v-card-actions>\r\n                </v-card>\r\n            </v-card-text>\r\n        </v-card>\r\n    </v-dialog>\r\n</template>\r\n<script>\r\nimport axios from "axios";\r\n\r\nexport default {\r\n    props: {\r\n        areas: Array,\r\n    },\r\n    data: () => ({\r\n        loading_table: false,\r\n        dialog: false,\r\n        bienes_result: [],\r\n        page: 1,\r\n        total_result: 0,\r\n        pages: 1,\r\n    }),\r\n    async created() {\r\n        this.loading_table = true;\r\n        this.bienes_result = await this.getBienes();\r\n        this.loading_table = false;\r\n    },\r\n\r\n    methods: {\r\n        async getBienes(page = 1) {\r\n            let res = await axios.post(\r\n                "/inventario/get-bienes-usuario?page=" + page\r\n            );\r\n            this.page = res.data.datos.current_page;\r\n            this.total_result = res.data.datos.total;\r\n            this.pages = res.data.datos.last_page;\r\n            return res.data.datos.data;\r\n        },\r\n\r\n        async onSelectColumDobleClik(item) {\r\n            item.registrado = true;\r\n            item.is_inventario = true;\r\n            this.$emit("setData", item);\r\n            this.dialog = false;\r\n        },\r\n    },\r\n    watch: {\r\n        async page(val, old_val) {\r\n            if (val == old_val) return;\r\n\r\n            this.loading_table = true;\r\n            let res = await this.getBienes(val);\r\n            this.bienes_result = res;\r\n            this.loading_table = false;\r\n        },\r\n\r\n        async dialog(val) {\r\n            if (val == false) return;\r\n            this.bienes_result = await this.getBienes();\r\n        },\r\n    },\r\n};\r\n<\/script>\r\n\r\n<style>\r\n.tr-selected {\r\n    background-color: rgba(0, 0, 255, 0.2);\r\n    border: 1px dashed #444;\r\n    color: blue;\r\n    font-weight: 600;\r\n}\r\n</style>\r\n'],sourceRoot:""}]);const s=i},9679:(t,r,e)=>{e.r(r),e.d(r,{default:()=>p});var n=e(9669),o=e.n(n);function a(t){return a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},a(t)}function i(){i=function(){return t};var t={},r=Object.prototype,e=r.hasOwnProperty,n="function"==typeof Symbol?Symbol:{},o=n.iterator||"@@iterator",s=n.asyncIterator||"@@asyncIterator",c=n.toStringTag||"@@toStringTag";function l(t,r,e){return Object.defineProperty(t,r,{value:e,enumerable:!0,configurable:!0,writable:!0}),t[r]}try{l({},"")}catch(t){l=function(t,r,e){return t[r]=e}}function u(t,r,e,n){var o=r&&r.prototype instanceof f?r:f,a=Object.create(o.prototype),i=new L(n||[]);return a._invoke=function(t,r,e){var n="suspendedStart";return function(o,a){if("executing"===n)throw new Error("Generator is already running");if("completed"===n){if("throw"===o)throw a;return E()}for(e.method=o,e.arg=a;;){var i=e.delegate;if(i){var s=x(i,e);if(s){if(s===d)continue;return s}}if("next"===e.method)e.sent=e._sent=e.arg;else if("throw"===e.method){if("suspendedStart"===n)throw n="completed",e.arg;e.dispatchException(e.arg)}else"return"===e.method&&e.abrupt("return",e.arg);n="executing";var c=v(t,r,e);if("normal"===c.type){if(n=e.done?"completed":"suspendedYield",c.arg===d)continue;return{value:c.arg,done:e.done}}"throw"===c.type&&(n="completed",e.method="throw",e.arg=c.arg)}}}(t,e,i),a}function v(t,r,e){try{return{type:"normal",arg:t.call(r,e)}}catch(t){return{type:"throw",arg:t}}}t.wrap=u;var d={};function f(){}function p(){}function h(){}var g={};l(g,o,(function(){return this}));var m=Object.getPrototypeOf,y=m&&m(m(A([])));y&&y!==r&&e.call(y,o)&&(g=y);var _=h.prototype=f.prototype=Object.create(g);function b(t){["next","throw","return"].forEach((function(r){l(t,r,(function(t){return this._invoke(r,t)}))}))}function w(t,r){function n(o,i,s,c){var l=v(t[o],t,i);if("throw"!==l.type){var u=l.arg,d=u.value;return d&&"object"==a(d)&&e.call(d,"__await")?r.resolve(d.__await).then((function(t){n("next",t,s,c)}),(function(t){n("throw",t,s,c)})):r.resolve(d).then((function(t){u.value=t,s(u)}),(function(t){return n("throw",t,s,c)}))}c(l.arg)}var o;this._invoke=function(t,e){function a(){return new r((function(r,o){n(t,e,r,o)}))}return o=o?o.then(a,a):a()}}function x(t,r){var e=t.iterator[r.method];if(void 0===e){if(r.delegate=null,"throw"===r.method){if(t.iterator.return&&(r.method="return",r.arg=void 0,x(t,r),"throw"===r.method))return d;r.method="throw",r.arg=new TypeError("The iterator does not provide a 'throw' method")}return d}var n=v(e,t.iterator,r.arg);if("throw"===n.type)return r.method="throw",r.arg=n.arg,r.delegate=null,d;var o=n.arg;return o?o.done?(r[t.resultName]=o.value,r.next=t.nextLoc,"return"!==r.method&&(r.method="next",r.arg=void 0),r.delegate=null,d):o:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,d)}function k(t){var r={tryLoc:t[0]};1 in t&&(r.catchLoc=t[1]),2 in t&&(r.finallyLoc=t[2],r.afterLoc=t[3]),this.tryEntries.push(r)}function C(t){var r=t.completion||{};r.type="normal",delete r.arg,t.completion=r}function L(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(k,this),this.reset(!0)}function A(t){if(t){var r=t[o];if(r)return r.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var n=-1,a=function r(){for(;++n<t.length;)if(e.call(t,n))return r.value=t[n],r.done=!1,r;return r.value=void 0,r.done=!0,r};return a.next=a}}return{next:E}}function E(){return{value:void 0,done:!0}}return p.prototype=h,l(_,"constructor",h),l(h,"constructor",p),p.displayName=l(h,c,"GeneratorFunction"),t.isGeneratorFunction=function(t){var r="function"==typeof t&&t.constructor;return!!r&&(r===p||"GeneratorFunction"===(r.displayName||r.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,h):(t.__proto__=h,l(t,c,"GeneratorFunction")),t.prototype=Object.create(_),t},t.awrap=function(t){return{__await:t}},b(w.prototype),l(w.prototype,s,(function(){return this})),t.AsyncIterator=w,t.async=function(r,e,n,o,a){void 0===a&&(a=Promise);var i=new w(u(r,e,n,o),a);return t.isGeneratorFunction(e)?i:i.next().then((function(t){return t.done?t.value:i.next()}))},b(_),l(_,c,"Generator"),l(_,o,(function(){return this})),l(_,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var r=[];for(var e in t)r.push(e);return r.reverse(),function e(){for(;r.length;){var n=r.pop();if(n in t)return e.value=n,e.done=!1,e}return e.done=!0,e}},t.values=A,L.prototype={constructor:L,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(C),!t)for(var r in this)"t"===r.charAt(0)&&e.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var r=this;function n(e,n){return i.type="throw",i.arg=t,r.next=e,n&&(r.method="next",r.arg=void 0),!!n}for(var o=this.tryEntries.length-1;o>=0;--o){var a=this.tryEntries[o],i=a.completion;if("root"===a.tryLoc)return n("end");if(a.tryLoc<=this.prev){var s=e.call(a,"catchLoc"),c=e.call(a,"finallyLoc");if(s&&c){if(this.prev<a.catchLoc)return n(a.catchLoc,!0);if(this.prev<a.finallyLoc)return n(a.finallyLoc)}else if(s){if(this.prev<a.catchLoc)return n(a.catchLoc,!0)}else{if(!c)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return n(a.finallyLoc)}}}},abrupt:function(t,r){for(var n=this.tryEntries.length-1;n>=0;--n){var o=this.tryEntries[n];if(o.tryLoc<=this.prev&&e.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var a=o;break}}a&&("break"===t||"continue"===t)&&a.tryLoc<=r&&r<=a.finallyLoc&&(a=null);var i=a?a.completion:{};return i.type=t,i.arg=r,a?(this.method="next",this.next=a.finallyLoc,d):this.complete(i)},complete:function(t,r){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&r&&(this.next=r),d},finish:function(t){for(var r=this.tryEntries.length-1;r>=0;--r){var e=this.tryEntries[r];if(e.finallyLoc===t)return this.complete(e.completion,e.afterLoc),C(e),d}},catch:function(t){for(var r=this.tryEntries.length-1;r>=0;--r){var e=this.tryEntries[r];if(e.tryLoc===t){var n=e.completion;if("throw"===n.type){var o=n.arg;C(e)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(t,r,e){return this.delegate={iterator:A(t),resultName:r,nextLoc:e},"next"===this.method&&(this.arg=void 0),d}},t}function s(t,r,e,n,o,a,i){try{var s=t[a](i),c=s.value}catch(t){return void e(t)}s.done?r(c):Promise.resolve(c).then(n,o)}function c(t){return function(){var r=this,e=arguments;return new Promise((function(n,o){var a=t.apply(r,e);function i(t){s(a,n,o,i,c,"next",t)}function c(t){s(a,n,o,i,c,"throw",t)}i(void 0)}))}}const l={props:{areas:Array},data:function(){return{loading_table:!1,dialog:!1,bienes_result:[],page:1,total_result:0,pages:1}},created:function(){var t=this;return c(i().mark((function r(){return i().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return t.loading_table=!0,r.next=3,t.getBienes();case 3:t.bienes_result=r.sent,t.loading_table=!1;case 5:case"end":return r.stop()}}),r)})))()},methods:{getBienes:function(){var t=arguments,r=this;return c(i().mark((function e(){var n,a;return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return n=t.length>0&&void 0!==t[0]?t[0]:1,e.next=3,o().post("/inventario/get-bienes-usuario?page="+n);case 3:return a=e.sent,r.page=a.data.datos.current_page,r.total_result=a.data.datos.total,r.pages=a.data.datos.last_page,e.abrupt("return",a.data.datos.data);case 8:case"end":return e.stop()}}),e)})))()},onSelectColumDobleClik:function(t){var r=this;return c(i().mark((function e(){return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:t.registrado=!0,t.is_inventario=!0,r.$emit("setData",t),r.dialog=!1;case 4:case"end":return e.stop()}}),e)})))()}},watch:{page:function(t,r){var e=this;return c(i().mark((function n(){var o;return i().wrap((function(n){for(;;)switch(n.prev=n.next){case 0:if(t!=r){n.next=2;break}return n.abrupt("return");case 2:return e.loading_table=!0,n.next=5,e.getBienes(t);case 5:o=n.sent,e.bienes_result=o,e.loading_table=!1;case 8:case"end":return n.stop()}}),n)})))()},dialog:function(t){var r=this;return c(i().mark((function e(){return i().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(0!=t){e.next=2;break}return e.abrupt("return");case 2:return e.next=4,r.getBienes();case 4:r.bienes_result=e.sent;case 5:case"end":return e.stop()}}),e)})))()}}};var u=e(3379),v=e.n(u),d=e(7101),f={insert:"head",singleton:!1};v()(d.Z,f);d.Z.locals;const p=(0,e(1900).Z)(l,(function(){var t=this,r=t._self._c;return r("v-dialog",{attrs:{fullscreen:"",scrollable:""},scopedSlots:t._u([{key:"activator",fn:function(e){var n=e.on,o=e.attrs;return[r("v-btn",t._g(t._b({attrs:{block:""}},"v-btn",o,!1),n),[t._v("\n            Mis Registros "),r("v-icon",{attrs:{right:""}},[t._v("mdi-format-list-checks")])],1)]}}]),model:{value:t.dialog,callback:function(r){t.dialog=r},expression:"dialog"}},[t._v(" "),r("v-card",{attrs:{tile:""}},[r("v-toolbar",[r("v-app-bar-nav-icon",{on:{click:function(r){t.dialog=!1}}},[r("v-icon",[t._v("mdi-arrow-left")])],1),t._v(" "),r("v-toolbar-title",[t._v("Bienes Registrados")])],1),t._v(" "),r("div",{staticClass:"text-center"},[r("small",[t._v("*Doble toque para seleccionar")])]),t._v(" "),r("v-card-text",{staticStyle:{height:"90vh"}},[r("v-row",{staticClass:"mt-3"},[r("v-col",{staticClass:"pb-1 pt-0",attrs:{cols:"12"}})],1),t._v(" "),r("v-card",{attrs:{tile:""}},[r("v-overlay",{attrs:{absolute:"",value:t.loading_table}},[r("v-progress-circular",{attrs:{indeterminate:"",size:"64"}})],1),t._v(" "),r("v-divider"),t._v(" "),r("v-simple-table",{scopedSlots:t._u([{key:"default",fn:function(){return[r("thead",{staticClass:"grey lighten-3"},[r("tr",[r("th",{staticClass:"text-left"},[t._v("Inventario")]),t._v(" "),r("th",{staticClass:"text-left"},[t._v("Codigo")]),t._v(" "),r("th",{staticClass:"text-left"},[t._v("Descripcion")]),t._v(" "),r("th",{staticClass:"text-left"},[t._v("Dependencia")]),t._v(" "),r("th",{staticClass:"text-left"},[t._v("Sticker")])])]),t._v(" "),r("tbody",t._l(t.bienes_result,(function(e,n){return r("tr",{key:n,on:{dblclick:function(r){return t.onSelectColumDobleClik(e)}}},[r("td",[e.idbienk?[t._v("\n                                        "+t._s(e.idbienk)+"\n                                    ")]:[r("v-chip",{staticClass:"ma-2",attrs:{small:"",color:"green","text-color":"white"}},[t._v("\n                                            Nuevo\n                                        ")])]],2),t._v(" "),r("td",[t._v(t._s(e.codigo))]),t._v(" "),r("td",[t._v(t._s(e.descripcion))]),t._v(" "),r("td",[r("strong",[t._v(t._s(e.dependencia))]),t._v("\n                                    -\n                                    "+t._s(e.nombre)+"\n                                ")]),t._v(" "),r("td",[t._v("\n                                    "+t._s(e.corr_area)+"\n                                    -\n                                    "+t._s(e.corr_num)+"\n                                ")])])})),0)]},proxy:!0}])}),t._v(" "),r("v-card-actions",[r("v-spacer"),t._v(" "),r("v-pagination",{attrs:{length:t.pages,"total-visible":5},model:{value:t.page,callback:function(r){t.page=r},expression:"page"}}),t._v(" "),r("v-spacer")],1)],1)],1)],1)],1)}),[],!1,null,null,null).exports},1900:(t,r,e)=>{function n(t,r,e,n,o,a,i,s){var c,l="function"==typeof t?t.options:t;if(r&&(l.render=r,l.staticRenderFns=e,l._compiled=!0),n&&(l.functional=!0),a&&(l._scopeId="data-v-"+a),i?(c=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),o&&o.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(i)},l._ssrRegister=c):o&&(c=s?function(){o.call(this,(l.functional?this.parent:this).$root.$options.shadowRoot)}:o),c)if(l.functional){l._injectStyles=c;var u=l.render;l.render=function(t,r){return c.call(r),u(t,r)}}else{var v=l.beforeCreate;l.beforeCreate=v?[].concat(v,c):[c]}return{exports:t,options:l}}e.d(r,{Z:()=>n})}}]);
//# sourceMappingURL=9679.js.map?id=24f483458782271e