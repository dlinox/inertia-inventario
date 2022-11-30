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
                    <v-col cols="12" class="py-2 py-md-3">
                        <strong> REGISTRO DE INVENTARIOS</strong>
                    </v-col>

                    <v-col
                        cols="12"
                        sm="auto"
                        class="py-2 py-md-3 d-flex py-2 py-md-3"
                    >
                        <RegistrosComponent
                            v-if="!is_new"
                            @setData="data_emit = $event"
                        />
                    </v-col>

                    <v-col
                        cols="12"
                        sm="auto"
                        class="d-flex ml-auto py-2 py-md-3"
                    >
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
                            <template
                                v-if="data_emit.registrado && !form_data.estado"
                            >
                                <v-alert
                                    border="left"
                                    color="blue-grey lighten-3"
                                >
                                    Elemento bloqueado, no se puede hacer
                                    modificaiones.
                                </v-alert>
                            </template>

                            <template v-else>
                                <v-alert
                                    v-if="data_emit.registrado"
                                    type="warning"
                                    border="left"
                                    color="blue-grey lighten-3"
                                >
                                    <small>
                                        <b>
                                            El elemento ya se encuentra
                                            registrado.
                                        </b>
                                    </small>

                                    <v-divider class="my-3"> </v-divider>

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
                                            color="secondary"
                                            @click="editInventario(true)"
                                        >
                                            Editar
                                        </v-btn>

                                        <v-btn
                                            color="dark"
                                            @click="
                                                dialog_delete = !dialog_delete
                                            "
                                        >
                                            Eliminar
                                        </v-btn>
                                    </template>
                                </v-alert>
                            </template>
                        </v-col>

                        <v-col cols="12" sm="4" md="4" class="pb-1 pt-0">
                            <v-text-field
                                class="mt-0 pt-0"
                                dense
                                label="Codigo"
                                outlined
                                v-model="form_data.codigo"
                                :disabled="!is_new"
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
                                :disabled="!is_new"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                            <v-text-field
                                class="mt-0 pt-0"
                                dense
                                label="Serie"
                                outlined
                                v-model="form_data.nro_serie"
                                :disabled="!is_new"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                            <v-text-field
                                class="mt-0 pt-0"
                                dense
                                label="Color"
                                outlined
                                v-model="form_data.color"
                                :disabled="disable_input"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                            <v-text-field
                                class="mt-0 pt-0"
                                dense
                                label="Medidas"
                                outlined
                                persistent-hint
                                hint="Largo x Ancho x Alto"
                                v-model="form_data.medidas"
                                :disabled="disable_input"
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
                            <SelectOficina
                                :disabled="disable_input"
                                :user="user.id"
                                v-model="form_data.id_oficina"
                                :rules="nameRules"
                            />
                        </v-col>

                        <v-col cols="6" class="pb-1 pt-0">
                            <v-combobox
                                v-model="form_data.estado_uso"
                                :items="estados_uso"
                                label="Estado de uso"
                                :disabled="disable_input"
                                outlined
                                dense
                            ></v-combobox>

                        </v-col>

                        <v-col cols="6" class="pb-1 pt-0">
                            <v-text-field
                                class="mt-0 pt-0"
                                dense
                                label="N° Ambiente"
                                outlined
                                v-model="form_data.num_ambiente"
                                :disabled="disable_input"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" class="pb-1 pt-0">
                            <v-textarea
                                :disabled="disable_input"
                                class="mt-0 pt-0"
                                label="Observación"
                                dense
                                outlined
                                rows="2"
                                v-model="form_data.observaciones"
                            ></v-textarea>
                        </v-col>

                        <v-col v-if="file_foto" cols="12" class="pb-1 pt-0">
                            <v-file-input
                                label="Foto referencial"
                                accept="image/png, image/jpeg, image/bmp"
                                v-model="foto_ref"
                                :disabled="disable_input"
                                dense
                                outlined
                                counter
                                show-size
                            ></v-file-input>
                        </v-col>

                        <v-col
                            v-if="form_data.foto_ref"
                            cols="12"
                            class="pb-1 pt-0"
                        >
                            <v-img
                                :src="form_data.foto_ref"
                                height="250"
                                contain
                                class="grey darken-4"
                            ></v-img
                        ></v-col>

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
                    <h4 class="text-center my-3">
                        Seguro de eliminar el registro?
                    </h4>

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
        <AlertComponent
            :show_alert="show_alert"
            :msg_alert="msg_alert"
            :type_alert="type_alert"
            @setAlert="show_alert = $event"
        />

        <v-dialog persistent v-model="dialog_corr" max-width="320">
            <v-card>
                <div class="pa-3">
                    <h4 class="text-center my-3">ETIQUETA: INVENTARIO</h4>
                    <v-divider></v-divider>
                    <h1 class="text-center my-3">
                        {{ corr_area }} - {{ corr_num }}
                    </h1>

                    <v-divider></v-divider>

                    <div class="d-flex justify-center mt-3">
                        <v-btn
                            color="primary"
                            dense
                            @click="dialog_corr = !dialog_corr"
                        >
                            Aceptar
                        </v-btn>
                    </div>
                </div>
            </v-card>
        </v-dialog>

        <v-fab-transition>
            <v-btn
                small
                dark
                absolute
                top
                left
                fab
                @click="file_foto = !file_foto"
            >
                <template v-if="file_foto">
                    <v-icon small>mdi-camera</v-icon>
                </template>
                <template v-else>
                    <v-icon small color="red lighten-3">mdi-camera-off</v-icon>
                </template>
            </v-btn>
        </v-fab-transition>
    </div>
</template>

<script>
import Layout from "@/Layouts/InventarioLayout";
import axios from "axios";

import { getBienByCodigo } from "@/Helpers/ConsultasHelper";

import AreasAsignadasComponent from "@/Pages/Inventario/Components/AreasAsignadasComponent.vue";
import RegistrosComponent from "@/Pages/Inventario/Components/RegistrosComponent.vue";
import BusquedaAvanzadaComponent from "@/Pages/Inventario/Components/BusquedaAvanzadaComponent.vue";
import SearchCodeComponente from "./Components/FormComponents/SearchCodeComponente.vue";
import ScannerBarComponent from "./Components/ScannerBarComponent.vue";
import SimpleAutoCompleteInput from "./Components/FormComponents/SimpleAutoCompleteInput.vue";
import AlertComponent from "./Components/AlertComponent.vue";
import SelectOficina from "../../components/autocomplete/SelectOficina.vue";

export default {
    components: {
        AreasAsignadasComponent,
        BusquedaAvanzadaComponent,
        SearchCodeComponente,
        ScannerBarComponent,
        SimpleAutoCompleteInput,
        AlertComponent,
        SelectOficina,
        RegistrosComponent,
    },
    props: {
        estados: Array,
        mis_areas: Array,
        areas: Array,
    },
    layout: Layout,
    data: () => ({
        estados_uso: ["EN USO", "ALMACENADO", "EMPAQUETADO"],
        file_foto: false,
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
    methods: {
        setDataAlert(response) {
            this.msg_alert = response.mensaje;
            this.type_alert = response.estado ? "success" : "red";
            this.show_alert = true;
        },
        async guardarFoto(id) {
            const formData = new FormData();
            formData.append("foto", this.foto_ref);
            formData.append("id", id);
            let res = await axios.post("/inventario/save-foto", formData);
        },

        async Guardar() {
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
            if (res.data.estado && this.file_foto) {
                await this.guardarFoto(res.data.id);
            }

            this.shwModalCorrelativo(res.data);

            this.setDataAlert(res.data);
        },
        async updateInventario() {
            let res = await axios.post(
                "/inventario/update-inventario",
                this.form_data
            );
            if (res.data.estado && this.file_foto) {
                let res_foto = await this.guardarFoto(res.data.id);
            }
            this.setDataAlert(res.data);
        },

        shwModalCorrelativo(data) {
            this.corr_num = data.corr_num;
            this.corr_area = data.corr_area;
            this.dialog_corr = true;
        },

        async deleteInventario() {
            this.loadin_form = true;
            let res = await axios.post(
                "/inventario/delete-inventario",
                this.form_data
            );

            this.setDataAlert(res.data);
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
            this.foto_ref = null;
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
            if (!this.mis_areas_id.includes(val)) {
                this.form_data.id_oficina = null;
            }
            this.areas_by_oficina = this.areas.filter(
                (e) => e.id_oficina === val
            );
        },
    },

    computed: {
        user() {
            return this.$page.props.auth.user;
        },
    },
};
</script>
