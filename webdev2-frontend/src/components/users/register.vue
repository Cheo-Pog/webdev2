<template>
    <section>
      <div class="container">
        <h1 v-if="!isCreate">Register</h1>
        <h1 v-else>Create User</h1>
        <button class="btn btn-danger mt-3 mb-3" v-if="isCreate" @click="this.$router.push('/admin/users')">Cancel</button>
        <div class="row">
          <div class="col-md-6">
            <form>
              <div class="mb-3">
                <label for="inputemail" class="form-label">Email</label>
                <input id="inputemial" type="email" v-model="user.email" class="form-control"/>
              </div>
              <div class="mb-3">
                <label for="inputemail" class="form-label">first name</label>
                <input id="inputFName" type="text" v-model="user.firstname" class="form-control"/>
              </div>
              <div class="mb-3">
                <label for="inputemail" class="form-label">last name</label>
                <input id="inputLName" type="text" v-model="user.lastname" class="form-control"/>
              </div>
              <div class="mb-3">
                <label for="inputPassword" class="form-label">Password</label>
                <input type="password" class="form-control" v-model="user.password" id="inputPassword"/>
              </div>
              <div class="mb-3" v-if="isCreate">
                <label for="inputPassword" class="form-label">Rank</label>
                  <select class="form-select" v-model="user.rank">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                  </select>
              </div>
              <div class="alert alert-danger" v-if="errorMessage">{{errorMessage}}</div>
              <button type='button' class="btn btn-primary" @click="save">Submit</button>
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
    name: "Register",
    setup() {
      const store = useStore();
      return { store };
    },
    data() {
      return {
        user:{
          email: "",
          firstname: "",
          lastname: "",
          password: ""
        },
        errorMessage: "",
        isCreate: false,
      };
    },
    mounted() {
        this.isCreate = window.location.href.includes("create");
    },
    methods: {
      save() {
        if (this.user.email === "" || this.user.password === "" || this.user.firstname === "" || this.user.lastname === "") {
          this.errorMessage = "Please fill in all fields";
          return;
        }
        if (this.user.password.length < 8) {
          this.errorMessage = "Password must be at least 8 characters long";
          return;
        }

        axios
          .post("/users/register" , this.user)
          .then((res) => {
            if(this.isCreate){
              this.$router.replace("/admin/users")
            }
            else{
              this.$router.replace("/login")
            }
          })
          .catch((error) => this.errorMessage = error);
      }
    }
  }
  ;
  </script>
  
  <style>
  </style>