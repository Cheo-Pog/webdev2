<template>
  <section>
    <div class="container">
      <form ref="form">
        <h2 class="mt-3 mt-lg-5" v-if="isEdit">Edit a product</h2>
        <h2 class="mt-3 mt-lg-5" v-else>Create a product</h2>
        <h5 class="mb-4"></h5>

        <div class="input-group mb-3">
          <span class="input-group-text">Name</span>
          <input type="text" class="form-control" v-model="product.name" />
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text">Price</span>
          <input type="number" class="form-control" v-model="product.price" />
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text">Description</span>
          <textarea
            class="form-control"
            v-model="product.description"
          ></textarea>
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text">Image URL</span>
          <input type="text" class="form-control" v-model="product.image" />
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text">Category</span>
          <select class="form-select" v-model="product.category_id">
            <option
              v-for="category in categories"
              :key="category.id"
              :value="category.id"
            >
              {{ category.name }}
            </option>
          </select>
        </div>

        <div class="input-group mt-4">
          <button type="button" class="btn btn-primary" v-if="isEdit" @click="updateProduct">
            Save changes
          </button>
          <button type="button" class="btn btn-primary" v-else @click="createProduct">
            Create 
          </button>
          <button
            type="button"
            class="btn btn-danger"
            @click="this.$router.push('/admin/categories/edit/' + Number(product.category_id))">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import axios from "../../../axios-auth.js";

export default {
  name: "EditProduct",
  props: {
    id: Number,
  },
  data() {
    return {
      product: {
        id: 0,
        name: "",
        price: 0.0,
        description: "",
        image: "",
        category_id: 0,
      },
      categories: [],
      isEdit: true,
    };
  },
  methods: {
    updateProduct() {
      axios
        .put("/products/" + this.product.id, this.product)
        .then((res) => {
          console.log(res.data);
          this.$refs.form.reset();
          this.$router.push("/admin/categories/edit/" + this.product.category_id);
        })
        .catch((error) => console.log(error));
    },
    createProduct() {
      axios
        .post("/products", this.product)
        .then((res) => {
          this.$router.push("/admin/categories/edit/" + this.product.category_id);
        })
        .catch((error) => console.log(error));
    },
  },
  mounted() {
    axios
      .get("/categories")
      .then((result) => {
        console.log(result);
        this.categories = result.data;
        axios
          .get("/products/" + this.id)
          .then((result) => {
            this.product = result.data;
          })
          .catch((error) => console.log(error));
      })
      .catch((error) => console.log(error));
      this.isEdit = window.location.href.includes("edit");
  },
};
</script>

<style>
</style>