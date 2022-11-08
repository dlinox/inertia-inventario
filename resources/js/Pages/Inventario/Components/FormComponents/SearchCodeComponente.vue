<template>
    <v-autocomplete
        v-model="codigo_search"
        clearable
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
                    <template v-if="codigos_search?.length > 2">
                        Sin resultados para
                        <strong> "{{ codigos_search }}" </strong>
                    </template>
                    <template v-else>
                        Digite más de
                        <strong> 3 </strong> caracteres.
                    </template>
                </v-list-item-title>
            </v-list-item>
        </template>

        <template v-slot:item="data">
            <v-list-item-content @click="onSelected(data.item)">
                <v-list-item-title v-html="data.item.codigo">
                </v-list-item-title>
                <v-list-item-subtitle>
                    {{ data.item.nombre }}
                </v-list-item-subtitle>
            </v-list-item-content>
        </template>
    </v-autocomplete>
</template>
<script>
import {
    getBienKByCodigo,
} from "@/Helpers/ConsultasHelper";

export default {
    data: () => ({
        codigo_search: "",
        codigos_res: [],
        codigos_search: "",
        codigos_search_loading: false,
    }),
    watch: {
        async codigos_search(val) {
            if (!val) return;
            if (val.length < 3) return;
            this.codigos_search_loading = true;
            let res = await getBienKByCodigo(val);
            this.codigos_res = res;
            this.codigos_search_loading = false;
        },
    },
    methods: {
        onSelected(item) {
            console.log("aquiiii on");
            console.log(item);
            this.$emit("setData", item);
        },
    },
};
</script>
