<template>
  <v-container class="pa-0 pt-2">
    
      <v-card class="my-2 py-3" style="min-height: 80vh;">
      <div class="">
        <div class="ma-2" style="height: 38px;">
          <v-autocomplete v-model="dep" clearable dense label="Dependencia" outlined :items="dependencias"
            :filter="customFilterDEP" item-value="iduoper" item-text="dependencia" required>
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
                <v-list-item-title v-html="data.item.iduoper">
                </v-list-item-title>
                <v-list-item-subtitle>
                  {{ data.item.dependencia }}
                </v-list-item-subtitle>
              </v-list-item-content>
            </template>
          </v-autocomplete>
        </div>
      </div>


      <v-tabs v-model="tab" background-color="transparent" color="primary" dense>
        <v-tab v-for="item in items" :key="item">
          {{ item }}
        </v-tab>
      </v-tabs>

      <v-tabs-items v-model="tab">
        <v-tab-item href="#Bienes AF">
          <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">
                    Codigo
                  </th>
                  <th class="text-left">
                    Nombre
                  </th>
                  <th class="text-left">
                    Cod. Ubic
                  </th>
                  <th class="text-left">
                    Oficina
                  </th>
                  <th class="text-left">
                    Etiqueta
                  </th>
                  <th class="text-left">
                    Responsable
                  </th>
                </tr>
              </thead>
              <tbody>


                <tr v-for="(item, index) in bienesAF" :key="index">
                  <td>{{ item.codigo }}</td>
                  <td>{{ item.descripcion }}</td>
                  <td>{{ item.cod_ubicacion }}</td>
                  <td>{{ item.nombre }}</td>
                  <td>{{ item.idreg_anterior }}</td>
                  <td>
                    <div>{{ item.dni }}</div>
                    {{ item.nombres }} {{ item.paterno }} {{ item.materno }}
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
          <div v-if="bienesAF.length" v-observe-visibility="handleScrolledToBottom">
          </div>
        </v-tab-item>


        <v-tab-item href="#Bienes ND">
          <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">
                    Codigo
                  </th>
                  <th class="text-left">
                    Nombre
                  </th>
                  <th class="text-left">
                    Cod. Ubic
                  </th>
                  <th class="text-left">
                    Oficina
                  </th>
                  <th class="text-left">
                    Etiqueta
                  </th>
                  <th class="text-left">
                    Responsable
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in bienesND" :key="index">
                  <td>{{ item.codigo }}</td>
                  <td>{{ item.descripcion }}</td>
                  <td>{{ item.cod_ubicacion }}</td>
                  <td>{{ item.nombre }}</td>
                  <td>{{ item.idreg_anterior }}</td>
                  <td>
                    <div>{{ item.dni }}</div>
                    {{ item.nombres }} {{ item.paterno }} {{ item.materno }}
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
          <div v-if="bienesND.length" v-observe-visibility="handleScrolledToBottomND">
          </div>
        </v-tab-item>
        <v-tab-item href="#Sobrantes">
          <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">
                    Codigo
                  </th>
                  <th class="text-left">
                    Nombre
                  </th>
                  <th class="text-left">
                    Cod. Ubic
                  </th>
                  <th class="text-left">
                    Oficina
                  </th>
                  <th class="text-left">
                    Etiqueta
                  </th>
                  <th class="text-left">
                    Responsable
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in bienesSO" :key="index">
                  <td>{{ item.codigo }}</td>
                  <td>{{ item.descripcion }}</td>
                  <td>{{ item.cod_ubicacion }}</td>
                  <td>{{ item.nombre }}</td>
                  <td>{{ item.idreg_anterior }}</td>
                  <td>
                    <div>{{ item.dni }}</div>
                    {{ item.nombres }} {{ item.paterno }} {{ item.materno }}
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
          <div v-if="bienesSO.length" v-observe-visibility="handleScrolledToBottomSO">
          </div>
        </v-tab-item>
      </v-tabs-items>
    </v-card>
  </v-container>
</template>
<script>
import Layout from "@/Layouts/FacilitadorLayout";
import axios from 'axios';
export default {
  metaInfo: { title: "Conciliación" },
  layout: Layout,
  data() {
    return {
      bienesAF: [],
      bienesND: [],
      bienesSO: [],
      page: 1,
      page_so: 1,
      tab: null,
      dep: null,
      dependencias: [],
      dependencia: null,
      items: ['Bienes AF', 'Bienes NP', 'Sobrantes']
    }
  },


  mounted() {
    this.getBienesAF()
    this.getDependencias()
    this.getBienesSO();
  },

  // created() {
  //   $this->
  // },

  watch: {
    dep: function () {
      this.bienesAF = [];
      this.getBienesAF();
      this.bienesND = [];
      this.getBienesND();
      this.bienesSO = [];
      this.getBienesSO();
    },

  },

  methods: {

    async getDependencias() {
      let res = await axios.get("/facilitador/getDependencias");
      this.dependencias = res.data.datos;
      return res.data.datos.data;
    },

    async getBienesAF() {
      let res = await axios.get("/facilitador/getBienesAF/" + this.page + "/" + this.dep);
      this.bienesAF.push(...res.data.datos);
    },
    async getBienesND() {
      let res = await axios.get("/facilitador/getBienesND/" + this.page + "/" + this.dep);
      this.bienesND.push(...res.data.datos);
    },

    async getBienesSO() {
      let res = await axios.get("/facilitador/getBienesSobrantes/" + this.page_so + "/" + this.dep);
      this.bienesSO.push(...res.data.datos);
    },

    handleScrolledToBottom(isVisible) {
      if (!isVisible) { return }
      // console.log('abc');
      this.page++;
      this.getBienesAF()
    },

    handleScrolledToBottomND(isVisible) {
      if (!isVisible) { return }
      // console.log('abc');
      this.page++;
      this.getBienesND()
    },


    handleScrolledToBottomSO(isVisible) {
      if (!isVisible) { return }
      // console.log('abc');
      this.page_so++;
      this.getBienesSO()
    },

    customFilterDEP(item, queryText, itemText) {
      const dependencia = item.dependencia.toLowerCase();
      const iduoper = item.iduoper.toLowerCase();
      const searchText = queryText.toLowerCase();
      return (
        dependencia.indexOf(searchText) > -1 ||
        iduoper.indexOf(searchText) > -1
      );
    },
  },
}
</script>
