<script setup>
import { ref } from 'vue';
import axios from 'axios';

const nickname = ref('');
const posts = ref([]);

const searchByNickname = async () => {
  if (!nickname.value.trim()) return;

  try {
    const response = await axios.get(`http://localhost:8000/api/${nickname.value}`);
    posts.value = response.data;
  } catch (error) {
    console.error('Ошибка при получении постов:', error);
  }
};
</script>

<template>
  <div>
    <input v-model="nickname" @keyup.enter="searchByNickname" placeholder="Введите никнейм" />
    <button @click="searchByNickname">Найти посты по никнейму</button>

    <div v-if="posts.length">
        <div v-for="post in posts" :key="post.id" class="post">

          <div class="content">
           <small>Автор: {{ post.user?.nickname}} <br> Дата: {{ post.created_at.slice(0, 10) }}</small>
            <p>{{ post.message }}</p>
          </div>

        </div>
    </div>
  </div>
</template>