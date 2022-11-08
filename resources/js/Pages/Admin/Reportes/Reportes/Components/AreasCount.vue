<template>
    <div style="width: 100%; height: 100%;">
      <v-card elevation="0" v-for="item in data" :key="item.id" style="margin-bottom:5px">
          <div class="d-flex" style="justify-content:space-between">
            <span>{{ item.codigo }}</span>
            <span>Reg. {{ item.registros }}</span>
          </div>
          <div>
            <span>{{item.nombre}}</span>
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
