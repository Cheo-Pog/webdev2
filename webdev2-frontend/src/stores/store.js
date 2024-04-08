import { defineStore } from "pinia";
import axios from '../axios-auth';

export const useStore = defineStore('store',
    {
        state: () => ({
            token: '',
            username: ''
        }),
        getters: {
            isLoggedIn: (state) => state.token != '',
        },
        actions: {
            login(username, password) {
                return new Promise((resolve, reject) => {
                    axios.post('/users/login', {
                        username: username,
                        password: password
                    })
                    .then(result => {
                        console.log(result);
                        alert(result.data);
                        axios.defaults.headers.common['Authorization'] = "Bearer " + result.data;
                        this.token = result.data;
                        this.username = username;
                        localStorage.setItem('token', result.data);
                        localStorage.setItem('username', username);
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
                    this.username = username;
                    axios.defaults.headers.common['Authorization'] = "Bearer " + token;
                }
            },
            logout() {
                this.token = '';
                this.username = '';
                localStorage.removeItem('token');
                localStorage.removeItem('username');
                axios.defaults.headers.common['Authorization'] = '';
            }
        }
    })