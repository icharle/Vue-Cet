import Vue from 'vue'
import Router from 'vue-router'
import ticket from '../components/ticket/ticket.vue'
import detail from '../components/detail/detail.vue'
import query from '../components/query/query.vue'
import reserve from '../components/reserve/reserve.vue'

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
        },
        {
            path: '/query',
            component: query
        },
        {
            path: '/reserve',
            component: reserve
        }
    ]
})