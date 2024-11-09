<template>
  <header-admin></header-admin>
  <div class="body-container">
    <div class="left-box"></div>
    <div class="table">
      <div class="table-header">
        <div class="line">
          <div class="column column-name">Cliente</div>
          <div class="column">Subtotal</div>
          <div class="column brand-column">Total com desconto</div>
          <div class="column column-left"></div>
        </div>
      </div>
      <div class="body">
        <div v-for="order in orders" :key="order.id">
          <div
            class="line order-line"
            :class="{ active: isActive(order.id) }"
            @click="toggleDetails(order.id)"
          >
            <div class="column column-name">
              {{ order.client.name }}
            </div>

            <div class="column">
              {{ currencyFormat(order.total) }}
            </div>
            <div class="column">
              {{ currencyFormat(order.totalWithDiscount) }}
            </div>
            <div class="column column-left">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 320 512"
                :class="{ rotate: true, active: isActive(order.id) }"
              >
                <path
                  d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z"
                />
              </svg>
            </div>
          </div>
          <div class="details" :class="{ active: isActive(order.id) }">
            <p><strong>Contato:</strong>{{order.client.whatsapp}}</p>
            <p><strong>Data Pagamento:</strong>WIP</p>
            <div class="table-header">
              <div class="line">
                <div class="column column-name">Produto</div>
                <div class="column">Preço</div>
                <div class="column">Quantidade</div>
                <div class="column">Total item</div>
              </div>
            </div>
            <div v-for="orderProduct in order.orders_product" :key="orderProduct.id">
              <div class="line">
                <div class="column column-name">{{ orderProduct.product.name }}</div>
                <div class="column">{{ currencyFormat(orderProduct.price) }}</div>
                <div class="column">{{ orderProduct.quantity }}</div>
                <div class="column">
                  {{ currencyFormat(orderProduct.price * orderProduct.quantity) }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
      activeOrderId: null,
    };
  },
  created() {
    this.fetchOrders();
  },
  setup() {
    const orders = ref([]);

    const handleLogout = () => {
      store.logout();
      const router = useRouter();
      router.push("/login");
    };

    const isLoggedIn = computed(() => store.state.isLoggedIn);
    const username = computed(() => store.state.username);

    return {
      orders,
      isLoggedIn,
      username,
      handleLogout,
    };
  },
  methods: {
    async fetchOrders() {
      try {
        const response = await axios.get("/api/orders");
        this.orders = response.data;
      } catch (error) {
        console.error("Erro ao buscar pedidos:", error);
      }
    },
    currencyFormat(value) {
      return `R$ ${parseFloat(value).toFixed(2).replace(".", ",")}`;
    },
    toggleDetails(orderId) {
      this.activeOrderId = this.activeOrderId === orderId ? null : orderId;
    },
    isActive(orderId) {
      return this.activeOrderId === orderId;
    },
  },
};
</script>

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

.body-container {
  padding: 20px;
}

.card {
  border: 1px solid #ddd;
  padding: 10px;
}

.column {
  flex: 0 0 calc(19% - 4px);
  width: calc(19% - 4px);
  padding: 2px;
}
.column-name {
  flex: 0 0 calc(50% - 4px);
  width: calc(50% - 4px);
}
.column-left {
  display: flex;
  align-items: flex-end;
  justify-content: flex-end;
  flex: 0 0 5%;
  max-width: 5%;
  padding: 0px;
}

.line {
  display: flex;
  padding: 4px;
  align-items: center;
  cursor: pointer;
}
.order-line {
  font-weight: bold;
}
.body .line:not(.active),
.body .details {
  border-bottom: 1px solid #ccc;
}

.details {
  padding: 8px 16px;
  background-color: #f9f9f9;
  border-top: solid 1px #eee;
  display: none;
}
.details .table-header {
  background-color: #0056b310;
  font-weight: 500;
  border-radius: 0;
  padding: 8px 8px 4px 8px;
  color: #555;
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
