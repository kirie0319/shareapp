<template>
  <div class="container background home">
    <SideNavi @getPost="getData" />
    <Message :postLists="postLists" :uid="uid" />
  </div>
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
  data() {
    return{
      postLists: [],
      uid: null,
    }
  },
   methods: {
    async getPostData() {
      const postData = await this.$axios.get(
        "http://127.0.0.1:8000/api/post"
      );
      const postLists = postData.data.data;
      return postLists;
    },
    async getLikeCount(postLists) {
      for (let i = 0; i < postLists.length; i++) {
          const likeCountData = await this.$axios.get("http://127.0.0.1:8000/api/like/count",
          {
            params: {
              post_id: postLists[i].id,
            },
          }
        );
        console.log(likeCountData);
        postLists[i].like_count = likeCountData.data.count;
      }
      return postLists;
    },

    async getHasLike(postLists) {
      for (let i = 0; i < postLists.length; i++) {
        const hasLikeData = await this.$axios.get("http://127.0.0.1:8000/api/like", {
            params: {
              post_id: postLists[i].id, 
              user_id: this.uid,
            },
          }
        );
        postLists[i].has_like = hasLikeData.data.result;
      }
      this.postLists = postLists;
    },
    getData() {
      firebase.auth().onAuthStateChanged(async (user) => {
        this.uid = user.uid;
        let postLists = await this.getPostData();
        postLists = await this.getLikeCount(postLists);
        await this.getHasLike(postLists);
      });
    },
  },
  created() {
    this.getData();
  },
}
</script>