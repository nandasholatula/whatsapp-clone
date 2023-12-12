const images = {
    namespaced: true,

    state: () => ({
        url: null
    }),

    mutations: {
        setUrl(state, payload) {
            state.url = payload;
        }
    },

    actions: {
        setUrl(state, payload) {
            state.commit("setUrl", payload);
        }
    },

    getters: {
        getUrl(state) {
            return state.url;
        }
    }
};
export default images;
