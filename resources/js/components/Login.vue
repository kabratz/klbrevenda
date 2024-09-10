<template>
  <div class="login">
    <h2>Login</h2>
    <form @submit.prevent="handleLogin">
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="email" required />
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="password" required />
      </div>
      <button type="submit">Login</button>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </form>
  </div>
</template>

<script>
import store from '../../src/store.js';
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
  name: 'Login',
  setup() {
    const email = ref('');
    const password = ref('');
    const errorMessage = ref('');
    const router = useRouter(); // Hook para manipulação de rotas

    if(store.state.isLoggedIn){
      router.push('/products')
    }
    // Obtém o token CSRF do HTML
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const handleLogin = async () => {
      try {
        const response = await axios.post('/api/login', {
          email: email.value,
          password: password.value,
        }, {
          headers: {
            'X-CSRF-TOKEN': csrfToken, // Usa o token CSRF do HTML
          },
        });

        if (response.data.success) {
          store.state.isLoggedIn = true;
          store.state.username   = email.value;
          router.push('/products'); // Redireciona para a rota /products
        } else {
          errorMessage.value = response.data.message || 'Login failed. Please try again.';
        }
      } catch (error) {
        errorMessage.value = 'Login failed. Please check your credentials and try again.';
      }
    };

    return {
      email,
      password,
      errorMessage,
      handleLogin,
    };
  },
};
</script>

<style scoped>
/* Estilos aqui */
</style>
