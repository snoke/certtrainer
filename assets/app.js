/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Vue from 'vue';
import App from './components/App';
import Base from './components/Base';

import  VueRouter from 'vue-router'
Vue.use(VueRouter)

var router = {  
    components: {Base},
    routes: [
        { 
                name: "app",
                path: '/app', 
                component:  App,
                props: true,
  
        }
    ]
};

router = new VueRouter(router);
new Vue({
    methods: {
      created() {
      },
    },
    el: '#app',
    render: h => h(Base),  router: router,
});