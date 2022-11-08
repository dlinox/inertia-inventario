<template>
    <v-container>
        <h1>Dashboard</h1>
       
    </v-container>
</template>

<script>
import Layout from "@/Layouts/AdminLayout";
export default {
    metaInfo: { title: "Dashboard" },
    layout: Layout,
    data: () => ({
        mensaje_hijo: 0,
    }),
};
</script>
