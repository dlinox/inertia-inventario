<template>
    <v-card :loading="loadin_form" :disabled="loadin_form" class="mx-auto bg-transparent" max-width="850" tile>
        <v-overlay absolute :value="loadin_form">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>

        <v-container>
            <v-row class="" align="center" no-gutters>
                <v-col cols="12" class="py-2 py-md-3">
                    <strong> REGISTRO DE INVENTARIOS</strong>
                </v-col>
                <v-col cols="12" sm="auto" class="d-flex ml-auto py-2 py-md-3">
                    <AreasAsignadasComponent :areas="mis_areas" />
                </v-col>
            </v-row>
        </v-container>
    </v-card>
</template>

<script>
import Layout from "@/Layouts/InventarioLayout";
import axios from "axios";

import AreasAsignadasComponent from "@/Pages/Inventario/Components/AreasAsignadasComponent.vue";


export default {
    components: {
        AreasAsignadasComponent,

    },
    props: {
        estados: Array,
        mis_areas: Array,
        areas: Array,
    },
    layout: Layout,
    data: () => ({

        loadin_form: false,
        disable_input: false,
        disable_input_new: false,

        areas_by_oficina: [],
        personas: [],
        personas_search: "",
        loading_search_persona: false,

        personas_otro: [],
        personas_search_otro: "",
        loading_search_persona_otro: false,
        data_emit: {},

        dialog_delete: false,
        is_edit: false,
        is_new: false,

        show_persona_otro: false,
        nameRules: [(v) => !!v || "*Obligatorio"],

        //alerta
        show_alert: false,
        msg_alert: "",
        type_alert: "",

        foto_ref: null,
        //correlativo
        corr_num: "",
        corr_area: "",
        dialog_corr: false,
        //areas_control
        mis_areas_id: [],
    }),
    created() {
        this.mis_areas_id = this.mis_areas.map((area) => area.iduoper);
    },

    computed: {
        user() {
            return this.$page.props.auth.user;
        },
    },
};
</script>
