<template>
<v-container class="pa-0" style="background:white; height: calc(100vh - 60px);">
<v-card>
  <card-title>
    <div>
      <div class="ma-2" style="background:yellow; height: 38px;">                
        <v-autocomplete
          v-model="dep"
          clearable
          dense
          label="Dependencia"
          outlined
          :items="dependencias"
          :filter="customFilter"
          item-value="iduoper"
          item-text="nombres"
          :search-input.sync="oficinas_search"
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
                  <v-list-item-title v-html="data.item.iduoper">
                  </v-list-item-title>
                  <v-list-item-subtitle>
                      {{ data.item.nombres }}
                  </v-list-item-subtitle>
              </v-list-item-content>
          </template>
      </v-autocomplete>
    </div>
    </div>
  </card-title>

  <v-tabs
    v-model="tab"
    background-color="transparent"
    color="primary"
    dense
  >
    <v-tab
      v-for="item in items"
      :key="item"
    >
        {{ item }}
    </v-tab>
  </v-tabs>

  <v-tabs-items v-model="tab">
      <v-tab-item  href="#Bienes AF">
        <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">
                    Nombre
                  </th>
                  <th class="text-left">
                    Código
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(item,index) in bienesAF"
                  :key="index"
                >
                  <td>{{ item.nombre }}</td>
                  <td>{{ item.codigo }}</td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
       <div v-if="bienesAF.length" v-observe-visibility="handleScrolledToBottom">        
       </div>
       </v-tab-item> 
       <v-tab-item href="#Bienes ND">
       {{ bienesND  }} 2
       </v-tab-item> 
       <v-tab-item href="#Sobrantes">
       {{ sobrantes }} 3
       </v-tab-item> 
  </v-tabs-items>
</v-card>
</v-container>
</template>
<script>
import Layout from "@/Layouts/InventarioLayout";
import axios from 'axios';
export default {
    metaInfo: { title: "Conciliación" },
    layout: Layout,
    data () {
        return {
          bienesAF: [],
          bienesND: [],
          page:1,
          sobrantes: [],
          tab: null,
          items: ['Bienes AF', 'Bienes NP', 'Sobrantes']
        }
    },


    mounted() {
      this.getBienesAF()
    },

    // created() {
    //   $this->
    // },

    // watch:{     
    // },

    methods: {

      async getBienesAF() {
        let res = await axios.get("/inventario/conciliacion/bienesAF/"+this.page);
        this.bienesAF.push(...res.data.datos);
      },

      handleScrolledToBottom(isVisible){
        if(!isVisible){ return}
        // console.log('abc');
        this.page++;
        this.getBienesAF()
      }

    },
}
</script>
<style scoped>

</style>
