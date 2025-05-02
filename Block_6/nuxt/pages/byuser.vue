<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const data = ref(null)
const error = ref(null)
const loading = ref(true)

onMounted(async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/hello')
    data.value = response.data
  } catch (err) {
    error.value = err
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div v-if="loading">Загрузка...</div>
  <div v-else-if="error">Ошибка: {{ error.message }}</div>
  <div v-else>
    <h1>{{ data.message }}</h1>
  </div>
</template>
