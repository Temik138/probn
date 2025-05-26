<template>
  <div class="cart-page">
    <AppHeader />
    <Cart1 :cartItems="cartItems || []" :cartTotal="cartTotal" />
    <AppFooter />
  </div>
</template>

<script setup>
import AppHeader from './Header.vue'; 
import AppFooter from './Footer.vue'; 
import Cart1 from './Cart1.vue'; 


defineProps({
  cartItems: {
    type: Array,
    required: true,
    default: () => []
  },
  cartTotal: {
    type: Number,
    required: true,
    default: 0
  }
});
</script>

<style scoped>
.cart-page {
  background-color: #884535; 
}
</style>