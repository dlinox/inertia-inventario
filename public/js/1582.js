/*! For license information please see 1582.js.LICENSE.txt */
"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[1582],{2069:(t,e,r)=>{r.d(e,{Z:()=>s});var n=r(4015),o=r.n(n),i=r(3645),a=r.n(i)()(o());a.push([t.id,"@import url(https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&display=swap);"]),a.push([t.id,"*[data-v-70b42944]{font-family:Nunito,sans-serif}.main_app[data-v-70b42944]{background:#eee}.component-fade-enter-active[data-v-70b42944],.component-fade-leave-active[data-v-70b42944]{transition:opacity .3s ease}.component-fade-enter[data-v-70b42944],.component-fade-leave-to[data-v-70b42944]{opacity:0}.wrap-imagen[data-v-70b42944]{align-items:center;background-color:hsla(0,0%,100%,.3);display:flex;justify-content:center;width:100%}","",{version:3,sources:["webpack://./resources/js/Layouts/AdminLayout.vue"],names:[],mappings:"AA4JA,mBACA,6BACA,CACA,2BACA,eACA,CACA,4FAEA,2BACA,CACA,iFAEA,SACA,CACA,8BAGA,kBAAA,CAEA,mCAAA,CAJA,YAAA,CACA,sBAAA,CAEA,UAEA",sourcesContent:['<template>\r\n    <v-app>\r\n        <v-navigation-drawer app v-model="drawer" color="#01305A" dark>\r\n            <div class="wrap-imagen py-4">\r\n                <img width="80%" src="/images/logomin.png" alt="" />\r\n            </div>\r\n\r\n            <v-card flat rounded="0" color="transparent">\r\n                <v-list two-line class="py-0">\r\n                    <v-list-item>\r\n                        <v-list-item-avatar color="secondary">\r\n                            <span class="white--text headline">\r\n                                <small> AA </small>\r\n                            </span>\r\n                        </v-list-item-avatar>\r\n                        <v-list-item-content>\r\n                            <v-list-item-title>\r\n                                {{ user.nombres }}\r\n                            </v-list-item-title>\r\n                            <v-list-item-subtitle>\r\n                                {{ user.rol }}\r\n                            </v-list-item-subtitle>\r\n                        </v-list-item-content>\r\n                    </v-list-item>\r\n                </v-list>\r\n            </v-card>\r\n\r\n            <v-divider />\r\n\r\n                <menu-principal-component />\r\n\r\n            \x3c!-- <MenuFacilitadorComponent /> --\x3e\r\n\r\n            <template v-slot:append>\r\n                <v-divider></v-divider>\r\n                <v-card-text class="text-center py-1">\r\n                    <v-btn class="mx-4" icon link @click="salir">\r\n                        <v-icon size="24px" color="blue-grey lighten-4">\r\n                            mdi-power\r\n                        </v-icon>\r\n                    </v-btn>\r\n                </v-card-text>\r\n            </template>\r\n        </v-navigation-drawer>\r\n        <v-app-bar app color="white" scroll-off-screen elevation="3">\r\n            <v-app-bar-nav-icon\r\n                @click.stop="drawer = !drawer"\r\n            ></v-app-bar-nav-icon>\r\n\r\n            <v-spacer />\r\n\r\n            <v-menu offset-y>\r\n                <template v-slot:activator="{ attrs, on }">\r\n                    <v-btn\r\n                        text\r\n                        color="primary"\r\n                        class=""\r\n                        v-bind="attrs"\r\n                        v-on="on"\r\n                    >\r\n                        {{ user.nombres }}\r\n                        <v-icon right>mdi-account </v-icon>\r\n                    </v-btn>\r\n                </template>\r\n\r\n                <v-list dense>\r\n                    <v-subheader>Opciones</v-subheader>\r\n                    <v-list-item-group v-model="selectedMenu" color="primary">\r\n                        <v-list-item\r\n                            v-for="(item, i) in items"\r\n                            :key="i"\r\n                            @click="SelectMenu(item.text)"\r\n                        >\r\n                            <v-list-item-icon>\r\n                                <v-icon v-text="item.icon"></v-icon>\r\n                            </v-list-item-icon>\r\n                            <v-list-item-content>\r\n                                <v-list-item-title\r\n                                    v-text="item.text"\r\n                                ></v-list-item-title>\r\n                            </v-list-item-content>\r\n                        </v-list-item>\r\n                    </v-list-item-group>\r\n                </v-list>\r\n            </v-menu>\r\n        </v-app-bar>\r\n\r\n        <v-main class="main_app">\r\n            <transition name="component-fade" mode="out-in">\r\n                <slot />\r\n            </transition>\r\n        </v-main>\r\n        <v-footer app dark>\r\n            <v-spacer />\r\n            <h6>\r\n                \x3c!--by\r\n                <a\r\n                    href="https://www.linkedin.com/in/lino-puma-ticona-a76021202/"\r\n                    target="_blank"\r\n                    class="blue--text text-decoration-none"\r\n                    >Lino Puma</a\r\n                > --\x3e\r\n            </h6>\r\n        </v-footer>\r\n    </v-app>\r\n</template>\r\n<script>\r\nimport MenuPrincipalComponent from "@/components/MenuPrincipalComponent";\r\nimport MenuFacilitadorComponent from "@/components/MenuFacilitadorComponent";\r\n\r\nexport default {\r\n    components: {\r\n        MenuPrincipalComponent,\r\n        MenuFacilitadorComponent,\r\n    },\r\n    data: () => ({\r\n        drawer: true,\r\n        attrs: {\r\n            class: "mb-1",\r\n            boilerplate: true,\r\n            elevation: 0,\r\n            loading: false,\r\n        },\r\n\r\n        closeOnContentClick: true,\r\n\r\n        items: [\r\n            { text: "Perfil", icon: "mdi-account" },\r\n            { text: "Salir", icon: "mdi-power" },\r\n        ],\r\n        selectedMenu: null,\r\n    }),\r\n    computed: {\r\n        user() {\r\n            return this.$page.props.auth.user;\r\n        },\r\n    },\r\n    methods: {\r\n        SelectMenu(op){\r\n            if(op == \'Salir\'){\r\n                this.salir();\r\n            }\r\n        },\r\n        salir() {\r\n            this.$inertia.post("/logout");\r\n        },\r\n    },\r\n    async created() {\r\n        //await this.GetCurrentUser();\r\n\r\n        this.drawer = this.$vuetify.breakpoint.width > 960 ? true : false;\r\n    },\r\n};\r\n<\/script>\r\n<style scoped>\r\n@import url(\'https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&display=swap\');\r\n* {\r\n    font-family: \'Nunito\', sans-serif;\r\n}\r\n.main_app {\r\n    background: #eeeeee;\r\n}\r\n.component-fade-enter-active,\r\n.component-fade-leave-active {\r\n    transition: opacity 0.3s ease;\r\n}\r\n.component-fade-enter, .component-fade-leave-to\r\n/* .component-fade-leave-active below version 2.1.8 */ {\r\n    opacity: 0;\r\n}\r\n.wrap-imagen {\r\n    display: flex;\r\n    justify-content: center;\r\n    align-items: center;\r\n    width: 100%;\r\n    background-color: rgba(255,255,255,.3);\r\n}\r\n</style>\r\n'],sourceRoot:""}]);const s=a},8765:(t,e,r)=>{r.d(e,{Z:()=>p});var n=r(800),o=r(3763);function i(t){return i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},i(t)}function a(){a=function(){return t};var t={},e=Object.prototype,r=e.hasOwnProperty,n="function"==typeof Symbol?Symbol:{},o=n.iterator||"@@iterator",s=n.asyncIterator||"@@asyncIterator",c=n.toStringTag||"@@toStringTag";function l(t,e,r){return Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{l({},"")}catch(t){l=function(t,e,r){return t[e]=r}}function u(t,e,r,n){var o=e&&e.prototype instanceof p?e:p,i=Object.create(o.prototype),a=new A(n||[]);return i._invoke=function(t,e,r){var n="suspendedStart";return function(o,i){if("executing"===n)throw new Error("Generator is already running");if("completed"===n){if("throw"===o)throw i;return E()}for(r.method=o,r.arg=i;;){var a=r.delegate;if(a){var s=x(a,r);if(s){if(s===f)continue;return s}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if("suspendedStart"===n)throw n="completed",r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n="executing";var c=v(t,e,r);if("normal"===c.type){if(n=r.done?"completed":"suspendedYield",c.arg===f)continue;return{value:c.arg,done:r.done}}"throw"===c.type&&(n="completed",r.method="throw",r.arg=c.arg)}}}(t,r,a),i}function v(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(t){return{type:"throw",arg:t}}}t.wrap=u;var f={};function p(){}function d(){}function m(){}var h={};l(h,o,(function(){return this}));var y=Object.getPrototypeOf,g=y&&y(y(L([])));g&&g!==e&&r.call(g,o)&&(h=g);var _=m.prototype=p.prototype=Object.create(h);function b(t){["next","throw","return"].forEach((function(e){l(t,e,(function(t){return this._invoke(e,t)}))}))}function w(t,e){function n(o,a,s,c){var l=v(t[o],t,a);if("throw"!==l.type){var u=l.arg,f=u.value;return f&&"object"==i(f)&&r.call(f,"__await")?e.resolve(f.__await).then((function(t){n("next",t,s,c)}),(function(t){n("throw",t,s,c)})):e.resolve(f).then((function(t){u.value=t,s(u)}),(function(t){return n("throw",t,s,c)}))}c(l.arg)}var o;this._invoke=function(t,r){function i(){return new e((function(e,o){n(t,r,e,o)}))}return o=o?o.then(i,i):i()}}function x(t,e){var r=t.iterator[e.method];if(void 0===r){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=void 0,x(t,e),"throw"===e.method))return f;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return f}var n=v(r,t.iterator,e.arg);if("throw"===n.type)return e.method="throw",e.arg=n.arg,e.delegate=null,f;var o=n.arg;return o?o.done?(e[t.resultName]=o.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=void 0),e.delegate=null,f):o:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,f)}function k(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function C(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function A(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(k,this),this.reset(!0)}function L(t){if(t){var e=t[o];if(e)return e.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var n=-1,i=function e(){for(;++n<t.length;)if(r.call(t,n))return e.value=t[n],e.done=!1,e;return e.value=void 0,e.done=!0,e};return i.next=i}}return{next:E}}function E(){return{value:void 0,done:!0}}return d.prototype=m,l(_,"constructor",m),l(m,"constructor",d),d.displayName=l(m,c,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===d||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,m):(t.__proto__=m,l(t,c,"GeneratorFunction")),t.prototype=Object.create(_),t},t.awrap=function(t){return{__await:t}},b(w.prototype),l(w.prototype,s,(function(){return this})),t.AsyncIterator=w,t.async=function(e,r,n,o,i){void 0===i&&(i=Promise);var a=new w(u(e,r,n,o),i);return t.isGeneratorFunction(r)?a:a.next().then((function(t){return t.done?t.value:a.next()}))},b(_),l(_,c,"Generator"),l(_,o,(function(){return this})),l(_,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=[];for(var r in t)e.push(r);return e.reverse(),function r(){for(;e.length;){var n=e.pop();if(n in t)return r.value=n,r.done=!1,r}return r.done=!0,r}},t.values=L,A.prototype={constructor:A,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(C),!t)for(var e in this)"t"===e.charAt(0)&&r.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function n(r,n){return a.type="throw",a.arg=t,e.next=r,n&&(e.method="next",e.arg=void 0),!!n}for(var o=this.tryEntries.length-1;o>=0;--o){var i=this.tryEntries[o],a=i.completion;if("root"===i.tryLoc)return n("end");if(i.tryLoc<=this.prev){var s=r.call(i,"catchLoc"),c=r.call(i,"finallyLoc");if(s&&c){if(this.prev<i.catchLoc)return n(i.catchLoc,!0);if(this.prev<i.finallyLoc)return n(i.finallyLoc)}else if(s){if(this.prev<i.catchLoc)return n(i.catchLoc,!0)}else{if(!c)throw new Error("try statement without catch or finally");if(this.prev<i.finallyLoc)return n(i.finallyLoc)}}}},abrupt:function(t,e){for(var n=this.tryEntries.length-1;n>=0;--n){var o=this.tryEntries[n];if(o.tryLoc<=this.prev&&r.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var i=o;break}}i&&("break"===t||"continue"===t)&&i.tryLoc<=e&&e<=i.finallyLoc&&(i=null);var a=i?i.completion:{};return a.type=t,a.arg=e,i?(this.method="next",this.next=i.finallyLoc,f):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),f},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),C(r),f}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.tryLoc===t){var n=r.completion;if("throw"===n.type){var o=n.arg;C(r)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,r){return this.delegate={iterator:L(t),resultName:e,nextLoc:r},"next"===this.method&&(this.arg=void 0),f}},t}function s(t,e,r,n,o,i,a){try{var s=t[i](a),c=s.value}catch(t){return void r(t)}s.done?e(c):Promise.resolve(c).then(n,o)}const c={components:{MenuPrincipalComponent:n.Z,MenuFacilitadorComponent:o.Z},data:function(){return{drawer:!0,attrs:{class:"mb-1",boilerplate:!0,elevation:0,loading:!1},closeOnContentClick:!0,items:[{text:"Perfil",icon:"mdi-account"},{text:"Salir",icon:"mdi-power"}],selectedMenu:null}},computed:{user:function(){return this.$page.props.auth.user}},methods:{SelectMenu:function(t){"Salir"==t&&this.salir()},salir:function(){this.$inertia.post("/logout")}},created:function(){var t,e=this;return(t=a().mark((function t(){return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:e.drawer=e.$vuetify.breakpoint.width>960;case 1:case"end":return t.stop()}}),t)})),function(){var e=this,r=arguments;return new Promise((function(n,o){var i=t.apply(e,r);function a(t){s(i,n,o,a,c,"next",t)}function c(t){s(i,n,o,a,c,"throw",t)}a(void 0)}))})()}};var l=r(3379),u=r.n(l),v=r(2069),f={insert:"head",singleton:!1};u()(v.Z,f);v.Z.locals;const p=(0,r(1900).Z)(c,(function(){var t=this,e=t._self._c;return e("v-app",[e("v-navigation-drawer",{attrs:{app:"",color:"#01305A",dark:""},scopedSlots:t._u([{key:"append",fn:function(){return[e("v-divider"),t._v(" "),e("v-card-text",{staticClass:"text-center py-1"},[e("v-btn",{staticClass:"mx-4",attrs:{icon:"",link:""},on:{click:t.salir}},[e("v-icon",{attrs:{size:"24px",color:"blue-grey lighten-4"}},[t._v("\n                        mdi-power\n                    ")])],1)],1)]},proxy:!0}]),model:{value:t.drawer,callback:function(e){t.drawer=e},expression:"drawer"}},[e("div",{staticClass:"wrap-imagen py-4"},[e("img",{attrs:{width:"80%",src:"/images/logomin.png",alt:""}})]),t._v(" "),e("v-card",{attrs:{flat:"",rounded:"0",color:"transparent"}},[e("v-list",{staticClass:"py-0",attrs:{"two-line":""}},[e("v-list-item",[e("v-list-item-avatar",{attrs:{color:"secondary"}},[e("span",{staticClass:"white--text headline"},[e("small",[t._v(" AA ")])])]),t._v(" "),e("v-list-item-content",[e("v-list-item-title",[t._v("\n                            "+t._s(t.user.nombres)+"\n                        ")]),t._v(" "),e("v-list-item-subtitle",[t._v("\n                            "+t._s(t.user.rol)+"\n                        ")])],1)],1)],1)],1),t._v(" "),e("v-divider"),t._v(" "),e("menu-principal-component")],1),t._v(" "),e("v-app-bar",{attrs:{app:"",color:"white","scroll-off-screen":"",elevation:"3"}},[e("v-app-bar-nav-icon",{on:{click:function(e){e.stopPropagation(),t.drawer=!t.drawer}}}),t._v(" "),e("v-spacer"),t._v(" "),e("v-menu",{attrs:{"offset-y":""},scopedSlots:t._u([{key:"activator",fn:function(r){var n=r.attrs,o=r.on;return[e("v-btn",t._g(t._b({attrs:{text:"",color:"primary"}},"v-btn",n,!1),o),[t._v("\n                    "+t._s(t.user.nombres)+"\n                    "),e("v-icon",{attrs:{right:""}},[t._v("mdi-account ")])],1)]}}])},[t._v(" "),e("v-list",{attrs:{dense:""}},[e("v-subheader",[t._v("Opciones")]),t._v(" "),e("v-list-item-group",{attrs:{color:"primary"},model:{value:t.selectedMenu,callback:function(e){t.selectedMenu=e},expression:"selectedMenu"}},t._l(t.items,(function(r,n){return e("v-list-item",{key:n,on:{click:function(e){return t.SelectMenu(r.text)}}},[e("v-list-item-icon",[e("v-icon",{domProps:{textContent:t._s(r.icon)}})],1),t._v(" "),e("v-list-item-content",[e("v-list-item-title",{domProps:{textContent:t._s(r.text)}})],1)],1)})),1)],1)],1)],1),t._v(" "),e("v-main",{staticClass:"main_app"},[e("transition",{attrs:{name:"component-fade",mode:"out-in"}},[t._t("default")],2)],1),t._v(" "),e("v-footer",{attrs:{app:"",dark:""}},[e("v-spacer"),t._v(" "),e("h6")],1)],1)}),[],!1,null,"70b42944",null).exports},1582:(t,e,r)=>{r.r(e),r.d(e,{default:()=>p});var n=r(8765),o=r(9680);function i(t){return i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},i(t)}function a(){a=function(){return t};var t={},e=Object.prototype,r=e.hasOwnProperty,n="function"==typeof Symbol?Symbol:{},o=n.iterator||"@@iterator",s=n.asyncIterator||"@@asyncIterator",c=n.toStringTag||"@@toStringTag";function l(t,e,r){return Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{l({},"")}catch(t){l=function(t,e,r){return t[e]=r}}function u(t,e,r,n){var o=e&&e.prototype instanceof p?e:p,i=Object.create(o.prototype),a=new A(n||[]);return i._invoke=function(t,e,r){var n="suspendedStart";return function(o,i){if("executing"===n)throw new Error("Generator is already running");if("completed"===n){if("throw"===o)throw i;return E()}for(r.method=o,r.arg=i;;){var a=r.delegate;if(a){var s=x(a,r);if(s){if(s===f)continue;return s}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if("suspendedStart"===n)throw n="completed",r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n="executing";var c=v(t,e,r);if("normal"===c.type){if(n=r.done?"completed":"suspendedYield",c.arg===f)continue;return{value:c.arg,done:r.done}}"throw"===c.type&&(n="completed",r.method="throw",r.arg=c.arg)}}}(t,r,a),i}function v(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(t){return{type:"throw",arg:t}}}t.wrap=u;var f={};function p(){}function d(){}function m(){}var h={};l(h,o,(function(){return this}));var y=Object.getPrototypeOf,g=y&&y(y(L([])));g&&g!==e&&r.call(g,o)&&(h=g);var _=m.prototype=p.prototype=Object.create(h);function b(t){["next","throw","return"].forEach((function(e){l(t,e,(function(t){return this._invoke(e,t)}))}))}function w(t,e){function n(o,a,s,c){var l=v(t[o],t,a);if("throw"!==l.type){var u=l.arg,f=u.value;return f&&"object"==i(f)&&r.call(f,"__await")?e.resolve(f.__await).then((function(t){n("next",t,s,c)}),(function(t){n("throw",t,s,c)})):e.resolve(f).then((function(t){u.value=t,s(u)}),(function(t){return n("throw",t,s,c)}))}c(l.arg)}var o;this._invoke=function(t,r){function i(){return new e((function(e,o){n(t,r,e,o)}))}return o=o?o.then(i,i):i()}}function x(t,e){var r=t.iterator[e.method];if(void 0===r){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=void 0,x(t,e),"throw"===e.method))return f;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return f}var n=v(r,t.iterator,e.arg);if("throw"===n.type)return e.method="throw",e.arg=n.arg,e.delegate=null,f;var o=n.arg;return o?o.done?(e[t.resultName]=o.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=void 0),e.delegate=null,f):o:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,f)}function k(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function C(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function A(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(k,this),this.reset(!0)}function L(t){if(t){var e=t[o];if(e)return e.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var n=-1,i=function e(){for(;++n<t.length;)if(r.call(t,n))return e.value=t[n],e.done=!1,e;return e.value=void 0,e.done=!0,e};return i.next=i}}return{next:E}}function E(){return{value:void 0,done:!0}}return d.prototype=m,l(_,"constructor",m),l(m,"constructor",d),d.displayName=l(m,c,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===d||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,m):(t.__proto__=m,l(t,c,"GeneratorFunction")),t.prototype=Object.create(_),t},t.awrap=function(t){return{__await:t}},b(w.prototype),l(w.prototype,s,(function(){return this})),t.AsyncIterator=w,t.async=function(e,r,n,o,i){void 0===i&&(i=Promise);var a=new w(u(e,r,n,o),i);return t.isGeneratorFunction(r)?a:a.next().then((function(t){return t.done?t.value:a.next()}))},b(_),l(_,c,"Generator"),l(_,o,(function(){return this})),l(_,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=[];for(var r in t)e.push(r);return e.reverse(),function r(){for(;e.length;){var n=e.pop();if(n in t)return r.value=n,r.done=!1,r}return r.done=!0,r}},t.values=L,A.prototype={constructor:A,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(C),!t)for(var e in this)"t"===e.charAt(0)&&r.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function n(r,n){return a.type="throw",a.arg=t,e.next=r,n&&(e.method="next",e.arg=void 0),!!n}for(var o=this.tryEntries.length-1;o>=0;--o){var i=this.tryEntries[o],a=i.completion;if("root"===i.tryLoc)return n("end");if(i.tryLoc<=this.prev){var s=r.call(i,"catchLoc"),c=r.call(i,"finallyLoc");if(s&&c){if(this.prev<i.catchLoc)return n(i.catchLoc,!0);if(this.prev<i.finallyLoc)return n(i.finallyLoc)}else if(s){if(this.prev<i.catchLoc)return n(i.catchLoc,!0)}else{if(!c)throw new Error("try statement without catch or finally");if(this.prev<i.finallyLoc)return n(i.finallyLoc)}}}},abrupt:function(t,e){for(var n=this.tryEntries.length-1;n>=0;--n){var o=this.tryEntries[n];if(o.tryLoc<=this.prev&&r.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var i=o;break}}i&&("break"===t||"continue"===t)&&i.tryLoc<=e&&e<=i.finallyLoc&&(i=null);var a=i?i.completion:{};return a.type=t,a.arg=e,i?(this.method="next",this.next=i.finallyLoc,f):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),f},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),C(r),f}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.tryLoc===t){var n=r.completion;if("throw"===n.type){var o=n.arg;C(r)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,r){return this.delegate={iterator:L(t),resultName:e,nextLoc:r},"next"===this.method&&(this.arg=void 0),f}},t}function s(t,e,r,n,o,i,a){try{var s=t[i](a),c=s.value}catch(t){return void r(t)}s.done?e(c):Promise.resolve(c).then(n,o)}function c(t){return function(){var e=this,r=arguments;return new Promise((function(n,o){var i=t.apply(e,r);function a(t){s(i,n,o,a,c,"next",t)}function c(t){s(i,n,o,a,c,"throw",t)}a(void 0)}))}}var l,u,v;const f=(l={metaInfo:{title:"Formulario Usuarios"},layout:n.Z,props:{roles:Array,data:Object,is_nuevo:Boolean},data:function(){return{tab:0,form_valid:!0,show_password:!1,form:{id:null,nombres:"",apellidos:"",rol:2,estado:1,email:"",oficinas:"",password:""},obligatorioRules:[function(t){return!!t||"*Obligatorio"}],emailRules:[function(t){return!!t||"*Obligatorio"},function(t){return/.+@.+\..+/.test(t)||"Formato invalido"}],dialog_asignar:!1,oficina_asig:null,area_asig:[],areas_asig:null,info_area:{dialog:!1,datos:{}},areas_listas:!1,oficinas_res:[],oficinas_search:"",data_ofi:[],oficina_selected:null}},computed:{},watch:{oficina_asig:function(t){var e=this;return c(a().mark((function r(){var n;return a().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:if(t){r.next=2;break}return r.abrupt("return");case 2:return r.next=4,axios.get("/get-data/areas/by-oficina/"+t+"/"+e.form.id);case 4:n=r.sent,e.areas_asig=n.data.datos;case 6:case"end":return r.stop()}}),r)})))()}},methods:{customFilterOficina:function(t,e,r){var n=t.nombre.toLowerCase(),o=e.toLowerCase();return n.indexOf(o)>-1},BuscarOficinas:function(t){return c(a().mark((function e(){var r;return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,axios.get("/get-data/oficinas/"+t);case 2:return r=e.sent,e.abrupt("return",r.data.datos);case 4:case"end":return e.stop()}}),e)})))()},Guardar:function(){var t=this;return c(a().mark((function e(){var r;return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(!t.$refs.form_user.validate()){e.next=6;break}return e.next=3,axios.post("/admin/usuarios/guardar",t.form);case 3:r=e.sent,console.log(r.data),t.is_nuevo&&t.$refs.form_user.reset();case 6:case"end":return e.stop()}}),e)})))()},getInfoAreas:function(t){var e=this;return c(a().mark((function r(){var n;return a().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,axios.get("/get-data/areas/all-info/"+t.id+"/"+e.form.id);case 2:return n=r.sent,r.abrupt("return",n.data.datos);case 4:case"end":return r.stop()}}),r)})))()},getInformacionArea:function(){var t=this;return c(a().mark((function e(){var r;return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:r=0;case 1:if(!(t.form.oficinas.length>r)){e.next=8;break}return e.next=4,t.getInfoAreas(t.form.oficinas[r]);case 4:t.form.oficinas[r].areas=e.sent;case 5:r++,e.next=1;break;case 8:console.log(t.form.oficinas),t.areas_listas=!0;case 10:case"end":return e.stop()}}),e)})))()},guardarAsingar:function(){var t=this;return c(a().mark((function e(){return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,axios.post("/admin/usuarios/asignar-area",{areas:t.oficina_selected,usuario:t.form.id});case 2:e.sent.data.estado&&o.Inertia.get("/admin/usuarios/formulario/"+t.form.id);case 4:case"end":return e.stop()}}),e)})))()}},created:function(){var t=this;return c(a().mark((function e(){return a().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:console.log(t.data),t.data&&!t.is_nuevo&&(t.data.rol=parseInt(t.data.rol),t.form=t.data);case 2:case"end":return e.stop()}}),e)})))()}},v={oficinas_search:function(t){var e=this;return c(a().mark((function r(){var n;return a().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:if(t){r.next=2;break}return r.abrupt("return");case 2:if(!(t.length<2)){r.next=4;break}return r.abrupt("return");case 4:return r.next=6,e.BuscarOficinas(t);case 6:n=r.sent,e.oficinas_res=n;case 8:case"end":return r.stop()}}),r)})))()}},(u="watch")in l?Object.defineProperty(l,u,{value:v,enumerable:!0,configurable:!0,writable:!0}):l[u]=v,l);const p=(0,r(1900).Z)(f,(function(){var t=this,e=t._self._c;return e("div",{staticClass:"wrapper-page"},[void 0,t._v(" "),e("div",{staticClass:"page-heading"},[e("div",{staticClass:"page-details"},[e("v-toolbar",{attrs:{outlined:"",color:"grey lighten-3",elevation:"0"}},[e("v-toolbar-title",[e("v-app-bar-nav-icon",[e("v-icon",[t._v("mdi-account")])],1),t._v("\n\n                    "+t._s(t.is_nuevo?" Nuevo Usuarios":"Editar Usuarios")+"\n                ")],1)],1)],1),t._v(" "),e("div",{staticClass:"page-search"},[e("v-toolbar",{attrs:{outlined:"",color:"grey lighten-5",elevation:"0"}})],1)]),t._v(" "),e("div",{staticClass:"content-wrapper"},[e("v-container",[e("v-card",[e("v-tabs",{attrs:{left:"",color:"primary accent-4"},model:{value:t.tab,callback:function(e){t.tab=e},expression:"tab"}},[e("v-tab",[e("strong",[t._v(" Datos de Usuario")])])],1),t._v(" "),e("v-tabs-items",{model:{value:t.tab,callback:function(e){t.tab=e},expression:"tab"}},[e("v-tab-item",[e("v-card",{staticClass:"pa-5",attrs:{flat:""}},[e("v-form",{ref:"form_user",attrs:{"lazy-validation":""},model:{value:t.form_valid,callback:function(e){t.form_valid=e},expression:"form_valid"}},[e("v-row",[e("v-col",{staticClass:"pb-0",attrs:{cols:"12",sm:"6",md:"4"}},[e("h4",{staticClass:"pb-0 grey--text text--darken-2"},[t._v("\n                                            Nombres\n                                        ")]),t._v(" "),e("v-text-field",{attrs:{required:"",dense:"",rules:t.obligatorioRules},model:{value:t.form.nombres,callback:function(e){t.$set(t.form,"nombres",e)},expression:"form.nombres"}})],1),t._v(" "),e("v-col",{staticClass:"pb-0",attrs:{cols:"12",sm:"6",md:"4"}},[e("h4",{staticClass:"pb-0 grey--text text--darken-2"},[t._v("\n                                            Apellidos\n                                        ")]),t._v(" "),e("v-text-field",{attrs:{required:"",dense:"",rules:t.obligatorioRules},model:{value:t.form.apellidos,callback:function(e){t.$set(t.form,"apellidos",e)},expression:"form.apellidos"}})],1),t._v(" "),e("v-col",{staticClass:"pb-0",attrs:{cols:"12",sm:"6",md:"4"}},[e("h4",{staticClass:"pb-0 grey--text text--darken-2"},[t._v("\n                                            Correo\n                                        ")]),t._v(" "),e("v-text-field",{attrs:{required:"",dense:"",rules:t.emailRules},model:{value:t.form.email,callback:function(e){t.$set(t.form,"email",e)},expression:"form.email"}})],1),t._v(" "),t.is_nuevo?e("v-col",{staticClass:"pb-0",attrs:{cols:"12",sm:"6",md:"4"}},[e("h4",{staticClass:"pb-0 grey--text text--darken-2"},[t._v("\n                                            Contraseña\n                                        ")]),t._v(" "),e("v-text-field",{attrs:{"append-icon":t.show_password?"mdi-eye":"mdi-eye-off",type:t.show_password?"text":"password",required:"",dense:"",rules:t.obligatorioRules},on:{"click:append":function(e){t.show_password=!t.show_password}},model:{value:t.form.password,callback:function(e){t.$set(t.form,"password",e)},expression:"form.password"}})],1):t._e(),t._v(" "),e("v-col",{staticClass:"pb-0",attrs:{cols:"12",sm:"6",md:"4"}},[e("h4",{staticClass:"pb-0 grey--text text--darken-2"},[t._v("\n                                            Rol de usuario\n                                        ")]),t._v(" "),e("v-autocomplete",{attrs:{items:t.roles,"item-text":"name","item-value":"id",dense:"",rules:t.obligatorioRules},model:{value:t.form.rol,callback:function(e){t.$set(t.form,"rol",e)},expression:"form.rol"}})],1)],1),t._v(" "),e("div",{staticClass:"d-flex mt-3"},[e("v-spacer"),t._v(" "),e("v-btn",{attrs:{disabled:!t.form_valid,color:"primary"},on:{click:function(e){return t.Guardar()}}},[t._v("\n                                        "+t._s(t.is_nuevo?" Registrar":"Guardar Cambios")+"\n                                    ")])],1)],1)],1)],1)],1)],1)],1)],1)],2)}),[],!1,null,null,null).exports},3763:(t,e,r)=>{r.d(e,{Z:()=>o});const n={components:{Link:r(6454).rU},data:function(){return{path_name:"",active_menu:0,items:[{title:"Grupos",icon:"mdi-account-group",ruta:"/facilitador/grupo"},{title:"Inventario",icon:"mdi-clipboard-check",ruta:"/facilitador/inventario"},{title:"Reporte de Avance",icon:"mdi-chart-line",ruta:null,sub_menu:[{title:"Diario",icon:"mdi-cast-audio",ruta:"/facilitador/reporte"},{title:"Acumulado",icon:"mdi-fencing",ruta:"/reporte/global"}]},{title:"Bienes sin codigo",icon:"mdi-clipboard-check",ruta:"/facilitador/bienes-sin-codigo"}]}},methods:{activeMenu:function(t){this.path_name=t}},mounted:function(){this.path_name=window.location.pathname}};const o=(0,r(1900).Z)(n,(function(){var t=this,e=t._self._c;return e("div",[e("v-list",{attrs:{dense:""}},[e("v-list-item-group",{staticClass:"items-menuss",attrs:{color:"pimario"},model:{value:t.active_menu,callback:function(e){t.active_menu=e},expression:"active_menu"}},t._l(t.items,(function(r,n){return e("div",{key:n},[r.sub_menu?[e("v-list-group",{attrs:{"no-action":"",color:"pimario"},scopedSlots:t._u([{key:"activator",fn:function(){return[e("v-list-item-icon",[e("v-icon",[t._v(t._s(r.icon))])],1),t._v(" "),e("v-list-item-content",[e("v-list-item-title",[e("b",[t._v(t._s(r.title)+" ")])])],1)]},proxy:!0}],null,!0)},[t._v(" "),t._l(r.sub_menu,(function(r,n){return e("Link",{key:n,staticClass:"v-list-item v-list-item--link theme--dark",class:t.path_name==r.ruta?"v-item--active v-list-item--active":"",attrs:{href:r.ruta,color:"white",link:""},on:{click:function(e){return t.activeMenu(r.ruta)}}},[e("v-list-item-title",[e("b",[t._v(" "+t._s(r.title)+" ")])])],1)}))],2)]:[e("Link",{staticClass:"v-list-item v-list-item--link theme--dark",class:t.path_name==r.ruta?"v-item--active v-list-item--active":"",attrs:{color:"white",href:r.ruta,link:""},on:{click:function(e){return t.activeMenu(r.ruta)}}},[e("v-list-item-icon",[e("v-icon",[t._v(t._s(r.icon))])],1),t._v(" "),e("v-list-item-content",[e("v-list-item-title",[e("b",[t._v(t._s(r.title)+" ")])])],1)],1)]],2)})),0)],1)],1)}),[],!1,null,null,null).exports},800:(t,e,r)=>{r.d(e,{Z:()=>o});const n={components:{Link:r(6454).rU},data:function(){return{path_name:"",active_menu:0,items:[{title:"Dashboard",icon:"mdi-home",ruta:"/admin"},{title:"Grupos",icon:"mdi-account-group",ruta:"/admin/grupo"},{title:"Reportes",icon:"mdi-chart-bar",ruta:null,sub_menu:[{title:"Generador",icon:"mdi-chart-bar",ruta:"/admin/reportes"},{title:"Explorador",icon:"mdi-chart-bar",ruta:"/admin/reportes/explorador"}]},{title:"Administrador",icon:"mdi-cog",ruta:null,sub_menu:[{title:"Usuarios",icon:"mdi-cast-audio",ruta:"/admin/usuarios"},{title:"Personas",icon:"mdi-fencing",ruta:"/admin/personas"},{title:"Inventario",icon:"mdi-fencing",ruta:"/admin/inventario"}]}]}},methods:{activeMenu:function(t){this.path_name=t}},mounted:function(){this.path_name=window.location.pathname}};const o=(0,r(1900).Z)(n,(function(){var t=this,e=t._self._c;return e("div",[e("v-list",{attrs:{dense:""}},[e("v-list-item-group",{staticClass:"items-menuss",attrs:{color:"pimario"},model:{value:t.active_menu,callback:function(e){t.active_menu=e},expression:"active_menu"}},t._l(t.items,(function(r,n){return e("div",{key:n},[r.sub_menu?[e("v-list-group",{attrs:{"no-action":"",color:"pimario"},scopedSlots:t._u([{key:"activator",fn:function(){return[e("v-list-item-icon",[e("v-icon",[t._v(t._s(r.icon))])],1),t._v(" "),e("v-list-item-content",[e("v-list-item-title",[e("b",[t._v(t._s(r.title)+" ")])])],1)]},proxy:!0}],null,!0)},[t._v(" "),t._l(r.sub_menu,(function(r,n){return e("Link",{key:n,staticClass:"v-list-item v-list-item--link theme--dark",class:t.path_name==r.ruta?"v-item--active v-list-item--active":"",attrs:{href:r.ruta,color:"white",link:""},on:{click:function(e){return t.activeMenu(r.ruta)}}},[e("v-list-item-title",[e("b",[t._v(" "+t._s(r.title)+" ")])])],1)}))],2)]:[e("Link",{staticClass:"v-list-item v-list-item--link theme--dark",class:t.path_name==r.ruta?"v-item--active v-list-item--active":"",attrs:{color:"white",href:r.ruta,link:""},on:{click:function(e){return t.activeMenu(r.ruta)}}},[e("v-list-item-icon",[e("v-icon",[t._v(t._s(r.icon))])],1),t._v(" "),e("v-list-item-content",[e("v-list-item-title",[e("b",[t._v(t._s(r.title)+" ")])])],1)],1)]],2)})),0)],1)],1)}),[],!1,null,null,null).exports},1900:(t,e,r)=>{function n(t,e,r,n,o,i,a,s){var c,l="function"==typeof t?t.options:t;if(e&&(l.render=e,l.staticRenderFns=r,l._compiled=!0),n&&(l.functional=!0),i&&(l._scopeId="data-v-"+i),a?(c=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),o&&o.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(a)},l._ssrRegister=c):o&&(c=s?function(){o.call(this,(l.functional?this.parent:this).$root.$options.shadowRoot)}:o),c)if(l.functional){l._injectStyles=c;var u=l.render;l.render=function(t,e){return c.call(e),u(t,e)}}else{var v=l.beforeCreate;l.beforeCreate=v?[].concat(v,c):[c]}return{exports:t,options:l}}r.d(e,{Z:()=>n})}}]);
//# sourceMappingURL=1582.js.map?id=b52eeb3f73c234de