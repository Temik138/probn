<template>
  <div class="auth-page">
    <AppHeader />
    <section class="auth-section">
      <div class="auth-card">
        <h2 class="auth-title">Регистрация</h2>

        <form @submit.prevent="submit">
          <div class="form-group">
            <label for="name" class="form-label">Имя</label>
            <input
              id="name"
              type="text"
              class="form-input"
              v-model="form.name"
              required
              autofocus
              autocomplete="name"
              placeholder="Имя"
            />
            <div v-if="form.errors.name" class="error-message">{{ form.errors.name }}</div>
          </div>

          <div class="form-group">
            <label for="email" class="form-label">Электронная почта</label>
            <input
              id="email"
              type="email"
              class="form-input"
              v-model="form.email"
              required
              autocomplete="username"
              placeholder="Электронная почта"
            />
            <div v-if="form.errors.email" class="error-message">{{ form.errors.email }}</div>
          </div>

          <div class="form-group">
            <label for="phone" class="form-label">Номер телефона</label>
            <input
              id="phone"
              type="tel"
              class="form-input"
              v-model="form.phone"
              @input="handlePhoneInput"
              autocomplete="tel"
              placeholder="Номер телефона"
              maxlength="12"
            />
            <div v-if="form.errors.phone" class="error-message">{{ form.errors.phone }}</div>
          </div>

          <div class="form-group">
            <label for="password" class="form-label">Пароль</label>
            <input
              id="password"
              type="password"
              class="form-input"
              v-model="form.password"
              required
              autocomplete="new-password"
              placeholder="Пароль"
            />
            <div v-if="form.errors.password" class="error-message">{{ form.errors.password }}</div>
          </div>

          <div class="form-group">
            <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
            <input
              id="password_confirmation"
              type="password"
              class="form-input"
              v-model="form.password_confirmation"
              required
              autocomplete="new-password"
              placeholder="Подтвердите пароль"
            />
            <div v-if="form.errors.password_confirmation" class="error-message">{{ form.errors.password_confirmation }}</div>
          </div>

          <button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="auth-button">
            Зарегистрироваться
          </button>
        </form>
      </div>
    </section>
    <AppFooter />
  </div>
</template>

<script setup>
import AppHeader from '../Header.vue';
import AppFooter from '../Footer.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const form = useForm({
  name: '',
  email: '',
  phone: '', // Начинаем с пустого значения
  password: '',
  password_confirmation: '',
});

// Обработчик ввода для поля телефона
const handlePhoneInput = (event) => {
  // Удаляем все нецифровые символы
  let cleaned = event.target.value.replace(/\D/g, '');
  
  // Добавляем +7 в начало, если его нет
  if (!cleaned.startsWith('7') && cleaned.length > 0) {
    cleaned = '7' + cleaned;
  }
  
  // Ограничиваем длину (11 цифр, включая первую 7)
  if (cleaned.length > 11) {
    cleaned = cleaned.substring(0, 11);
  }
  
  // Добавляем + в начало
  form.phone = '+' + cleaned;
};

// Валидация перед отправкой формы
const submit = () => {
  // Проверяем, что номер телефона содержит достаточно цифр
  const phoneDigits = form.phone.replace(/\D/g, '');
  if (phoneDigits.length < 11) {
    form.setError('phone', 'Номер телефона должен содержать 11 цифр');
    return;
  }
  
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<style scoped>
/* Используйте те же стили, что и для Login.vue */
.auth-page {
  background-color: #884535;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.auth-section {
  flex-grow: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px 20px;
}

.auth-card {
  background-color: #7a3a2d;
  border: dashed 2px white;
  border-radius: 8px;
  padding: 40px;
  max-width: 500px;
  width: 100%;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  color: white;
  font-family: "Montserrat", sans-serif;
}

.auth-title {
  font-size: 32px;
  color: #ffd700;
  text-align: center;
  margin-bottom: 30px;
  font-weight: bold;
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
  display: none; /* Скрываем, если используем placeholder */
}

.form-input {
  width: 100%;
  padding: 12px 15px;
  border: dashed 2px white;
  border-radius: 5px;
  background-color: #7a3a2d;
  color: white;
  font-size: 16px;
  box-sizing: border-box;
  outline: none;
  transition: border-color 0.3s ease, background-color 0.3s ease;
}

.form-input:focus {
  border-color: #ffd700;
  background-color: #884535;
}

.form-input::placeholder {
  color: #ccc;
  text-align: center;
}

.error-message {
  color: #ffcccc;
  font-size: 14px;
  margin-top: 5px;
  text-align: center;
}

.auth-button {
  display: block;
  width: fit-content;
  padding: 12px 30px;
  margin: 30px auto 0;
  background-color: transparent;
  color: white;
  border: dashed 2px white;
  border-radius: 5px;
  font-size: 18px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  font-weight: bold;
}

.auth-button:hover {
  background-color: rgba(255, 255, 255, 0.1);
  border-color: #ffd700;
  color: #ffd700;
}

.auth-button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>