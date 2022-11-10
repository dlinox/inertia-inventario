<template>
  <v-container>
    <v-row no-gutters dense>
      <v-col class="d-flex lef" cols="12" xs="12" sm="12" md="6" style=" padding-bottom:10px;">
        <v-row no-gutters dense class="" >
            <v-col cols="12" xs="12" sm="4" md="4" class="cuadros" >
                <v-row no-gutters>
                    <v-col class="d-flex cuadro1" cols="6" xs="6" sm="12" md="12" >
                        <div @click="dialog=true" style="width:100%; height:100%; cursor:pointer;">
                            <CuadroDatos :datos="grafico3" />
                        </div>
                    </v-col>
                    <v-col class="d-flex cuadro2" cols="6" xs="6" sm="12" md="12">
                        <div @click="dialogAyer=true" style="width:100%; height:100%; cursor:pointer;">
                            <CuadroDatos :datos="grafico4"/>
                        </div>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" xs="12" sm="8" md="8"  style="width: 100%;" >
            <div class="d-flex" style="width:100%; height:270px; justify-content:center; align-items:center; background:white;">
                <div @click="dialogGlobal=true" style="width:100%; height:100%; cursor:pointer;">
                    <CircularData :grafico="grafico1"/>
                </div>
            </div>
            </v-col>
        </v-row>
      </v-col>

      <v-col class="d-flex rig" cols="12" xs="12" sm="12" md="6" style=" padding-bottom:10px;">
        <v-row no-gutters dense class="" >
            <v-col cols="12" xs="12" sm="4" md="4" class="cuadros" >
                <v-row no-gutters>
                    <v-col class="d-flex cuadro1" cols="6" xs="6" sm="12" md="12" >
                        <CuadroDatos :datos="grafico5"/>
                    </v-col>
                    <v-col class="d-flex cuadro2" cols="6" xs="6" sm="12" md="12">
                        <CuadroDatos :datos="grafico6"/>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" xs="12" sm="8" md="8"  style="width: 100%;" >
            <div class="d-flex" style="width:100%; height:270px; justify-content:center; align-items:center; background:white;">
              <div @click="dialogDocuments=true" style="width:100%; height:100%; cursor:pointer;">
                <CircularData :grafico="grafico2"/>
              </div>
            </div>
            </v-col>
        </v-row>
      </v-col>
    </v-row>

    <v-row no-gutters dense>
      <v-col class="d-flex lef"  cols="12" xs="12" sm="12" md="7" style="margin-bottom:10px;">
        <div style="width: 100%;">
          <div class="d-flex" @click="diaglogXdia = true" style="width:100%; height: 100%; justify-content:center; align-items:center; background:white; cursor:pointer" >
            <SparkLine/>
          </div>
        </div>
      </v-col>
      <v-col class="d-flex rig" cols="12" xs="12" sm="12" md="5" style="padding-right: 0px; margin-top:0px;">
        <div style="width: 100%; margin-left:0px; ">
          <div class="d-flex" @click="dialogInvetaristas=true" style="width:100%; height:270px; justify-content:center; align-items:center; background:white; cursor:pointer">
            <Inventaristas :total="grafico1.registrados" :maximo="4"/>
          </div>
        </div>
        <!-- <div style="width: 50%; margin-left:10px; ">
          <div class="d-flex" style="width:100%; height:270px; justify-content:center; align-items:center; background:white;">
            <Barras/>
          </div>
        </div> -->
      </v-col>
    </v-row>

    <v-dialog
      v-model="dialog"
      width="600px"
    >
      <v-card>
        <v-card-title>
          <span class="text-h6">Registrados Hoy</span>
        </v-card-title>
        <v-card-text>
            <RegistroXdia fecha='2022-11-05'/>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary darken-1"
            primary
            @click="dialog = false"
          >
            Aceptar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="dialogAyer"
      width="600px"
    >
      <v-card>
        <v-card-title>
          <span class="text-h6">Registrados Ayer</span>
        </v-card-title>
        <v-card-text>
            <RegistroXdia fecha='2022-11-04'/>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary darken-1"
            primary
            @click="dialogAyer = false"
          >
            Aceptar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="dialogGlobal"
      width="600px"
    >
      <v-card>
        <v-card-title>
          <span class="text-h6">Avance Global</span>
        </v-card-title>
        <v-card-text>
            <v-expansion-panels focusable accordion tile>
                <v-expansion-panel
                    v-for="(item,i) in oficinas.oficinas"
                    :key="i"
                >
                    <v-expansion-panel-header>
                        <div class="d-flex" style="justify-content:space-between">
                            <span> <!-- {{item.codigo}}  - --> {{item.nombre}} </span>
                             <span>Reg. <OficinaCount :oficina=item.id /></span>
                        </div>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <div style="margin-left:20px;">
                            <AreaCount :oficina = item.id />
                        </div>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>

        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary darken-1"
            primary
            @click="dialogGlobal = false"
          >
            Aceptar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>





    <v-dialog
      v-model="diaglogXdia"
      width="600px"
    >
      <v-card>
        <v-card-title>
          <span class="text-h6">Registros en los ultimos días</span>
        </v-card-title>
        <v-card-text>
            <v-expansion-panels focusable accordion tile>
                <v-expansion-panel
                    v-for="(item,i) in dataxdias"
                    :key="i"
                >
                    <v-expansion-panel-header>
                        <div class="d-flex" style="justify-content:space-between">
                            <span> ({{item.REGISTROS}})  {{item.FECHA}} </span>
                        </div>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <div v-for="(itemD,j) in dataxdiaDatos" :key="j" >
                          <div v-if="itemD.fecha === item.FECHA">
                            <div class="d-flex" style=" margin-top: 5px; border-radius:5px;"  >
                              <div class="d-flex" style="justify-content:center; height:100%; width: 30px;">
                                <span v-if="itemD.estado === 1" style="color:green;" class="mdi mdi-checkbox-blank-circle"></span>
                                <span v-else style="color:grey;" class="mdi mdi-checkbox-blank-circle"></span>
                              </div>
                              <div>
                                <div><span> {{ itemD.nombre}} </span></div>
                                <div><span style="color:grey; font-size: .7rem; "> {{ itemD.area }} - {{ itemD.usuario}} </span></div>
                              </div>
                            </div> 
                          </div>
                        </div>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>

        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary darken-1"
            primary
            @click="diaglogXdia = false"
          >
            Aceptar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


    <v-dialog
      v-model="dialogInvetaristas"
      width="600px"
    >
        <v-card tile>
            <Inventaristas :total="grafico1.registrados" :maximo="10000"/>
        </v-card>
        <v-card-actions style="background:white;">
          <v-spacer></v-spacer>
          <v-btn
            color="primary darken-1"
            primary
            @click="dialogInvetaristas = false"
          >
            Aceptar
          </v-btn>
        </v-card-actions>

    </v-dialog>

























    <v-dialog
      v-model="dialogDocuments"
      width="600px"
    >
      <v-card>
        <v-card-title>
          <span class="text-h6">Cargos </span>
        </v-card-title>
        <v-card-text>
          <v-simple-table dense>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">
                    Código
                  </th>
                  <th class="text-left">
                    Responsable
                  </th>
                  <th class="text-left">
                    Area
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="item in documentos"
                  :key="item.id"
                >
                  <td>{{ item.codigo }}</td>
                  <td>{{ item.dni}}</td>
                  <td>{{ item.nombre }}</td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>

        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary darken-1"
            primary
            @click="dialogDocuments = false"
          >
            Aceptar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </v-container>
</template>

<script>
import Layout from "@/Layouts/AdminLayout";
import CuadroDatos from './Components/CuadroDatos'
import CircularData from './Components/CircularData'
import SparkLine from './Components/SparkLine'
import Inventaristas from './Components/Inventaristas'
import Barras from './Components/Barras.vue'
import RegistroXdia from './Components/RegistroXdia.vue'
import AreaCount from './Components/AreasCount.vue'
import OficinaCount from './Components/OficinaCount.vue'

export default {
  components: {CuadroDatos, CircularData, SparkLine, Inventaristas, Barras, RegistroXdia, AreaCount, OficinaCount},
  metaInfo: { title: "Dashboard" },
  layout: Layout,
  data(){
    return{
        dialog: false,
        dialogAyer: false,
        dialogGlobal: false,
        diaglogXdia: false,
        dialogInvetaristas:false,
        oficinas:[],
        documentos:[],
        dataxdias:[],
        dataxdiaDatos:[],
        dialogDocuments:[],
        grafico1 : {
            color:'success',
            titulo:'Avance Global',
            valor:54,
            label:"Bienes Registrados",
            registrados:73989,
            anterior:89982,
            labelAnterior:'Bienes Anteriores'
        },

        grafico2 : {
            color:'warning',
            titulo:'Cargos de Bienes',
            valor:84,
            label:"Cargos Registrados",
            registrados:1989,
            labelAnterior:'Total de cargos',
            anterior:4982,

        },
        grafico3 : {
            nroanterior:89922,
            nroactual:1322,
            label:'Hoy',
            label2:'Bienes registrados'
        },
        grafico4 : {
            nroanterior:"",
            nroactual:1022,
            label:'Ayer',
            label2:'Bienes registrados'
        },

        grafico5 : {
            nroanterior:"",
            nroactual:1022,
            label:'',
            label2:'Oficinas Registradas'
        },
        grafico6 : {
            nroanterior:"",
            nroactual:1022,
            label:'',
            label2:'Areas Registradas'
        }

    }
  },

  created(){
    this.getDocuments()
    this.getGlobal()
    this.avanceCargos()
    this.avanceG()
    this.getDataXdias()

  },
  methods: {
    async getGlobal() {
        let res = await axios.get("/admin/reportes/avanceGlobal");
        console.log(res.data.g_actual.registros);
        this.grafico1.registrados = res.data.g_actual.registros;
        this.grafico1.anterior = res.data.g_antes.registros;
        this.grafico1.valor = (res.data.g_actual.registros/res.data.g_antes.registros).toFixed(2);
        this.grafico3.nroactual = res.data.g_hoy.registros;
        this.grafico4.nroactual = res.data.g_ayer.registros;
    },

    async avanceCargos() {
        let res = await axios.get("/admin/reportes/avanceCargos");
        //console.log(res.data.g_actual.registros);
        this.grafico2.registrados = res.data.cargos.registros;
        this.grafico2.anterior = res.data.totalCargosInv.registros;
        this.grafico2.valor = (res.data.cargos.registros/res.data.totalCargosInv.registros).toFixed(2);
        this.grafico5.nroactual = res.data.nOficinas.registros;
        this.grafico6.nroactual = res.data.nAreas.registros;
    },

    async getDocuments() {
      let res = await axios.get("/admin/reportes/getDocumentsF/3,1900-01-01,2100-12-31");
      this.documentos = res.data.datos;
    },

    async getDataXdias(){
        let res = await axios.get("/admin/reportes/regDiarioG");
        this.dataxdias = res.data.datos;
        this.dataxdiaDatos = res.data.registros;
    },

    async avanceG() {
        let res = await axios.get("/admin/reportes/OficinasAvanzadas");
        this.oficinas = res.data;
    },

  }
};
</script>

<style scope>
.lef{
    padding-right: 5px !important;
}
.rig{
    padding-left: 5px !important;
}
.cuadro1{
    align-items:center;
    margin-bottom: 10px;
}
.cuadro2{
    align-items:center;
    margin-bottom: 10px;
}
.cuadros{
    padding-right:10px !important;
}
@media screen and (max-width: 959px) {
    .lef{
        padding-right: 0px !important;
    }
    .rig{
        padding-left: 0px !important;
    }
}
@media screen and (max-width: 600px) {

    .cuadros{
        padding-right:0px !important;
        margin-bottom: 0px;
    }
    .cuadro2{
        padding-left: 5px!important;
    }
    .cuadro1{
        padding-right: 5px!important;
    }
}

</style>
