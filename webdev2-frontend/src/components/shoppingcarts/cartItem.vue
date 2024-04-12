<template>
    <tr>
        <td>
            {{ item.product.name }}
        </td>
        <td>
            €
            {{ item.product.price }}
        </td>
        <td>
            <button class="btn btn-primary quantity" @click="subtrackt()">-</button>
            <span class="quantity-value">
                {{ item.quantity }}
            </span>
            <button class="btn btn-primary quantity" @click="add()">+</button>
        </td>
        <td>
            €{{ totalprice }}
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
            totalprice: 0,
        };
    },
    mounted() {
        this.totalprice = (this.item.product.price * this.item.quantity).toFixed(2);
        this.init();
    },
    methods: {
        init() {
            this.$emit("update", this.totalprice);
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
                        this.totalprice = (this.item.product.price * (this.item.quantity -1)).toFixed(2);
                        this.$emit("update", -this.item.product.price);
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
                    this.totalprice = (this.item.product.price * (this.item.quantity + 1)).toFixed(2);
                    this.$emit("update", this.item.product.price);
                })
                .catch((error) => console.log(error));
        },
    },
};
</script>

<style scoped></style>