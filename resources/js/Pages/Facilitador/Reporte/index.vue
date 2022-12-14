<template>
    <div class="pa-3"> 
      <v-card>
      <!-- <pre>{{datos}}</pre> -->
      <v-simple-table style="width: 100%;">
        <thead>
          <tr>
            <th colspan="5">
              <div class="">
                <div class="d-flex" style="justify-content: space-between; align-items: center;">
                  <div>
                    <span style="font-weight: bold; font-size: 1.3rem;"> Reporte de Avance del {{voltear(fecha)}} </span>
                    <h2>Registro de Bienes </h2>
                  </div>
                  <div class="pt-5">
                    <v-menu
                      v-model="menu"
                      :close-on-content-click="false"
                      :nudge-right="-40"
                      transition="scale-transition"
                      offset-y 
                      min-width="auto"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="fecha"
                          label="Fecha"
                          dense
                          append-icon="mdi-calendar"
                          readonly
                          outlined
                          v-bind="attrs"
                          v-on="on"
                          style="padding-right: 0px;"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="fecha"
                        no-title
                        locale="es-es"
                        :first-day-of-week="1"
                        @input="menu = false"
                      ></v-date-picker>
                    </v-menu>
                  </div>
                </div>
              </div>
            </th>
          </tr>
          <tr>
            <th>Equipo</th>
            <th>Dependencia</th>
            <th>Apellidos Y Nombres</th>
            <th>Reg. x Usuario</th>
            <th>Reg. x Equipo</th>
          </tr>
        </thead>
        <tbody >
            <tr v-for="item in datos" :key="item.id">
              <td align="center"><div>Team</div> {{ item.equipo }}</td>
              <td>
                <div v-for="it in item.dependencia">
                    {{it}}
                </div>
              </td>
              <td style="width: 300px; min-width: 330px;">
                <div>{{ item.usuarios.uno }} </div>
                <div>{{ item.usuarios.dos }} </div>
              </td>
              <td align="center">
                <div>{{ item.usuarios.unoR }} </div>
                <div>{{ item.usuarios.dosR }} </div>
              </td>
              <td align="center"><span style=" font-size: 1rem;"> {{item.reg }} </span></td>
            </tr>
            <tr>
              <td colspan="4"><span style="font-weight: bold; font-size: 1rem;">Total</span> </td>
              <td align="center"><span style="font-weight: bold; font-size: 1rem; "> {{total}} </span> </td>
            </tr>
        </tbody>
      </v-simple-table>

    </v-card>
    </div>
</template>

<script>
import Layout from "@/Layouts/FacilitadorLayout";

export default {
    metaInfo: { title: "Facilitador - Reporte" },
    layout: Layout,
    data: () => ({
        datos:[],
        total:0,
        fecha:(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        menu: false,
    }),
    methods: {
      async getDatos() {
          let res = await axios.get("/facilitador/reporte-dia/"+this.fecha);
          this.datos = res.data.datos;
          this.total = res.data.total;
          return res.data.datos.data;
      },

      voltear(string) {
        var info = string.split('-').reverse().join('/');
        return info;
      },

      getFecha(dates) {
        var dd = new Date();
        var n = dates || 0;
        dd.setDate(dd.getDate() + n);
        var y = dd.getFullYear();
        var m = dd.getMonth() + 1;
        var d = dd.getDate();
        m = m < 10 ? "0" + m: m;
        d = d < 10 ? "0" + d: d;
        var day = y + "-" + m + "-" + d;
        return day;
      },


    },    
    created() {
      this.fecha = this.getFecha(0)
      this.getDatos()
    }, 

    watch:{
      fecha: function(){
          this.getDatos()
      },
    }  
};
</script>
