
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
import Portal from 'vue2-portal';

import VueRouter from 'vue-router'
Vue.use(VueRouter)





/*
const router = new VueRouter({
    mode: 'history',
    //routes: require(`./routes/${Spark.is_prestataire ? 'prestataire' : 'client'}`),
    routes: [
        { name: 'demo',
            path: '/test',
            component: resolve => require(['./pages/test'], resolve) },
        { name: 'demo.view',
            path: '/test/:id(\\d+)',
            component: resolve => require(['./pages/test_view'], resolve) },

        {
            path: '*',
            redirect: '/app/demo'
        }
    ]
})*/
// 2. Define route components
const Home = { template: '<div>home</div>' }
const Foo = { template: '<div>foo</div>' }
const Bar = { template: '<div>bar</div>' }
const Unicode = { template: '<div>unicode</div>' }
const router = new VueRouter({
    mode: 'history',
    base: "/app",
    routes: [
        { path: '/', component: Home },
        { name: 'test',
            path: '/test',
            component: resolve => require(['./pages/test'], resolve) },

        { path: '/test/:id(\\d+)', component: resolve => require(['./pages/test_view'], resolve) },
        { path: '/bar', component: Bar },
        { path: '/é', component: Unicode }
    ]
})


import VueSweetalert2 from 'vue-sweetalert2';

Vue.use(VueSweetalert2);

Vue.use(Portal);
Vue.component('InputField', require('./components/Fields/Tailwind/InputField.vue').default);
Vue.component('SelectField', require('./components/Fields/Tailwind/SelectField.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('example-component2', require('./components/ExampleComponent2.vue').default);
Vue.component('loader', require('./components/Loader.vue').default);
Vue.component('progressButton', require('./components/ProgressButton').default);

Vue.component('FormField', require('./components/FormField.vue').default);
Vue.component('ResourcesIndex', require('./components/Resources/Index.vue').default);
Vue.component('DeleteLink', require('./components/DeleteLink.vue').default);

window.vueFormMessages = {

    httpCode: {
        "500": "An error occured. Please try later",
        "403": "Forbidden, you are not able to do this."
    }

}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
window.Bus = new Vue();

window.VueAjaxErrorMessages = {
    500: "Internal server error, please try later.",
    403: "This action was forbidden.",
    422: "Your form was not correctly filled."
}

window.MessageEvent = require('vue');
import Message from 'vue-m-message'
window.MessageEvent.use(Message)
window.MessageEvent = new Vue({
    methods: {
        sendMessage: function(options) {

            if(typeof options.http_code != "undefined") {
                if (typeof VueAjaxErrorMessages[options.http_code] != "undefined") {
                    var options = {
                        message: VueAjaxErrorMessages[options.http_code],
                        type: "error",
                        showClose: true
                    }
                } else {
                    var options = {
                        message: "Internal error.",
                        type: "error",
                        showClose: true
                    }
                }

            }
            this.$message(options);

        }
    }
});


const app = new Vue({
    router,
    el: '#app',
    data() {
        return {
            test:"example-component2",
            data: []
        }
    },
    mounted() {
        /*
        axios.get("/api/forms/test").then((data) => {
            this.data.splice(0,this.data.length);
            for(var i in data.data) {
                this.data.push(data.data[i])
            }
        })*/


    }
});
