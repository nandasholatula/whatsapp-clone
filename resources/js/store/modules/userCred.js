const userCred = {
    namespaced: true,

    state: () => ({
        name: null,
        user_id: null,
        credential_id: null,
        active: null,
        phone: null,
        chatId: null,
        instance: null,
        token: null
    }),

    mutations: {
        setCred(state, payload) {
            state.name = payload.credential.name;
            state.phone = payload.credential.phone;
            state.chatId = payload.credential.chatId;
            state.instance = payload.credential.instance;
            state.token = payload.credential.token;
            state.user_id = payload.user_id;
            state.credential_id = payload.credential_id;
            state.active = payload.active;
        }
    },

    actions: {
        async setCred(state) {
            await axios.get("/credential/getcred").then(e => {
                state.commit("setCred", e.data);
            });
        }
    },

    getters: {
        getCred(state) {
            return state;
        }
    }
};
export default userCred;
