<template>
    <div class="form-group" :class="{ 'error': isError }">
        <label v-for="(valueField,key) in field.options">
            <input type="checkbox" v-model="inputData" :value="key" @change="updateField()" >
            {{ valueField }}
        </label>
        <div class="form-error" v-if="error.length > 0">
            {{ error[0] }}
        </div>
    </div>
</template>
<script>
    export default {

        props: ["field", "error", "isError"],
        mounted() {
        },

        data() { return {
            //value: null,
            name: null,
            inputData: [],
            props: {}
        }},

        methods: {
            updateField()  {
                this.$emit('input',this.inputData)
            }
        }
    }
</script>
