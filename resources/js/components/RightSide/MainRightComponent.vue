<template>
  <div class="right-side">
    <div v-if="selected">
      <Header @toggle="$emit('toggle')" />
      <Chat />
      <InputRight />
    </div>
    <div class="no-contact" v-else>Select contact to start chat</div>
  </div>
</template>
<script>
import Header from "./HeaderRightComponent";
import Chat from "./ChatRightComponent";
import InputRight from "./InputRightComponent";
import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
export default {
  components: { Header, Chat, InputRight },
  computed: {
    ...mapGetters({
      selected: "dialogs/getSelectedDialogs",
    }),
  },
};
</script>
<style lang="scss" scoped>
.right-side {
  flex: 4;
  .no-contact {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bolder;
    font-size: 2rem;
  }
}
</style>