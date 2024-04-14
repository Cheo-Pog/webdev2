<template>
    <section>
        <div>
            <button class="btn btn-primary" @click="this.$router.push('/admin/products/create')">Create Product</button>
            <h1>products</h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th  class="d-none d-md-table-cell">Image</th>
                                    <th>Category Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-for="product in products">
                                <tr>
                                    <td>
                                        {{ product.name }}
                                    </td>
                                    <td>
                                        €
                                        {{ product.price }}
                                    </td>
                                    <td>
                                            {{ product.description }}
                                    </td>
                                    <td  class="d-none d-md-table-cell">
                                        {{ product.image }}
                                    </td>
                                    <td>
                                        {{ product.category_name }}
                                    </td>
                                    <td>
                                        <button class="btn btn-danger remove" @click="remove(product.id)">Remove</button>
                                        <button class="btn btn-primary remove" @click="this.$router.push('/admin/products/edit/' + Number(product.id))">Edit</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "../../../axios-auth.js";

export default {
    name: "productIndex",
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
                .get("/products/category/" + this.$route.params.id)
                .then((result) => {
                    this.products = result.data;
                })
                .catch((error) => console.log(error));
        },
        remove(id) {
            axios
                .delete("/products/" + id)
                .then((result) => {
                    this.update();
                })
                .catch((error) => console.log(error));
        },
    },
};
</script>

<style></style>