<template>
    <label for="" :class="{ error: isError }" style="display:block">
        {{ field.name }}
        <input type="text" :value="$parent.form[field.name]" @input="updateField($event.target.value)" v-on:keyup.enter="$parent.onSubmit">
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
