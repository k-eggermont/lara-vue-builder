<template>
    <div>
        <template v-for="row in data.data">
            <h3>{{ row.titre }} <router-link :to="'/test/'+row.id">Edit</router-link>
            <delete-link :resource="resource" :resource-id="row.id"></delete-link>
            </h3>

        </template>
    </div>
</template>

<script>
    export default {
        props: {
            resource: {
                type: String,
                required: true
            },
        },
        data() {
            return {
                data: {}
            }
        }
        ,

        computed: {
            url: function() {
                    return "/api/forms/"+this.resource
            }
        },

        created() {
            this.getResourceData();
        },
        mounted() {
            if(typeof Bus != "undefined") {
                Bus.$on("resources." + this.resource + ".updated", (id) => {
                    this.getResourceData();
                })
            }
        },
        methods: {
            getResourceData()  {
                axios.get(this.url).then((data) => {
                    this.data = Object.assign({}, this.data, data.data);
                })
            }
        }
    }
</script>
