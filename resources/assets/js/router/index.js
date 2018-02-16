import Vue from 'vue'
import Router from 'vue-router'
import ticket from '../components/ticket/ticket.vue'
import detail from '../components/detail/detail.vue'

Vue.use(Router)


export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: ticket
        },
        {
            path: '/ticket',
            component: ticket
        },
        {
            path: '/detail',
            name: 'detail',
            component: detail,
            props: true
        }
    ]
})