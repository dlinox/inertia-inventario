<template>
    <div style="width: 100%; height: 100%;">
        <v-card elevation="0" class="pl-0" v-for="item in data" :key="item.id" style="margin-bottom:5px; cursor:pointer;">
        <div class="d-flex pa-2 pl-0" style="justify-content:space-between; ">
            <span> <span class="mdi mdi-label-outline"></span> {{ item.nombre }}</span>
            <span style=" font-weight: bold;">{{ item.registros }}</span>
        </div>
          <hr style="height:0.1rem; border:solid 0.5px #cdcdcd9d;">
      </v-card>
    </div>
  </template>

  <script>
  export default {
    props:['oficina'] ,
    data () {
      return {
          ido: this.oficina,
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
          let res = await axios.get('/admin/reportes/getCountArea/'+this.oficina);
          this.data = res.data.areas;
      },
    },

  }

  </script>
