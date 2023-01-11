<template>
<div class="wrapper-page">
  <div class="continer">
    <v-card>
    <v-card-title>
      <v-row class="inputs" style="background: white">
 
        {{ oficina }}
        <v-col sx="12" sm="12" md="4" lg="4" style=" height: 51px;">
            <v-autocomplete
                v-model="dep"
                clearable
                dense
                label="Dependencia"
                outlined
                :items="dependencias"
                :filter="customFilterDEP"
                item-value="iddep"
                item-text="dependencia"
                required
            >
                <template v-slot:no-data>
                    <v-list-item>
                        <v-list-item-title>
                            <template>
                                No hay registros
                            </template>
                        </v-list-item-title>
                    </v-list-item>
                </template>

                <template v-slot:item="data">
                    <v-list-item-content>
                        <v-list-item-title v-html="data.item.iddep">
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            {{ data.item.dependencia }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </template>
            </v-autocomplete>

        </v-col>

        <v-col sx="12" sm="12" md="4" lg="4" style=" height: 51px;">
            <v-autocomplete
                v-model="oficina"
                clearable
                dense
                label="Oficina"
                outlined
                :items="oficinas"
                :filter="searchoficina"
                item-value="id"
                item-text="name"
            >
                <template v-slot:no-data>
                    <v-list-item>
                        <v-list-item-title>                         
                          No hay registros
                        </v-list-item-title>
                    </v-list-item>
                </template>

                <template v-slot:item="data">
                    <v-list-item-content >
                        <v-list-item-subtitle >
                          <div v-if="data.item.tipo === 1" style="color:#252850;">
                            <div><span style="font-weight: bold;">[{{ data.item.nombre }}] {{ data.item.iduoper }} {{ data.item.dni}} - {{ data.item.num }}</span></div>
                            <span>{{ data.item.nombres }} {{ data.item.paterno }} {{ data.item.materno }}</span>
                          </div>
                          <div v-if="data.item.tipo === 2" style="color:#8B0000;">
                            <div><span style="font-weight: bold;">[{{ data.item.nombre }}] {{ data.item.iduoper }} {{ data.item.dni}} - {{ data.item.num }}</span></div>
                            <span>{{ data.item.nombres }} {{ data.item.paterno }} {{ data.item.materno }}</span>
                          </div>
                          <div v-if="data.item.tipo === 3" style="color:#2271b3;">
                            <div><span style="font-weight: bold;">[{{ data.item.nombre }}] {{ data.item.iduoper }} {{ data.item.dni}} - {{ data.item.num }}</span></div>
                            <span>{{ data.item.nombres }} {{ data.item.paterno }} {{ data.item.materno }}</span>
                          </div>
                        </v-list-item-subtitle>
                    </v-list-item-content>
                </template>
            </v-autocomplete>

        </v-col>
        
        <!-- <v-col sx="12" sm="12" md="4" lg="4" style=" height: 51px;">
            <pre>{{ oficinas }}</pre>
        </v-col> -->
      </v-row>
      <v-row>
        <v-col >
          <v-data-table
            v-model="selected"
            :headers="headers"
            :items="bienes"
            item-key="name"
            show-select
            class="elevation-1"
          >
          </v-data-table>
        </v-col>
      </v-row>
    </v-card-title>
  <v-card-text>
    
  </v-card-text>

    </v-card>
  </div>
</div>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
import axios from "axios";

export default {
  metaInfo: { title: "Update cargo"},
  layout: Layout,

  data: () => ({
    buscarcargos:"",
    term:"",
    oficina:null,
    dep:'01',
    page:1,

    search:"",
    ofi:"",

    dependencias:[],
    oficinas:[],
    bienes:[],
    bienesseleccionados:[],


    headers: [
          { text: 'Codigo', value: 'codigo' },
          { text: 'Corr', value: 'corr' },
          { text: 'Descripcion', value: 'detalle' },
        ],

  }),
  mounted() {
    this.getDependencias();
  },
  methods: {
    async getDependencias(){
      let res = await axios.get("/admin/get-dependencias");
      this.dependencias = res.data.datos;
      return res.data.datos.data;
    },
    async getCargos() {
      let res = await axios.get("/admin/get-cargos/"+this.dep);
      this.oficinas = res.data.datos;
      console.log(this.oficinas);
      return res.data.datos.data;
    },

    async getDependencias(){
      console.log(sd)
    },









    customFilterDEP(item, queryText, itemText) {
      const dependencia = item.dependencia.toLowerCase();
      const iddep = item.iddep.toLowerCase();
      const searchText = queryText.toLowerCase();
      return (
          dependencia.indexOf(searchText) > -1 ||
          iddep.indexOf(searchText) > -1
        );
    },
    searchoficina(item, queryText, itemText) {
      const nombre = item.nombre.toLowerCase();
      const iduoper = item.iduoper.toLowerCase();
      const nombres = item.nombres.toLowerCase();
      const paterno = item.paterno.toLowerCase();
      const materno = item.paterno.toLowerCase();
      const searchText = queryText.toLowerCase();
      return (
          nombre.indexOf(searchText) > -1 ||
          iduoper.indexOf(searchText) > -1 ||
          nombres.indexOf(searchText) > -1 ||
          paterno.indexOf(searchText) > -1 ||
          materno.indexOf(searchText) > -1
        );
    },


  },

  watch:{
    dep(){
      this.getCargos()
    },
    oficina(){
      this.getBienes()
    }

  }

};
</script>
