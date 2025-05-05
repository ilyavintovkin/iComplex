<script setup>
import { ref } from 'vue'
import axios from 'axios'

// Модели
const message = ref('')

// Метод отправки поста
const submitPost = async () => {
  if (!message.value.trim()) return

  try {
    const response = await axios.post('http://localhost:8000/api/newPost', {
      user_id: 1, // временно статично
      message: message.value,
    })
    message.value = '' // очищаем поле ввода
    alert('Пост отправлен')

    // Глобальное событие
    window.dispatchEvent(new CustomEvent('post-created', {
      detail: response.data
    }))
  } catch (err) {
    alert('Ошибка при отправке поста')
    console.error(err)
  }
}
</script>

<template>
  <div class="layout">
    <header class="header">
      <NuxtLink to="/" class="custom-link">Главная</NuxtLink>
      <NuxtLink to="/byuser" class="custom-link">Пользователь</NuxtLink>
      <NuxtLink to="/byhashtag" class="custom-link">Хэштег</NuxtLink>
    </header>
    
    <main class="main">
      <form @submit.prevent="submitPost" class="create-post-form">
        <input v-model="message" type="text" placeholder="Напиши пост..." maxlength="280" class="post-input" />
        <button type="submit" class="post-button">Отправить</button>
      </form>
  
      <slot />
    </main>
    
    <footer class="footer">
      <p>&copy; 2025 Bitter. Все права защищены.</p>
    </footer>
  </div>
</template>

<style>
.post {
  background-color: rgba(0, 0, 0, 0.115);
  margin: 15px;
}

.create-post-form {
  display: flex;
  align-items: center;
  gap: 12px;
  background-color: #fff;
  padding: 16px;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  max-width: 600px;
  margin: 0 auto;
}

.post-input {
  flex: 1;
  padding: 10px 16px;
  border: 1px solid #ccc;
  border-radius: 999px;
  font-size: 16px;
  outline: none;
  transition: border-color 0.2s;
}

.post-input:focus {
  border-color: #3b82f6; /* синий */
}

.post-button {
  padding: 10px 20px;
  background-color: #3b82f6;
  color: white;
  border: none;
  border-radius: 999px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.post-button:hover {
  background-color: #2563eb; /* чуть темнее при наведении */
}

.create-post-form {
  margin-bottom: 50px;
}
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
