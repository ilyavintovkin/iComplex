<template>
  <div>
    <NuxtRouteAnnouncer />
    <NuxtLayout> <!-- Этот компонент оборачивает текущую страницу в default.vue layout-->
      <NuxtPage /> <!-- Это место, куда вставляется контент текущей страницы (pages/*.vue) -->
    </NuxtLayout>
  </div>
</template>
