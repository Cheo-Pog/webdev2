<template>
  <section>
    <div class="container">
      <h2 class="mt-3 mt-lg-5">Welcome to the homepage</h2>
    </div>
    <product-list-item
          v-for="product in products"
          :key="product.id"
          :product="product"
          @update="update"
        />    
  </section>
</template>

<script>
import axios from "axios";
import ProductListItem from "./Products/ProductListItem.vue";
export default {
  name: "Home",
  components: {
    ProductListItem,
  },
  data() {
    return {
      products: [],
    };
  },
  mounted() {
    this.update();
  },
  methods: {
    update() {
      axios
        .get("/products")
        .then((result) => {
          console.log(result);
          this.products = result.data;
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>

<style>
</style>