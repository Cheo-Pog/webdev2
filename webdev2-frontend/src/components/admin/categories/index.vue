<template>
    <section>
        <div class="container">
            <button class="btn btn-danger " @click="this.$router.push('/admin')">Cancel</button>
            <button class="btn btn-primary float-end" @click="this.$router.push('/admin/categories/create')">Create Category</button>
            <h1>Categories</h1>
            <div class="row">
                <div class="col-md-12 col-sm-8">
                    <div class="table-responsive">
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-for="category in categories">
                                <tr>
                                    <td>
                                        {{ category.id }}
                                    </td>
                                    <td>
                                        {{ category.name }}
                                    </td>
                                    <td>
                                        <button class="btn btn-danger remove" @click="remove(category.id)">Remove</button>
                                        <button class="btn btn-primary remove" @click="this.$router.push('/admin/categories/edit/' + Number(category.id))">Edit</button>
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
    name: "CategoryIndex",
    data() {
        return {
            categories: [],
        };
    },
    mounted() {
        this.update();
    },
    methods: {
        update() {
            axios
                .get("/categories")
                .then((result) => {
                    this.categories = result.data;
                })
                .catch((error) => console.log(error));
        },
        remove(id) {
            axios
                .delete("/categories/" + id)
                .then((result) => {
                    this.update();
                })
                .catch((error) => console.log(error));
        },
    },
};
</script>

<style></style>