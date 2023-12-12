<template>
  <div>
    <Loading
      :active.sync="isLoading"
      :can-cancel="false"
      :is-full-page="true"
    />
    <div class="main" v-if="gStatus == 'authenticated'">
      <ImagePreview />
      <SendImage />
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card rounded-lg border-none shadow-lg">
            <div class="card-body p-0 d-flex">
              <MainLeft
                :class="isMobile ? (!toggleSideBar ? 'hidden' : '') : ''"
                @toggle="toggleSide"
              />
              <MainRight
                :class="isMobile ? (toggleSideBar ? 'hidden' : '') : ''"
                @toggle="toggleSide"
              />
              <!-- <button @click="handleinc">{{ aGet }}</button> -->
              <!-- <button @click="$modal.show('image-preview')">show</button> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else-if="!isLoading">
      <QrCodeComponent />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import MainLeft from "./LeftSide/MainLeftComponent";
import MainRight from "./RightSide/MainRightComponent";
import ImagePreview from "./modals/ImagePreview";
import SendImage from "./modals/sendImage";
import Loading from "vue-loading-overlay";
import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
import "vue-loading-overlay/dist/vue-loading.css";
import QrCodeComponent from "./QrCodeComponent.vue";
export default {
  components: {
    MainLeft,
    MainRight,
    ImagePreview,
    SendImage,
    Loading,
    QrCodeComponent,
  },
  data() {
    return {
      messages: null,
      select_contact: null,
      status: null,
      today: new Date().toISOString().split("T")[0],
      isLoading: false,
      qrCodeSrc: null,
      toggleSideBar: true,
      isMobile: false,
    };
  },
  beforeMount() {
    this.isLoading = true;
    this.isMobile = this.$vssWidth < 640;
    // this.setDialogs();
    this.setUser();
    this.setCred().then(() => {
      axios
        .get(this.userCred.instance + "status?token=" + this.userCred.token)
        .then((e) => {
          if (e.data.accountStatus == "authenticated") {
            this.setUserStatus(e.data.accountStatus);
          } else {
            this.setSrc(e.data.qrCode);
          }
          this.isLoading = false;
        });
    });
  },
  mounted() {
    Echo.private("test").listen("TestEvent", (e) => {
      this.setUserStatus(null);
      console.log(e.data);
    });
    Echo.private("status").listen("StatusChange", (e) => {
      if (e.status == "authenticated") this.setUserStatus("authenticated");
    });
  },
  computed: {
    ...mapState({
      cn: "count",
    }),
    ...mapGetters({
      // done: "doneTodos",
      // doneCount: "doneTodosCount",
      // doneId: "getTodoById",
      // aGet: "a/doubleCount",
      cUser: "user/currentUser",
      gStatus: "user/getStatus",
      userCred: "cred/getCred",
      gDialogs: "dialogs/getDialogs",
      selectedDialogs: "dialogs/getSelectedDialogs",
    }),
  },
  methods: {
    ...mapActions({
      inc: "increment",
      setSrc: "qrcode/setSrc",
      setUser: "user/setUser",
      setUserStatus: "user/setStatus",
      setDialogs: "dialogs/setDialogs",
      setCred: "cred/setCred",
    }),
    toggleSide() {
      this.toggleSideBar = !this.toggleSideBar;
    },
    ...mapMutations({ minc: "increment", mincA: "a/increment" }),
    handleinc() {
      this.minc();
      this.mincA();
    },
    handleinc2() {
      this.inc();
      console.log("count : ", this.cn);
    },
  },
  watch: {
    toggleSideBar(toggleSideBar) {
      this.toggleSideBar = toggleSideBar;
    },
    selectedDialogs(selectedDialogs) {
      if (selectedDialogs) {
        this.select_contact = selectedDialogs;
      } else {
        // Echo.leave(`chat.${this.select_contact.id}`);
        this.select_contact = null;
      }
    },
    gStatus(gStatus) {
      if (!gStatus) {
        axios
          .get(this.userCred.instance + "status?token=" + this.userCred.token)
          .then((e) => {
            if (e.data.accountStatus == "authenticated") {
              // this.status = e.data.accountStatus;
              this.setUserStatus(e.data.accountStatus);
            } else {
              this.setSrc(e.data.qrCode);
            }
            this.isLoading = false;
          });
      }
    },
  },
};
</script>
<style lang="scss" scoped>
.card-body {
  height: 85vh;
}
</style>