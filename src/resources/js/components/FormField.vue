<script>
    import FormFieldMixin from '../components/Mixins/FormFieldMixin'
    export default {

        mixins: [FormFieldMixin],
        props: {
            resource: {
                type: String,
                required: true
            },
            resourceId: {
                type: Number,
                required: false,
                default: null,
            },
            resetOnSubmit: {
                type: Boolean,
                required: false,
                default: false,
            },
            className: {
                type: String,
                required: false,
                default: "",
            },
        },

    }
</script>
