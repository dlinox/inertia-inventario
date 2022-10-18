<template>
    <v-app>
        <v-navigation-drawer app v-model="drawer" color="#01305A" dark>
            <v-sheet
                color="rgba(0,0,0,.3)"
                elevation="1"
                class="py-4"
                width="100%"
            >
                <img width="80%" src="/images/logomin.png" alt=""
            /></v-sheet>

            <v-card flat rounded="0" color="transparent">
                <v-list two-line class="py-0">
                    <v-list-item>
                        <v-list-item-avatar color="secondary">
                            <span class="white--text headline">
                                <small> AA </small>
                            </span>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title>
                                {{ user.nombres }}
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                {{ user.rol }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card>

            <v-divider />

            <menu-principal-component />

            <template v-slot:append>
                <v-divider></v-divider>
                <v-card-text class="text-center py-1">
                    <v-btn class="mx-4" icon link @click="salir">
                        <v-icon size="24px" color="blue-grey lighten-4">
                            mdi-power
                        </v-icon>
                    </v-btn>
                </v-card-text>
            </template>
        </v-navigation-drawer>
        <v-app-bar app color="white" scroll-off-screen elevation="3">
            <v-app-bar-nav-icon
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>

            <v-spacer />

            <v-menu offset-y>
                <template v-slot:activator="{ attrs, on }">
                    <v-btn
                        text
                        color="primary"
                        class=""
                        v-bind="attrs"
                        v-on="on"
                    >
                        {{ user.nombres }}
                        <v-icon right>mdi-account </v-icon>
                    </v-btn>
                </template>

                <v-list dense>
                    <v-subheader>Opciones</v-subheader>
                    <v-list-item-group v-model="selectedMenu" color="primary">
                        <v-list-item
                            v-for="(item, i) in items"
                            :key="i"
                            @click="SelectMenu(item.text)"
                        >
                            <v-list-item-icon>
                                <v-icon v-text="item.icon"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title
                                    v-text="item.text"
                                ></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-menu>
        </v-app-bar>

        <v-main class="main_app">
            <transition name="component-fade" mode="out-in">
                <slot />
            </transition>
        </v-main>
        <v-footer app dark>
            <v-spacer />
            <h6>
                <!--by
                <a
                    href="https://www.linkedin.com/in/lino-puma-ticona-a76021202/"
                    target="_blank"
                    class="blue--text text-decoration-none"
                    >Lino Puma</a
                > -->
            </h6>
        </v-footer>
    </v-app>
</template>
<script>
import MenuPrincipalComponent from "@/components/MenuPrincipalComponent";
export default {
    components: {
        MenuPrincipalComponent,
    },
    data: () => ({
        drawer: true,
        attrs: {
            class: "mb-1",
            boilerplate: true,
            elevation: 0,
            loading: false,
        },

        closeOnContentClick: true,

        items: [
            { text: "Perfil", icon: "mdi-account" },
            { text: "Configuracion", icon: "mdi-cog" },
            { text: "Salir", icon: "mdi-power" },
        ],
        selectedMenu: null,
    }),
    computed: {
        user() {
            return this.$page.props.auth.user;
        },
    },
    methods: {
        salir() {
            this.$inertia.post("/logout");
        },
    },
    async created() {
        //await this.GetCurrentUser();

        this.drawer = this.$vuetify.breakpoint.width > 960 ? true : false;
    },
};
</script>
<style scoped>
.main_app {
    background: #eeeeee;
}
.component-fade-enter-active,
.component-fade-leave-active {
    transition: opacity 0.3s ease;
}
.component-fade-enter, .component-fade-leave-to
/* .component-fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>
