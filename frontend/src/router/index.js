import { h, resolveComponent } from 'vue'
import { createRouter, createWebHashHistory } from 'vue-router'

import DefaultLayout from '@/layouts/DefaultLayout'

const routes = [
  {
    path: '/',
    name: 'Index',
    component: () => import('@/views/system/Index.vue'),
    meta: {
      requiresAuth: false,
    },
  },
  {
    path: '/view/:bookId',
    name: 'HomeViewBook',
    component: () => import('@/views/system/ViewProduct.vue'),
    meta: {
      requiresAuth: false,
    },
  },
  {
    path: '/home',
    name: 'Home',
    component: DefaultLayout,
    redirect: '/books',
    children: [
      {
        path: '/books',
        name: 'Dashboard',
        component: () => import('@/views/Dashboard.vue'),
        meta: {
          requiresAuth: false,
        },
      },
      {
        path: '/books/view/:bookId',
        name: 'View Book',
        component: () => import('@/views/books/ViewBook.vue'),
        meta: {
          requiresAuth: false,
        },
      },
      {
        path: '/books/book',
        name: 'Book',
        component: () => import('@/views/books/Book.vue'),
        meta: {
          requiresAuth: false,
        },
      },
      {
        path: '/books/edit/:bookId?',
        name: 'Edit Book',
        component: () => import('@/views/books/Book.vue'),
        meta: {
          requiresAuth: false,
        },
      },
    ],
  },
  {
    path: '/pages',
    redirect: '/pages/404',
    name: 'Pages',
    component: {
      render() {
        return h(resolveComponent('router-view'))
      },
    },
    children: [
      {
        path: '404',
        name: 'Page404',
        component: () => import('@/views/pages/Page404'),
      },
      {
        path: '500',
        name: 'Page500',
        component: () => import('@/views/pages/Page500'),
      },
      {
        path: '/login',
        name: 'Login',
        component: () => import('@/views/pages/Login'),
      },
      {
        path: 'register',
        name: 'Register',
        component: () => import('@/views/pages/Register'),
      },
    ],
  },
  {
    path: '/products',
    name: 'Products',
    component: () => import('@/views/Products.vue'),
    meta: {
      requiresAuth: false,
    },
  },
]

const router = createRouter({
  history: createWebHashHistory(process.env.BASE_URL),
  routes,
  scrollBehavior() {
    // always scroll to top
    return { top: 0 }
  },
})

// router.beforeEach((to, from, next) => {
//   if (to.matched.some((record) => record.meta.requiresAuth)) {
//     if (!localStorage.getItem('token')) {
//       next({
//         path: '/login',
//       })

//       return
//     }
//   }

//   if (to.name === 'Login' && localStorage.getItem('token')) {
//     next({
//       name: from.name,
//     })
//   }

//   next()
// })

export default router
