

import { createRouter, createWebHistory } from 'vue-router'
import HomeViewVue from '../views/HomeView.vue'
import HomeAdminViewVue from '../views/Admin/HomeAdminView.vue'
import LoginVue from '../views/Authentication/Login.vue'
import AdminLayoutVue from '../views/Admin/AdminLayout.vue'
import DashboardViewVue from '../views/Admin/DashboardView/DashboardView.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeViewVue
    },
    {
      path: '/admin/login',
      name: 'admin-login',
      component: LoginVue
},
    {
      path: '/admin',
          name: 'dashboard',
      component:AdminLayoutVue,
      children: [

        {
          path: '',
          component: HomeAdminViewVue,
          children: [
            {
              path: '',
              component: DashboardViewVue
            },
            {
              path: 'currency',
              name: 'admin-currency',
              component: LoginVue
            },
            {
              path: 'currency-pairs',
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
