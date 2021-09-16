<template>
  <div class="login background">
    <header class="header">
      <img class="header_logo" src="../static/img/logo.png">
      <ul class="header__list">
        <li class="header__list--item" @click="$router.push('/register')">新規登録</li>
        <li class="header__list--item" @click="$router.push('/login')">ログイン</li>
      </ul>
    </header>
  </div>
</template>