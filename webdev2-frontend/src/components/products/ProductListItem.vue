<template>
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xxl-3 p-2">
    <div class="card product-card h-100">
      <div class="card-body">
        <img :src="product.image" :alt="product.title" :title="product.title" />
        <div class="float-start">
          <p>{{ product.name }}</p>
          <p>
            <small>{{ product.category_name }}</small>
          </p>
        </div>
        <span class="price float-end">{{ product.price }}</span>
      </div>
      <div class="card-footer">
        <button class="btn btn-primary" @click="addToCart(product.id)">Add to cart</button>&nbsp;&nbsp;
      </div>
    </div>
  </div>
</template>

<script>
import { useStore } from "../../stores/store";
import axios from "axios";

export default {
  name: "ProductListItem",
  setup() {
    const store = useStore();
    return { store };
  },
  props: {
    product: Object,
  },
  methods: {
    addToCart(id) {
      axios
        .post("http://localhost/shoppingcart", { user_id: this.store.user.id ,product_id: id, quantity: 1 })
        .then((result) => {
          console.log(result);
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>

<style>
</style>