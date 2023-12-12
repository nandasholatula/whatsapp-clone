<template>
  <div class="main-left">
    <Header />
    <SearchLeftComponent />
    <Contact @toggle="$emit('toggle')" />
  </div>
</template>
<script>
import Header from "./HeaderleftComponent";
import Contact from "./ContactLeftComponent";
import SearchLeftComponent from "./SearchLeftComponent.vue";
export default {
  components: { Header, Contact, SearchLeftComponent },
  methods: {
    selectedContact(contact) {
      this.$emit("selectedContact", contact);
    },
  },
};
</script>
<style lang="scss" scoped>
.main-left {
  flex: 1.5;
}
</style>