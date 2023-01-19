<template>
    <div>
        <v-list dense>
            <v-list-item-group
                v-model="active_menu"
                color="pimario"
                class="items-menuss"
            >
                <div v-for="(item, index) in items" :key="index">
                    <template v-if="!item.sub_menu">
                        <Link
                            class="v-list-item v-list-item--link theme--dark"
                            color="white"
                            :href="item.ruta"
                            link
                            :class="
                                path_name == item.ruta
                                    ? 'v-item--active v-list-item--active'
                                    : ''
                            "
                            @click="activeMenu(item.ruta)"
                        >
                            <v-list-item-icon>
                                <v-icon>{{ item.icon }}</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>
                                    <b>{{ item.title }} </b></v-list-item-title
                                >
                            </v-list-item-content>
                        </Link>
                    </template>
                    <template v-else>
                        <v-list-group no-action color="pimario">
                            <template v-slot:activator>
                                <v-list-item-icon>
                                    <v-icon>{{ item.icon }}</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        <b>{{ item.title }} </b>
                                    </v-list-item-title>
                                </v-list-item-content>
                            </template>

                            <Link
                                class="v-list-item v-list-item--link theme--dark"
                                v-for="(element, index) in item.sub_menu"
                                :key="index"
                                :href="element.ruta"
                                color="white"
                                link
                                :class="
                                    path_name == element.ruta
                                        ? 'v-item--active v-list-item--active'
                                        : ''
                                "
                                @click="activeMenu(element.ruta)"
                            >
                                <v-list-item-title>
                                    <b> {{ element.title }} </b>
                                </v-list-item-title>
                            </Link>
                        </v-list-group>
                    </template>
                </div>
            </v-list-item-group>
        </v-list>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
export default {
    components: {
        Link,
    },

    data: () => ({
        path_name: "",
        active_menu: 0,
        items: [

            {
                title: "Grupos",
                icon: "mdi-account-group",
                ruta: "/facilitador/grupo"
            },

            {
                title: "Inventario",
                icon: "mdi-clipboard-check",
                ruta: null,
                sub_menu:[
                       {
                        title: "Registros",
                        icon: "mdi-cast-audio",
                        ruta: "/facilitador/inventario"
                    },
                    {
                        title: "Reg. sin codigo",
                        icon: "mdi-fencing",
                        ruta: "/facilitador/bienes-sin-codigo"
                    },
                ]   
            },
            {
                title: "Reporte de Avance",
                icon: "mdi-chart-line",
                ruta: null,
                sub_menu:[
                       {
                        title: "Diario",
                        icon: "mdi-cast-audio",
                        ruta: "/facilitador/reporte"
                    },
                    {
                        title: "Acumulado",
                        icon: "mdi-fencing",
                        ruta: "/reporte/global"
                    },
                ]   
            },

            {
                title: "Faltantes",
                icon: "mdi-clipboard-text-search-outline",
                ruta: "/facilitador/faltantes"
            },

            {
                title: "Conciliación",
                icon: "mdi-clipboard-check",
                ruta: "/facilitador/conciliacion"
            },
            {
                title: "Mantenimiento",
                icon: "mdi-wrench",
                ruta: null,
                sub_menu:[
                       {
                        title: "Oficinas",
                        icon: "mdi-cast-audio",
                        ruta: "/facilitador/oficina"   
                    },
                    {
                        title: "Personas",
                        icon: "mdi-fencing",
                        ruta: "/facilitador/persona"
                    },
                ]   
            },

            

            // {
            //     title: "Administrador",
            //     icon: "mdi-cog",
            //     ruta: null,
            //     sub_menu: [
            //         {
            //             title: "Usuarios",
            //             icon: "mdi-cast-audio",
            //             ruta: "/admin/usuarios",
            //         },
            //         {
            //             title: "Personas",
            //             icon: "mdi-fencing",
            //             ruta: "/admin/personas",
            //         },

            //     ],
            // },
        ],
    }),
    methods: {
        activeMenu(pathname) {
            this.path_name = pathname;
        },
    },
    mounted() {
        this.path_name = window.location.pathname;
    },
};

</script>


