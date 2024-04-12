<template>
    <section>
        <div class="container">
            <button class="btn btn-danger " @click="this.$router.push('/admin')">Cancel</button>
            <button class="btn btn-primary float-end" @click="this.$router.push('/admin/users/create')">Create User</button>
            <h1>Users</h1>
            <div class="row">
                <div class="col-md-12 col-sm-8">
                    <div class="table-responsive">
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Email</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Rank</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-for="user in users">
                                <tr>
                                    <td>
                                        {{ user.id }}
                                    </td>
                                    <td>
                                        {{ user.email }}
                                    </td>
                                    <td>
                                        {{ user.firstname }}
                                    </td>
                                    <td>
                                        {{ user.lastname }}
                                    </td>
                                    <td>
                                        {{ user.rank }}
                                    </td>
                                    <td>
                                        <button class="btn btn-danger remove" @click="remove(user.id)">Remove</button>
                                        <button class="btn btn-primary remove" @click="this.$router.push('/admin/users/edit/' + Number(user.id))">Edit</button>
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
    name: "UsersIndex",
    data() {
        return {
            users: [],
        };
    },
    mounted() {
        this.update();
    },
    methods: {
        update() {
            axios
                .get("/users")
                .then((result) => {
                    this.users = result.data;
                })
                .catch((error) => console.log(error));
        },
        remove(id) {
            axios
                .delete("/users/" + id)
                .then((result) => {
                    this.update();
                })
                .catch((error) => console.log(error));
        },
    },
};
</script>

<style></style>