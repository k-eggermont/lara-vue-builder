<template>

    <!--  :class="'form-group '+field.name+'_field '+field.name+'_field_'+resource" :class="{ 'error': isError }"   -->
    <div  :class="[{ 'form-group error': isError }, 'form-group']" :id="'field_'+field.field">

        <label :for="field.field+'_form_'+resource">
            {{ field.name }}
        </label>

        <flat-pickr
                v-model="date"
                :config="config"
                class="form-control"
                placeholder="Select date"
                name="date">
        </flat-pickr>

        <div class="form-error" v-if="error.length > 0">
            {{ error[0] }}
        </div>
    </div>
</template>
<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    export default {

    components: {
        flatPickr
    },
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

        watch: {

            date: function() {
                this.$emit("input",this.date);
            },


        },
        mounted() {
            if(typeof this.field.displayDateFormat != "undefined" && this.field.displayDateFormat != null && this.field.displayDateFormat) {
                this.config.altFormat = this.field.displayDateFormat;
            }
            if(typeof this.field.enableTime != "undefined" && this.field.enableTime != null) {
                this.config.enableTime = this.field.enableTime;
            }
            if(typeof this.field.minDate != "undefined" && this.field.minDate != null) {
                this.config.minDate = this.field.minDate;
            }
            if(typeof this.field.maxDate != "undefined" && this.field.maxDate != null) {
                this.config.maxDate = this.field.maxDate;
            }
            if(typeof this.field.defaultDate != "undefined" && this.field.defaultDate != null) {
                this.config.defaultDate = this.field.defaultDate;
            }


        },

        data() { return {
            date: null,
            name: null,

            props: {},

            config: {
                wrap: true,
                altFormat: 'd-m-Y H:i',
                altInput: true,
                dateFormat: 'Y-m-d H:i',
                time_24hr: true
            },
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
