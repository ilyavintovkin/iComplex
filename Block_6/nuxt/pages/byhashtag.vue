<script setup>
import { ref } from 'vue'
import axios from 'axios'

const hashtag = ref('')
const posts = ref([])

const searchByHashtag = async () => {
  if (!hashtag.value.trim()) return
  const tag = hashtag.value.replace(/^#/, '') // удаляем # если пользователь ввел его

  try {
    const response = await axios.get(`http://localhost:8000/api/hash/${tag}`);
    posts.value = response.data
  } catch (error) {
    console.error('Ошибка при получении постов:', error)
  }
}
</script>

<template>
  <div>
    <input v-model="hashtag" @keyup.enter="searchByHashtag" type="text" placeholder="Введите хэштег"/>
    <button @click="searchByHashtag">Найти посты по хэштегу</button>

    <div v-if="posts.length">
      <h2>Посты по хэштегу #{{ hashtag }}</h2>
      <div v-for="post in posts" :key="post.id" class="post">

        <div class="content">
          <small>Автор: {{ post.user.nickname}} <br> Дата: {{ post.created_at.slice(0, 10) }}</small>
          <p>{{ post.message }}</p>
        </div>

      </div>
    </div>
  </div>
</template>

