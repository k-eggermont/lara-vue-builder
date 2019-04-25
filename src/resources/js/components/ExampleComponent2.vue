<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component2</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                    <component></component>
                    <portal to="destination-name">
                        <a href="#" v-on:click.prevent="updateString('Yellowww')">HELLOOO {{ test }}</a>
                    </portal>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() { return {
            test:"ok"
        }},

        methods: {
            updateString: function(str) {
                this.test = str;
            }
        }
    }
</script>
