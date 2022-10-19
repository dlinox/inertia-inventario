<template>
    <v-container>
        <v-card>
            <v-card-title>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
            ></v-text-field>
            </v-card-title>
            <v-data-table
            :headers="headersAreas"
            :items="areas"
            :search="search"
            >

            <template v-slot:item.stado ="{ item }">
                <div v-if="item.stado == 1">Activo</div>
                <div v-else>Desactivado</div>
            </template>

            <template v-slot:item.accion ="{ item }">

                <div >
                    <v-btn color="success" dark text @click="cambiarEstado(item)"> Cambiar estado</v-btn>
                </div>
            </template>

            </v-data-table>
        </v-card>
    </v-container>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
import { assertBinary, throwStatement } from "@babel/types";
export default {
    metaInfo: { title: "Personas" },
    layout: Layout,
    data () {
      return {
        dialog: false,
        areaID: null,
        search: '',
        searchpersonas: '',
        headersAreas: [
          { text: 'Codigo', align: 'start', filterable: true, value: 'id', },
          { text: 'Nombre', align: 'start', filterable: true, value: 'nombre', },
          { text: 'Estado', align: 'center', filterable: false, value: 'stado',},
          { text: 'Acción', align: 'center', value:'accion' },
        ],
        areas: [],
      }
    },
    created() {
        this.getAreas()
    },
    onMounted() {
        this.getAreas()
    },

    methods: {
        async getAreas() {
            let res = await axios.get("/admin/areas/getAreas");
            console.log(res.data);
            this.areas = res.data.datos;
            //            return res.data.datos.data;
        },


        async cambiarEstado(item){
            let est;

            if(item.stado == 1 ){
                est = 0;
            }else { est = 1}

            let res = await axios.put("/admin/areas/cambiarEstado/"+est, item);
            this.getAreas()
            return res.data.datos;
        },

        buscabyID(id){
            for(let i in this.personas){
                if (this.personas[i].id === id ){
                    return this.personas[i].dni
                }

            }
        }



    },
  }
</script>
