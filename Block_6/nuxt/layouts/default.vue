<template>
  <div class="layout">
    <header class="header">
      <NuxtLink to="/" class="custom-link">Главная</NuxtLink>
      <NuxtLink to="/byuser" class="custom-link">Пользователь</NuxtLink>
      <NuxtLink to="/byhashtag" class="custom-link">Хэштег</NuxtLink>
    </header>
    
    <main class="main">
      <slot />
    </main>
    
    <footer class="footer">
      <p>&copy; 2025 Bitter. Все права защищены.</p>
    </footer>
  </div>
</template>

<style>
.custom-link {
  color: white; 
  text-decoration: none;
}

.custom-link:hover {
  text-decoration: underline;
}

.layout {
  display: flex;
  flex-direction: column;
  height: 100vh;
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
}

.header {
  display: flex;
  flex-direction: row;
  background-color: #333;
  color: white;
  padding: 20px;
  text-align: center;
  gap: 20px;
}

.main {
  flex: 1;
  padding: 20px;
  background-color: white;
}

.footer {
  background-color: #333;
  color: rgb(255, 255, 255);
  text-align: center;
  padding: 10px;
}
</style>
