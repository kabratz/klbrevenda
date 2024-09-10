<template>
  <nav class="navbar">
    <h1 class="navbar-title">My Application</h1>
    <div class="navbar-content">
      <p v-if="isLoggedIn" class="welcome-message">
        Welcome back, {{ username }}!
        <button @click="handleLogout" class="logout-button">Logout</button>
      </p>
      <p v-else class="login-message">Please log in to access your account.</p>
    </div>
  </nav>
</template>

<script>
import store from '../../src/store.js';

export default {
  name: 'DefaultNav',
  computed: {
    isLoggedIn() {
      return store.state.isLoggedIn;
    },
    username() {
      return store.state.username;
    }
  },
  methods: {
    handleLogout() {
      store.logout();
    }
  }
};
</script>

<style scoped>
.navbar {
  padding: 1rem;
  background-color: #f8f9fa;
  border-bottom: 1px solid #dee2e6;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.navbar-title {
  margin: 0;
  font-size: 1.5rem;
}

.navbar-content {
  display: flex;
  align-items: center;
}

.welcome-message {
  margin: 0;
  font-size: 1rem;
}

.login-message {
  margin: 0;
  font-size: 1rem;
}

.logout-button {
  margin-left: 10px;
  padding: 5px 10px;
  border: none;
  background-color: #007bff;
  color: white;
  border-radius: 4px;
  cursor: pointer;
}

.logout-button:hover {
  background-color: #0056b3;
}
</style>
