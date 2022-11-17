<template>
    <div style="width: 100%; height: 100%;">
      <v-card elevation="0" class="pl-0" v-for="item in data" :key="item.id" style="margin-bottom:5px; cursor:pointer;">
        <CargosXAreas :item="item" />
        <hr style="height:0.1rem; border:solid 0.5px #cdcdcd9d;">
      </v-card>

    </div>
  </template>
<script>
import CargosXAreas from './CargosXAreas.vue';
export default {
   components:{CargosXAreas},
    props:['oficina'] ,
    data () {
      return {
          ido: this.oficina,
          active:false,
          data:[],
      }
    },
    created(){
       this.getRegistros();
    },
    mounted(){

    },
    methods:{
      async getRegistros() {
          let res = await axios.get('/admin/reportes/getCountAreaCargos/'+this.oficina);
          this.data = res.data.areas;
      },
      change( estado ){
        this.active = !estado;
      }
    },

  }

  </script>
