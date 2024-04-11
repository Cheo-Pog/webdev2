import { defineStore } from "pinia";
import axios from '../axios-auth';

export const useStore = defineStore('store',
    {
        state: () => ({
            token: '',
            user: {},
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
                        axios.defaults.headers.common['Authorization'] = "Bearer " + result.data;
                        this.token = result.data[0];
                        this.user = result.data[1];
                        localStorage.setItem('email', email);
                        resolve();
                    })
                    .catch(error => reject(error.response.data.errorMessage));
                });
            },
            autoLoggin() {
                const token = localStorage.getItem('token');
                const email = localStorage.getItem('email');
                if (token) {
                    this.token = token;
                    this.email = email;
                    axios.defaults.headers.common['Authorization'] = "Bearer " + token;
                }
            },
            logout() {
                    this.token = '';
                    this.email = '';
                    localStorage.removeItem('token');
                    localStorage.removeItem('email');
                    delete axios.defaults.headers.common['Authorization'];
            }
        }
    })