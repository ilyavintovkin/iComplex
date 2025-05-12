<script setup>
import { ref } from 'vue' // импорт функции ref(). используется для создания переменной, которая будет реагировать на изменения.
import axios from 'axios' // библиотека axios (библиотека HTTP запросов)
import PostList from '@/components/PostList.vue'

const currentUserId= ref(3); // создание реактивной переменной (будет хранить вводимый 
const posts = ref([]); // создание реактивной переменной (будет хранить посты)
const searched = ref(false) // флаг, был ли выполнен поиск

const hashtag = ref('') // создание реактивной переменной (будет хранить вводимый пользователем хэштег )

const searchByHashtag = async () => {  // асинхронная функция, вызываемая при нажатии на кнопку "найти посты по хэштегу".
  if (!hashtag.value.trim()) return  // проверка на пустоту message
  const tag = hashtag.value.replace(/^#/, '') // удаление # если пользователь ввел его

  try {
    const response = await axios.get(`http://localhost:8000/api/hash/${tag}`); // GET-запрос на api. Получение определенных постов по введенному хэштегу ${tag}
    posts.value = response.data // присваиваю в реактивную переменную все посты полученные по запросу на api.
  } catch (error) { // отлов возможных ошибок
    console.error('Ошибка при получении постов:', error) // вывод сообщения ошибки
  } finally {
    searched.value = true; // т.к. была нажата кнопка - значит был выполнен поиск.
  }
}
</script>

<template>
  <div>
    <input v-model="hashtag" type="text" placeholder="Введите хэштег" /> <!-- поле ввода хэштега для поиска постов по хэштегу-->
    <button @click="searchByHashtag">Найти посты по хэштегу</button> <!-- в случае клика на кнопку - отработает функция searchByHashtag-->

    <div v-if="posts.length"> <!-- проверка, что кол-во постов в массиве > 0-->
      <h2>Посты по хэштегу "#{{ hashtag }}"</h2> <!-- вывод заголовка-->
      <!-- "посылаем" массив в PostList-->
      <PostList 
        :posts="posts"
        :currentUserId="currentUserId"
        :onFollowChange="searchByHashtag"
      />
    </div>

    <div v-else> <!-- Если кол-во постов в массиве == 0 - значит посты по введенному хэштегу не найдены -->
      <h2 v-if="searched">Посты по хэштегу "#{{ hashtag }}" - не найдены</h2>
    </div>
  </div>
</template>
