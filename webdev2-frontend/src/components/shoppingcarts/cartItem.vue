<template>
    <tr>
        <td>
            {{ product.name }}
        </td>
        <td>
            €
            {{ product.price }}
        </td>
        <td>
            <button class="btn btn-primary quantity" @click="subtrackt()">-</button>
            <span class="quantity-value">
                {{ item.quantity }}
            </span>
            <button class="btn btn-primary quantity" @click="add()">+</button>
        </td>
        <td>
            {{ totalprice }}
        </td>
        <td>
            <button class="btn btn-danger remove" @click="remove()">Remove</button>
        </td>
    </tr>
</template>

<script>
import axios from "../../axios-auth.js";

export default {
    name: "cartItem",
    props: {
        item: Object,
    },
    data() {
        return {
            product: {},
            totalprice: 0,
        };
    },
    mounted() {
        this.init();
    },
    methods: {
        init() {
            axios
                .get("/products/" + this.item.product_id)
                .then((result) => {
                    this.product = result.data;
                    this.totalprice = (this.product.price * this.item.quantity).toFixed(2);
                    this.$emit("update", this.totalprice);
                })
                .catch((error) => console.log(error));
        },
        remove() {
            axios
                .delete("/shoppingcart/" + this.item.id)
                .then((result) => {
                    this.$emit("update", -this.totalprice);
                })
                .catch((error) => console.log(error));
        },
        subtrackt() {
            if (this.item.quantity > 1) {
                axios
                    .put("/shoppingcart/" + this.item.id, { quantity: this.item.quantity - 1 })
                    .then((result) => {
                        this.totalprice = (this.product.price * (this.item.quantity -1)).toFixed(2);
                        this.$emit("update", -this.product.price);
                    })
                    .catch((error) => console.log(error));
            }else{
                alert("You can't have less than 1 item in your cart")
            }
        },
        add() {
            axios
                .put("/shoppingcart/" + this.item.id, { quantity: this.item.quantity + 1 })
                .then((result) => {
                    this.totalprice = (this.product.price * (this.item.quantity + 1)).toFixed(2);
                    this.$emit("update", this.product.price);
                })
                .catch((error) => console.log(error));
        },
    },
};
</script>

<style scoped></style>