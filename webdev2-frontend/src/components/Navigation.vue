<template>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container-fluid">
      <router-link to="/" class="navbar-brand">Home</router-link>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
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
          <li class="nav-item" v-if="isLoggedIn">
            <router-link to="/shoppingcart" class="nav-link" active-class="active">Cart</router-link>
          </li>
        </ul>

        <ul class="navbar-nav">
          <div class="dropdown" v-if="isLoggedIn">
            <li class="nav-item">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ name }}
              </a>
              <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDropdown">
                <li class="nav-item">
                  <router-link to="/profile" class="nav-link fix" active-class="active">Profile</router-link>
                </li>
                <li class="nav-item" v-if="rank >= 2">
                  <router-link to="/admin" class="nav-link fix" active-class="active">Admin</router-link>
                </li>
                <li class="nav-item">
                  <div class="nav-link danger" @click="logout()">Logout</div>
                </li>
              </ul>
            </li>
          </div>
          <li class="nav-item" v-if="!isLoggedIn">
            <router-link to="/login" class="nav-link" active-class="active">Login</router-link>
          </li>
          <li class="nav-item" v-if="!isLoggedIn">
            <router-link to="/register" class="nav-link" active-class="active">Register</router-link>
          </li>
        </ul>
      </div>
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
      rank: Number(this.store.user.rank),
    }
  },
  watch: {
    '$route': function () {
      this.isLoggedIn = this.store.isLoggedIn;
      this.name = this.store.user.firstname;
      this.rank = Number(this.store.user.rank);
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

<style scoped>
.fix {
  color: black !important;
}

.danger {
  color: red !important;
}
</style>