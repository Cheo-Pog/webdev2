<template>
    <section>
      <div class="container">
        <h2 class="mt-3 mt-lg-5">dashboard</h2>
      </div>
      <div class="row mt-3">
      <router-link to="/admin/categories">categories</router-link>
      </div>
      <div class="row mt-3">
      <router-link to="/admin/users" >users</router-link>
      </div>
      <div class="row mt-3">
      <router-link to="/admin/orders" >orders</router-link>
      </div>

    </section>
  </template>
  
  <script>
  import axios from "../../axios-auth";
  import {useStore} from "../../stores/store.js"
  
  export default {
    name: "Admin-Dashboard",
  };
  </script>
  
  <style>
  </style>