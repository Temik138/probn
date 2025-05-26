<template>
    <section>
       
        <form @submit.prevent="form.put(route('password.update'))" class="mt-6 space-y-6">
            <div class="form-group">
                <label for="current_password" class="form-label">Текущий пароль</label>
                <input
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="form-input"
                    autocomplete="current-password"
                />
                <div v-if="form.errors.current_password" class="error-message">{{ form.errors.current_password }}</div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Новый пароль</label>
                <input
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="form-input"
                    autocomplete="new-password"
                />
                <div v-if="form.errors.password" class="error-message">{{ form.errors.password }}</div>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Подтвердите новый пароль</label>
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="form-input"
                    autocomplete="new-password"
                />
                <div v-if="form.errors.password_confirmation" class="error-message">{{ form.errors.password_confirmation }}</div>
            </div>

            </form>
    </section>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue'; // Импортируем ref
import { defineExpose } from 'vue'; // Импортируем defineExpose

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

// Выставляем метод submit наружу
const submitForm = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            console.log('Пароль успешно обновлен!');
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
            console.error('Ошибка при обновлении пароля:', form.errors);
        },
    });
};

defineExpose({
    submitForm // Делаем метод submitForm доступным для родительского компонента
});
</script>

<style scoped>
/* Аналогично UpdateProfileInformationForm.vue, стили здесь для наглядности,
   но будут переопределены из Edit.vue через :deep() */
.text-lg { font-size: 1.125rem; }
.font-medium { font-weight: 500; }
.text-white { color: white; }
.mt-1 { margin-top: 0.25rem; }
.text-sm { font-size: 0.875rem; }
.text-gray-400 { color: #9ca3af; }
.mt-6 { margin-top: 1.5rem; }
.space-y-6 > :not([hidden]) ~ :not([hidden]) {
    --tw-space-y-reverse: 0;
    margin-top: calc(1.5rem * calc(1 - var(--tw-space-y-reverse)));
    margin-bottom: calc(1.5rem * var(--tw-space-y-reverse));
}

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
</style>