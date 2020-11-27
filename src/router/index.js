import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    redirect: { name: 'Home' }
  },
  {
    path: '/home',
    name: 'Home',
    component: () => import('../views/Home'),
    meta: {
      title: 'BOCS',
      metaTags: {

      }
    }
  },
  {
    path: '/users',
    name: 'Users',
    component: () => import('../views/Accounts'),
    meta: {
      title: 'Manage Accounts',
      metaTags: {

      }
    }
  },
  {
    path: '/departments',
    name: 'Departments',
    component: () => import('../views/Departments'),
    meta: {
      title: 'Departments',
      metaTags: {

      }
    }
  },
  {
    path: '/agencies',
    name: 'Agencies',
    component: () => import('../views/Agencies'),
    meta: {
      title: 'Agencies',
      metaTags: {

      }
    }
  },
  {
    path: '/advertisers',
    name: 'Advertisers',
    component: () => import('../views/Advertisers'),
    meta: {
      title: 'Advertisers',
      metaTags: {

      }
    }
  },
  {
    path: '/contracts',
    name: 'Contracts',
    component: () => import('../views/Contracts'),
    meta: {
      title: 'Contracts',
      metaTags: {

      }
    }
  },
  {
    path: '/sales',
    name: 'Sales',
    component: () => import('../views/Sales'),
    meta: {
      title: 'Sales',
      metaTags: {

      }
    }
  },
  {
    path: '/archives',
    name: 'Archives',
    component: () => import('../views/Archives'),
    meta: {
      title: 'Archives',
      metaTags: {

      }
    }
  },
  {
    path: '/logs',
    name: 'Logs',
    component: () => import('../views/Logs'),
    meta: {
      title: 'Logs',
      metaTags: {

      }
    }
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
});

router.beforeEach((to, from, next) => {
  document.title = to.meta.title;

  next()
});


export default router
