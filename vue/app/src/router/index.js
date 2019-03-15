import Vue from 'vue'
import Router from 'vue-router'
import UserMailView from '@/components/UserMailView'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'UserMailView',
      component: UserMailView
    }
  ]
})
