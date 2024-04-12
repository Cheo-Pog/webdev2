import { createRouter, createWebHistory } from 'vue-router'

import Home from '../components/Home.vue';
import ProductList from '../components/products/ProductList.vue';
import EditProduct from '../components/admin/products/EditProduct.vue';
import Login from '../components/users/Login.vue';
import shoppingcart from '../components/shoppingcarts/shoppingcart.vue';
import Profile from '../components/users/Profile.vue';
import Register from '../components/users/Register.vue';
import AdminDashboard from '../components/admin/Dashboard.vue';
import productIndex from '../components/admin/products/index.vue';
import CategoryIndex from '../components/admin/categories/index.vue';
import EditCategory from '../components/admin/categories/EditCategory.vue';
import UsersIndex from '../components/admin/users/index.vue';
import OrderIndex from '../components/admin/orders/index.vue';
import OrderView from '../components/admin/orders/view.vue';


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', component: Home },
    { path: '/products', component: ProductList },
    { path: '/login', component: Login },
    { path: '/admin/products/edit/:id', component: EditProduct, props: true },
    { path: '/admin/products/create', component: EditProduct, props: false},
    { path: '/products/category/:id', component: ProductList},
    { path: '/shoppingcart', component: shoppingcart},
    { path: '/profile', component: Profile},
    { path: '/register', component: Register},
    { path: '/admin', component: AdminDashboard},
    { path: '/admin/products', component: productIndex},
    { path: '/admin/categories', component: CategoryIndex},
    { path: '/admin/categories/edit/:id', component: EditCategory, props: true},
    { path: '/admin/categories/create', component: EditCategory, props: false},
    { path: '/admin/users', component: UsersIndex},
    { path: '/admin/users/edit/:id', component: Profile, props: true},
    { path: '/admin/users/create', component: Register, props: false},
    { path: '/admin/orders', component: OrderIndex},
    { path: '/admin/orders/view/:id', component: OrderView, props: true},
  ]
})

export default router
