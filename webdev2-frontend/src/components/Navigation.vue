<template>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container-fluid">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <router-link to="/" class="nav-link" active-class="active">Home</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/products" class="nav-link" active-class="active">Products</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/login" class="nav-link" active-class="active">Login</router-link>
        </li>
        <li class="nav-item">
          <button class="nav-link" active-class="active" @click="logout">Logout</button>
        </li>
      </ul>
    </div>
  </nav>
</template>
<script>
import { useStore } from "../stores/store";

export default {
  name: "Navigation",
  setup() {
    const store = useStore();
    return { store };
  },
   methods: {
    logout() {
      this.store.logout();
      this.$router.replace("/");
    }
  }
};
</script>

<style></style>