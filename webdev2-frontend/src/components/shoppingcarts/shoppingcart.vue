<template>
  <section>
    <div class="container">
      <h1>Cart</h1>
      <div class="row">
        <div class="col-md-8 col-sm-12">
          <div class="table-responsive">
            <table id="cart" class="table table-hover table-condensed">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <cartItem v-for="item in cart" :key="item.id" :item="item" @update="update" />
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4>Summary</h4>
            </div>
            <div class="card-body">
              <p class="text-end">
                <strong>Total: €{{ totalprice.toFixed(2) }}</strong>
              </p>
              <button class="btn btn-primary" @click="checkout()">Checkout</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { useStore } from '../../stores/store.js';
import axios from "../../axios-auth.js";
import cartItem from "./cartItem.vue";

export default {
  name: "shoppingcart",
  setup() {
    const store = useStore();
    return { store };
  },
  components: {
    cartItem,
  },
  data() {
    return {
      cart: [],
      id: this.store.user.id,
      totalprice: 0,
    };
  },
  mounted() {
    this.update();
  },
  methods: {
    update(price) {
      axios
        .get("/shoppingcart/" + this.id)
        .then((result) => {
          this.cart = result.data;
          if (!isNaN(Number(price))) {
            this.totalprice += Number(price);
          }
        })
        .catch((error) => console.log(error));
    },
    checkout() {
      axios
        .delete("/shoppingcart/" + this.id)
        .then((result) => {
          this.cart = [];
          this.totalprice = 0;
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>

<style></style>