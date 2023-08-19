import {createRouter, createWebHistory} from 'vue-router'

const routes =  [
    {
        path: '/',
        name: 'products.index',
        // route-level code-splitting
        // this generates a separate chunk (Register.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import('../views/Products/Index.vue')
    },
    {
        path: '/products/create',
        name: 'products.create',
        component: () => import('../views/Products/Create.vue')
    },
    {
        path: '/products/:id/edit',
        name: 'products.edit',
        component: () => import('../views/Products/Edit.vue'),
        props: true
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
}) 

export default router