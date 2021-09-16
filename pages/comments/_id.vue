<template>
  <div class="container background home">
    <div class="home__common">
      <img class="header_logo" src="../../static/img/logo.png">
      <div class="home--link">
        <NuxtLink to="/"><img class="home--img" src="../../static/img/home.png"></NuxtLink>
        <NuxtLink to="/" class="home--txt">ホーム</NuxtLink>
      </div>
      <div class="home--link">
        <img @click="logout" class="home--img" src="../../static/img/logout.png">
        <button @click="logout" class="home--txt">ログアウト</button>
      </div>
      <div class="share__block">
        <label for="share" class="share--txt">シェア</label>
        <textarea id="share" name="post" v-model="newPost" row="10" cols="44" class="share--area"></textarea>
        <button @click="share" class="share--btn">シェアする</button>
      </div>
    </div>
    <div class="post">
      <h1 class="post--txt post--border">コメント</h1>
      <div class="post--border post__content">
        <h2 v-if="postLists.actor" class="post__content--txt">{{postLists.actor.name}}</h2>
        <img v-if="postLists.id" class="post__content--img" src="../../static/img/heart.png">
        <p class="post__good">0</p>
        <NuxtLink to="/comments/:id?"><img v-if="postLists.id" @click="deleteShare(postLists.id)" class="post__content--img" src="../../static/img/cross.png"></NuxtLink>
        <p class="post__content--detail">{{postLists.post}}</p>
      </div>
      <h2 class="post--border comment--txt">コメント</h2>
      <div v-for="item in commentLists" :key="item.id" class="post--border">
        <p class="comment--content">{{item.actor.name}}</p>
        <p class="comment--content">{{item.comment}}</p>
      </div>
      <div class="comment">
        <textarea name="comment" v-model="newComment" row="10" cols="44" class="comment--area"></textarea>
        <button @click="comment" class="comment--btn">コメント</button>
      </div>
    </div>
  </div>
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
  data() {
    return{
      newPost: null,
      postLists: {},
      uid: null,
      newComment: null,
      commentLists: [],
    }
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
    async getPost() {
      const resData = await this.$axios.get(
        "http://127.0.0.1:8000/api/post/" + this.$route.params.id
      );
      this.postLists = resData.data.data;
    },
    async getComment() {
      const commentData = await this.$axios.get(
      "http://127.0.0.1:8000/api/comment"
      );
      this.commentLists = commentData.data.data;
    },
    async share() {
      const sendData = {
        post: this.newPost,
        actor_id: this.uid
      };
      await this.$axios.post("http://127.0.0.1:8000/api/post/", sendData);
      this.getPost();
    },
    async comment() {
      const submitData = {
        comment: this.newComment,
        actor_id: this.uid,
        post_id: this.postLists.id,
      };
      console.log(submitData);
      await this.$axios.post("http://127.0.0.1:8000/api/comment/", submitData);
      this.getComment();
    },
    async deleteShare(id) {
      await this.$axios.delete("http://127.0.0.1:8000/api/post/" + id);
    }
  },
  created() {
    firebase.auth().onAuthStateChanged((user) => {
      if (user) {
        this.uid = user.uid
        this.message = 'ログイン済みです'
      }
    })
    this.getPost();
    this.getComment();
  },
}
</script>