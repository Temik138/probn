<template>
  <nav class="navigation-bar">
    <Link href="/" class="logo">DigitalStore</Link>
    <Link href="/catalog" class="catalog">каталог</Link>
    <Link href="/cart" class="cart">корзина</Link>

    <template v-if="$page.props.auth.user">
      <Link :href="route('logout')" method="post" as="button" class="logout-button">
        Выход
      </Link>
      <Link :href="route('profile.edit')" class="profile-link">
        Привет, {{ $page.props.auth.user.name }}!
      </Link>
      
    </template>
    <template v-else>
      <Link :href="route('login')" class="login">вход</Link>
      <Link :href="route('register')" class="register">регистрация</Link>
    </template>
  </nav>
</template>

<script>
// Импортируем Link из Inertia.js
import { Link } from '@inertiajs/vue3';

export default {
  name: 'AppHeader',
  components: {
    Link, // Регистрируем компонент Link
  },
  // computed свойство, чтобы получить доступ к данным страницы Inertia
  computed: {
    // $page.props.auth.user доступен благодаря Laravel Breeze и Inertia.js
    // Он содержит информацию о текущем авторизованном пользователе.
    // Если пользователь не авторизован, $page.props.auth.user будет null.
    user() {
      return this.$page.props.auth.user;
    }
  }
}
</script>

<style scoped>
/* Ваши существующие стили */
.navigation-bar {
  display: flex;
  min-width: 100%;
  background-color: #884535;
  align-items: center; /* Выравнивание по центру по вертикали */
  padding: 0 20px; /* Добавим немного отступа по бокам */
  box-sizing: border-box; /* Учитываем padding в ширине */
}

.logo {
  font-family: "Jersey 25";
  font-size: 48px;
  margin: 30px 0 0 150px; /* Оставим ваш отступ */
  color: white;
  text-decoration: none;
  white-space: nowrap; /* Предотвращает перенос текста */
}

/* Общий стиль для ссылок каталога, корзины, входа, регистрации */
.catalog, .cart, .login, .register, .profile-link, .logout-button {
  font-family: "Montserrat";
  font-size: 26px;
  font-weight: 250;
  color: white;
  text-decoration: none;
  white-space: nowrap;
  transition: color 0.2s ease;
  padding: 10px 15px; /* Увеличим область клика */
  border-radius: 5px;
}

.catalog:hover, .cart:hover, .login:hover, .register:hover, .profile-link:hover, .logout-button:hover {
  color: #ffd700; /* Цвет при наведении */
}

.catalog {
  margin: 50px 0 0 405px; /* Оставим ваш отступ */
}

.cart {
  margin: 50px 0 0 135px; /* Оставим ваш отступ */
}

.login {
  margin: 50px 0 0 55px; /* Оставим ваш отступ */
}

.register {
  margin: 50px 0 0 55px; /* Для регистрации тоже */
}

/* Стили для ссылок авторизованного пользователя */
.profile-link {
    margin: 50px 0 0 ; /* Автоматический отступ, чтобы ссылки прибились вправо */
    /* Отступ от кнопки выхода */
}

.logout-button {
    margin: 50px 0 0 200px; /* Отступ справа от кнопки выхода */
    background: none;
    border: none;
    cursor: pointer;
    font-size: 26px; /* Сохраняем размер шрифта */
    font-weight: 250;
    font-family: "Montserrat";
}

/* Адаптивные стили для мобильных устройств */
@media (max-width: 1200px) {
  .logo {
    font-size: 38px;
    margin-left: 50px;
  }
  .catalog {
    margin-left: 100px; /* Уменьшим отступ для каталога */
  }
  .cart {
    margin-left: 50px; /* Уменьшим отступ для корзины */
  }
  .login, .register, .profile-link, .logout-button {
    margin-left: 20px; /* Уменьшим отступы для авторизации */
  }
  .logout-button {
    margin-right: 50px;
  }
}

@media (max-width: 900px) {
  .navigation-bar {
    flex-wrap: wrap; /* Разрешаем перенос элементов на новую строку */
    justify-content: center; /* Центрируем элементы при переносе */
    padding: 15px;
  }
  .logo, .catalog, .cart, .login, .register, .profile-link, .logout-button {
    margin: 10px 10px; /* Уменьшаем все отступы */
  }
  .logo {
    flex-basis: 100%; /* Логотип на всю ширину */
    text-align: center;
    margin: 10px 0;
  }
  .profile-link, .logout-button {
      margin: 10px 10px; /* Сбросим авто отступ */
  }
}

@media (max-width: 600px) {
  .logo {
    font-size: 32px;
  }
  .catalog, .cart, .login, .register, .profile-link, .logout-button {
    font-size: 20px;
    padding: 8px 12px;
  }
}
</style>