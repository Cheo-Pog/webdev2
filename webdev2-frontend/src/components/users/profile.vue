<template>
    <section>
        <div class="container">
            <h1 class="text-center" v-if="!isEdit">Profile</h1>
            <h1 class="text-center" v-else>Edit User</h1>
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label for="inputemail" class="form-label">Email</label>
                                    <input id="inputemial" type="email" v-model="user.email" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label for="inputemail" class="form-label">First Name</label>
                                    <input id="inputFName" type="text" v-model="user.firstname" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label for="inputemail" class="form-label">Last Name</label>
                                    <input id="inputLName" type="text" v-model="user.lastname" class="form-control" />
                                </div>
                                <div class="mb-3" v-if="!isEdit">
                                    <label for="inputPassword" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" v-model="user.password"
                                        id="inputPassword" />
                                </div>
                                <div class="mb-3" v-else>
                                    <label for="inputPassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" v-model="user.password"
                                        id="inputPassword" />
                                </div>
                                <div class="mb-3" v-if="isEdit">
                                    <label for="inputPassword" class="form-label">Rank</label>
                                    <select class="form-select" v-model="user.rank">
                                        <option value="1">User</option>
                                        <option value="2">Admin</option>
                                    </select>
                                </div>

                                <div class="alert alert-danger" v-if="errorMessage">{{ errorMessage }}</div>
                                <button type="button" class="btn btn-primary col-6" @click="save">Save</button>

                                <button type="button" class="btn btn-danger col-6" v-if="!isEdit"
                                    @click="this.$router.push('/')">Cancel</button>
                                <button type="button" class="btn btn-danger col-6" v-else
                                    @click="this.$router.push('/admin/users')">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>


<script>

import { useStore } from '../../stores/store';
import axios from '../../axios-auth';

export default {
    name: "Login",
    setup() {
        const store = useStore();
        return { store };
    },
    data() {
        return {
            user: {
                id: 0,
                email: "",
                firstname: "",
                lastname: "",
                password: "",
                rank: "",
            },
            errorMessage: "",
            isEdit: true,
        };
    },
    mounted() {
        this.isEdit = window.location.href.includes("edit");
        if (this.isEdit) {
            this.loadUser();
        }
        else {
            this.user = {
                id: this.store.user.id,
                email: this.store.user.email,
                firstname: this.store.user.firstname,
                lastname: this.store.user.lastname,
                password: "",
                rank: this.store.user.rank,
            }
        }
    },
    methods: {
        save() {
            if (this.user.email === "" || this.user.password === "" || this.user.firstname === "" || this.user.lastname === "") {
                this.errorMessage = "Please fill in all fields";
                return;
            }
            if (this.user.email.includes("@") === false || this.user.email.includes(".") === false) {
                this.errorMessage = "Please enter a valid email address";
                return;
            }
            if (this.isEdit) {
                this.saveAdmin();
                return;
            }
            if (/[^a-zA-Z0-9@.]/.test(this.user.email) || /[^a-zA-Z0-9]/.test(this.user.firstname) || /[^a-zA-Z0-9]/.test(this.user.lastname)) {
                this.errorMessage = "Please refrain from using special characters in your email, first name, and last name fields.";
                return;
            }
            axios
                .put("/users/" + this.user.id, this.user)
                .then((res) => {
                    this.store.setUser(res.data);
                    this.$router.replace("/")
                })
                .catch((error) => this.errorMessage =  error.response.data.errorMessage);
        },
        saveAdmin() {
            axios
                .put("/users/admin/" + this.user.id, this.user)
                .then((res) => {
                    this.$router.push("/admin/users");
                })
                .catch((error) => this.errorMessage = error.response.data.errorMessage);
        },
        loadUser() {
            axios
                .get("/users/" + this.$route.params.id)
                .then((res) => {
                    this.user = res.data;
                })
                .catch((error) => this.errorMessage = error.response.data.errorMessage);
        }
    }
}
    ;
</script>

<style></style>