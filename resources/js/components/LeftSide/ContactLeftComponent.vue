<template>
  <div class="contact" v-if="!searched">
    <!-- <button @click="addDummy">add</button> -->
    <div v-for="(dial, index) in localDialogs" :key="index">
      <div
        class="d-flex contact-container py-2 px-3 mb-1"
        @click="selectUser(dial)"
      >
        <div class="contact-left w-25">
          <!-- {{ index }} -->
          <avatar :username="dial.name" :src="dial.image" :size="40"></avatar>
        </div>
        <div class="contact-right w-75">
          <div class="name">{{ dial.name }}</div>
          <div class="message" v-if="dial.latest_message.type == 'chat'">
            <span v-if="regex.test(dial.latest_message.body)">
              {{
                dial.latest_message.body.length > 25
                  ? dial.latest_message.body
                      .replaceAll(regex, regexTo)
                      .substr(0, 21) + "..."
                  : dial.latest_message.body.replaceAll(regex, regexTo)
              }}
            </span>
            <span v-else>
              {{
                dial.latest_message.body.length > 25
                  ? dial.latest_message.body.substr(0, 21) + "..."
                  : dial.latest_message.body
              }}
            </span>
          </div>
          <div class="message" v-else-if="dial.latest_message.type == 'image'">
            <i class="bi bi-file-earmark-image"></i>
            <span v-if="dial.latest_message.caption">
              {{
                dial.latest_message.caption.length > 25
                  ? dial.latest_message.caption.substr(0, 21) + "..."
                  : dial.latest_message.caption
              }}
            </span>
            <span v-else>photo</span>
          </div>
          <div
            class="message"
            v-else-if="dial.latest_message.type == 'document'"
          >
            <span class="flex items-center">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4 mr-1"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1"
                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                />
              </svg>
              <span>File</span>
            </span>
          </div>
          <div
            class="message"
            v-else-if="dial.latest_message.type == 'call_log'"
          >
            <span class="flex items-center">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4 mr-1"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z"
                />
              </svg>
              <span>Missed voice call</span>
            </span>
          </div>
          <div class="message" v-else>
            <span class="flex items-center">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4 mr-1"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"
                />
              </svg>
              <span>Audio</span>
            </span>
          </div>
        </div>
        <div class="time">
          <span
            class="small text-right"
            v-if="
              new Date(dial.latest_message.time).toDateString() ==
              new Date().toDateString()
            "
            >{{
              new Date(dial.latest_message.time).toTimeString().substr(0, 5)
            }}</span
          >
          <span
            class="small text-right"
            v-else-if="
              new Date(dial.latest_message.time).toDateString() ==
              tomorrowGen(new Date())
            "
            >yesterday</span
          >
          <span v-else>
            <timeago
              class="small text-right to-right"
              :datetime="dial.latest_message.time"
              :auto-update="60"
            ></timeago>
          </span>
        </div>
      </div>
    </div>
    <infinite-loading @infinite="infiniteHandler"></infinite-loading>
  </div>
  <div class="contact" v-else>
    <div v-for="(dial, index) in searched" :key="index">
      <div
        class="d-flex contact-container py-2 px-3 mb-1"
        @click="selectUser(dial)"
      >
        <div class="contact-left w-25">
          <avatar :username="dial.name" :src="dial.image" :size="40"></avatar>
        </div>
        <div class="contact-right w-75">
          <div class="name">{{ dial.name }}</div>
          <div class="message" v-if="dial.latest_message.type == 'chat'">
            <span v-if="regex.test(dial.latest_message.body)">
              {{
                dial.latest_message.body.length > 25
                  ? dial.latest_message.body
                      .replaceAll(regex, regexTo)
                      .substr(0, 21) + "..."
                  : dial.latest_message.body.replaceAll(regex, regexTo)
              }}
            </span>
            <span v-else>
              {{
                dial.latest_message.body.length > 25
                  ? dial.latest_message.body.substr(0, 21) + "..."
                  : dial.latest_message.body
              }}
            </span>
          </div>
          <div class="message" v-else-if="dial.latest_message.type == 'image'">
            <i class="bi bi-file-earmark-image"></i>
            <span v-if="dial.latest_message.caption">
              {{
                dial.latest_message.caption.length > 25
                  ? dial.latest_message.caption.substr(0, 21) + "..."
                  : dial.latest_message.caption
              }}
            </span>
            <span v-else>photo</span>
          </div>
          <div class="message" v-else>
            <span v-if="regex.test(dial.latest_message.body)">
              {{
                dial.latest_message.body.length > 25
                  ? dial.latest_message.body
                      .replaceAll(regex, regexTo)
                      .substr(0, 21) + "..."
                  : dial.latest_message.body.replaceAll(regex, regexTo)
              }}
            </span>
            <span v-else>
              {{
                dial.latest_message.body.length > 25
                  ? dial.latest_message.body.substr(0, 21) + "..."
                  : dial.latest_message.body
              }}
            </span>
          </div>
        </div>
        <div class="time">
          <span
            class="small text-right"
            v-if="
              new Date(dial.latest_message.time).toDateString() ==
              new Date().toDateString()
            "
            >{{
              new Date(dial.latest_message.time).toTimeString().substr(0, 5)
            }}</span
          >
          <span
            class="small text-right"
            v-else-if="
              new Date(dial.latest_message.time).toDateString() ==
              tomorrowGen(new Date())
            "
            >yesterday</span
          >
          <span v-else>
            <timeago
              class="small text-right to-right"
              :datetime="dial.latest_message.time"
              :auto-update="60"
            ></timeago>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Avatar from "vue-avatar";
import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
export default {
  components: {
    Avatar,
  },
  computed: {
    ...mapGetters({
      dialogs: "dialogs/getDialogs",
      searched: "dialogs/getSearchedDialogs",
      selected: "dialogs/getSelectedDialogs",
      dialogsLimit: "dialogs/getDialogsLimit",
      userCred: "cred/getCred",
    }),
  },
  mounted() {
    Echo.private("chat").listen("NewChat", (e) => {
      // console.log(e);
      const data = e.dialog;
      var index = _.findIndex(this.localDialogs, { id: data.id });
      if (index !== false) {
        _.remove(this.localDialogs, { id: data.id });
      }
      this.localDialogs.splice(0, 0, data);
    });
  },
  methods: {
    selectUser(user) {
      this.selectedUser(user);
      this.$emit("toggle");
    },
    addDummy() {
      var index = _.findIndex(this.localDialogs, { id: this.dummy.id });
      // console.log(index);
      if (index !== false) {
        _.remove(this.localDialogs, { id: this.dummy.id });
        // console.log("removed");
      }
      this.localDialogs.splice(0, 0, this.dummy);
    },
    tomorrowGen(date) {
      var currentDate = new Date(date);
      currentDate.setDate(currentDate.getDate() - 1);
      return currentDate.toDateString();
    },
    ...mapMutations({
      limitPush: "dialogs/setDialogsLimitPush",
    }),
    ...mapActions({
      selectedUser: "dialogs/setSelectedDialog",
      setLimit: "dialogs/setDialogsLimit",
    }),
    infiniteHandler($state) {
      this.setLimit({
        page: this.page,
        credential_id: this.userCred.credential_id,
      }).then(() => {
        this.localDialogs.push(...this.dialogsLimit);
        if (this.dialogsLimit.length) {
          this.page += 1;
          $state.loaded();
        } else {
          $state.complete();
        }
      });
    },
  },
  data() {
    return {
      tomorrow: null,
      regex: /\*(.*?)\*/g,
      regexTo: "",
      localDialogs: [],
      page: 0,
      dummy: {
        id: "6281221601998@c.us",
        name: "+62 812-2160-1998",
        image:
          "https://pps.whatsapp.net/v/t61.24694-24/56721798_2223368147728904_7273999364610064384_n.jpg?oh=8e464602d5ac4d2ba29edb15e5916497&oe=60796FF4",
        is_group: 0,
        last_time: "2021-04-13 15:52:34",
        created_at: "2021-04-13T08:53:19.000000Z",
        updated_at: "2021-04-13T09:59:19.000000Z",
        credential_id: 1,
        latest_message: {
          id: "false_6281221601998@c.us_3EB0A3F1B06D5C85C827",
          user_id: null,
          chatId: "6281221601998@c.us",
          body: "ok",
          from_me: 0,
          type: "chat",
          author: "6281221601998@c.us",
          caption: null,
          sender_name: "Andika Wijaya",
          time: "2021-04-13T08:52:34.000000Z",
          message_number: 17762,
          created_at: "2021-04-13T08:53:23.000000Z",
          updated_at: "2021-04-13T09:59:25.000000Z",
          credential_id: 1,
        },
      },
    };
  },
  watch: {},
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
.contact {
  max-height: 65vh;
  overflow-y: auto;
  .time {
    text-align: right !important;
  }
  .contact-container {
    align-items: center;
    cursor: pointer;
    &:hover {
      background-color: lightcyan;
    }
  }
  &-right {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    .name {
      font-weight: bold;
    }
    .message {
      font-weight: 500;
    }
  }
}
</style>