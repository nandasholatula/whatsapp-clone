const credentials = {
    namespaced: true,

    state: () => ({
        selectedCredential: null,
        credentials: null
    }),

    mutations: {
        setCredentials(state, payload) {
            state.credentials = payload;
        },
        addCredentials(state, payload) {
            state.credentials.push(payload);
        },
        updateCredential(state, payload) {
            const index = _.findIndex(state.credentials, function(o) {
                return o.id == payload.id;
            });
            state.credentials.splice(index, 1, payload);
        }
    },

    actions: {
        async setCredentials(state) {
            await axios.get("/creds/").then(e => {
                state.commit("setCredentials", e.data);
            });
        },
        updateCredential(state, payload) {
            state.commit("updateCredential", payload);
        },
        addCredentials(state, payload) {
            state.commit("addCredentials", payload);
        }
    },

    getters: {
        getCreds(state) {
            return state.credentials;
        }
    }
};
export default credentials;
