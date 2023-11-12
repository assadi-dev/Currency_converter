

import { createRouter, createWebHistory } from 'vue-router'
import HomeViewVue from '../views/HomeView/HomeView.vue'
import HomeAdminViewVue from '../views/Admin/HomeAdminView.vue'
import LoginVue from '../views/Authentication/Login.vue'
import AdminLayoutVue from '../views/Admin/AdminLayout.vue'
import DashboardViewVue from '../views/Admin/DashboardView/DashboardView.vue'
import CurrencyViewVue from '../views/Admin/CurrencyView/CurrencyView.vue'
import PairCurrencyViewVue from '../views/Admin/PairCurrencyView/PairCurrencyView.vue'


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
   
      component:AdminLayoutVue,
      children: [

        {
          path: '',
         
          component: HomeAdminViewVue,
          children: [
     
            {
              path: 'currencies',
              name: 'admin-currencies',
              component: CurrencyViewVue
            },
            {
              path: 'pair-currencies',
              name: 'admin-pair-currency',
              component: PairCurrencyViewVue
            },
          ]
        },
      ]
    }


  ]
})




export default router
