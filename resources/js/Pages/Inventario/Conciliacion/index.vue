<template>
  <v-container>

    <v-card class="mt-3">
      <v-toolbar color="primary" dark flat>
<<<<<<< HEAD
        <v-app-bar-nav-icon></v-app-bar-nav-icon>

        <v-toolbar-title>Conciliacion</v-toolbar-title>

=======

        <v-toolbar-title>
         <small> {{ dependencia_select.dependencia }}</small>

        </v-toolbar-title>
>>>>>>> e415b6bb53c34bc178e2cbd78158f9f2b70e4322

        <v-spacer></v-spacer>

        <v-menu transition="slide-y-transition" bottom>
          <template v-slot:activator="{ on, attrs }">
<<<<<<< HEAD
=======

>>>>>>> e415b6bb53c34bc178e2cbd78158f9f2b70e4322
            <v-btn class="purple" color="secondary" dark v-bind="attrs" v-on="on">
              Dependencia
            </v-btn>
          </template>
          <v-list>
<<<<<<< HEAD
            <v-list-item v-for="(item, i) in dependenciasTEMP" :key="i" link @click="GetDataBienk(item)">
=======
            <v-list-item v-for="(item, i) in dependencias" :key="i" link @click="GetDataBienk(item)">
>>>>>>> e415b6bb53c34bc178e2cbd78158f9f2b70e4322
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

<<<<<<< HEAD
          <v-card-title>
            {{ dependencia_select }}
            <v-spacer></v-spacer>
           
            <v-text-field dense outlined v-model="search_af" append-icon="mdi-magnify" label="Buscar" single-line
              hide-details></v-text-field>
              <v-icon style="font-size: 3.1rem; color: green;" @click="descargarExcelAF()">mdi mdi-arrow-down-bold-box</v-icon>    
          </v-card-title>

=======

          <v-card-title>

            <v-btn tile color="success" class="me-2 mb-2" :disabled="!dependencia_select.id"
              :href="'/inventario/excel-conciliacion/' + dependencia_select.id + '/ACTIVO FIJO'" link download>
              <v-icon left>
                mdi-microsoft-excel
              </v-icon>
              Excel
            </v-btn>
            <v-spacer></v-spacer>
            <v-text-field dense outlined v-model="search_af" append-icon="mdi-magnify" label="Buscar" single-line
              hide-details></v-text-field>
          </v-card-title>



>>>>>>> e415b6bb53c34bc178e2cbd78158f9f2b70e4322
          <v-data-table item-key="index" :loading="loading_af" loading-text="Cargando... Espere Por Favor"
            :headers="headers" :items="bienes_af" :search="search_af">

            <template v-slot:item.responsable="{ item }">

              {{ item.nombres }} {{ item.paterno }} {{ item.materno }}

            </template>
          </v-data-table>
        </v-tab-item>

        <v-tab-item>

          <v-card-title>
<<<<<<< HEAD
            {{ dependencia_select }}
            <v-spacer></v-spacer>
            <v-text-field dense outlined v-model="search_nd" append-icon="mdi-magnify" label="Buscar" single-line
              hide-details>
            </v-text-field>
            <v-icon style="font-size: 3.1rem; color: green;" @click="descargarExcelND()">mdi mdi-arrow-down-bold-box</v-icon>    
=======

            <v-btn tile color="success" class="me-2 mb-2" :disabled="!dependencia_select.id"
              :href="'/inventario/excel-conciliacion/' + dependencia_select.id + '/NO DEPRECIABLE'" link download>
              <v-icon left>
                mdi-microsoft-excel
              </v-icon>
              Excel
            </v-btn>

            
            <v-spacer></v-spacer>
            <v-text-field dense outlined v-model="search_nd" append-icon="mdi-magnify" label="Buscar" single-line
              hide-details></v-text-field>
>>>>>>> e415b6bb53c34bc178e2cbd78158f9f2b70e4322
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
<<<<<<< HEAD
import exportFromJSON from "export-from-json";
import DataTableComponent from "../Components/DataTableComponent.vue";
=======

import { Link } from '@inertiajs/inertia-vue'
>>>>>>> e415b6bb53c34bc178e2cbd78158f9f2b70e4322
export default {
  metaInfo: { title: "Conciliación" },
  layout: Layout,
  props: {
    dependencias: Array,
  },
  components: {
<<<<<<< HEAD
    DataTableComponent,
=======
    Link,
>>>>>>> e415b6bb53c34bc178e2cbd78158f9f2b70e4322
  },
  data() {
    return {
      tab: null,
      items: [
<<<<<<< HEAD
        'Bienes AF', 'Bienes NP', 'Sobrantes'
=======
        'Bienes AF', 'Bienes NP', //'Sobrantes'
>>>>>>> e415b6bb53c34bc178e2cbd78158f9f2b70e4322
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

<<<<<<< HEAD
      dependencia_select: 'Dependencia',

      dependenciasTEMP:[],
      namex:"ACTIVO FIJO"
    }
  },
  created() {
    this.getDependencias();
  },

  watch: {
  },
=======
      dependencia_select: {
        id: false,
        dependencia: 'Seleccione una dependencia'
      },
    }
  },

>>>>>>> e415b6bb53c34bc178e2cbd78158f9f2b70e4322

  methods: {
    async GetDataBienk(dependencia) {

<<<<<<< HEAD
      this.dependencia_select = dependencia.dependencia;
=======
      this.dependencia_select = dependencia;
>>>>>>> e415b6bb53c34bc178e2cbd78158f9f2b70e4322

      this.bienes_af = [];
      this.bienes_nd = [];

      this.loading_af = true;
<<<<<<< HEAD
=======
      this.loading_nf = true;
>>>>>>> e415b6bb53c34bc178e2cbd78158f9f2b70e4322

      let res_af = await axios.get('/inventario/get-bienes-conciliacion/' + dependencia.id + '/ACTIVO FIJO');
      this.bienes_af = res_af.data.datos;
      this.loading_af = false;

<<<<<<< HEAD
      this.loading_nf = true;
=======
>>>>>>> e415b6bb53c34bc178e2cbd78158f9f2b70e4322
      let res_nd = await axios.get('/inventario/get-bienes-conciliacion/' + dependencia.id + '/NO DEPRECIABLE');
      this.bienes_nd = res_nd.data.datos;
      this.loading_nf = false;
      //let res_sobrantes = await axios.get("/inventario/get-bienes-conciliacion/?tipo=NO DEPRECIABLE FIJO&dependencia=" + dependencia);
      //this.bienes_sobrantes = res_sobrantes.data.datos;
<<<<<<< HEAD
    },

    async getDependencias() {
        let res = await axios.get("/inventario/getDependenciasTEMP");
        console.log(res.data);
        this.dependenciasTEMP = res.data.datos;
        return res.data.datos.data;
    },

    descargarExcelAF() {
      const data = this.bienes_af;
      const filename = "BIENES AF";
      const exportType = exportFromJSON.types.xls;
      exportFromJSON({ data, filename, exportType });
    },

    descargarExcelND() {
      const data = this.bienes_nd;
      const filename = "BIENES ND";
      const exportType = exportFromJSON.types.xls;
      exportFromJSON({ data, filename, exportType });
    },

    

  },
}
</script>
=======
    }

  },
}
</script>
<style scoped>

</style>
>>>>>>> e415b6bb53c34bc178e2cbd78158f9f2b70e4322
