<template>
  <div>
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

    <h3 style="font-weight:700">Categories</h3>
    <div class="category-list">
      <button
        v-for="category in categories"
        :key="category.id"
        @click="filterByCategory(category.name)"
        class="category-button"
      >
        {{ category.name }}
      </button>
    </div>

    <section>
      <h3 style="font-weight:700">Products</h3>
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
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import api from '../api';

export default {
  name: 'Home',
  data() {
    return {
      banners: [],
      categories: [],
      products: [],
      filteredProducts: [],
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
  },
  methods: {
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
  },
};
</script>

<style scoped>
/* 🔹 Banner styles */
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
</style>
