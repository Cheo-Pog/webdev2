<template>
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xxl-3 p-2">
    <div class="card h-100">
      <div class="card-header h-100">
        <img :src="product.image" :alt="product.title" :title="product.title" class="card-img-top w-100" />
      </div>
      <div class="card-body"> 
        <p class="card-text float-end">{{ product.category_name }}</p>
        <h5 class="card-title">{{ product.name }}</h5>
        <p class="card-text">{{ product.description }}</p>
      </div>
      <div class="card-footer">
        <button class="btn btn-primary btn-sm" @click="addToCart(product.id)">Add to cart</button>
        <p class="card-text price float-end">€{{ product.price }}</p>
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
.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}

.btn-primary:focus,
.btn-primary.focus {
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
}
</style>