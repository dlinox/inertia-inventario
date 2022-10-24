<template>
<v-container style="background:white">
  <div class="" style="background:white">
    <div class="text-center">
      <v-snackbar
        v-model="snackbar"
        :timeout="timeout"
      >
        {{ text }}

        <template v-slot:action="{ attrs }">
          <v-btn
            color="blue"
            text
            v-bind="attrs"
            @click="snackbar = false"
          >
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </div>

    <v-row class="inputs" style="background: white" >
        <v-col sx="12" sm="12" md="4" lg="4" style="margin-bottom:-40px;" class=" " >
            <v-autocomplete
                v-model="ofiE"
                clearable
                dense
                label="Oficina"
                outlined
                :items="oficinas"
                :filter="customFilter"
                item-value="id"
                item-text="nombre"
                :search-input.sync="oficinas_search"
                required
            >
                <template v-slot:no-data>
                    <v-list-item>
                        <v-list-item-title>
                            <template v-if="oficinas_search?.length > 0">
                                Datos no encontrados para
                                <!-- <strong>
                                    {{ oficinas_search }}
                                </strong> -->
                            </template>
                            <template v-else>
                                Digite más de
                                <strong> 2</strong> caracteres.
                            </template>
                        </v-list-item-title>
                    </v-list-item>
                </template>

                <template v-slot:item="data">
                    <v-list-item-content>
                        <v-list-item-title v-html="data.item.codigo">
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            {{ data.item.nombre }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </template>
            </v-autocomplete>

        </v-col>
        <v-col sx="12" sm="12" md="4" lg="4" style="margin-bottom:-40px;" class="p-0 " >
            <v-autocomplete
                v-model="areE"
                clearable
                class="mt-0 pt-0"
                dense
                label="Area"
                outlined
                :items="areas"
                :filter="customFilter"
                item-value="id"
                item-text="nombre"
                :search-input.sync="areas_search"
                required
            >
                <template v-slot:no-data>
                    <v-list-item>
                        <v-list-item-title>
                            <template v-if="oficinas_search?.length > 0">
                                Datos no encontrados para
                                <strong>
                                    {{ oficinas_search }}
                                </strong>
                            </template>
                            <template v-else>
                                Digite más de
                                <strong> 2</strong> caracteres.
                            </template>
                        </v-list-item-title>
                    </v-list-item>
                </template>

                <template v-slot:item="data">
                    <v-list-item-content>
                        <v-list-item-title v-html="data.item.codigo">
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            {{ data.item.nombre }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </template>
            </v-autocomplete>

        </v-col>

        <v-col sx="12" sm="12" md="4" lg="4" style="margin-bottom:-40px;" class="p-0" >
            <v-autocomplete
                v-model="perE"
                clearable
                class="mt-0 pt-0"
                dense
                label="Persona"
                outlined
                :items="personas"
                :filter="customFilterPersona"
                item-value="id"
                item-text="nombres"
                :search-input.sync="personas_search"
                required
            >
                <template v-slot:no-data>
                    <v-list-item>
                        <v-list-item-title>
                            <template v-if="oficinas_search?.length > 0">
                                Datos no encontrados para
                                <strong>
                                    {{ oficinas_search }}
                                </strong>
                            </template>
                            <template v-else>
                                Digite más de
                                <strong> 2</strong> caracteres.
                            </template>
                        </v-list-item-title>
                    </v-list-item>
                </template>

                <template v-slot:item="data">
                    <v-list-item-content>
                        <v-list-item-title v-html="data.item.dni">
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            {{ data.item.nombres }} {{ data.item.paterno }} {{ data.item.materno }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </template>
            </v-autocomplete>

        </v-col>
        <v-col style="display: flex; justify-content:flex-end;" sx="12" sm="12" md="12" lg="12" >
                <div class="ml-2">
                    <v-btn height="38" small class="btn" dark color="primary" @click="generarPDF">Previsualizar</v-btn>
                </div>
                <div class=" ml-2" small>
                    <v-btn height="38" class="btn" dark color="primary" @click="Guardar" >Guardar PDF</v-btn>
                </div>
        </v-col>

    </v-row>
    <div class="mt-2" style="background:white; height: 700px;">

            <div v-if="PDF !== null">
                <iframe :src="url"  style="width:100%;" :height="500" frameBorder="0" ></iframe>
            </div>
    </div>

    </div>
  </v-container>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
import axios from 'axios';
export default {
    metaInfo: { title: "Personas" },
    layout: Layout,
    data () {
      return {
        dialog: false,
        headersdocuments: [
          { text: '-', align: 'center', value:'acciones' },
          { text: 'Codigo', align: 'center', filterable: true, value: 'codigo', },
          { text: 'Estado', align:'center', value:'estado'},
          { text: 'Responsable', align: 'start', filterable: true, value: 'dni_responsable', },
          { text: 'Area', align: 'start', filterable: true, value: 'id_area', },
        ],
        url:'',
        searchdocuments:"",
        areas: [],
        oficinas: [],
        personas:[],
        documentos:[],
        areEO:null,
        areE:null,
        perE:null,
        ofiE:null,
        documentoElegido: null,
        areas2:[],
        snackbar: false,
        text: '',
        PDF:null,
        timeout: 2000,
        oficinas_search: "",
        areas_search: "",
        personas_search: "",
        data: [],
      }
    },
    created() {
        this.getAreas()
        this.getPersonas()
        this.getDocuments()
        this.getOficinas()
    },

    watch:{
        areE: function(){
            this.getPersonas();
            this.buscabyOficinaID(this.areEO)
        },
        perE: function(){
            this.getAreas();
        },
        ofiE: function(){
            this.getAreas();
        }
    },

    methods: {
        customFilter(item, queryText, itemText) {
            const nombre = item.nombre.toLowerCase();
            const codigo = item.codigo.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                nombre.indexOf(searchText) > -1 ||
                codigo.indexOf(searchText) > -1
             );
        },
        customFilterPersona(item, queryText, itemText) {
            const nombres = item.nombres.toLowerCase();
            const dni = item.dni.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                nombres.indexOf(searchText) > -1 ||
                dni.indexOf(searchText) > -1
             );
        },

        async getOficinas() {
            if (this.areE === null ){
                let res = await axios.get("/admin/oficinas/getallOficinas");
                console.log(res.data);
                this.oficinas = res.data.datos;
                return res.data.datos.data;
            } else {
                if(this.areE !== null ){

                }
            }
        },

        async getAreas() {
            if (this.perE === null && this.ofiE === null){
                let res = await axios.get("/admin/areas/getAreasAllInv");
                this.areas = res.data.datos;
                this.areas2 = res.data.datos;
                return res.data.datos.data;
            }
            else
            {
                if (this.ofiE !== null  && this.perE === null){
                    let res = await axios.get("/admin/areas/getAreasByOficinaInv/"+this.ofiE);
                    this.areas = res.data.datos;
                    return res.data.datos.data;
                }else {
                    if (this.ofiE === null && this.perE !== null ){
                        let res = await axios.get("/admin/areas/getAreasByPersonaInv/"+this.perE);
                        this.areas = res.data.datos;
                        return res.data.datos.data;
                    }

                }

            }

        },
        async getPersonas() {
            if (this.areE === null ){
                let res = await axios.get("/admin/personas/getPersonasInv");
                console.log(res.data);
                this.personas = res.data.datos;
                return res.data.datos.data;
            }
            else {
                let res = await axios.get("/admin/personas/getPersonasByAreaInv/"+this.areE);
                console.log(res.data);
                this.personas = res.data.datos;
                return res.data.datos.data;
            }
        },

        async getDocuments() {
            let res = await axios.get("/admin/reportes/getDocuments");
            this.documentos = res.data.datos;
            return res.data.datos.data;
        },
        buscabyID(id){
            for(let i in this.personas){
                if (this.personas[i].id === id ){
                    return this.personas[i].dni
                }

            }
        },
        buscabyOficinaID(id){
            console.log(id)
            for(let i in this.oficinas){
                if (this.oficinas[i] === id ){
                    this.ofiE = this.oficinas[i].id
                    this.oficinaElegida = this.oficinas[i].nombre
                }
            }
        },
        buscaAreabyID(id){
            for(let i in this.areas2){
                if (this.areas2[i].id === id ){
                    return this.areas2[i].nombre
                }

            }
        },
        generarPDF(){
            let res = axios.get("/admin/pdfBienes/"+this.perE+"/"+this.areE)
            .then(response => {
                 console.log(response);
                 this.PDF=response.data.datos;
//                 this.url = this.PDF.url+"#toolbar=0";
                 this.url = this.PDF.url;
             });
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

        async Guardar() {
            this.PDF['id_persona'] = this.perE;
            let res = await axios.post(
                "/admin/documentos/guardar",
                this.PDF
            );
            console.log(res.data);
            if (this.is_nuevo) {
                this.$refs.form_user.reset();
            }

        },

    },
  }
</script>
<style scoped>
iframe{
border:none;
}
@media (max-width: 600px) {
  .botones {
    width: 100%;
    justify-content: space-between;
    margin-left: -5px;
    margin-right: -10px;
    margin-bottom: 5px;
  }
  .btn{
    width: 100%;
  }
    .inputs{
        display: block;
    }

}
</style>
