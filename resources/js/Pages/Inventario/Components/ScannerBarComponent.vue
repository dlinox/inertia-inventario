<template>
    <v-dialog scrollable  v-model="dialog" width="500">
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                class="mr-sm-2 order-sm-1 mb-2 mb-sm-0 mr-2"
                dark
                color="primary"
                v-bind="attrs"
                v-on="on"
            >
                <v-icon>mdi-barcode-scan</v-icon>
            </v-btn>
        </template>
        <v-card tile>
            <v-overlay absolute :value="loading">
                <v-progress-circular
                    indeterminate
                    size="64"
                ></v-progress-circular>
            </v-overlay>
            <v-card-title class="text-h6 grey lighten-2">
                Escanear codigo
            </v-card-title>

            <v-divider></v-divider>

            <v-card-text class="pa-3">
                <template v-if="loading_camera">
                    <div class="text-center">
                        <v-progress-circular
                            indeterminate
                            color="primary"
                        ></v-progress-circular>
                    </div>
                </template>

                <StreamBarcodeReader
                    v-if="dialog"
                    @decode="onDecode"
                    @loaded="onLoaded"
                ></StreamBarcodeReader>
                <div class="respuesta-codigo">
                   

                    <h3> {{ scanner_res }}</h3>

                    <v-alert v-if="error" text  type="error" icon="mdi-cloud-alert">
                        {{ text_error }}
                    </v-alert>
                </div>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" text @click="dialog = false">
                    <v-icon left>mdi-close</v-icon>
                    Cerrar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
import { StreamBarcodeReader } from "vue-barcode-reader";

export default {
    components: {
        StreamBarcodeReader,
    },
    data: () => ({
        dialog: false,
        loading_camera: true,
        scanner_res: "",
        loading: false,
        error: false,
        text_error: "",
    }),
    methods: {
        async onDecode(codigo) {
            this.error = false;
            this.text_error = '';

            this.scanner_res = codigo;
            this.loading = true;
            let res = await axios.get("/autocomplete/bienes/" + codigo);

            if (res.data.estado) {
                let item = res.data.datos[0];
                item.registrado = item.registrado == 1 ? true : false;
                this.$emit("setData", item);
                this.dialog = false;
            } else {
                this.error = true;
                this.text_error = res.data.mensaje;
            }

            this.loading = false;
        },

        onLoaded() {
            this.loading_camera = false;
        },
    },
};
</script>

<style>
.overlay-element {
    clip-path: polygon(
        0% 0%,
        0% 100%,
        10% 100%,
        10% 20%,
        90% 20%,
        90% 80%,
        10% 80%,
        9% 100%,
        100% 100%,
        100% 0%
    ) !important;
}
.respuesta-codigo {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    padding: 1rem;
}
.respuesta-codigo h3{
    width: 100%;
    text-align: center;
}
</style>
