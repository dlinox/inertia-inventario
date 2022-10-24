<template>
    <v-container>
        <div class="mt-0 pl-4 p-4"  style="margin: 0px; min-height: 530px; background-color: white; " >
            <v-card-title>
                <div style="width:100%;">
                    <h5>
                    Cargos personales
                </h5>

                </div>
                <div style="width:100%; display: flex; justify-content: flex-end;">
                    <div style="width:300px;">
                        <v-text-field
                           v-model="searchdocuments"
                           append-icon="mdi-magnify"
                           single-line
                           dense
                           hide-details
                           >
                        </v-text-field>
                    </div>
                </div>
            </v-card-title>
            <div
               max-width="900"

            >
            <v-data-table
                :headers="headersdocuments"
                :items="documentos"item
                :search="searchdocuments"
                hide-default-footer
                dense
                >
            <template v-slot:item.acciones="{ item }" >
                <div style="width: 90px;">
                 <div class="flex" style="width:85px;">
                    <v-btn  class="ml-0 p-0" style="width: 25px; height:25px;;" icon dark color="indigo" @click="desbloquear(item)" >
                        <v-icon color="primary" v-if="item.estado === 0" size="1.1rem">mdi-lock</v-icon>
                        <v-icon v-else color="grey" size="1.1rem">mdi-lock-open</v-icon>
                    </v-btn>
                    <v-btn class="ml-0" style="width: 25px; height:25px;;" icon dark color="primary" @click="verDocumento(item)" >
                        <v-icon size="1.1rem">mdi-eye</v-icon>
                    </v-btn>
                    <v-btn style="width: 25px; height:25px;;" icon dark color="indigo" @click="eliminarDocumento(item)">
                        <v-icon size="1.1rem">mdi-delete</v-icon>
                    </v-btn>
                </div>
               </div>
            </template>

            </v-data-table>
            </div>
       </div>
    </v-container>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
import axios from 'axios';
export default {
    metaInfo: { title: "Explorador" },
    layout: Layout,
    data () {
      return {
        dialog: false,
        personas:[],
        areas:[],
        documentos:[],
        documentoElegido: null,
        searchdocuments:'',
        headersdocuments: [
          { text: ' ', align: 'right', value:'acciones', maxWidth:'50px'  },
          { text: 'Codigo', align: 'start', filterable: true, value: 'codigo', },
          { text: 'Responsable', align: 'start', filterable: true, value: 'dni', },
          { text: 'Area', align: 'start', filterable: true, value: 'nombre', },
        ],
      }
    },
    created() {
        this.getDocuments()
    },
    methods: {
        async getDocuments() {
            let res = await axios.get("/admin/reportes/getDocuments");
            this.documentos = res.data.datos;
            return res.data.datos.data;
        },
        verDocumento(item){
            window.open(item.url, '_blank');
        },

        async eliminarDocumento(item){
            await axios.delete(`/admin/documentos/eliminar/${item.id}`)
             .then(response => {
                 console.log(response);
             });
             this.text = "Documento eliminado"
             this.snackbar = true
             this.getDocuments()
        },

        async desbloquear( item ){
            await axios.get(`/admin/documentos/desbloquearBienes/${item.id}`);
            this.getDocuments()
            this.text = "Bienes Desbloquedos"
            this.snackbar = true
            return res.data.datos;
        },

    },
  }

</script>
