<template>
    <v-dialog v-model="dialog" fullscreen scrollable>
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" block dark v-bind="attrs" v-on="on">
                Areas Asignadas (Lotes)
            </v-btn>
        </template>
        <v-card tile>
            <v-toolbar>
                <v-app-bar-nav-icon @click="dialog = false">
                    <v-icon>mdi-arrow-left</v-icon>
                </v-app-bar-nav-icon>

                <v-toolbar-title> Areas Asignadas</v-toolbar-title>

                <v-spacer></v-spacer>

            </v-toolbar>

            <v-card-text style="height: 90vh">

                <v-autocomplete v-model="area_selected" :items="areas" item-text="nombre" item-value="iduoper"
                    label="Seleccione un Area" class="mt-4" outlined dense>
                    <template v-slot:selection="data">
                        <small>
                            <strong>{{ data.item.dependencia }}</strong>
                            {{ data.item.nombre }}</small>
                    </template>
                    <template v-slot:item="data">
                        <v-list-item-content>
                            <v-list-item-title v-html="data.item.dependencia">
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                {{ data.item.nombre }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </template>
                </v-autocomplete>

                <v-autocomplete v-model="responsable" clearable dense label="Responsable" outlined :items="responsables"
                    item-value="dni" item-text="text">
                    <template v-slot:no-data>
                        <small class="px-3 text-center">Sin datos (Seleccione un area)</small>
                    </template>
                </v-autocomplete>


                <v-card :loading="loading_table">
                    <v-overlay absolute :value="loading_table">
                        <v-progress-circular indeterminate size="64"></v-progress-circular>
                    </v-overlay>
                    <v-card-title>
                        <v-row>
                            <v-col cols="6" sm="7" class="pb-1">
                                <v-combobox v-model="mostrar_selected" :items="items_combobox" label="Mostrar" outlined
                                    hide-details dense></v-combobox>
                            </v-col>
                            <v-col cols="6" sm="5" class="pb-1">
                                <v-text-field v-model="corr_search" min="1" label="Stiker 2019" dense outlined
                                    hide-details :prefix="
                                    area_selected ? area_selected.split('.')[0] + ' - ' : ''"
                                    type="number"></v-text-field>
                            </v-col>
                            <v-col cols="12" class="pb-1">
                                <v-text-field v-model="area_search" append-icon="mdi-magnify" label="Buscar"
                                    hide-details outlined dense></v-text-field>
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
                                    :class="[items_selected.some(elem => elem.id === item.id) ? 'tr-selected' : '',]"
                                    @click="onSelectColum(item)">
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
                <v-btn color="primary" @click="emitSelections">
                    selecionar ({{ items_selected.length }})
                </v-btn>
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
        corr_search: null,
        search: "",

        bienes_result: [],
        mostrar_selected: "Todos",
        area_search: "",

        page: 1,
        total_result: 0,
        pages: 1,
        team: [],
        //reposnable
        responsable: null,
        responsables: [],

        items_selected: [],
    }),
    filters: {
        correlativo: function (value) {
            if (!value) return '-'
            let corr_area = value.split(/[-.]+/);
            return corr_area[0] + ' - ' + corr_area.slice(-1);
        }
    },
    methods: {
        onSelectColum(item) {

            let existe = this.items_selected.some(elem => elem.id == item.id);
            if (!existe) {
                console.log('Agregado ', item.id);
                this.items_selected.push(item);
            }
            else {
                this.items_selected = this.items_selected.filter(elem => {
                    if (elem.id != item.id) return elem;
                });
                console.log('Eliminado ', item.id);
            }
        },

        emitSelections() {
            this.$emit("setData", this.items_selected);
            this.dialog = false;
        },

        async getBienes() {
            let res = await axios.post("/inventario/get-bienes?page=" + this.page, {
                area: this.area_selected,
                responsable: this.responsable,
                mostrar: this.mostrar_selected,
                correlativo: this.corr_search,
                term: this.area_search,
            });

            this.page = res.data.datos.current_page;
            this.total_result = res.data.datos.total;
            this.pages = res.data.datos.last_page;

            return res.data.datos.data;
        },

        async getResonsables(area) {
            let res = await axios.get("/inventario/get-responsables/" + area);
            return res.data.datos;
        },

        async getTeam() {
            let res = await axios.get(
                "inventario/getTeam/" + this.area_selected
            );

            this.team = res.data.datos;
            //            return res.data.datos.data;
        },
        SeleccionarBien() {
            tr_item.registrado = tr_item.registrado == 1 ? true : false;
            this.$emit("setData", this.tr_item);
            this.dialog = false;
            this.resetAll();
        },

        personasFilter(item, queryText, itemText) {
            const nombres = item.nombres.toLowerCase();
            //const paterno = item.paterno.toLowerCase();
            //const materno = item.materno.toLowerCase();
            const dni = item.dni.toLowerCase();

            const searchText = queryText.toLowerCase();

            return (
                nombres.indexOf(searchText) > -1 ||
                //paterno.indexOf(searchText) > -1 ||
                //materno.indexOf(searchText) > -1 ||
                dni.indexOf(searchText) > -1
            );
        },

        resetAll() {
            this.bienes_result = [];
            this.area_selected = null;
            this.area_search = "";
            this.corr_search = null;
            this.responsable = null;
            this.responsables = [];
            this.page = 1;
            this.total_result = 0;
            this.pages = 1;
            this.mostrar_selected = "Todos";
        },
    },

    watch: {
        async area_selected(val) {
            if (!val) return;

            this.tr_index = null;
            this.loading_table = true;
            let res = await this.getBienes();

            this.responsables = await this.getResonsables(val);

            this.bienes_result = res;
            this.loading_table = false;
        },

        async responsable(val) {
            this.tr_index = null;
            this.loading_table = true;
            let res = await this.getBienes(
                this.area_selected,
                val,
                this.area_search,
                this.mostrar_selected,
                this.corr_search
            );
            this.bienes_result = res;
            this.loading_table = false;
        },

        async area_search(val) {
            //term
            //if (!val) return;

            this.tr_index = null;
            this.loading_table = true;
            let res = await this.getBienes(
                this.area_selected,
                this.responsable,
                val,
                this.mostrar_selected,
                this.corr_search
            );
            this.bienes_result = res;
            this.loading_table = false;
        },

        async corr_search(val) {//correlativo
            //if (!val) return;
            //if (val < 1) return;

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

        async mostrar_selected(val) {
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
