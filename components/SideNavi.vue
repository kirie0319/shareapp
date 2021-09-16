<template>
    <div class="home__common">
      <img class="header_logo" src="../static/img/logo.png">
      <div class="home--link" @click="$router.push('/')">
        <img class="home--img" src="../static/img/home.png">
        <p class="home--txt">ホーム</p>
      </div>
      <div class="home--link" @click="logout">
        <img class="home--img" src="../static/img/logout.png">
        <button class="home--txt">ログアウト</button>
      </div>
      <div class="share__block">
        <label for="share" class="share--txt">シェア</label>
        <textarea id="share" v-model="newPost" class="share--area"></textarea>
        <button @click="share" class="share--btn">シェアする</button>
      </div>
    </div>
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
  data() {
    return{
      newPost: "",
    };
  },
   methods: {
    logout() {
      firebase
        .auth()
        .signOut()
        .then(() => {
          alert('ログアウトが完了しました')
          this.$router.replace('/login')
        })
    },
    share() {
      if (!this.newPost) {
        alert("シェアする内容を入力してください");
      } else {
        firebase.auth().onAuthStateChanged((user) => {
          const sendData = {
              user_id: user.uid,
              post: this.newPost,
          }
          this.$axios.post("http://127.0.0.1:8000/api/post", sendData)
          .then(() => {
            alert("シェアしました");
            this.newPost = "";
            this.$emit("getPost");
          });
        });
      }
    },
  },
}
</script>