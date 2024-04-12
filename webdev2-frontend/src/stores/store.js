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
                        axios.defaults.headers.common['Authorization'] = "Bearer " + result.data[0];
                        this.token = result.data[0];
                        this.user = result.data[1];
                        console.log(this.user);
                        localStorage.setItem('token', this.token);
                        localStorage.setItem('user', JSON.stringify(this.user));
                        resolve();
                    })
                    .catch(error => reject(error.response.data.errorMessage));
                });
            },
            autoLoggin() {
                const token = localStorage.getItem('token');
                let user = JSON.parse(localStorage.getItem('user'));
                if (token) {
                    this.token = token;
                    this.user = user;
                    axios.defaults.headers.common['Authorization'] = "Bearer " + token;
                }
            },
            logout() {
                    this.token = '';
                    this.user = '';
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    delete axios.defaults.headers.common['Authorization'];
            },
            setUser(user){
                user.password = '';
                this.user = user;
                localStorage.setItem('user', JSON.stringify(this.user));
            }
        }
    })