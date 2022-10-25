<template>
    <v-app>
        <v-main class="main-login">
            <div class="container-logo">
                <img width="200" class="mx-auto " src="/images/logomin.png" alt="">
            </div>
            <v-card class="mx-auto elevation-10" max-width="400">
            

                <v-card-subtitle class="pb-2">
                    Restablecer la contraseña
                </v-card-subtitle>

                <v-divider></v-divider>

                <v-alert
                    v-if="show_mensaje"
                    class="rounded-0 my-1"
                    dense
                    text
                    :type="type_mensaje"
                >
                    <small> {{ mensaje }} </small>
                </v-alert>

                <v-form
                    class="px-5 py-4"
                    ref="form"
                    v-model="valid"
                    lazy-validation
                >
                    <v-text-field
                        v-model="email"
                        :rules="[rules.required, rules.email]"
                        label="Correo Electronico"
                        required
                        dense
                        outlined
                    ></v-text-field>

        
                    <v-btn
                        :disabled="!valid"
                        color="primary"
                        class="mt-1"
                        block
                        :loading="loading_btn"
                        @click="IngresarSistema"
                    >
                        Enviar Correo
                    </v-btn>
                </v-form>
            </v-card>
        </v-main>
    </v-app>
</template>

<script>
export default {
    metaInfo: { title: "Login" },
    data: () => ({
        loading_btn: false,
        show_password: false,
        email: "",
        valid: true,

        show_mensaje: false,
        type_mensaje: "success",
        mensaje: "",
        rules: {
            required: (value) => !!value || "Requerido.",
            min: (v) => v.length >= 4 || "Min 6 caracteres",
            email: (v) => /.+@.+\..+/.test(v) || "Formato incorrecto",
        },
    }),

    methods: {
        validate() {
            return this.$refs.form.validate();
        },
        async IngresarSistema() {
            if (this.validate()) {
                try {
                    this.loading_btn = true;
                    let res = await axios.post("/sent-email", {
                        email: this.email,
                        password: this.password,
                    });
                    this.show_mensaje = true;
                    this.mensaje = res.data.mensaje;
                    this.loading_btn = false;


                } catch (error) {
                    this.type_mensaje = "error";
                    this.mensaje = error.response.data.error;
                    this.show_mensaje = true;
                    this.loading_btn = false;
                    console.log(error);
                }
            }
        },
    },
};
</script>
<style>
.main-login {
    background-color: whitesmoke;
    align-items: center;
}
.container-logo{
    display: flex;
    width: 100%;
    justify-content: center;
}
</style>
