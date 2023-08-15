<template>
    <div class="login-container">
        <div class="login-form">
            <h2>Login</h2>
            <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
            <input v-model="credentials.email" placeholder="Email">
            <input type="password" v-model="credentials.password" placeholder="Password">
            <button @click="login">Login</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            credentials: {
                email: '',
                password: ''
            },
            errorMessage: ''
        }
    },

    methods: {
        async login() {
            try {
                const response = await axios.post('/api/login', this.credentials);

                // Store the token in localStorage after a successful login
                localStorage.setItem('authToken', response.data.token);

                this.$emit('login-success', response.data.token); // Emit token upwards
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    // Capture the first error message for simplicity
                    this.errorMessage = Object.values(error.response.data.errors)[0][0];
                } else {
                    this.errorMessage = "Failed to log in. Please check your connection.";
                }
            }
        }
    }
}

</script>

<style scoped>
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f4f4;
}

.login-form {
    width: 300px;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    background-color: white;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

button {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}

.error {
    color: red;
    margin-bottom: 10px;
}
</style>

