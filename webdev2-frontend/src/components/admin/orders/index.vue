<template>
    <section>
        <div class="container">
            <button class="btn btn-danger " @click="this.$router.push('/admin')">Cancel</button>
            <h1>Orders</h1>
            <div class="row">
                <div class="col-md-12 col-sm-8">
                    <div class="table-responsive">
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>User</th>
                                    <th>Total Price</th>
                                    <th>Order Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-for="order in orders">
                                <tr>
                                    <td>
                                        {{ order.id }}
                                    </td>
                                    <td>
                                        {{ order.user_id }}
                                    </td>
                                    <td>
                                        €{{ order.total_price }}
                                    </td>
                                    <td>
                                        {{ order.order_date }}
                                    </td>
                                    <td>
                                        <button class="btn btn-primary remove" @click="this.$router.push('/admin/orders/view/' + Number(order.id))">View</button>
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
    name: "orderIndex",
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
                .get("/orders")
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