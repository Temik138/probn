<template>
    <div class="home-page">
      <AppHeader />
      <AppCatalog1 :products="products || []" />
      <AppFooter />
    </div>
  </template>
  
  <script setup>
import AppHeader from './Header.vue';
import AppCatalog1 from './Catalog1.vue'
import AppFooter from './Footer.vue';
</script>q

<script>
export default {
  components: { AppCatalog1 },
  props: {
    products: {
      type: Array,
      required: true,
      default: () => []
    }
  }
}
</script>
  
  <style scoped>
  .home-page{
    background-color: #884535;
  }
  </style>