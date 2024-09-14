<template>
  <header-admin></header-admin>
  <div class="body-container">
    <div class="left-box">
      <button class="button-primary" @click="openCreateModal">
        Adicionar uma nova marca
      </button>
    </div>
    <div class="card">
      <!-- Chamada recursiva para exibir as categorias e subcategorias -->
      <div v-for="brand in brands" :key="brand.id">
        <div class="line">
          <!-- Verifica se a categoria está sendo editada -->
          <div class="column">
            {{ brand.name }}
          </div>
          <!-- Botões de ação (Editar, Salvar, Cancelar) -->
          <div class="actions">
            <button @click.stop="deleteBrand(bran.id)">Excluir</button>
            <button @click.stop="openEditModal(brand)">Editar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-overlay" :class="{ active: isModalActive }" @click="closeModal"></div>
  <div class="modal-product" :class="{ active: isModalActive }">
    <div class="modal-header">
      <h4>{{ isEditing ? "Edite a marca" : "Crie uma marca" }}</h4>
      <button class="button-close-modal" @click="closeModal">&times;</button>
    </div>
    <div class="modal-product-content">
      <form @submit.prevent="saveBrand" class="modal-product-body">
        <label>Nome</label>
        <input v-model="editableBrand.name" type="text" />

        <button type="submit" class="button-primary">
          {{ isEditing ? "Salvar alterações" : "Criar marca" }}
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

export default {
  data() {
    return {
      editableBrand: {
        name: "",
      },
      isEditing: false,
      isModalActive: false,
    };
  },
  created() {
    this.fetchBrands();
    if (!store.state.isLoggedIn) {
      const router = useRouter();
      router.push("/login");
    }
  },
  setup() {
    const brands = ref([]);
    const router = useRouter();

    const handleLogout = () => {
      store.logout();
      router.push("/login");
    };

    const isLoggedIn = computed(() => store.state.isLoggedIn);
    const username = computed(() => store.state.username);

    return {
      brands,
      isLoggedIn,
      username,
      handleLogout,
    };
  },
  methods: {
    async fetchBrands() {
      try {
        const response = await axios.get("/api/brands");
        this.brands = response.data;
      } catch (error) {
        console.error("Erro ao buscar produtos:", error);
      }
    },
    async deleteBrand(brandId) {
      if (confirm("Você tem certeza que deseja remover esta marca? ")) {
        try {
          await axios.delete(`/api/brands/${brandId}`, {});
          alert("Marca removida com sucesso!")
          window.location.reload();
        } catch (error) {
          console.error("Erro ao salvar a marca:", error);
        }
      }
    },
    openCreateModal() {
      this.isEditing = false;
      this.editableBrand = {
        name: "",
        id: null,
      };
      this.isModalActive = true;
      document.body.classList.add("no-scroll");
    },
    openEditModal(brand) {
      this.isEditing = true;
      this.editableBrand = {
        name: brand.name,
        id: brand.id,
      };
      this.isModalActive = true;
      document.body.classList.add("no-scroll");
    },
    closeModal() {
      this.isModalActive = false;
      this.editableBrand = {};
      document.body.classList.remove("no-scroll");
    },

    saveBrand() {
      const url = this.isEditing ? `/api/brands/${this.editableBrand.id}` : "/api/brands";
      const method = this.isEditing ? "PUT" : "POST";

      fetch(url, {
        method: method,
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
        body: JSON.stringify(this.editableBrand),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert("Marca salva com sucesso!");
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
/* Estilização básica para exibir a hierarquia visualmente */
.body-container {
  padding: 20px;
}

.card {
  border: 1px solid #ddd;
  padding: 10px;
}


.column {
  font-weight: bold;
}

.line{
  display: flex;
    justify-content: space-between;
    padding: 10px;
    border-bottom: 1px solid #ddd;
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

.actions {
  display: flex;
  gap: 8px;
}
</style>
