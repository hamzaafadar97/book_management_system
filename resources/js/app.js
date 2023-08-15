import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler';
import Book from "./components/Book.vue";
import Login from "./components/Login.vue";
import BookValidation from "./components/BookValidation.vue";

const app = createApp({
    data() {
        return {
            token: localStorage.getItem('authToken') || null
        };
    },
    methods: {
        setToken(token) {
            this.token = token;
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
    }
});

app.component('book', Book);
app.component('validation', BookValidation);
app.component('login', Login);

app.mount("#app");
