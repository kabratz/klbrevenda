<style scoped>
.table {
  border: solid 1px grey;
  border-radius: 16px;
  padding: 8px;
}

.table-header {
  font-weight: bold;
  background-color: #0056b390;
  border-radius: 8px 8px 0 0;
  padding: 8px 8px 4px 8px;
  color: #fff;
}

.product-box {
  border-bottom: solid 1px grey;
}

.line {
  display: flex;
  padding: 4px;
  align-items: center;
  cursor: pointer;
}
.body .line:not(.active),
.body .details {
  border-bottom: 1px solid #ccc;
}

.column {
  flex: 0 0 calc(19% - 4px);
  width: calc(19% - 4px);
  padding: 2px;
}

.column-left {
  display: flex;
  align-items: flex-end;
  justify-content: flex-end;
  flex: 0 0 5%;
  max-width: 5%;
  padding: 0px;
}

.button-close-modal {
  border: none;
  font-size: 24px;
  cursor: pointer;
}

.details {
  padding: 8px;
  background-color: #f9f9f9;
  border-top: solid 1px #eee;
  display: none;
}

.details.active {
  display: block;
}

.rotate {
  transition: transform 0.3s ease;
}

.rotate.active {
  transform: rotate(-90deg);
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

.image-modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.image-modal {
  max-width: 90%;
  max-height: 90%;
}

.image-modal img {
  max-width: 90vw;
  max-height: 90vh;
}

.no-scroll {
  overflow: hidden;
}

.modal-product-content {
  max-height: 80vh;
  overflow-y: auto;
}
.brand-detail,
.quantity-detail {
  display: none;
}

@media (max-width: 768px) {
  .brand-column,
  .quantity-column {
    display: none;
  }
  .brand-detail,
  .quantity-detail {
    display: block;
  }
  .column {
    flex: 0 0 calc(49% - 4px);
    max-width: calc(49% - 4px);
  }
  .options-column {
    flex: 0 0 calc(24% - 4px);
    max-width: calc(24% - 4px);
  }
  .column-left {
    display: flex;
    align-items: flex-end;
    justify-content: flex-end;
    flex: 0 0 3%;
    max-width: 3%;
  }
}
</style>
<template>
  <header-admin></header-admin>

  <div class="body-container">
    <div class="row justify-content-center">
      <div class="card">
        <div class="left-box">
          <a href="/products/import" class="button-primary"> Importar de um csv </a>
        </div>
        <div class="left-box">
          <button class="button-primary" @click="openCreateModal">
            Adicionar um novo produto
          </button>
        </div>
        <div class="card-body">
          <div class="table">
            <div class="table-header">
              <div class="line">
                <div class="column">Nome</div>
                <div class="column quantity-column">Quantidade</div>
                <div class="column brand-column">Marca</div>
                <div class="column options-column">Editar</div>
                <div class="column options-column">Deletar</div>
                <div class="column column-left"></div>
              </div>
            </div>
            <div class="body">
              <div v-for="product in localProducts.products" :key="product.id">
                <div
                  class="line"
                  :class="{ active: isActive(product.id) }"
                  @click="toggleDetails(product.id)"
                >
                  <div class="column">{{ product.name }}</div>
                  <div class="column quantity-column">{{ product.quantity }}</div>
                  <div class="column brand-column">{{ product.brand.name }}</div>
                  <div class="column options-column">
                    <button @click.stop="openEditModal(product)">Editar</button>
                  </div>
                  <div class="column options-column">
                    <button @click.stop="deleteProduct(product.id)">Deletar</button>
                  </div>
                  <div class="column column-left">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="16"
                      height="16"
                      viewBox="0 0 320 512"
                      :class="{ rotate: true, active: isActive(product.id) }"
                    >
                      <path
                        d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z"
                      />
                    </svg>
                  </div>
                </div>
                <div class="details" :class="{ active: isActive(product.id) }">
                  <p><strong>Descrição:</strong> {{ product.description }}</p>
                  <p class="brand-detail">
                    <strong>Marca:</strong> {{ product.brand.name }}
                  </p>
                  <p class="quantity-detail">
                    <strong>Quantidade:</strong> {{ product.brand.name }}
                  </p>
                  <p><strong>Preço:</strong> R${{ product.price }}</p>
                  <p><strong>Gênero:</strong> {{ product.gender }}</p>
                  <p>
                    <strong>Google Category:</strong>
                    {{ product.google_product_category }}
                  </p>
                  <p>
                    <strong>Facebook Category:</strong> {{ product.fb_product_category }}
                  </p>
                  <p><strong>SKU:</strong> {{ product.sku }}</p>
                  <div v-if="product.categories.length">
                    <h4>Categorias:</h4>
                    <ul>
                      <li v-for="category in product.categories" :key="category.id">
                        {{ category.name }}
                        <ul v-if="category.parent">
                          <li
                            v-for="parent in getParentCategories(category)"
                            :key="parent.id"
                          >
                            {{ parent.name }}
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                  <div class="images-section">
                    <p><strong>Imagens:</strong></p>
                    <div
                      v-for="(image, index) in product.images"
                      :key="image.id"
                      class="image-item"
                    >
                      <picture>
                        <source
                          :src="`/storage/${image.file}`"
                          :alt="image.name"
                          @click="openImageModal(image.file)"
                          style="cursor: pointer; width: 100px; height: 100px"
                        />
                        <source
                          :src="`/default.png`"
                          alt="Default Image"
                          @click="openImageModal(image.file)"
                          style="cursor: pointer; width: 100px; height: 100px"
                        />
                        <img
                          :src="`/storage/${image.file}`"
                          :alt="image.name"
                          @click="openImageModal(image.file)"
                          style="cursor: pointer; width: 100px; height: 100px"
                          @error="handleError"
                        />
                      </picture>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal e Overlay -->
    <div
      class="modal-overlay"
      :class="{ active: isModalActive }"
      @click="closeModal"
    ></div>
    <div v-if="isImageModalActive" class="image-modal-overlay" @click="closeImageModal">
      <div class="image-modal">
        <img :src="`/storage/${currentImage}`" alt="Full-size Image" />
      </div>
    </div>
    <div class="modal-product" :class="{ active: isModalActive }">
      <div class="modal-header">
        <h4>{{ isEditing ? "Edit Product" : "Create Product" }}</h4>
        <button class="button-close-modal" @click="closeModal">&times;</button>
      </div>
      <div class="modal-product-content">
        <form @submit.prevent="saveProduct" class="modal-product-body">
          <label>Nome</label>
          <input v-model="editableProduct.name" type="text" />

          <label>Descrição</label>
          <!-- <textarea v-model="editableProduct.description"></textarea> -->
          <div ref="quillEditor"></div>
          <!-- Editor Quill -->

          <label>Preço</label>
          <input v-model="editableProduct.price" type="number" step="0.01" />

          <label>Quantidade</label>
          <input v-model="editableProduct.quantity" type="number" />

          <label>Google Category</label>
          <input v-model="editableProduct.google_product_category" type="text" />

          <label>Facebook Category</label>
          <input v-model="editableProduct.fb_product_category" type="text" />

          <label>SKU</label>
          <input v-model="editableProduct.sku" type="text" />

          <!-- Select de Gênero -->
          <div class="form-group">
            <label for="gender">Fênero:</label>
            <select v-model="editableProduct.gender" id="gender" class="form-control">
              <option disabled value="">Selecione o gênero</option>
              <option value="female">Feminino</option>
              <option value="male">Masculino</option>
              <option value="unisex">Unisex</option>
            </select>
          </div>

          <!-- Select de Marcas -->
          <div class="form-group">
            <label for="brand">Marca:</label>
            <select v-model="editableProduct.brand_id" id="brand" class="form-control">
              <option disabled value="">Selecione a marca</option>
              <option
                v-for="brand in this.localProducts.brands"
                :key="brand.id"
                :value="brand.id"
              >
                {{ brand.name }}
              </option>
            </select>
          </div>

          <div class="form-group categories-group">
            <label>Categorias:</label>
            <div class="categories-group">
              <label v-for="category in this.localProducts.categories" :key="category.id">
                <input
                  :key="category.id"
                  :value="category.id"
                  :id="category.id"
                  v-model="editableProduct.categoriesId"
                  type="checkbox"
                />
                {{ category.name }}
              </label>
            </div>
          </div>

          <div class="images-section">
            <p><strong>Imagens:</strong></p>
            <div
              v-for="(image, index) in editableProduct.images"
              :key="index"
              class="image-item"
            >
              <input
                type="file"
                @change="handleImageUpload($event, editableProduct.id, index)"
              />
              <img
                :src="image.previewUrl || `/storage/${image.file}`"
                alt="Preview Image"
                style="cursor: pointer; width: 100px; height: 100px"
                @click="openImageModal(image.previewUrl || image.file)"
              />

              <button @click="removeImage(index)">Remover Imagem</button>
            </div>
            <button type="button" @click="addImageField()">Adicionar Nova Imagem</button>
          </div>

          <button type="submit" class="button-primary">
            {{ isEditing ? "Salvar alterações" : "Criar produto" }}
          </button>
        </form>
      </div>
    </div>
    <div v-if="isImageModalActive" class="image-modal-overlay" @click="closeImageModal">
      <div class="image-modal">
        <img :src="`/storage/${currentImage}`" alt="Full-size Image" />
      </div>
    </div>
  </div>
</template>

<script>
import Quill from "quill";
import "quill/dist/quill.snow.css"; // Importa o estilo do Quill
import store from "../../../src/store.js";
import { useRouter } from "vue-router";

export default {
  computed: {
    isLoggedIn() {
      return store.state.isLoggedIn;
    },
    username() {
      return store.state.username;
    },
  },
  data() {
    return {
      localProducts: { products: [], brands: [], categories: [] },
      activeProductId: null,
      isModalActive: false,
      editableProduct: {
        images: [],
      },
      imageUrls: [],
      isEditing: false,
      isImageModalActive: false,
      currentImage: "",
      quill: null,
      navbarVisible: false,
    };
  },
  created() {
    this.fetchProducts();
    if (!store.state.isLoggedIn) {
      const router = useRouter();
      router.push("/login");
    }
  },
  setup() {
    const router = useRouter();

    const handleLogout = () => {
      store.logout(); // Chama a mutação para deslogar
      router.push("/login"); // Redireciona para a rota /login
    };

    return {
      handleLogout,
    };
  },
  methods: {
    async fetchProducts() {
      try {
        const response = await axios.get("/api/products");
        this.localProducts = response.data;
      } catch (error) {
        console.error("Erro ao buscar produtos:", error);
      }
    },
    toggleDetails(productId) {
      this.activeProductId = this.activeProductId === productId ? null : productId;
    },
    isActive(productId) {
      return this.activeProductId === productId;
    },
    openEditModal(product) {
      this.isEditing = true;
      this.editableProduct = {
        ...product,
        brand_id: product.brand.id,
        images: product.images || [],
        categoriesId: product.categories.map((category) => category.id),
      };
      this.imageUrls = this.editableProduct.images.map((img) => img.file || "");
      this.isModalActive = true;
      this.$nextTick(() => {
        if (this.quill) {
          this.quill.root.innerHTML = this.editableProduct.description;
        }
      });
      document.body.classList.add("no-scroll");
    },
    openCreateModal() {
      this.isEditing = false;
      this.editableProduct = {
        name: "",
        description: "",
        price: 0,
        quantity: 0,
        google_product_category: "",
        fb_product_category: "",
        gender: "",
        brand_id: "",
        images: [],
        categoriesId: [],
      };
      this.imageUrls = [];
      this.isModalActive = true;
      document.body.classList.add("no-scroll");
      this.$nextTick(() => {
        if (this.quill) {
          this.quill.root.innerHTML = this.editableProduct.description;
        }
      });
    },
    closeModal() {
      this.isModalActive = false;
      this.editableProduct = {};
      document.body.classList.remove("no-scroll");
    },
    saveProduct() {
      const url = this.isEditing
        ? `/api/products/${this.editableProduct.id}`
        : "/api/products";
      const method = this.isEditing ? "PUT" : "POST";

      this.editableProduct.description = this.quill.root.innerHTML;
      fetch(url, {
        method: method,
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
        body: JSON.stringify(this.editableProduct),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            if (this.isEditing) {
              this.fetchProducts();
            } else {
              this.localProducts.products.push(data.product);
            }
            alert("Produto salvo com sucesso!");
            this.closeModal();
          } else {
            console.error("Failed to save product:", data);
          }
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },
    deleteProduct(productId) {
      if (confirm("Você tem certeza quopene deseja remover este produto?")) {
        fetch(`/api/products/${productId}`, {
          method: "DELETE",
          headers: {
            "X-CSRF-TOKEN": document
              .querySelector('meta[name="csrf-token"]')
              .getAttribute("content"),
          },
        })
          .then((response) => {
            if (response.ok) {
              this.fetchProducts();
              alert("Produto Removido com sucesso!");
            } else {
              alert("Erro ao remover, tente novamente mais tarde!");
            }
          })
          .catch((error) => {
            console.error("Error:", error);
          });
      }
    },
    handleImageUpload(event, productId, index) {
      const file = event.target.files[0];

      if (file) {
        const reader = new FileReader();

        reader.onload = (e) => {
          this.editableProduct.images[index].previewUrl = e.target.result;
        };

        reader.readAsDataURL(file);
        this.editableProduct.images[index].file = file;

        // Envia a imagem para o servidor
        const formData = new FormData();
        formData.append("image", file);

        fetch(`/api/products/${productId}/upload-image`, {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": document
              .querySelector('meta[name="csrf-token"]')
              .getAttribute("content"),
          },
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              this.editableProduct.images[index].file = data.imageUrl;
            } else {
              console.error("Failed to upload image:", data);
            }
          })
          .catch((error) => {
            console.error("Error:", error);
          });
      }
    },

    addImageField() {
      this.editableProduct.images.push({ url: "", file: null });
    },
    removeImageField(index) {
      this.editableProduct.images.splice(index, 1);
    },
    getImageSrc(imagePath) {
      return "/storage/" + imagePath;
    },
    openImageModal(imagePath) {
      this.currentImage = imagePath;
      this.isImageModalActive = true;
    },
    closeImageModal() {
      this.isImageModalActive = false;
      this.currentImage = "";
    },
    getParentCategories(category) {
      let parents = [];
      let current = category.parent;
      while (current) {
        parents.push(current);
        current = current.parent;
      }
      return parents;
    },
    handleError(event) {
      event.target.src = "/default.png";
    },
  },
  mounted() {
    this.quill = new Quill(this.$refs.quillEditor, {
      theme: "snow",
      modules: {
        toolbar: [
          [{ header: "1" }, { header: "2" }],
          ["bold", "italic", "underline"],
          [{ list: "ordered" }, { list: "bullet" }],
          [{ align: [] }],
          ["link"],
        ],
      },
    });
  },
};
</script>
