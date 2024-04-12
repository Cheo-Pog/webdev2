<template>
    <section>
        <div class="container">
            <button class="btn btn-danger " @click="this.$router.push('/admin/orders')">Cancel</button>
            <h1>Order Items</h1>
            <div class="row">
                <div class="col-md-12 col-sm-8">
                    <div class="table-responsive">
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Order Id</th>
                                    <th>Product Id</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody v-for="item in orders.order_items">
                                <tr>
                                    <td>
                                        {{ item.id }}
                                    </td>
                                    <td>
                                        {{ item.order_id }}
                                    </td>
                                    <td>
                                        {{ item.product_id }}
                                    </td>
                                    <td>
                                        {{ item.quantity }}
                                    </td>
                                    <td>
                                        €{{ item.price }}
                                    </td>
                                    <td>
                                        €{{ item.price * item.quantity }}
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
    name: "orderView",
    data() {
        return {
            orders: [],
        };
    },
    mounted() {
        this.update();
    },
    methods: {
        update() {
            axios
                .get("/orders/" + this.$route.params.id)
                .then((result) => {
                    this.orders = result.data;
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