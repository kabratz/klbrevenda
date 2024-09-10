import { createRouter, createWebHistory } from 'vue-router'; // Certifique-se de estar importando corretamente para Vue 3
import Login from './components/Login.vue';
import Products from './components/admin/ListProducts.vue';
import ImportProducts from './components/admin/ImportProducts.vue';
import Catalog from './components/Catalog.vue';

// Defina suas rotas
const routes = [
  { path: '/login', component: Login },
  { path: '/products', component: Products, meta: { requiresAuth: true } },
  { path: '/products/import', component: ImportProducts, meta: { requiresAuth: true } },
  { path: '/catalog', component: Catalog, meta: { requiresAuth: false } }
];

// Crie o roteador usando o modo de histórico da web (sem hash)
const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;