import { createRouter, createWebHistory } from 'vue-router';
import Home from '../components/Home.vue';
import ProductDetail from '../components/ProductDetail.vue';
import Cart from '../components/Cart.vue';
import Register from '../components/Register.vue';
import Login from '../components/Login.vue';
const routes = [
  { path: '/', name: 'Home', component: Home, meta: { requiresAuth: true } },
  { path: '/register', name: 'Register', component: Register },
  { path: '/login', name: 'Login', component: Login },
  { path: '/product/:id', name: 'ProductDetail', component: ProductDetail, meta: { requiresAuth: true } },
  { path: '/cart', name: 'Cart', component: Cart, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('api-token');
  const userRole = localStorage.getItem('user-role');

  if (to.meta.requiresAuth) {
    if (!token) {
      next('/login');
    } else {
      if (to.meta.role && to.meta.role !== userRole) {
        alert('Access Denied: Unauthorized Role');
        next('/login');
      } else {
        next();
      }
    }
  } else {
    next();
  }
});

export default router;

