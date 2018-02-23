import Vue from 'vue'
import Router from 'vue-router'
import ticket from '../components/ticket/ticket.vue'
import detail from '../components/detail/detail.vue'
import query from '../components/query/query.vue'
import reserve from '../components/reserve/reserve.vue'

Vue.use(Router)


export default new Router({
    mode: 'history',
    linkActiveClass: 'active',
    routes: [
        {
            path: '/',
            redirect: '/ticket'
        },
        {
            path: '/ticket',
            meta:{index:0},
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
            meta:{index:1},
            component: query
        },
        {
            path: '/reserve',
            meta:{index:-1},
            component: reserve
        }
    ]
})