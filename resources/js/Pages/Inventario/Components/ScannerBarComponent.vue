<template>
    <v-dialog v-model="dialog" width="500">
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
        <v-card>
            <v-card-title class="text-h6 grey lighten-2">
                Escanear codigo
            </v-card-title>

            <v-divider></v-divider>

            <div class="pa-3">
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
                {{scanner_res}}
            </div>


            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" text @click="dialog = false"> 
                    
                <v-icon left>mdi-close</v-icon>    
                Cerrar </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
import { StreamBarcodeReader } from "vue-barcode-reader";
import { getBienKByCodigo } from "@/Helpers/ConsultasHelper";

export default {
    components: {
        StreamBarcodeReader,
    },
    data: () => ({
        dialog: false,
        loading_camera: true,
        scanner_res: '',
    }),
    methods: {
        async onDecode(codigo) {

            this.scanner_res = codigo;
            let res = await axios.get("/autocomplete/bienes/" + codigo);
            let item = res.data.datos[0];
            item.registrado = item.registrado == 1 ? true : false;
            this.$emit("setData", item);
            this.dialog = false;
        },

        onLoaded() {
            this.loading_camera = false;
        },
    },
};
</script>

<style>
.overlay-element{
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

</style>