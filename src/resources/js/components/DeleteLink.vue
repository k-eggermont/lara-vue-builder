<template>
    <a href="#" v-on:click.prevent="onDelete()">Delete</a>
</template>
<script>
    export default {
        props: {
            resource: {
                type: String,
                required: true
            },
            resourceId: {
                type: Number,
                required: true,
            },
        },
        /*      [
              "resource", "resourceId", "reset-on-submit"
          ],*/
        data() {
            return {
                loading: false,
            }
        }
        ,

        computed: {
            url: function () {
                if (this.resource && this.resourceId) {
                    return "/api/forms/" + this.resource + "/" + this.resourceId
                }
                return false
            },
        },

        created() {
        },
        mounted() {
        },
        methods: {
            onDelete() {
                if(!this.url) {
                    MessageEvent.sendMessage({
                        message: "Resource id or resource was not set",
                        type: "error",
                        showClose: true
                    });
                } else {



                    this.$swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        console.log(result.value);
                        if (result.value) {


                                axios.delete(this.url).then((data) => {
                                    this.loading = false;
                                }).catch((error) => {
                                    var status = error.response.status
                                    if (typeof vueFormMessages.httpCode[status] != "undefined") {
                                        MessageEvent.sendMessage({
                                            message: vueFormMessages.httpCode[status],
                                            type: "error",
                                            showClose: true
                                        })
                                    } else {
                                        MessageEvent.sendMessage({
                                            message: "Internal error",
                                            type: "error",
                                            showClose: true
                                        })
                                    }

                                })

                                Bus.$emit("resources." + this.resource + ".updated", {resourceId: this.resourceId });


                        }
                    })
                }
            }
        }
    }
</script>

