<template>
  <div class="cart-page">
    <h2 style="text-align:center; font-weight:bold;">Items in 🛒</h2>

    <div v-if="cart.length === 0" class="empty-cart">
      <router-link to="/">Go Back To Home</router-link>
      <p>Your cart is empty.</p>
    </div>

    <div v-else class="cart-list">
      <div v-for="item in cart" :key="item.id" class="cart-card">
        <img :src="item.product.image" alt="Product Image" class="cart-image" />
        <div class="cart-details">
          <h4>{{ item.product.name }}</h4>
          <p>₹{{ item.product.price }}</p>
          <p>Quantity: {{ item.quantity }}</p>
          <button class="btn btn-danger" @click="removeFromCart(item.product.id)" style="font-weight:700">
           <DeleteOutlined/> Remove
          </button>
        </div>
      </div>
    </div>
  </div>
  <div style="width: 45%; margin: 20px auto; padding: 16px; border: 1px solid #ddd; border-radius: 8px; background-color: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.1); text-align: center;">
  <div>
    <p style="font-weight:600; margin: 8px 0;">Subtotal ({{ cartCount }} items)</p>
  </div>
  <div>
    <p style="font-weight:600; margin: 8px 0;">Total Price: ₹{{ totalPrice }}</p>
  </div>
  <div style="text-align: center;">
  <p style="font-size: 120%; margin: 0 auto; max-width: 80%;">
    Shipping and taxes will be calculated at checkout
  </p>
</div>
  <div style="text-align: center;">
  <button class="btn btn-danger mt-4" style="font-weight:700">Checkout</button>
</div>

</div>

</template>

<script>
import api from '../api';
import { DeleteOutlined } from '@ant-design/icons-vue';
export default {
  name: 'Cart',
  components: {
    DeleteOutlined
  },
  data() {
    return {
      cart: [],
      totalPrice: 0
    };
  },
  async mounted() {
    await this.loadCart();
  },
  methods: {
    async loadCart() {
      try {
        const res = await api.get('/cart');
        this.cart = res.data;
        this.cartCount = this.cart.reduce((total, item) => total + item.quantity, 0);
        this.totalPrice = this.cart.reduce((sum, item) => sum + item.quantity * item.product.price, 0);
      } catch (error) {
        console.error('Failed to load cart', error);
      }
    },
    async removeFromCart(productId) {
      try {
        await api.delete(`/cart/${productId}`);
        await this.loadCart(); 
        alert('Item removed from cart');
      } catch (error) {
        console.error('Remove failed', error);
      }
    }
  }
};
</script>

<style scoped>
.cart-page {
  max-width: 800px;
  margin: auto;
  padding: 20px;
}
.cart-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}
.cart-card {
  display: flex;
  align-items: center;
  gap: 20px;
  border: 1px solid #ddd;
  padding: 16px;
  border-radius: 8px;
  background-color: #fff;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}
.cart-image {
  width: 170px;
  height: 180px;
  object-fit: cover;
  border-radius: 8px;
}
.cart-details {
  flex: 1;
}
.empty-cart {
  text-align: center;
  margin-top: 40px;
  font-size: 18px;
}
</style>
