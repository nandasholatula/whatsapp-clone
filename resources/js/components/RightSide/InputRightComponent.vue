<template>
  <div class="input-right d-flex">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="32"
      height="32"
      fill="currentColor"
      class="bi bi-paperclip icon-input"
      viewBox="0 0 16 16"
      @click="showUploadFile"
    >
      <path
        d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"
      />
    </svg>
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="32"
      height="32"
      fill="currentColor"
      class="bi bi-images icon-input"
      viewBox="0 0 16 16"
      @click="showUploadImage"
    >
      <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
      <path
        d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z"
      />
    </svg>
    <textarea
      id="area"
      class="border border-transparent focus:outline-none focus:ring-2 focus:ring-green_cus-300 focus:border-transparent"
      placeholder="Type something ..."
      v-model="text"
      @keydown.enter.exact.prevent="sendMessage"
    ></textarea>
    <twemoji-picker
      :emojiData="emojiDataAll"
      :emojiGroups="emojiGroups"
      :skinsSelection="false"
      isLoadingLabel="Loading..."
      @emojiUnicodeAdded="emojiUnicodeAdded"
    ></twemoji-picker>
  </div>
</template>
<script>
import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
import { TwemojiTextarea } from "@kevinfaguiar/vue-twemoji-picker";
import { TwemojiPicker } from "@kevinfaguiar/vue-twemoji-picker";
import EmojiAllData from "@kevinfaguiar/vue-twemoji-picker/emoji-data/en/emoji-all-groups.json";
import EmojiDataAnimalsNature from "@kevinfaguiar/vue-twemoji-picker/emoji-data/en/emoji-group-animals-nature.json";
import EmojiDataFoodDrink from "@kevinfaguiar/vue-twemoji-picker/emoji-data/en/emoji-group-food-drink.json";
import EmojiGroups from "@kevinfaguiar/vue-twemoji-picker/emoji-data/emoji-groups.json";
import Swal from "sweetalert2";
export default {
  components: {
    "twemoji-picker": TwemojiPicker,
    "twemoji-textarea": TwemojiTextarea,
  },
  methods: {
    ...mapActions({
      sendText: "messages/sendMessage",
      get: "messages/setMessages",
      sendFile: "messages/sendFile",
    }),
    emojiUnicodeAdded(a) {
      this.text += a;
    },
    async showUploadImage() {
      this.$modal.show("modal-image");
      // const { value: file } = await Swal.fire({
      //   title: "Select image",
      //   input: "file",
      //   showConfirmButton: false,
      //   showCloseButton: true,
      //   inputAttributes: {
      //     accept: "image/*",
      //     "aria-label": "Upload your profile picture",
      //   },
      // });

      // if (file) {
      //   const reader = new FileReader();
      //   reader.onload = (e) => {
      //     Swal.fire({
      //       title: "Your uploaded picture",
      //       imageUrl: e.target.result,
      //       imageAlt: "The uploaded picture",
      //     });
      //   };
      //   reader.readAsDataURL(file);
      // }
    },
    async showUploadFile() {
      const { value: file } = await Swal.fire({
        title: "Select file",
        input: "file",
        showCloseButton: true,
        inputAttributes: {
          accept:
            ".doc, .docx, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/*, text/*",
          "aria-label": "Upload your profile picture",
        },
      });

      if (file) {
        const formData = new FormData();
        formData.append("file", file);
        axios
          .post("/chat/upload", formData, {
            headers: { "Content-Type": "multipart/form-data" },
          })
          .then((e) => {
            // console.log(e.data.name, e.data.type);
            const data = {};
            data.chatId = this.cUser.id;
            data.filename = e.data.name;
            data.caption = e.data.name;
            data.url = e.data.url;
            data.id = new Date();
            data.time = new Date();
            data.type = "document";
            data.body = e.data.url;
            data.user = this.currentUser;
            data.from_me = true;
            data.instance = this.cred.instance;
            data.token = this.cred.token;
            this.sendFile(data).then(() => {
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
            });
          });
      }
    },
    sendMessage(e) {
      if (!/^\s+$/.test(this.text) && this.text != "") {
        const data = {};
        data.chatId = this.cUser.id;
        data.id = new Date();
        data.time = new Date();
        data.type = "chat";
        data.body = this.text;
        data.user = this.currentUser;
        data.from_me = true;
        data.instance = this.cred.instance;
        data.token = this.cred.token;
        this.sendText(data);
        // this.get(this.cUser.id);
        this.text = "";
      }
    },
  },
  computed: {
    ...mapGetters({
      cUser: "dialogs/getSelectedDialogs",
      cred: "cred/getCred",
      currentUser: "user/currentUser",
    }),
    emojiDataAll() {
      return EmojiAllData;
    },
    emojiGroups() {
      return EmojiGroups;
    },
  },
  data() {
    return {
      text: "",
    };
  },
};
</script>
<style lang="scss" scoped>
.icon-input {
  color: rgb(0, 0, 0);
  font-size: 1rem;
  margin: 10px;
  &:hover {
    cursor: pointer;
  }
}
::-webkit-scrollbar {
  width: 8px;
}
::-webkit-scrollbar-track {
  background: #f1f1f1;
}
::-webkit-scrollbar-thumb {
  background: #888;
}
::-webkit-scrollbar-thumb:hover {
  background: #555;
}
.input-right {
  height: 12vh;
  align-items: center;
  textarea {
    width: -webkit-fill-available;
    margin: 10px;
    margin-right: 0;
    resize: none;
    border-radius: 6px;
    border: 1px solid lightgray;
    padding: 10px;
    overflow-y: auto;
  }
}
</style>