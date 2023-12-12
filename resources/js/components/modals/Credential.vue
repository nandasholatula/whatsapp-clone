<template>
  <div class="px-5 pt-4 pb-4 edit-cred">
    <h3 class="mb-5 text-center">Edit Credential</h3>

    <div class="mb-3 row form-group">
      <label for="name" class="col-md-3 col-form-label text-md-end">
        Name
      </label>
      <div class="col-md-8">
        <input
          id="name"
          type="text"
          class="form-control"
          v-model.trim="name"
          required
        />
        <div class="error" v-if="!$v.name.required">Field is required</div>
        <div class="error" v-if="!$v.name.minLength">
          Name must have at least {{ $v.name.$params.minLength.min }} letters.
        </div>
      </div>
    </div>

    <div class="mb-3 row">
      <label for="ChatId" class="col-md-3 col-form-label text-md-end"
        >ChatId</label
      >
      <div class="col-md-8">
        <input
          id="ChatId"
          type="text"
          class="form-control"
          v-model="chatId"
          disabled
        />
      </div>
    </div>

    <div class="mb-3 row">
      <label for="Phone" class="col-md-3 col-form-label text-md-end"
        >Phone</label
      >
      <div class="col-md-8">
        <input
          id="Phone"
          type="number"
          class="form-control"
          v-model="phone"
          @input="phoneChange"
          required
        />
        <div class="error" v-if="!$v.phone.required">Field is required</div>
        <div class="error" v-if="!$v.phone.minLength">
          Phone must have at least {{ $v.phone.$params.minLength.min }} letters.
        </div>
      </div>
    </div>

    <div class="mb-3 row">
      <label for="Instance" class="col-md-3 col-form-label text-md-end"
        >Instance</label
      >
      <div class="col-md-8">
        <input
          id="Instance"
          type="text"
          class="form-control"
          v-model.trim="instance"
          required
        />
        <div class="error" v-if="!$v.instance.required">Field is required</div>
      </div>
    </div>

    <div class="mb-3 row">
      <label for="Token" class="col-md-3 col-form-label text-md-end"
        >Token</label
      >
      <div class="col-md-8">
        <input
          id="Token"
          type="text"
          class="form-control"
          v-model.trim="token"
          required
        />
        <div class="error" v-if="!$v.token.required">Field is required</div>
      </div>
    </div>
    <div class="btn-container mt-5">
      <button
        type="button"
        class="btn btn-outline-primary"
        @click="updateOrCreateCredential"
      >
        Save
      </button>
    </div>
  </div>
</template>
<script>
import Swal from "sweetalert2";
import { required, minLength } from "vuelidate/lib/validators";
import { mapState, mapGetters, mapActions, mapMutations } from "vuex";
export default {
  props: {
    cred: { require: true },
  },
  data: () => ({
    name: "",
    phone: "",
    chatId: "",
    instance: "",
    token: "",
    act: "add",
  }),
  mounted() {
    if (this.cred) {
      this.name = this.cred.name;
      this.phone = this.cred.phone;
      this.chatId = this.cred.chatId;
      this.instance = this.cred.instance;
      this.token = this.cred.token;
      this.act = "edit";
    }
  },
  validations: {
    name: {
      required,
      minLength: minLength(4),
    },
    phone: {
      required,
      minLength: minLength(10),
    },
    instance: {
      required,
    },
    token: {
      required,
    },
  },
  methods: {
    ...mapActions({
      updateCreds: "credentials/updateCredential",
      addCreds: "credentials/addCredentials",
    }),
    phoneChange() {
      this.chatId = this.phone + "@u.cs";
    },
    updateOrCreateCredential() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        console.log("any error");
      } else if (this.act == "edit") {
        axios
          .put("/creds/" + this.cred.id, {
            name: this.name,
            phone: this.phone,
            chatId: this.chatId,
            instance: this.instance,
            token: this.token,
          })
          .then((e) => {
            this.updateCreds(e.data);
            this.swalToast("success", "Credential Updated");
            this.$modal.hideAll();
          })
          .catch((err) => {
            this.swalToast("warning", err);
            console.error(err);
          });
      } else if (this.act == "add") {
        axios
          .post("/creds", {
            name: this.name,
            phone: this.phone,
            chatId: this.chatId,
            instance: this.instance,
            token: this.token,
          })
          .then((e) => {
            this.addCreds(e.data);
            this.swalToast("success", "Credential Added");
            this.$modal.hideAll();
          })
          .catch((err) => {
            this.swalToast("warning", err);
            console.error(err);
          });
      }
    },
    swalToast(icon, title) {
      Swal.fire({
        icon: icon,
        title: title,
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
      });
    },
  },
  watch: {
    phone(phone) {
      this.phone = phone.replace(/^\s/g, "");
      this.phone = phone.replace(/^0/g, "62");
      this.chatId = this.chatId.replace(/^0/g, "62");
    },
  },
};
</script>
<style lang="scss" scoped>
.error {
  color: red;
}
.edit-cred {
  height: auto;
}
.btn-container {
  display: flex;
  justify-content: flex-end;
}
.edit-credential {
  background-color: transparent;
  display: flex;
  justify-content: center;
  box-shadow: 0 2px 20px 0 rgba(0, 0, 0, 0.4);
  border: 1px solid rgba(255, 255, 255, 0.65);
}
.edit-credential img {
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
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type="number"] {
  -moz-appearance: textfield;
}
</style>