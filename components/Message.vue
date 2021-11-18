<template>
<div>
      <div v-for="(item, index) in postLists" :key="item.id" class="post--border post__content">
        <h2 class="post__content--txt">{{item.user_name}}</h2>
        <img @click="like(item, index)" class="post__content--img" src="../static/img/heart.png">
        <p class="post__good">{{item.like_count}}</p>
        <img @click="deletePost(item.id, index)" class="post__content--img" src="../static/img/cross.png">
        <img class="post__content--img space" src="../static/img/detail.png" @click="$router.push({path: '/comments/' + item.id, params: { id: item.id }, })" v-if="$route.name === 'index'">
        <p class="post__content--detail">{{item.post}}</p>
      </div>
</div>
</template>

<script>
export default {
  props: {
      postLists: Array,
      uid: String,
  },
   methods: {
    async like(item, index) {
      const sendData = {
        post_id: item.id,
        user_id: this.uid,
      };
      if (!item.has_like) {
        const { data } = await this.$axios.post("http://127.0.0.1:8000/api/like", sendData);
        this.postLists[index].like_count = data.count;
        this.postLists[index].has_like = data.result;
      } else {
        const { data } = await this.$axios.delete("http://127.0.0.1:8000/api/like", {data: sendData,}
        );
        this.postLists[index].like_count =  data.count;
        this.postLists[index].has_like = data.result;
      }
    },
    async deletePost(id, index) {
      await this.$axios.delete("http://127.0.0.1:8000/api/post/" + id);
      this.postLists.splice(index, 1);
      this.$router.push("/");
    }
  },
}
</script>