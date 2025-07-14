<template>
  <div>
    <div class="cart-icon-wrapper">
      <router-link to="/cart" class="cart-icon-wrapper">
    <ShoppingCartOutlined class="cart-icon" />
    <span v-if="cartCount > 0" class="cart-count-badge">{{ cartCount }}</span>
  </router-link>
      <div v-if="showCartPopup" class="cart-popup">
    <p><strong>{{ cartCount }}</strong> items in your cart</p>
    <button @click="goToCart" class="view-cart-btn">View Cart</button>
  </div>
    </div>
    <section>
      <div class="banner-scroll-wrapper">
        <button class="scroll-left" @click="scrollLeft">‹</button>
        <div class="banner-row" ref="bannerRow">
          <img
            v-for="banner in banners"
            :key="banner.id"
            :src="banner.image_url"
            :alt="`Banner ${banner.id}`"
            class="banner-img"
          />
        </div>
        <button class="scroll-right" @click="scrollRight">›</button>
      </div>
    </section>

    <h3 style="font-weight:700;text-align:center">Categories</h3>
    <div class="category-list">
      <button
        v-for="category in categories"
        :key="category.id"
        @click="filterByCategory(category.name)"
        class="category-button"
      >
      <FilterOutlined style="font-size: 20px; margin-right: 6px;color:blue" />
        {{ category.name }}
      </button>
    </div>

    <section>
      <h3 style="font-weight:700;text-align:center">Products</h3>
      <div class="product-list">
        <div
          v-for="product in filteredProducts"
          :key="product.id"
          class="product-card"
        >
          <img :src="product.image" style="width: 150px;" />
          <h4 style="font-weight:700;margin-top:40px">{{ product.name }}</h4>
          <p>₹{{ product.price }}</p>
          <p>{{ product.description }}</p>
          <div class="my-3 d-flex justify-content-center">
            <button @click="addToCart(product)" class="add-cart-btn">
            Add to <ShoppingCartOutlined style="font-size:120%" /> 
          </button>
          
          </div>
          <div v-if="getQuantity(product.id) > 0" class="cart-quantity">
            <span style="font-weight:bold">{{ getQuantity(product.id) }}</span>
          </div>
          <button @click="removeFromCart(product)" class="btn btn-danger fw-bold">
            Delete From <ShoppingCartOutlined style="font-size: 20px; margin-right: 6px;" /> 
          </button>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import api from '../api';
import { ShoppingCartOutlined,FilterOutlined } from '@ant-design/icons-vue';
export default {
  name: 'Home',
  components: {
    ShoppingCartOutlined,
    FilterOutlined
  },
  data() {
    return {
     showCartPopup: false,
      banners: [],
      categories: [],
      products: [],
      filteredProducts: [],
      cart: [],
      cartCount:0
    };
  },
  async mounted() {
    const catRes = await api.get('/categories');
    const bannerRes = await api.get('/banners');
    const productRes = await api.get('/products');

    this.banners = bannerRes.data;
    this.products = productRes.data;
    this.filteredProducts = productRes.data;

    this.categories = [{ id: 0, name: 'All' }, ...catRes.data];
    await this.loadCart();
  },
  methods: {
    toggleCartPopup() {
      this.showCartPopup = !this.showCartPopup;
    },
    goToCart() {
      this.$router.push('/cart');
      this.showCartPopup = false;
    },
    async loadCart() {
  try {
    const res = await api.get('/cart');
    this.cart = res.data;
    this.cartCount = res.data.reduce((total, item) => total + item.quantity, 0);
  } catch (error) {
    console.error('Failed to load cart:', error);
  }
},
    async addToCart(product) {
  try {
    await api.post('/cart/add', { product_id: product.id });
    await this.loadCart();
    alert('Product added to cart');
  } catch (error) {
    console.error('Add to cart failed:', error);
    if (error.response && error.response.status === 401) {
      alert('Please login to add to cart');
    } else {
      // Show a different alert for other types of errors
      alert('Something went wrong while adding to cart.');
    }
  }
},

  getQuantity(productId) {
    const found = this.cart.find(item => item.id === productId);
    return found ? found.quantity : 0;
  },
    async filterByCategory(categoryName) {
      if (categoryName === 'All') {
        this.filteredProducts = this.products;
      } else {
        const res = await api.get('/products', {
          params: {
            category: categoryName,
          },
        });
        this.filteredProducts = res.data;
      }
    },
    scrollRight() {
      const row = this.$refs.bannerRow;
      row.scrollBy({ left: 300, behavior: 'smooth' });
    },
    scrollLeft() {
      const row = this.$refs.bannerRow;
      row.scrollBy({ left: -300, behavior: 'smooth' });
    },
    async removeFromCart(product) {
  try {
    await api.delete(`/cart/${product.id}`);
    await this.loadCart(); 
    alert('Product removed from cart');
  } catch (error) {
    console.error('Remove from cart failed:', error);
    alert('Something went wrong while removing from cart.');
  }
}

  },
};
</script>

<style scoped>
.banner-scroll-wrapper {
  position: relative;
  overflow-x: hidden;
  padding: 10px 16px;
}

.banner-row {
  display: flex;
  gap: 20px;
  overflow-x: auto;
  scroll-behavior: smooth;
  padding-bottom: 10px;
}

.banner-img {
  width: 40%;
  height: 260px;
  object-fit: cover;
  border-radius: 10px;
  transition: transform 0.3s;
  cursor: pointer;
  flex-shrink: 0;
}

.banner-img:hover {
  transform: scale(1.08);
}

.scroll-right,
.scroll-left {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  font-size: 22px;
  background-color: black;
  color: white;
  border: none;
  border-radius: 50%;
  padding: 6px 10px;
  cursor: pointer;
  z-index: 1;
}

.scroll-right {
  right: 10px;
}

.scroll-left {
  left: 10px;
}

/* 🔹 Product styles */
.product-list {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center;
  padding: 20px 0;
}

.product-card {
  width: 200px;
  border: 1px solid #eee;
  border-radius: 8px;
  padding: 16px;
  text-align: center;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s;
  background-color: #fff;
}

.product-card:hover {
  transform: translateY(-4px);
}

/* 🔹 Category button styles */
.category-list {
  display: flex;
  gap: 12px;
  padding: 10px 0;
  flex-wrap: wrap;
  justify-content: center;
}

.category-button {
  background-color: #f0f0f0;
  border: none;
  padding: 8px 16px;
  font-weight: bold;
  border-radius: 20px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.category-button:hover {
  background-color: #ffd166;
}
.add-cart-btn {
  background-color: #2ecc71;
  color: white;
  border: none;
  padding: 8px 14px;
  margin-top: 10px;
  cursor: pointer;
  border-radius: 6px;
  font-weight: bold;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  font-size: 14px;
}

.add-cart-btn:hover {
  background-color: #27ae60;
}
.cart-container {
  display: flex;
  justify-content: flex-end; /* ✅ Pushes it to the right */
  align-items: center;
  padding: 0 16px;
}

.cart-icon-wrapper {
  position: relative;
  display: inline-block;
  cursor: pointer;
}

.cart-icon {
  font-size: 56px;
  color: #333;
}

.cart-count-badge {
  position: absolute;
  top: -6px;
  right: -10px;
  background-color: #f5222d;
  color: white;
  border-radius: 50%;
  padding: 2px 6px;
  font-size: 12px;
  font-weight: bold;
  line-height: 1;
}
.cart-popup {
  position: absolute;
  top: 45px;
  right: 0;
  background-color: white;
  padding: 10px 14px;
  border: 1px solid #ccc;
  border-radius: 6px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  z-index: 100;
  width: 160px;
  text-align: center;
}

.popup-button {
  background-color: #00b894;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
  margin-top: 6px;
}

.popup-button:hover {
  background-color: #019970;
}

</style>
