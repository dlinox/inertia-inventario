<template>
    <v-app class="app-wrapper">
        <v-app-bar  color="white">
           
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

        <v-main class="main-wrapper">
            <slot />
        </v-main>

        <ReLogin :user="user"  :dialog="dialog_relogin"  @dialog="dialog_relogin = $event" />
    </v-app>
</template>

<script>
import ReLogin from "../components/ReLogin.vue";
export default {
    components: { ReLogin },
    data: () => ({
        dialog_relogin: false,

        items: [
            { text: "Perfil", icon: "mdi-account" },
            { text: "Salir", icon: "mdi-power" },
        ],
        selectedMenu: null,
        focus: false,
        blur: false,
        session: true,
    }),
    computed: {
        user() {
            return this.$page.props.auth.user;
        },
    },
    methods: {
        SelectMenu(menu) {
            if (menu == "Perfil") {
                this.$inertia.get("/inventario/perfil");
            } else if (menu == "Configuracion") {

            } else if (menu == "Salir") {
                this.$inertia.post("/logout");
            }
        },
    },
    mounted() {
        window.addEventListener("focus", () => {
            this.focus = new Date();
            console.log("focus");
            if (!this.blur) return;
            let diff = this.focus - this.blur;
            diff = diff / 1000 / 60;
            console.log(diff);
            if (diff > 60) {
                this.session = false;
                this.dialog_relogin = true;
                //comprobar si hay sesion activa
                //mostrar ReLogin
            }
        });
        window.addEventListener("blur", () => {
            this.blur = new Date();
            console.log("salio: " + this.blur);
        });
    },
};
</script>

<style>

.main-wrapper {
    background-color: #eaeaea;
}

.v-btn:not(.v-btn--round).v-size--default {
    height: 40px;
    min-width: 64px;
    padding: 0 16px;
}

.v-messages {
    flex: 1 1 auto;
    font-size: 10px;
    height: 12px;
    min-width: 1px;
    position: relative;
}

.v-text-field__details {
    display: flex;
    flex: 1 0 auto;
    max-width: 100%;
    max-height: 12px;
    overflow: hidden;
}

.v-text-field.v-text-field--enclosed .v-text-field__details {
    padding-top: 0;
    margin-bottom: 0px;
}



.v-text-field .v-input__control,
.v-text-field .v-input__slot,
.v-text-field fieldset {
    border-radius: 0.375rem;
}
</style>
