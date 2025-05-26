<template>
  <div class="auth-page">
    <AppHeader />
    <section class="auth-section">
      <div class="auth-card">
        <h2 class="auth-title">Авторизация</h2>

        <form @submit.prevent="submit">
          <div class="form-group">
            <label for="email" class="form-label">Электронная почта</label>
            <input
              id="email"
              type="email"
              class="form-input"
              v-model="form.email"
              required
              autofocus
              autocomplete="username"
              placeholder="email"
            />
            <div v-if="form.errors.email" class="error-message">{{ form.errors.email }}</div>
          </div>

          <div class="form-group">
            <label for="password" class="form-label">Пароль</label>
            <input
              id="password"
              type="password"
              class="form-input"
              v-model="form.password"
              required
              autocomplete="current-password"
              placeholder="пароль"
            />
            <div v-if="form.errors.password" class="error-message">{{ form.errors.password }}</div>
          </div>

          <button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="auth-button">
            Авторизация
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

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<style scoped>
.auth-page {
  background-color: #884535; /* Ваш фоновый цвет */
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.auth-section {
  flex-grow: 1; /* Занимает доступное пространство */
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px 20px; /* Отступы сверху/снизу */
}

.auth-card {
  background-color: #7a3a2d; /* Цвет карточки, немного светлее фона */
  border: dashed 2px white; /* Ваша рамка */
  border-radius: 8px;
  padding: 40px;
  max-width: 500px; /* Ограничьте ширину карточки */
  width: 100%;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  color: white;
  font-family: "Montserrat", sans-serif;
}

.auth-title {
  font-size: 32px;
  color: #ffd700; /* Золотой цвет для заголовка */
  text-align: center;
  margin-bottom: 30px;
  font-weight: bold;
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
  display: block;
  font-size: 18px;
  margin-bottom: 8px;
  color: white;
  text-align: center; /* Центрируем метку */
}

.form-input {
  width: 100%;
  padding: 12px 15px;
  border: dashed 2px white; /* Ваша рамка */
  border-radius: 5px;
  background-color: #7a3a2d; /* Цвет инпута, как у карточки */
  color: white;
  font-size: 16px;
  box-sizing: border-box; /* Важно для padding */
  outline: none; /* Убираем стандартную обводку */
  transition: border-color 0.3s ease, background-color 0.3s ease;
}

.form-input:focus {
  border-color: #ffd700; /* Изменение цвета рамки при фокусе */
  background-color: #884535; /* Возможно, чуть темнее при фокусе */
}

.form-input::placeholder {
  color: #ccc;
}

.error-message {
  color: #ffcccc;
  font-size: 14px;
  margin-top: 5px;
  text-align: center;
}

.auth-button {
  display: block;
  width: fit-content; /* Ширина по контенту */
  padding: 12px 30px;
  margin: 30px auto 0; /* Центрируем кнопку */
  background-color: transparent; /* Прозрачный фон */
  color: white;
  border: dashed 2px white; /* Ваша рамка */
  border-radius: 5px;
  font-size: 18px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  font-weight: bold;
}

.auth-button:hover {
  background-color: rgba(255, 255, 255, 0.1); /* Легкое затемнение при наведении */
  border-color: #ffd700; /* Изменение цвета рамки при наведении */
  color: #ffd700;
}

.auth-button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Дополнительные стили для полей по вашим скриншотам, если нужны плейсхолдеры */
.form-group label {
    position: absolute; /* Делаем метку абсолютной */
    left: 50%; /* Центрируем по горизонтали */
    transform: translateX(-50%); /* Смещаем на половину ширины, чтобы выровнять */
    top: -15px; /* Выносим над полем */
    background-color: #7a3a2d; /* Цвет фона, чтобы перекрыть рамку */
    padding: 0 10px; /* Отступы для фона */
    font-size: 16px;
    color: white;
    z-index: 1; /* Чтобы метка была над рамкой */
}

/* Скрываем метку, если поле с placeholder, или если она должна быть внутри */
.form-input + .form-label { /* Если метка идет сразу после инпута, то она должна быть placeholder */
    position: relative; /* Или абсолютной внутри родителя */
    /* Здесь можно добавить стили для метки-плейсхолдера, если вы хотите ее позиционировать внутри поля */
}

/* На ваших скриншотах кажется, что метки - это плейсхолдеры. Если это так,
   то в шаблоне уберите <label> и используйте атрибут placeholder="Имя" в <input> */
.form-group label {
    display: none; /* Если вы используете placeholder вместо метки */
}
.form-input::placeholder {
    color: #ccc; /* Цвет placeholder */
    text-align: center; /* Центрирование placeholder */
}
</style>