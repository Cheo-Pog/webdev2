import { defineStore } from "pinia";
import axios from '../axios-auth';

export const useStore = defineStore('store',
    {
        state: () => ({
            token: '',
            email: ''
        }),
        getters: {
            isLoggedIn: (state) => state.token != '',
        },
        actions: {
            login(email, password) {
                return new Promise((resolve, reject) => {
                    axios.post('/users/login', {
                        email: email,
                        password: password
                    })
                    .then(result => {
                        console.log(result);
                        alert(result.data);
                        axios.defaults.headers.common['Authorization'] = "Bearer " + result.data;
                        this.token = result.data;
                        this.email = email;
                        localStorage.setItem('token', result.data);
                        localStorage.setItem('username', email);
                        resolve();
                    })
                    .catch(error => reject(error.response.data.errorMessage));
                });
            },
            autoLoggin() {
                const token = localStorage.getItem('token');
                const username = localStorage.getItem('username');
                if (token) {
                    this.token = token;
                    this.email = username;
                    axios.defaults.headers.common['Authorization'] = "Bearer " + token;
                }
            },
            logout() {
                axios.post('/users/logout')
                .then(result => {
                    this.token = '';
                    this.email = '';
                    localStorage.removeItem('token');
                    localStorage.removeItem('username');
                    delete axios.defaults.headers.common['Authorization'];
                })
            }
        }
    })