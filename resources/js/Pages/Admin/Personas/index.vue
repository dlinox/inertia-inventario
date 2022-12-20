<template>
    <div class="wrapper-page">
        <div class="page-heading">
            <div class="page-details">
                <v-toolbar outlined color="grey lighten-3" elevation="0">
                    <v-toolbar-title>
                        <v-app-bar-nav-icon @click="drawer = !drawer">
                            <v-icon>mdi-filter-menu</v-icon>
                        </v-app-bar-nav-icon>
                        Personas
                    </v-toolbar-title>
                </v-toolbar>
            </div>
            <div class="page-search">
                <v-toolbar outlined color="grey lighten-5" elevation="0">
                    <v-text-field v-model="usuario_search" append-icon="mdi-magnify" label="Buscar" hide-details
                        outlined dense></v-text-field>
                </v-toolbar>
            </div>
        </div>
        <div class="content-wrapper">
            <v-navigation-drawer absolute v-model="drawer" color="grey lighten-5">
                <v-container>
                    <v-btn block color="primary" @click="
                        () => {
                            this.$inertia.get('/admin/personas/formulario');
                        }
                    ">
                        <v-icon left>mdi-plus</v-icon>
                        Nuevo
                    </v-btn>

                    <div class="mt-5">
                        <h5 class="pb-3 grey--text text--darken-2">
                            Filtar por Tipo
                        </h5>

                        <v-autocomplete v-model="tipo" :items="tipos" item-text="name" item-value="id" label="Tipo"
                            outlined dense clearable></v-autocomplete>
                    </div>
                </v-container>
            </v-navigation-drawer>
            <div class="content" :class="drawer ? '' : 'full'">
                <v-container>
                    <v-card :loading="loading_table">
                        <v-overlay absolute :value="loading_table">
                            <v-progress-circular indeterminate size="64"></v-progress-circular>
                        </v-overlay>
                        <v-simple-table>
                            <template v-slot:default>
                                <thead class="grey lighten-1">
                                    <tr>
                                        <th class="text-left">ID</th>
                                        <th class="text-left">Nombres</th>
                                        <th class="text-left">A. Paterno</th>
                                        <th class="text-left">A. Materno</th>
                                        <th class="text-left">DNI</th>
                                        <th class="text-left">Tipo</th>
                                        <th class="text-left d-flex" style="width: 60px">
                                            <v-icon class="mr-1" color="primary" style="cursor: pointer"
                                                @click="dialogImpExp = true">mdi-arrow-up-bold-box-outline</v-icon>
                                            <v-icon class="ml-1" color="primary" style="cursor: pointer"
                                                @click="descargarExcel()">mdi-arrow-down-bold-box-outline</v-icon>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in list_usuarios" :key="index">
                                        <td>{{ item.id }}</td>
                                        <td>{{ item.nombres }}</td>
                                        <td>{{ item.paterno }}</td>
                                        <td>
                                            {{ item.materno }}
                                        </td>

                                        <td>
                                            {{ item.dni }}
                                        </td>

                                        <td>
                                            {{ item.tipo_nombre }}
                                        </td>

                                        <td>

                                            <v-btn icon text color="primary" class=""
                                                @click="getFormularioUsuario(item.id)">
                                                <v-icon>
                                                    mdi-plus-circle
                                                </v-icon>
                                            </v-btn>
                                        </td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>

                        <v-pagination v-model="page" class="" :length="pages" :total-visible="5"></v-pagination>
                    </v-card>
                </v-container>
            </div>
        </div>

        <v-dialog transition="dialog-top-transition" max-width="500" persistent v-model="dialog_asignar">
            <v-card>
                <v-card-title primary-title>
                    Asignar Area - {{ user_asignar.nombres }}
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="mt-3">
                    <SelectOficina v-model="oficina_asig"></SelectOficina>

                    <v-autocomplete v-model="area_asig" :items="areas_asig" item-text="nombre" item-value="id"
                        label="Seleccione un Area" outlined dense multiple></v-autocomplete>

                    <v-btn class="mr-3" text color="red" @click="dialog_asignar = false">
                        cancelar
                    </v-btn>
                    <v-btn :disabled="!area_asig.length > 0" color="success" @click="guardarAsingar">
                        Asignar
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogImpExp" width="600px">
            <v-card>
                <v-card-title>
                    <span class="text-h6">Importar Personas </span>
                </v-card-title>
                <v-card-text>
                    <v-file-input id="archivoExcel" type="file" label="File input" @change="subirExcel()"
                        append-icon=""></v-file-input>
                    <v-simple-table v-if="personasImp.length > 0">
                        <template v-slot:default>
                            <tbody>
                                <tr v-for="(item, index) in personasImp" :key="index">
                                    <td>{{ item[0] }}</td>
                                    <td>{{ item[1] }}</td>
                                    <td>{{ item[2] }}</td>
                                    <td>{{ item[3] }}</td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary darken-1" primary @click="dialogImpExp = false" NoCaps outlined>
                        Cancelar
                    </v-btn>
                    <v-btn color="primary darken-1" primary @click="guardarImportados" NoCaps>
                        Guardar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
import SelectOficina from "@/components/autocomplete/SelectOficina.vue";
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";
import readXlsFile from "read-excel-file";
import exportFromJSON from "export-from-json";

export default {
    metaInfo: { title: "Usuarios" },
    layout: Layout,
    props: {
        roles: Array,
    },

    data: () => ({
        tipos: [
            { id: 1, name: "Docente" },
            { id: 2, name: "Administrativo" },
            { id: 3, name: "C.A.S." },
        ],
        dialog_asignar: false,
        user_asignar: {},
        itemsOptions: [
            { text: "Editar", icon: "mdi-pen" },
            { text: "Eliminar", icon: "mdi-delete" },
        ],
        loading_table: false,
        oficina: null,
        areas: [],
        area: null,

        rol: null,
        tipo: null,

        oficina_asig: null,
        area_asig: [],
        areas_asig: null,

        absolute: false,
        drawer: true,

        page: 1,
        total_result: 0,
        pages: 1,
        usuario_search: "",
        list_usuarios: [],

        dialogImpExp: false,
        personasImp: [],

        headerImport: [
            { text: "Dni", value: "0" },
            { text: "Nombres ", value: "1" },
            { text: "Paterno", value: "2" },
            { text: "Materno", value: "3" },
        ],
    }),
    computed: {
        size_display: {
            get: function () {
                if (this.$vuetify.breakpoint.width > 960) {
                    this.absolute = false;
                    return true;
                }
                this.absolute = true;
                return false;
            },
            set: function (newValue) { },
        },
    },
    methods: {
        async getUsuarios(term = "", tipo = "", page = 1) {
            this.loading_table = true;
            let res = await axios.post(
                "/admin/personas/get-personas?page=" + page,
                {
                    term: term,
                    tipo: tipo,
                }
            );
            console.log(res.data.datos.data);

            this.page = res.data.datos.current_page;
            this.total_result = res.data.datos.total;
            this.pages = res.data.datos.last_page;

            this.loading_table = false;

            return res.data.datos.data;
        },

        async aplicarFiltros() {
            let res = await this.getUsuarios(
                this.usuario_search,
                this.rol,
                this.oficina,
                this.area
            );
            this.list_usuarios = res;
        },
        async eliminarFiltros() {
            this.usuario_search = null;
            this.rol = null;
            this.oficina = null;
            this.area = null;
            let res = await this.getUsuarios();
            this.list_usuarios = res;
        },
        SelectMenu(op, user) {
            if (op == "Editar") {
                this.getFormularioUsuario(user.id);
            }
        },

        async getFormularioUsuario(id = "") {
            Inertia.get("/admin/personas/formulario/" + id);
            //let res = await axios.get("/admin/usuarios/get-formulario/" + id);
            //console.log(res.data);
        },

        async asignarArea(user) {
            console.log(user);
            this.user_asignar = user;
            this.dialog_asignar = true;
        },

        async guardarAsingar() {
            let res = await axios.post("/admin/usuarios/asignar-area", {
                areas: this.area_asig,
                usuario: this.user_asignar.id,
            });

            this.list_usuarios = await this.getUsuarios();
            this.user_asignar = {};
            this.dialog_asignar = false;
        },

        subirExcel() {
            const input = document.getElementById("archivoExcel");
            readXlsFile(input.files[0]).then((rows) => {
                this.personasImp = rows;
            });
        },
        descargarExcel() {

            const data = this.list_usuarios;
            const filename = "personas";
            const exportType = exportFromJSON.types.xls;
            exportFromJSON({ data, filename, exportType });
        },
        async guardarImportados() {
            await axios.post("/admin/personas/savePersonasImport", {
                data: this.personasImp,
            });
            this.list_usuarios = await this.getUsuarios();
        },
    },
    async created() {
        this.drawer = this.$vuetify.breakpoint.width > 960 ? true : false;
        this.absolute = this.$vuetify.breakpoint.width > 960 ? false : true;
        this.list_usuarios = await this.getUsuarios();

        console.log(this.list_usuarios);
    },

    watch: {
        async usuario_search(val) {
            if (!val) return;

            let res = await this.getUsuarios(val, this.tipo);
            this.list_usuarios = res;
        },
        async page(val, old_val) {
            if (!val) return;
            if (val == old_val) return;
            //this.loading_table = true;
            let res = await this.getUsuarios(
                this.usuario_search,
                this.tipo,
                val
            );
            this.list_usuarios = res;
            //this.loading_table = false;
        },

        async oficina(val) {
            if (!val) return;
            let res = await axios.get("/get-data/areas/by-oficina/" + val);
            this.areas = res.data.datos;
        },

        async oficina_asig(val) {
            if (!val) return;
            let res = await axios.get("/get-data/areas/by-oficina/" + val);
            this.areas_asig = res.data.datos;
        },

        async tipo(val) {
            if (!val) return;
            let res = await this.getUsuarios(this.usuario_search, val);
            this.list_usuarios = res;
        },
    },
    components: { SelectOficina },
};
</script>

<style>
.wrapper-page {
    width: 100%;
    height: 100%;
    background-color: #fafafa;
}

.page-heading {
    display: flex;
    justify-content: space-between;
}

.page-details {
    width: 256px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    border-right: 1px solid rgba(0, 0, 0, 0.1);
}

.page-search {
    width: calc(100% - 256px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.content-wrapper {
    position: relative;
    display: flex;
    width: 100%;
    height: 100%;
}

.content {
    width: 100%;
    margin-left: 256px;
    transition: all 0.3s ease;
}

.content.full {
    width: 100%;
    margin-left: 0;
}

@media (max-width: 960px) {
    .content {
        margin-left: 0;
    }

    .page-details {
        width: 200px;
    }

    .page-search {
        width: calc(100% - 200px);
    }
}

@media (max-width: 740px) {
    .page-details {
        width: 180px;
    }

    .page-search {
        width: calc(100% - 180px);
    }
}
</style>
