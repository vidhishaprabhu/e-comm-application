<template>
  <div class="cart-coupon">
    <input v-model="couponCode" placeholder="Enter coupon code" />
    <button @click="applyCoupon">Apply</button>
    <p v-if="error" class="error">{{ error }}</p>
    <p v-if="discount">Discount: ₹{{ discount }} | New Total: ₹{{ newTotal }}</p>
  </div>
</template>

<script>
import api from '@/api';
export default {
  data() {
    return {
      couponCode: '',
      error: '',
      discount: 0,
      newTotal: this.cartTotal // passed or computed from cart
    };
  },
  props: ['cartTotal'],
  methods: {
    async applyCoupon() {
      this.error=''; this.discount=0;
      try {
        const res = await api.post('/coupons/apply', {
          code:this.couponCode,
          cart_total:this.cartTotal
        });
        this.discount = res.data.discount;
        this.newTotal = res.data.new_total;
      } catch (err) {
        this.error = err.response?.data?.error || 'Failed to apply coupon';
      }
    }
  }
}
</script>

<style>
.cart-coupon { margin: 20px 0; }
.error { color: red; }
</style>
