<template>
  <div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark container-fluid px-4">
      <router-link to="/" class="navbar-brand d-flex align-items-center gap-2" style="font-weight:700">
        Shopify <ShoppingCartOutlined style="color:white" />
      </router-link>

      <div class="collapse navbar-collapse show">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <router-link to="/" class="nav-link" exact>Home</router-link>
          </li>
          <li v-if="!isLoggedIn" class="nav-item">
            <router-link to="/register" class="nav-link">Register</router-link>
          </li>
          <li v-if="!isLoggedIn" class="nav-item">
            <router-link to="/login" class="nav-link">Login</router-link>
          </li>
          <li class="nav-item">
            <button @click="logout" class="btn btn-danger fw-bold">Logout</button>
          </li>
          <li class="nav-item">
            <router-link to="/product/1" class="nav-link">Product</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/cart" class="nav-link">Cart</router-link>
          </li>
        </ul>
      </div>
    </nav>

    <router-view />
  </div>
</template>

<script>
import { ShoppingCartOutlined } from '@ant-design/icons-vue';
import api from './api'; // your axios instance

export default {
  name: 'App',
  components: {
    ShoppingCartOutlined,
  },
  methods: {
    async logout() {
      try {
        const token = localStorage.getItem('api-token');
        if (!token) {
          alert("No token found. Please log in again.");
          return;
        }
        const response = await api.post('/logout', {}, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        localStorage.removeItem('api-token');
        alert("User logged out successfully");
        this.$router.push('/login');
      } catch (error) {
        this.error = "Logout failed. Please try again.";
      }
    },
  }
}
</script>

<style>
/* your styles from before */
</style>
