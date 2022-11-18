<template>
    <div class="my-3">
        <v-card
            :loading="loadin_form"
            :disabled="loadin_form"
            class="mx-auto bg-transparent"
            max-width="850"
            tile
        >
            <v-overlay absolute :value="loadin_form">
                <v-progress-circular
                    indeterminate
                    size="64"
                ></v-progress-circular>
            </v-overlay>

            <v-container>
                <v-row class="" align="center" no-gutters>
                    <v-col cols="12" sm="7" md="8" class="px-1 py-2 py-md-3">
                        <div class="text-h6">Registar</div>
                    </v-col>

                    <v-col cols="12" sm="auto" class="ml-auto py-2 py-md-3">
                        <AreasAsignadasComponent
                            v-if="!is_new"
                            @setData="data_emit = $event"
                            :areas="mis_areas"
                        />
                    </v-col>

                    <template v-if="is_new">
                        <v-col cols="12 my-2">
                            <v-btn
                                class="order-sm-4"
                                dark
                                outlined
                                block
                                color="red"
                                @click="is_new = false"
                            >
                                <v-icon left> mdi-close </v-icon>
                                Cancelar
                            </v-btn>
                        </v-col>
                    </template>

                    <template v-else>
                        <v-col cols="12 my-2">
                            <div
                                class="d-flex flex-wrap align-items-center justify-space-between"
                            >
                                <ScannerBarComponent
                                    @setData="data_emit = $event"
                                />

                                <SearchCodeComponente
                                    class="order-last order-sm-2"
                                    @setData="data_emit = $event"
                                />

                                <BusquedaAvanzadaComponent
                                    @setData="data_emit = $event"
                                />

                                <v-btn
                                    class="order-sm-4"
                                    dark
                                    outlined
                                    color="primary"
                                    @click="is_new = true"
                                >
                                    <v-icon>mdi-plus</v-icon>
                                </v-btn>
                            </div>
                        </v-col>
                    </template>
                </v-row>

                <v-form ref="form" v-model="form_valid" lazy-validation>
                    <v-row class="" align="center">
                        <v-col cols="12" class="pb-4 pt-0">
                            <v-alert
                                v-if="data_emit.registrado && form_data.estado"
                                type="warning"
                                border="left"
                            >
                                <small>
                                    <b>
                                        El elemento ya se encuentra registrado.
                                    </b>
                                </small>

                                <v-divider class="my-3"> </v-divider>

                                <v-spacer></v-spacer>

                                <template v-if="is_edit">
                                    <v-btn
                                        color="red"
                                        @click="editInventario(false)"
                                    >
                                        Cancelar
                                    </v-btn>
                                </template>

                                <template v-else>
                                    <v-btn
                                        outlined
                                        color="dark"
                                        @click="dialog_delete = !dialog_delete"
                                    >
                                        Eliminar
                                    </v-btn>

                                    <v-btn
                                        color="secondary"
                                        @click="editInventario(true)"
                                    >
                                        Editar
                                    </v-btn>
                                </template>
                            </v-alert>

                            <v-alert
                                v-if="data_emit.registrado && !form_data.estado"
                                type="warning"
                                border="left"
                                color="blue-grey"
                            >
                                Elemento bloqueado, no se puede hacer
                                modificaiones.
                            </v-alert>
                        </v-col>

                        <v-col cols="12" sm="4" md="4" class="pb-1 pt-0">
                            <v-text-field
                                class="mt-0 pt-0"
                                dense
                                label="Codigo"
                                outlined
                                v-model="form_data.codigo"
                                :rules="nameRules"
                                :disabled="!is_new"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="8" md="8" class="pb-1 pt-0">
                            <v-text-field
                                class="mt-0 pt-0"
                                dense
                                label="Descripción"
                                outlined
                                v-model="form_data.descripcion"
                                :rules="nameRules"
                                :disabled="!is_new"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                            <v-text-field
                                class="mt-0 pt-0"
                                dense
                                label="Marca"
                                outlined
                                v-model="form_data.marca"
                                :disabled="!is_new"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                            <v-text-field
                                class="mt-0 pt-0"
                                dense
                                label="Modelo"
                                outlined
                                v-model="form_data.modelo"
                                :rules="nameRules"
                                :disabled="!is_new"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                            <v-text-field
                                class="mt-0 pt-0"
                                dense
                                label="Serie"
                                outlined
                                v-model="form_data.nro_serie"
                                :rules="nameRules"
                                :disabled="!is_new"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                            <SimpleAutoCompleteInput
                                v-model="form_data.id_estado"
                                :items="estados"
                                label="Estado"
                                item_text="nombre"
                                item_value="id"
                                :rules="nameRules"
                                :disabled="disable_input"
                            />
                        </v-col>

                        <v-col cols="12" class="pb-1 pt-0 d-flex">
                            <v-autocomplete
                                v-model="form_data.id_persona"
                                clearable
                                class="mt-0 pt-0"
                                dense
                                label="Responsable"
                                outlined
                                :items="personas"
                                :filter="personasFilter"
                                item-value="id"
                                :search-input.sync="personas_search"
                                :loading="loading_search_persona"
                                :rules="nameRules"
                                required
                                :disabled="disable_input"
                            >
                                <template v-slot:no-data>
                                    <v-list-item>
                                        <v-list-item-title>
                                            <template
                                                v-if="
                                                    personas_search?.length > 2
                                                "
                                            >
                                                Datos no encontrados para
                                                <strong>
                                                    {{ personas_search }}
                                                </strong>
                                            </template>
                                            <template v-else>
                                                Digite más de
                                                <strong> 2</strong> caracteres.
                                            </template>
                                        </v-list-item-title>
                                    </v-list-item>
                                </template>
                                <template v-slot:selection="data">
                                    {{ data.item.nombres }} |
                                    {{ data.item.dni }}
                                </template>

                                <template v-slot:item="data">
                                    <v-list-item-content>
                                        <v-list-item-title
                                            v-html="data.item.dni"
                                        >
                                        </v-list-item-title>
                                        <v-list-item-subtitle>
                                            {{ data.item.nombres }}
                                            {{ data.item.paterno }}
                                            {{ data.item.materno }}
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </template>
                            </v-autocomplete>

                            <template
                                v-if="
                                    !show_persona_otro &&
                                    !form_data.idpersona_otro
                                "
                            >
                                <v-btn
                                    :disabled="disable_input"
                                    class="ml-2"
                                    dark
                                    color="primary"
                                    @click="
                                        show_persona_otro = !show_persona_otro
                                    "
                                >
                                    <v-icon>mdi-account-plus</v-icon>
                                </v-btn>
                            </template>
                        </v-col>

                        <v-col
                            v-if="show_persona_otro || form_data.idpersona_otro"
                            cols="12"
                            class="pb-1 pt-0 d-flex"
                        >
                            <v-autocomplete
                                v-model="form_data.idpersona_otro"
                                clearable
                                class="mt-0 pt-0"
                                dense
                                label="2° Responsable"
                                outlined
                                :items="personas_otro"
                                :filter="personasFilter"
                                item-value="id"
                                :search-input.sync="personas_search_otro"
                                :loading="loading_search_persona_otro"
                                :rules="nameRules"
                                required
                                :disabled="disable_input"
                            >
                                <template v-slot:no-data>
                                    <v-list-item>
                                        <v-list-item-title>
                                            <template
                                                v-if="
                                                    personas_search?.length > 2
                                                "
                                            >
                                                Datos no encontrados para
                                                <strong>
                                                    {{ personas_search }}
                                                </strong>
                                            </template>
                                            <template v-else>
                                                Digite más de
                                                <strong> 2</strong> caracteres.
                                            </template>
                                        </v-list-item-title>
                                    </v-list-item>
                                </template>
                                <template v-slot:selection="data">
                                    {{ data.item.nombres }} |
                                    {{ data.item.dni }}
                                </template>
                                <template v-slot:item="data">
                                    <v-list-item-content>
                                        <v-list-item-title
                                            v-html="data.item.dni"
                                        >
                                        </v-list-item-title>
                                        <v-list-item-subtitle>
                                            {{ data.item.nombres }}
                                            {{ data.item.paterno }}
                                            {{ data.item.materno }}
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </template>
                            </v-autocomplete>

                            <v-btn
                                class="ml-2"
                                dark
                                color="red"
                                @click="show_persona_otro = !show_persona_otro"
                                :disabled="disable_input"
                            >
                                <v-icon dark>mdi-account-minus</v-icon>
                            </v-btn>
                        </v-col>

                        <v-col cols="12" class="pb-1 pt-0">
                            <v-autocomplete
                                v-model="form_data.id_oficina"
                                :disabled="disable_input"
                                :items="oficinas"
                                :rules="nameRules"
                                label="Oficina"
                                item-value="id"
                                item-text="nombre"
                                class="mt-0 pt-0"
                                required
                                clearable
                                dense
                                outlined
                            >
                                <template v-slot:selection="data">
                                    <small>
                                        <strong>{{ data.item.codigo }}</strong>
                                        {{ data.item.nombre }}</small
                                    >
                                </template>
                                <template v-slot:item="data">
                                    <v-list-item-content>
                                        <v-list-item-title
                                            v-html="data.item.codigo"
                                        >
                                        </v-list-item-title>
                                        <v-list-item-subtitle>
                                            {{ data.item.nombre }}
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </template>
                            </v-autocomplete>
                        </v-col>

                        <v-col cols="12" class="pb-1 pt-0">
                            <v-autocomplete
                                v-model="form_data.id_area"
                                :disabled="disable_input"
                                clearable
                                class="mt-0 pt-0"
                                dense
                                label="Area"
                                outlined
                                :items="areas_by_oficina"
                                item-text="nombre"
                                item-value="id"
                                :rules="nameRules"
                                required
                            ></v-autocomplete>
                        </v-col>

                        <v-col cols="12" class="pb-1 pt-0">
                            <v-textarea
                                :disabled="disable_input"
                                class="mt-0 pt-0"
                                label="Observacion"
                                dense
                                outlined
                                rows="2"
                                v-model="form_data.observaciones"
                                :rules="nameRules"
                                required
                            ></v-textarea>
                        </v-col>

                        <v-col cols="12" class="pb-3 pt-0">
                            <v-btn
                                :disabled="disable_input"
                                block
                                class="mr-2"
                                color="primary"
                                @click="Guardar"
                            >
                                <v-icon left>mdi-content-save-check</v-icon>
                                Guardar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-container>
        </v-card>

        <v-dialog v-model="dialog_delete" max-width="320">
            <v-card>
                <div class="pa-3">
                    <h4 class="text-center my-3">Seguro de eliminar el registro?</h4>

                    <v-divider></v-divider>

                    <div class="d-flex justify-center mt-3">
                        <v-btn
                            color="red darken-1"
                            text
                            dense
                            @click="dialog_delete = false"
                        >
                            Cancelar
                        </v-btn>

                        <v-btn
                            color="green"
                            text
                            dense
                            @click="deleteInventario()"
                        >
                            Aceptar
                        </v-btn>
                    </div>
                </div>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import Layout from "@/Layouts/InventarioLayout";
import axios from "axios";

import { getBienByCodigo } from "@/Helpers/ConsultasHelper";

import AreasAsignadasComponent from "@/Pages/Inventario/Components/AreasAsignadasComponent.vue";
import BusquedaAvanzadaComponent from "@/Pages/Inventario/Components/BusquedaAvanzadaComponent.vue";
import SearchCodeComponente from "./Components/FormComponents/SearchCodeComponente.vue";
import ScannerBarComponent from "./Components/ScannerBarComponent.vue";
import SimpleAutoCompleteInput from "./Components/FormComponents/SimpleAutoCompleteInput.vue";

export default {
    components: {
        AreasAsignadasComponent,
        BusquedaAvanzadaComponent,
        SearchCodeComponente,
        ScannerBarComponent,
        SimpleAutoCompleteInput,
    },
    props: {
        estados: Array,
        mis_areas: Array,
        areas: Array,
        oficinas: Array,
    },
    layout: Layout,
    data: () => ({
        form_data: {},
        form_valid: true,
        loadin_form: false,
        disable_input: false,

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
    }),
    methods: {
        async Guardar() {
            console.log(this.form_data);
            if (this.$refs.form.validate()) {
                this.loadin_form = true;
                if (this.data_emit.registrado && this.is_edit) {
                    await this.updateInventario();
                } else {
                    await this.createInventario();
                }
                this.resetAll();
                this.loadin_form = false;
            }
        },

        async createInventario() {
            let res = await axios.post(
                "/inventario/create-inventario",
                this.form_data
            );
            console.log(res.data);
        },
        async updateInventario() {
            let res = await axios.post(
                "/inventario/update-inventario",
                this.form_data
            );
            console.log(res.data);
        },

        async deleteInventario() {
            
            this.loadin_form = true;
            let res = await axios.post(
                "/inventario/delete-inventario",
                this.form_data
            );
            console.log(res.data);
            this.resetAll();
            this.dialog_delete = false;
            this.loadin_form = false;
        },

        async BuscarPersonas(term) {
            let res = await axios.get("/inventario/search-personas/" + term);
            return res.data.datos;
        },

        personasFilter(item, queryText, itemText) {
            const nombres = item.nombres.toLowerCase();
            //const paterno = item.paterno.toLowerCase();
            //const materno = item.materno.toLowerCase();
            const dni = item.dni.toLowerCase();

            const searchText = queryText.toLowerCase();

            return (
                nombres.indexOf(searchText) > -1 ||
                //paterno.indexOf(searchText) > -1 ||
                //materno.indexOf(searchText) > -1 ||
                dni.indexOf(searchText) > -1
            );
        },

        resetAll() {
            this.form_data = {};
            this.$refs.form.reset();
            this.is_edit = false;
            this.data_emit = false;
        },

        async getDataBien(item) {
            let res = await getBienByCodigo(item);
            this.form_data = res;
            this.personas = [res.persona];
            this.personas_otro = [res.persona_otro];
        },

        editInventario(val) {
            this.is_edit = val;
            this.disable_input = !val;
        },
    },

    watch: {
        async data_emit(item) {
            if (!item) return;

            this.loadin_form = true;
            await this.getDataBien(item);
            this.disable_input = item.registrado;
            this.loadin_form = false;
        },
        is_new() {
            this.resetAll();
        },

        async personas_search(val) {
            if (!val) return;
            if (val.length < 2) return;
            this.loading_search_persona = true;
            let res = await this.BuscarPersonas(val);
            this.personas = res;
            this.loading_search_persona = false;
        },

        async personas_search_otro(val) {
            if (!val) return;
            if (val.length < 2) return;
            this.loading_search_persona_otro = true;
            let res = await this.BuscarPersonas(val);
            this.personas_otro = res;
            this.loading_search_persona_otro = false;
        },

        "form_data.id_oficina": function (val) {
            console.log("aquiiiiii");
            this.areas_by_oficina = this.areas.filter(
                (e) => e.id_oficina === val
            );
        },
    },
};
</script>
