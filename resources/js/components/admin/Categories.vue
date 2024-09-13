<template>
  <header-admin></header-admin>

  <div class="body-container">
    <div class="left-box">
      <button class="button-primary" @click="openCreateModal">
        Adicionar uma nova categoria
      </button>
    </div>
    <div class="card">
      <!-- Chamada recursiva para exibir as categorias e subcategorias -->
      <div v-for="category in categories" :key="category.id">
        <CategoryItem :category="category" />
      </div>
    </div>
  </div>

  <div class="modal-overlay" :class="{ active: isModalActive }" @click="closeModal"></div>
  <div class="modal-product" :class="{ active: isModalActive }">
    <div class="modal-header">
      <h4>{{ isEditing ? "Edite a categoria" : "Crie uma categoria" }}</h4>
      <button class="button-close-modal" @click="closeModal">&times;</button>
    </div>
    <div class="modal-product-content">
      <form @submit.prevent="saveCategory" class="modal-product-body">
        <label>Nome</label>
        <input v-model="editableCategory.name" type="text" />

        <!-- Select de pai -->
        <div class="form-group">
          <label for="brand">Categoria Pai:</label>
          <select
            v-model="editableCategory.parent_id"
            id="parent-id"
            class="form-control"
          >
            <option disabled value="">Selecione uma categoria pai</option>
            <option
              v-for="category in this.allCategories"
              :key="category.id"
              :value="category.id"
            >
              {{ category.name }}
            </option>
          </select>
        </div>
        <button type="submit" class="button-primary">
          {{ isEditing ? "Salvar alterações" : "Criar categoria" }}
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import store from "../../../src/store.js";
import CategoryItem from "./CategoryItem.vue"; // Importando o componente

export default {
  components: {
    CategoryItem,
  },
  data() {
    return {
      allCategories: [],
      editableCategory: {
        name: "",
        parent_id: "",
      },
      isEditing: false,
      isModalActive: false,
    };
  },
  created() {
    this.fetchAllCategories();
    if (!store.state.isLoggedIn) {
      const router = useRouter();
      router.push("/login");
    }
  },
  setup() {
    const categories = ref([]);
    const navbarVisible = ref(false);
    const router = useRouter();

    const fetchCategories = async () => {
      try {
        const response = await axios.get("/api/categories");
        categories.value = response.data;
      } catch (error) {
        console.error("Erro ao buscar categorias:", error);
      }
    };

    const handleLogout = () => {
      store.logout();
      router.push("/login");
    };

    onMounted(() => {
      fetchCategories();
      if (!store.state.isLoggedIn) {
        router.push("/login");
      }
    });

    const isLoggedIn = computed(() => store.state.isLoggedIn);
    const username = computed(() => store.state.username);

    return {
      categories,
      navbarVisible,
      isLoggedIn,
      username,
      handleLogout,
    };
  },
  methods: {
    async fetchAllCategories() {
      try {
        const categories = await axios.get("/api/categories/all");
        this.allCategories = categories.data;
      } catch (error) {
        console.error("Erro ao buscar produtos:", error);
      }
    },
    openCreateModal() {
      this.editableCategory = {
        name: "",
        parent_id: "",
      };
      this.isModalActive = true;
      document.body.classList.add("no-scroll");
    },
    closeModal() {
      this.isModalActive = false;
      this.editableCategory = {};
      document.body.classList.remove("no-scroll");
    },

    saveCategory() {
      const url = "/api/categories";
      const method = "POST";

      fetch(url, {
        method: method,
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
        body: JSON.stringify(this.editableCategory),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            window.location.reload();
          } else {
            console.error("Failed to save product:", data);
          }
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },
  },
};
</script>

<style scoped>
.body-container {
  padding: 20px;
}

.card {
  border: 1px solid #ddd;
  padding: 10px;
  font-size: 20px;
}


.button-primary {
  background-color: #007bff;
  color: white;
  padding: 10px;
  border: none;
  cursor: pointer;
  margin-bottom: 15px;
}

.button-primary:hover {
  background-color: #0056b3;
}

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

.button-close-modal {
  border: none;
  font-size: 24px;
  cursor: pointer;
}

.modal-product {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: white;
  padding: 16px;
  border-radius: 8px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  z-index: 1000;
  display: none;
  min-width: 80vw;
}

.modal-product.active {
  display: block;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 999;
  display: none;
}

.modal-overlay.active {
  display: block;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: solid 1px grey;
  margin-bottom: 16px;
}

.modal-header h4 {
  margin: 0;
}

.modal-product-body {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.modal-product-content {
  max-height: 80vh;
  overflow-y: auto;
}
</style>
