<template>
  <div class="credential">
    <div class="card rounded-lg border-none shadow-md">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">ChatId</th>
                <th scope="col">Phone</th>
                <th scope="col">Instance</th>
                <th scope="col">Token</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(cre, inx) in creds" :key="inx">
                <th scope="row">{{ inx + 1 }}</th>
                <td>{{ cre.name }}</td>
                <td>{{ cre.chatId }}</td>
                <td>{{ cre.phone }}</td>
                <td>{{ cre.instance }}</td>
                <td>{{ cre.token }}</td>
                <td>
                  <button
                    class="btn bg-blue-400 text-white hover:bg-blue-600"
                    @click="showModal(cre)"
                  >
                    edit
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="grid">
          <div
            class="btn border-1 border-green-400 text-green-400 hover:text-white hover:bg-green-400"
            @click="showModal()"
          >
            add
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Credential from "./modals/Credential";
import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
import Swal from "sweetalert2";
export default {
  components: { Credential },
  computed: {
    ...mapGetters({
      creds: "credentials/getCreds",
    }),
  },
  mounted() {
    this.setCreds();
  },
  methods: {
    ...mapActions({
      setCreds: "credentials/setCredentials",
    }),
    showModal(cred = null) {
      this.$modal.show(
        Credential,
        {
          cred: cred,
        },
        { height: "auto", width: "90%" }
      );
    },
  },
};
</script>
<style lang="scss" scoped>
.grid {
  display: grid;
  place-items: end;
}
</style>