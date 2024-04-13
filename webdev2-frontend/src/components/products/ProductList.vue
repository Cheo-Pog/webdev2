<template>
  <section>
    <div class="container">
      <h2 class="mt-3 mt-lg-5 text-center">Here are some of my {{ name}}</h2>
    </div>
      <div class="row mt-3 margin">
        <product-list-item
          v-for="product in products"
          :key="product.id"
          :product="product"
          @update="update"
        />
      </div>
  </section>
</template>

<script>
import axios from "../../axios-auth";

import ProductListItem from "./ProductListItem.vue";

export default {
  name: "ProductList",
  components: {
    ProductListItem,
  },
  data() {
    return {
      products: [],
      name: '',
    };
  },
  watch: {
    // anders doet hij het niet als je vanuit een andere product page komt
    '$route': 'update'
  },
  mounted() {
    this.update();
  },
  methods: {
    update() {
      axios
        .get("/products/category/" + this.$route.params.id)
        .then((result) => {
          this.products = result.data;
          this.name = this.products[0].category_name;
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>

<style>
</style>