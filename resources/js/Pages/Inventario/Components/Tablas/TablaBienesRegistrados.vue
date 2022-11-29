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
                    <tr v-for="(item, index) in bienes_result" :key="index">
                        <td>
                            <v-btn
                                dark
                                small
                                color="red"
                                @click="modalElimnar(item)"
                            >
                                Elimnar
                            </v-btn>
                        </td>

                        <td>
                            <template v-if="item.idbienk">
                                {{ item.idbienk }}
                            </template>
                            <template v-else>
                                <v-chip
                                    small
                                    class="ma-2"
                                    color="green"
                                    text-color="white"
                                >
                                    Nuevo
                                </v-chip>
                            </template>
                        </td>
                        <td>{{ item.codigo }}</td>
                        <td>{{ item.descripcion }}</td>

                        <td>{{ item.dependencia }}</td>
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

        <v-dialog v-model="dialog_delete" max-width="320">
            <v-card>
                <v-overlay absolute :value="loadin_delete">
                    <v-progress-circular
                        indeterminate
                        size="64"
                    ></v-progress-circular>
                </v-overlay>
                <div class="pa-3">
                    <h4 class="text-center my-3">
                        Seguro de eliminar el registro?
                    </h4>

                    <v-divider></v-divider>

                    <div class="d-flex justify-center mt-3">
                        <v-btn
                            color="red darken-1"
                            text
                            dense
                            @click="dialog_delete = false"
                        >
                            Cancelar
                        </v-btn>

                        <v-btn
                            color="green"
                            text
                            dense
                            @click="deleteInventario()"
                        >
                            Aceptar
                        </v-btn>
                    </div>
                </div>
            </v-card>
        </v-dialog>

        <AlertComponent
            :show_alert="show_alert"
            :msg_alert="msg_alert"
            :type_alert="type_alert"
            @setAlert="show_alert = $event"
        />
    </v-card>
</template>
<script>
import axios from "axios";
import AlertComponent from "../AlertComponent.vue";

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

        //alerta
        //alerta
        show_alert: false,
        msg_alert: "",
        type_alert: "",

        loadin_delete: false,
        item_eliminar: null,
    }),
    async created() {
        this.loading_table = true;
        this.bienes_result = await this.getBienes();
        this.loading_table = false;
    },
    methods: {
        modalElimnar(item) {
            this.dialog_delete = true;
            this.item_eliminar = item;
            console.log(item);
        },
        setDataAlert(response) {
            this.msg_alert = response.mensaje;
            this.type_alert = response.estado ? "success" : "red";
            this.show_alert = true;
        },
        async deleteInventario() {
            this.loadin_delete = true;
            let res = await axios.post(
                "/inventario/delete-inventario",
                this.item_eliminar
            );

            this.setDataAlert(res.data);
            this.item_eliminar = null;
            let res_b = await this.getBienes();

            this.bienes_result = res_b;

            this.dialog_delete = false;
            this.loadin_delete = false;
        },
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
    components: { AlertComponent },
};
</script>
