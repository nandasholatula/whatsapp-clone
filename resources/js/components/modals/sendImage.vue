<template>
  <modal name="modal-image" height="auto" width="80%">
    <div class="p-5">
      <h1 class="mb-3">Send Images</h1>
      <UploadImages
        class="mb-3"
        @change="handleImages"
        :max="5"
        maxError="Max files exceed"
      />
      <button type="button" class="btn btn-outline-primary" @click="sendImages">
        Send
      </button>
    </div>
    <div
      slot="top-right"
      class="ct-top-right"
      @click="$modal.hide('modal-image')"
    >
      X
    </div>
  </modal>
</template>

<script>
import UploadImages from "vue-upload-drop-images";
import Swal from "sweetalert2";
import axios from "axios";
import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
export default {
  components: { UploadImages },
  computed: {
    ...mapGetters({
      selectedContact: "dialogs/getSelectedDialogs",
      cred: "cred/getCred",
      currentUser: "user/currentUser",
    }),
  },
  methods: {
    ...mapActions({
      sendFile: "messages/sendFile",
    }),
    handleImages(files) {
      let _imgsDetails = [];
      let _imgsFiles = [];
      files.forEach((element) => {
        _imgsFiles.push(element);
        _imgsDetails.push({
          name: element.name,
          size: element.size,
          type: element.type,
          lastModified: element.lastModified,
        });
      });
      this.imagesDetails = _imgsDetails;
      this.imagesFiles = _imgsFiles;
    },
    sendImages() {
      if (this.imagesFiles) {
        Swal.fire({
          title: "Sending Images!",
          html: "Please kindly to wait :)",
          didOpen: () => {
            Swal.showLoading();
          },
        });
        const length = this.imagesFiles.length;
        this.imagesFiles.forEach((el, id) => {
          const formData = new FormData();
          formData.append("file", el);
          axios
            .post("/chat/upload", formData, {
              headers: { "Content-Type": "multipart/form-data" },
            })
            .then((e) => {
              // console.log(e.data.name, e.data.type);
              const data = {};
              data.chatId = this.selectedContact.id;
              data.filename = e.data.name;
              data.url = e.data.url;
              data.id = new Date();
              data.time = new Date();
              data.type = "image";
              data.body = e.data.url;
              data.user = this.currentUser;
              data.from_me = true;
              data.instance = this.cred.instance;
              data.token = this.cred.token;
              this.sendFile(data).then(() => {
                if (id == length - 1) {
                  Swal.close();
                  this.$modal.hide("modal-image");
                  Swal.fire({
                    icon: "success",
                    title: "File sended!",
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: "#FFEDE1",
                  });
                }
              });
            });
        });
        this.imagesDetails = null;
        this.imagesFiles = null;
      } else {
        Swal.fire({
          icon: "error",
          title: "Upload file first!",
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          background: "#FFEDE1",
        });
      }
    },
  },
  data: () => ({
    imagesDetails: null,
    imagesFiles: null,
  }),
};
</script>
<style lang="scss" scoped>
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
</style>