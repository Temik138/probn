<template>
    <AdminLayout>
      <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Добавить товар</h1>
        
        <form @submit.prevent="submit">
          <!-- Поля формы -->
          <div class="mb-4">
            <label class="block mb-2">Название</label>
            <input v-model="form.name" type="text" class="w-full p-2 border rounded">
          </div>
          
          <!-- Остальные поля (price, description, category) -->
          
          <div class="mb-4">
            <label class="block mb-2">Изображение</label>
            <input type="file" @input="form.image = $event.target.files[0]">
          </div>
          
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Добавить товар
          </button>
        </form>
      </div>
    </AdminLayout>
  </template>
  
  <script setup>
  import AdminLayout from '@/Pages/AdminPages.vue';
  import { useForm } from '@inertiajs/vue3';
  
  const form = useForm({
    name: '',
    description: '',
    price: 0,
    category: 'kurs',
    image: null
  });
  
  const submit = () => {
    form.post(route('admin.products.store'), {
      onSuccess: () => form.reset(),
    });
  };
  </script>