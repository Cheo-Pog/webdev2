<template>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <div class="mb-3">
                            <label for="inputemail" class="form-label">Email</label>
                            <input id="inputemial" type="text" v-model="user.email" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="inputemail" class="form-label">first name</label>
                            <input id="inputFName" type="text" v-model="user.firstname" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="inputemail" class="form-label">last name</label>
                            <input id="inputLName" type="text" v-model="user.lastname" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" v-model="user.password" id="inputPassword" />
                        </div>
                        <div class="mb-3" v-if="isEdit">
                            <label for="inputPassword" class="form-label">Rank</label>
                            <select class="form-select" v-model="user.rank">
                                <option value="1">User</option>
                                <option value="2">Admin</option>
                            </select>
                        </div>

                        <div class="alert alert-danger" v-if="errorMessage">{{ errorMessage }}</div>
                        <button type='button' class="btn btn-primary" v-if="!isEdit" @click="save">Edit</button>
                        <button type='button' class="btn btn-primary" v-else @click="saveAdmin">Edit</button>

                        <button type='button' class="btn btn-danger" v-if="!isEdit"
                            @click="this.$router.push('/')">Cancel</button>
                        <button type='button' class="btn btn-danger" v-else
                            @click="this.$router.push('/admin/users')">Cancel</button>
                    </form>
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
            axios
                .put("/users/" + this.user.id, this.user)
                .then((res) => {
                    this.store.setUser(res.data);
                    this.$router.replace("/")
                })
                .catch((error) => this.errorMessage = error);
        },
        saveAdmin() {
            axios
                .put("/users/admin/" + this.user.id, this.user)
                .then((res) => {
                    this.$router.push("/admin/users");
                })
                .catch((error) => this.errorMessage = error);
        },
        loadUser() {
            axios
                .get("/users/" + this.$route.params.id)
                .then((res) => {
                    this.user = res.data;
                })
                .catch((error) => this.errorMessage = error);
        }
    }
}
    ;
</script>

<style></style>