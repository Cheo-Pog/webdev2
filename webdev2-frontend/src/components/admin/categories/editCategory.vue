<template>
    <section>
        <div class="container">
            <form ref="form">
                <h2 class="mt-3 mt-lg-5" v-if="isEdit">Edit a Category</h2>
                <h2 class="mt-3 mt-lg-5" v-else>Create a Category</h2>
                <h5 class="mb-4"></h5>
                <div class="input-group mb-3">
                    <span class="input-group-text">Name</span>
                    <input type="text" class="form-control" v-model="Category.name" />
                </div>
                <div class="input-group mt-4">
                    <button type="button" class="btn btn-primary" v-if="isEdit" @click="updateCategory">
                        Save changes
                    </button>
                    <button type="button" class="btn btn-primary" v-else @click="createCategory">
                        Create
                    </button>
                    <button type="button" class="btn btn-danger" @click="this.$router.push('/admin/categories')">
                        Cancel
                    </button>
                </div>
            </form>
            <productIndex class="mt-5" v-if="isEdit"/>
        </div>
    </section>
</template>

<script>
import axios from "../../../axios-auth.js";
import productIndex from "../products/index.vue";


export default {
    name: "EditCategory",
    components: {
        productIndex,
    },
    props: {
        id: Number,
    },
    data() {
        return {
            Category: {
                id: 0,
                name: "",
            },
            isEdit: true,
        };
    },
    methods: {
        updateCategory() {
            axios
                .put("/categories/" + this.Category.id, this.Category)
                .then((res) => {
                    this.$router.push("/admin/categories");
                })
                .catch((error) => console.log(error));
        },
        createCategory() {
            axios
                .post("/categories", this.Category)
                .then((res) => {
                    this.$router.push("/admin/categories");
                })
                .catch((error) => console.log(error));
        },
    },
    mounted() {
        axios
            .get("/categories/" + this.id)
            .then((result) => {
                this.Category = result.data;
            })
            .catch((error) => console.log(error));
    this.isEdit = window.location.href.includes("edit");
},
};
</script>

<style></style>