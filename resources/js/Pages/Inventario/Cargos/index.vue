<template>
    <v-container  style="background:white;">
      <div class="" style="background:white;">

        <v-row style="background: white; margin-bottom:-25px;" >
            <v-col md="9" lg="9">
                <h3>Cargo de bienes </h3>
            </v-col>
        </v-row>
        <v-row class="inputs" style="background: white">
            <v-col sx="12" sm="12" md="4" lg="4" style="margin-bottom:-40px;" class=" " >
                <v-autocomplete
                    v-model="areE"
                    clearable
                    dense
                    label="Oficina"
                    outlined
                    :items="oficinas"
                    :filter="customFilter"
                    item-value="iduoper"
                    item-text="nombres"
                    :search-input.sync="oficinas_search"
                    required
                >
                    <template v-slot:no-data>
                        <v-list-item>
                            <v-list-item-title>
                                <template v-if="oficinas_search?.length > 0">
                                    <!-- Datos no encontrados para -->
                                    <!-- <strong>
                                        {{ oficinas_search }}
                                    </strong> -->
                                </template>
                                <template v-else>
                                    No hay registros en el inventario
                                </template>
                            </v-list-item-title>
                        </v-list-item>
                    </template>
    
                    <template v-slot:item="data">
                        <v-list-item-content>
                            <v-list-item-title v-html="data.item.iduoper">
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                {{ data.item.nombres }}
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
                    item-text="nombre"
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
                                    No hay registros en el inventario
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

        <div style=" overflow-y:hidden; width:100%; margin-top:30px; height:425px;" class="contenedorIframe" >
            <div  v-if="areE !== null && perE !== null"  class="by-preview" style="transform:scale(1);">
                <iframe :src="preview" scrolling="yes" frameborder="0" style=" padding-top:-30px;  border:solid 0.5px #cdcdf4;"> </iframe>
            </div>
        </div>    
    
    
    </div>
    
    
      </v-container>
    </template>
    <script>
    import Layout from "@/Layouts/InventarioLayout";
    import axios from 'axios';
    export default {
        metaInfo: { title: "Personas" },
        layout: Layout,
        data () {
          return {
            url:'',

            preview:'',
            searchdocuments:"",
            areas: [],
            oficinas: [],
            personas:[],
            documentos:[],
            docSeleccionado: null,
            areEO:null,
            areE:null,
            perE:null,
            ofiE:null,
            PDF:null,
 
            oficinas_search: "",
            areas_search: "",
            personas_search: "",

          }
        },
        created() {

            this.getOficinas()
        },
    
        watch:{ 
            areE: function(){
                this.getPersonas();
                this.preview = null;
            },
            perE: function(){
                this.preview = '/inventario/preview/'+this.areE+'/'+this.perE+'#toolbar=0';
            },
    
    
        },
    
        methods: {

            customFilter(item, queryText, itemText) {
                const nombres = item.nombres.toLowerCase();
                const iduoper = item.iduoper.toLowerCase();
                const searchText = queryText.toLowerCase();
                return (
                    nombres.indexOf(searchText) > -1 ||
                    iduoper.indexOf(searchText) > -1
                 );
            },
    
            customFilterAreas(item, queryText, itemText) {
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
                let res = await axios.get("/inventario/getOficinas");
                console.log(res.data);
                this.oficinas = res.data.datos;
                return res.data.datos.data;
            },
    
            async getPersonas() {
                if( this.areE !== null ){
                    let res = await axios.get("/inventario/getPersonasByAreaInv/"+this.areE);
                    console.log(res.data);
                    this.personas = res.data.datos;
                    return res.data.datos;

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

    
        },
      }
</script>
<style scoped>
.selec{
    color: #0808a7;
    font-weight: bold;
}
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
.contenedorIframe{
    background: none;
}
.hijo{
    transform: scale(0.6)
}
@media (max-width: 600px) {
    .contenedorIframe{
        overflow-x:scroll;
    }
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
