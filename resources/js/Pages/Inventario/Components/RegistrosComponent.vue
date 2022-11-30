<template>
    <v-dialog v-model="dialog" fullscreen scrollable>
        <template v-slot:activator="{ on, attrs }">
            <v-btn block v-bind="attrs" v-on="on">
                Mis Registros <v-icon right>mdi-format-list-checks</v-icon>
            </v-btn>
        </template>

        <v-card tile>
            <v-toolbar>
                <v-app-bar-nav-icon @click="dialog = false">
                    <v-icon>mdi-arrow-left</v-icon>
                </v-app-bar-nav-icon>

                <v-toolbar-title>Bienes Registrados</v-toolbar-title>
            </v-toolbar>

            <div class="text-center">
                <small>*Doble toque para selecionar</small> 
            </div>
            

            <v-card-text style="height: 90vh">
                <v-row class="mt-3">
                    <v-col cols="12" class="pb-1 pt-0"> </v-col>
                </v-row>

                <v-card tile>
                    <v-overlay absolute :value="loading_table">
                        <v-progress-circular
                            indeterminate
                            size="64"
                        ></v-progress-circular>
                    </v-overlay>

                    <v-divider></v-divider>

                    <v-simple-table>
                        <template v-slot:default>
                            <thead class="grey lighten-3">
                                <tr>
                                    <th class="text-left">Inventario</th>
                                    <th class="text-left">Codigo</th>
                                    <th class="text-left">Descripcion</th>
                                    <th class="text-left">Dependencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(item, index) in bienes_result"
                                    :key="index"
                                    @dblclick="onSelectColumDobleClik(item)"
                                >
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

                                    <td>
                                        <strong>{{ item.dependencia }}</strong>
                                        -
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
            </v-card-text>
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
        dialog: false,
        bienes_result: [],
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
        async getBienes( page = 1) {
            let res = await axios.post(
                "/inventario/get-bienes-usuario?page=" + page,
            );
            this.page = res.data.datos.current_page;
            this.total_result = res.data.datos.total;
            this.pages = res.data.datos.last_page;
            return res.data.datos.data;
        },

        async onSelectColumDobleClik(item) {
            item.registrado =  true ;
            this.$emit("setData", item);
            this.dialog = false;
        },
    },
    watch: {

        async page(val, old_val) {
            if (val == old_val) return;
            
            this.loading_table = true;
            let res = await this.getBienes(
                val
            );
            this.bienes_result = res;
            this.loading_table = false;
        },
  

        async dialog(val){
            if(val == false) return;
            this.bienes_result = await this.getBienes();
        }
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
