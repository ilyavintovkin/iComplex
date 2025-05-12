<!-- Данный компонент показывает нужную кнопку для одного ПОСТА -->
<script setup>
import { ref, watch } from 'vue' // подключение функций ref, watch
import axios from 'axios' // импортирование axios (для запросов)
const props = defineProps({ // обьявление пропсов (входные параметры)
  currentUserId: Number, // id текущего юзера
  targetUserId: Number, // id юзера для подписки/отписки
  initialIsFollowing: Boolean, // флаг, подписан ли пользователь?
  onFollowChange: Function // функция вызываемая после отрабатывания функции Подписки/Отписки ( например перезагрузка постов, для отображения измененных постов)
})

const isFollowingLocal = ref(props.initialIsFollowing) // локальное реактивное состояние (будет меняться при нажатии на кнопку)

watch(() => props.initialIsFollowing, (newVal) => { // Следит. Если родитель обновит initialIsFollowing, локальное состояние тоже обновится.
  isFollowingLocal.value = newVal // вот само обновление initialIsFollowing
})

const toggleFollow = async () => { // Функция вызываемая при нажатии на кнопку
  try {
    if (isFollowingLocal.value) { // если флаг  isFollowingLocal == true. Значит текущий пользователь подписан - соответственно можем только отписаться
      await axios.delete('http://localhost:8000/api/unfollow', { // посылается запрос на отписку (удаление записи в таблице follow)
        data: { // данные упаковываются в data
          currentUserId: props.currentUserId, // текущий пользователь, который хочет отписаться
          userIdToUnfollow: props.targetUserId // указание id пользователя, от которого хочет отписаться текущий пользователь
        }
      })
    } else {
      await axios.post('http://localhost:8000/api/follow', { // если не подписаны - значит можем подписаться
        currentUserId: props.currentUserId, // текущий пользователь, который хочет подписаться
        userIdToFollow: props.targetUserId // указание id пользователя, на которого хочет подписаться текущий пользователь
      })
    }

    isFollowingLocal.value = !isFollowingLocal.value // независимо от исхода меняем флаг на противоположный 

    if (props.onFollowChange) { // Если функцию передали, то она вызовется 
      props.onFollowChange() // Перезагрузка постов
    }
  } catch (error) { // отлов возможных ошибок
    console.error('Ошибка при подписке/отписке:', error)
  }
}
</script>

<template>
  <button @click="toggleFollow"> <!-- При клике на кнопку сработает функция toggleFollow -->
    {{ isFollowingLocal ? 'Отписаться' : 'Подписаться' }} <!-- В зависимсости от того подписан текущий пользователь или нет будет выведен определенный текст -->
  </button>
</template>

