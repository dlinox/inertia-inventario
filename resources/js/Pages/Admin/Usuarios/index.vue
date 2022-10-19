<template>
    <div class="wrapper-page">
        <div class="page-heading">
            <div class="page-details">
                <v-toolbar outlined color="grey lighten-3" elevation="0">
                    <v-toolbar-title>
                        <v-app-bar-nav-icon
                            @click="drawer = !drawer"
                        ></v-app-bar-nav-icon>

                        Usuarios
                    </v-toolbar-title>
                </v-toolbar>
            </div>
            <div class="page-search">
                <v-toolbar outlined color="grey lighten-5" elevation="0">
                    <v-text-field
                        v-model="usuario_search"
                        append-icon="mdi-magnify"
                        label="Buscar"
                        hide-details
                        outlined
                        dense
                    ></v-text-field>
                </v-toolbar>
            </div>
        </div>
        <div class="content-wrapper">
            <v-navigation-drawer
                absolute
                v-model="drawer"
                color="grey lighten-5"
            >
            </v-navigation-drawer>
            <div class="content" :class="drawer ? '' : 'full'">
                <v-container>
                    <v-card>
                        <v-simple-table>
                            <template v-slot:default>
                                <thead class="grey lighten-1">
                                    <tr>
                                        <th class="text-left">Nombres</th>
                                        <th class="text-left">Apellidos</th>
                                        <th class="text-left">Correo</th>
                                        <th class="text-left">Rol</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(item, index) in list_usuarios"
                                        :key="index"
                                    >
                                        <td>{{ item.nombres }}</td>
                                        <td>{{ item.apellidos }}</td>
                                        <td>
                                            {{ item.email }}
                                        </td>
                                        <td>
                                            {{ item.rol_name }}
                                        </td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>

                        <v-pagination
                            v-model="page"
                            class=""
                            :length="pages"
                        ></v-pagination>
                    </v-card>
                </v-container>
            </div>
        </div>
    </div>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
export default {
    metaInfo: { title: "Usuarios" },
    layout: Layout,
    data: () => ({
        absolute: false,
        drawer: true,
        items: [
            { title: "Home", icon: "mdi-view-dashboard" },
            { title: "About", icon: "mdi-forum" },
        ],

        page: 1,
        total_result: 0,
        pages: 1,

        usuario_search: "",
        list_usuarios: [],
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
            set: function (newValue) {},
        },
    },

    methods: {
        async getUsuarios(term = "", page = 1) {
            let res = await axios.post(
                "/admin/usuarios/get-usuarios?page=" + page,
                {
                    term: term,
                }
            );

            console.log(res.data);

            this.page = res.data.datos.current_page;
            this.total_result = res.data.datos.total;
            this.pages = res.data.datos.last_page;

            return res.data.datos.data;
        },
    },
    async created() {
        this.drawer = this.$vuetify.breakpoint.width > 960 ? true : false;
        this.absolute = this.$vuetify.breakpoint.width > 960 ? false : true;
        this.list_usuarios = await this.getUsuarios();
    },
    watch: {
        async usuario_search(val) {
            //if (!val) return;

            //this.loading_table = true;
            let res = await this.getUsuarios(val);
            this.list_usuarios = res;
            //this.loading_table = false;
        },

        async page(val, old_val) {
            if (val == old_val) return;

            //this.loading_table = true;

            let res = await this.getUsuarios(this.usuario_search, val);
            this.list_usuarios = res;

            //this.loading_table = false;
        },
    },
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
</style>
