<template>
    <v-card tile>
        <v-overlay absolute :value="loading_table">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <v-card-title> Bienes Registrados </v-card-title>
        <v-divider></v-divider>

        <v-simple-table>
            <template v-slot:default>
                <thead class="grey lighten-3">
                    <tr>
                        <th class="text-left"></th>
                        <th class="text-left">Inventario</th>
                        <th class="text-left">Codigo</th>
                        <th class="text-left">Descripcion</th>
                        <th class="text-left">Dependencia</th>

                        <th class="text-left">Area</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </template>
        </v-simple-table>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-pagination v-model="page" class="" :length="pages" :total-visible="5"></v-pagination>
            <v-spacer></v-spacer>
        </v-card-actions>
    </v-card>
</template>

<script>
import axios from "axios";


export default {
    props: {
        areas: Array,
    },
    data: () => ({
        dialog_delete: false,
        loading_table: false,
        search: "",
        bienes_result: [],
        mostrar_selected: "Todos",
        area_search: "",
        page: 1,
        total_result: 0,
        pages: 1,
    }),
    async created() {
        this.loading_table = true;
        this.bienes_result = await this.getData();
        this.loading_table = false;
    },
    methods: {


        async getData() {
            let res = await axios.post(
                "/inventario/get-bienes-conciliacion?page=" + this.page, {
                dpendencia: this.area_selected,
                term: this.term,
            }
            );
            this.page = res.data.datos.current_page;
            this.total_result = res.data.datos.total;
            this.pages = res.data.datos.last_page;
            return res.data.datos.data;
        },
    },
    watch: {

        async page(val, old_val) {
            if (val == old_val) return;

            this.loading_table = true;
            let res = await this.getData();
            this.bienes_result = res;
            this.loading_table = false;
        },
    },

};
</script>
