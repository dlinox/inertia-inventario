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
                        <th class="text-left">Codigo</th>
                        <th class="text-left">Descripcion</th>
                        <th class="text-left">Area</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in bienes_result" :key="index">
                        <td>{{ item.codigo }}</td>
                        <td>{{ item.descripcion }}</td>
                        <td>
                            {{ item.nombre }}
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
</template>
<script>
import axios from "axios";

export default {
    props: {
        areas: Array,
    },
    data: () => ({
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
        this.bienes_result = await this.getBienes();
        this.loading_table = false;
    },
    methods: {
        async getBienes(term = "", page = 1) {
            let res = await axios.post(
                "/inventario/get-bienes-usuario?page=" + page,
                {
                    term: term,
                }
            );

            this.page = res.data.datos.current_page;
            this.total_result = res.data.datos.total;
            this.pages = res.data.datos.last_page;
            console.log(res.data.datos.data);

            return res.data.datos.data;
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

            let res = await this.getBienes(this.area_selected, val);
            this.bienes_result = res;

            this.loading_table = false;
        },
    },
};
</script>
