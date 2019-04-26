<template>

    <!--  :class="'form-group '+field.name+'_field '+field.name+'_field_'+resource" :class="{ 'error': isError }"   -->
    <div  :class="[{ 'form-group error': isError }, 'form-group']" :id="'field_'+field.field">
        <label :for="field.field+'_form_'+resource">
            {{ field.name }}
        </label>

        <input type="number" :step="field.step" :id="field.field+'_form_'+resource" :name="field.field" :placeholder="field.placeholder" :value="$parent.form[field.field]" @input="updateField($event.target.value)" >
        <div class="form-error" v-if="error.length > 0">
            {{ error[0] }}
        </div>
    </div>
</template>
<script>
    export default {

        props: {
            field: {
                type: Object,
                required:true
            },
            error: {
                type:Array,
                required:false,
                default:[]
            },
            isError: {
                type: Boolean,
                required: false,
                default: false,
            },

            resource: {
                type: String,
                required: true
            },
            resourceId: {
                type: Number,
                required: false,
                default: null,
            },
        },
        mounted() {
            //this.attribute = this.field;
            //this.value = this.field.value;
        },

        data() { return {
            //value: null,
            name: null,
            props: {}
        }},

        computed: {
            firstError: function() {
                if(typeof this.error[0] != "undefined") return this.error[0];
                return false
            }
        },

        methods: {
            updateField(data)  {
                this.$emit('input',data)
            }
        }
    }
</script>
