<template>
    <v-dialog v-model="dialog" fullscreen scrollable>
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                class="mx-sm-2 order-sm-3"
                dark
                color="primary"
                v-bind="attrs"
                v-on="on"
            >
                <v-icon>mdi-magnify-expand</v-icon>
            </v-btn>
        </template>

        <v-card tile>
            <v-toolbar>
                <v-app-bar-nav-icon @click="dialog = false">
                    <v-icon>mdi-arrow-left</v-icon>
                </v-app-bar-nav-icon>

                <v-toolbar-title>Busqueda Avanzada</v-toolbar-title>
            </v-toolbar>

            <v-card-text style="height: 90vh">
                <v-row class="mt-3">
                    <v-col cols="12" class="pb-1 pt-0">
                        <v-autocomplete
                            v-model="oficina_selected"
                            :items="oficinas"
                            label="Oficinas"
                            item-value="iduoper"
                            item-text="nombre"
                            class="mt-0 pt-0"
                            required
                            clearable
                            dense
                            outlined
                        >
                            <template v-slot:selection="data">
                                <small>
                                    <strong>{{ data.item.codigo }}</strong>
                                    {{ data.item.nombre }}</small
                                >
                            </template>
                            <template v-slot:item="data">
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-html="data.item.codigo"
                                    >
                                    </v-list-item-title>
                                    <v-list-item-subtitle>
                                        {{ data.item.nombre }}
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                            </template>
                        </v-autocomplete>
                    </v-col>
                </v-row>

                <v-card :loading="loading_table">
                    <v-overlay absolute :value="loading_table">
                        <v-progress-circular
                            indeterminate
                            size="64"
                        ></v-progress-circular>
                    </v-overlay>
                    <v-card-title>
                        <v-row>
                            <v-col cols="12" sm="5" class="pb-1">
                                <v-combobox
                                    v-model="mostrar_selected"
                                    :items="items_combobox"
                                    label="Mostrar"
                                    outlined
                                    hide-details
                                    dense
                                ></v-combobox>
                            </v-col>
                            <v-col cols="12" sm="7" class="pb-1">
                                <v-text-field
                                    v-model="area_search"
                                    append-icon="mdi-magnify"
                                    label="Buscar"
                                    hide-details
                                    outlined
                                    dense
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-simple-table>
                        <template v-slot:default>
                            <thead class="grey lighten-3">
                                <tr>
                                    <th class="text-left">Estado</th>
                                    <th class="text-left">Descripcion</th>
                                    <th class="text-left">Codigo</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(item, index) in bienes_result"
                                    :key="index"
                                    :class="[
                                        index == tr_index ? 'tr-selected' : '',
                                    ]"
                                    @click="onSelectColum(item, index)"
                                    @dblclick="onSelectColumDobleClik(item)"
                                >
                                    <td>
                                        <template v-if="item.registrado == 1">
                                            <v-chip
                                                small
                                                color="grey"
                                                outlined
                                                class="ma-2"
                                            >
                                                <small>REGISTRADO</small>
                                            </v-chip>
                                        </template>
                                        <template v-else>
                                            <v-chip
                                                small
                                                color="orange"
                                                outlined
                                                class="ma-2"
                                            >
                                                <small>NO REGISTRADO</small>
                                            </v-chip>
                                        </template>
                                    </td>
                                    <td>{{ item.descripcion }}</td>
                                    <td>{{ item.codigo }}</td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-pagination
                            v-model="page"
                            class=""
                            :total-visible="5"
                            :length="pages"
                        ></v-pagination>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-card-text>
            <v-divider></v-divider>

            <v-card-actions>
                <h5>Total: {{ total_result }}</h5>
                <v-spacer></v-spacer>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
import axios from "axios";

export default {
    props: {
        oficinas: Array,
    },
    data: () => ({
        loading_table: false,

        tr_index: null,
        tr_item: {},

        items_combobox: ["Todos", "Registrados", "Sin registrar"],

        dialog: false,
        area_selected: null,
        search: "",

        bienes_result: [],
        mostrar_selected: "Todos",
        area_search: "",

        page: 1,
        total_result: 0,
        pages: 1,

        oficina_selected: null,
        oficinas_res: [],
        oficinas_search: "",

        area_selected: null,
        areas_by_oficna: [],
    }),

    methods: {
        async Editar(id) {
            let res = await axios.get("/inventario/get-inventario/" + id);
        },

        onSelectColum(item, index) {
            this.tr_index = index;
            this.tr_item = item;
        },
        onSelectColumDobleClik(item) {
            item.registrado = item.registrado == 1 ? true : false;
            this.$emit("setData", item);
            this.dialog = false;
            this.resetAll();
        },
        SeleccionarBien() {
            tr_item.registrado = tr_item.registrado == 1 ? true : false;
            this.$emit("setData", this.tr_item);
            this.dialog = false;
        },

        async getBienes(area, term = "", mostrar = "Todos", page = 1) {
            let res = await axios.post("/inventario/get-bienes?page=" + page, {
                area: area,
                mostrar: mostrar,
                term: term,
            });

            this.page = res.data.datos.current_page;
            this.total_result = res.data.datos.total;
            this.pages = res.data.datos.last_page;

            return res.data.datos.data;
        },

        customFilterOficina(item, queryText, itemText) {
            const nombre = item.nombre.toLowerCase();
            const codigo = item.codigo.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                nombre.indexOf(searchText) > -1 ||
                codigo.indexOf(searchText) > -1
            );
        },

        async BuscarOficinas(term) {
            let res = await axios.get("/inventario/search-oficinas/" + term);
            return res.data.datos;
        },

        resetAll() {
            this.bienes_result = [];
            this.area_selected = null;
            this.page = 1;
            this.total_result = 0;
            this.pages = 1;
        },
    },

    watch: {
        async area_selected(val) {
            if (!val) return;

            this.tr_index = null;
            this.loading_table = true;
            let res = await this.getBienes(val);
            this.bienes_result = res;
            this.loading_table = false;
        },

        async oficinas_search(val) {
            if (!val) return;
            if (val.length < 2) return;

            let res = await this.BuscarOficinas(val);
            this.oficinas_res = res;
        },

        async oficina_selected(val) {
            this.tr_index = null;
            this.loading_table = true;
            console.log(val);
            let res = await this.getBienes(val);
            this.bienes_result = res;
            this.loading_table = false;
        },

        async area_search(val) {
            //if (!val) return;

            this.tr_index = null;
            this.loading_table = true;
            let res = await this.getBienes(
                this.area_selected,
                val,
                this.mostrar_selected
            );
            this.bienes_result = res;
            this.loading_table = false;
        },

        async page(val, old_val) {
            if (val == old_val) return;

            this.tr_index = null;
            this.loading_table = true;

            let res = await this.getBienes(
                this.area_selected,
                this.area_search,
                this.mostrar_selected,
                val
            );
            this.bienes_result = res;

            this.loading_table = false;
        },

        async mostrar_selected(val) {
            this.tr_index = null;
            this.loading_table = true;
            let res = await this.getBienes(
                this.area_selected,
                this.area_search,
                val
            );
            this.bienes_result = res;
            this.loading_table = false;
        },
    },
};
</script>

<style>
.tr-selected {
    background-color: rgba(1, 48, 90, 0.2);
    border: 1px dashed #444;
    color: #01305a;
    font-weight: 600;
}
</style>
