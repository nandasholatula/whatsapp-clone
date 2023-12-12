const qrcode = {
    namespaced: true,

    state: () => ({
        src: null,
    }),

    mutations: {
        setSrc(state, payload) {
            state.src = payload;
        }
    },

    actions: {
        setSrc(state, payload) {
            state.commit("setSrc", payload);
        }
    },

    getters: {
        getSrc(state) {
            return state.src;
        }
    }
};
export default qrcode;
