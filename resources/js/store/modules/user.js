import axios from "axios";

const user = {
	namespaced: true,

	state: () => ({
		email: "",
		name: "",
		role: "",
		status: null,
	}),

	mutations: {
		setStatus(state, payload) {
			state.status = payload;
		},
		setUser(state, payload) {
			state.email = payload.email;
			state.name = payload.name;
			state.role = payload.role[0];
		},
	},

	getters: {
		currentUser(state) {
			return state;
		},
		getStatus(state) {
			return state.status;
		},
	},

	actions: {
		async setUser(state) {
			await axios.get("/user/me").then((e) => {
				state.commit("setUser", e.data);
			});
		},
		setStatus(state, payload) {
			state.commit("setStatus", payload);
		},
	},
};
export default user;
