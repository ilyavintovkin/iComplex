# Используем официальный Node.js образ
FROM node:latest

# Устанавливаем рабочую директорию
WORKDIR /usr/src/app

# Копируем package.json и package-lock.json в рабочую директорию
COPY ./nuxt/package*.json ./

# Устанавливаем зависимости
RUN npm install

# Копируем весь код приложения в контейнер
COPY ./nuxt /usr/src/app

# Собираем приложение Nuxt.js
RUN npm run build

# Запускаем приложение
CMD ["npm", "run", "start"]

# Указываем порт, на котором будет работать Nuxt.js
EXPOSE 3000
