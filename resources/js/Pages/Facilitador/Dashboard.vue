<template>
    <div>
       <Reporte/>
    </div>
</template>

<script>
import Layout from "@/Layouts/FacilitadorLayout";
import Reporte from './Reporte/'
export default {
    components:{Reporte},
    metaInfo: { title: "Dashboard - facilitador" },
    layout: Layout,
    data: () => ({
        mensaje_hijo: 0,
    }),
};
</script>

