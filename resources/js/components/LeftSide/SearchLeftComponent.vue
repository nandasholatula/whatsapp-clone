<template>
  <div class="search-left">
    <input
      type="text"
      class="search-input border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-green_cus-300 focus:border-transparent"
      placeholder="Search Contact"
      v-model="search"
      @change="searchName"
    />
  </div>
</template>
<script>
import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
export default {
  data: () => ({
    search: "",
  }),
  computed: {},
  methods: {
    ...mapMutations({
      setSearch: "dialogs/setSearch",
      setSearchList: "dialogs/setSearchList",
    }),
    ...mapActions({
      searchDialogs: "dialogs/searchDialog",
    }),
    searchName() {
      this.setSearch(this.search);
      //   this.searchDialogs(this.search);
      if (this.search != "" && !/^\s+$/.test(this.search)) {
        axios.get("/chat/contact/search/" + this.search).then((e) => {
          //   state.commit("searchDialog", e.data);
          this.setSearchList(e.data);
        });
      } else {
        // state.commit("searchDialog", null);
        this.setSearchList(null);
      }
    },
  },
};
</script>
<style lang="scss" scoped>
.search-left {
  padding: 10px 20px;
  height: 10vh;
  .search-input {
    width: 100%;
    height: 6vh;
    padding: 0 8px;
  }
}
</style>