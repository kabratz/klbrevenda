<template>
    <div class="cart">
        <h2>Carrinho de Compras</h2>
        <div v-for="item in cart" :key="item.product_id" class="cart-item">
            <p>{{ item.name }} - {{ item.quantity }} x {{ item.price }}</p>
            <button @click="removeFromCart(item.product_id)">Remover</button>
        </div>
        <button @click="checkout">Finalizar Pedido</button>
    </div>
</template>

<script>
export default {
    props: ['cart'],
    methods: {
        removeFromCart(productId) {
            axios.post('/cart/remove', { product_id: productId }).then(response => {
                this.$emit('update:cart', response.data);
            });
        },
        checkout() {
            axios.post('/order/checkout', { client_id: 1 }).then(response => {
                alert(response.data.message);
            });
        }
    }
};
</script>
