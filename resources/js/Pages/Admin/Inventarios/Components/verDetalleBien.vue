<template>
    <div class="d-flex" style="width:100%; background-color: #fff; height: 130px; align-items: center; justify-content:center;">
        {{data}}
    </div>  
  </template>
  
  <script>
  export default {
    props:['item'] ,
    data () {
      return {
          data:null,
      }
    },
    created(){
        this.getBien();
    },

    methods:{
      async getBien() {
        let res = await axios.get('/admin/inventario/getBien/'+this.item.id);
        this.data = res.data.datos;
      },
    },

  }
  </script>
  