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
          <img :src="`/logo.webp`" :alt="`logotipo`" />
        </a>
      </div>

      <!-- Barra de Navegação -->
      <nav class="navbar" :class="{ visible: navbarVisible }">
        <ul>
          <!-- Dropdown de Marcas -->
          <li @click="toggleBrands" :class="{ selected: showBrands }">
            <a href="#">Marcas</a>
            <ul v-if="showBrands" class="dropdown">
              <li v-for="brand in brands" :key="brand.id">
                <a @click.stop="filterByBrand(brand.id)">{{ brand.name }}</a>
              </li>
            </ul>
          </li>
          <li @click="toggleCategories" :class="{ selected: showCategories }">
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
          <input
            v-model="search"
            type="text"
            placeholder="Buscar..."
            @keyup.enter="filterBySearch()"
          />
          <button @click.stop="filterBySearch()">Buscar</button>
        </div>
      </nav>

      <!-- Ícone do Carrinho -->
      <div class="cart-icon">
        <span v-if="cartMessage" class="cart-message">{{ cartMessage }}</span>
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
            <picture>
              <source
                :src="`/storage/${product.images[currentImageIndex[product.id]]?.file}`"
                :alt="`${product.images[currentImageIndex[product.id]]?.name}`"
              />
              <source
                :src="`/default.png`"
                alt="Default Image"
                style="cursor: pointer; width: 100px; height: 100px"
              />
              <img
                :src="`/storage/${product.images[currentImageIndex[product.id]]?.file}`"
                :alt="`${product.images[currentImageIndex[product.id]]?.name}`"
                class="carousel-image"
                @error="handleError"
              />
            </picture>

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
          <div v-if="modalProduct.images.length" class="carousel">
            <!--             <button @click="currentImageIndex --"> < </button> -->
            <picture>
              <source
                :src="`/storage/${
                  modalProduct.images[currentImageIndex[modalProduct.id]]?.file
                }`"
                :alt="`${modalProduct.images[currentImageIndex[modalProduct.id]]?.name}`"
              />
              <source
                :src="`/default.png`"
                alt="Default Image"
                style="cursor: pointer; width: 100px; height: 100px"
              />
              <img
                :src="`/storage/${
                  modalProduct.images[currentImageIndex[modalProduct.id]]?.file
                }`"
                :alt="`${modalProduct.images[currentImageIndex[modalProduct.id]]?.name}`"
                class="carousel-image"
                @error="handleError"
              />
            </picture>
            <!--             <button @click="currentImageIndex ++"> > </button> -->
            <div v-if="modalProduct.quantity <= 0" class="out-of-stock-overlay">
              <p>Produto Indisponível</p>
            </div>
          </div>
        </div>
        <h2>{{ modalProduct.name }}</h2>
        <h3>{{ currencyFormat(modalProduct.price) }}</h3>
        <p v-html="modalProduct.description"></p>
        <div v-if="modalProduct.quantity > 0" class="box-quantity">
          <div>
            <label for="quantity">Quantidade: </label>
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
        <li
          v-for="item in cartItems"
          :key="item.id"
          :class="{ 'cart-out-of-stock': item.quantity <= 0 }"
        >
          <picture>
            <source
              :src="`/storage/${findImage(item.id)?.file}`"
              :alt="`${findImage(item.id)?.name}`"
            />
            <source
              :src="`/default.png`"
              alt="Default Image"
              style="cursor: pointer; width: 100px; height: 100px"
            />
            <img
              :src="`/storage/${findImage(item.id)?.file}`"
              :alt="`${findImage(item.id)?.name}`"
              @error="handleError"
            />
          </picture>
          <div class="product-resume">
            <span v-if="item.quantity <= 0" class="out-of-stock-cart"
              >Produto Indisponível</span
            >
            <h3>{{ item.name }}</h3>
            <p>{{ currencyFormat(item.price) }}</p>
          </div>
          <div class="quantity-box">
            <button @click="removeFromCart(item)">-</button>{{ item.quantity }}
            <button @click="addToCart(item)">+</button>
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
      setInterval: false,
      cartMessage: null,
    };
  },
  mounted() {
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
        this.products = []//response.data.products;
        this.brands = response.data.brands;
        this.categories = response.data.categories;

        if (!this.setInterval) {
          this.products.forEach((product) => {
            this.currentImageIndex[product.id] = 0;
            setInterval(() => {
              this.currentImageIndex[product.id] =
                (this.currentImageIndex[product.id] + 1) % product.images.length;
            }, 5000);
          });
          this.setInterval = true;
        }
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
      this.showBrands = false;
      this.showCategories = false;
      this.cartVisible = false;
      document.body.style.overflow = "hidden";
    },
    closeModal() {
      this.showModal = false;
      document.body.style.overflow = "auto";
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
      this.showBrands = false;
      this.showCategories = false;
      this.navbarVisible = false;
      this.showModal = false;
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
        let newQuantity = Math.min(
          item.quantity,
          product ? product.quantity : item.quantity
        );
        if (newQuantity !== item.quantity) {
          this.cartMessage = `Há alterações no seu carrinho`;
        }
        return {
          ...item,
          price: product ? product.price : item.price,
          quantity: newQuantity,
        };
      });

      deleteCookie("cart");
      setCookie("cart", this.cartItems, 7);
      this.cartItemCount = cart.reduce((total, item) => total + item.quantity, 0);
      this.totalPrice = this.cartItems.reduce(
        (total, item) => total + item.quantity * item.price,
        0
      );
    },
    toggleCart() {
      this.cartVisible = !this.cartVisible;
      this.cartMessage = null;
      this.navbarVisible = false;

      this.showModal = false;
      this.showBrands = false;
      this.showCategories = false;
    },

    toggleCheckoutForm() {
      if (!this.checkoutVisible) {
        if (this.cartItems.length === 0) {
          alert("Adicione produtos ao carrinho para finalizar a compra");
          return;
        }
        if (this.cartItems.some((item) => item.quantity === 0)) {
          removeFromCart(item);
          return;
        }
      }
      this.checkoutVisible = !this.checkoutVisible;
    },
    completeCheckout() {
      if (!this.customerName || !this.customerWhatsapp) {
        alert("Preencha o nome e o whatsapp para finalizar a compra");
        return;
      }

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
              "X-CSRF-TOKEN": this.csrfToken,
            },
          }
        )
        .then((response) => {
          this.orderConfirmationVisible = true;
          this.whatsappLink = response.data.whatsapp_link;
          this.cart = response.data;
          this.clearCart();
          this.getProducts();
        })
        .catch((error) => {
          if (error.response && error.response.status === 419) {
            alert("Por favor, atualize a página e tente novamente.");
            return;
          }
          alert("Ocorreu um erro, tente novamente mais tarde!");
          console.error("Erro:", error);
        });
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
    toggleBrands() {
      this.showBrands = !this.showBrands;
      this.showCategories = false;
      this.showModal = false;
      this.cartVisible = false;
    },
    toggleCategories() {
      this.showCategories = !this.showCategories;
      this.showBrands = false;
      this.showModal = false;
      this.cartVisible = false;
    },

    handleError(event) {
      event.target.src = "/default.png";
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
