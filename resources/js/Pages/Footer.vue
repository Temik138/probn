<template>
  <nav class="navigation-bar">
    <a href="/" class="logo">DigitalStore</a>
    <a href="" class="email">DigitalStore38@mail.ru</a>
    <a href="" class="telegramm">телеграмм</a>
  </nav>
</template>

<script>
export default {
  name: 'AppHeader'
}
</script>

<style scoped>
.navigation-bar {
  display: flex;
  min-width: 100%;
  background-color: #884535;
  color: white;
  padding-bottom: 40px;
}

.logo {
  font-family: "Jersey 25";
  font-size: 48px;
  margin: 0 0 0 150px;
  color: white;
  text-decoration: none;
}

.email {
  margin: 20px 0 0 425px;
  font-family: "Montserrat";
  font-size: 26px;
  font-weight: 250;
  color: white;
  text-decoration: none;
}

.telegramm {
  margin: 20px 0 0 135px;
  font-family: "Montserrat";
  font-size: 26px;
  font-weight: 250;
  color: white;
  text-decoration: none;
}
</style>
