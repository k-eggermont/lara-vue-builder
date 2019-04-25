<template>
    <div class="form-group" :class="{ 'error': isError }">
        <label :for="field.name+'_form'">
            {{ field.name }}
        </label>
        <div class="relative">

            <select :name="field.name" :id="field.name+'_form'" :value="$parent.form[field.name]" @input="updateField($event.target.value)">
                <option v-for="(value,key) in field.options" :value="key">{{ value }}</option>
            </select>
            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <div class="form-error" v-if="error.length > 0">
            {{ error[0] }}
        </div>
    </div>
</template>
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
