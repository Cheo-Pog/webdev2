<template>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <form>
            <div class="mb-3">
              <label for="inputUsername" class="form-label">Username</label>
              <input id="inputUsername" type="text" v-model="username" class="form-control"/>
            </div>
            <div class="mb-3">
              <label for="inputPassword" class="form-label">Password</label>
              <input type="password" class="form-control" v-model="password" id="inputPassword"/>
            </div>
            <div class="alert alert-danger" v-if="errorMessage">{{errorMessage}}</div>
            <button type='button' class="btn btn-primary" @click="login">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>

import { useStore } from '../stores/store';
import axios from '../axios-auth';

export default {
  name: "Login",
  setup() {
    const store = useStore();
    return { store };
  },
  data() {
    return {
      username: "",
      password: "",
      errorMessage: "",
    };
  },
  methods: {
    login() {
      this.store.login(this.username, this.password)
          .then(result => {
           this.$router.replace("/products")
          })
          .catch(error => this.errorMessage = error);
    }
  }
}
;
</script>

<style>

</style>