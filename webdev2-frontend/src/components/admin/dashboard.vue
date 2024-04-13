<template>
  <section>
    <div class="container">
      <h2 class="mt-3 mt-lg-5 text-center">Dashboard</h2>
      <div class="row mt-3">
        <div class="col-md-4">
          <router-link to="/admin/categories" class="dashboard-link">
            <div class="card">
              <div class="card-body">
                Categories
              </div>
            </div>
          </router-link>
        </div>
        <div class="col-md-4">
          <router-link to="/admin/users" class="dashboard-link">
            <div class="card">
              <div class="card-body">
                Users
              </div>
            </div>
          </router-link>
        </div>
        <div class="col-md-4"><router-link to="/admin/orders" class="dashboard-link">
            <div class="card">
              <div class="card-body">
                Orders
              </div>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from "../../axios-auth";
import { useStore } from "../../stores/store.js"

export default {
  name: "Admin-Dashboard",
};
</script>

<style scoped>
.dashboard-link {
  text-decoration: none;
  color: inherit;
}

.card {
  height: 100%;
  transition: transform 0.3s;
}

.card:hover {
  transform: translateY(-5px);
}
</style>