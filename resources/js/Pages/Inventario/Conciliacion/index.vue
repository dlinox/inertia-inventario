<template>
<v-container  style="background:white; height: calc(100vh - 60px);">
  <v-tabs
    v-model="tab"
    background-color="transparent"
    color="basil"
    dense
  >
    <v-tab
      v-for="item in items"
      :key="item"
    >
      {{ item }}
    </v-tab>
  </v-tabs>

  <v-tabs-items v-model="tab">
      <v-tab-item>
       {{ text }}
       </v-tab-item>
  </v-tabs-items>
</v-container>
</template>
<script>
import Layout from "@/Layouts/InventarioLayout";
import axios from 'axios';
export default {
    metaInfo: { title: "Conciliación" },
    layout: Layout,
    data () {
        return {
          tab: null,
          items: [
              'Bienes AF', 'Bienes NP', 'Sobrantes'
          ],
          text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
          }
    },
    created() {
    },

    watch:{     
    },

    methods: {




    },
}
</script>
<style scoped>

</style>
