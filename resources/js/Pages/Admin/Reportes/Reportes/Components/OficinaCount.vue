<template>
    <div style="width: 100%; height: 100%;">
        {{ data.oficina[0].registros }}
    </div>
  </template>

<script>
export default {
props:['oficina'] ,
data () {
    return {
        ofi: this.oficina,
        data:null,
        registros: 4,
    }
},
created(){
    this.getCountOficinas()
},
methods:{
    async getCountOficinas() {
        let res = await axios.get('/admin/reportes/getCountOficina/'+this.ofi);
        this.data = res.data;
    },
},

}

</script>
