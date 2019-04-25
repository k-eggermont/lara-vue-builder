<template>
    <label for="" :class="{ error: isError }" style="display:block">
        {{ field.name }}
        <select :value="$parent.form[field.name]" @input="updateField($event.target.value)">
            <option v-for="(value,key) in field.options" :value="key">{{ value }}</option>
        </select>
    </label>
</template>
<style type="text/css">
    .error { border:1px solid red; }
</style>
<script>
    export default {

        props: ["field", "error", "isError"],
        mounted() {
            //this.attribute = this.field;
            //this.value = this.field.value;
        },

        data() { return {
            //value: null,
            name: null,
            props: {}
        }},

        methods: {
            updateField(data)  {
                this.$emit('input',data)
            }
        }
    }
</script>
