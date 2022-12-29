<template>
    <div class="wrapper-page">
        <div class="page-heading">
            <div class="page-details">
                <v-toolbar outlined color="grey lighten-3" elevation="0">
                    <v-toolbar-title>
                        <v-app-bar-nav-icon>
                            <v-icon>mdi-account</v-icon>
                        </v-app-bar-nav-icon>
                        {{ is_nuevo ? " Nueva Persona" : "Editar Persona" }}
                    </v-toolbar-title>
                </v-toolbar>
            </div>
            <div class="page-search">
                <v-toolbar outlined color="grey lighten-5" elevation="0">
                </v-toolbar>
            </div>
        </div>
        <div class="content-wrapper">
            <v-container>
                <v-card>
                    <v-tabs left color="primary accent-4" v-model="tab">
                        <v-tab>
                            <strong> Datos de Usuario</strong>
                        </v-tab>
                        <v-tab>
                            <strong> Oficina / Areas</strong>
                        </v-tab>
                    </v-tabs>

                    <v-tabs-items v-model="tab">
                        <v-tab-item>
                            <v-card class="pa-5" flat>
                                <v-form ref="form_user" v-model="form_valid" lazy-validation>
                                    <v-row>
                                        <v-col cols="12" sm="6" md="4" class="pb-0">
                                            <h4 class="pb-0 grey--text text--darken-2">
                                                Nombres
                                            </h4>
                                            <v-text-field v-model="form.nombres" required dense
                                                :rules="obligatorioRules"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" class="pb-0">
                                            <h4 class="pb-0 grey--text text--darken-2">
                                                A. Paterno
                                            </h4>
                                            <v-text-field v-model="form.paterno" required dense
                                                :rules="obligatorioRules"></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="4" class="pb-0">
                                            <h4 class="pb-0 grey--text text--darken-2">
                                                A. Materno
                                            </h4>
                                            <v-text-field v-model="form.materno" required dense
                                                :rules="obligatorioRules"></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="4" class="pb-0">
                                            <h4 class="pb-0 grey--text text--darken-2">
                                                A. DNI
                                            </h4>
                                            <v-text-field type="number" v-model="form.dni" required dense
                                                :rules="dniRules" :counter="8"></v-text-field>
                                        </v-col>

                                        <v-col cols="12" sm="6" md="4" class="pb-0">
                                            <h4 class="pb-0 grey--text text--darken-2">
                                                Tipo Persona
                                            </h4>
                                            <v-autocomplete v-model="form.id_tipo_persona" :items="tipos"
                                                item-text="name" item-value="id" dense
                                                :rules="obligatorioRules"></v-autocomplete>
                                        </v-col>
                                    </v-row>

                                    <div class="d-flex mt-3">
                                        <v-spacer></v-spacer>
                                        <v-btn :disabled="!form_valid" color="primary" @click="Guardar()">
                                            {{
        is_nuevo
            ? " Registrar"
            : "Guardar Cambios"
                                            }}
                                        </v-btn>
                                    </div>
                                </v-form>
                            </v-card>
                        </v-tab-item>

                        <v-tab-item> ... </v-tab-item>
                    </v-tabs-items>
                </v-card>
            </v-container>
        </div>
    </div>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";

export default {
    metaInfo: { title: "Formulario Usuarios" },
    layout: Layout,
    props: {
        roles: Array,
        data: Object,
        is_nuevo: Boolean,
    },
    data: () => ({
        tipos: [
            { id: 1, name: "Docente" },
            { id: 2, name: "Administrativo" },
            { id: 3, name: "C.A.S." },
        ],
        tab: 0,
        form_valid: true,
        show_password: false,
        form: {
            id: null,
            nombres: "",
            paterno: "",
            materno: "",
            dni: "",
            id_tipo_persona: "",
        },

        obligatorioRules: [(v) => !!v || "*Obligatorio"],
        emailRules: [
            (v) => !!v || "*Obligatorio",
            (v) => /.+@.+\..+/.test(v) || "Formato invalido",
        ],

        dniRules: [
            (v) => !!v || "*Obligatorio",
            (v) => v.length == 8 || "El DNI debe tener 8 caracteres",
        ],

        areas_listas: false,
    }),
    computed: {},
    watch: {},
    methods: {
        async Guardar() {
            if (this.$refs.form_user.validate()) {
                let res = await axios.post(
                    "/admin/personas/guardar",
                    this.form
                );
                console.log(res.data);
                if (this.is_nuevo) {
                    this.$refs.form_user.reset();
                }
            }
        },
    },
    async created() {
        console.log(this.data);
        if (this.data && !this.is_nuevo) {
            this.form = this.data;
        }
    },
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
    width: 500px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    border-right: 1px solid rgba(0, 0, 0, 0.1);
}

.page-search {
    width: calc(100% - 500px);
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
        width: 400px;
    }

    .page-search {
        width: calc(100% - 400px);
    }
}

@media (max-width: 740px) {
    .page-details {
        width: 280px;
    }

    .page-search {
        width: calc(100% - 280px);
    }
}

.v-expansion-panel-content__wrap {
    padding: 0 0 16px;
}
</style>
