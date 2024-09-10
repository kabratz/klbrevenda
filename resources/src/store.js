// src/store.js
import { reactive, watch } from 'vue';

// Retrieve initial state from localStorage
const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
const username = localStorage.getItem('username') || '';

const state = reactive({
  isLoggedIn,
  username
});

// Watch for changes to isLoggedIn and username and store them in localStorage
watch(
  () => state.isLoggedIn,
  (newValue) => {
    localStorage.setItem('isLoggedIn', newValue);
  }
);

watch(
  () => state.username,
  (newValue) => {
    localStorage.setItem('username', newValue);
  }
);

// Method to perform logout
function logout() {
  state.isLoggedIn = false;
  state.username = '';
  localStorage.removeItem('isLoggedIn');
  localStorage.removeItem('username');
}

export default {
  state,
  logout
};
