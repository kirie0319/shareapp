<template>
  <div class="container background home">
    <SideNavi />
    <div class="post">
      <h1 class="post--txt post--border">コメント</h1>
    <Message :postLists="postLists" :uid="uid" />
      <h2 class="post--border comment--txt">コメント</h2>
      <div v-for="item in commentLists" :key="item.id" class="post--border">
        <p class="comment--content">{{item.user_name}}</p>
        <p class="comment--content">{{item.comment}}</p>
      </div>
      <div class="comment">
        <textarea name="comment" v-model="newComment" row="10" cols="44" class="comment--area"></textarea>
        <button @click="postComment" class="comment--btn">コメント</button>
      </div>
    </div>
  </div>
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
  data() {
    return {
      postLists: [],
      uid: null,
      newComment: null,
      commentLists: [],
    };
  },
   methods: {
    async getPostAndCommentData() {
      const resData = await this.$axios.get(
        "http://127.0.0.1:8000/api/comment/", 
        {
          params: {
            post_id: this.$route.params.id,
          },
        }
      );
      console.log(resData);
      const post = resData.data.data;
      return post;
    },
    async getLikeCount(post) {
      const { data } = await this.$axios.get(
        "http://localhost:8000/api/like/count",
        {
          params: {
            post_id: post.id,
          },
        }
      );
      post.like_count = data.count;
      return post;
    },
    async getHasLike(post) {
      const { data } = await this.$axios.get(
        "http://localhost:8000/api/like",
        {
          params: {
            post_id: post.id,
            user_id: this.uid,
          },
        }
      );
      post.has_like = data.result;
      this.commentLists = post.comments;
      this.postLists.push(post);
    },
    getData() {
      firebase.auth().onAuthStateChanged(async (user) => {
        this.uid = user.uid;
        let post = await this.getPostAndCommentData();
        post = await this.getLikeCount(post);
        await this.getHasLike(post);
      });
    },
    async postComment() {
      const { data } = await this.$axios.post(
        "http://localhost:8000/api/comment",
        {
          post_id: this.postLists[0].id,
          user_id: this.uid,
          comment: this.newComment,
        }
      );
      this.commentLists.push(data.data);
      this.newComment = "";
    },
  },
  created() {
    this.getData();
  },
}
</script>