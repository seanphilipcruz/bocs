import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    redirect: '/home'
  },
  {
    path: '/home',
    name: 'Home',
    component: () => import('../views/Home'),
  },
  {
    path: '/users',
    name: 'Users',
    component: () => import('../views/Accounts'),
  },
  {
    path: '/departments',
    name: 'Departments',
    component: () => import('../views/Departments'),
  },
  {
    path: '/contracts',
    name: 'Contracts',
    component: () => import('../views/Contracts'),
  },
  {
    path: '/sales',
    name: 'Sales',
    component: () => import('../views/Sales'),
  },
  {
    path: '/logs',
    name: 'Logs',
    component: () => import('../views/Logs'),
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
