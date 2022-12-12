<template>
    <v-dialog v-model="dialog" fullscreen scrollable>
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="blue" outlined block dark v-bind="attrs" v-on="on">
                <v-icon left>mdi-table-search</v-icon> Correlativo 2019
            </v-btn>
        </template>
        <v-card tile>
            <v-toolbar>
                <v-app-bar-nav-icon @click="dialog = false">
                    <v-icon>mdi-arrow-left</v-icon>
                </v-app-bar-nav-icon>

                <v-toolbar-title>Buscar por Correlativo 2019</v-toolbar-title>

                <v-spacer></v-spacer>

            </v-toolbar>

            <v-card-text style="height: 90vh">

                <v-alert class="mt-3" color="blue-grey" dark dense dismissible >
                   <small>
                    Primero digite el código de área (ej. "24" FACULTAD DE CS CONTABLES Y ADMINISTRATIVA) y posteriormente el correlativo para iniciar la búsqueda.
                   </small> 
                </v-alert>

                <v-card class="mt-2" :loading="loading_table">
                    <v-overlay absolute :value="loading_table">
                        <v-progress-circular indeterminate size="64"></v-progress-circular>
                    </v-overlay>
                    <v-card-title>
                        <v-row>

                            <v-col cols="6" sm="3" md="2" class="pb-1">
                                <v-text-field v-model="corr_area" min="1" label="Area" dense outlined hide-details
                                    type="number"></v-text-field>
                            </v-col>

                            <v-col cols="6" sm="3" md="2" class="pb-1">
                                <v-text-field v-model="corr_num" min="1" label="Correlativo" dense outlined hide-details
                                    type="number" :disabled="!corr_area"></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="8" class="pb-1">
                                <v-text-field v-model="term_search" append-icon="mdi-magnify" label="Buscar"
                                    hide-details outlined dense :disabled="!corr_num"></v-text-field>
                            </v-col>

                        </v-row>
                    </v-card-title>
                    <v-simple-table>
                        <template v-slot:default>
                            <thead class="grey lighten-3">
                                <tr>
                                    <th class="text-left">Estado</th>
                                    <th class="text-left">Stiker 2019</th>
                                    <th class="text-left">Codigo</th>
                                    <th class="text-left">Descripcion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in bienes_result" :key="index"
                                    @dblclick="onSelectColumDobleClik(item)">
                                    <td>
                                        <v-list-item-avatar size="20" :color="
                                            item.registrado
                                                ? 'green'
                                                : 'grey'
                                        ">
                                            <v-icon small dark>
                                                mdi-checkbox-marked-circle
                                            </v-icon>
                                        </v-list-item-avatar>
                                    </td>
                                    <td>
                                        <small>{{ item.cod_ubicacion | correlativo }}</small>
                                    </td>
                                    <td>{{ item.codigo }}</td>
                                    <td>
                                        <small> {{ item.descripcion }} </small>
                                    </td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-pagination v-model="page" class="" :length="pages" :total-visible="5"></v-pagination>
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
        areas: Array,
    },
    data: () => ({
        loading_table: false,

        tr_index: null,
        tr_item: {},

        items_combobox: ["Todos", "Registrados", "Sin registrar"],

        dialog: false,
        area_selected: null,
        corr_area: null,
        corr_num: null,

        search: "",

        bienes_result: [],
        mostrar_selected: "Todos",
        term_search: "",

        page: 1,
        total_result: 0,
        pages: 1,
        team: [],
        //reposnable
        responsable: null,
        responsables: [],
    }),
    filters: {
        correlativo: function (value) {
            if (!value) return '-'
            let corr_area = value.split(/[-.]+/);
            //value = value.toString()
            return corr_area[0] + ' - ' + corr_area.slice(-1);
        }
    },
    methods: {
        async onSelectColumDobleClik(item) {
            item.registrado = (await item.registrado) == 1 ? true : false;

            this.$emit("setData", item);
            this.dialog = false;
            this.resetAll();
        },

        async getBienes() {
            let res = await axios.post("/inventario/get-bienes-by-correlativo?page=" + this.page, {
                corr_area: this.corr_area,
                corr_num: this.corr_num,
                term: this.term_search,
            });

            this.page = res.data.datos.current_page;
            this.total_result = res.data.datos.total;
            this.pages = res.data.datos.last_page;

            return res.data.datos.data;
        },
        resetAll() {
            this.bienes_result = [];
            this.term_search = "";
            this.corr_num = null;
            this.page = 1;
            this.total_result = 0;
            this.pages = 1;
        },
    },

    watch: {

        async term_search(val) {
            this.tr_index = null;
            this.loading_table = true;
            let res = await this.getBienes();
            this.bienes_result = res;
            this.loading_table = false;
        },

        async corr_num(val) {//correlativo
            this.tr_index = null;
            this.loading_table = true;
            let res = await this.getBienes();
            this.bienes_result = res;
            this.loading_table = false;
        },

        async page(val, old_val) {
            if (val == old_val) return;
            this.tr_index = null;
            this.loading_table = true;
            let res = await this.getBienes();
            this.bienes_result = res;
            this.loading_table = false;
        },
    },
};
</script>

<style>
.tr-selected {
    background-color: rgba(0, 0, 255, 0.2);
    border: 1px dashed #444;
    color: blue;
    font-weight: 600;
}
</style>
