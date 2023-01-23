<template>
    <v-container>
        <v-card :loading="loading" class="mx-auto my-2">
            <v-card-title>Faltantes</v-card-title>

            <v-row class="mx-3">
                <v-col cols="12" class="pb-0">
                    <v-autocomplete v-model="dep" clearable dense label="Dependencia" outlined :items="dependencias"
                        :filter="customFilterDEP" item-value="iduoper" item-text="dependencia" required hide-details>
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
                </v-col>
                <v-col cols="12" class="mb-0 pb-0">

                    <span class="text-subtitle-2 mb-2">
                        Seleccione los tipo de bien
                    </span>

                    <div class="d-flex justify-content-around flex-wrap">
                        <v-switch v-model="tipos.activo_fijo" inset class="mr-6" disabled>
                            <template #label>
                                <span :class="tipos.activo_fijo ? 'primary--text font-weight-bold' : 'blue-grey--text'">
                                    Activo fijo
                                </span>
                            </template>
                        </v-switch>

                        <v-switch v-model="tipos.no_depreciable" inset class="mr-6">
                            <template #label>
                                <span
                                    :class="tipos.no_depreciable ? 'primary--text font-weight-bold' : 'blue-grey--text'">
                                    No depreciable
                                </span>
                            </template>
                        </v-switch>


                        <v-switch v-model="tipos.otros" inset class="mr-6">
                            <template #label>
                                <span :class="tipos.otros ? 'primary--text font-weight-bold' : 'blue-grey--text'">
                                    Otros
                                </span>
                            </template>
                        </v-switch>
                    </div>
                </v-col>

                <template v-if="dep == null">
                    <div class="blue-grey--text  mx-auto my-3">
                        Seleccione una dependencia
                    </div>

                </template>

                <template v-else>
                    <v-col cols="12" class="py-4 px-8 text-center">

                        <h2 class="text-center mb-5"> <span class="primary--text">
                                {{ id_dep }}
                            </span> - {{ nombre_dep }}
                        </h2>

                        <p class="text-h2 mb-0">
                            {{ tweened.toFixed(0) }}
                        </p>
                        <p class="red--text">Faltantes</p>


               

                        <v-btn tile color="green accent-4" class="ma-2 white--text"
                            :href="'/facilitador/excel-faltantes/' + dep + '/?activofijo=' + this.tipos.activo_fijo + '&nodepreciable=' + this.tipos.no_depreciable + '&otro=' + this.tipos.otros"
                            link download>
                            Exportar excel
                            <v-icon right dark>
                                mdi-microsoft-excel
                            </v-icon>
                        </v-btn>

                    </v-col>
                </template>


            </v-row>

        </v-card>

    </v-container>
</template>
<script>
import Layout from "@/Layouts/FacilitadorLayout";
import axios from 'axios';
import gsap from 'gsap'
export default {

    layout: Layout,
    data: () => ({
        loading: false,
        page: 1,
        dep: null,
        dependencias: [],
        dependencia: null,
        tipos: {
            activo_fijo: true,
            no_depreciable: true,
            otros: false,
        },

        count_res: 0,
        tweened: 0,

        id_dep: '',
        nombre_dep: '',

    }),
    async created() {
        await this.getDependencias()
    },
    methods: {///excel-faltantes

        exportExcel() {

            axios.post('/facilitador/excel-faltantes', {
                dependencia: this.dep,
                tipos: this.tipos,
            });

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

        async getDependencias() {
            let res = await axios.get("/facilitador/getDependencias");
            this.dependencias = res.data.datos;
            return res.data.datos.data;
        },

        async getFaltantes() {

            if (this.dep == null) return;

            this.loading = true;

            let res = await axios.post('/facilitador/get-faltantes', {
                dependencia: this.dep,
                tipos: this.tipos,
            });

            this.count_res = res.data.data;

            console.log(res.data);
            this.loading = false;

        }

    },
    watch: {
        dep(val) {
            if (this.dep == null) return;
            let va = this.dependencias.filter((item) => item.iduoper == val)[0];
            this.id_dep = va.iduoper;
            this.nombre_dep = va.dependencia;
            this.getFaltantes();
        },
        tipos: {
            handler: function (newVal) {
                this.getFaltantes();
            },
            deep: true
        },

        count_res(n) {
            gsap.to(this, { duration: 0.5, tweened: Number(n) || 0 })
        }
    }


};
</script>
