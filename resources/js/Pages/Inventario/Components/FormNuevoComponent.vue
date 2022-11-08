<template>
    <v-dialog v-model="dialog" fullscreen scrollable>
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                class="order-sm-4"
                dark
                outlined
                color="primary"
                v-bind="attrs"
                v-on="on"
            >
                <v-icon>mdi-plus</v-icon>
            </v-btn>
        </template>

        <v-card tile>
            <v-toolbar>
                <v-app-bar-nav-icon @click="dialog = false">
                    <v-icon>mdi-arrow-left</v-icon>
                </v-app-bar-nav-icon>

                <v-toolbar-title>Registrar Nuevo Bien</v-toolbar-title>
            </v-toolbar>

            <v-card-text style="height: 90vh"> </v-card-text>
            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary">
                    <v-icon left>mdi-check</v-icon> Guardar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props: {},
    data: () => ({
        dialog: false,
    }),
    methods: {},

    watch: {},
};
</script>
