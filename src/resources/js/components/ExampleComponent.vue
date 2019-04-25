<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>

                    <portal-target name="destination-name">
                        <!-- The contents of the portal component will appear here -->
                    </portal-target>
                </div>
            </div>
            TEST:
            <template :v-html="testx"></template>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() { return {
            testx: "<example-component2></example-component2>"
        }}
    }
</script>
