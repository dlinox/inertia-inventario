<template>
  <div class="d-flex" style="width:100%; background-color: #fff; height: 130px; align-items: center; justify-content:center;">
    <div style="text-align:center;">
      <!-- <div style=" margin-bottom:-5px;"><span class="" style="font-size:1em; color: #837272;"> {{datos.nroanterior}} </span></div> -->
      <div style="margin-bottom:-10px;"><p width="60%" style="font-size: 0.8rem; line-height: 1;">{{datos.label}}</p></div>
      <div style=" margin-bottom:0px;"><span class="font-weight-bold" style=" color:#000000; font-size:1.3em">{{ datos.nroactual }}</span></div>
      <div><p width="60%" style="font-size: 0.8rem; line-height: 1;">{{datos.label2}}</p></div>
    </div>
  </div>

</template>

<script>
 export default {
    props:['datos'] ,
 }

</script>
