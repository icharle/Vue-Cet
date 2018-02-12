import Vue from 'vue'
import Router from 'vue-router'
import check from '../components/check/check.vue'

Vue.use(Router)


export default new Router({
    routes: [
        {
            path: '/check',
            component: check
        }
    ]
})