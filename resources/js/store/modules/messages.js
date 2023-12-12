import Swal from "sweetalert2";
const messages = {
	namespaced: true,

	state: () => ({
		messages: null,
		id: new Date(),
		time: new Date(),
		type: "document",
		caption: null,
		body: null,
		from_me: true,
		filename: null,
		chatId: null,
	}),

	mutations: {
		setMessages(state, payload) {
			state.messages = payload;
		},
		sendMessage(state, payload) {
			const body = payload.body ? payload.body : null;
			const author = payload.author ? payload.author : null;
			const caption = payload.caption ? payload.caption : null;
			const senderName = payload.senderName ? payload.senderName : null;
			const messageNumber = payload.messageNumber
				? payload.messageNumber
				: null;
			axios
				.post("/db/message/", {
					id: payload.id,
					chatId: payload.chatId,
					body: body,
					from_me: payload.from_me,
					type: payload.type,
					author: author,
					caption: caption,
					sender_name: senderName,
					message_number: messageNumber,
					time: payload.time,
				})
				.then((e) => {
					// console.log(e.data);
				});
			state.messages.push(payload);
		},
	},

	actions: {
		async setMessages(state, id) {
			await axios.get("/chat/contact/" + id).then((e) => {
				const msg = e.data;
				state.commit("setMessages", msg);
			});
		},
		async getMessageByPage(state, page) {
			await axios.get("/chat/contact/" + page).then((e) => {
				const msg = e.data;
				state.commit("setMessages", msg);
			});
		},
		async sendMessage(state, payload) {
			await axios
				.post("/chat-api/message/text", {
					body: payload.body,
					chatId: payload.chatId,
					instance: payload.instance,
					token: payload.token,
				})
				.then((e) => {
					payload.id = e.data.id;
					Swal.fire({
						icon: "success",
						title: "Message sended!",
						toast: true,
						position: "top-end",
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						background: "#FFEDE1",
					});
				});
			state.commit("sendMessage", payload);
		},
		async sendFile(state, payload) {
			await axios
				.post("/chat-api/message/file", {
					url: payload.url,
					filename: payload.filename,
					chatId: payload.chatId,
					instance: payload.instance,
					token: payload.token,
				})
				.then((e) => {
					payload.id = e.data.id;
				});
			state.commit("sendMessage", payload);
		},
		appendMessage(state, payload) {
			payload.from_me = payload.fromMe;
			state.commit("sendMessage", payload);
		},
	},

	getters: {
		getMessage(state) {
			return state.messages;
		},
	},
};
export default messages;
