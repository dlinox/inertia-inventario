<template>
    <div class="wrapper-page">
        <template> </template>
        <div class="page-heading">
            <div class="page-details">
                <v-toolbar outlined color="grey lighten-3" elevation="0">
                    <v-toolbar-title>
                        <v-app-bar-nav-icon>
                            <v-icon>mdi-account</v-icon>
                        </v-app-bar-nav-icon>

                        {{ is_nuevo ? " Nuevo Usuarios" : "Editar Usuarios" }}
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
                                <v-form
                                    ref="form_user"
                                    v-model="form_valid"
                                    lazy-validation
                                >
                                    <v-row>
                                        <v-col
                                            cols="12"
                                            sm="6"
                                            md="4"
                                            class="pb-0"
                                        >
                                            <h4
                                                class="pb-0 grey--text text--darken-2"
                                            >
                                                Nombres
                                            </h4>
                                            <v-text-field
                                                v-model="form.nombres"
                                                required
                                                dense
                                                :rules="obligatorioRules"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col
                                            cols="12"
                                            sm="6"
                                            md="4"
                                            class="pb-0"
                                        >
                                            <h4
                                                class="pb-0 grey--text text--darken-2"
                                            >
                                                Apellidos
                                            </h4>
                                            <v-text-field
                                                v-model="form.apellidos"
                                                required
                                                dense
                                                :rules="obligatorioRules"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col
                                            cols="12"
                                            sm="6"
                                            md="4"
                                            class="pb-0"
                                        >
                                            <h4
                                                class="pb-0 grey--text text--darken-2"
                                            >
                                                Correo
                                            </h4>
                                            <v-text-field
                                                v-model="form.email"
                                                required
                                                dense
                                                :rules="emailRules"
                                            ></v-text-field>
                                        </v-col>

                                        <v-col
                                            v-if="is_nuevo"
                                            cols="12"
                                            sm="6"
                                            md="4"
                                            class="pb-0"
                                        >
                                            <h4
                                                class="pb-0 grey--text text--darken-2"
                                            >
                                                Contraseña
                                            </h4>

                                            <v-text-field
                                                v-model="form.password"
                                                :append-icon="
                                                    show_password
                                                        ? 'mdi-eye'
                                                        : 'mdi-eye-off'
                                                "
                                                :type="
                                                    show_password
                                                        ? 'text'
                                                        : 'password'
                                                "
                                                required
                                                dense
                                                :rules="obligatorioRules"
                                                @click:append="
                                                    show_password =
                                                        !show_password
                                                "
                                            ></v-text-field>
                                        </v-col>

                                        <v-col
                                            cols="12"
                                            sm="6"
                                            md="4"
                                            class="pb-0"
                                        >
                                            <h4
                                                class="pb-0 grey--text text--darken-2"
                                            >
                                                Rol de usuario
                                            </h4>
                                            <v-autocomplete
                                                v-model="form.rol"
                                                :items="roles"
                                                item-text="name"
                                                item-value="id"
                                                dense
                                                :rules="obligatorioRules"
                                            ></v-autocomplete>
                                        </v-col>
                                    </v-row>

                                    <div class="d-flex mt-3">
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            :disabled="!form_valid"
                                            color="primary"
                                            @click="Guardar()"
                                        >
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

                        <v-tab-item>
                            <v-card class="py-4" flat tile>
                                <v-card-title>
                                    Areas Asignadas

                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="secondary"
                                        @click="
                                            dialog_asignar = !dialog_asignar
                                        "
                                    >
                                        Asignar Areas
                                    </v-btn>
                                </v-card-title>
                                <v-expansion-panels focusable accordion tile>
                                    <v-expansion-panel
                                        v-for="(item, i) in form.oficinas"
                                        :key="i"
                                    >
                                        <v-expansion-panel-header>
                                            <strong class="primary--text">{{
                                                item.nombre
                                            }}</strong>
                                        </v-expansion-panel-header>

                                        <v-expansion-panel-content>
                                            <template v-if="areas_listas">
                                                <v-list subheader two-line>
                                                    <v-subheader inset>
                                                        Areas asignadas a
                                                        {{ form.nombres }}
                                                    </v-subheader>

                                                    <v-list-item
                                                        v-for="(
                                                            area, index
                                                        ) in item.areas"
                                                        :key="index"
                                                    >
                                                        <v-list-item-avatar>
                                                            <v-icon
                                                                class="warning"
                                                                dark
                                                            >
                                                                mdi-office-building-marker
                                                            </v-icon>
                                                        </v-list-item-avatar>

                                                        <v-list-item-content>
                                                            <v-list-item-title
                                                                v-text="
                                                                    area.nombre
                                                                "
                                                            ></v-list-item-title>

                                                            <v-list-item-subtitle>
                                                                {{
                                                                    area.responsables
                                                                }}

                                                                <v-progress-linear
                                                                    :value="
                                                                        (area.inventarios *
                                                                            100) /
                                                                        area.bienesk
                                                                    "
                                                                    height="15"
                                                                >
                                                                    <small>
                                                                        {{
                                                                            (area.inventarios *
                                                                                100) /
                                                                            area.bienesk
                                                                        }}
                                                                        %
                                                                    </small>
                                                                </v-progress-linear>
                                                            </v-list-item-subtitle>
                                                        </v-list-item-content>

                                                    </v-list-item>
                                                </v-list>
                                            </template>

                                            <template v-else>
                                                <div class="text-center py-5">
                                                    <v-progress-circular
                                                        indeterminate
                                                        color="primary"
                                                    ></v-progress-circular>
                                                </div>
                                            </template>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                </v-expansion-panels>
                            </v-card>
                        </v-tab-item>
                    </v-tabs-items>
                </v-card>
            </v-container>
        </div>

        <v-dialog max-width="500" persistent v-model="dialog_asignar">
            <v-card>
                <v-card-title primary-title>
                    Asignar Area - {{ form.nombres }}
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text class="mt-3">
                    <SelectOficina v-model="oficina_asig"></SelectOficina>

                    <v-autocomplete
                        v-model="area_asig"
                        :items="areas_asig"
                        item-text="nombre"
                        item-value="id"
                        label="Seleccione un Area"
                        outlined
                        dense
                        multiple
                    >
                    </v-autocomplete>

                    <v-btn
                        class="mr-3"
                        text
                        color="red"
                        @click="dialog_asignar = false"
                    >
                        cancelar
                    </v-btn>
                    <v-btn
                        :disabled="!area_asig.length > 0"
                        @click="guardarAsingar"
                    >
                        Asignar
                    </v-btn>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog max-width="500" persistent v-model="info_area.dialog">
            <v-card dark>
                <v-card-title primary-title>
                    Informacion del area
                </v-card-title>
                <v-divider></v-divider>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <small>
                                <strong> Responsable(s): </strong> Nombre del
                                responsable
                            </small>
                        </v-col>
                        <v-col
                            cols="4"
                            class="d-flex justify-content-center align-items-center"
                        >
                            <v-progress-circular
                                :rotate="270"
                                :size="100"
                                :width="15"
                                :value="30"
                                color="teal"
                            >
                                30%
                            </v-progress-circular>
                        </v-col>
                        <v-col cols="8">
                            <v-progress-linear :value="25" height="15">
                                <small> 25 % </small>
                            </v-progress-linear>
                        </v-col>
                    </v-row>
                </v-container>

                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn
                        text
                        color="red"
                        @click="info_area.dialog = !info_area.dialog"
                        >Salir</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
import SelectOficina from "@/components/autocomplete/SelectOficina.vue";
import { Inertia } from "@inertiajs/inertia";

export default {
    metaInfo: { title: "Formulario Usuarios" },
    layout: Layout,
    props: {
        roles: Array,
        data: Object,
        is_nuevo: Boolean,
    },
    data: () => ({
        tab: 0,
        form_valid: true,
        show_password: false,
        form: {
            id: null,
            nombres: "",
            apellidos: "",
            rol: "",
            estado: 1,
            email: "",
            oficinas: "",
            password: "",
        },

        obligatorioRules: [(v) => !!v || "*Obligatorio"],
        emailRules: [
            (v) => !!v || "*Obligatorio",
            (v) => /.+@.+\..+/.test(v) || "Formato invalido",
        ],

        dialog_asignar: false,
        oficina_asig: null,
        area_asig: [],
        areas_asig: null,

        info_area: {
            dialog: false,
            datos: {},
        },

        areas_listas: false,
    }),
    computed: {},
    watch: {
        async oficina_asig(val) {
            if (!val) return;
            let res = await axios.get(
                "/get-data/areas/by-oficina/" + val + "/" + this.form.id
            );
            this.areas_asig = res.data.datos;
        },
    },
    methods: {
        async Guardar() {
            if (this.$refs.form_user.validate()) {
                let res = await axios.post(
                    "/admin/usuarios/guardar",
                    this.form
                );
                console.log(res.data);
                if (this.is_nuevo) {
                    this.$refs.form_user.reset();
                }
            }
        },

        async getInfoAreas(oficina) {
            let res = await axios.get(
                "/get-data/areas/all-info/" + oficina.id + "/" + this.form.id
            );

            return res.data.datos;
        },
        async getInformacionArea() {
            for (let i = 0; this.form.oficinas.length > i; i++) {
                this.form.oficinas[i].areas = await this.getInfoAreas(
                    this.form.oficinas[i]
                );
            }
            console.log(this.form.oficinas);
            this.areas_listas = true;
        },
        async guardarAsingar() {
            let res = await axios.post("/admin/usuarios/asignar-area", {
                areas: this.area_asig,
                usuario: this.form.id,
            });

            if(res.data.estado){
                Inertia.get('/admin/usuarios/formulario/'+ this.form.id);
            }
            
        },
    },
    async created() {
        console.log(this.data);
        if (this.data && !this.is_nuevo) {
            this.data.rol = parseInt(this.data.rol);
            this.form = this.data;
            await this.getInformacionArea();
        }
    },
    components: { SelectOficina },
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

.v-expansion-panel-content__wrap {
    padding: 0 0 16px;
}
</style>
