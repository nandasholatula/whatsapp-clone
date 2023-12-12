<template>
  <modal
    name="image-preview"
    classes="cute-image-preview-photo"
    transition="scale"
    height="auto"
  >
    <div
      slot="top-right"
      class="ct-top-right"
      @click="$modal.hide('image-preview')"
    >
      X
    </div>
    <img :src="url" />
  </modal>
</template>
<script>
import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
export default {
  computed: {
    ...mapGetters({
      url: "image/getUrl",
    }),
  },
};
</script>
<style lang="scss">
.cute-image-preview-photo {
  background-color: transparent;
  display: flex;
  justify-content: center;
  box-shadow: 0 2px 20px 0 rgba(0, 0, 0, 0.4);
  border: 1px solid rgba(255, 255, 255, 0.65);
}
.cute-image-preview-photo img {
  max-height: 80vh;
  max-width: 80vw;
}
.ct-top-right {
  cursor: pointer;
  margin: 20px;
  padding: 10px 20px;
  font-weight: 600;
  color: white;
  text-shadow: 0 0px 20px black;
  background: #555;
  border-radius: 100px;
}
.scale-enter-active,
.scale-leave-active {
  transition: all 0.5s;
}
.scale-enter,
.scale-leave-active {
  opacity: 0;
  transform: scale(0.3) translateY(24px);
}
</style>