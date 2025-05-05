<script setup>
import { ref } from 'vue'
import axios from 'axios'

const hashtag = ref('')
const posts = ref([])

const search = async () => {
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
  <div class="p-4 max-w-md mx-auto">
    <input
      v-model="hashtag"
      @keyup.enter="search"
      type="text"
      placeholder="Введите хэштег"
      class="border p-2 w-full rounded"
    />
    <button @click="search" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
      Найти посты
    </button>

    <div v-if="posts.length" class="mt-4">
      <h2 class="text-xl font-semibold mb-2">Посты по хэштегу #{{ hashtag }}</h2>

      <div v-for="post in posts" :key="post.id" class="post">
        <small>Автор: {{ post.user.nickname}} <br> Дата: {{ post.created_at.slice(0, 10) }}</small>
        <p>{{ post.message }}</p>
      </div>
      
    </div>
  </div>
</template>
