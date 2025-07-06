<template>
  <div>
    <!-- <h1>Welcome to the E-commerce Store</h1>
    <p>Featured Products will be shown here.</p> -->
    <section>
      <div class="banner-scroll-wrapper">
    <div class="banner-row" ref="bannerRow">
      <img
        v-for="banner in banners"
        :key="banner.id"
        :src="banner.image_url"
        alt="banner"
        class="banner-img"
      />
    </div>

    <button class="scroll-right" @click="scrollRight"><RightOutlined/>
</button>
  </div>
    </section>
    <section>
      <h3>Products</h3>
      <div class="product-list">
        <div v-for="product in products" :key="product.id" class="product-card">
          <img :src="product.image" style="width: 150px;" />
          <h4>{{ product.name }}</h4>
          <p>₹{{ product.price }}</p>
        </div>
      </div>
    </section>
  </div>
</template>
<script>

import api from '../api';
import { RightOutlined } from '@ant-design/icons-vue';
export default {
  name: 'App',
  components: {
    name: 'Home',
    RightOutlined

    
  },
  data(){
    return{
      banners:[],
      products: []
    }
  },
  
  async mounted(){
    const bannerRes = await api.get('/banners');
    const productRes = await api.get('/products');
    this.banners = bannerRes.data;
    this.products = productRes.data;
  },
  methods: {
    scrollRight() {
      const row = this.$refs.bannerRow;
      row.scrollBy({ left: 300, behavior: 'smooth' }); // scroll 300px right
    },
    scrollLeft() {
      const row = this.$refs.bannerRow;
      row.scrollBy({ left: -300, behavior: 'smooth' }); // scroll 300px right
    }
  }
}
</script>
<style scoped>
.banner-scroll-wrapper {
  overflow-x: auto;
  overflow-y: hidden;
  white-space: nowrap;
  padding: 10px 0;
  margin: 0 16px;
}

.banner-row {
  display: flex;
  gap: 20px;
  padding-bottom: 10px;
}

.banner-img {
  height: 160px;
  border-radius: 10px;
  transition: transform 0.3s;
  cursor: pointer;
  flex-shrink: 0;
}

.banner-img:hover {
  transform: scale(1.08);
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

/* Right Arrow Button */
.scroll-right {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  font-size: 22px;
  background-color: #ffffffcc;
  border: none;
  border-radius: 50%;
  padding: 6px 10px;
  cursor: pointer;
  z-index: 1;
}



</style>