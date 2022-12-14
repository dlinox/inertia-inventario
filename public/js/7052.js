/*! For license information please see 7052.js.LICENSE.txt */
"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[7052],{799:(t,e,n)=>{n.d(e,{Z:()=>c});var r=n(4015),i=n.n(r),o=n(3645),a=n.n(o)()(i());a.push([t.id,"@import url(https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&display=swap);"]),a.push([t.id,"*[data-v-757de6f5]{font-family:Nunito,sans-serif}.main_app[data-v-757de6f5]{background:#eee}.component-fade-enter-active[data-v-757de6f5],.component-fade-leave-active[data-v-757de6f5]{transition:opacity .3s ease}.component-fade-enter[data-v-757de6f5],.component-fade-leave-to[data-v-757de6f5]{opacity:0}.wrap-imagen[data-v-757de6f5]{align-items:center;background-color:hsla(0,0%,100%,.3);display:flex;justify-content:center;width:100%}","",{version:3,sources:["webpack://./resources/js/Layouts/FacilitadorLayout.vue"],names:[],mappings:"AA+IA,mBACA,6BACA,CAEA,2BACA,eACA,CAEA,4FAEA,2BACA,CAEA,iFAKA,SACA,CAEA,8BAGA,kBAAA,CAEA,mCAAA,CAJA,YAAA,CACA,sBAAA,CAEA,UAEA",sourcesContent:['<template>\r\n    <v-app>\r\n        <v-navigation-drawer app v-model="drawer" color="#01305A" dark>\r\n            <div class="wrap-imagen py-4">\r\n                <img width="80%" src="/images/logomin.png" alt="" />\r\n            </div>\r\n\r\n            <v-card flat rounded="0" color="transparent">\r\n                <v-list two-line class="py-0">\r\n                    <v-list-item>\r\n                        <v-list-item-avatar color="secondary">\r\n                            <span class="white--text headline">\r\n                                <small> AA </small>\r\n                            </span>\r\n                        </v-list-item-avatar>\r\n                        <v-list-item-content>\r\n                            <v-list-item-title>\r\n                                {{ user.nombres }}\r\n                            </v-list-item-title>\r\n                            <v-list-item-subtitle>\r\n                                {{ user.rol }}\r\n                            </v-list-item-subtitle>\r\n                        </v-list-item-content>\r\n                    </v-list-item>\r\n                </v-list>\r\n            </v-card>\r\n\r\n            <v-divider />\r\n\r\n\r\n            <MenuFacilitadorComponent />\r\n\r\n            \x3c!-- <MenuFacilitadorComponent /> --\x3e\r\n\r\n            <template v-slot:append>\r\n                <v-divider></v-divider>\r\n                <v-card-text class="text-center py-1">\r\n                    <v-btn class="mx-4" icon link @click="salir">\r\n                        <v-icon size="24px" color="blue-grey lighten-4">\r\n                            mdi-power\r\n                        </v-icon>\r\n                    </v-btn>\r\n                </v-card-text>\r\n            </template>\r\n        </v-navigation-drawer>\r\n        <v-app-bar app color="white" scroll-off-screen elevation="3">\r\n            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>\r\n\r\n            <v-spacer />\r\n\r\n            <v-menu offset-y>\r\n                <template v-slot:activator="{ attrs, on }">\r\n                    <v-btn text color="primary" class="" v-bind="attrs" v-on="on">\r\n                        {{ user.nombres }}\r\n                        <v-icon right>mdi-account </v-icon>\r\n                    </v-btn>\r\n                </template>\r\n\r\n                <v-list dense>\r\n                    <v-subheader>Opciones</v-subheader>\r\n                    <v-list-item-group v-model="selectedMenu" color="primary">\r\n                        <v-list-item v-for="(item, i) in items" :key="i" @click="SelectMenu(item.text)">\r\n                            <v-list-item-icon>\r\n                                <v-icon v-text="item.icon"></v-icon>\r\n                            </v-list-item-icon>\r\n                            <v-list-item-content>\r\n                                <v-list-item-title v-text="item.text"></v-list-item-title>\r\n                            </v-list-item-content>\r\n                        </v-list-item>\r\n                    </v-list-item-group>\r\n                </v-list>\r\n            </v-menu>\r\n        </v-app-bar>\r\n\r\n        <v-main class="main_app">\r\n            <transition name="component-fade" mode="out-in">\r\n                <slot />\r\n            </transition>\r\n        </v-main>\r\n        <v-footer app dark>\r\n            <v-spacer />\r\n            <h6>\r\n                \x3c!--by\r\n                <a\r\n                    href="https://www.linkedin.com/in/lino-puma-ticona-a76021202/"\r\n                    target="_blank"\r\n                    class="blue--text text-decoration-none"\r\n                    >Lino Puma</a\r\n                > --\x3e\r\n            </h6>\r\n        </v-footer>\r\n    </v-app>\r\n</template>\r\n<script>\r\nimport MenuPrincipalComponent from "@/components/MenuPrincipalComponent";\r\nimport MenuFacilitadorComponent from "@/components/MenuFacilitadorComponent";\r\n\r\nexport default {\r\n    components: {\r\n        MenuPrincipalComponent,\r\n        MenuFacilitadorComponent,\r\n    },\r\n    data: () => ({\r\n        drawer: true,\r\n        attrs: {\r\n            class: "mb-1",\r\n            boilerplate: true,\r\n            elevation: 0,\r\n            loading: false,\r\n        },\r\n\r\n        closeOnContentClick: true,\r\n\r\n        items: [\r\n            { text: "Salir", icon: "mdi-power" },\r\n        ],\r\n        selectedMenu: null,\r\n    }),\r\n    computed: {\r\n        user() {\r\n            return this.$page.props.auth.user;\r\n        },\r\n    },\r\n    methods: {\r\n        SelectMenu(op) {\r\n            if (op == \'Salir\') {\r\n                this.salir();\r\n            }\r\n        },\r\n        salir() {\r\n            this.$inertia.post("/logout");\r\n        },\r\n    },\r\n    async created() {\r\n        //await this.GetCurrentUser();\r\n\r\n        this.drawer = this.$vuetify.breakpoint.width > 960 ? true : false;\r\n    },\r\n};\r\n<\/script>\r\n<style scoped>\r\n@import url(\'https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&display=swap\');\r\n\r\n* {\r\n    font-family: \'Nunito\', sans-serif;\r\n}\r\n\r\n.main_app {\r\n    background: #eeeeee;\r\n}\r\n\r\n.component-fade-enter-active,\r\n.component-fade-leave-active {\r\n    transition: opacity 0.3s ease;\r\n}\r\n\r\n.component-fade-enter,\r\n.component-fade-leave-to\r\n\r\n/* .component-fade-leave-active below version 2.1.8 */\r\n    {\r\n    opacity: 0;\r\n}\r\n\r\n.wrap-imagen {\r\n    display: flex;\r\n    justify-content: center;\r\n    align-items: center;\r\n    width: 100%;\r\n    background-color: rgba(255, 255, 255, .3);\r\n}\r\n</style>\r\n'],sourceRoot:""}]);const c=a},4541:(t,e,n)=>{n.d(e,{Z:()=>f});var r=n(800),i=n(2608);function o(t){return o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},o(t)}function a(){a=function(){return t};var t={},e=Object.prototype,n=e.hasOwnProperty,r="function"==typeof Symbol?Symbol:{},i=r.iterator||"@@iterator",c=r.asyncIterator||"@@asyncIterator",s=r.toStringTag||"@@toStringTag";function l(t,e,n){return Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{l({},"")}catch(t){l=function(t,e,n){return t[e]=n}}function u(t,e,n,r){var i=e&&e.prototype instanceof f?e:f,o=Object.create(i.prototype),a=new A(r||[]);return o._invoke=function(t,e,n){var r="suspendedStart";return function(i,o){if("executing"===r)throw new Error("Generator is already running");if("completed"===r){if("throw"===i)throw o;return E()}for(n.method=i,n.arg=o;;){var a=n.delegate;if(a){var c=x(a,n);if(c){if(c===p)continue;return c}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if("suspendedStart"===r)throw r="completed",n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);r="executing";var s=v(t,e,n);if("normal"===s.type){if(r=n.done?"completed":"suspendedYield",s.arg===p)continue;return{value:s.arg,done:n.done}}"throw"===s.type&&(r="completed",n.method="throw",n.arg=s.arg)}}}(t,n,a),o}function v(t,e,n){try{return{type:"normal",arg:t.call(e,n)}}catch(t){return{type:"throw",arg:t}}}t.wrap=u;var p={};function f(){}function d(){}function h(){}var m={};l(m,i,(function(){return this}));var y=Object.getPrototypeOf,g=y&&y(y(C([])));g&&g!==e&&n.call(g,i)&&(m=g);var _=h.prototype=f.prototype=Object.create(m);function w(t){["next","throw","return"].forEach((function(e){l(t,e,(function(t){return this._invoke(e,t)}))}))}function b(t,e){function r(i,a,c,s){var l=v(t[i],t,a);if("throw"!==l.type){var u=l.arg,p=u.value;return p&&"object"==o(p)&&n.call(p,"__await")?e.resolve(p.__await).then((function(t){r("next",t,c,s)}),(function(t){r("throw",t,c,s)})):e.resolve(p).then((function(t){u.value=t,c(u)}),(function(t){return r("throw",t,c,s)}))}s(l.arg)}var i;this._invoke=function(t,n){function o(){return new e((function(e,i){r(t,n,e,i)}))}return i=i?i.then(o,o):o()}}function x(t,e){var n=t.iterator[e.method];if(void 0===n){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=void 0,x(t,e),"throw"===e.method))return p;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return p}var r=v(n,t.iterator,e.arg);if("throw"===r.type)return e.method="throw",e.arg=r.arg,e.delegate=null,p;var i=r.arg;return i?i.done?(e[t.resultName]=i.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=void 0),e.delegate=null,p):i:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,p)}function k(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function L(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function A(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(k,this),this.reset(!0)}function C(t){if(t){var e=t[i];if(e)return e.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var r=-1,o=function e(){for(;++r<t.length;)if(n.call(t,r))return e.value=t[r],e.done=!1,e;return e.value=void 0,e.done=!0,e};return o.next=o}}return{next:E}}function E(){return{value:void 0,done:!0}}return d.prototype=h,l(_,"constructor",h),l(h,"constructor",d),d.displayName=l(h,s,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===d||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,h):(t.__proto__=h,l(t,s,"GeneratorFunction")),t.prototype=Object.create(_),t},t.awrap=function(t){return{__await:t}},w(b.prototype),l(b.prototype,c,(function(){return this})),t.AsyncIterator=b,t.async=function(e,n,r,i,o){void 0===o&&(o=Promise);var a=new b(u(e,n,r,i),o);return t.isGeneratorFunction(n)?a:a.next().then((function(t){return t.done?t.value:a.next()}))},w(_),l(_,s,"Generator"),l(_,i,(function(){return this})),l(_,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=[];for(var n in t)e.push(n);return e.reverse(),function n(){for(;e.length;){var r=e.pop();if(r in t)return n.value=r,n.done=!1,n}return n.done=!0,n}},t.values=C,A.prototype={constructor:A,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(L),!t)for(var e in this)"t"===e.charAt(0)&&n.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function r(n,r){return a.type="throw",a.arg=t,e.next=n,r&&(e.method="next",e.arg=void 0),!!r}for(var i=this.tryEntries.length-1;i>=0;--i){var o=this.tryEntries[i],a=o.completion;if("root"===o.tryLoc)return r("end");if(o.tryLoc<=this.prev){var c=n.call(o,"catchLoc"),s=n.call(o,"finallyLoc");if(c&&s){if(this.prev<o.catchLoc)return r(o.catchLoc,!0);if(this.prev<o.finallyLoc)return r(o.finallyLoc)}else if(c){if(this.prev<o.catchLoc)return r(o.catchLoc,!0)}else{if(!s)throw new Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return r(o.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var i=this.tryEntries[r];if(i.tryLoc<=this.prev&&n.call(i,"finallyLoc")&&this.prev<i.finallyLoc){var o=i;break}}o&&("break"===t||"continue"===t)&&o.tryLoc<=e&&e<=o.finallyLoc&&(o=null);var a=o?o.completion:{};return a.type=t,a.arg=e,o?(this.method="next",this.next=o.finallyLoc,p):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),p},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),L(n),p}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.tryLoc===t){var r=n.completion;if("throw"===r.type){var i=r.arg;L(n)}return i}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,n){return this.delegate={iterator:C(t),resultName:e,nextLoc:n},"next"===this.method&&(this.arg=void 0),p}},t}function c(t,e,n,r,i,o,a){try{var c=t[o](a),s=c.value}catch(t){return void n(t)}c.done?e(s):Promise.resolve(s).then(r,i)}const s={components:{MenuPrincipalComponent:r.Z,MenuFacilitadorComponent:i.Z},data:function(){return{drawer:!0,attrs:{class:"mb-1",boilerplate:!0,elevation:0,loading:!1},closeOnContentClick:!0,items:[{text:"Salir",icon:"mdi-power"}],selectedMenu:null}},computed:{user:function(){return this.$page.props.auth.user}},methods:{SelectMenu:function(t){"Salir"==t&&this.salir()},salir:function(){this.$inertia.post("/logout")}},created:function(){var t,e=this;return(t=a().mark((function t(){return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:e.drawer=e.$vuetify.breakpoint.width>960;case 1:case"end":return t.stop()}}),t)})),function(){var e=this,n=arguments;return new Promise((function(r,i){var o=t.apply(e,n);function a(t){c(o,r,i,a,s,"next",t)}function s(t){c(o,r,i,a,s,"throw",t)}a(void 0)}))})()}};var l=n(3379),u=n.n(l),v=n(799),p={insert:"head",singleton:!1};u()(v.Z,p);v.Z.locals;const f=(0,n(1900).Z)(s,(function(){var t=this,e=t._self._c;return e("v-app",[e("v-navigation-drawer",{attrs:{app:"",color:"#01305A",dark:""},scopedSlots:t._u([{key:"append",fn:function(){return[e("v-divider"),t._v(" "),e("v-card-text",{staticClass:"text-center py-1"},[e("v-btn",{staticClass:"mx-4",attrs:{icon:"",link:""},on:{click:t.salir}},[e("v-icon",{attrs:{size:"24px",color:"blue-grey lighten-4"}},[t._v("\n                        mdi-power\n                    ")])],1)],1)]},proxy:!0}]),model:{value:t.drawer,callback:function(e){t.drawer=e},expression:"drawer"}},[e("div",{staticClass:"wrap-imagen py-4"},[e("img",{attrs:{width:"80%",src:"/images/logomin.png",alt:""}})]),t._v(" "),e("v-card",{attrs:{flat:"",rounded:"0",color:"transparent"}},[e("v-list",{staticClass:"py-0",attrs:{"two-line":""}},[e("v-list-item",[e("v-list-item-avatar",{attrs:{color:"secondary"}},[e("span",{staticClass:"white--text headline"},[e("small",[t._v(" AA ")])])]),t._v(" "),e("v-list-item-content",[e("v-list-item-title",[t._v("\n                            "+t._s(t.user.nombres)+"\n                        ")]),t._v(" "),e("v-list-item-subtitle",[t._v("\n                            "+t._s(t.user.rol)+"\n                        ")])],1)],1)],1)],1),t._v(" "),e("v-divider"),t._v(" "),e("MenuFacilitadorComponent")],1),t._v(" "),e("v-app-bar",{attrs:{app:"",color:"white","scroll-off-screen":"",elevation:"3"}},[e("v-app-bar-nav-icon",{on:{click:function(e){e.stopPropagation(),t.drawer=!t.drawer}}}),t._v(" "),e("v-spacer"),t._v(" "),e("v-menu",{attrs:{"offset-y":""},scopedSlots:t._u([{key:"activator",fn:function(n){var r=n.attrs,i=n.on;return[e("v-btn",t._g(t._b({attrs:{text:"",color:"primary"}},"v-btn",r,!1),i),[t._v("\n                    "+t._s(t.user.nombres)+"\n                    "),e("v-icon",{attrs:{right:""}},[t._v("mdi-account ")])],1)]}}])},[t._v(" "),e("v-list",{attrs:{dense:""}},[e("v-subheader",[t._v("Opciones")]),t._v(" "),e("v-list-item-group",{attrs:{color:"primary"},model:{value:t.selectedMenu,callback:function(e){t.selectedMenu=e},expression:"selectedMenu"}},t._l(t.items,(function(n,r){return e("v-list-item",{key:r,on:{click:function(e){return t.SelectMenu(n.text)}}},[e("v-list-item-icon",[e("v-icon",{domProps:{textContent:t._s(n.icon)}})],1),t._v(" "),e("v-list-item-content",[e("v-list-item-title",{domProps:{textContent:t._s(n.text)}})],1)],1)})),1)],1)],1)],1),t._v(" "),e("v-main",{staticClass:"main_app"},[e("transition",{attrs:{name:"component-fade",mode:"out-in"}},[t._t("default")],2)],1),t._v(" "),e("v-footer",{attrs:{app:"",dark:""}},[e("v-spacer"),t._v(" "),e("h6")],1)],1)}),[],!1,null,"757de6f5",null).exports},7052:(t,e,n)=>{n.r(e),n.d(e,{default:()=>c});function r(t){return r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},r(t)}function i(){i=function(){return t};var t={},e=Object.prototype,n=e.hasOwnProperty,o="function"==typeof Symbol?Symbol:{},a=o.iterator||"@@iterator",c=o.asyncIterator||"@@asyncIterator",s=o.toStringTag||"@@toStringTag";function l(t,e,n){return Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{l({},"")}catch(t){l=function(t,e,n){return t[e]=n}}function u(t,e,n,r){var i=e&&e.prototype instanceof f?e:f,o=Object.create(i.prototype),a=new A(r||[]);return o._invoke=function(t,e,n){var r="suspendedStart";return function(i,o){if("executing"===r)throw new Error("Generator is already running");if("completed"===r){if("throw"===i)throw o;return E()}for(n.method=i,n.arg=o;;){var a=n.delegate;if(a){var c=x(a,n);if(c){if(c===p)continue;return c}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if("suspendedStart"===r)throw r="completed",n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);r="executing";var s=v(t,e,n);if("normal"===s.type){if(r=n.done?"completed":"suspendedYield",s.arg===p)continue;return{value:s.arg,done:n.done}}"throw"===s.type&&(r="completed",n.method="throw",n.arg=s.arg)}}}(t,n,a),o}function v(t,e,n){try{return{type:"normal",arg:t.call(e,n)}}catch(t){return{type:"throw",arg:t}}}t.wrap=u;var p={};function f(){}function d(){}function h(){}var m={};l(m,a,(function(){return this}));var y=Object.getPrototypeOf,g=y&&y(y(C([])));g&&g!==e&&n.call(g,a)&&(m=g);var _=h.prototype=f.prototype=Object.create(m);function w(t){["next","throw","return"].forEach((function(e){l(t,e,(function(t){return this._invoke(e,t)}))}))}function b(t,e){function i(o,a,c,s){var l=v(t[o],t,a);if("throw"!==l.type){var u=l.arg,p=u.value;return p&&"object"==r(p)&&n.call(p,"__await")?e.resolve(p.__await).then((function(t){i("next",t,c,s)}),(function(t){i("throw",t,c,s)})):e.resolve(p).then((function(t){u.value=t,c(u)}),(function(t){return i("throw",t,c,s)}))}s(l.arg)}var o;this._invoke=function(t,n){function r(){return new e((function(e,r){i(t,n,e,r)}))}return o=o?o.then(r,r):r()}}function x(t,e){var n=t.iterator[e.method];if(void 0===n){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=void 0,x(t,e),"throw"===e.method))return p;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return p}var r=v(n,t.iterator,e.arg);if("throw"===r.type)return e.method="throw",e.arg=r.arg,e.delegate=null,p;var i=r.arg;return i?i.done?(e[t.resultName]=i.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=void 0),e.delegate=null,p):i:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,p)}function k(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function L(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function A(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(k,this),this.reset(!0)}function C(t){if(t){var e=t[a];if(e)return e.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var r=-1,i=function e(){for(;++r<t.length;)if(n.call(t,r))return e.value=t[r],e.done=!1,e;return e.value=void 0,e.done=!0,e};return i.next=i}}return{next:E}}function E(){return{value:void 0,done:!0}}return d.prototype=h,l(_,"constructor",h),l(h,"constructor",d),d.displayName=l(h,s,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===d||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,h):(t.__proto__=h,l(t,s,"GeneratorFunction")),t.prototype=Object.create(_),t},t.awrap=function(t){return{__await:t}},w(b.prototype),l(b.prototype,c,(function(){return this})),t.AsyncIterator=b,t.async=function(e,n,r,i,o){void 0===o&&(o=Promise);var a=new b(u(e,n,r,i),o);return t.isGeneratorFunction(n)?a:a.next().then((function(t){return t.done?t.value:a.next()}))},w(_),l(_,s,"Generator"),l(_,a,(function(){return this})),l(_,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=[];for(var n in t)e.push(n);return e.reverse(),function n(){for(;e.length;){var r=e.pop();if(r in t)return n.value=r,n.done=!1,n}return n.done=!0,n}},t.values=C,A.prototype={constructor:A,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(L),!t)for(var e in this)"t"===e.charAt(0)&&n.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function r(n,r){return a.type="throw",a.arg=t,e.next=n,r&&(e.method="next",e.arg=void 0),!!r}for(var i=this.tryEntries.length-1;i>=0;--i){var o=this.tryEntries[i],a=o.completion;if("root"===o.tryLoc)return r("end");if(o.tryLoc<=this.prev){var c=n.call(o,"catchLoc"),s=n.call(o,"finallyLoc");if(c&&s){if(this.prev<o.catchLoc)return r(o.catchLoc,!0);if(this.prev<o.finallyLoc)return r(o.finallyLoc)}else if(c){if(this.prev<o.catchLoc)return r(o.catchLoc,!0)}else{if(!s)throw new Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return r(o.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var i=this.tryEntries[r];if(i.tryLoc<=this.prev&&n.call(i,"finallyLoc")&&this.prev<i.finallyLoc){var o=i;break}}o&&("break"===t||"continue"===t)&&o.tryLoc<=e&&e<=o.finallyLoc&&(o=null);var a=o?o.completion:{};return a.type=t,a.arg=e,o?(this.method="next",this.next=o.finallyLoc,p):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),p},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),L(n),p}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var n=this.tryEntries[e];if(n.tryLoc===t){var r=n.completion;if("throw"===r.type){var i=r.arg;L(n)}return i}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,n){return this.delegate={iterator:C(t),resultName:e,nextLoc:n},"next"===this.method&&(this.arg=void 0),p}},t}function o(t,e,n,r,i,o,a){try{var c=t[o](a),s=c.value}catch(t){return void n(t)}c.done?e(s):Promise.resolve(s).then(r,i)}const a={metaInfo:{title:"Facilitador - Reporte"},layout:n(4541).Z,data:function(){return{datos:[],total:0,fecha:new Date(Date.now()-6e4*(new Date).getTimezoneOffset()).toISOString().substr(0,10),menu:!1}},methods:{getDatos:function(){var t,e=this;return(t=i().mark((function t(){var n;return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,axios.get("/facilitador/reporte-dia/"+e.fecha);case 2:return n=t.sent,e.datos=n.data.datos,e.total=n.data.total,t.abrupt("return",n.data.datos.data);case 6:case"end":return t.stop()}}),t)})),function(){var e=this,n=arguments;return new Promise((function(r,i){var a=t.apply(e,n);function c(t){o(a,r,i,c,s,"next",t)}function s(t){o(a,r,i,c,s,"throw",t)}c(void 0)}))})()},voltear:function(t){return t.split("-").reverse().join("/")},getFecha:function(t){var e=new Date,n=t||0;e.setDate(e.getDate()+n);var r=e.getFullYear(),i=e.getMonth()+1,o=e.getDate();return r+"-"+(i=i<10?"0"+i:i)+"-"+(o=o<10?"0"+o:o)}},created:function(){this.fecha=this.getFecha(-5),this.getDatos()},watch:{fecha:function(){this.getDatos()}}};const c=(0,n(1900).Z)(a,(function(){var t=this,e=t._self._c;return e("div",{staticClass:"pa-3"},[e("v-card",[e("v-simple-table",{staticStyle:{width:"100%"}},[e("thead",[e("tr",[e("th",{attrs:{colspan:"5"}},[e("div",{},[e("div",{staticClass:"d-flex",staticStyle:{"justify-content":"space-between","align-items":"center"}},[e("div",[e("span",{staticStyle:{"font-weight":"bold","font-size":"1.3rem"}},[t._v(" Reporte de Avance del "+t._s(t.voltear(t.fecha))+" ")]),t._v(" "),e("h2",[t._v("Registro de Bienes ")])]),t._v(" "),e("div",{staticClass:"pt-5"},[e("v-menu",{attrs:{"close-on-content-click":!1,"nudge-right":-40,transition:"scale-transition","offset-y":"","min-width":"auto"},scopedSlots:t._u([{key:"activator",fn:function(n){var r=n.on,i=n.attrs;return[e("v-text-field",t._g(t._b({staticStyle:{"padding-right":"0px"},attrs:{label:"Fecha",dense:"","append-icon":"mdi-calendar",readonly:"",outlined:""},model:{value:t.fecha,callback:function(e){t.fecha=e},expression:"fecha"}},"v-text-field",i,!1),r))]}}]),model:{value:t.menu,callback:function(e){t.menu=e},expression:"menu"}},[t._v(" "),e("v-date-picker",{attrs:{"no-title":"",locale:"es-es","first-day-of-week":1},on:{input:function(e){t.menu=!1}},model:{value:t.fecha,callback:function(e){t.fecha=e},expression:"fecha"}})],1)],1)])])])]),t._v(" "),e("tr",[e("th",[t._v("Equipo")]),t._v(" "),e("th",[t._v("Dependencia")]),t._v(" "),e("th",[t._v("Apellidos Y Nombres")]),t._v(" "),e("th",[t._v("Reg. x Usuario")]),t._v(" "),e("th",[t._v("Reg. x Equipo")])])]),t._v(" "),e("tbody",[t._l(t.datos,(function(n){return e("tr",{key:n.id},[e("td",{attrs:{align:"center"}},[e("div",[t._v("Team")]),t._v(" "+t._s(n.equipo))]),t._v(" "),e("td",t._l(n.dependencia,(function(n){return e("div",[t._v("\n                "+t._s(n)+"\n            ")])})),0),t._v(" "),e("td",{staticStyle:{width:"300px","min-width":"330px"}},[e("div",[t._v(t._s(n.usuarios.uno)+" ")]),t._v(" "),e("div",[t._v(t._s(n.usuarios.dos)+" ")])]),t._v(" "),e("td",{attrs:{align:"center"}},[e("div",[t._v(t._s(n.usuarios.unoR)+" ")]),t._v(" "),e("div",[t._v(t._s(n.usuarios.dosR)+" ")])]),t._v(" "),e("td",{attrs:{align:"center"}},[e("span",{staticStyle:{"font-size":"1rem"}},[t._v(" "+t._s(n.reg)+" ")])])])})),t._v(" "),e("tr",[e("td",{attrs:{colspan:"4"}},[e("span",{staticStyle:{"font-weight":"bold","font-size":"1rem"}},[t._v("Total")])]),t._v(" "),e("td",{attrs:{align:"center"}},[e("span",{staticStyle:{"font-weight":"bold","font-size":"1rem"}},[t._v(" "+t._s(t.total)+" ")])])])],2)])],1)],1)}),[],!1,null,null,null).exports},2608:(t,e,n)=>{n.d(e,{Z:()=>i});const r={components:{Link:n(6454).rU},data:function(){return{path_name:"",active_menu:0,items:[{title:"Grupos",icon:"mdi-account-group",ruta:"/facilitador/grupo"},{title:"Inventario",icon:"mdi-clipboard-check",ruta:"/facilitador/inventario"},{title:"Reporte diario",icon:"mdi-chart-line",ruta:"/facilitador/reporte"},{title:"Bienes sin codigo",icon:"mdi-clipboard-check",ruta:"/facilitador/bienes-sin-codigo"}]}},methods:{activeMenu:function(t){this.path_name=t}},mounted:function(){this.path_name=window.location.pathname}};const i=(0,n(1900).Z)(r,(function(){var t=this,e=t._self._c;return e("div",[e("v-list",{attrs:{dense:""}},[e("v-list-item-group",{staticClass:"items-menuss",attrs:{color:"pimario"},model:{value:t.active_menu,callback:function(e){t.active_menu=e},expression:"active_menu"}},t._l(t.items,(function(n,r){return e("div",{key:r},[n.sub_menu?[e("v-list-group",{attrs:{"no-action":"",color:"pimario"},scopedSlots:t._u([{key:"activator",fn:function(){return[e("v-list-item-icon",[e("v-icon",[t._v(t._s(n.icon))])],1),t._v(" "),e("v-list-item-content",[e("v-list-item-title",[e("b",[t._v(t._s(n.title)+" ")])])],1)]},proxy:!0}],null,!0)},[t._v(" "),t._l(n.sub_menu,(function(n,r){return e("Link",{key:r,staticClass:"v-list-item v-list-item--link theme--dark",class:t.path_name==n.ruta?"v-item--active v-list-item--active":"",attrs:{href:n.ruta,color:"white",link:""},on:{click:function(e){return t.activeMenu(n.ruta)}}},[e("v-list-item-title",[e("b",[t._v(" "+t._s(n.title)+" ")])])],1)}))],2)]:[e("Link",{staticClass:"v-list-item v-list-item--link theme--dark",class:t.path_name==n.ruta?"v-item--active v-list-item--active":"",attrs:{color:"white",href:n.ruta,link:""},on:{click:function(e){return t.activeMenu(n.ruta)}}},[e("v-list-item-icon",[e("v-icon",[t._v(t._s(n.icon))])],1),t._v(" "),e("v-list-item-content",[e("v-list-item-title",[e("b",[t._v(t._s(n.title)+" ")])])],1)],1)]],2)})),0)],1)],1)}),[],!1,null,null,null).exports},800:(t,e,n)=>{n.d(e,{Z:()=>i});const r={components:{Link:n(6454).rU},data:function(){return{path_name:"",active_menu:0,items:[{title:"Dashboard",icon:"mdi-home",ruta:"/admin"},{title:"Grupos",icon:"mdi-account-group",ruta:"/admin/grupo"},{title:"Reportes",icon:"mdi-chart-bar",ruta:null,sub_menu:[{title:"Generador",icon:"mdi-chart-bar",ruta:"/admin/reportes"},{title:"Explorador",icon:"mdi-chart-bar",ruta:"/admin/reportes/explorador"}]},{title:"Administrador",icon:"mdi-cog",ruta:null,sub_menu:[{title:"Usuarios",icon:"mdi-cast-audio",ruta:"/admin/usuarios"},{title:"Personas",icon:"mdi-fencing",ruta:"/admin/personas"},{title:"Inventario",icon:"mdi-fencing",ruta:"/admin/inventario"}]}]}},methods:{activeMenu:function(t){this.path_name=t}},mounted:function(){this.path_name=window.location.pathname}};const i=(0,n(1900).Z)(r,(function(){var t=this,e=t._self._c;return e("div",[e("v-list",{attrs:{dense:""}},[e("v-list-item-group",{staticClass:"items-menuss",attrs:{color:"pimario"},model:{value:t.active_menu,callback:function(e){t.active_menu=e},expression:"active_menu"}},t._l(t.items,(function(n,r){return e("div",{key:r},[n.sub_menu?[e("v-list-group",{attrs:{"no-action":"",color:"pimario"},scopedSlots:t._u([{key:"activator",fn:function(){return[e("v-list-item-icon",[e("v-icon",[t._v(t._s(n.icon))])],1),t._v(" "),e("v-list-item-content",[e("v-list-item-title",[e("b",[t._v(t._s(n.title)+" ")])])],1)]},proxy:!0}],null,!0)},[t._v(" "),t._l(n.sub_menu,(function(n,r){return e("Link",{key:r,staticClass:"v-list-item v-list-item--link theme--dark",class:t.path_name==n.ruta?"v-item--active v-list-item--active":"",attrs:{href:n.ruta,color:"white",link:""},on:{click:function(e){return t.activeMenu(n.ruta)}}},[e("v-list-item-title",[e("b",[t._v(" "+t._s(n.title)+" ")])])],1)}))],2)]:[e("Link",{staticClass:"v-list-item v-list-item--link theme--dark",class:t.path_name==n.ruta?"v-item--active v-list-item--active":"",attrs:{color:"white",href:n.ruta,link:""},on:{click:function(e){return t.activeMenu(n.ruta)}}},[e("v-list-item-icon",[e("v-icon",[t._v(t._s(n.icon))])],1),t._v(" "),e("v-list-item-content",[e("v-list-item-title",[e("b",[t._v(t._s(n.title)+" ")])])],1)],1)]],2)})),0)],1)],1)}),[],!1,null,null,null).exports},1900:(t,e,n)=>{function r(t,e,n,r,i,o,a,c){var s,l="function"==typeof t?t.options:t;if(e&&(l.render=e,l.staticRenderFns=n,l._compiled=!0),r&&(l.functional=!0),o&&(l._scopeId="data-v-"+o),a?(s=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(a)},l._ssrRegister=s):i&&(s=c?function(){i.call(this,(l.functional?this.parent:this).$root.$options.shadowRoot)}:i),s)if(l.functional){l._injectStyles=s;var u=l.render;l.render=function(t,e){return s.call(e),u(t,e)}}else{var v=l.beforeCreate;l.beforeCreate=v?[].concat(v,s):[s]}return{exports:t,options:l}}n.d(e,{Z:()=>r})}}]);
//# sourceMappingURL=7052.js.map?id=bad23376ac2a8901