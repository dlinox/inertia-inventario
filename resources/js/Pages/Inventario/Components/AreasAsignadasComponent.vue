<template>
    <v-dialog v-model="dialog" fullscreen scrollable>
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" block dark v-bind="attrs" v-on="on">
                Areas Asignadas
            </v-btn>
        </template>

        <v-card tile>
            <v-toolbar>
                <v-app-bar-nav-icon @click="dialog = false">
                    <v-icon>mdi-arrow-left</v-icon>
                </v-app-bar-nav-icon>

                <v-toolbar-title> Areas Asignadas xd</v-toolbar-title>
            </v-toolbar>

            <v-card-text style="height: 90vh">
      
                <v-autocomplete
                    v-model="area_selected"
                    :items="areas"
                    item-text="nombre"
                    item-value="id"
                    label="Seleccione un Area"
                    class="my-4"
                    outlined
                    dense
                ></v-autocomplete>

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
                                    <th class="text-left">Cod. SIGA</th>
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
                                    <td>
                                        {{ item.codigo_siga }}
                                    </td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-pagination
                            v-model="page"
                            class=""
                            :length="pages"
                            :total-visible="5"
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
        areas: Array,
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
    }),
    methods: {
        onSelectColum(item, index) {
            this.tr_index = index;
            this.tr_item = item;
        },
        async onSelectColumDobleClik(item) {
            item.registrado = await item.registrado == 1 ? true : false;

            console.log(item);
            this.$emit("setData", item);
            this.dialog = false;
            this.resetAll();
          
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
            console.log(res.data.datos.data);

            return res.data.datos.data;
        },

        SeleccionarBien() {
            tr_item.registrado = tr_item.registrado == 1 ? true : false;
            this.$emit("setData", this.tr_item);
            this.dialog = false;
            this.resetAll();
           
        },

        resetAll(){
            this.bienes_result = [];
            this.area_selected = null;
            this.page=  1;
            this.total_result=  0;
            this.pages=  1;
        }
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
    background-color: rgba(0, 0, 255, 0.2);
    border: 1px dashed #444;
    color: blue;
    font-weight: 600;
}
</style>
