<template>
    <div class="wrapper-page">
        <div class="page-heading">
            <div class="page-details">
                <v-toolbar outlined color="grey lighten-3" elevation="0">
                    <v-toolbar-title>

                        Oficinas
                    </v-toolbar-title>
                </v-toolbar>
            </div>

        </div>
        <div class="content-wrapper">

            <div class="content full">
                <v-container>
                    <v-card :loading="loading_table">
                        <v-overlay absolute :value="loading_table">
                            <v-progress-circular indeterminate size="64"></v-progress-circular>
                        </v-overlay>

                        <v-card-text>
                            <h3>Agregar Nuevo </h3>
                            <v-divider></v-divider>

                            <v-form ref="form_ofic" v-model="form_valid" lazy-validation>
                                <v-row class="mt-5">
                                    <v-col cols="12" sm="6" md="2" class="pb-0 ">
                                        <h4 class="pb-0 grey--text text--darken-2">
                                            IDUOPER
                                        </h4>
                                        <v-text-field v-model="form.iduoper" required dense outlined
                                            :rules="obligatorioRules"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="5" class="pb-0">
                                        <h4 class="pb-0 grey--text text--darken-2">
                                            Nombre
                                        </h4>
                                        <v-text-field v-model="form.nombre" required dense outlined
                                            :rules="obligatorioRules"></v-text-field>
                                    </v-col>

                                    <v-col cols="12" sm="6" md="5" class="pb-0">
                                        <h4 class="pb-0 grey--text text--darken-2">
                                            Dependencia
                                        </h4>
                                        <v-text-field v-model="form.dependencia" required dense outlined
                                            :rules="obligatorioRules"></v-text-field>
                                    </v-col>

                                </v-row>

                                <div class="d-flex mt-3">
                                    <v-spacer></v-spacer>
                                    <v-btn :disabled="!form_valid" color="primary" @click="Guardar()">
                                        Registrar
                                    </v-btn>
                                </div>
                            </v-form>

                        </v-card-text>

                    </v-card>
                </v-container>
            </div>
        </div>
    </div>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
import SelectOficina from "@/components/autocomplete/SelectOficina.vue";
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";

export default {
    metaInfo: { title: "Usuarios" },
    layout: Layout,
    props: {
        roles: Array,
    },

    data: () => ({

        loading_table: false,
        form_valid: null,

        form: {
            iduoper: null,
            nombre: null,
            dependencia: "",
        },

        obligatorioRules: [(v) => !!v || "*Obligatorio"],
        absolute: false,
        drawer: true,


    }),
    computed: {
        size_display: {
            get: function () {
                if (this.$vuetify.breakpoint.width > 960) {
                    this.absolute = false;
                    return true;
                }
                this.absolute = true;
                return false;
            },
            set: function (newValue) { },
        },
    },
    methods: {
        async Guardar() {
            if (this.$refs.form_ofic.validate()) {
                let res = await axios.post(
                    "/admin/oficinas",
                    this.form
                );
                console.log(res.data);
                if (res.data.estado) {
                    this.$refs.form_ofic.reset();
                }
            }

            console.log(this.form);
        }
    }

};
</script>

<style>
.wrapper-page {
    width: 100%;
    height: 100%;
    background-color: #fafafa;
}

.page-heading {
    display: flex;
    justify-content: space-between;
}

.page-details {
    width: 256px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    border-right: 1px solid rgba(0, 0, 0, 0.1);
}

.page-search {
    width: calc(100% - 256px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.content-wrapper {
    position: relative;
    display: flex;
    width: 100%;
    height: 100%;
}

.content {
    width: 100%;
    margin-left: 256px;
    transition: all 0.3s ease;
}

.content.full {
    width: 100%;
    margin-left: 0;
}

@media (max-width: 960px) {
    .content {
        margin-left: 0;
    }

    .page-details {
        width: 200px;
    }

    .page-search {
        width: calc(100% - 200px);
    }
}

@media (max-width: 740px) {
    .page-details {
        width: 180px;
    }

    .page-search {
        width: calc(100% - 180px);
    }
}
</style>
