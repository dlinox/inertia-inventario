<template>
    <v-card :loading="loadin_form" :disabled="loadin_form" class="mx-auto mt-2 bg-transparent" min-height="90vh"
        max-width="850" tile>
        <v-overlay absolute :value="loadin_form">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>

        <v-container>
            <v-row class="" align="center" no-gutters>
                <v-col cols="12" class="py-2 py-md-3">
                    <strong> REGISTRO DE INVENTARIOS POR LOTE</strong>
                </v-col>
                <v-col cols="12" sm="auto" class="d-flex ml-auto py-2 py-md-3">
                    <AreasAsignadasLotesComponent :areas="mis_areas" @setData="data_emit = $event" />

                </v-col>

                <v-col cols="12 my-4">

                    <v-form ref="form" v-model="form_valid" lazy-validation>

                        <v-row>

                            <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                                <v-text-field class="mt-0 pt-0" dense label="Color" outlined v-model="form_data.color"
                                    :disabled="disable_input"></v-text-field>
                            </v-col>

                            <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                                <v-text-field class="mt-0 pt-0" dense label="Medidas" outlined persistent-hint
                                    hint="Largo x Ancho x Alto" v-model="form_data.medidas"
                                    :disabled="disable_input"></v-text-field>
                            </v-col>

                            <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                                <SimpleAutoCompleteInput v-model="form_data.id_estado" :items="estados" label="Estado"
                                    item_text="nombre" item_value="id" :rules="nameRules" :disabled="disable_input" />
                            </v-col>


                            <v-col cols="12" class="pb-1 pt-0 d-flex">
                                <v-autocomplete v-model="form_data.id_persona" clearable class="mt-0 pt-0" dense
                                    label="Responsable" outlined :items="personas" :filter="personasFilter"
                                    item-value="id" :search-input.sync="personas_search"
                                    :loading="loading_search_persona" :rules="nameRules" required
                                    :disabled="disable_input">
                                    <template v-slot:no-data>
                                        <v-list-item>
                                            <v-list-item-title>
                                                <template v-if="
                                                    personas_search?.length > 2
                                                ">
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
                                            <v-list-item-title v-html="data.item.dni">
                                            </v-list-item-title>
                                            <v-list-item-subtitle>
                                                {{ data.item.nombres }}
                                                {{ data.item.paterno }}
                                                {{ data.item.materno }}
                                            </v-list-item-subtitle>
                                        </v-list-item-content>
                                    </template>
                                </v-autocomplete>

                                <template v-if="
                                    !show_persona_otro &&
                                    !form_data.idpersona_otro
                                ">
                                    <v-btn :disabled="disable_input" class="ml-2" dark color="primary" @click="
                                        show_persona_otro = !show_persona_otro
                                    ">
                                        <v-icon>mdi-account-plus</v-icon>
                                    </v-btn>
                                </template>
                            </v-col>

                            <v-col v-if="show_persona_otro || form_data.idpersona_otro" cols="12"
                                class="pb-1 pt-0 d-flex">
                                <v-autocomplete v-model="form_data.idpersona_otro" clearable class="mt-0 pt-0" dense
                                    label="2° Responsable" outlined :items="personas_otro" :filter="personasFilter"
                                    item-value="id" :search-input.sync="personas_search_otro"
                                    :loading="loading_search_persona_otro" :rules="nameRules" required
                                    :disabled="disable_input">
                                    <template v-slot:no-data>
                                        <v-list-item>
                                            <v-list-item-title>
                                                <template v-if="
                                                    personas_search?.length > 2
                                                ">
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
                                            <v-list-item-title v-html="data.item.dni">
                                            </v-list-item-title>
                                            <v-list-item-subtitle>
                                                {{ data.item.nombres }}
                                                {{ data.item.paterno }}
                                                {{ data.item.materno }}
                                            </v-list-item-subtitle>
                                        </v-list-item-content>
                                    </template>
                                </v-autocomplete>

                                <v-btn class="ml-2" dark color="red" @click="show_persona_otro = !show_persona_otro"
                                    :disabled="disable_input">
                                    <v-icon dark>mdi-account-minus</v-icon>
                                </v-btn>
                            </v-col>

                            <v-col cols="12" class="pb-1 pt-0">
                                <SelectOficina :disabled="disable_input" :user="user.id" v-model="form_data.id_oficina"
                                    :rules="nameRules" />
                            </v-col>

                            <v-col cols="6" class="pb-1 pt-0">
                                <v-combobox v-model="form_data.estado_uso" :items="estados_uso" label="Situación"
                                    :disabled="disable_input" outlined dense :rules="nameRules"></v-combobox>
                            </v-col>

                            <v-col cols="6" class="pb-1 pt-0">
                                <v-text-field class="mt-0 pt-0" dense label="N° Ambiente" outlined
                                    v-model="form_data.num_ambiente" :disabled="disable_input"></v-text-field>
                            </v-col>

                            <v-col cols="12" class="pb-1 pt-0">
                                <v-textarea :disabled="disable_input" class="mt-0 pt-0" label="Observación" dense
                                    outlined rows="2" v-model="form_data.observaciones"></v-textarea>
                            </v-col>
                            <template v-if="data_emit.length > 0">
                                <v-col cols="12">

                                    <v-list three-line>
                                        <v-list-item three-line v-for="(item, index) in data_emit" :key="index">
                                            <v-list-item-content>
                                                <v-list-item-title>
                                                    <strong>{{ item.codigo }}</strong>
                                                </v-list-item-title>
                                                <v-list-item-subtitle>
                                                    <small> <strong> {{ item.descripcion }}</strong> </small>
                                                </v-list-item-subtitle>
                                                <v-list-item-subtitle>

                                                    <v-tooltip top color="primary">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <span v-bind="attrs" v-on="on">
                                                                <v-icon small>mdi-information</v-icon>
                                                            </span>
                                                        </template>
                                                        <span>
                                                            <small> Oficina-Responsable-Correlativo</small>
                                                        </span>
                                                    </v-tooltip>

                                                    {{ item.cod_ubicacion }}
                                                </v-list-item-subtitle>
                                            </v-list-item-content>

                                            <v-list-item-action>
                                                <v-btn icon small tile color="red" @click="EliminarItem(index)">
                                                    <v-icon>
                                                        mdi-close-box
                                                    </v-icon>
                                                </v-btn>
                                            </v-list-item-action>
                                        </v-list-item>


                                    </v-list>


                                </v-col>
                                <v-col cols="12" class="pb-3 pt-0">
                                    <v-alert icon="mdi-alert" prominent text type="info">
                                        <b>¡Importante!, </b> Al realizar un registro por lote asegúrese que no se hagan
                                        más registros simultáneamente en su misma área.

                                    </v-alert>
                                </v-col>
                                <v-col cols="12" class="pb-3 pt-0">
                                    <v-btn :disabled="!form_valid" block class="mr-2" color="primary" @click="Guardar">
                                        <v-icon left>mdi-content-save-check</v-icon>
                                        Guardar
                                    </v-btn>
                                </v-col>
                            </template>
                        </v-row>
                    </v-form>
                </v-col>
            </v-row>

        </v-container>

        <v-dialog persistent v-model="dialog_corr" max-width="420">
            <v-card>
                <div class="pa-3">
                    <h4 class="text-center my-3">ETIQUETAS: INVENTARIO</h4>
                    <v-divider></v-divider>

                    <v-list two-line>
                        <v-list-item two-line v-for="(item, index) in list_corr" :key="index">
                            <v-list-item-content>
                                <v-list-item-title>
                                    <small> Cod.: <strong>{{ item.codigo }}</strong></small>
                                </v-list-item-title>
                                <v-list-item-subtitle>

                                    <v-tooltip top color="primary">
                                        <template v-slot:activator="{ on, attrs }">
                                            <span v-bind="attrs" v-on="on">
                                                <v-icon small>mdi-information</v-icon>
                                            </span>
                                        </template>
                                        <span>
                                            <small> Oficina-Responsable-Correlativo</small>
                                        </span>
                                    </v-tooltip>
                                    <small>{{ item.cod_ubicacion }}</small>
                                </v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-action>
                                <v-btn small tile color="primary">
                                    <strong>{{ item.correlativo }}</strong>
                                </v-btn>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list>


                    <v-divider></v-divider>

                    <div class="d-flex justify-center mt-3">
                        <v-btn color="primary" dense @click=" $inertia.get('/inventario/lotes')" >
                            Aceptar
                        </v-btn>
                    </div>
                </div>
            </v-card>
        </v-dialog>

        <AlertComponent :show_alert="show_alert" :msg_alert="msg_alert" :type_alert="type_alert"
            @setAlert="show_alert = $event" />

    </v-card>
</template>

<script>
import Layout from "@/Layouts/InventarioLayout";
import axios from "axios";
import SelectOficina from "../../components/autocomplete/SelectOficina.vue";
import AlertComponent from "./Components/AlertComponent.vue";
import AreasAsignadasLotesComponent from "./Components/AreasAsignadasLotes.Component.vue";
import SimpleAutoCompleteInput from "./Components/FormComponents/SimpleAutoCompleteInput.vue";


export default {
    components: {
    AreasAsignadasLotesComponent,
    SimpleAutoCompleteInput,
    SelectOficina,
    AlertComponent
},
    props: {
        estados: Array,
        mis_areas: Array,
        areas: Array,
    },
    layout: Layout,
    data: () => ({
        form_data: {},

        estados_uso: ["EN USO", "ALMACENADO", "EMPAQUETADO"],
        form_valid: true,

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
        data_emit: [],

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

        list_corr: [],
    }),
    created() {
        this.mis_areas_id = this.mis_areas.map((area) => area.iduoper);
    },

    computed: {
        user() {
            return this.$page.props.auth.user;
        },
    },

    methods: {
        EliminarItem(index) {
            this.data_emit.splice(index, 1);
        },
        setDataAlert(response) {
            this.msg_alert = response.mensaje;
            this.type_alert = response.estado ? "success" : "red";
            this.show_alert = true;
        },

        async Guardar() {
            if (this.$refs.form.validate()) {
                this.loadin_form = true;

                this.form_data.bienes = this.data_emit;
                let res = await axios.post('/inventario/guardar-lote', this.form_data);

                if (res.data.estado) {
                    this.shwModalCorrelativo(res.data);
                    this.resetAll();
                }

                this.setDataAlert(res.data);

                

                this.loadin_form = false;
            }
        },


        shwModalCorrelativo(data) {

            this.list_corr = data.correlativos;
            this.dialog_corr = true;
        },


        async BuscarPersonas(term) {
            let res = await axios.get("/inventario/search-personas/" + term);
            return res.data.datos;
        },

        personasFilter(item, queryText, itemText) {

            const nombres = item.nombres.toLowerCase();
            const paterno = item.paterno?.toLowerCase();
            const materno = item.materno?.toLowerCase();
            const dni = item.dni.toLowerCase();

            const searchText = queryText.toLowerCase();

            return (
                nombres.indexOf(searchText) > -1 ||
                paterno.indexOf(searchText) > -1 ||
                materno.indexOf(searchText) > -1 ||
                dni.indexOf(searchText) > -1
            );
        },

        resetAll() {
            this.resetForm();
            this.data_emit = false;
        },
        resetForm() {
            this.form_data = {};
            this.$refs.form.reset();
            this.is_edit = false;
            this.foto_ref = null;
            this.disable_input_new = false;
            this.disable_input = false;
        },
    },

    watch: {


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
};
</script>
