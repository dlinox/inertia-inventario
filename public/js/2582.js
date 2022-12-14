/*! For license information please see 2582.js.LICENSE.txt */
"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[2582],{2069:(t,r,n)=>{n.d(r,{Z:()=>s});var e=n(4015),i=n.n(e),o=n(3645),a=n.n(o)()(i());a.push([t.id,"@import url(https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&display=swap);"]),a.push([t.id,"*[data-v-70b42944]{font-family:Nunito,sans-serif}.main_app[data-v-70b42944]{background:#eee}.component-fade-enter-active[data-v-70b42944],.component-fade-leave-active[data-v-70b42944]{transition:opacity .3s ease}.component-fade-enter[data-v-70b42944],.component-fade-leave-to[data-v-70b42944]{opacity:0}.wrap-imagen[data-v-70b42944]{align-items:center;background-color:hsla(0,0%,100%,.3);display:flex;justify-content:center;width:100%}","",{version:3,sources:["webpack://./resources/js/Layouts/AdminLayout.vue"],names:[],mappings:"AA4JA,mBACA,6BACA,CACA,2BACA,eACA,CACA,4FAEA,2BACA,CACA,iFAEA,SACA,CACA,8BAGA,kBAAA,CAEA,mCAAA,CAJA,YAAA,CACA,sBAAA,CAEA,UAEA",sourcesContent:['<template>\r\n    <v-app>\r\n        <v-navigation-drawer app v-model="drawer" color="#01305A" dark>\r\n            <div class="wrap-imagen py-4">\r\n                <img width="80%" src="/images/logomin.png" alt="" />\r\n            </div>\r\n\r\n            <v-card flat rounded="0" color="transparent">\r\n                <v-list two-line class="py-0">\r\n                    <v-list-item>\r\n                        <v-list-item-avatar color="secondary">\r\n                            <span class="white--text headline">\r\n                                <small> AA </small>\r\n                            </span>\r\n                        </v-list-item-avatar>\r\n                        <v-list-item-content>\r\n                            <v-list-item-title>\r\n                                {{ user.nombres }}\r\n                            </v-list-item-title>\r\n                            <v-list-item-subtitle>\r\n                                {{ user.rol }}\r\n                            </v-list-item-subtitle>\r\n                        </v-list-item-content>\r\n                    </v-list-item>\r\n                </v-list>\r\n            </v-card>\r\n\r\n            <v-divider />\r\n\r\n                <menu-principal-component />\r\n\r\n            \x3c!-- <MenuFacilitadorComponent /> --\x3e\r\n\r\n            <template v-slot:append>\r\n                <v-divider></v-divider>\r\n                <v-card-text class="text-center py-1">\r\n                    <v-btn class="mx-4" icon link @click="salir">\r\n                        <v-icon size="24px" color="blue-grey lighten-4">\r\n                            mdi-power\r\n                        </v-icon>\r\n                    </v-btn>\r\n                </v-card-text>\r\n            </template>\r\n        </v-navigation-drawer>\r\n        <v-app-bar app color="white" scroll-off-screen elevation="3">\r\n            <v-app-bar-nav-icon\r\n                @click.stop="drawer = !drawer"\r\n            ></v-app-bar-nav-icon>\r\n\r\n            <v-spacer />\r\n\r\n            <v-menu offset-y>\r\n                <template v-slot:activator="{ attrs, on }">\r\n                    <v-btn\r\n                        text\r\n                        color="primary"\r\n                        class=""\r\n                        v-bind="attrs"\r\n                        v-on="on"\r\n                    >\r\n                        {{ user.nombres }}\r\n                        <v-icon right>mdi-account </v-icon>\r\n                    </v-btn>\r\n                </template>\r\n\r\n                <v-list dense>\r\n                    <v-subheader>Opciones</v-subheader>\r\n                    <v-list-item-group v-model="selectedMenu" color="primary">\r\n                        <v-list-item\r\n                            v-for="(item, i) in items"\r\n                            :key="i"\r\n                            @click="SelectMenu(item.text)"\r\n                        >\r\n                            <v-list-item-icon>\r\n                                <v-icon v-text="item.icon"></v-icon>\r\n                            </v-list-item-icon>\r\n                            <v-list-item-content>\r\n                                <v-list-item-title\r\n                                    v-text="item.text"\r\n                                ></v-list-item-title>\r\n                            </v-list-item-content>\r\n                        </v-list-item>\r\n                    </v-list-item-group>\r\n                </v-list>\r\n            </v-menu>\r\n        </v-app-bar>\r\n\r\n        <v-main class="main_app">\r\n            <transition name="component-fade" mode="out-in">\r\n                <slot />\r\n            </transition>\r\n        </v-main>\r\n        <v-footer app dark>\r\n            <v-spacer />\r\n            <h6>\r\n                \x3c!--by\r\n                <a\r\n                    href="https://www.linkedin.com/in/lino-puma-ticona-a76021202/"\r\n                    target="_blank"\r\n                    class="blue--text text-decoration-none"\r\n                    >Lino Puma</a\r\n                > --\x3e\r\n            </h6>\r\n        </v-footer>\r\n    </v-app>\r\n</template>\r\n<script>\r\nimport MenuPrincipalComponent from "@/components/MenuPrincipalComponent";\r\nimport MenuFacilitadorComponent from "@/components/MenuFacilitadorComponent";\r\n\r\nexport default {\r\n    components: {\r\n        MenuPrincipalComponent,\r\n        MenuFacilitadorComponent,\r\n    },\r\n    data: () => ({\r\n        drawer: true,\r\n        attrs: {\r\n            class: "mb-1",\r\n            boilerplate: true,\r\n            elevation: 0,\r\n            loading: false,\r\n        },\r\n\r\n        closeOnContentClick: true,\r\n\r\n        items: [\r\n            { text: "Perfil", icon: "mdi-account" },\r\n            { text: "Salir", icon: "mdi-power" },\r\n        ],\r\n        selectedMenu: null,\r\n    }),\r\n    computed: {\r\n        user() {\r\n            return this.$page.props.auth.user;\r\n        },\r\n    },\r\n    methods: {\r\n        SelectMenu(op){\r\n            if(op == \'Salir\'){\r\n                this.salir();\r\n            }\r\n        },\r\n        salir() {\r\n            this.$inertia.post("/logout");\r\n        },\r\n    },\r\n    async created() {\r\n        //await this.GetCurrentUser();\r\n\r\n        this.drawer = this.$vuetify.breakpoint.width > 960 ? true : false;\r\n    },\r\n};\r\n<\/script>\r\n<style scoped>\r\n@import url(\'https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&display=swap\');\r\n* {\r\n    font-family: \'Nunito\', sans-serif;\r\n}\r\n.main_app {\r\n    background: #eeeeee;\r\n}\r\n.component-fade-enter-active,\r\n.component-fade-leave-active {\r\n    transition: opacity 0.3s ease;\r\n}\r\n.component-fade-enter, .component-fade-leave-to\r\n/* .component-fade-leave-active below version 2.1.8 */ {\r\n    opacity: 0;\r\n}\r\n.wrap-imagen {\r\n    display: flex;\r\n    justify-content: center;\r\n    align-items: center;\r\n    width: 100%;\r\n    background-color: rgba(255,255,255,.3);\r\n}\r\n</style>\r\n'],sourceRoot:""}]);const s=a},4186:(t,r,n)=>{n.d(r,{Z:()=>s});var e=n(4015),i=n.n(e),o=n(3645),a=n.n(o)()(i());a.push([t.id,".treee[data-v-65715dfe]{background:none}.treee[data-v-65715dfe]::-webkit-scrollbar{-webkit-appearance:none}.treee[data-v-65715dfe]::-webkit-scrollbar:vertical{width:10px}.treee[data-v-65715dfe]::-webkit-scrollbar-button,.treee[data-v-65715dfe]::-webkit-scrollbar-button:increment{display:none}.treee[data-v-65715dfe]::-webkit-scrollbar:horizontal{height:10px}.treee[data-v-65715dfe]::-webkit-scrollbar-thumb{background-color:#797979;border:2px solid #f1f2f3;border-radius:20px}.treee[data-v-65715dfe]::-webkit-scrollbar-track{border-radius:10px}.v-data-table_expanded.v-data-tableexpanded_content[data-v-65715dfe]{box-shadow:none!important}","",{version:3,sources:["webpack://./resources/js/Pages/Admin/Grupo/dindex.vue"],names:[],mappings:"AAkGA,wBACA,eACA,CACA,2CACA,uBACA,CAEA,oDACA,UACA,CAEA,8GAEA,YACA,CAEA,sDACA,WACA,CAEA,iDACA,wBAAA,CAEA,wBAAA,CADA,kBAEA,CAEA,iDACA,kBACA,CACA,qEACA,yBACA",sourcesContent:['<template>\r\n    <v-container>\r\n        <div>\r\n\r\n            {{oficinas}}\r\n\r\n        </div>\r\n    </v-container>\r\n</template>\r\n<script>\r\nimport Layout from "@/Layouts/AdminLayout";\r\nimport axios from "axios";\r\n\r\nexport default {\r\n\r\n    layout: Layout,\r\n    data: () => ({\r\n        oficinas:[]\r\n    }),   \r\n\r\n    methods: {\r\n\r\n        async getGrupos() {\r\n            let res = await axios.get("/facilitador/inventario/get-grupo");\r\n            this.oficinas = res.data.datos;\r\n            return res.data.datos.data;\r\n        },\r\n\r\n        customFilterOficina(item, queryText, itemText) {\r\n            const nombre = item.nombre.toLowerCase();\r\n            const iduoper = item.iduoper.toLowerCase();\r\n            const searchText = queryText.toLowerCase();\r\n            return (\r\n                nombre.indexOf(searchText) > -1 ||\r\n                iduoper.indexOf(searchText) > -1\r\n            );\r\n        },\r\n\r\n        limpiar() {\r\n            this.tree = [];\r\n            this.usuariosSelecionadas = [];\r\n            this.oficinasSelecionadas = [];\r\n        },\r\n\r\n        buscaPersonabyID(id) {\r\n            for (let i in this.usuarios) {\r\n                if (this.usuarios[i].id === id) {\r\n                    return (\r\n                        this.usuarios[i].nombres +\r\n                        " " +\r\n                        this.usuarios[i].paterno +\r\n                        " " +\r\n                        this.usuarios[i].materno\r\n                    );\r\n                }\r\n            }\r\n        },\r\n\r\n        buscaOficinabyID(id) {\r\n            for (let i in this.oficinas) {\r\n                if (this.oficinas[i].iduoper === id) {\r\n                    return this.oficinas[i].nombre;\r\n                }\r\n            }\r\n        },\r\n\r\n        async Guardar() {\r\n            let res = await axios.post("/admin/grupo/guardar", {\r\n                usuarios: this.usuariosSelecionadas,\r\n                ofici: this.oficinasSelecionadas,\r\n            });\r\n            this.dialog = false;\r\n            this.text = "Grupo Creado";\r\n            this.snackbar = true;\r\n        },\r\n        clickColumn(slotData) {\r\n            const indexRow = slotData.index;\r\n            const indexExpanded = this.expanded.findIndex(\r\n                (i) => i === slotData.item\r\n            );\r\n            if (indexExpanded > -1) {\r\n                this.expanded.splice(indexExpanded, 1);\r\n            } else {\r\n                this.expanded.push(slotData.item);\r\n            }\r\n        },\r\n    },\r\n    async created() {\r\n        // this.getItemsGroup()\r\n        await this.getUsuarios();\r\n        await this.getOficinas();\r\n        console.log("awedarafdf");\r\n        await this.getOficinasDependencias();\r\n    },\r\n};\r\n<\/script>\r\n\r\n<style scoped>\r\n.treee {\r\n    background: none;\r\n}\r\n.treee::-webkit-scrollbar {\r\n    -webkit-appearance: none;\r\n}\r\n\r\n.treee::-webkit-scrollbar:vertical {\r\n    width: 10px;\r\n}\r\n\r\n.treee::-webkit-scrollbar-button:increment,\r\n.treee::-webkit-scrollbar-button {\r\n    display: none;\r\n}\r\n\r\n.treee::-webkit-scrollbar:horizontal {\r\n    height: 10px;\r\n}\r\n\r\n.treee::-webkit-scrollbar-thumb {\r\n    background-color: #797979;\r\n    border-radius: 20px;\r\n    border: 2px solid #f1f2f3;\r\n}\r\n\r\n.treee::-webkit-scrollbar-track {\r\n    border-radius: 10px;\r\n}\r\n.v-data-table_expanded.v-data-tableexpanded_content {\r\n    box-shadow: none !important;\r\n}\r\n</style>\r\n'],sourceRoot:""}]);const s=a},8765:(t,r,n)=>{n.d(r,{Z:()=>f});var e=n(800),i=n(2608);function o(t){return o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},o(t)}function a(){a=function(){return t};var t={},r=Object.prototype,n=r.hasOwnProperty,e="function"==typeof Symbol?Symbol:{},i=e.iterator||"@@iterator",s=e.asyncIterator||"@@asyncIterator",c=e.toStringTag||"@@toStringTag";function u(t,r,n){return Object.defineProperty(t,r,{value:n,enumerable:!0,configurable:!0,writable:!0}),t[r]}try{u({},"")}catch(t){u=function(t,r,n){return t[r]=n}}function l(t,r,n,e){var i=r&&r.prototype instanceof f?r:f,o=Object.create(i.prototype),a=new C(e||[]);return o._invoke=function(t,r,n){var e="suspendedStart";return function(i,o){if("executing"===e)throw new Error("Generator is already running");if("completed"===e){if("throw"===i)throw o;return E()}for(n.method=i,n.arg=o;;){var a=n.delegate;if(a){var s=_(a,n);if(s){if(s===p)continue;return s}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if("suspendedStart"===e)throw e="completed",n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);e="executing";var c=d(t,r,n);if("normal"===c.type){if(e=n.done?"completed":"suspendedYield",c.arg===p)continue;return{value:c.arg,done:n.done}}"throw"===c.type&&(e="completed",n.method="throw",n.arg=c.arg)}}}(t,n,a),o}function d(t,r,n){try{return{type:"normal",arg:t.call(r,n)}}catch(t){return{type:"throw",arg:t}}}t.wrap=l;var p={};function f(){}function v(){}function h(){}var m={};u(m,i,(function(){return this}));var y=Object.getPrototypeOf,g=y&&y(y(L([])));g&&g!==r&&n.call(g,i)&&(m=g);var b=h.prototype=f.prototype=Object.create(m);function w(t){["next","throw","return"].forEach((function(r){u(t,r,(function(t){return this._invoke(r,t)}))}))}function x(t,r){function e(i,a,s,c){var u=d(t[i],t,a);if("throw"!==u.type){var l=u.arg,p=l.value;return p&&"object"==o(p)&&n.call(p,"__await")?r.resolve(p.__await).then((function(t){e("next",t,s,c)}),(function(t){e("throw",t,s,c)})):r.resolve(p).then((function(t){l.value=t,s(l)}),(function(t){return e("throw",t,s,c)}))}c(u.arg)}var i;this._invoke=function(t,n){function o(){return new r((function(r,i){e(t,n,r,i)}))}return i=i?i.then(o,o):o()}}function _(t,r){var n=t.iterator[r.method];if(void 0===n){if(r.delegate=null,"throw"===r.method){if(t.iterator.return&&(r.method="return",r.arg=void 0,_(t,r),"throw"===r.method))return p;r.method="throw",r.arg=new TypeError("The iterator does not provide a 'throw' method")}return p}var e=d(n,t.iterator,r.arg);if("throw"===e.type)return r.method="throw",r.arg=e.arg,r.delegate=null,p;var i=e.arg;return i?i.done?(r[t.resultName]=i.value,r.next=t.nextLoc,"return"!==r.method&&(r.method="next",r.arg=void 0),r.delegate=null,p):i:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,p)}function A(t){var r={tryLoc:t[0]};1 in t&&(r.catchLoc=t[1]),2 in t&&(r.finallyLoc=t[2],r.afterLoc=t[3]),this.tryEntries.push(r)}function k(t){var r=t.completion||{};r.type="normal",delete r.arg,t.completion=r}function C(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(A,this),this.reset(!0)}function L(t){if(t){var r=t[i];if(r)return r.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var e=-1,o=function r(){for(;++e<t.length;)if(n.call(t,e))return r.value=t[e],r.done=!1,r;return r.value=void 0,r.done=!0,r};return o.next=o}}return{next:E}}function E(){return{value:void 0,done:!0}}return v.prototype=h,u(b,"constructor",h),u(h,"constructor",v),v.displayName=u(h,c,"GeneratorFunction"),t.isGeneratorFunction=function(t){var r="function"==typeof t&&t.constructor;return!!r&&(r===v||"GeneratorFunction"===(r.displayName||r.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,h):(t.__proto__=h,u(t,c,"GeneratorFunction")),t.prototype=Object.create(b),t},t.awrap=function(t){return{__await:t}},w(x.prototype),u(x.prototype,s,(function(){return this})),t.AsyncIterator=x,t.async=function(r,n,e,i,o){void 0===o&&(o=Promise);var a=new x(l(r,n,e,i),o);return t.isGeneratorFunction(n)?a:a.next().then((function(t){return t.done?t.value:a.next()}))},w(b),u(b,c,"Generator"),u(b,i,(function(){return this})),u(b,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var r=[];for(var n in t)r.push(n);return r.reverse(),function n(){for(;r.length;){var e=r.pop();if(e in t)return n.value=e,n.done=!1,n}return n.done=!0,n}},t.values=L,C.prototype={constructor:C,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(k),!t)for(var r in this)"t"===r.charAt(0)&&n.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var r=this;function e(n,e){return a.type="throw",a.arg=t,r.next=n,e&&(r.method="next",r.arg=void 0),!!e}for(var i=this.tryEntries.length-1;i>=0;--i){var o=this.tryEntries[i],a=o.completion;if("root"===o.tryLoc)return e("end");if(o.tryLoc<=this.prev){var s=n.call(o,"catchLoc"),c=n.call(o,"finallyLoc");if(s&&c){if(this.prev<o.catchLoc)return e(o.catchLoc,!0);if(this.prev<o.finallyLoc)return e(o.finallyLoc)}else if(s){if(this.prev<o.catchLoc)return e(o.catchLoc,!0)}else{if(!c)throw new Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return e(o.finallyLoc)}}}},abrupt:function(t,r){for(var e=this.tryEntries.length-1;e>=0;--e){var i=this.tryEntries[e];if(i.tryLoc<=this.prev&&n.call(i,"finallyLoc")&&this.prev<i.finallyLoc){var o=i;break}}o&&("break"===t||"continue"===t)&&o.tryLoc<=r&&r<=o.finallyLoc&&(o=null);var a=o?o.completion:{};return a.type=t,a.arg=r,o?(this.method="next",this.next=o.finallyLoc,p):this.complete(a)},complete:function(t,r){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&r&&(this.next=r),p},finish:function(t){for(var r=this.tryEntries.length-1;r>=0;--r){var n=this.tryEntries[r];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),k(n),p}},catch:function(t){for(var r=this.tryEntries.length-1;r>=0;--r){var n=this.tryEntries[r];if(n.tryLoc===t){var e=n.completion;if("throw"===e.type){var i=e.arg;k(n)}return i}}throw new Error("illegal catch attempt")},delegateYield:function(t,r,n){return this.delegate={iterator:L(t),resultName:r,nextLoc:n},"next"===this.method&&(this.arg=void 0),p}},t}function s(t,r,n,e,i,o,a){try{var s=t[o](a),c=s.value}catch(t){return void n(t)}s.done?r(c):Promise.resolve(c).then(e,i)}const c={components:{MenuPrincipalComponent:e.Z,MenuFacilitadorComponent:i.Z},data:function(){return{drawer:!0,attrs:{class:"mb-1",boilerplate:!0,elevation:0,loading:!1},closeOnContentClick:!0,items:[{text:"Perfil",icon:"mdi-account"},{text:"Salir",icon:"mdi-power"}],selectedMenu:null}},computed:{user:function(){return this.$page.props.auth.user}},methods:{SelectMenu:function(t){"Salir"==t&&this.salir()},salir:function(){this.$inertia.post("/logout")}},created:function(){var t,r=this;return(t=a().mark((function t(){return a().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:r.drawer=r.$vuetify.breakpoint.width>960;case 1:case"end":return t.stop()}}),t)})),function(){var r=this,n=arguments;return new Promise((function(e,i){var o=t.apply(r,n);function a(t){s(o,e,i,a,c,"next",t)}function c(t){s(o,e,i,a,c,"throw",t)}a(void 0)}))})()}};var u=n(3379),l=n.n(u),d=n(2069),p={insert:"head",singleton:!1};l()(d.Z,p);d.Z.locals;const f=(0,n(1900).Z)(c,(function(){var t=this,r=t._self._c;return r("v-app",[r("v-navigation-drawer",{attrs:{app:"",color:"#01305A",dark:""},scopedSlots:t._u([{key:"append",fn:function(){return[r("v-divider"),t._v(" "),r("v-card-text",{staticClass:"text-center py-1"},[r("v-btn",{staticClass:"mx-4",attrs:{icon:"",link:""},on:{click:t.salir}},[r("v-icon",{attrs:{size:"24px",color:"blue-grey lighten-4"}},[t._v("\n                        mdi-power\n                    ")])],1)],1)]},proxy:!0}]),model:{value:t.drawer,callback:function(r){t.drawer=r},expression:"drawer"}},[r("div",{staticClass:"wrap-imagen py-4"},[r("img",{attrs:{width:"80%",src:"/images/logomin.png",alt:""}})]),t._v(" "),r("v-card",{attrs:{flat:"",rounded:"0",color:"transparent"}},[r("v-list",{staticClass:"py-0",attrs:{"two-line":""}},[r("v-list-item",[r("v-list-item-avatar",{attrs:{color:"secondary"}},[r("span",{staticClass:"white--text headline"},[r("small",[t._v(" AA ")])])]),t._v(" "),r("v-list-item-content",[r("v-list-item-title",[t._v("\n                            "+t._s(t.user.nombres)+"\n                        ")]),t._v(" "),r("v-list-item-subtitle",[t._v("\n                            "+t._s(t.user.rol)+"\n                        ")])],1)],1)],1)],1),t._v(" "),r("v-divider"),t._v(" "),r("menu-principal-component")],1),t._v(" "),r("v-app-bar",{attrs:{app:"",color:"white","scroll-off-screen":"",elevation:"3"}},[r("v-app-bar-nav-icon",{on:{click:function(r){r.stopPropagation(),t.drawer=!t.drawer}}}),t._v(" "),r("v-spacer"),t._v(" "),r("v-menu",{attrs:{"offset-y":""},scopedSlots:t._u([{key:"activator",fn:function(n){var e=n.attrs,i=n.on;return[r("v-btn",t._g(t._b({attrs:{text:"",color:"primary"}},"v-btn",e,!1),i),[t._v("\n                    "+t._s(t.user.nombres)+"\n                    "),r("v-icon",{attrs:{right:""}},[t._v("mdi-account ")])],1)]}}])},[t._v(" "),r("v-list",{attrs:{dense:""}},[r("v-subheader",[t._v("Opciones")]),t._v(" "),r("v-list-item-group",{attrs:{color:"primary"},model:{value:t.selectedMenu,callback:function(r){t.selectedMenu=r},expression:"selectedMenu"}},t._l(t.items,(function(n,e){return r("v-list-item",{key:e,on:{click:function(r){return t.SelectMenu(n.text)}}},[r("v-list-item-icon",[r("v-icon",{domProps:{textContent:t._s(n.icon)}})],1),t._v(" "),r("v-list-item-content",[r("v-list-item-title",{domProps:{textContent:t._s(n.text)}})],1)],1)})),1)],1)],1)],1),t._v(" "),r("v-main",{staticClass:"main_app"},[r("transition",{attrs:{name:"component-fade",mode:"out-in"}},[t._t("default")],2)],1),t._v(" "),r("v-footer",{attrs:{app:"",dark:""}},[r("v-spacer"),t._v(" "),r("h6")],1)],1)}),[],!1,null,"70b42944",null).exports},2582:(t,r,n)=>{n.r(r),n.d(r,{default:()=>h});var e=n(8765),i=n(9669),o=n.n(i);function a(t){return a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},a(t)}function s(){s=function(){return t};var t={},r=Object.prototype,n=r.hasOwnProperty,e="function"==typeof Symbol?Symbol:{},i=e.iterator||"@@iterator",o=e.asyncIterator||"@@asyncIterator",c=e.toStringTag||"@@toStringTag";function u(t,r,n){return Object.defineProperty(t,r,{value:n,enumerable:!0,configurable:!0,writable:!0}),t[r]}try{u({},"")}catch(t){u=function(t,r,n){return t[r]=n}}function l(t,r,n,e){var i=r&&r.prototype instanceof f?r:f,o=Object.create(i.prototype),a=new C(e||[]);return o._invoke=function(t,r,n){var e="suspendedStart";return function(i,o){if("executing"===e)throw new Error("Generator is already running");if("completed"===e){if("throw"===i)throw o;return E()}for(n.method=i,n.arg=o;;){var a=n.delegate;if(a){var s=_(a,n);if(s){if(s===p)continue;return s}}if("next"===n.method)n.sent=n._sent=n.arg;else if("throw"===n.method){if("suspendedStart"===e)throw e="completed",n.arg;n.dispatchException(n.arg)}else"return"===n.method&&n.abrupt("return",n.arg);e="executing";var c=d(t,r,n);if("normal"===c.type){if(e=n.done?"completed":"suspendedYield",c.arg===p)continue;return{value:c.arg,done:n.done}}"throw"===c.type&&(e="completed",n.method="throw",n.arg=c.arg)}}}(t,n,a),o}function d(t,r,n){try{return{type:"normal",arg:t.call(r,n)}}catch(t){return{type:"throw",arg:t}}}t.wrap=l;var p={};function f(){}function v(){}function h(){}var m={};u(m,i,(function(){return this}));var y=Object.getPrototypeOf,g=y&&y(y(L([])));g&&g!==r&&n.call(g,i)&&(m=g);var b=h.prototype=f.prototype=Object.create(m);function w(t){["next","throw","return"].forEach((function(r){u(t,r,(function(t){return this._invoke(r,t)}))}))}function x(t,r){function e(i,o,s,c){var u=d(t[i],t,o);if("throw"!==u.type){var l=u.arg,p=l.value;return p&&"object"==a(p)&&n.call(p,"__await")?r.resolve(p.__await).then((function(t){e("next",t,s,c)}),(function(t){e("throw",t,s,c)})):r.resolve(p).then((function(t){l.value=t,s(l)}),(function(t){return e("throw",t,s,c)}))}c(u.arg)}var i;this._invoke=function(t,n){function o(){return new r((function(r,i){e(t,n,r,i)}))}return i=i?i.then(o,o):o()}}function _(t,r){var n=t.iterator[r.method];if(void 0===n){if(r.delegate=null,"throw"===r.method){if(t.iterator.return&&(r.method="return",r.arg=void 0,_(t,r),"throw"===r.method))return p;r.method="throw",r.arg=new TypeError("The iterator does not provide a 'throw' method")}return p}var e=d(n,t.iterator,r.arg);if("throw"===e.type)return r.method="throw",r.arg=e.arg,r.delegate=null,p;var i=e.arg;return i?i.done?(r[t.resultName]=i.value,r.next=t.nextLoc,"return"!==r.method&&(r.method="next",r.arg=void 0),r.delegate=null,p):i:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,p)}function A(t){var r={tryLoc:t[0]};1 in t&&(r.catchLoc=t[1]),2 in t&&(r.finallyLoc=t[2],r.afterLoc=t[3]),this.tryEntries.push(r)}function k(t){var r=t.completion||{};r.type="normal",delete r.arg,t.completion=r}function C(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(A,this),this.reset(!0)}function L(t){if(t){var r=t[i];if(r)return r.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var e=-1,o=function r(){for(;++e<t.length;)if(n.call(t,e))return r.value=t[e],r.done=!1,r;return r.value=void 0,r.done=!0,r};return o.next=o}}return{next:E}}function E(){return{value:void 0,done:!0}}return v.prototype=h,u(b,"constructor",h),u(h,"constructor",v),v.displayName=u(h,c,"GeneratorFunction"),t.isGeneratorFunction=function(t){var r="function"==typeof t&&t.constructor;return!!r&&(r===v||"GeneratorFunction"===(r.displayName||r.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,h):(t.__proto__=h,u(t,c,"GeneratorFunction")),t.prototype=Object.create(b),t},t.awrap=function(t){return{__await:t}},w(x.prototype),u(x.prototype,o,(function(){return this})),t.AsyncIterator=x,t.async=function(r,n,e,i,o){void 0===o&&(o=Promise);var a=new x(l(r,n,e,i),o);return t.isGeneratorFunction(n)?a:a.next().then((function(t){return t.done?t.value:a.next()}))},w(b),u(b,c,"Generator"),u(b,i,(function(){return this})),u(b,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var r=[];for(var n in t)r.push(n);return r.reverse(),function n(){for(;r.length;){var e=r.pop();if(e in t)return n.value=e,n.done=!1,n}return n.done=!0,n}},t.values=L,C.prototype={constructor:C,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=void 0,this.done=!1,this.delegate=null,this.method="next",this.arg=void 0,this.tryEntries.forEach(k),!t)for(var r in this)"t"===r.charAt(0)&&n.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=void 0)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var r=this;function e(n,e){return a.type="throw",a.arg=t,r.next=n,e&&(r.method="next",r.arg=void 0),!!e}for(var i=this.tryEntries.length-1;i>=0;--i){var o=this.tryEntries[i],a=o.completion;if("root"===o.tryLoc)return e("end");if(o.tryLoc<=this.prev){var s=n.call(o,"catchLoc"),c=n.call(o,"finallyLoc");if(s&&c){if(this.prev<o.catchLoc)return e(o.catchLoc,!0);if(this.prev<o.finallyLoc)return e(o.finallyLoc)}else if(s){if(this.prev<o.catchLoc)return e(o.catchLoc,!0)}else{if(!c)throw new Error("try statement without catch or finally");if(this.prev<o.finallyLoc)return e(o.finallyLoc)}}}},abrupt:function(t,r){for(var e=this.tryEntries.length-1;e>=0;--e){var i=this.tryEntries[e];if(i.tryLoc<=this.prev&&n.call(i,"finallyLoc")&&this.prev<i.finallyLoc){var o=i;break}}o&&("break"===t||"continue"===t)&&o.tryLoc<=r&&r<=o.finallyLoc&&(o=null);var a=o?o.completion:{};return a.type=t,a.arg=r,o?(this.method="next",this.next=o.finallyLoc,p):this.complete(a)},complete:function(t,r){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&r&&(this.next=r),p},finish:function(t){for(var r=this.tryEntries.length-1;r>=0;--r){var n=this.tryEntries[r];if(n.finallyLoc===t)return this.complete(n.completion,n.afterLoc),k(n),p}},catch:function(t){for(var r=this.tryEntries.length-1;r>=0;--r){var n=this.tryEntries[r];if(n.tryLoc===t){var e=n.completion;if("throw"===e.type){var i=e.arg;k(n)}return i}}throw new Error("illegal catch attempt")},delegateYield:function(t,r,n){return this.delegate={iterator:L(t),resultName:r,nextLoc:n},"next"===this.method&&(this.arg=void 0),p}},t}function c(t,r,n,e,i,o,a){try{var s=t[o](a),c=s.value}catch(t){return void n(t)}s.done?r(c):Promise.resolve(c).then(e,i)}function u(t){return function(){var r=this,n=arguments;return new Promise((function(e,i){var o=t.apply(r,n);function a(t){c(o,e,i,a,s,"next",t)}function s(t){c(o,e,i,a,s,"throw",t)}a(void 0)}))}}const l={layout:e.Z,data:function(){return{oficinas:[]}},methods:{getGrupos:function(){var t=this;return u(s().mark((function r(){var n;return s().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,o().get("/facilitador/inventario/get-grupo");case 2:return n=r.sent,t.oficinas=n.data.datos,r.abrupt("return",n.data.datos.data);case 5:case"end":return r.stop()}}),r)})))()},customFilterOficina:function(t,r,n){var e=t.nombre.toLowerCase(),i=t.iduoper.toLowerCase(),o=r.toLowerCase();return e.indexOf(o)>-1||i.indexOf(o)>-1},limpiar:function(){this.tree=[],this.usuariosSelecionadas=[],this.oficinasSelecionadas=[]},buscaPersonabyID:function(t){for(var r in this.usuarios)if(this.usuarios[r].id===t)return this.usuarios[r].nombres+" "+this.usuarios[r].paterno+" "+this.usuarios[r].materno},buscaOficinabyID:function(t){for(var r in this.oficinas)if(this.oficinas[r].iduoper===t)return this.oficinas[r].nombre},Guardar:function(){var t=this;return u(s().mark((function r(){return s().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,o().post("/admin/grupo/guardar",{usuarios:t.usuariosSelecionadas,ofici:t.oficinasSelecionadas});case 2:r.sent,t.dialog=!1,t.text="Grupo Creado",t.snackbar=!0;case 6:case"end":return r.stop()}}),r)})))()},clickColumn:function(t){t.index;var r=this.expanded.findIndex((function(r){return r===t.item}));r>-1?this.expanded.splice(r,1):this.expanded.push(t.item)}},created:function(){var t=this;return u(s().mark((function r(){return s().wrap((function(r){for(;;)switch(r.prev=r.next){case 0:return r.next=2,t.getUsuarios();case 2:return r.next=4,t.getOficinas();case 4:return console.log("awedarafdf"),r.next=7,t.getOficinasDependencias();case 7:case"end":return r.stop()}}),r)})))()}};var d=n(3379),p=n.n(d),f=n(4186),v={insert:"head",singleton:!1};p()(f.Z,v);f.Z.locals;const h=(0,n(1900).Z)(l,(function(){var t=this,r=t._self._c;return r("v-container",[r("div",[t._v("\n\n        "+t._s(t.oficinas)+"\n\n    ")])])}),[],!1,null,"65715dfe",null).exports},2608:(t,r,n)=>{n.d(r,{Z:()=>i});const e={components:{Link:n(6454).rU},data:function(){return{path_name:"",active_menu:0,items:[{title:"Grupos",icon:"mdi-account-group",ruta:"/facilitador/grupo"},{title:"Inventario",icon:"mdi-clipboard-check",ruta:"/facilitador/inventario"},{title:"Reporte diario",icon:"mdi-chart-line",ruta:"/facilitador/reporte"},{title:"Bienes sin codigo",icon:"mdi-clipboard-check",ruta:"/facilitador/bienes-sin-codigo"}]}},methods:{activeMenu:function(t){this.path_name=t}},mounted:function(){this.path_name=window.location.pathname}};const i=(0,n(1900).Z)(e,(function(){var t=this,r=t._self._c;return r("div",[r("v-list",{attrs:{dense:""}},[r("v-list-item-group",{staticClass:"items-menuss",attrs:{color:"pimario"},model:{value:t.active_menu,callback:function(r){t.active_menu=r},expression:"active_menu"}},t._l(t.items,(function(n,e){return r("div",{key:e},[n.sub_menu?[r("v-list-group",{attrs:{"no-action":"",color:"pimario"},scopedSlots:t._u([{key:"activator",fn:function(){return[r("v-list-item-icon",[r("v-icon",[t._v(t._s(n.icon))])],1),t._v(" "),r("v-list-item-content",[r("v-list-item-title",[r("b",[t._v(t._s(n.title)+" ")])])],1)]},proxy:!0}],null,!0)},[t._v(" "),t._l(n.sub_menu,(function(n,e){return r("Link",{key:e,staticClass:"v-list-item v-list-item--link theme--dark",class:t.path_name==n.ruta?"v-item--active v-list-item--active":"",attrs:{href:n.ruta,color:"white",link:""},on:{click:function(r){return t.activeMenu(n.ruta)}}},[r("v-list-item-title",[r("b",[t._v(" "+t._s(n.title)+" ")])])],1)}))],2)]:[r("Link",{staticClass:"v-list-item v-list-item--link theme--dark",class:t.path_name==n.ruta?"v-item--active v-list-item--active":"",attrs:{color:"white",href:n.ruta,link:""},on:{click:function(r){return t.activeMenu(n.ruta)}}},[r("v-list-item-icon",[r("v-icon",[t._v(t._s(n.icon))])],1),t._v(" "),r("v-list-item-content",[r("v-list-item-title",[r("b",[t._v(t._s(n.title)+" ")])])],1)],1)]],2)})),0)],1)],1)}),[],!1,null,null,null).exports},800:(t,r,n)=>{n.d(r,{Z:()=>i});const e={components:{Link:n(6454).rU},data:function(){return{path_name:"",active_menu:0,items:[{title:"Dashboard",icon:"mdi-home",ruta:"/admin"},{title:"Grupos",icon:"mdi-account-group",ruta:"/admin/grupo"},{title:"Reportes",icon:"mdi-chart-bar",ruta:null,sub_menu:[{title:"Generador",icon:"mdi-chart-bar",ruta:"/admin/reportes"},{title:"Explorador",icon:"mdi-chart-bar",ruta:"/admin/reportes/explorador"}]},{title:"Administrador",icon:"mdi-cog",ruta:null,sub_menu:[{title:"Usuarios",icon:"mdi-cast-audio",ruta:"/admin/usuarios"},{title:"Personas",icon:"mdi-fencing",ruta:"/admin/personas"},{title:"Inventario",icon:"mdi-fencing",ruta:"/admin/inventario"}]}]}},methods:{activeMenu:function(t){this.path_name=t}},mounted:function(){this.path_name=window.location.pathname}};const i=(0,n(1900).Z)(e,(function(){var t=this,r=t._self._c;return r("div",[r("v-list",{attrs:{dense:""}},[r("v-list-item-group",{staticClass:"items-menuss",attrs:{color:"pimario"},model:{value:t.active_menu,callback:function(r){t.active_menu=r},expression:"active_menu"}},t._l(t.items,(function(n,e){return r("div",{key:e},[n.sub_menu?[r("v-list-group",{attrs:{"no-action":"",color:"pimario"},scopedSlots:t._u([{key:"activator",fn:function(){return[r("v-list-item-icon",[r("v-icon",[t._v(t._s(n.icon))])],1),t._v(" "),r("v-list-item-content",[r("v-list-item-title",[r("b",[t._v(t._s(n.title)+" ")])])],1)]},proxy:!0}],null,!0)},[t._v(" "),t._l(n.sub_menu,(function(n,e){return r("Link",{key:e,staticClass:"v-list-item v-list-item--link theme--dark",class:t.path_name==n.ruta?"v-item--active v-list-item--active":"",attrs:{href:n.ruta,color:"white",link:""},on:{click:function(r){return t.activeMenu(n.ruta)}}},[r("v-list-item-title",[r("b",[t._v(" "+t._s(n.title)+" ")])])],1)}))],2)]:[r("Link",{staticClass:"v-list-item v-list-item--link theme--dark",class:t.path_name==n.ruta?"v-item--active v-list-item--active":"",attrs:{color:"white",href:n.ruta,link:""},on:{click:function(r){return t.activeMenu(n.ruta)}}},[r("v-list-item-icon",[r("v-icon",[t._v(t._s(n.icon))])],1),t._v(" "),r("v-list-item-content",[r("v-list-item-title",[r("b",[t._v(t._s(n.title)+" ")])])],1)],1)]],2)})),0)],1)],1)}),[],!1,null,null,null).exports},1900:(t,r,n)=>{function e(t,r,n,e,i,o,a,s){var c,u="function"==typeof t?t.options:t;if(r&&(u.render=r,u.staticRenderFns=n,u._compiled=!0),e&&(u.functional=!0),o&&(u._scopeId="data-v-"+o),a?(c=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),i&&i.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(a)},u._ssrRegister=c):i&&(c=s?function(){i.call(this,(u.functional?this.parent:this).$root.$options.shadowRoot)}:i),c)if(u.functional){u._injectStyles=c;var l=u.render;u.render=function(t,r){return c.call(r),l(t,r)}}else{var d=u.beforeCreate;u.beforeCreate=d?[].concat(d,c):[c]}return{exports:t,options:u}}n.d(r,{Z:()=>e})}}]);
//# sourceMappingURL=2582.js.map?id=ccf1ce97561765eb