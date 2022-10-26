<template>
<v-container  style="background:white;">
  <div class="" style="background:white;">
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

    <v-row class="inputs" style="background: white">
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
    </v-row>
    {{ registrado }}
    <div style="overflow-x:scroll; overflow-y:hidden; width:100%; margin-top:30px; height:460px;">
        <div  v-if="areE !== null && perE !== null"  class="by-preview" style="transform:scale(1);">
            <iframe :src="preview" scrolling="yes" frameborder="0" style=" padding-top:-30px;"> </iframe>
        </div>
    </div>
    <v-col style="display: flex; justify-content:flex-end;" sx="12" sm="12" md="12" lg="12" >
        <div class="ml-2">
            <v-btn height="38" small class="btn" dark color="primary" @click="dialogGuardar">Guardar PDF</v-btn>
        </div>

        <div class="ml-2">
            <v-btn height="38" small class="btn" dark color="primary" @click="PrintPdf">Print PDF</v-btn>
        </div>
        <!-- <div class=" ml-2" small>
            <v-btn height="38" class="btn" dark color="primary" @click="Guardar" >Guardar PDF</v-btn>
        </div> -->
    </v-col>

    <v-row justify="center">
        <v-dialog
        v-model="dialog"
        persistent
        max-width="290"
            >
            <v-card>
            <v-card-title class="text-h5">
            Precaución..!!
            </v-card-title>
            <v-card-text>{{ mensaje }}</v-card-text>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                color="green darken-1"
                text
                @click="dialog = false"
            >
                Cancelar
            </v-btn>
            <v-btn
                color="green darken-1"
                text
                @click="generarPDF"
            >
                Continuar
            </v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>
    </v-row>
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
        url:'',
        dialog: false,
        preview:'',
        searchdocuments:"",
        areas: [],
        oficinas: [],
        personas:[],
        documentos:[],
        areEO:null,
        areE:null,
        perE:null,
        ofiE:null,
        snackbar: false,
        text: '',
        PDF:null,
        timeout: 2000,
        oficinas_search: "",
        areas_search: "",
        personas_search: "",
        data: [],
        mensaje:'',
        registrado:0,
      }
    },
    created() {
        this.getAreas()
        this.getPersonas()
        this.getOficinas()
        this.getDocumentos()
    },

    watch:{
        areE: function(){
            this.getPersonas();
            this.buscabyOficinaID(this.areEO)
            this.Registrado(this.areE, this.perE)
            this.preview =  '/admin/reportes/preview/'+this.areE+'/'+this.perE+'#toolbar=0';
        },
        perE: function(){
            this.getAreas();
            this.preview =  '/admin/reportes/preview/'+this.areE+'/'+this.perE+'#toolbar=0';
            this.Registrado(this.areE, this.perE)
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
        async getDocumentos() {
            let res = await axios.get("/admin/reportes/getDocuments");
            this.documentos = res.data.datos;
            return res.data.datos.data;
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
        Registrado(idA, idP){
            this.registrado = 0;
            for(let i in this.documentos){
                if (this.documentos[i].id_area === idA && this.documentos[i].id_persona === idP ){
                    this.registrado = 1;
                }
            }
        },
        dialogGuardar(){
            this.mensaje = "Se bloquearan todos los bienes de este documento";
            this.dialog = true;
        },
        dialogImprimir(){
            this.mensaje = "Se bloquearan todos los bienes de este documento";
            this.dialog = true;
        },
        generarPDF(){
            this.dialog = false;
            let res = axios.get("/admin/pdfBienes/"+this.perE+"/"+this.areE)
            .then(response => {
                 console.log(response);
                 this.PDF=response.data.datos;
//                 this.url = this.PDF.url+"#toolbar=0";
                 this.url = this.PDF.url;
             });

            this.text = "Documento Guardado"
            this.snackbar = true
        },

        async Guardar() {
            this.PDF['id_persona'] = this.perE;
            let res = await axios.post(
                "/admin/documentos/guardar",
                this.PDF
            );


        },

        PrintPdf () {
            var iframe = document.createElement('iframe');
            iframe.style.display = "none";
            iframe.src = "http://localhost:8000/documents/cargos/CBI-24102022-0000032.pdf";
            document.body.appendChild(iframe);
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        }

    },
  }
</script>
<style scoped>
.by-preview{
    width:100%;
    height:100%;
    min-width:1070px;
}
iframe{
border:none;
width: 100% !important;
  height: 100% !important;
  scale:(0.7);
}
.padre{
   overflow-x: visible;
   white-space: nowrap;
  }
.hijo{
    transform: scale(0.6)
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
