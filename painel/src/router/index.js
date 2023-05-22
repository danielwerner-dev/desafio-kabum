import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import CadCliente from '../components/CadCliente'
import Dashboard from '../components/Dashboard'
import KListaCliente from '../components/KListaCliente'
import Login from '../components/Login'
import LocalStorage from '../utils/LocalStorage'


const router = new Router({
  mode: 'history',
  routes: [
    {
      path: "/",
      name: "login",
      component: Login
    },
    {
      path: "/painel",
      name: "painel",
      component: Dashboard,
      meta: {
        requiresAuth: true
      },
      children: [
        {
          path: '/ListaCliente',
          name: 'ListaCliente',
          component: KListaCliente,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/cadClientes',
          name: 'cadClientes',
          component: CadCliente,
          meta: {
            requiresAuth: true
          }
        }
      ]
    }
  ]
})


router.beforeEach((to, routeFrom, next) => {
  const data = LocalStorage.get("SESSION_KABUM") || {token: ''};
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

  if(requiresAuth && !data.token) {
    next('/');
  } else if(requiresAuth && data.token) {
    next();
  } else {
    next();
  }
})


export default router
