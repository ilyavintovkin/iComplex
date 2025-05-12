<!-- Данный компонент работает с массивом постов -->
<script setup>
import PostCard from './PostCard.vue' // подключение компонента PostCard->FollowButton

const props = defineProps({ // Обьявление пропсов (входные параметры)
  posts: Array, // массив постов
  currentUserId: Number, // текущий пользователь
  onFollowChange: Function  // функция, которая будет вызвана после того, как будет выполнена операция подписки/отписки.
})
</script>

<template>
  <div>
    <div v-for="post in posts" :key="post.id" class="post"> <!-- перебор всех постов. Каждый пост "посылаем" в PostCard-->
      <PostCard
        :post="post"
        :currentUserId="currentUserId"
        :onFollowChange="onFollowChange"
      />
    </div>
  </div>
</template>
