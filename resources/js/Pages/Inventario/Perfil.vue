<template>
    <v-container class="my-3 main-page">
        <v-card tile>
            <v-card-title>
                <v-btn tile @click="atras" icon class="mr-2">
                    <v-icon>mdi-arrow-left</v-icon>
                </v-btn>
                Datos del Usuario
            </v-card-title>
            <v-divider></v-divider>
            <v-row class="pa-4" no-gutter>
                <v-col cols="12" sm="4">
                    <h4
                        class="pb-0 grey--text text--darken-2 text-sm-start text-sm-end"
                    >
                        Nombres y Apellidos:
                    </h4>
                </v-col>
                <v-col cols="12" sm="8">
                    <h4 class="pb-0 grey--text text--darken-4">
                        {{ datos.nombres }} {{ datos.apellidos }}
                    </h4>
                </v-col>

                <v-col cols="12" sm="4">
                    <h4
                        class="pb-0 grey--text text--darken-2 text-sm-start text-sm-end"
                    >
                        Correo electronico:
                    </h4>
                </v-col>
                <v-col cols="12" sm="8">
                    <h4 class="pb-0 grey--text text--darken-4">
                        {{ datos.email }}
                    </h4>
                </v-col>

                <v-col cols="12" sm="4">
                    <h4
                        class="pb-0 grey--text text--darken-2 text-sm-start text-sm-end"
                    >
                        Rol de usuario:
                    </h4>
                </v-col>
                <v-col cols="12" sm="8">
                    <h4 class="pb-0 grey--text text--darken-4">
                        {{ datos.rol_name }}
                    </h4>
                </v-col>

                <v-col cols="12" sm="4">
                    <h4
                        class="pb-0 grey--text text--darken-2 text-sm-start text-sm-end"
                    >
                        Contraseña:
                    </h4>
                </v-col>
                <v-col cols="12" sm="8">
                    <v-btn
                        @click="dialog_change_pass = !dialog_change_pass"
                        small
                        color="primary"
                        >Cambiar contraseña</v-btn
                    >
                </v-col>
            </v-row>
        </v-card>
        <!--
        <v-card tile>
            <v-card-title> Areas Asignadas </v-card-title>
            <v-divider></v-divider>
            <v-expansion-panels
                focusable
                accordion
                tile
                v-model="areas_details"
            >
                <v-expansion-panel v-for="(item, i) in datos.oficinas" :key="i">
                    <v-expansion-panel-header>
                        <strong class="primary--text">{{ item.nombre }}</strong>
                    </v-expansion-panel-header>

                    <v-expansion-panel-content>
                        <template v-if="areas_listas">
                            <v-list subheader two-line>
                                <v-subheader inset>
                                    Areas asignadas a
                                    {{ datos.nombres }}
                                </v-subheader>

                                <v-list-item
                                    v-for="(area, index) in item.areas"
                                    :key="index"
                                >
                                    <v-list-item-avatar>
                                        <v-icon class="warning" dark>
                                            mdi-office-building-marker
                                        </v-icon>
                                    </v-list-item-avatar>

                                    <v-list-item-content>
                                        <v-list-item-title
                                            v-text="area.nombre"
                                        ></v-list-item-title>

                                        <v-list-item-subtitle>
                                            {{ area.responsables }}

                                            <v-progress-linear
                                                :value="
                                                    (area.inventarios * 100) /
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
    -->

        <v-dialog
            v-model="dialog_change_pass"
            persistent
            :overlay="false"
            max-width="400px"
        >
            <v-card>
                <v-card-title class="text-h5">
                    Cambiar contraseña
                </v-card-title>

                <v-form
                    class="px-5 py-4"
                    ref="form"
                    v-model="valid"
                    lazy-validation
                >
                    <v-text-field
                        v-model="password"
                        :append-icon="show_password ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.required, rules.min]"
                        :type="show_password ? 'text' : 'password'"
                        label="Nueva Contraseña"
                        counter
                        @click:append="show_password = !show_password"
                    ></v-text-field>

                    <v-btn
                        :disabled="!valid"
                        color="primary"
                        class="mt-1"
                        block
                        :loading="loading_btn"
                        @click="ChangePassword()"
                    >
                        Guardar Contraseña
                    </v-btn>

                    <v-btn
                        color="red"
                        class="mt-3"
                        block
                        text
                        @click="dialog_change_pass = !dialog_change_pass"
                    >
                        Cancelar
                    </v-btn>
                </v-form>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
import Layout from "@/Layouts/InventarioLayout";

export default {
    components: {},
    props: {
        datos: Object,
    },
    layout: Layout,
    data: () => ({
        loading_btn: false,
        show_password: false,
        password: "",
        valid: true,

        dialog_change_pass: false,
        areas_details: 0,
        areas_listas: false,

        rules: {
            required: (value) => !!value || "Requerido.",
            min: (v) => v.length >= 4 || "Min 4 caracteres",
            email: (v) => /.+@.+\..+/.test(v) || "Formato incorrecto",
        },
    }),
    methods: {
        async getInfoAreas(oficina) {
            let res = await axios.get(
                "/get-data/areas/all-info/" + oficina.id + "/" + this.datos.id
            );

            return res.data.datos;
        },

        async getInformacionArea() {
            for (let i = 0; this.datos.oficinas.length > i; i++) {
                this.datos.oficinas[i].areas = await this.getInfoAreas(
                    this.datos.oficinas[i]
                );
            }
            console.log(this.datos.oficinas);
            this.areas_listas = true;
        },

        async ChangePassword() {
            if (this.$refs.form.validate()) {
                try {
                    this.loading_btn = true;
                    let res = await axios.post("/inventario/update-password", {
                        password: this.password,
                    });

                    this.dialog_change_pass = false;
                    this.loading_btn = false;
                } catch (error) {
                    this.mensaje = error.response.data.error;
                    this.loading_btn = false;
                }
            }
        },
        atras() {
            this.$inertia.get("/inventario/");
        },
    },
    watch: {},

    async created() {
        console.log(this.data);
        if (this.datos) {
            // await this.getInformacionArea();
        }
    },
};
</script>

<style scoped>
.main-page {
    min-height: 90vh;
}
</style>
