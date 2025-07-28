<template>
<div class="bg-section">
  <nav style="padding: 12px 24px; background-color: white; font-size: 16px;border:1px solid black;background-color: #eee;">
  <span style="margin-right: 8px;">
    <router-link to="/" style="text-decoration: none; color: black;font-weight:700">Home</router-link>
  </span>
  <span style="margin: 0 8px;">›</span>
  <span style="margin-right: 8px;">
    <router-link to="/cart" style="text-decoration: none; color: black;font-weight:700;">View Cart</router-link>
  </span>
  <span style="margin: 0 8px;">›</span>
  <span style="color: black;font-weight:700">Checkout</span>
</nav>
<div style="max-width: 600px; margin: auto;">
  <!-- Step Navigation -->
  <div style="display: flex; justify-content: center; align-items: flex-start; gap: 40px; padding: 20px;">
    <div :style="tabStyle(1)">1. Address</div>
    <div :style="tabStyle(2)">2. Dispatch</div>
    <div :style="tabStyle(3)">3. Review Order</div>
  </div>

  <!-- Step Content -->
  <div v-if="currentStep === 1">
    <h4>Profile Details</h4>
    <form @submit.prevent="handleShippingSubmit">
      <!-- Email -->
      <div class="form-group">
        <label>Email <span style="color:red;">*</span></label>
        <input v-model="form.email" type="email" class="form-control" required />
        <span v-if="errors.email" style="color:red;">{{ errors.email }}</span>
        
      </div>

      <h4 class="mt-3 my-3">Shipping Address</h4>

      <!-- First and Last Name -->
      <div class="form-row">
        <div class="form-group" style="flex: 1; margin-right: 10px;">
          <label>First Name <span style="color:red;">*</span></label>
          <input v-model="form.firstName" class="form-control" required/>
        </div>
        <div class="form-group" style="flex: 1;">
          <label>Last Name <span style="color:red">*</span></label>
          <input v-model="form.lastName" class="form-control" required />
        </div>
      </div>

      <!-- Address -->
      <div class="form-group">
        <label>Address <span style="color:red">*</span></label>
        <textarea v-model="form.address" class="form-control" required></textarea>
      </div>

      <!-- City and Country -->
      <div class="form-row">
        <div class="form-group" style="flex: 1; margin-right: 10px;">
          <label>City <span style="color:red">*</span></label>
          <input v-model="form.city" class="form-control" required/>
        </div>
        <div class="form-group" style="flex: 1;">
          <label>Country <span style="color:red">*</span></label>
          <select v-model="form.country" class="form-control" required>
            <option>India</option>
            <option>USA</option>
            <option>UK</option>
          </select>
        </div>
      </div>

      <!-- State and ZIP -->
      <div class="form-row">
        <div class="form-group" style="flex: 1; margin-right: 10px;">
          <label>State / Province <span style="color:red">*</span></label>
          <select v-model="form.state" class="form-control" required>
            <option>Karnataka</option>
            <option>Maharashtra</option>
            <option>Tamil Nadu</option>
          </select>
        </div>
        <div class="form-group" style="flex: 1;">
          <label>ZIP Code <span style="color:red">*</span></label>
          <input v-model="form.zip" class="form-control" required/>
        </div>
      </div>

      <!-- Telephone -->
      <div class="form-group">
        <label>Telephone <span style="color:red">*</span></label>
        <input v-model="form.phone" class="form-control" required/>
      </div>

      <!-- Billing Checkbox -->
      <div class="form-group">
        <input type="checkbox" v-model="form.sameAsShipping" />
        <label>Billing Address is same as Shipping Address</label>
      </div>

      <button type="submit" class="btn mt-3 my-3">Continue</button>
    </form>
  </div>

  <div v-else-if="currentStep === 2">
    <p style="font-weight:600">Want to Edit the Address ? .Click on <button class="btn btn-danger" @click="goToAddressStep">Change</button></p>
    <h3>Dispatch Options</h3>
    <!-- your dispatch form here -->
    <button class="btn">Continue</button>
  </div>

  <div v-else-if="currentStep === 3">
    <h3>Review Order</h3>
    <!-- your order summary here -->
    <button @click="submitOrder">Submit</button>
  </div>
</div>
</div>
<div class="cart-card" style="flex: 0.6; border: 1px solid #ccc; padding: 20px; border-radius: 8px;">
  <h3 class="text-center">Order Summary</h3>

</div>

  
</template>
<script>
import api from '../api';
export default{
  name:'CheckoutForm',
  data(){
    return{
      userId:'',
      currentStep: parseInt(localStorage.getItem('checkout_step')) || 1,
      errors:{},
      form: {
        email: '',
        firstName: '',
        lastName: '',
        address: '',
        city: '',
        country: 'India',
        state: 'Karnataka',
        zip: '',
        phone: '',
        sameAsShipping: true
      }
    }
  },
  async mounted() {
  try {
    const res = await api.get('/user'); // Get the logged-in user
    this.userId = res.data.id;

    // Load last visited user ID
    const lastVisitedUserId = localStorage.getItem('last_user_id');

    // If new user, reset the step
    if (lastVisitedUserId !== String(this.userId)) {
      localStorage.setItem('currentStep_' + this.userId, '1');
      localStorage.setItem('last_user_id', this.userId);
    }

    // Load current step
    const savedStep = localStorage.getItem(`currentStep_${this.userId}`);
    this.currentStep = savedStep ? parseInt(savedStep) : 1;

    // Load saved form if exists
    const savedForm = localStorage.getItem(`shippingForm_${this.userId}`);
    if (savedForm) {
      this.form = JSON.parse(savedForm);
    }
  } catch (error) {
    console.error("User fetch failed", error);
  }
},
  methods: {
  goToAddressStep() {
    this.currentStep = 1; 
    
  },
    nextStep() {
      if (this.currentStep < 3) this.currentStep++;
      localStorage.setItem('checkout_step', this.currentStep); 
      this.currentStep = 2;
      
    },
    async handleShippingSubmit() {
  try {
    this.errors = {}; // ✅ Clear first

    // Basic frontend validation
    if (!this.form.email) this.errors.email = "Email is required.";

    // Check for errors
    if (Object.keys(this.errors).length > 0) {
      return; // Stop form submission
    }

    // Submit form
    await api.post('/shipping-address', this.form);

    // Save progress
    localStorage.setItem('shippingForm', JSON.stringify(this.form));
    localStorage.setItem('currentStep', '2');

    alert("Shipping address saved");
    this.currentStep = 2;
  } catch (error) {
    console.error(error);
    alert("Failed to save address");
  }
},

    submitOrder() {
      alert("Order placed successfully!");
    },
    tabStyle(step) {
      return {
        padding: '8px 12px',
        borderBottom: this.currentStep === step ? '2px solid #3498db' : '2px solid #ccc',
        color: this.currentStep === step ? '#3498db' : '#999',
        fontWeight: 'bold'
      };
    }
  }
}
</script>
<style scoped>
.btn{
  background-color:black;
  color:white;
}
.bg-section {
  background-image: url('../assets/background-image.jpg');
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
  height: 120%;
  width: 100%;  
}
label{
  font-weight:700
}
</style>
