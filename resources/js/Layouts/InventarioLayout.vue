<template>
    <v-app class="app-wrapper">
        <v-app-bar color="white" app>


            <v-btn text color="primary" @click="irConciliacion">
                Conciliacion
            </v-btn>

            <v-spacer />

            <v-menu offset-y>
                <template v-slot:activator="{ attrs, on }">
                    <v-btn text color="primary" class="" v-bind="attrs" v-on="on">
                        {{ user.nombres }}
                        <v-icon right>mdi-account </v-icon>
                    </v-btn>
                </template>

                <v-list dense>
                    <v-subheader>Opciones</v-subheader>
                    <v-list-item-group v-model="selectedMenu" color="primary">
                        <v-list-item v-for="(item, i) in items" :key="i" @click="SelectMenu(item.text)">

                            <v-list-item-icon>
                                <v-icon v-text="item.icon"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="item.text"></v-list-item-title>
                            </v-list-item-content>

                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-menu>
        </v-app-bar>

        <v-main class="main-wrapper">
            <slot />
        </v-main>

        <!-- <ReLogin :user="user"  :dialog="dialog_relogin"  @dialog="dialog_relogin = $event" />-->

        <v-dialog v-model="dialog_change_pass" persistent :overlay="false" max-width="400px">
            <v-card>
                <v-card-title class="text-h6">
                    Cambiar contraseña
                </v-card-title>

                <v-form class="px-5 py-4" ref="form" v-model="valid" lazy-validation>
                    <v-text-field v-model="password" :append-icon="show_password ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.required, rules.min]" :type="show_password ? 'text' : 'password'"
                        label="Nueva Contraseña" counter @click:append="show_password = !show_password"></v-text-field>

                    <v-btn :disabled="!valid" color="primary" class="mt-1" block :loading="loading_btn"
                        @click="ChangePassword()">
                        Guardar Contraseña
                    </v-btn>
                </v-form>
            </v-card>
        </v-dialog>
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
            { text: "Cargos", icon: "mdi-file-document", to: "url" },
            { text: "Salir", icon: "mdi-power" },
        ],
        selectedMenu: null,
        focus: false,
        blur: false,
        session: true,

        //cambair contraseña
        dialog_change_pass: false,
        show_password: false,
        password: "",
        valid: true,
        loading_btn: false,

        rules: {
            required: (value) => !!value || "Requerido.",
            min: (v) => v.length >= 4 || "Min 4 caracteres",
        },
        //cambair contraseña
    }),
    computed: {
        user() {
            return this.$page.props.auth.user;
        },
    },
    async created() {
        this.dialog_change_pass = !this.user.estado_password;
    },
    methods: {
        async ChangePassword() {
            if (this.$refs.form.validate()) {
                try {
                    this.loading_btn = true;
                    let res = await axios.post("/inventario/update-password", {
                        password: this.password,
                    });

                    this.dialog_change_pass = false;
                    this.loading_btn = false;
                } catch (error) {

                    this.loading_btn = false;
                }
            }
        },
        SelectMenu(menu) {
            if (menu == "Perfil") {
                this.$inertia.get("/inventario/perfil");
            } else if (menu == "Cargos") {
                this.$inertia.get("/inventario/cargos")
            } else if (menu == "Salir") {
                this.$inertia.post("/logout");
            }
        },
        irConciliacion() {
            this.$inertia.get("/inventario/conciliacion");
        }
    },
};
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&display=swap");

.main-wrapper {
    font-family: "Nunito", sans-serif;
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