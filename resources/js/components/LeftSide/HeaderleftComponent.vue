<template>
  <div class="header">
    <div class="me d-flex px-4">
      <span class="name">{{ user.name }}</span>

      <i
        class="bi bi-box-arrow-right"
        title="Log Out from Whatsapp"
        @click="exitWa"
      ></i>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
export default {
  computed: {
    ...mapGetters({
      user: "user/currentUser",
      userCred: "cred/getCred",
    }),
  },
  methods: {
    ...mapActions({
      setUserStatus: "user/setStatus",
    }),
    exitWa() {
      // console.log(this.userCred);
      axios
        .post(this.userCred.instance + "logout?token=" + this.userCred.token)
        .then(() => {
          this.setUserStatus(null);
          // console.log("exit wa");
        });
    },
  },
};
</script>
<style lang="scss" scoped>
.header {
  height: 10vh;
  .me {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-weight: bold;
    .name {
      font-size: 1.1rem;
    }
    .bi {
      font-size: 20px;
    }
    .bi:hover {
      cursor: pointer;
    }
  }
}
</style>