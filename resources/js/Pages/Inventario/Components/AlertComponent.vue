<template>
    <div class="text-center ma-2">
        <v-snackbar v-model="show" :color="type_alert">
            {{ msg_alert }}
            <template v-slot:action="{ attrs }">
                <v-btn dark icon v-bind="attrs" @click="show = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </template>
        </v-snackbar>
    </div>
</template>

<script>
export default {
    props: {
        show_alert: Boolean,
        type_alert: {
            type: String,
            default: "success",
        },
        msg_alert: String,
    },
    data: () => ({
        text: `Hello, I'm a snackbar`,
    }),
    computed: {
        show: {
            // getter
            get: function () {
                return this.show_alert;
            },
            // setter
            set: function (newValue) {
                
                this.$emit("setAlert", newValue);
               // return newValue;
          
            },
        },
    },
};
</script>
