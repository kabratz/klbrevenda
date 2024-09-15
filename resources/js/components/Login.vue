<template>
  <div class="login-form">
    <img width="200" :src="`/logo.webp`" alt="logotipo" />

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
  </div>
</template>

<script>
import store from "../../src/store.js";
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

export default {
  name: "Login",
  setup() {
    const email = ref("");
    const password = ref("");
    const errorMessage = ref("");
    const router = useRouter(); // Hook para manipulação de rotas

    if (store.state.isLoggedIn) {
      router.push("/products");
    }
    // Obtém o token CSRF do HTML
    const csrfToken = document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute("content");

    const handleLogin = async () => {
      if (!email.value || !password.value) {
        errorMessage.value = "Por favor, preencha todos os campos.";
        return;
      }
      try {
        const response = await axios.post(
          "/api/login",
          {
            email: email.value,
            password: password.value,
          },
          {
            headers: {
              "X-CSRF-TOKEN": csrfToken, // Usa o token CSRF do HTML
            },
          }
        );

        if (response.data.success) {
          store.state.isLoggedIn = true;
          store.state.username = email.value;
          router.push("/products"); // Redireciona para a rota /products
        } else {
          errorMessage.value =
            response.data.message || "Falha ao logar, por favor, tente novamente.";
        }
      } catch (error) {
        errorMessage.value =
          "Falha ao logar, por favor confira suas credenciais e tente novamente.";
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
.login-form {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  max-width: 80vw;
  max-height: 80vh;
  width: 300px;
  height: 500px;
  gap: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-top: 50px;
  margin-left: calc(50% - 150px);
  margin-bottom: 50px;
}

form {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

form div {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

form div label {
  font-size: 1.2rem;
}

form div input,
form button {
  font-size: 1.2rem;
  border-radius: 5px;
  border: 1px solid #ccc;
}

@media (max-width: 350px) {
  .login-form {
    left: 0;
    width: 100vw;
    max-width: 100vw;
  }
}
</style>
