<!-- данный компонент работает с одним ПОСТОМ из массива постов-->
<script setup>
import FollowButton from '@/components/FollowButton.vue' // подключение компонента followButton (Получется)

const props = defineProps({ // обьявление пропсов (входные параметры)
  post: Object, // объект, содержащий данные о посте, такие как автор, содержание, дата создания и статус подписки.
  currentUserId: Number, // ID текущего пользователя
  onFollowChange: Function // функция, которая будет вызвана после того, как будет выполнена операция подписки/отписки.
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
  <div class="post-card">
    <div class="content">
      <small>Автор: {{ post.user.nickname }} <br> Дата: {{ formatDate(post.created_at) }}</small> <!-- основаная информация поста-->
      <p>{{ post.message }}</p>

      <!-- Кнопка подписки  -->
      <div v-if="currentUserId !== post.user.id"> <!-- если текущий пользователь не является автором поста - будет показна кнопка-->
        <!-- Выводим всю информацию отдельно поста, и для отображения верной кнопки "посылаем" пост в FollowButton-->
        <FollowButton
          :currentUserId="currentUserId" 
          :targetUserId="post.user.id"
          :initialIsFollowing="Boolean(post.is_following)"
          :onFollowChange="onFollowChange"
        />
      </div>
    </div>
  </div>
</template>

<style scoped>
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
