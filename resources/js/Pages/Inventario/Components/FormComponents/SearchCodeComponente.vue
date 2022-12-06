<template>
    <v-autocomplete
        ref="autocomplete"
        v-model="codigo_search"
        clearable
        dense
        label="Buscar Codigo"
        outlined
        :items="codigos_res"
        item-text="codigo"
        :search-input.sync="codigos_search"
        :loading="codigos_search_loading"
        @keydown="filterKey"
    >
        <template v-slot:item="{ item }">
            <v-list-item-avatar
                size="20"
                :color="item.registrado ? 'green' : 'grey'"
            >
                <v-icon small dark> mdi-checkbox-marked-circle </v-icon>
            </v-list-item-avatar>
            <v-list-item-content>
                <v-list-item-title v-text="item.codigo" />
                <v-list-item-subtitle v-text="item.descripcion" />
            </v-list-item-content>
        </template>
        <template v-slot:no-data>
            <v-list-item>
                <v-list-item-title>
                    <template v-if="codigos_search?.length > 2">
                        Sin resultados para
                        <strong> "{{ codigos_search }}" </strong>
                    </template>
                    <template v-else>
                        Digite
                        <strong> 3 </strong> dijitos para iniciar la busqueda.
                    </template>
                </v-list-item-title>
            </v-list-item>
        </template>
    </v-autocomplete>
</template>
<script>
export default {
    data: () => ({
        codigo_search: "",
        codigos_res: [],
        codigos_search: "",
        codigos_search_loading: false,
    }),
    watch: {
        async codigo_search(val) {
            if (!val) return;
            this.codigos_search = val;
            let item = this.codigos_res.filter((e) => e.codigo === val)[0];
            item.registrado = item.registrado == 1 ? true : false;
            this.$emit("setData", item);
            this.codigo_search = "";
            this.codigos_res = [];
            this.codigos_search = "";
            this.reset();
        },

        async codigos_search(val) {
            if (!val) return;
            if (val == this.codigo_search) return;
            if (val.length < 3) return;
            this.codigos_search_loading = true;
            let res = await axios.get("/autocomplete/bienes/" + val);
            this.codigos_res = res.data.datos;
            this.codigos_search_loading = false;
        },
    },
    methods: {
        reset() {
            this.$nextTick(() => {
                this.codigo_search = null;
                this.$refs.autocomplete.internalSearch = null;
            });
        },
        filterKey(e) {
            const key = e.key;
           
            if (
                !Number.isInteger(parseInt(key)) &&
                key != "Backspace" &&
                key != "ArrowLeft" &&
                key != "ArrowRight"
            )
                return e.preventDefault();
        },
    },
};
</script>
