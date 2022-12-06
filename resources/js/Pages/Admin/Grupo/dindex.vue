<template>
    <v-container>
        <div>

            {{oficinas}}

        </div>
    </v-container>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
import axios from "axios";

export default {

    layout: Layout,
    data: () => ({
        oficinas:[]
    }),   

    methods: {

        async getGrupos() {
            let res = await axios.get("/facilitador/inventario/get-grupo");
            this.oficinas = res.data.datos;
            return res.data.datos.data;
        },

        customFilterOficina(item, queryText, itemText) {
            const nombre = item.nombre.toLowerCase();
            const iduoper = item.iduoper.toLowerCase();
            const searchText = queryText.toLowerCase();
            return (
                nombre.indexOf(searchText) > -1 ||
                iduoper.indexOf(searchText) > -1
            );
        },

        limpiar() {
            this.tree = [];
            this.usuariosSelecionadas = [];
            this.oficinasSelecionadas = [];
        },

        buscaPersonabyID(id) {
            for (let i in this.usuarios) {
                if (this.usuarios[i].id === id) {
                    return (
                        this.usuarios[i].nombres +
                        " " +
                        this.usuarios[i].paterno +
                        " " +
                        this.usuarios[i].materno
                    );
                }
            }
        },

        buscaOficinabyID(id) {
            for (let i in this.oficinas) {
                if (this.oficinas[i].iduoper === id) {
                    return this.oficinas[i].nombre;
                }
            }
        },

        async Guardar() {
            let res = await axios.post("/admin/grupo/guardar", {
                usuarios: this.usuariosSelecionadas,
                ofici: this.oficinasSelecionadas,
            });
            this.dialog = false;
            this.text = "Grupo Creado";
            this.snackbar = true;
        },
        clickColumn(slotData) {
            const indexRow = slotData.index;
            const indexExpanded = this.expanded.findIndex(
                (i) => i === slotData.item
            );
            if (indexExpanded > -1) {
                this.expanded.splice(indexExpanded, 1);
            } else {
                this.expanded.push(slotData.item);
            }
        },
    },
    async created() {
        // this.getItemsGroup()
        await this.getUsuarios();
        await this.getOficinas();
        console.log("awedarafdf");
        await this.getOficinasDependencias();
    },
};
</script>

<style scoped>
.treee {
    background: none;
}
.treee::-webkit-scrollbar {
    -webkit-appearance: none;
}

.treee::-webkit-scrollbar:vertical {
    width: 10px;
}

.treee::-webkit-scrollbar-button:increment,
.treee::-webkit-scrollbar-button {
    display: none;
}

.treee::-webkit-scrollbar:horizontal {
    height: 10px;
}

.treee::-webkit-scrollbar-thumb {
    background-color: #797979;
    border-radius: 20px;
    border: 2px solid #f1f2f3;
}

.treee::-webkit-scrollbar-track {
    border-radius: 10px;
}
.v-data-table_expanded.v-data-tableexpanded_content {
    box-shadow: none !important;
}
</style>
