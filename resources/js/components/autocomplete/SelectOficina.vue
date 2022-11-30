<template>
    <div>
        <v-autocomplete
        v-model="oficina_selected"
        clearable
        class="mt-0 pt-0"
        dense
        label="Oficina"
        outlined
        :items="oficinas_res"
        :filter="customFilterOficina"
        item-value="iduoper"
        item-text="nombre"
        :search-input.sync="oficinas_search"
        required
        :disabled="disabled"

        :rules="rules"
    >
        <template v-slot:selection="data">
            <small>
                <strong>{{ data.item.dependencia }}</strong>
                {{ data.item.nombre }}</small
            >
        </template>

        <template v-slot:no-data>
            <v-list-item>
                <v-list-item-title>
                    <template v-if="oficinas_search?.length > 2">
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

        <template v-slot:item="data">
            <v-list-item-content>
                <v-list-item-title v-html="data.item.dependencia">
                </v-list-item-title>
                <v-list-item-subtitle>
                    {{ data.item.nombre }}
                </v-list-item-subtitle>
            </v-list-item-content>
        </template>
    </v-autocomplete>
    </div>
  
</template>
<script>
export default {
    name: "SelectOficina",
    props: {
        value: String,

        disabled: {
            default: false,
            type: Boolean,
        },
        user: Number,
        rules: Array,
    },
    data: () => ({
        oficinas_res: [],
        oficinas_search: "",
        data: [],
    }),

    methods: {
        customFilterOficina(item, queryText, itemText) {
            const nombre = item.nombre.toLowerCase();
            const dependencia = item.dependencia.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                nombre.indexOf(searchText) > -1 ||
                dependencia.indexOf(searchText) > -1
            );
        },
        async BuscarOficinas(term) {
            let user_filter = this.user ? "/" + this.user : "";
            let res = await axios.get(
                "/get-data/oficinas/" + term + user_filter
            );
            return res.data.datos;
        },
    },
    watch: {
        async oficinas_search(val) {
            if (!val) return;
            if (val.length < 2) return;
            let res = await this.BuscarOficinas(val);
            this.oficinas_res = res;
        },
        async oficina_selected(val) {
            let res = await this.BuscarOficinas(val);
            this.oficinas_res = res;
        },
    },
    computed: {
        oficina_selected: {
            get() {
                return this.value;
            },
            set(newValue) {
                this.$emit("input", newValue);
            },
        },
    },
};
</script>

<style>
.v-autocomplete {
    font-size: 15px;
}
</style>
