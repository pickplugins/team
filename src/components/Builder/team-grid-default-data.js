var teamGridDefaultData = {
	globalOptions: {
		viewType: "teamGrid",
		itemSource: "manual",
		search: true,
	},
	itemQueryArgs: [],
	styleObj: {},
	reponsiveCss: "",

	items: [
		{
			isActive: false,
			person: {
				name: "",
				avatar: { id: "", srcUrl: "" },
				jobTitle: "",
				company: { name: "", website: "", logoUrl: { id: "", srcUrl: "" } },
			},
			rating: 5,
			date: "11/01/2025",
			videoUrl: { type: "", link: "" },
			title: "What is Lorem Ipsum?",
			content:
				"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
			tags: [],
		},
	],

	loopLayout: [],
	wrapper: {
		options: {
			content: "",
			tag: "div",
			class: "team-wrapper",
		},
		styles: {},
	},
	itemsWrap: {
		options: {
			class: "team-items",
		},
		styles: {},
	},
	itemWrap: {
		options: {
			class: "team-item",
		},
		styles: {},
	},

	paginationWrap: {
		options: {
			type: "",
			class: "",
		},
		styles: {},
	},
	paginationItem: {
		options: {
			class: "",
		},
		styles: {},
	},
	paginationItemActive: {
		options: {
			class: "",
		},
		styles: {},
	},
};
export default teamGridDefaultData;
