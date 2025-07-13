<template>
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4 shadow-sm">
          <h2 class="text-center mb-4" style="color:red">Register</h2>
          <form @submit.prevent="register">
            <div class="mb-3">
              <input 
                type="text" 
                class="form-control" 
                placeholder="Enter your name" 
                v-model="name"
              >
            </div>
            <div class="mb-3">
              <input 
                type="email" 
                class="form-control" 
                placeholder="Enter your email" 
                v-model="email"
              >
            </div>
            <div class="mb-3">
              <input 
                type="password" 
                class="form-control" 
                placeholder="Enter your password" 
                v-model="password"
              >
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
            <p v-if="error" class="text-danger text-center mt-3">{{ error }}</p>
            <p v-else-if="message" class="text-success mt-5">{{message}}</p>
          </form>
        </div>
        <p style="text-align:center;margin-top:3vw;font-weight:700;font-size:120%">Already Have an account ?. Click here for <router-link to="/login" style="color:red;font-weight:700;">Login</router-link></p>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../api';
export default {
  data() {
    return {
      'name': '',
      'email': '',
      'password': '',
    }
  },
  methods: {
    async register() {
  try {
    const response = await api.post('/register', {
      name: this.name,
      email: this.email,
      password: this.password,
    });

    this.error = '';
    this.message = "Registration was Successfully done !!";

    // Optional: Delay or confirm before redirect
    setTimeout(() => {
      this.$router.push('/login');
    }, 1000);

  } catch (error) {
    // Handle Laravel validation errors (status code 422)
    if (error.response && error.response.status === 422) {
      const errors = error.response.data.errors;

      // Check if email validation failed
      if (errors.email) {
        this.error = errors.email[0];
      } else if (errors.name) {
        this.error = errors.name[0];
      } else if (errors.password) {
        this.error = errors.password[0];
      } else {
        this.error = 'Validation failed. Please check your inputs.';
      }

    } else {
      // Generic error
      this.error = 'Registration Failed !!. Please Try Again.';
    }
  }
}
  }
}
</script>
