<template>
    <section>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
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
                />
                <div v-if="form.errors.email" class="error-message">{{ form.errors.email }}</div>

                <div v-if="mustVerifyEmail && user.email_verified_at === null">
                    <p class="text-sm mt-2 text-gray-400">
                        Ваш адрес электронной почты не подтвержден.
                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="underline text-sm text-gray-400 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Нажмите здесь, чтобы повторно отправить письмо с подтверждением.
                        </Link>
                    </p>

                    <div
                        v-show="status === 'verification-link-sent'"
                        class="mt-2 font-medium text-sm text-green-600"
                    >
                        Новая ссылка для подтверждения была отправлена на ваш адрес электронной почты.
                    </div>
                </div>
            </div>

            </form>
    </section>
</template>

<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { defineExpose } from 'vue'; // Импортируем defineExpose

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    // Если вы добавили 'phone', убедитесь, что он есть в user.phone
    // phone: user.phone,
});

// Выставляем метод submit наружу, чтобы родительский компонент мог его вызвать
const submitForm = () => {
  form.patch(route('profile.update'), {
    preserveScroll: true,
    onSuccess: () => {
      // Можно добавить свою логику успеха, например, показать всплывающее окно
      console.log('Информация профиля успешно обновлена!');
    },
    onError: (errors) => {
      console.error('Ошибка при обновлении информации профиля:', errors);
    },
  });
};

defineExpose({
  submitForm // Делаем метод submitForm доступным для родительского компонента
});
</script>

<style scoped>
/* Эти стили могут быть переопределены через :deep() в Edit.vue,
   но если вы хотите, чтобы они работали напрямую, их можно здесь оставить
   или скопировать в Edit.vue. Я оставляю их здесь для наглядности,
   но основная стилизация будет из Edit.vue. */
.text-lg { font-size: 1.125rem; } /* 18px */
.font-medium { font-weight: 500; }
.text-white { color: white; }
.mt-1 { margin-top: 0.25rem; } /* 4px */
.text-sm { font-size: 0.875rem; } /* 14px */
.text-gray-400 { color: #9ca3af; } /* Светло-серый */
.mt-6 { margin-top: 1.5rem; } /* 24px */
.space-y-6 > :not([hidden]) ~ :not([hidden]) {
    --tw-space-y-reverse: 0;
    margin-top: calc(1.5rem * calc(1 - var(--tw-space-y-reverse)));
    margin-bottom: calc(1.5rem * var(--tw-space-y-reverse));
}

/* Стили для формы группы и инпутов будут переопределены из Edit.vue через :deep() */
/* Но если вы хотите, чтобы они работали здесь напрямую, вам нужно скопировать их */
.form-group {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}

.form-label {
    display: block;
    font-size: 18px;
    margin-bottom: 0;
    color: white;
    text-align: right;
    width: 200px;
    flex-shrink: 0;
}

.form-input {
    flex-grow: 1;
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

.error-message {
    color: #ffcccc;
    font-size: 14px;
    margin-top: 5px;
    text-align: center;
    width: 100%;
}

/* Стили для ссылки подтверждения почты */
.underline { text-decoration: underline; }
.rounded-md { border-radius: 0.375rem; }
.focus\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
.focus\:ring-2:focus { --tw-ring-offset-width: 2px; --tw-ring-color: #4f46e5; } /* Пример цвета */
.focus\:ring-offset-2:focus { --tw-ring-offset-width: 2px; }

/* Сообщения об успешной отправке */
.text-green-600 { color: #16a34a; } /* Зеленый цвет */
</style>