<template>
    <div>
        <Dashboard/>
    </div>
</template>

<script>
import Dashboard from './Reportes/Reportes'
import Layout from "@/Layouts/AdminLayout";
export default {
    components:{Dashboard},
    metaInfo: { title: "Dashboard" },
    layout: Layout,
    data: () => ({
        mensaje_hijo: 0,
    }),
};
</script>
