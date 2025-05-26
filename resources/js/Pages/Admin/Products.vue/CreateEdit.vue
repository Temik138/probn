
<template>
    <AdminLayout>
      <div class="product-form">
        <h1>{{ editMode ? 'Редактирование товара' : 'Создание товара' }}</h1>
        
        <form @submit.prevent="submitForm">
          <div class="form-group">
            <label>Название товара</label>
            <input v-model="form.name" type="text" required>
          </div>
          
          <div class="form-group">
            <label>Описание</label>
            <textarea v-model="form.description" required></textarea>
          </div>
          
          <div class="form-group">
            <label>Цена (руб)</label>
            <input v-model="form.price" type="number" min="0" step="0.01" required>
          </div>
          
          <div class="form-group">
            <label>Категория</label>
            <select v-model="form.category" required>
              <option value="kurs">Курс</option>
              <option value="books">Книга</option>
              <option value="shabl">Шаблон</option>
            </select>
          </div>
          
          <div class="form-group">
            <label>Основное изображение</label>
            <input type="file" @change="handleImageUpload">
            <img v-if="form.image" :src="imagePreview" class="image-preview">
          </div>
          
          <div class="form-group">
            <label>Дополнительные изображения</label>
            <input type="file" multiple @change="handleImagesUpload">
            <div class="images-preview">
              <img v-for="(img, index) in imagesPreviews" :key="index" :src="img" class="image-preview">
            </div>
          </div>
          
          <button type="submit" class="btn-submit">
            {{ editMode ? 'Обновить' : 'Создать' }}
          </button>
        </form>
      </div>
    </AdminLayout>
  </template>
  
  <script setup>
  import AdminLayout from '@/Pages/AdminPages.vue';
  import { useForm, router } from '@inertiajs/vue3';
  import { computed, ref } from 'vue';
  
  const props = defineProps({
    product: Object
  });
  
  const editMode = computed(() => !!props.product);
  
  const form = useForm({
    name: props.product?.name || '',
    description: props.product?.description || '',
    price: props.product?.price || 0,
    category: props.product?.category || 'kurs',
    image: null,
    images: []
  });
  
  const imagePreview = ref(props.product ? '/storage/' + props.product.image : null);
  const imagesPreviews = ref(props.product?.images?.map(img => '/storage/' + img) || []);
  
  const handleImageUpload = (e) => {
    const file = e.target.files[0];
    form.image = file;
    
    const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
  };
  
  const handleImagesUpload = (e) => {
    form.images = Array.from(e.target.files);
    
    imagesPreviews.value = [];
    Array.from(e.target.files).forEach(file => {
      const reader = new FileReader();
      reader.onload = (e) => {
        imagesPreviews.value.push(e.target.result);
      };
      reader.readAsDataURL(file);
    });
  };
  
  const submitForm = () => {
    if (editMode.value) {
      form.put(route('admin.products.update', props.product.id));
    } else {
      form.post(route('admin.products.store'));
    }
  };
  </script>
  
  <style scoped>
  .product-form {
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
  }
  
  .form-group {
    margin-bottom: 20px;
  }
  
  label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }
  
  input[type="text"],
  input[type="number"],
  textarea,
  select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }
  
  textarea {
    min-height: 100px;
  }
  
  .image-preview {
    max-width: 200px;
    max-height: 200px;
    margin-top: 10px;
    display: block;
  }
  
  .images-preview {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
  }
  
  .btn-submit {
    background: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
  }
  </style>