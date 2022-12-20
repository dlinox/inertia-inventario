<template>
   <v-card class="mt-2 mb-5 mx-auto" max-width="850">
      <v-overlay absolute :value="loadin_form">
         <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <v-card-title class="text-h6 font-weight-regular justify-space-between">
         <span>{{ currentTitle }}</span>
         <v-avatar color="primary lighten-2" class="subheading white--text" size="24" v-text="step"></v-avatar>
      </v-card-title>

      <v-window v-model="step">
         <v-window-item :value="1">
            <v-card-text>

               <v-form ref="form" v-model="form_valid" lazy-validation>
                  <v-row class="" align="center">
                     <v-col cols="12" sm="8" md="8" class="pb-1 pt-0">
                        <v-text-field class="mt-0 pt-0" dense label="Descripción" outlined
                           v-model="form_data.descripcion" :rules="nameRules" required></v-text-field>
                     </v-col>
                     <v-col cols="6" sm="4" md="4" class="pb-1 pt-0">
                        <v-text-field class="mt-0 pt-0" dense label="Marca" outlined
                           v-model="form_data.marca"></v-text-field>
                     </v-col>
                     <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                        <v-text-field class="mt-0 pt-0" dense label="Modelo" outlined
                           v-model="form_data.modelo"></v-text-field>
                     </v-col>


                     <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                        <v-text-field class="mt-0 pt-0" dense label="Color" outlined
                           v-model="form_data.color"></v-text-field>
                     </v-col>

                     <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                        <v-text-field class="mt-0 pt-0" dense label="Medidas" outlined persistent-hint
                           hint="Largo x Ancho x Alto" v-model="form_data.medidas"></v-text-field>
                     </v-col>

                     <v-col cols="6" sm="6" md="6" class="pb-1 pt-0">
                        <SimpleAutoCompleteInput v-model="form_data.id_estado" :items="estados" label="Estado"
                           item_text="nombre" item_value="id" :rules="nameRules" />
                     </v-col>

                     <v-col cols="12" class="pb-1 pt-0 d-flex">
                        <v-autocomplete v-model="form_data.id_persona" clearable class="mt-0 pt-0" dense
                           label="Responsable" outlined :items="personas" :filter="personasFilter" item-value="id"
                           :search-input.sync="personas_search" :loading="loading_search_persona" :rules="nameRules"
                           required>
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
                           <v-btn class="ml-2" dark color="primary" @click="
                              show_persona_otro = !show_persona_otro
                           ">
                              <v-icon>mdi-account-plus</v-icon>
                           </v-btn>
                        </template>
                     </v-col>

                     <v-col v-if="show_persona_otro || form_data.idpersona_otro" cols="12" class="pb-1 pt-0 d-flex">
                        <v-autocomplete v-model="form_data.idpersona_otro" clearable class="mt-0 pt-0" dense
                           label="2° Responsable" outlined :items="personas_otro" :filter="personasFilter"
                           item-value="id" :search-input.sync="personas_search_otro"
                           :loading="loading_search_persona_otro" :rules="nameRules" required>
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

                        <v-btn class="ml-2" dark color="red" @click="show_persona_otro = !show_persona_otro">
                           <v-icon dark>mdi-account-minus</v-icon>
                        </v-btn>
                     </v-col>

                     <v-col cols="12" class="pb-1 pt-0">
                        <SelectOficina :user="user.id" v-model="form_data.id_oficina" :rules="nameRules" />
                     </v-col>

                     <v-col cols="6" class="pb-1 pt-0">
                        <v-combobox v-model="form_data.estado_uso" :items="estados_uso" label="Situación" outlined dense
                           :rules="nameRules"></v-combobox>
                     </v-col>

                     <v-col cols="6" class="pb-1 pt-0">
                        <v-text-field class="mt-0 pt-0" dense label="N° Ambiente" outlined
                           v-model="form_data.num_ambiente"></v-text-field>
                     </v-col>

                     <v-col cols="12" class="pb-1 pt-0">
                        <v-textarea class="mt-0 pt-0" label="Observación" dense outlined rows="2"
                           v-model="form_data.observaciones"></v-textarea>
                     </v-col>

                  </v-row>
               </v-form>
            </v-card-text>
         </v-window-item>

         <v-window-item :value="2">
            <v-card-text>

               <v-slider v-model="cantidad" ticks thumb-label="always" min="2" max="150" class="mt-5">
                  <template v-slot:prepend>
                     <v-icon @click="cantidad--">
                        mdi-minus
                     </v-icon>
                  </template>

                  <template v-slot:append>
                     <v-icon @click="cantidad++">
                        mdi-plus
                     </v-icon>
                  </template>
               </v-slider>

               <v-expansion-panels v-model="panel">
                  <v-expansion-panel>
                     <v-expansion-panel-header>
                        <span> Elementos <v-chip dark color="blue">{{ cantidad }} </v-chip></span>
                     </v-expansion-panel-header>
                     <v-expansion-panel-content class="py-2">
                        <v-row v-for="(item, index ) in form_data.cant" :key="index">
                           <v-col cols="6" class="pb-1 pt-0">
                              <v-text-field class="mt-0 pt-0" dense :label="'Codigo ' + (index + 1)" outlined
                                 v-model="item.codigo"></v-text-field>
                           </v-col>

                           <v-col cols="6" class="pb-1 pt-0">
                              <v-text-field class="mt-0 pt-0" dense :label="'Serie ' + (index + 1)" outlined
                                 v-model="item.nro_serie"></v-text-field>
                           </v-col>
                        </v-row>
                     </v-expansion-panel-content>
                  </v-expansion-panel>
               </v-expansion-panels>

            </v-card-text>
         </v-window-item>

         <v-window-item :value="3">
            <div class="pa-4 text-center">
               <h3 class="text-h6 font-weight-light mb-2">
                  CORRELATIVOS
               </h3>
               <span class="text-caption grey--text">
                  <v-list subheader three-line>
                     <v-subheader>Lista de correlativos</v-subheader>
                     <v-list-item v-for="(item, index) in correlativos" :key="index">
                        <v-list-item-content>
                           <v-list-item-subtitle>
                               <b>Codigo: </b> {{ item.codigo }} - <b>Serie: </b> {{ item.serie }}
                           </v-list-item-subtitle>
                           <v-list-item-title>
                              <b class="text--primary">{{ item.correlativo }}</b> 
                           
                           </v-list-item-title>

                        </v-list-item-content>
                     </v-list-item>
                  </v-list>
               </span>
            </div>
         </v-window-item>
      </v-window>

      <v-divider></v-divider>

      <v-card-actions>
         <template v-if="step === 2">
            <v-btn :disabled="step === 3" color="primary" text @click="step--">
               atras
            </v-btn>
         </template>

         <v-spacer></v-spacer>
         <template v-if="step === 1">
            <v-btn :disabled="!form_valid" color="primary" depressed @click="() => {
               this.$refs.form.validate() ? step++ : step;
            }">
               SIGUIENTE
            </v-btn>
         </template>
         <template v-if="step === 2">
            <v-btn :disabled="!form_valid" color="primary" depressed @click="GuardarLote()">
               guardar
            </v-btn>
         </template>
      </v-card-actions>
   </v-card>
</template>

<script>
import Layout from "@/Layouts/InventarioLayout";
import axios from "axios";
import SimpleAutoCompleteInput from "./Components/FormComponents/SimpleAutoCompleteInput.vue";
import AlertComponent from "./Components/AlertComponent.vue";
import SelectOficina from "../../components/autocomplete/SelectOficina.vue";

export default {

   components: {
      SimpleAutoCompleteInput,
      AlertComponent,
      SelectOficina,
   },
   props: {
      estados: Array,
      mis_areas: Array,
      areas: Array,
   },

   data: () => ({
      step: 1,
      estados_uso: ["EN USO", "ALMACENADO", "EMPAQUETADO"],
      form_data: {
         cant: [
            {
               codigo: null,
               nro_serie: null,
            },
            {
               codigo: null,
               nro_serie: null,
            },
         ]
      },
      element: {
         codigo: null,
         nro_serie: null,
      },

      form_valid: true,
      loadin_form: false,
      areas_by_oficina: [],
      personas: [],
      personas_search: "",
      loading_search_persona: false,
      personas_otro: [],
      personas_search_otro: "",
      loading_search_persona_otro: false,
      show_persona_otro: false,
      nameRules: [(v) => !!v || "*Obligatorio"],
      mis_areas_id: [],

      cantidad: 2,
      panel: 0,
      correlativos: [],

   }),
   layout: Layout,

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

      async GuardarLote() {
         if (this.$refs.form.validate()) {
            this.loadin_form = true;
            await this.createInventario();
            this.loadin_form = false;
         }
      },

      async createInventario() {
         let res = await axios.post(
            "/inventario/guardar-lote-nuevos",
            this.form_data
         );


         if (res.data.estado) {
            this.correlativos = res.data.correlativos;
            this.step++;
            console.log(res.data);
            //  this.shwModalCorrelativo(res.data);
            this.resetAll();
         }

         this.setDataAlert(res.data);
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
         this.resetForm();
      },
      resetForm() {
         this.form_data = {};
         this.$refs.form.reset();
      },

   },

   watch: {

      cantidad(val) {
         this.form_data.cant = Array(val).fill({ ...this.element });
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
      currentTitle() {
         switch (this.step) {
            case 1:
               return 'DATOS EN COMUN'
            case 2:
               return 'NUMERO DE REGISTROS'
            default:
               return 'CORRELATIVOS'
         }
      },
   },
}
</script>