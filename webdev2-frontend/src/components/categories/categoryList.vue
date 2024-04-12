<template>
    <router-link v-for="category in categories" :key="category.id" :to="'/products/category/' + category.id">
        <div class="nav-item" :value="category.id">
            <li class="dropdown-item nav-item">
                {{ category.name }}
            </li>
        </div>
    </router-link>
</template>

<script>
import axios from "../../axios-auth";
export default {
    name: "categoryList",
    data() {
        return {
            categories: [],
        };
    },
    mounted() {
        this.update();
    },
    watch: {
        '$route': function () {
            this.update();
        }
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