<template>
    <v-container>
        <div>
            <a href="/export/3/1" > export </a> 
            <v-btn  @click="generarExcel" type=""> crear Excel </v-btn>
        </div>    

        <v-card>
            <v-card-title>

            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                outline
                hide-details
            ></v-text-field>
            </v-card-title>
            <v-data-table
            :headers="headersAreas"
            :items="areas"
            :search="search"
            >

            <template v-slot:item.id_responsable ="{ item }">
            {{           buscabyID(item.id_persona)
            }}
            </template>

            <template v-slot:item.accion ="{ item }">
                <div v-if="item.id_persona !== null">
                    <div class="flex justify-content-between">
                        <v-btn color="warning" text @click="abrirDialog(item.id)"> Cambiar</v-btn>
                    </div>
                </div>
                <div v-else>
                    <v-btn color="success" dark text @click="abrirDialog(item.id)"> Asignar</v-btn>
                </div>
            </template>

            </v-data-table>
        </v-card>
        <v-dialog
            v-model="dialog"
            max-width="900"
            >
            <v-card>
                <v-card-title>
                    <v-text-field
                        v-model="searchpersonas"
                        append-icon="mdi-magnify"
                        label="Search"
                        single-line
                        hide-details
                    > {{ areaID }} </v-text-field>
                </v-card-title>
                <v-data-table
                :headers="headersPersonas"
                :items="personas"
                :search="searchpersonas"
                >
                <template v-slot:item.acciones ="{ item }">
                    <v-btn
                        color="green darken-1"
                        text
                        @click="asignar(item)">Asignar
                    </v-btn>
                </template>

                </v-data-table>
            </v-card>
        </v-dialog>
    </v-container>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
//import { assertBinary, throwStatement } from "@babel/types";
import OficinaSelect from '../../../components/autocomplete/SelectOficina.vue'

export default {
    components:{ OficinaSelect },
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
          { text: 'Responsable', align: 'center', filterable: false, value: 'id_responsable',},
          { text: 'Acción', align: 'center', value:'accion' },
        ],
        headersPersonas: [
          { text: 'Codigo', align: 'start', filterable: true, value: 'id', },
          { text: 'DNI', align: 'start', filterable: true, value: 'dni', },
          { text: 'Nombre', align: 'start', filterable: true, value: 'nombres', },
          { text: 'A. Paterno', align: 'start', filterable: true, value: 'paterno', },
          { text: 'A. Materno', align: 'center', filterable: true, value: 'materno', },
          { text: 'Asignar', align: 'center', value:'acciones' },
        ],
        areas: [],
        king:'king',
        personas:[],
      }
    },
    created() {
        this.getAreas()
        this.getPersonas()
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
        async getPersonas() {
            let res = await axios.get("/admin/personas/getPersonas");
            console.log(res.data);
            this.personas = res.data.datos;
            //            return res.data.datos.data;
        },

        async generarExcel() {
            let params = {
                'a': 2,
                'p': 1
            }
//            var url = '/export/3/1';
//            let queryString = Object.keys(params).map(key => key + '=' + params[key]).join('&');
            let url = '/export/2,1';
                window.location.href = url; // esto redireccionará al usuario a la ruta de descarga

        },

        abrirDialog(item){
            this.areaID = item;
            console.log('id: ', item)
            console.log('id Area: ', this.areaID)
            this.dialog = true;
        },
        async asignar(item){

            let res = await axios.put("/admin/areas/asignarPersona/"+this.areaID, item);
            this.dialog = false;
            this.areaID = null;
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
