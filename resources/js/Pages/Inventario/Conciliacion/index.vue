<template>
    <v-container>
  
      <v-card class="mt-3">
        <v-toolbar color="primary" dark flat>
          <v-app-bar-nav-icon></v-app-bar-nav-icon>
  
          <v-toolbar-title>Conciliacion</v-toolbar-title>
  
          <v-spacer></v-spacer>
  
          <v-menu transition="slide-y-transition" bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn class="purple" color="secondary" dark v-bind="attrs" v-on="on">
                Dependencia
              </v-btn>
            </template>
            <v-list>
              <v-list-item v-for="(item, i) in dependencias" :key="i" link @click="GetDataBienk(item)">
                <v-list-item-subtitle>{{ item.id }} - {{ item.dependencia }}
                </v-list-item-subtitle>
              </v-list-item>
            </v-list>
          </v-menu>
  
          <template v-slot:extension>
            <v-tabs v-model="tab" align-with-title>
              <v-tabs-slider color="blue"></v-tabs-slider>
  
              <v-tab v-for="item in items" :key="item">
                {{ item }}
              </v-tab>
            </v-tabs>
          </template>
        </v-toolbar>
  
        <v-tabs-items v-model="tab">
          <v-tab-item>
  
            <v-card-title>
              {{ dependencia_select }}
              <v-spacer></v-spacer>
              <v-text-field dense outlined v-model="search_af" append-icon="mdi-magnify" label="Buscar" single-line
                hide-details></v-text-field>
            </v-card-title>
  
         
  
            <v-data-table item-key="index" :loading="loading_af" loading-text="Cargando... Espere Por Favor"
              :headers="headers" :items="bienes_af" :search="search_af">
  
              <template v-slot:item.responsable="{ item }">
  
                {{ item.nombres }} {{ item.paterno }} {{ item.materno }}
  
              </template>
            </v-data-table>
          </v-tab-item>
  
          <v-tab-item>
  
            <v-card-title>
              {{ dependencia_select }}
              <v-spacer></v-spacer>
              <v-text-field dense outlined v-model="search_nd" append-icon="mdi-magnify" label="Buscar" single-line
                hide-details></v-text-field>
            </v-card-title>
  
            <v-data-table item-key="index" :loading="loading_nf" loading-text="Cargando... Espere Por Favor"
              :headers="headers" :items="bienes_nd" :search="search_nd">
  
              <template v-slot:item.responsable="{ item }">
                {{ item.nombre }} {{ item.paterno }} {{ item.materno }}
              </template>
            </v-data-table>
          </v-tab-item>
  
          <v-tab-item>
  
          </v-tab-item>
  
        </v-tabs-items>
      </v-card>
  
  
    </v-container>
  </template>
  <script>
  import Layout from "@/Layouts/InventarioLayout";
  import DataTableComponent from "../Components/DataTableComponent.vue";
  export default {
    metaInfo: { title: "Conciliación" },
    layout: Layout,
    props: {
      dependencias: Array,
    },
    components: {
      DataTableComponent,
    },
    data() {
      return {
        tab: null,
        items: [
          'Bienes AF', 'Bienes NP', 'Sobrantes'
        ],
        search_af: '',
        search_nd: '',
        headers: [
          {
            text: 'Codigo',
            align: 'start',
            filterable: false,
            value: 'codigo',
          },
          { text: 'Descripcion', value: 'descripcion' },
          { text: 'Cod Ubicación', value: 'cod_ubicacion' },
          { text: 'Modelo', value: 'modelo' },
          { text: 'Marca', value: 'marca' },
          { text: 'Serie', value: 'nro_serie' },
          { text: 'Medidas', value: 'medidas' },
          { text: 'Color', value: 'color' },
          { text: 'Observaciones', value: 'observaciones' },
          { text: 'Oficina', value: 'oficina' },
          { text: 'Responsable', value: 'responsable' },
        ],
  
        loading_af: false,
        loading_nf: false,

        bienes_af: [],
        bienes_nd: [],
        bienes_sobrantes: [],
  
        dependencia_select: 'Dependencia',
      }
    },
    created() {
    },
  
    watch: {
    },
  
    methods: {
      async GetDataBienk(dependencia) {
  
        this.dependencia_select = dependencia.dependencia;
  
        this.bienes_af = [];
        this.bienes_nd = [];
  
        this.loading_af = true;
  
        let res_af = await axios.get('/inventario/get-bienes-conciliacion/' + dependencia.id + '/ACTIVO FIJO');
        this.bienes_af = res_af.data.datos;
        this.loading_af = false;
  
        this.loading_nf = true;
        let res_nd = await axios.get('/inventario/get-bienes-conciliacion/' + dependencia.id + '/NO DEPRECIABLE');
        this.bienes_nd = res_nd.data.datos;
        this.loading_nf = false;
        //let res_sobrantes = await axios.get("/inventario/get-bienes-conciliacion/?tipo=NO DEPRECIABLE FIJO&dependencia=" + dependencia);
        //this.bienes_sobrantes = res_sobrantes.data.datos;
      }
  
    },
  }
  </script>
  <style scoped>
  
  </style>