<template>
    <div class="" @click="isOpen = !isOpen">
        <a class="nav-link" href="#">
            Products</a>
        <div class="nav-item" v-for="category in categories" :key="category.id" :value="category.id" v-if="isOpen">
            <router-link :to="'/products/category/' + category.id">
                {{ category.name }}
            </router-link>
        </div>
    </div>
</template>

<script>
import axios from "../../axios-auth";
export default {
    name: "categoryList",
    data() {
        return {
            categories: [],
            isOpen: false,
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
                    console.log(result);
                    this.categories = result.data;
                })
                .catch((error) => console.log(error));
        },
    },
};
</script>

<style>
.menu-item {
    display: block;
    padding: 10px;
    background-color: #f9f9f9;
    border-bottom: 1px solid #ccc;
    cursor: pointer;

}
</style>