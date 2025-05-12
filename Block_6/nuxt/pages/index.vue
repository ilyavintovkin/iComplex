<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue' // подключение функций ref - для реактивных переменных, onMounted - хук (момент запуска), onBeforeUnmount - хук (перед очисткой)
import axios from 'axios' // подключение axios ( для запросов)
import FollowButton from '@/components/FollowButton.vue' // подключение компонента FollowButton - для отображения кнопки

const currentUserId = ref(3) // Реактивная переменная. Id текущего пользователя
const posts = ref([]) // реактивная переменная (будет хранить посты для отображения)
const loading = ref(true) // реактивная переменная-флаг - пока посты грузятся = true

const loadPosts = async () => { // функция получения постов 
  loading.value = true // пока грузится флаг загрузки = true
  try {
    const response = await axios.get('http://localhost:8000/api/lenta') // запрос на Api, для получения постов
    posts.value = response.data // присваивание реактивной переменной posts - постов, пришедших с api
  } catch (error) { //возможный отлов ошибок
    console.error('Ошибка при получении постов:', error)
  } finally {
    loading.value = false // после загрузки флаг загрузки становится false
  }
}

onMounted(() => { // при загрузке .vue 
  loadPosts() // вызывается функция отображения постов 
  window.addEventListener('post-created', loadPosts) // подписка на событие (создать пост) - функцией загрузить посты
 })

onBeforeUnmount(() => { // при уничтожении .vue 
  window.removeEventListener('post-created', loadPosts) // отписываемся
})

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
</script>

<template>
  <div v-if="loading">Загрузка...</div>
  <div v-else>
    <h2>Моя лента</h2>
    <div v-for="post in posts" :key="post.id" class="post">
      <div class="content">
        <small> Автор: {{ post.user.nickname }} <br> Дата: {{ formatDate(post.created_at) }}</small>
        <p>{{ post.message }}</p>

        <!-- Кнопка подписки — через компонент -->
        <div v-if="currentUserId !== post.user.id">
          <FollowButton
            :currentUserId="currentUserId"
            :targetUserId="post.user.id"
            :initialIsFollowing="post.is_following"
            :onFollowChange="loadPosts"
          />
        </div>
        
      </div>
    </div>
  </div>
</template>

<style scoped>
.content {
  border: 1px solid #ddd;
  padding: 15px;
  margin-bottom: 20px;
  border-radius: 8px;
  background-color: #fff;
  font-size: 14px;
}

.post-card .content {
  font-size: 14px;
}

  small {
  color: #888;
}

.post-card p {
  margin: 10px 0;
}
</style>


