<template>
    <div :class="className">
        <template v-if="displayError">
            The resource could not be found.
        </template>
        <loader v-else-if="loading"></loader>
        <template v-else>

            <slot name="form-header"></slot>

            <div class="-medium" :class="messageClass" v-if="message">{{ message }}</div>
            <form @submit.prevent="onSubmit" @keydown="clearError" @change="clearError" class="form-vue">
                <template v-for="(field,key) in fields">
                    <component :is="field.vueComponent" :name="form[field.field]+'_'+key" v-model="form[field.field]" :resource="resource" :resourceId="resourceId" :field="field" :isError="form.errors.has(field.field)" :error="form.errors.get(field.field)"></component>
                </template>

                <slot name="form-footer"></slot>


                <div class="form-footer">

                    <slot name="before-button"></slot>
                    <progress-button
                            dusk="update-button"
                            type="submit"
                            :disabled="isSubmitted"
                            :processing="isSubmitted"
                    >
                        <slot name="submit-text">Submit</slot>
                    </progress-button>
                </div>


            </form>

            <slot name="form-after"></slot>

        </template>
    </div>
</template>

<script>
    import Form from 'form-backend-validation';
    export default {
        props: {
            params: {
                type: Object,
                required: false,
                default: () => { return {}; }
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
        /*      [
              "resource", "resourceId", "reset-on-submit"
          ],*/
        data() {
            return {
                fields: [],
                form: {},
                displayError: false,
                loading:true,
                message: '',
                messageClass: '',
                isSubmitted: false
            }
        }
        ,

        watch: {

            resourceId: function() {
                this.getData();
            },

            'form.processing': function() {


                for(var i in this.params) {
                    //console.log(this.form.has(i));
                    console.log("processing", );
                    if(this.form.errors.has(i)) {
                        MessageEvent.$message({
                            message: i+" : "+this.form.errors.get(i)[0],
                            type: "error",
                            showClose: true
                        })
                    }
                }

            }


        },

        computed: {
            resetForm: function() {
                if(this.resetOnSubmit !== null) {
                    return this.resetOnSubmit;
                }
                if(this.resourceId > 0) return true;
                return false
            },
            url: function() {
                if(this.resourceId) {
                    return "/api/forms/"+this.resource+"/"+this.resourceId
                } else {
                    return "/api/forms/"+this.resource
                }
            },
            argsFields: function() {
                if(this.resourceId) {
                    return "?state=updating";
                } else {
                    return "?state=creating";
                }
            }
        },

        created() {

            this.getData();
        },
        mounted() {

            if(typeof Bus != "undefined") {
                Bus.$on("resources." + this.resource + ".updated", (data) => {
                    if(this.resourceId == data.resourceId) {
                        this.getData();
                    }
                })
            }

        },

        methods: {

            clearError(e) {
                this.form.errors.clear(e.target.name);
            },
            getData(displayError = true) {
                this.loading = true;
                axios.get(this.url+"/fields"+this.argsFields).then((data) => {
                    this.loading = false;
                    this.fields.splice(0,this.fields.length);
                    var tmpFields = {};
                    for(var i in data.data) {
                        this.fields.push(data.data[i])
                        tmpFields[data.data[i].field] = data.data[i].value;
                    }

                    // Add params fields
                    for(var i in this.params) {
                        tmpFields[i] = this.params[i];
                    }

                    this.form = new Form(tmpFields,
                        {
                            resetOnSuccess: this.resetForm,
                        });
                }).catch((error) => {

                    this.displayError = true;
                    this.loading = false;
                    if(displayError) {
                        var status = error.response.status
                        MessageEvent.sendMessage({
                            http_code: status,
                        })
                    }

                })
            },
            onSubmit() {
                this.isSubmitted = true;
                this.form.post(this.url)
                    .then((response) => {
                        if(typeof Bus != "undefined") {
                            Bus.$emit("resources."+this.resource+".updated",response.model)
                        }
                        this.$message({
                            message: "Your project was created",
                            type: "success",
                            showClose: true
                        })
                        this.isSubmitted = false;
                    })
                    .catch((error) => {
                        var status = error.response.status
                        this.isSubmitted = false;

                        MessageEvent.sendMessage({
                            http_code: status,
                        })


                    });
            },

            displaySuccessMessage(message) {
                this.messageClass = 'alert--success';
                this.message = message;
            },

            displayErrorMessage(message) {
                this.messageClass = 'alert--error';
                this.message = message;
            },

            clearMessage() {
                this.message = '';
            },
        }
    }
</script>
