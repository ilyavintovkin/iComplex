<script setup>
import { ref } from 'vue';
import axios from 'axios';

const nickname = ref('');
const posts = ref([]);

const searchPosts = async () => {
  if (!nickname.value.trim()) return;

  try {
    // Исправленный endpoint для поиска постов по никнейму
    const response = await axios.get(`http://localhost:8000/api/${nickname.value}`);
    posts.value = response.data;
  } catch (error) {
    console.error('Ошибка при получении постов:', error);
  }
};
</script>

<template>
  <div>
    <input v-model="nickname" @keyup.enter="searchPosts" placeholder="Введите никнейм" />
    <button @click="searchPosts">Найти посты</button>

    <div v-if="posts.length">
      <div v-for="post in posts" :key="post.id">
        <small>Автор: {{ post.user?.nickname}} <br> Дата: {{ post.created_at.slice(0, 10) }}</small>
        <p>{{ post.message }}</p>
      </div>
    </div>
  </div>
</template>