import { createRouter, createWebHistory } from 'vue-router'; // Certifique-se de estar importando corretamente para Vue 3
import Login from './components/Login.vue';
import Products from './components/admin/ListProducts.vue';
import ImportProducts from './components/admin/ImportProducts.vue';
import Catalog from './components/Catalog.vue';
import Categories from './components/admin/Categories.vue';
import Brands from './components/admin/Brands.vue';
import Orders from './components/admin/Orders.vue';

// Defina suas rotas
const routes = [
  { path: '/login', component: Login },
  { path: '/products', component: Products, meta: { requiresAuth: true } },
  { path: '/categories', component: Categories, meta: { requiresAuth: true } },
  { path: '/brands', component: Brands, meta: { requiresAuth: true } },
  { path: '/products/import', component: ImportProducts, meta: { requiresAuth: true } },
  { path: '/orders', component: Orders, meta: { requiresAuth: true } },
  { path: '/', component: Catalog, meta: { requiresAuth: false } }

];

// Crie o roteador usando o modo de histórico da web (sem hash)
const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;