<template>
    <div class="wrapper-page">
        <div class="content-wrapper">

            <div class="content full"> 
                <v-container>
                <v-dialog
                    v-model="dialog"
                    width="900px"
                    >
                    <v-card>
                        <v-card-title class="primary">
                            <h4 style="color: white;">Agregar Oficina </h4>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>

                            <v-form ref="form_ofic" v-model="form_valid" lazy-validation>
                                <v-row class="mt-5">
                                    <v-col cols="12" sm="6" md="2" class="pb-0 ">
                                        <h4 class="pb-0 grey--text text--darken-2">
                                            Cod U. Operativa
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

                                        <v-autocomplete
                                            v-model="form.dependencia"
                                            clearable
                                            dense
                                            outlined
                                            :items="dependencias"
                                            :filter="customFilterDEP"
                                            item-value="dependencia"
                                            item-text="dependencia"
                                            :search-input.sync="oficinas_search"
                                            required
                                        >
                                            <template v-slot:no-data>
                                                <v-list-item>
                                                    <v-list-item-title>
                                                        <template>
                                                            No hay registros
                                                        </template>
                                                    </v-list-item-title>
                                                </v-list-item>
                                            </template>
                                    
                                            <template v-slot:item="data">
                                                <v-list-item-content>
                                                    <v-list-item-title v-html="data.item.iduoper">
                                                    </v-list-item-title>
                                                    <v-list-item-subtitle>
                                                        {{ data.item.dependencia }}
                                                    </v-list-item-subtitle>
                                                </v-list-item-content>
                                            </template>
                                        </v-autocomplete>
                                        <!-- <v-text-field v-model="form.dependencia" required dense outlined
                                            :rules="obligatorioRules"></v-text-field> -->
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
                </v-dialog>
                
                    <v-card class="mt-3">
                        <v-card-title>
                            <h4>Lista de oficinas</h4>
                            <v-divider></v-divider>
                            <v-btn class="success" @click="dialog = true;">Nuevo</v-btn>
                        </v-card-title>

                        <v-card-text>
                            <div>
                                <v-divider></v-divider>
                                <div class="mt-2 d-flex" style="justify-content: flex-end">
                                    <v-text-field
                                        v-model="dep"
                                        outlined
                                        clearable
                                        label="Cod. Dep"
                                        style="max-width: 80px;"
                                        dense
                                        hide-details
                                        >
                                    </v-text-field>
                                    <v-text-field
                                        class="ml-2"
                                        v-model="buscaroficina"
                                        style="calc(100% - 90px)"
                                        append-icon="mdi-magnify"
                                        outlined
                                        dense
                                        hide-details
                                        >
                                    </v-text-field>
                                </div>
                            </div>

                            <v-simple-table>
                                <template v-slot:default>
                                <thead>
                                    <tr>
                                    <th class="text-left">
                                        Cod U. Operativa
                                    </th>
                                    <th class="text-left">
                                        Nombre
                                    </th>
                                    <th class="text-left">
                                        Dependencia
                                    </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                    v-for="item in oficinas"
                                    :key="item.iduoper"
                                    >
                                    <td>{{ item.iduoper }}</td>
                                    <td>{{ item.nombre }}</td>
                                    <td>{{ item.dependencia }}</td>
                                    </tr>
                                </tbody>
                                </template>
                            </v-simple-table>
                            <div v-if="oficinas.length" v-observe-visibility="handleScrolledToBottom"></div>
                        </v-card-text>

                    </v-card>
                </v-container>
            </div>

            
        </div>
    </div>
</template> 
<script>
import Layout from "@/Layouts/FacilitadorLayout";
import axios from "axios";

export default {
    metaInfo: { title: "Usuarios" },
    layout: Layout,
    props: {
        roles: Array,
    },

    data: () => ({

        loading_table: false,
        form_valid: null,

        dependencias:[],
        oficinas_search:"",

        form: {
            iduoper: null,
            nombre: null,
            dependencia: "",
        },

        obligatorioRules: [(v) => !!v || "*Obligatorio"],
        absolute: false,
        drawer: true,

        dialog:false,   
        dep:'01',
        page:1,
        oficinas:[],
        buscaroficina:"",

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
    mounted() {
          this.getDependencias()
          this.getOficinas()
        },
    methods: {
        async getDependencias(){
            let res = await axios.get("/facilitador/getDependencias");
            this.dependencias = res.data.datos;
            return res.data.datos.data;
        },
        async Guardar() {
            if (this.$refs.form_ofic.validate()) {
                let res = await axios.post(
                    "/facilitador/oficina",
                    this.form
                );
                // console.log(res.data);
                if (res.data.estado) {
                    this.$refs.form_ofic.reset();
                    this.limpiar()
                }
            }
//            console.log(this.form);
            this.dialog = false;
            this.getOficinas()
        },

        customFilterDEP(item, queryText, itemText) {
            const dependencia = item.dependencia.toLowerCase();
            const iduoper = item.iduoper.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                dependencia.indexOf(searchText) > -1 ||
                iduoper.indexOf(searchText) > -1
             );
        },

        async getOficinas(term = "", page = 1) {
            let res = await axios.post(
                "/facilitador/oficina/get-ofi-all?page=" + page,
                { term: this.buscaroficina, dependencia: this.dep}
            );
            this.oficinas = res.data.datos.data;
        },
        async getOficinasS( page = 1) {
            let res = await axios.post(
                "/facilitador/oficina/get-ofi-all?page=" + this.page,
                { term: this.buscaroficina, dependencia: this.dep}
            );
            this.oficinas.push(...res.data.datos.data);
        },
        handleScrolledToBottom(isVisible){
            if(!isVisible){ return}        
            this.page++;
            this.getOficinasS()
        },
        limpiar(){
            this.form = null;
        },

    },
    watch:{

        async dep(){
            this.page = 1;
            this.bienesAF = [];
            this.getOficinas()
        },
        async buscaroficina(val) {
            this.bienesAF = [];
            await this.getOficinas(val);            
        },

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
