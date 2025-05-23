<script setup>
import { ref } from 'vue' // импорт функции ref(). используется для создания переменной, которая будет реагировать на изменения.
import axios from 'axios' // библиотека axios (библиотека HTTP запросов)
import PostList from '@/components/PostList.vue' // подключение компонента PostList

const currentUserId= ref(4); // создание реактивной переменной (будет хранить вводимый пользователем хэштег )
const posts = ref([]); // создание реактивной переменной (будет хранить посты)
const searched = ref(false) // флаг, был ли выполнен поиск
const loading = ref(false)

const nickname = ref(''); // создание реактивной переменной (будет хранить вводимый пользователем хэштег )

const searchByNickname = async () => { // асинхронная функция, вызываемая при нажатии на кнопку "найти посты по хэштегу".
  if (!nickname.value.trim()) return; // проверка на пустоту message     
  loading.value = true;
  try {
    const response = await axios.get(`http://localhost:8000/api/${nickname.value}`); // GET-запрос на api. Получение определенных постов по введенному никнейму ${nickname}
    posts.value = response.data; // присваиваю в реактивную переменную все посты полученные по запросу на api.
  } catch (error) { // отлов возможных ошибок
    console.error('Ошибка при получении постов:', error); // вывод сообщения ошибки
  } finally {
    searched.value = true; // т.к. была нажата кнопка - значит был выполнен поиск.
    loading.value = false;
  }
};
</script>

<template>
  <div>
    <input v-model="nickname" type="text" placeholder="Введите никнейм" /> <!-- поле ввода никнейма для поиска постов по никнейму -->
    <button @click="searchByNickname">Найти посты по никнейму</button> <!-- кнопка, нажав на которую вызовется функция searchByNickname -->

    <div v-if="posts.length"> <!-- проверка, что кол-во постов > 0-->
      <h2>Посты по никнейму "#{{ nickname }}"</h2> <!-- вывод заголовка -->

      <div v-if="loading" class="preloader"></div>
     
      <PostList
        :posts="posts"
        :currentUserId="currentUserId"
        :onFollowChange="searchByNickname"
      />
    </div>

    <div v-else> <!-- если кол-во постов == 0 - значит не нашли подходящих постов  -->
      <h2 v-if="searched">Посты по никнейму "#{{ nickname }}" - не найдены</h2>
    </div>
  </div>
</template>