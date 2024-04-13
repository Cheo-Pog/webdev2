<template>
  <section>
    <div class="container">
      <h1 class="text-center">Login</h1>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <form>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input id="email" type="email" v-model="email" class="form-control" />
                </div>
                <div class="mb-3">
                  <label for="inputPassword" class="form-label">Password</label>
                  <input type="password" class="form-control" v-model="password" id="inputPassword" />
                </div>
                <div class="alert alert-danger" v-if="errorMessage">{{ errorMessage }}</div>
                <button type='button' class="btn btn-primary col-12" @click="login">Submit</button>
                <div class="mt-3">
                  <p>Don't have an account? <router-link to="/register">Register</router-link></p>
                </div>
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
      email: "",
      password: "",
      errorMessage: "",
    };
  },
  methods: {
    login() {
      if(this.email.includes("@") === false || this.email.includes(".") === false){
          this.errorMessage = "Please enter a valid email address";
          return;
        }
      this.store.login(this.email, this.password)
        .then(result => {
          this.password = "";
          this.$router.replace("/")
        })
        .catch(error => this.errorMessage = error.response.data.errorMessage);
    }
  }
}
  ;
</script>

<style></style>