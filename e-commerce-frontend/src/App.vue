<template>
<div id="app">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark container-fluid px-4">
  <router-link to="/" class="navbar-brand d-flex align-items-center gap-2" style="font-weight:700">
  Shopify
</router-link>

  <div class="collapse navbar-collapse show">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <router-link to="/" class="nav-link" exact>Home</router-link>
      </li>
      <li class="nav-item">
        <router-link to="/login" class="nav-link">Login</router-link>
      </li>
      <li class="nav-item">
        <router-link to="/product/1" class="nav-link">Product</router-link>
      </li>
    </ul>
  </div>
</nav>
</div>

<router-view />
</template>

<script>
export default {
  name: 'App',
  components: {
    

  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

.navbar {
  background-color: #2c3e50;
  padding: 12px 24px;
  display: flex;
  justify-content: center;
  gap: 24px;
  align-items: center;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}

.nav-link {
  color: #ecf0f1;
  text-decoration: none;
  font-weight: bold;
  font-size: 16px;
  transition: color 0.3s, border-bottom 0.3s;
  padding-bottom: 4px;
}

.nav-link:hover {
  color: #ffd166;
  border-bottom: 2px solid #ffd166;
}

.nav-link.router-link-exact-active {
  color: #00d1b2;
  border-bottom: 2px solid #00d1b2;
}

* {
  margin: 0;
  padding: 0;
}
/* Remove default browser spacing */
html, body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
#app {
  margin: 0;
  padding: 0;
}

</style>
