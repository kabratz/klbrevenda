<style scoped>
.product-list {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  /* background-color: #eee; */
  margin-right: 20px;
  margin-left: 20px;
  justify-content: space-evenly;
}

.product-item {
  background-color: #fff;
  flex: 0 0 calc(31.333333% - 20px - 8px);
  max-width: calc(32.333333% - 20px);
  text-align: center;
  text-align: -webkit-center;
  padding: 20px;
  cursor: pointer;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  margin-bottom: 20px;
}

.out-of-stock {
  cursor: default;
}
.product-item:hover {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.out-of-stock:hover {
  box-shadow: none;
}
.product-item button {
  cursor: pointer;
}

.out-of-stock button {
  cursor: default;
}

.product-item img {
  height: 100%;
  max-height: 200px;
  max-width: 100%;
  width: auto;
  transition: all 0.3s ease;
}
.out-of-stock img {
  filter: grayscale(100%);
  filter: opacity(50%);
}
.out-of-stock-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.5);
  display: flex;
  justify-content: flex-start;
  align-items: flex-start;
  z-index: 1;
  background-color: rgba(255, 255, 255, 0.5);
}
.out-of-stock-overlay p {
  color: #fff;
  font-size: 12px;
  font-weight: bold;
  background-color: #007bff;
  padding: 3px 10px;
  border-radius: 8px;
}
.image-box {
  width: 100%;
  height: 200px;
}

.modal-content .image-box {
  height: 300px;
}

/* Estilo do carrossel */
.carousel {
  position: relative;
}

.carousel-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  max-width: 300px;
  z-index: 1;
}

/* Modal */
.modal {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  transform: translate(0, 0) !important;
  cursor: pointer;
  padding: 0;
}

.modal-content {
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  text-align: center;
  position: relative;
  cursor: default;
}

.close {
  position: absolute;
  right: 20px;
  top: 10px;
  font-size: 24px;
  cursor: pointer;
}

/* Header */
/* Estilo para o cabeçalho */
header {
  background-color: #f8f8f8;
  padding: 10px 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  z-index: 99;
}

.container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Estilo para o logotipo */
.logo img {
  height: 50px;
}

/* Barra de Navegação */
.navbar ul {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  gap: 20px;
}

.navbar ul li {
  display: inline;
}

.navbar ul li a {
  text-decoration: none;
  color: #333;
  font-size: 16px;
  transition: color 0.3s ease;
}

.navbar ul li a:hover .navbar ul li a.selected {
  color: #007bff;
}

/* Barra de Busca */
.search-bar {
  display: flex;
  align-items: center;
}

.search-bar input {
  padding: 5px 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-right: 10px;
}

.search-bar button {
  padding: 5px 10px;
  background-color: #007bff;
  border: none;
  color: white;
  border-radius: 4px;
  cursor: pointer;
}

.search-bar button:hover {
  background-color: #0056b3;
}

/* Ícone do Carrinho */

.cart-icon img {
  width: 30px;
}

/* Dropdown marcas */
/* Dropdown de Marcas */
.navbar {
  z-index: 99;
  gap: 50px;
}

.navbar ul {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  gap: 20px;
}

.navbar ul li {
  position: relative;
  display: inline-block;
  flex: 0 0 calc(20% - 20px - 8px);
}

.navbar ul li a {
  text-decoration: none;
  color: #333;
  font-size: 16px;
  transition: color 0.3s ease;
}

.navbar ul .dropdown li a:hover,
.navbar ul li a:hover {
  color: #007bff;
  cursor: pointer;
}

header {
  position: fixed;
  width: -webkit-fill-available;
  top: 0;
  left: 0;
}

/* Estilo do dropdown de marcas */
.navbar ul .dropdown {
  /* display: none; */
  position: fixed;
  left: 0;
  background-color: #fff;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  z-index: 99;
  width: 100%;
  padding: 0;
  text-align: left;
  -webkit-column-count: 6;
  -webkit-column-gap: 20px;
  -moz-column-count: 6;
  -moz-column-gap: 20px;
  column-count: 6;
  column-gap: 20px;
  display: flex;
  flex-wrap: wrap;
}

.navbar ul li :hover .dropdown {
  display: block;
}

.navbar ul .dropdown li {
  padding: 10px;
}

.navbar ul .dropdown li a {
  text-decoration: none;
  color: #333;
  font-size: 14px;
  transition: background-color 0.3s ease;
}

.body-products {
  margin-top: 100px;
}

/* Cart */

.cart-count {
  position: absolute;
  top: 5px;
  right: 0px;
  background-color: red;
  color: white;
  padding: 5px;
  border-radius: 50%;
  font-size: 12px;
}

.cart-sidebar {
  position: fixed;
  right: -300px;
  top: 75px;
  width: 300px;
  height: -webkit-fill-available;
  background-color: white;
  box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
  padding: 20px;
  z-index: 95;
  gap: 21px;
  display: flex;
  flex-direction: column;
  transform: translateX(100%);
  opacity: 0;
  transition: transform 0.7s ease, opacity 0.7s ease;
}

.cart-sidebar.visible {
  transform: translateX(0);
  opacity: 1;
  right: 0px;
}

.cart-sidebar img {
  width: 30px;
  height: 100%;
}

.cart-sidebar ul {
  padding: 0;
}

.cart-sidebar li {
  list-style: none;
  display: flex;
  justify-content: space-between;
  gap: 5px;
}

.quantity-box {
  display: flex;
  gap: 5px;
}

.quantity-box button {
  height: fit-content;
}

/* Formulário de Checkout */
.checkout-form {
  margin-top: 20px;
}

.checkout-form input {
  padding: 5px;
  margin-bottom: 10px;
  width: calc(100% - 10px);
}

.checkout-form button {
  padding: 10px;
  background-color: #28a745;
  color: white;
  border: none;
  cursor: pointer;
}

.checkout-form button:hover {
  background-color: #218838;
}
.selected-filter {
  background-color: #007bff80;
  color: white;
  padding: 5px;
  border-radius: 8px;
  margin-right: 5px;
  cursor: pointer;
  width: fit-content;
}
.selected-filters {
  display: flex;
  gap: 5px;
  margin-top: 10px;
}

.open-header {
  display: none;
}

@media (max-width: 768px) {
  .open-header {
    display: block;
    cursor: pointer;
  }
  .header-container .navbar {
    display: flex;
    align-items: flex-start;
    position: fixed;
    left: -300px; /* Altere para posicionar o menu fora da tela à esquerda */
    top: 75px;
    width: 300px;
    background-color: white;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.3);
    padding: 20px;
    z-index: 95;
    gap: 21px;
    flex-direction: column;
    transform: translateX(-100%);
    opacity: 0;
    transition: transform 0.7s ease, opacity 0.7s ease;
    overflow: auto;
    height: -webkit-fill-available;
    justify-content: flex-start;
  }

  .header-container .navbar.visible {
    transform: translateX(0);
    opacity: 1;
    left: 0;
  }
  .navbar ul {
    display: flex;
    width: 100%;
    justify-content: space-between;
    flex-direction: column;
  }

  .navbar ul .dropdown {
    flex-direction: column;
    position: relative;
    box-shadow: none;
    gap: 0;
  }
  .navbar ul li {
    display: block;
    font-size: 18px;
    flex: 0;
  }

  .navbar ul li a {
    color: #333;
    font-size: 24px;
    transition: background-color 0.3s ease;
  }
  .product-item {
    flex: 100%;
    max-width: 100%;
  }
  .modal-content {
    width: 80%;

  }
}
</style>

<template>
  <header>
    <div class="container header-container">
      <div class="open-header" @click="toggleNavbar()">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="16"
          height="16"
          viewBox="0 0 448 512"
        >
          <path
            d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"
          />
        </svg>
      </div>
      <!-- Logotipo -->
      <div class="logo">
        <a href="#">
          <img :src="`/storage/logo.webp`" :alt="`logotipo`" />
        </a>
      </div>

      <!-- Barra de Navegação -->
      <nav class="navbar" :class="{ visible: navbarVisible }">
        <ul>
          <!-- Dropdown de Marcas -->
          <li @click="showBrands = !showBrands" :class="{ selected: showBrands }">
            <a href="#">Marcas</a>
            <ul v-if="showBrands" class="dropdown">
              <li v-for="brand in brands" :key="brand.id">
                <a @click.stop="filterByBrand(brand.id)">{{ brand.name }}</a>
              </li>
            </ul>
          </li>
          <li @click="showCategories = !showCategories">
            <a href="#">Produtos</a>
            <ul v-if="showCategories" class="dropdown">
              <li v-for="category in categories" :key="category.id">
                <a @click.stop="filterByCategory(category.id)">{{ category.name }}</a>
              </li>
            </ul>
          </li>
        </ul>
        <!-- Barra de Busca -->
        <div class="search-bar">
          <input v-model="search" type="text" placeholder="Buscar..." @keyup.enter="filterBySearch()"/>
          <button @click.stop="filterBySearch()">Buscar</button>
        </div>
      </nav>

      <!-- Ícone do Carrinho -->
      <div class="cart-icon">
        <a href="#" @click="toggleCart">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 448 512"
            width="15"
            height="15"
          >
            <path
              d="M160 112c0-35.3 28.7-64 64-64s64 28.7 64 64l0 48-128 0 0-48zm-48 48l-64 0c-26.5 0-48 21.5-48 48L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-208c0-26.5-21.5-48-48-48l-64 0 0-48C336 50.1 285.9 0 224 0S112 50.1 112 112l0 48zm24 48a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm152 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"
            />
          </svg>
          <span class="cart-count">{{ cartItemCount }}</span>
        </a>
      </div>
    </div>
  </header>
  <div class="body-products">
    <div class="selected-filters">
      <div v-if="selectedBrand != ''" class="selected-filter" @click="clearBrandFilter()">
        <strong>{{ findBrand(selectedBrand).name }}</strong> x
      </div>
      <div
        v-if="selectedCategory != ''"
        class="selected-filter"
        @click="clearCategoryFilter()"
      >
        <strong>{{ findCategory(selectedCategory).name }}</strong> x
      </div>
      <div v-if="searched != ''" class="selected-filter" @click="clearSearchFilter()">
        <strong>{{ searched }}</strong> x
      </div>
    </div>
    <div class="product-list">
      <div v-if="products.length == 0" class="no-products">
        <p>Nenhum produto encontrado</p>
      </div>
      <div
        v-for="product in products"
        :key="product.id"
        class="product-item"
        :class="{ 'out-of-stock': product.quantity <= 0 }"
        @click="openProductModal(product)"
      >
        <div class="image-box">
          <!-- Carrossel de imagens -->
          <div v-if="product.images.length" class="carousel">
            <img
              :src="`/storage/${product.images[currentImageIndex[product.id]]?.file}`"
              :alt="`${product.images[currentImageIndex[product.id]]?.name}`"
              class="carousel-image"
            />
            <div v-if="product.quantity <= 0" class="out-of-stock-overlay">
              <p>Produto Indisponível</p>
            </div>
          </div>
        </div>
        <h3>{{ product.name }}</h3>
        <p>{{ currencyFormat(product.price) }}</p>
        <button v-if="product.quantity > 0" @click.stop="addToCart(product)">
          Adicionar ao Carrinho
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 448 512"
            width="15"
            height="15"
          >
            <path
              d="M160 112c0-35.3 28.7-64 64-64s64 28.7 64 64l0 48-128 0 0-48zm-48 48l-64 0c-26.5 0-48 21.5-48 48L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-208c0-26.5-21.5-48-48-48l-64 0 0-48C336 50.1 285.9 0 224 0S112 50.1 112 112l0 48zm24 48a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm152 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"
            />
          </svg>
        </button>
      </div>
    </div>

    <!-- Modal de Detalhes -->
    <div v-if="showModal" class="modal" @click="closeModal">
      <div class="modal-content" @click.stop>
        <span class="close" @click.stop="closeModal">&times;</span>
        <div class="image-box" :class="{ 'out-of-stock': modalProduct.quantity <= 0 }">
          <!-- Carrossel de imagens -->
          <div v-if="modalProduct.images.lengfth" class="carousel">
            <img
              :src="`/storage/${
                modalProduct.images[currentImageIndex[modalProduct.id]]?.file
              }`"
              :alt="`${modalProduct.images[currentImageIndex[modalProduct.id]]?.name}`"
              class="carousel-image"
            />
            <div v-if="modalProduct.quantity <= 0" class="out-of-stock-overlay">
              <p>Produto Indisponível</p>
            </div>
          </div>
        </div>
        <h2>{{ modalProduct.name }}</h2>
        <p v-html="modalProduct.description"></p>
        <div v-if="modalProduct.quantity > 0">
          <div>
            <label for="quantity">Quantidade:</label>
            <input
              type="number"
              v-model="quantity"
              min="1"
              :max="modalProduct.quantity"
            />
          </div>
          <button @click.stop="addToCart(modalProduct)">Adicionar ao Carrinho</button>
        </div>
      </div>
    </div>

    <!-- Janela lateral do carrinho -->
    <div class="cart-sidebar" :class="{ visible: cartVisible }">
      <h2>Carrinho</h2>
      <ul>
        <li v-for="item in cartItems" :key="item.id">
          <img
            :src="`/storage/${findImage(item.id)?.file}`"
            :alt="`${findImage(item.id)?.name}`"
          />
          {{ item.name }} - {{ currencyFormat(item.price) }}
          <div class="quantity-box">
            <button @click="removeFromCart(item)">-</button>{{ item.quantity
            }}<button @click="addToCart(item)">+</button>
          </div>
        </li>
      </ul>

      <!-- Resumo do Carrinho -->
      <div class="cart-summary">
        <p>Total de Itens: {{ cartItemCount }}</p>
        <p>Valor Total: {{ currencyFormat(totalPrice) }}</p>
      </div>

      <button @click="toggleCheckoutForm">Finalizar Pedido</button>

      <!-- Formulário de Checkout -->
      <div v-if="checkoutVisible" class="checkout-form">
        <h3>Informações de Contato</h3>
        <label for="name">Nome Completo:</label>
        <input
          id="name"
          type="text"
          v-model="customerName"
          placeholder="Ex:Maria da Silva"
          required
        />
        <label for="phone">WhatsApp:</label>
        <input
          id="phone"
          type="tel"
          v-phone-mask
          v-model="customerWhatsapp"
          placeholder="+55 (00) 00000-0000"
          required
        />
        <button @click="completeCheckout">Enviar Pedido</button>
      </div>
    </div>
  </div>
  <!-- Modal pedido realizado com sucesso -->
  <div
    v-if="orderConfirmationVisible"
    class="modal fade"
    id="orderConfirmationModal"
    @click="orderConfirmationVisible = false"
  >
    <div class="modal-dialog" @click.stop>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderConfirmationModalLabel">
            Pedido Realizado com Sucesso!
          </h5>
          <button
            type="button"
            class="btn-close"
            @click.stop="orderConfirmationVisible = false"
          >
            X
          </button>
        </div>
        <div class="modal-body">
          <p>Seu pedido foi criado com sucesso!</p>
          <p>
            Para confirmar seu pedido, você pode enviar uma mensagem para o nosso WhatsApp
            com o resumo do pedido.
          </p>
          <p>O pagamento será combinado assim que confirmarmos seu pedido. Obrigado!</p>
          <p>
            <a
              :href="whatsappLink"
              id="whatsappLink"
              class="btn btn-primary"
              target="_blank"
              >Enviar no WhatsApp</a
            >
          </p>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
            @click.stop="orderConfirmationVisible = false"
          >
            Fechar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Catalog",
  setup() {},
  data() {
    return {
      products: [],
      brands: [],
      categories: [],
      search: "",
      searched: "",
      selectedBrand: "",
      selectedCategory: "",
      cart: [],
      currentImageIndex: {},
      showModal: false,
      modalProduct: null,
      quantity: 1,
      showBrands: false,
      showCategories: false,
      cartVisible: false,
      cartItems: [],
      cartItemCount: 0,
      checkoutVisible: false,
      totalPrice: 0,
      customerName: null,
      customerWhatsapp: null,
      csrfToken: null,
      orderConfirmationVisible: false,
      whatsappLink: "",
      navbarVisible: false,
    };
  },
  mounted() {
    this.getProducts();
    this.loadCart();
    this.csrfToken = document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute("content");
  },
  methods: {
    async getProducts() {
      try {
        axios.defaults.headers.common["X-CSRF-TOKEN"] = document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content");

        const response = await axios.get("/api/products");
        this.products = response.data.products;
        this.brands = response.data.brands;
        this.categories = response.data.categories;

        this.products.forEach((product) => {
          this.currentImageIndex[product.id] = 0;
          setInterval(() => {
            this.currentImageIndex[product.id] =
              (this.currentImageIndex[product.id] + 1) % product.images.length;
          }, 5000);
        });
      } catch (error) {
        console.error("Erro ao buscar produtos:", error);
      }
    },
    filterProducts() {
      axios.defaults.headers.common["X-CSRF-TOKEN"] = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
      this.searched = this.search;

      axios
        .get("/api/catalog/filter", {
          params: {
            brand_id: this.selectedBrand,
            category_id: this.selectedCategory,
            search: this.search,
          },
        })
        .then((response) => {
          this.products = response.data;
        });
    },
    openProductModal(product) {
      this.modalProduct = product;
      this.quantity = 1;
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    filterByBrand(brandId) {
      this.navbarVisible = false;
      this.showBrands = false;
      this.selectedBrand = brandId;
      this.filterProducts();
    },

    filterByCategory(categoryId) {
      this.navbarVisible = false;
      this.showCategories = false;
      this.selectedCategory = categoryId;
      this.filterProducts();
    },

    filterBySearch() {
      this.navbarVisible = false;
      console.log(this.search);
      this.filterProducts();
    },
    addToCart(product) {
      let cart = getCookie("cart") || [];

      const existingItem = cart.find((item) => item.id === product.id);
      if (existingItem) {
        if (existingItem.quantity >= product.quantity) {
          alert("Quantidade indisponível");
          return;
        }
        existingItem.quantity += 1;
        existingItem.price = product.price;
      } else {
        cart.push({
          id: product.id,
          name: product.name,
          price: product.price,
          quantity: 1,
        });
      }

      setCookie("cart", cart, 7);

      this.loadCart();
      this.cartVisible = true;
    },
    removeFromCart(product) {
      let cart = getCookie("cart") || [];

      const itemIndex = cart.findIndex((item) => item.id === product.id);

      if (itemIndex !== -1) {
        const existingItem = cart[itemIndex];
        if (existingItem.quantity > 1) {
          existingItem.quantity -= 1;
        } else {
          cart.splice(itemIndex, 1);
        }

        setCookie("cart", cart, 7);

        this.loadCart();
      }
    },
    async loadCart() {
      const cart = getCookie("cart") || [];
      await this.getProducts();

      this.cartItems = cart.map((item) => {
        const product = this.products.find((product) => product.id === item.id);
        return {
          ...item,
          price: product ? product.price : item.price,
        };
      });

      this.cartItemCount = cart.reduce((total, item) => total + item.quantity, 0);
      this.totalPrice = this.cartItems.reduce(
        (total, item) => total + item.quantity * item.price,
        0
      );
    },
    toggleCart() {
      this.cartVisible = !this.cartVisible;
      this.navbarVisible = false;
    },

    toggleCheckoutForm() {
      this.checkoutVisible = !this.checkoutVisible;
    },
    completeCheckout() {
      if (this.customerName && this.customerWhatsapp) {
        console.log(this.csrfToken);

        axios
          .post(
            "/api/order",
            {
              cart: this.cartItems,
              customer: {
                name: this.customerName,
                whatsapp: this.customerWhatsapp.replace(/\D/g, ""),
              },
            },
            {
              headers: {
                "X-CSRF-TOKEN": this.csrfToken, // Usa o token CSRF do HTML
              },
            }
          )
          .then((response) => {
            this.orderConfirmationVisible = true;
            this.whatsappLink = response.data.whatsapp_link;
            this.cart = response.data;
            this.clearCart();
          })
          .catch((error) => {
            console.log(error);
            if (error.response && error.response.status === 419) {
              alert("Por favor, atualize a página e tente novamente.");
              return;
            }
            alert("Ocorreu um erro, tente novamente mais tarde!");
            console.error("Erro:", error);
          });
      } else {
        alert("Por favor, preencha todos os campos.");
      }
    },
    findImage(productId) {
      let product = this.products.find((product) => product.id === productId);
      if (product && product.images) {
        return product.images[0];
      }

      return null;
    },
    currencyFormat(value) {
      return `R$ ${parseFloat(value).toFixed(2).replace(".", ",")}`;
    },
    findBrand(brandId) {
      return this.brands.find((brand) => brand.id === brandId);
    },
    clearBrandFilter() {
      this.selectedBrand = "";
      this.filterProducts();
    },
    findCategory(categoryId) {
      return this.categories.find((category) => category.id === categoryId);
    },
    clearCategoryFilter() {
      this.selectedCategory = "";
      this.filterProducts();
    },
    clearSearchFilter() {
      this.search = "";
      this.filterProducts();
    },
    clearCart() {
      this.closeModal();
      this.cartItems = [];
      this.totalItems = 0;
      this.totalPrice = 0;
      this.cartVisible = false;
      this.checkoutVisible = false;
      deleteCookie("cart");
    },
    toggleNavbar() {
      this.navbarVisible = !this.navbarVisible;
      this.cartVisible = false;
    },
  },
};

function setCookie(name, value, days) {
  const d = new Date();
  d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
  const expires = "expires=" + d.toUTCString();

  let cookieString = `${name}=${JSON.stringify(value)};${expires};path=/;SameSite=Lax`;

  if (window.location.protocol === "https:") {
    cookieString += ";Secure";
  }
  document.cookie = cookieString;
}

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return JSON.parse(parts.pop().split(";").shift());
  return null;
}

function deleteCookie(name) {
  document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}
</script>
