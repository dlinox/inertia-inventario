<template>
    <div>
        <div @click="change(active)"  class="d-flex pa-2 pl-0" style="justify-content:space-between; ">
            <span> <span class="mdi mdi-label-outline"></span> {{ item.nombre }}</span>
            <span style=" font-weight: bold;">{{ item.registros }}</span>
        </div>
        <div v-if="active === true" class="pl-3">
            <div v-for="ite in data" :key="ite.id" class="d-flex pa-2 pl-0" style="justify-content:space-between;">
                <div>
                    <a :href="ite.url" target="_blank"  style="text-decoration:none; color:#000000DD">
                        <span > <span class="mdi mdi-radiobox-blank pr-2 pl-3"  ></span> {{ ite.codigo }}</span>
                        <span style=" font-weight: "> - {{ ite.nombre }}</span>
                    </a>
                </div>
                    <!-- <span class="mdi mdi-eye"></span> -->
            </div>
        </div>
    </div>
</template>
<script>

export default {
    props:['item'] ,
    data () {
      return {
          active:false,
          data:[],
      }
    },
    created(){
        this.getRegistros();
    },

    methods:{
      async getRegistros() {
        let res = await axios.get('/admin/reportes/getCargrosByArea/'+this.item.id);
        this.data = res.data.cargos;
      },
      change( estado ){
        this.active = !estado;
      }
    },

  }

  </script>
