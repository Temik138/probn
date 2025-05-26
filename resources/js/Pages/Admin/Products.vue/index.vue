<template>
    <AdminLayout>
      <div class="p-6">
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-2xl font-bold">Товары</h1>
          <Link 
            :href="route('admin.products.create')" 
            class="bg-blue-500 text-white px-4 py-2 rounded"
          >
            Добавить товар
          </Link>
        </div>
        
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <table class="min-w-full">
            <thead>
              <tr>
                <th class="px-6 py-3 bg-gray-50 text-left">ID</th>
                <th class="px-6 py-3 bg-gray-50 text-left">Название</th>
                <th class="px-6 py-3 bg-gray-50 text-left">Цена</th>
                <th class="px-6 py-3 bg-gray-50 text-left">Действия</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products.data" :key="product.id">
                <td class="px-6 py-4">{{ product.id }}</td>
                <td class="px-6 py-4">{{ product.name }}</td>
                <td class="px-6 py-4">{{ product.price }} ₽</td>
                <td class="px-6 py-4 flex space-x-2">
                  <Link 
                    :href="route('admin.products.edit', product.id)"
                    class="text-blue-500 hover:text-blue-700"
                  >
                    Редактировать
                  </Link>
                  <button 
                    @click="deleteProduct(product.id)"
                    class="text-red-500 hover:text-red-700"
                  >
                    Удалить
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </AdminLayout>
  </template>
  
  <script setup>
  import AdminLayout from '@/Pages/AdminPages.vue';
  import { Link, router } from '@inertiajs/vue3';
  
  defineProps({
    products: Object
  });
  
  const deleteProduct = (id) => {
    if (confirm('Вы уверены, что хотите удалить этот товар?')) {
      router.delete(route('admin.products.destroy', id));
    }
  };
  </script>