<template>
    <v-autocomplete
        v-model="v_model"
        :items="items"
        :label="label"
        :item-text="item_text"
        :item-value="item_value"
        :disabled="disabled"
        :rules="rules"

        clearable
        dense
        required
        outlined
        class="mt-0 pt-0"
    ></v-autocomplete>
</template>
<script>
export default {
    props: {
        value: Number,
        items: {
            required: true,
            default: [],
            type: Array,
        },
        label: {
            required: true,
            type: String,
        },
        item_text: {
            required: true,
            type: String,
        },
        item_value: {
            required: true,
            type: String,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        rules:{},
    },
    data: () => ({

    }),
    computed: {
        v_model: {
            get() {
                return this.value;
            },
            set(newValue) {
                this.$emit("input", newValue);
            },
        },
    },
};
</script>
