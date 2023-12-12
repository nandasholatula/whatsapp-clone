import axios from "axios";

const dialogs = {
    namespaced: true,

    state: () => ({
        dialog_list: null,
        dialog_list_limit: [],
        search_list: null,
        search: "",
        selectedDialog: null
    }),

    mutations: {
        setDialogs(state, payload) {
            state.dialog_list = payload;
        },
        setDialogsLimit(state, payload) {
            state.dialog_list_limit = payload;
        },
        setDialogsLimitPush(state, payload) {
            state.dialog_list_limit.push(payload);
        },
        searchDialog(state, payload) {
            state.search_list = payload;
        },
        setSearch(state, payload) {
            state.search = payload;
        },
        setSearchList(state, payload) {
            state.search_list = payload;
        },
        setSelectedDialog(state, payload) {
            if (payload == null) {
                state.selectedDialog = null;
            } else {
                state.selectedDialog = {};
                state.selectedDialog.id = payload.id;
                state.selectedDialog.name = payload.name;
                state.selectedDialog.image = payload.image;
                state.selectedDialog.isGroup = payload.is_group;
                state.selectedDialog.lastTime = payload.last_time;
            }
        }
    },

    actions: {
        async setDialogs(state, id) {
            await axios.get("/chat/contact/cred" + id).then(e => {
                const list = _.sortBy(e.data, [
                    function(o) {
                        return o.latest_message.time;
                    }
                ]).reverse();
                state.commit("setDialogs", list);
            });
        },
        async setDialogsLimit(state, payload) {
            await axios
                .get(
                    "/chat/contact/page/" +
                        payload.page +
                        "/cred/" +
                        payload.credential_id
                )
                .then(e => {
                    const list = _.sortBy(e.data, [
                        function(o) {
                            return o.latest_message.time;
                        }
                    ]);
                    state.commit("setDialogsLimit", list);
                });
        },
        setSelectedDialog(state, user) {
            state.commit("setSelectedDialog", user);
        },
        searchDialog(state, key) {
            if (key != "" && !/^\s+$/.test(key)) {
                axios.get("/chat/contact/search/" + key).then(e => {
                    state.commit("searchDialog", e.data);
                });
            } else {
                state.commit("searchDialog", null);
            }
        }
    },

    getters: {
        getDialogs(state) {
            return state.dialog_list;
        },
        getDialogsLimit(state) {
            return state.dialog_list_limit.reverse();
        },
        getSearchedDialogs(state) {
            return state.search_list;
        },
        getSelectedDialogs(state) {
            return state.selectedDialog;
        }
    }
};
export default dialogs;
