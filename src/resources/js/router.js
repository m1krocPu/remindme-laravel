
import { createRouter, createWebHistory } from 'vue-router'
import auth from './middleware/auth';
import middlewarePipeline from './middleware/middlewarePipeline';

import Reminder from './components/Reminder.vue'
import Login from './components/Login.vue'

const router = new createRouter({ 
    history: createWebHistory(),    
    routes:  [
        {
            path: '/',
            name: 'home', 
            meta: {
                middleware: [ auth ]
            },
            component: Reminder
        },
        {
            path: '/login',
            name: 'login', 
            component: Login
        },
    ] 
})

router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) {
        return next()
    }
 
    const middleware = to.meta.middleware;
    const context = {
      to,
      from,
      next,
    }
 
    return middleware[0]({
        ...context,
        next:middlewarePipeline(context, middleware,1)
    })
  })
export default router