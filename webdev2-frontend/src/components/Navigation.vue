<template>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container-fluid">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <router-link to="/" class="nav-link" active-class="active">Home</router-link>
        </li>
        <div class="dropdown">
          <li class="nav-item">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Products
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <categoryList />
            </ul>
          </li>
        </div>
        <li class="nav-item right" v-if="isLoggedIn">
          <router-link to="/shoppingcart" class="nav-link" active-class="active">cart</router-link>
        </li>
      </ul>
      <ul class="navbar-nav">
        <div class="dropdown" v-if="isLoggedIn">
          <li class="nav-item d-flex">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              {{ name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDropdown">
              <li class="nav-item dropdown-item">
                <router-link to="/profile" class="nav-link" active-class="active"
                  style="color: black;">Profile</router-link>
              </li>
              <li class="nav-item dropdown-item">
                <div class="nav-link" @click="logout()" style="color: black;">Logout</div>
              </li>
            </ul>
          </li>
        </div>
        <li class="nav-item right" v-else>
          <router-link to="/login" class="nav-link" active-class="active">Login</router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>
<script>
import { useStore } from "../stores/store";
import categoryList from "./categories/categoryList.vue";

export default {
  name: "Navigation",
  components: {
    categoryList,
  },
  data() {
    return {
      isLoggedIn: this.store.isLoggedIn,
      name: this.store.user.firstname,
    }
  },
  watch: {
    '$route': function () {
      this.isLoggedIn = this.store.isLoggedIn;
      this.name = this.store.user.firstname;
    }
  },
  setup() {
    const store = useStore();
    return { store };
  },
  methods: {
    logout() {
      this.store.logout();
      this.$router.replace("/");

      this.$nextTick(() => {
        //zieke virus anders idk
        this.isLoggedIn = this.store.isLoggedIn;
        this.name = this.store.user.firstname;
      });
    }
  }
};
</script>

<style scoped></style>