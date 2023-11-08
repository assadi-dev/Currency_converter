

import { createRouter, createWebHistory } from 'vue-router'
import HomeViewVue from '../views/HomeView.vue'
import HomeAdminViewVue from '../views/Admin/HomeAdminView.vue'
import LoginVue from '../views/Authentication/Login.vue'
import AdminLayoutVue from '../views/Admin/AdminLayout.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeViewVue
    },
    {
      path: '/admin',
      component:AdminLayoutVue ,
      children: [
        {
              path: '/admin/login',
              name: 'admin-login',
              component: LoginVue
        },
        {
          path: '/admin',
          name: 'dashboard',
          component: HomeAdminViewVue,
          children: [
            {
              path: '/admin/home',
              name: 'admin-home',
              component: LoginVue
            },
            {
              path: '/admin/currency',
              name: 'admin-currency',
              component: LoginVue
            },
            {
              path: '/admin/currency-pairs',
              name: 'admin-currency-pairs',
              component: LoginVue
            },
          ]
        },
      ]
    }


  ]
})




export default router
