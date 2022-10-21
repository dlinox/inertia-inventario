<template>
    <v-container class="my-3">
        <v-card
            :loading="loadin_form"
            :disabled="loadin_form"
            class="mx-auto"
            max-width="850"
        >
            <v-row class="pa-4" align="center">
                <v-col cols="12" sm="7" md="8" class="py-1 py-md-2">
                    <div class="text-h6">Registar</div>
                </v-col>
                <v-col cols="12" sm="auto" class="ml-auto py-1 py-md-2">
                    <AreasAsignadasComponent
                        @setData="data_emit = $event"
                        :areas="mis_areas"
                    />
                </v-col>
                <v-col cols="12">
                    <div
                        class="d-flex flex-wrap align-items-center justify-space-between"
                    >
                        <template v-if="!is_nuevo">
                            <v-btn
                                class="mr-sm-2 order-sm-1 mb-2 mb-sm-0"
                                dark
                                color="primary"
                                @click="dialog_scanner = !dialog_scanner"
                            >
                                <v-icon>mdi-barcode-scan</v-icon>
                            </v-btn>

                            <v-autocomplete
                                v-model="codigo_search"
                                clearable
                                class="order-last order-sm-2"
                                dense
                                label="Buscar Codigo"
                                outlined
                                :items="codigos_res"
                                item-text="codigo"
                                item-value="id"
                                :search-input.sync="codigos_search"
                                :loading="codigos_search_loading"
                            >
                                <template v-slot:no-data>
                                    <v-list-item>
                                        <v-list-item-title>
                                            <template
                                                v-if="
                                                    codigos_search?.length > 2
                                                "
                                            >
                                                Sin resultados para
                                                <strong>
                                                    "{{ codigos_search }}"
                                                </strong>
                                            </template>
                                            <template v-else>
                                                Digite más de
                                                <strong> 3 </strong> caracteres.
                                            </template>
                                        </v-list-item-title>
                                    </v-list-item>
                                </template>

                                <template v-slot:item="data">
                                    <v-list-item-content
                                        @click="LLenarDatos(data.item)"
                                    >
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

                            <BusquedaAvanzadaComponent
                                @setData="data_emit = $event"
                            />

                            <v-btn
                                class="order-sm-4"
                                dark
                                outlined
                                color="primary"
                                @click="is_nuevo = true"
                            >
                                <v-icon>mdi-plus</v-icon>
                            </v-btn>
                        </template>

                        <template v-else>
                            <v-btn
                                class="mr-sm-2 order-sm-1 mb-2 mb-sm-0"
                                dark
                                color="red"
                                @click="CancelarEdicion()"
                            >
                                <v-icon left>mdi-close</v-icon>
                                Cancelar
                            </v-btn>
                        </template>
                    </div>
                </v-col>
            </v-row>

            <v-form ref="form" v-model="valid" lazy-validation>
                <v-row class="px-4 pb-4" align="center">
                    <v-col cols="12" class="pb-4 pt-0">
                        <v-alert
                            v-if="registrado && activo"
                            outlined
                            type="warning"
                            prominent
                            border="left"
                        >
                            <v-row align="center">
                                <v-col class="grow">
                                    <p>
                                        El elemento ya se encuentra registrado.
                                        Haga click en editar ver el resitro y
                                        cambiar los datos
                                    </p>
                                </v-col>
                                <v-col class="shrink">
                                    <template v-if="is_edit">
                                        <v-btn
                                            color="secondary"
                                            @click="CancelarEdicion()"
                                        >
                                            Cancelar
                                        </v-btn>
                                    </template>

                                    <template v-else>
                                        <v-btn
                                            color="warning"
                                            @click="
                                                getInventario(
                                                    data.id_inventario
                                                )
                                            "
                                        >
                                            Editar
                                        </v-btn>
                                    </template>
                                </v-col>
                            </v-row>
                        </v-alert>

                        <v-alert
                            v-if="!activo && registrado"
                            type="warning"
                            border="left"
                            color="blue-grey"
                        >
                            Elemento bloqueado, no se puede hacer modificaiones.
                        </v-alert>
                    </v-col>

                    <v-col cols="12" sm="4" md="4" class="pb-1 pt-0">
                        <v-text-field
                            class="mt-0 pt-0"
                            dense
                            label="Codigo"
                            outlined
                            v-model="data.codigo"
                            :rules="nameRules"
                            :disabled="!is_nuevo"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="8" md="8" class="pb-1 pt-0">
                        <v-text-field
                            class="mt-0 pt-0"
                            dense
                            label="Nombre"
                            outlined
                            v-model="data.nombre"
                            :rules="nameRules"
                            :disabled="!is_nuevo"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                        <v-text-field
                            class="mt-0 pt-0"
                            dense
                            label="Marca"
                            outlined
                            v-model="data.marca"
                            :disabled="!is_nuevo"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                        <v-text-field
                            class="mt-0 pt-0"
                            dense
                            label="Modelo"
                            outlined
                            v-model="data.modelo"
                            :rules="nameRules"
                            :disabled="!is_nuevo"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6" sm="4" md="4" class="pb-1 pt-0">
                        <v-text-field
                            class="mt-0 pt-0"
                            dense
                            label="Serie"
                            outlined
                            v-model="data.serie"
                            :rules="nameRules"
                            :disabled="!is_nuevo"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="6" sm="4" md="4" class="pb-1 pt-0">
                        <v-text-field
                            class="mt-0 pt-0"
                            dense
                            label="Numero"
                            outlined
                            v-model="data.numero"
                            :rules="nameRules"
                            :disabled="!is_nuevo"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4" md="4" class="pb-1 pt-0">
                        <v-autocomplete
                            clearable
                            class="mt-0 pt-0"
                            dense
                            label="Estado"
                            outlined
                            :items="estados"
                            item-text="nombre"
                            item-value="id"
                            v-model="data.id_estado"
                            :rules="nameRules"
                            required
                            :disabled="editar_registrado"
                        ></v-autocomplete>
                    </v-col>
                    <v-col cols="12" class="pb-1 pt-0 d-flex">
                        <v-autocomplete
                            v-model="data.id_persona"
                            clearable
                            class="mt-0 pt-0"
                            dense
                            label="Responsable"
                            outlined
                            :items="personas_res"
                            :filter="customFilter"
                            item-value="id"
                            :search-input.sync="personas_search"
                            :loading="loading_search_persona"
                            :rules="nameRules"
                            required
                            :disabled="editar_registrado"
                        >
                            <template v-slot:no-data>
                                <v-list-item>
                                    <v-list-item-title>
                                        <template
                                            v-if="personas_search?.length > 2"
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

                        <template v-if="!respo_2 && !data.idpersona_otro">
                            <v-btn
                                :disabled="editar_registrado"
                                class="ml-2"
                                dark
                                color="primary"
                                @click="respo_2 = !respo_2"
                            >
                                <v-icon>mdi-account-plus</v-icon>
                            </v-btn>
                        </template>
                    </v-col>

                    <v-col
                        v-if="respo_2 || data.idpersona_otro"
                        cols="12"
                        class="pb-1 pt-0 d-flex"
                    >
                        <v-autocomplete
                            v-model="data.idpersona_otro"
                            clearable
                            class="mt-0 pt-0"
                            dense
                            label="2° Responsable"
                            outlined
                            :items="personas_res_otro"
                            :filter="customFilter"
                            item-value="id"
                            :search-input.sync="personas_search_otro"
                            :loading="loading_search_persona_otro"
                            :rules="nameRules"
                            required
                            :disabled="editar_registrado"
                        >
                            <template v-slot:no-data>
                                <v-list-item>
                                    <v-list-item-title>
                                        <template
                                            v-if="personas_search?.length > 2"
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

                        <v-btn
                            class="ml-2"
                            dark
                            color="red"
                            @click="respo_2 = !respo_2"
                        >
                            <v-icon>mdi-account-minus</v-icon>
                        </v-btn>
                    </v-col>
                    <v-col cols="12" class="pb-1 pt-0">
                        <v-autocomplete
                            :disabled="editar_registrado"
                            v-model="data.id_oficina"
                            clearable
                            class="mt-0 pt-0"
                            dense
                            label="Oficina"
                            outlined
                            :items="oficinas_res"
                            :filter="customFilterOficina"
                            item-value="id"
                            :search-input.sync="oficinas_search"
                            :loading="oficinas_search_loading"
                            :rules="nameRules"
                            required
                        >
                            <template v-slot:no-data>
                                <v-list-item>
                                    <v-list-item-title>
                                        <template
                                            v-if="personas_search?.length > 2"
                                        >
                                            Datos no encontrados para
                                            <strong>
                                                {{ oficinas_search }}
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
                            :disabled="editar_registrado"
                            clearable
                            class="mt-0 pt-0"
                            dense
                            label="Area"
                            outlined
                            :items="areas_by_oficna"
                            item-text="nombre"
                            item-value="id"
                            v-model="data.id_area"
                            :rules="nameRules"
                            required
                        ></v-autocomplete>
                    </v-col>
                    <v-col cols="12" class="pb-1 pt-0">
                        <v-textarea
                            :disabled="editar_registrado"
                            class="mt-0 pt-0"
                            label="Observacion"
                            dense
                            outlined
                            rows="2"
                            v-model="data.observaciones"
                            :rules="nameRules"
                            required
                        ></v-textarea>
                    </v-col>
                    <v-col cols="12" class="pb-1 pt-0">
                        <v-btn
                            :disabled="editar_registrado"
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
        </v-card>

        <v-dialog v-model="dialog_scanner" width="500">
            <v-card>
                <v-card-title class="text-h5 grey lighten-2">
                    Scannear codigo de barras
                </v-card-title>

                <v-card-text>
                    <StreamBarcodeReader
                        v-if="dialog_scanner"
                        @decode="onDecode"
                        @loaded="onLoaded"
                    ></StreamBarcodeReader>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red" text @click="dialog_scanner = false">
                        Cerrar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- -->
    </v-container>
</template>

<script>
import { StreamBarcodeReader } from "vue-barcode-reader";

import AreasAsignadasComponent from "@/Pages/Inventario/Components/AreasAsignadasComponent.vue";
import BusquedaAvanzadaComponent from "@/Pages/Inventario/Components/BusquedaAvanzadaComponent.vue";
import Layout from "@/Layouts/InventarioLayout";
import axios from "axios";
import { data } from "browserslist";

export default {
    components: {
        AreasAsignadasComponent,
        BusquedaAvanzadaComponent,
        StreamBarcodeReader,
    },
    props: {
        estados: Array,
        mis_areas: Array,
    },
    layout: Layout,
    data: () => ({
        dialog_scanner: false,
        is_nuevo: false,
        is_edit: false,

        loadin_form: false,
        valid: true,
        loading_search_persona: false,
        respo_2: false,

        data: {},

        data_emit: {},

        personas_res: [],
        personas_search: "",

        personas_res_otro: [],
        personas_search_otro: "",
        loading_search_persona_otro: false,

        oficinas_res: [],
        oficinas_search: "",
        oficinas_search_loading: false,

        areas_by_oficna: [],

        codigo_search: "",
        codigos_res: [],
        codigos_search: "",
        codigos_search_loading: false,

        nameRules: [(v) => !!v || "*Obligatorio"],

        registrado: false,
        activo: null,

        editar_registrado: false,
    }),
    methods: {
        async onDecode(result) {
            console.log(result);

            let res = await axios.post("/inventario/getbienbycodigo", {
                codigo: result,
            });
            console.log(res.data.estado);

            if (res.data.estado) {
                this.LLenarDatos(res.data.datos);

                this.dialog_scanner = false;
                //data_bien.value = res.data.datos;
            } else {
                console.log(error);
            }
        },

        onLoaded() {
            console.log("funciona ptm funcionaaa");
        },
        async Guardar() {
            if (this.$refs.form.validate()) {
                let res = await axios.post(
                    "/inventario/guardar-inventario",
                    this.data
                );
                console.log(res.data);

                this.$refs.form.reset();
            }
        },

        async getInventario(id) {
            let res = await axios.get("/inventario/get-inventario/" + id);

            //this.data.id_inventario = id;

            this.activo =
                res.data.datos.estado != null
                    ? res.data.datos.estado == 0
                        ? false
                        : true
                    : null;

            await this.LLenarDatos(res.data.datos);
            this.data.id_inventario = id;
            this.is_edit = true;
        },
        async BuscarPersonas(term) {
            let res = await axios.get("/inventario/search-personas/" + term);
            return res.data.datos;
        },

        async BuscarOficinas(term) {
            let res = await axios.get("/inventario/search-oficinas/" + term);
            return res.data.datos;
        },

        async BuscarCodigos(codigo) {
            let res = await axios.get("/inventario/search-codigos/" + codigo);
            return res.data.datos;
        },

        CancelarEdicion() {
            this.is_edit = false;
            this.editar_registrado = true;

            console.log("awuiiiii");
            // this.resetAll();
        },

        async LLenarDatos(item) {
            let res = await axios.get(
                "/inventario/search-personas-by-id/" + item.id_persona
            );

            this.personas_res = res.data.datos;

            if (item.idpersona_otro) {
                let res = await axios.get(
                    "/inventario/search-personas-by-id/" + item.idpersona_otro
                );
                this.personas_res_otro = res.data.datos;
            }

            let oficna = await axios.get(
                "/inventario/search-oficina-by-id/" + item.id_oficina
            );

            this.oficinas_res.push(oficna.data.datos);

            this.data = item;

            console.log("aqui: " + item.id_inventario);

            if (item.id_inventario != null) {
                console.log("ya esta registrado");
                this.editar_registrado = true;
            } else {
                console.log("es nuevo");
                this.editar_registrado = false;
            }
        },

        customFilter(item, queryText, itemText) {
            const nombres = item.nombres.toLowerCase();
            const paterno = item.paterno.toLowerCase();
            const materno = item.materno.toLowerCase();
            const dni = item.dni.toLowerCase();

            const searchText = queryText.toLowerCase();

            return (
                nombres.indexOf(searchText) > -1 ||
                paterno.indexOf(searchText) > -1 ||
                dni.indexOf(searchText) > -1 ||
                materno.indexOf(searchText) > -1
            );
        },
        customFilterOficina(item, queryText, itemText) {
            const nombre = item.nombre.toLowerCase();
            const codigo = item.codigo.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                nombre.indexOf(searchText) > -1 ||
                codigo.indexOf(searchText) > -1
            );
        },
        resetAll() {
            this.registrado = false;
            this.activo = null;
            this.editar_registrado = false;
            this.is_edit = false;
            this.data = {};
            this.codigo_search = "";
        },
    },

    watch: {
        async data_emit(val) {
            this.loadin_form = true;
            this.registrado = val.id_inventario ? true : false;
            this.activo =
                val.estado != null ? (val.estado == 0 ? false : true) : null;
            await this.LLenarDatos(val);
            this.loadin_form = false;
        },

        async personas_search(val) {
            if (!val) return;
            if (val.length < 2) return;
            this.loading_search_persona = true;
            let res = await this.BuscarPersonas(val);
            this.personas_res = res;
            this.loading_search_persona = false;
        },

        async personas_search_otro(val) {
            if (!val) return;
            if (val.length < 2) return;
            this.loading_search_persona_otro = true;
            let res = await this.BuscarPersonas(val);
            this.personas_res_otro = res;
            this.loading_search_persona_otro = false;
        },

        async oficinas_search(val) {
            if (!val) return;
            if (val.length < 2) return;
            this.oficinas_search_loading = true;
            let res = await this.BuscarOficinas(val);
            this.oficinas_res = res;
            this.oficinas_search_loading = false;
        },

        async codigos_search(val) {
            if (!val) return;
            if (val.length < 3) return;
            this.codigos_search_loading = true;
            let res = await this.BuscarCodigos(val);
            this.codigos_res = res;
            this.codigos_search_loading = false;
        },

        "data.id_oficina": async function (val) {
            console.log(val);
            let res = await axios.get("/inventario/search-areas/" + val);

            this.areas_by_oficna = res.data.datos;
        },

        is_nuevo() {
            console.log("es nuevo");
            this.registrado = false;
            this.activo = null;
            this.editar_registrado = false;
            this.data = {};
            this.codigo_search = "";
            this.$refs.form.reset();
        },
    },
};
</script>
