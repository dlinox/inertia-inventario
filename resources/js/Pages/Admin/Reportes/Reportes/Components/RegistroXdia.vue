<template>
  <div style="width: 100%; height: 100%;">
    <!-- <v-card elevation="1" v-for="item in data.registros" :key="item.id" style="margin-bottom:5px">
        <div>
            <span>{{item.codigo}} -  {{item.nombre}} - {{item.a}}</span>
        </div>
    </v-card> -->
    <!-- <div>
        <v-card-title>
        <v-text-field
            v-model="search"
            style="max-width:200px; "
            append-icon="mdi-magnify"
            label="Search"
            outlined
            dense
            hide-details
        ></v-text-field>
        </v-card-title>
        <v-data-table
        :headers="headers"
        :items="data.registros"
        :search="search"
        ></v-data-table>
    </div> -->

    <v-simple-table dense>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-left">
            Código
          </th>
          <th class="text-left">
            Nombre
          </th>
          <th class="text-left">
            Area
          </th>
          <th>
            Fecha y hora
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in data.registros"
          :key="item.id"
        >
          <td>{{ item.codigo }}</td>
          <td>{{ item.nombre }}</td>
          <td>{{ item.a }}</td>
          <td v-if="item.update_at !== null">{{ item.created_at}}</td>
          <td v-else>{{ item.created_at}}</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>

  </div>
</template>

<script>
export default {
  props:['fecha'] ,
  data () {
    return {
        fec: this.fecha,
        data:{ },
        search: '',
        headers: [
          {
            text: 'Cod',
            align: 'start',
            sortable: false,
            value: 'codigo',
          },
          { text: 'Nombre', value: 'nombre' },
        //   { text: 'Estado', value: 'estado' },
        //   { text: 'Modelo', value: 'modelo' },
        //   { text: 'Serie', value: 'serie' },
        //   { text: 'Medida', value: '' },
        //   { text: 'Color', value: '' },
          { text: 'Area', value: 'a' },
        ],
    }
  },
  created(){
    this.getRegistros();
  },
  mounted(){

  },
  methods:{
    async getRegistros() {
        let res = await axios.get('/admin/reportes/RegXdia/'+"'"+this.fec+"'");
        this.data = res.data;
    },
  },

}

</script>
