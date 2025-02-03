var teamFilterableDefaultData = {
	globalOptions: {
		viewType: "filterable",
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
	filterable: {
		options: {
			filters: [],
			allText: "All",
			logicWithinGroup: "",
			logicBetweenGroups: "",
			multifilter: false,
			showSort: "",
			filterToggle: "no",
			showRandom: "",
			showAll: "yes",
			showClear: "",
			activeFilter: "",
			perPage: 6,
		},
		styles: {
			color: {
				Desktop: "#000000",
			},
			padding: {
				Desktop: "8px 10px 8px 10px",
			},
			margin: {
				Desktop: "10px 10px 10px 10px",
			},
			display: {
				Desktop: "inline-block",
			},
			cursor: {
				Desktop: "pointer",
			},
			border: {
				Desktop: "1px solid #bebebe",
			},
			borderRadius: {
				Desktop: "5px 5px 5px 5px",
			},
			fontSize: {
				Desktop: "18px",
			},
			fontFamily: {
				Desktop: "Poppins",
			},
			fontWeight: {
				Desktop: "500",
			},
		},
	},
	activeFilter: {
		options: {
			slug: "all",
		},
		styles: {
			backgroundColor: {
				Desktop: "#7d7d7d",
			},
		},
	},
	filterGroupWrap: {
		options: {},
		styles: {},
	},
	filterGroup: {
		options: {},
		styles: {
			color: {
				Desktop: "#18978F",
			},
			margin: {
				Desktop: "0px 0px 10px 0px",
			},
			display: {
				Desktop: "inline-block",
			},
		},
	},
	container: {
		options: {
			class: "",
		},
		styles: {},
	},

	paginationWrap: {
		options: {
			tag: "type",
			tag: "ul",
			class: "",
		},
		styles: {},
	},
	paginationItem: {
		options: {
			tag: "span",
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
export default teamFilterableDefaultData;
