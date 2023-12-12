import Vue from "vue";
import Vuex from "vuex";
import moduleA from "./modules/moduleA";
import user from "./modules/user";
import dialogs from "./modules/dialogs";
import messages from "./modules/messages";
import images from "./modules/modal/image";
import userCred from "./modules/userCred";
import qrcode from "./modules/qrcode";
import credentials from "./modules/credentials";
Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        a: moduleA,
        user: user,
        dialogs: dialogs,
        messages: messages,
        image: images,
        cred: userCred,
        qrcode: qrcode,
        credentials: credentials
    },
    state: {
        count: 0,
        todos: [
            { id: 1, text: "...", done: true },
            { id: 2, text: "...", done: false },
            { id: 3, text: "...", done: true },
            { id: 4, text: "...", done: false },
            { id: 5, text: "...", done: true },
            { id: 6, text: "...", done: false },
            { id: 7, text: "...", done: true },
            { id: 8, text: "...", done: false }
        ]
    },
    mutations: {
        increment(state) {
            state.count++;
        }
    },
    getters: {
        doneTodos: state => {
            return state.todos.filter(todo => todo.done);
        },
        doneTodosCount: (state, getters) => {
            return getters.doneTodos.length;
        },
        getTodoById: state => id => {
            return state.todos.find(todo => todo.id === id);
        }
    },
    actions: {
        increment({ commit }) {
            commit("increment");
        },
        incrementAsync({ commit }) {
            setTimeout(() => {
                commit("increment");
            }, 1000);
        }
    }
});

export default store;
