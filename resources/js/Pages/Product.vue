<template>
  <div class="home-page">
    <AppHeader />
    <AppProduct1 :productData="productData" /> 
    <AppFooter />
  </div>
</template>

<script setup>
import AppHeader from '../Pages/Header.vue'; 
import AppProduct1 from '../Pages/Product1.vue'; 
import AppFooter from '../Pages/Footer.vue';

// Этот пропс Product.vue получает от Laravel/Inertia
const props = defineProps({
  productData: Object,
});
</script>

<style scoped>
.home-page{
  background-color: #884535;
}
</style>