<script setup> // синтаксис composition api. 
import { ref } from 'vue' // импорт функции ref(). используется для создания переменной, которая будет реагировать на изменения.
import axios from 'axios' // библиотека axios (библиотека HTTP запросов)

const message = ref('') // создание реактивной переменной (будет хранить текст, вводимый пользователем при создании поста)
const currentUserId = 3; // id текущего пользователя (кто будет выкладывать новый пост?)
// Функция для форматирования даты
const formatDate = (dateString) => { // функция форматирования даты
  const date = new Date(dateString);
  const options = { // опции для отображения формата даты 
    year: 'numeric', // год
    month: '2-digit', // месяц
    day: '2-digit', // день
    hour: '2-digit', // час
    minute: '2-digit', // минута
    hour12: false, // формат (24-часовой)
  };
  return date.toLocaleString('ru-RU', options); // локализация для России
};

const submitPost = async () => { // асинхронная функция, вызываемая при отправке формы.
  if (!message.value.trim()) return // проверка на пустоту message

  try { 
    const response = await axios.post('http://localhost:8000/api/newPost', { // Отправляется POST-запрос на бэкенд по адресу http...newPost 
      user_id: currentUserId, // id пользователя, который добавляет пост
      message: message.value, // сообщение, которое ввел пользователь в форме
    })
    message.value = '' // очищаем поле ввода
    alert('Пост отправлен') // всплывает окошко с сообщением ("пост отправлен")

    window.dispatchEvent(new CustomEvent('post-created', { // создание глобального события с именем post-created.
      detail: response.data // объект detail содержит любые данные, которые ты хочешь передать слушателю события.
    }))
  } catch (err) { // отлов возможных ошибок
    alert('Ошибка при отправке поста') // вывод ококша с текстом  "Ошибка при отправке поста"
    console.error(err) // вывод в консоль сообщение ошибки
  }
}
</script>

<template>
  <div class="layout"> <!-- div-обертка над всем template (шаблоном) -->
    <header class="header"> <!-- шапка сайта -->
      <NuxtLink to="/" class="custom-link">Моя лента</NuxtLink>  <!-- ссылка -->
      <NuxtLink to="/byuser" class="custom-link">Поиск постов по имени пользователя</NuxtLink> <!-- ссылка -->
      <NuxtLink to="/byhashtag" class="custom-link">Поиск постов по хэштегу</NuxtLink> <!-- ссылка -->
    </header>
    
    <main class="main">  <!-- основная часть страницы -->
      <form @submit.prevent="submitPost" class="create-post-form"> <!-- @submit.prevent="submitPost" — при отправке формы вызывается submitPost, но не происходит перезагрузки страницы  -->
        <input v-model="message" type="text" placeholder="Напиши пост..." maxlength="280" class="post-input" /> <!-- v-model="message" - двусторонняя привязка (типо ссылки)  -->
        <input type="submit" class="post-button"> <!-- кнопка "отправить" -->
      </form>
  
      <slot /> <!-- место, куда будут "вставляться" страницы приложения. Это как контейнер для контента -->

    </main>
    
    <footer class="footer">  <!-- Футер, подвал страницы -->
      <p>&copy; 2025 Bitter. Все права защищены.</p>
    </footer>
  </div>
</template>

<style scoped>
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

.custom-link {
  color: white;
  text-decoration: none;
}

.custom-link:hover {
  text-decoration: underline;
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
  margin-bottom: 50px;
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
  border-color: #3b82f6;
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
  background-color: #2563eb;
}

/* New post-card styles */
.post-card {
  border: 1px solid #ddd;
  padding: 15px;
  margin-bottom: 20px;
  border-radius: 8px;
  background-color: #fff;
}

.post-card .content {
  font-size: 14px;
}

.post-card small {
  color: #888;
}

.post-card p {
  margin: 10px 0;
}
</style>
