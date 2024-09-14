<template>
  <header>
    <div class="container header-container">
      <!-- Logotipo -->
      <div class="logo">
        <a href="#">
          <img :src="`/logo.webp`" alt="logotipo" />
        </a>
      </div>

      <a href="/products" class="card-header">Produtos</a>
      <a href="/brands" class="card-header">Marcas</a>
      <a href="/categories" class="card-header">Categorias</a>
      <!-- Barra de Navegação -->
      <nav class="navbar">
        <p v-if="isLoggedIn" class="welcome-message">
          Bem-vindo(a) de volta, {{ username }}!
          <button @click="handleLogout" class="logout-button">Logout</button>
        </p>
        <p v-else class="login-message">Por favor, logue para acessar sua conta.</p>
      </nav>
    </div>
  </header>
</template>

<script>
import { computed } from "vue";
import { useRouter } from "vue-router";
import store from "../../../src/store.js";

export default {
  created() {
    if (!store.state.isLoggedIn) {
      const router = useRouter();
      router.push("/login");
    }
  },
  setup() {
    const router = useRouter();

    const handleLogout = () => {
      store.logout();
      router.push("/login");
    };

    const isLoggedIn = computed(() => store.state.isLoggedIn);
    const username = computed(() => store.state.username);

    return {
      isLoggedIn,
      username,
      handleLogout,
    };
  },
};
</script>

<style scoped>
/* Header styles */
.header-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  background-color: #f5f5f5;
  border-bottom: 1px solid #ddd;
}

.logo img {
  height: 50px;
}

.navbar {
  display: flex;
  align-items: center;
}

.welcome-message {
  margin-right: 20px;
}

.logout-button {
  background-color: #ff4d4d;
  color: white;
  padding: 5px 10px;
  border: none;
  cursor: pointer;
}

.logout-button:hover {
  background-color: #ff0000;
}
.card-header {
  text-decoration: none;
}
</style>
