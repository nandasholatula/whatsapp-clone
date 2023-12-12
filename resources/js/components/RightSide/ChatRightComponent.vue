<template>
  <div class="chat" ref="chat">
    <div v-if="localMessages">
      <div
        class="chat-container"
        v-for="(message, index) in localMessages"
        :key="index"
      >
        <div class="time sticky top-0 z-10">
          <span class="small text-center font-weight-bold">
            {{ dateCheck(index) }}
          </span>
        </div>
        <div
          class="chat-list z-0"
          v-for="(msg, ind) in message"
          :class="msg.from_me ? 'send' : ''"
          :key="ind"
        >
          <div class="flex justify-center" v-if="msg.type == 'call_log'">
            <div
              class="flex items-center min-w-min justify-center text-center justify-items-start bg-green_cus-200 rounded-lg py-1 px-3"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4 fill-current text-red-600"
                fill="red"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1"
                  d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z"
                />
              </svg>
              <div class="ml-2">
                Missed voice call at
                {{ new Date(msg.time).toTimeString().substr(0, 5) }}
              </div>
            </div>
          </div>
          <div
            v-else
            class="chat-bubble relative mx-1 max-w-18 md:max-w-2xl"
            :class="msg.user ? 'my-2' : 'my-1'"
          >
            <span
              class="absolute -bottom-3 -left-5 rounded-lg p-1 bg-green_cus-400 text-white"
              v-if="msg.user && msg.from_me"
              >{{ msg.user.name }}</span
            >
            <div class="type-image" v-if="msg.type == 'image'">
              <div class="w-full image-preview max-h-96 mb-3 overflow-hidden">
                <img
                  class="rounded object-fill"
                  :src="msg.body"
                  :alt="msg.type"
                  @click="showImage(msg.body)"
                />
              </div>
              <div
                class="chat-message"
                v-if="regex.test(msg.caption)"
                v-html="msg.caption.replaceAll(regex, regexTo)"
              ></div>
              <div v-else class="chat-message">{{ msg.caption }}</div>
              <div class="chat-time">
                {{ new Date(msg.time).toTimeString().substr(0, 5) }}
              </div>
            </div>
            <div class="type-chat" v-else-if="msg.type == 'chat'">
              <div
                class="chat-message"
                v-if="regex.test(msg.body)"
                v-html="msg.body.replaceAll(regex, regexTo)"
              ></div>
              <div
                v-else
                class="chat-message break-all whitespace-pre-wrap"
                v-html="msg.body"
              ></div>
              <div class="chat-time">
                {{ new Date(msg.time).toTimeString().substr(0, 5) }}
              </div>
            </div>
            <div class="type-document" v-else-if="msg.type == 'document'">
              <a
                :href="msg.body"
                type="button"
                target="_blank"
                class="text-base"
              >
                <div
                  class="flex bg-opacity-25 items-center p-2 bg-black rounded-lg cursor-pointer"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-8 mr-2"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                    />
                  </svg>
                  {{ msg.caption }}
                </div>
              </a>
              <div class="chat-time">
                {{ new Date(msg.time).toTimeString().substr(0, 5) }}
              </div>
            </div>
            <div class="type-document" v-else-if="msg.type == 'ptt'">
              <audio controls>
                <source :src="msg.body" type="audio/ogg" />
                Your browser does not support the audio element.
              </audio>
              <div class="chat-time">
                {{ new Date(msg.time).toTimeString().substr(0, 5) }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
import Swal from "sweetalert2";
export default {
  beforeMount() {
    this.getMessages(this.selected.id).then(() => this.scrollToBottom());
  },
  data() {
    return {
      regex: /\*(.*?)\*/g,
      regexTo: "<b>$1</b>",
      localMessages: null,
      nowId: null,
    };
  },
  computed: {
    reverseItems() {
      return (msg) => msg;
    },
    ...mapState({
      a: "messages/messages",
    }),
    ...mapGetters({
      selected: "dialogs/getSelectedDialogs",
      messages: "messages/getMessage",
    }),
  },
  methods: {
    ...mapActions({
      getMessages: "messages/setMessages",
      appendMessage: "messages/appendMessage",
      setUrl: "image/setUrl",
    }),
    showImage(url) {
      this.setUrl(url);
      // this.$modal.show("image-preview");
      Swal.fire({
        imageUrl: url,
        imageAlt: "Preview picture",
      });
    },
    dateCheck(date) {
      // console.log(new Date(date).toDateString(), new Date().toDateString());
      if (new Date(date).toDateString() == new Date().toDateString()) {
        return "today";
      } else if (
        new Date(date).toDateString() == this.tomorrowGen(new Date())
      ) {
        return "yesterday";
      } else {
        return new Date(date).toDateString().substr(0, 10);
      }
    },
    tomorrowGen(date) {
      var currentDate = new Date(date);
      currentDate.setDate(currentDate.getDate() - 1);
      return currentDate.toDateString();
    },
    scrollToBottom() {
      this.$nextTick(function () {
        const chat = this.$refs.chat;
        chat.scrollTop = chat.scrollHeight;
      });
    },
  },
  watch: {
    selected(selected) {
      this.getMessages(selected.id).then(() => this.scrollToBottom());
      if (this.nowId) {
        // console.log("msg." + this.nowId);
        Echo.leaveChannel("message." + this.nowId);
      }
      this.nowId = selected.id;
      // console.log("msg." + this.nowId);
    },
    messages(messages) {
      this.localMessages = _.groupBy(messages, (message) =>
        new Date(message.time).toDateString()
      );
      this.scrollToBottom();
      // console.log("scroll");
    },
  },
  mounted() {
    Echo.private("message." + this.selected.id).listen("NewMessage", (e) => {
      // console.log(e.message.time, typeof e.message.time);
      if (!e.message.fromMe && this.selected.id == e.message.chatId) {
        // console.log(this.selected, e.message);
        e.message.time = new Date(e.message.time * 1000);
        this.appendMessage(e.message);
      }
    });
  },
};
</script>
<style lang="scss" scoped>
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
.chat {
  height: 63vh;
  overflow-y: auto;
  padding-top: 10px;
  .chat-list {
    &.send {
      text-align: end;
      .chat-bubble {
        background-color: lightcoral;
        text-align: left;
      }
    }
  }
  .time {
    text-align: center;
    margin: 20px 0;
    span {
      padding: 8px;
      background-color: lightskyblue;
      border-radius: 10px;
    }
  }
  .chat-time {
    text-align: right;
    font-size: 0.6rem;
    margin-bottom: 0;
  }
  .chat-bubble {
    background-color: burlywood;
    border-radius: 8px;
    // max-width: 500px;
    min-width: 100px;
    display: inline-block;
    // margin: 2px 10px;
    padding: 5px;
    .chat-message {
      white-space: pre-line;
      padding: 0 5px;
      margin-bottom: 0;
    }
    .type-image {
      .image-preview {
        // width: 390px;
        // height: 390px;
        cursor: pointer;
      }
    }
  }
}
</style>