<template>
  <section>
    <div class="container">
      <h2 class="mt-3 mt-lg-5 text-center">Welcome to the homepage</h2>
      <p class="text-center">Check out some of my products!</p>
    </div>
    <div class="row mt-3 margin">
      <product-list-item
        v-for="product in randomProducts"
        :key="product.id"
        :product="product"
        class="col-md-6"
      />  
    </div>  
  </section>
</template>

<script>
import axios from "../axios-auth";
import ProductListItem from "./Products/ProductListItem.vue";

export default {
  name: "Home",
  components: {
    ProductListItem,
  },
  data() {
    return {
      products: [],
      randomProducts: [],
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      axios
        .get("/products")
        .then((result) => {
          this.products = result.data;
          this.randomProducts = this.getRandomProducts(this.products, 6);
        })
        .catch((error) => console.log(error));
    },
    getRandomProducts(products, count) {
      if(count > products.length) {
        return products;
      }
      let randomProducts = [];
      let usedIndex = new Set();
      while (randomProducts.length < count) {
        let randomIndex = Math.floor(Math.random() * products.length);
        if (!usedIndex.has(randomIndex)) {
          randomProducts.push(products[randomIndex]);
          usedIndex.add(randomIndex);
        }
      }
      return randomProducts;
    },
  },
};
</script>

<style>
.margin {
  margin-left: 5%;
  margin-right: 5%;
}
</style>