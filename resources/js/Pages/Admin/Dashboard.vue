
<template>
    <AdminLayout>
      <div class="admin-dashboard">
        <h1>Панель администратора</h1>
        <div class="stats">
          <div class="stat-card">
            <h3>Всего товаров</h3>
            <p>{{ productsCount }}</p>
          </div>
        </div>
      </div>
    </AdminLayout>
  </template>
  
  <script setup>
  import AdminLayout from '@/Pages/AdminPages.vue';
  import { Head } from '@inertiajs/vue3';
  
  defineProps({
    productsCount: Number
  });
  </script>
  
  <style scoped>
  .admin-dashboard {
    padding: 20px;
  }
  
  .stats {
    display: flex;
    gap: 20px;
    margin-top: 30px;
  }
  
  .stat-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    min-width: 200px;
  }
  </style>