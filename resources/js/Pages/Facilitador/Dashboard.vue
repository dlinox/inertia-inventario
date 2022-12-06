<template>
    <div>
       <Inventario/>
    </div>
</template>

<script>
import Layout from "@/Layouts/FacilitadorLayout";
import Inventario from './Inventario/'
export default {
    components:{Inventario},
    metaInfo: { title: "Dashboard - facilitador" },
    layout: Layout,
    data: () => ({
        mensaje_hijo: 0,
    }),
};
</script>
