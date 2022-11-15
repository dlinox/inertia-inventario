<template>
<div class="wrapper-page">
<v-container>
    <v-card>
        <v-card-title primary-title>
            Importar de excel
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text style="height: 450px; " class="mt-3">
            <div>
                <v-file-input dense id="archivoExcelInventario" type="file"  label="File input" @change="subirExcelInventario()" append-icon=""></v-file-input>
            </div>

            <div>
                <v-simple-table v-if="items.length > 0">
                    <template v-slot:default>
                        <tbody>
                            <tr v-for="(item, index) in items" :key="index">
                                <td>{{ item[0] }}</td>
                                <td>{{ item[1] }}</td>
                                <td>{{ item[2] }}</td>
                                <td>{{ item[3] }}</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </div>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions >
            <v-spacer></v-spacer>
            <v-btn color="primary" dark> plantilla </v-btn>
        </v-card-actions>
    </v-card>
</v-container>
</div>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";

import axios from "axios";
import { Inertia } from "@inertiajs/inertia";

import readXlsFile from "read-excel-file";

export default {
    metaInfo: { title: "Usuarios" },
    layout: Layout,
    data: () => ({
        items:[],

    }),

    methods:{
        subirExcelInventario(){
            const input = document.getElementById("archivoExcelInventario");
            readXlsFile(input.files[0]).then((rows) => {
                this.items =  rows;
            });
        },

        async guardarImportados(){
            await axios.post("/admin/personas/savePersonasImport", {
                data: this.items,
            });
        }
    }

};
</script>

<style>

</style>
