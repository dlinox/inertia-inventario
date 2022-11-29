<template>
    <v-container>
        <div>
            <div class="text-center">
                <v-snackbar v-model="snackbar" :timeout="timeout">
                    {{ text }}

                    <template v-slot:action="{ attrs }">
                        <v-btn
                            color="blue"
                            text
                            v-bind="attrs"
                            @click="snackbar = false"
                        >
                            Close
                        </v-btn>
                    </template>
                </v-snackbar>
            </div>

            <v-card color="basil">
                <!-- {{oficinas}} -->

                <v-tabs
                    v-model="tab"
                    background-color="transparent"
                    color="basil"
                    grow
                >
                    <v-tab v-for="(item, ind) in tabs" :key="ind">
                        {{ item }}
                    </v-tab>
                </v-tabs>

                <v-tabs-items v-model="tab">
                    <v-tab-item href="Oficinas/Areasss">
                        <v-data-table
                            :headers="dessertHeaders"
                            :items="oficinas"
                            :expanded.sync="expanded"
                            :search="search"
                            item-key="iduoper"
                            show-expand
                            :mobile-breakpoint="10"
                        >
                            <template v-slot:top>
                                <v-toolbar
                                    flat
                                    style="
                                        margin-bottom: -30px;
                                        padding-top: 10px;
                                    "
                                >
                                    <v-spacer></v-spacer>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        class="ma-3"
                                        color="primary"
                                        @click="dialog = true"
                                    >
                                        <v-icon left
                                            >mdi
                                            mdi-account-multiple-plus</v-icon
                                        >

                                        Asignar Grupo
                                    </v-btn>
                                    <v-text-field
                                        v-model="search"
                                        append-icon="mdi-magnify"
                                        label="Buscar"
                                        outlined
                                        dense
                                        hide-details
                                        max-width="300px"
                                    ></v-text-field>
                                </v-toolbar>
                            </template>
                            <template v-slot:item.nombre="slotData">
                                <div
                                    style="cursor: pointer"
                                    @click="clickColumn(slotData)"
                                >
                                    <span class="mdi mdi-domain mr-2"></span>
                                    {{ slotData.item.nombre }}
                                </div>
                            </template>
                            <template
                                v-slot:expanded-item="{ headers, item }"
                                elevation="0"
                            >
                                <td
                                    cellpadding="0"
                                    style="background: white; transition: 2s"
                                    :colspan="headers.length"
                                    class="pa-0"
                                >
                                    <div>
                                        <AreasByOficinaGrupo :oficina="item" />
                                    </div>
                                </td>
                            </template>
                        </v-data-table>
                    </v-tab-item>
                </v-tabs-items>
            </v-card>
        </div>

        <div class="text-center">
            <v-dialog
                v-model="dialog"
                fullscreen
                hide-overlay
                transition="dialog-bottom-transition"
            >
                <v-card>
                    <v-toolbar color="primary">
                        <v-toolbar-items>
                            <v-btn icon dark @click="dialog = false">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-toolbar-items>
                        <v-toolbar-title style="color: white"
                            >Añadir grupo</v-toolbar-title
                        >
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn dark text @click="dialog = false"> </v-btn>
                        </v-toolbar-items>
                    </v-toolbar>
                    <v-card-text>
                        <v-row class="mt-2">
                            <v-col>
                                <div class="pl-4 pr-4" style="height: 40px">
                                    <v-autocomplete
                                        v-model="oficinasSelecionadas"
                                        clearable
                                        class="mt-0 pt-0"
                                        dense
                                        label="Oficinas"
                                        outlined
                                        :items="oficinas_de"
                                        item-value="oficinas_ids"
                                        item-text="dependencia"
                                        required
                                        multiple
                                    >
                                        <template
                                            v-slot:selection="{ item, index }"
                                        >
                                            <v-chip v-if="index === 0">
                                                <span>{{
                                                    item.dependencia
                                                }}</span>
                                            </v-chip>
                                            <span
                                                v-if="index === 1"
                                                class="grey--text text-caption"
                                            >
                                                (+{{
                                                    oficinasSelecionadas.length -
                                                    1
                                                }}
                                                others)
                                            </span>
                                        </template>
                                        <template v-slot:no-data>
                                            <v-list-item>
                                                <v-list-item-title>
                                                    <template>
                                                        No hay registros en el
                                                        inventario
                                                    </template>
                                                </v-list-item-title>
                                            </v-list-item>
                                        </template>
                                    </v-autocomplete>
                                </div>
                                <div class="mt-2"></div>

                                <div class="pl-4 pr-4" style="height: 40px">
                                    <v-autocomplete
                                        v-model="usuariosSelecionadas"
                                        clearable
                                        class="mt-0 pt-0"
                                        dense
                                        label="Usuarios"
                                        outlined
                                        :items="usuarios"
                                        :filter="customFilterUsuario"
                                        item-value="id"
                                        item-text="nombre"
                                        :search-input.sync="usuarios_search"
                                        required
                                        multiple
                                    >
                                        <template
                                            v-slot:selection="{ item, index }"
                                        >
                                            <v-chip v-if="index === 0">
                                                <span
                                                    >{{ item.nombres }}
                                                    {{ item.paterno }}
                                                    {{ item.materno }}
                                                </span>
                                            </v-chip>
                                            <span
                                                v-if="index === 1"
                                                class="grey--text text-caption"
                                            >
                                                (+{{
                                                    usuariosSelecionadas.length -
                                                    1
                                                }}
                                                others)
                                            </span>
                                        </template>
                                        <template v-slot:no-data>
                                            <v-list-item>
                                                <v-list-item-title>
                                                    <template>
                                                        No hay registros en el
                                                        inventario
                                                    </template>
                                                </v-list-item-title>
                                            </v-list-item>
                                        </template>

                                        <template v-slot:item="data">
                                            <v-list-item-content>
                                                <v-list-item-title
                                                    v-html="data.item.dni"
                                                >
                                                </v-list-item-title>
                                                <v-list-item-subtitle>
                                                    {{ data.item.nombres }}
                                                    {{ data.item.paterno }}
                                                    {{ data.item.materno }}
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </template>
                                    </v-autocomplete>
                                </div>
                                <v-row>
                                    <div
                                        class="mt-4"
                                        lg="12"
                                        md="12"
                                        sm="12"
                                        xs="12"
                                        style="width: 100vw"
                                    >
                                        <div
                                            style="
                                                overflow-y: scroll;
                                                height: 460px;
                                            "
                                            class="treee"
                                        >
                                            <div class="pa-7 pr-4 pb-0 pt-2">
                                                <span
                                                    style="
                                                        color: #000000;
                                                        font-size: 1rem;
                                                    "
                                                    >Usuarios Selecionados</span
                                                >
                                                <v-card
                                                    elevation="0"
                                                    style="
                                                        border: solid 0.5px
                                                            #cdcdcd;
                                                        min-height: 110px;
                                                    "
                                                >
                                                    <!-- <v-card-title> <span style="font-size:1rem;"> Usuarios Selecionadas</span></v-card-title> -->
                                                    <v-card-text>
                                                        <div
                                                            v-for="item in usuariosSelecionadas"
                                                            :key="item.id"
                                                        >
                                                            <span
                                                                class="mdi mdi-label-outline"
                                                            ></span>
                                                            {{
                                                                buscaPersonabyID(
                                                                    item
                                                                )
                                                            }}
                                                        </div>
                                                    </v-card-text>
                                                </v-card>
                                            </div>
                                            <div class="pa-7 pr-4 pt-2">
                                                <span
                                                    style="
                                                        color: #000000;
                                                        font-size: 1rem;
                                                    "
                                                    >Oficinas Selecionadas</span
                                                >
                                                <v-card
                                                    elevation="0"
                                                    style="
                                                        border: solid 0.5px
                                                            #cdcdcd;
                                                        min-height: 200px;
                                                    "
                                                >
                                                    <!-- <v-card-title><span style="font-size:1rem;"> Areas Selecionadas</span></v-card-title> -->
                                                    <v-card-text>
                                                        <div
                                                            v-for="item in oficinasSelecionadas"
                                                            :key="item.id"
                                                        >
                                                            <span
                                                                class="mdi mdi-label-outline"
                                                            ></span>
                                                            {{
                                                                buscaOficinabyID(
                                                                    item
                                                                )
                                                            }}
                                                        </div>
                                                    </v-card-text>
                                                </v-card>
                                            </div>
                                        </div>
                                        <div></div>
                                    </div>
                                </v-row>

                                <v-card-actions>
                                    <v-btn text @click="limpiar"> Reset </v-btn>

                                    <v-spacer></v-spacer>

                                    <v-btn
                                        class="white--text"
                                        color="primary darken-1"
                                        depressed
                                        @click="Guardar"
                                    >
                                        Guardar
                                        <v-icon right>
                                            mdi-content-save
                                        </v-icon>
                                    </v-btn>
                                </v-card-actions>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </div>
    </v-container>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
import axios from "axios";
import AreasByOficinaGrupo from "./Components/AreasByOfcinaGrupo.vue";

export default {
    components: { AreasByOficinaGrupo },

    layout: Layout,
    data: () => ({
        tree: [],
        types: [],
        items: [],
        open: [1, 2],
        search: null,
        caseSensitive: false,
        usuarios: [],
        oficinas: [],
        usuariosSelecionadas: null,
        oficinasSelecionadas: null,
        usuarios_search: "",
        oficinas_search: "",
        search: "",
        dialog: false,

        snackbar: false,
        text: "",
        timeout: 2000,

        tab: null,
        tabs: ["Oficinas/Areas", "Usuarios"],
        text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",

        expanded: [],
        dessertHeaders: [
            {
                text: "",
                align: "start",
                sortable: false,
                value: "nombre",
            },
            { text: "name", value: "data-table-expand" },
        ],

        oficinas_de: [],
    }),

    computed: {
        filter() {
            return this.caseSensitive
                ? (item, search, textKey) => item[textKey].indexOf(search) > -1
                : undefined;
        },
    },
    methods: {
        async getItemsGroup() {
            let res = await axios.get("/admin/grupo/items-group");
            this.items = res.data.datos;
            return res.data.datos.data;
        },

        async getUsuarios() {
            let res = await axios.get("/admin/usuarios/getUsuariosAll");
            this.usuarios = res.data.datos;
            return res.data.datos.data;
        },

        async getOficinas() {
            let res = await axios.get("/admin/oficinas/getallOficinasG");
            this.oficinas = res.data.datos;
            return res.data.datos.data;
        },
        async getOficinasDependencias() {
            let res = await axios.get(
                "/admin/oficinas/getallOficinasDependencia"
            );
            this.oficinas_de = res.data.datos;

            console.log(res.data);
        },

        // async getOficinas() {
        //     let res = await axios.get("/admin/oficina/o");
        //     this.oficinas = res.data.datos;
        //     return res.data.datos.data;
        // },

        customFilterUsuario(item, queryText, itemText) {
            const nombres = item.nombres.toLowerCase();
            //const dni = item.dni.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                nombres.indexOf(searchText) > -1 //||
                //dni.indexOf(searchText) > -1
            );
        },

        customFilterOficina(item, queryText, itemText) {
            const nombre = item.nombre.toLowerCase();
            const iduoper = item.iduoper.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                nombre.indexOf(searchText) > -1 ||
                iduoper.indexOf(searchText) > -1
            );
        },

        limpiar() {
            this.tree = [];
            this.usuariosSelecionadas = [];
            this.oficinasSelecionadas = [];
        },

        buscaPersonabyID(id) {
            for (let i in this.usuarios) {
                if (this.usuarios[i].id === id) {
                    return (
                        this.usuarios[i].nombres +
                        " " +
                        this.usuarios[i].paterno +
                        " " +
                        this.usuarios[i].materno
                    );
                }
            }
        },

        buscaOficinabyID(id) {
            for (let i in this.oficinas) {
                if (this.oficinas[i].iduoper === id) {
                    return this.oficinas[i].nombre;
                }
            }
        },

        async Guardar() {
            let res = await axios.post("/admin/grupo/guardar", {
                usuarios: this.usuariosSelecionadas,
                ofici: this.oficinasSelecionadas,
            });
            this.dialog = false;
            this.text = "Grupo Creado";
            this.snackbar = true;
        },
        clickColumn(slotData) {
            const indexRow = slotData.index;
            const indexExpanded = this.expanded.findIndex(
                (i) => i === slotData.item
            );
            if (indexExpanded > -1) {
                this.expanded.splice(indexExpanded, 1);
            } else {
                this.expanded.push(slotData.item);
            }
        },
    },
    async created() {
        // this.getItemsGroup()
        await this.getUsuarios();
        await this.getOficinas();
        console.log("awedarafdf");
        await this.getOficinasDependencias();
    },
};
</script>

<style scoped>
.treee {
    background: none;
}
.treee::-webkit-scrollbar {
    -webkit-appearance: none;
}

.treee::-webkit-scrollbar:vertical {
    width: 10px;
}

.treee::-webkit-scrollbar-button:increment,
.treee::-webkit-scrollbar-button {
    display: none;
}

.treee::-webkit-scrollbar:horizontal {
    height: 10px;
}

.treee::-webkit-scrollbar-thumb {
    background-color: #797979;
    border-radius: 20px;
    border: 2px solid #f1f2f3;
}

.treee::-webkit-scrollbar-track {
    border-radius: 10px;
}
.v-data-table_expanded.v-data-tableexpanded_content {
    box-shadow: none !important;
}
</style>
