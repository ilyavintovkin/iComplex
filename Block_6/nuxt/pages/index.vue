<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import axios from 'axios'

const data = ref(null)
const error = ref(null)
const loading = ref(true)

const loadPosts = async () => {
  loading.value = true
  try {
    const response = await axios.get('http://localhost:8000/api/lenta')
    data.value = response.data
  } catch (err) {
    error.value = err
  } finally {
    loading.value = false
  }
}

const handleNewPost = () => {
  loadPosts()
}

onMounted(() => {
  loadPosts()
  window.addEventListener('post-created', handleNewPost)
})

onBeforeUnmount(() => {
  window.removeEventListener('post-created', handleNewPost)
})
</script>

<template>
  <div v-if="loading">Загрузка...</div>
  <div v-else-if="error">Ошибка: {{ error.message }}</div>
  <div v-else>
    <h2>Моя лента</h2>
    <div v-for="post in data" :key="post.id" class="post">

      <div class="content">
        <small>Автор: {{ post.user.nickname }} <br> Дата: {{ post.created_at.slice(0, 10) }}</small>
        <p>{{ post.message }}</p>
      </div>
      
    </div>
  </div>
</template>
