const { Component, RawHTML, useState, useEffect } = wp.element;

var myStore = wp.data.select("postgrid-shop");

function Html(props) {
	if (!props.warn) {
		return null;
	}

	var id = props.id;
	var onChange = props.onChange;
	var addNotifications = props.addNotifications;
	var setHelp = props.setHelp;

	var isLoading = props.isLoading;
	var onUpdate = props.onUpdate;
	var pleaseUpdate = props.pleaseUpdate;

	if (props.postData.post_content == null) {
		return null;
	}

	var [pleaseUpdateX, setpleaseUpdateX] = useState(props.pleaseUpdate);
	var [postData, setpostData] = useState(props.postData);
	var [teamData, setteamData] = useState(postData.post_content);

	var [globalOptions, setglobalOptions] = useState(teamData.globalOptions);

	var [wrapper, setwrapper] = useState(teamData.wrapper);
	var [itemsWrap, setitemsWrap] = useState(teamData.itemsWrap);
	var [itemWrap, setitemWrap] = useState(teamData.itemWrap);
	var [items, setitems] = useState(teamData.items);
	var [loopLayout, setloopLayout] = useState(teamData.loopLayout);
	var [accOptions, setaccOptions] = useState(teamData.accOptions);
	var [header, setheader] = useState(teamData.header);
	var [headerLabel, setheaderLabel] = useState(teamData.headerLabel);
	var [labelCounter, setlabelCounter] = useState(teamData.labelCounter);
	var [labelIcon, setlabelIcon] = useState(teamData.labelIcon);
	var [icon, seticon] = useState(teamData.icon);
	var [searchInput, setsearchInput] = useState(teamData.searchInput);

	const [toggled, setToggled] = useState(false);
	const [labelIconHtml, setlabelIconHtml] = useState("");

	const [iconHtml, seticonHtml] = useState("");
	const [iconExpandAllHtml, seticonExpandAllHtml] = useState("");
	const [iconCollapseAllHtml, seticonCollapseAllHtml] = useState("");

	const copyData = (data) => {
		navigator.clipboard
			.writeText(data)
			.then(() => {
				addNotifications({
					title: "Copied to clipboard!",
					content:
						"Use the shortcode in page or post conent where you want to display.",
					type: "success",
				});
			})
			.catch((err) => { });
	};

	useEffect(() => {
		setpostData(props.postData);
	}, [props.postData]);

	useEffect(() => {
		setteamData(postData.post_content);
		//setitems(postData.post_content.items);
	}, [postData]);

	useEffect(() => {
		setglobalOptions(teamData.globalOptions);

		setwrapper(teamData.wrapper);
		setitemsWrap(teamData.itemsWrap);
		setitemWrap(teamData.itemWrap);
		setitems(teamData.items);
		setloopLayout(teamData.loopLayout);
		setaccOptions(teamData.accOptions);
		setheader(teamData.header);
		setheaderLabel(teamData.headerLabel);
		setlabelCounter(teamData.labelCounter);
		setlabelIcon(teamData.labelIcon);
		seticon(teamData.icon);
		setsearchInput(teamData.searchInput);
	}, [teamData]);

	useEffect(() => {
		//var teamDataX = { ...teamData };
		//teamDataX.items = items;
		//onChange(teamDataX);
	}, [items]);

	useEffect(() => {
		setpleaseUpdateX(pleaseUpdate);
	}, [pleaseUpdate]);

	useEffect(() => {
		var iconSrc = icon?.options?.iconSrc;
		var iconHtml = `<span class="${iconSrc}"></span>`;
		seticonHtml(iconHtml);
	}, [icon?.options]);

	useEffect(() => {
		var iconSrc = labelIcon?.options?.iconSrc;
		var iconHtml = `<span class="${iconSrc}"></span>`;
		setlabelIconHtml(iconHtml);
	}, [labelIcon?.options]);

	function unescapeHTML(str) {
		const map = {
			"&amp;": "&",
			"&lt;": "<",
			"&gt;": ">",
			"&quot;": '"',
			"&#039;": "'",
		};
		return str.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function (match) {
			return map[match];
		});
	}

	const GenerateNodeHtml = ({ node, itemData }) => {
		var nodeType = node.type;
		var person = itemData?.person;
		var title = itemData?.title;
		var content = itemData?.content;
		var videoUrl = itemData?.videoUrl;
		var date = itemData?.date;
		var rating = itemData?.rating;

		if (nodeType == "content") {
			return (
				<div
					id={`element-${node.id}`}
					dangerouslySetInnerHTML={{
						__html: unescapeHTML(content),
					}}></div>
			);
		}
		if (nodeType == "title") {
			return <div id={`element-${node.id}`}>{itemData?.title}</div>;
		}
		if (nodeType == "date") {
			return <div id={`element-${node.id}`}>{date}</div>;
		}
		if (nodeType == "rating") {
			return (
				<div id={`element-${node.id}`}>
					<span className=" inline-block fas fa-star"></span>
					<span className=" inline-block fas fa-star"></span>
					<span className=" inline-block fas fa-star"></span>
					<span className=" inline-block fas fa-star"></span>
					<span className=" inline-block fas fa-star"></span>
				</div>
			);
		}
		if (nodeType == "personName") {
			return <div id={`element-${node.id}`}>{person?.name}</div>;
		}
		if (nodeType == "personJobTitle") {
			return <div id={`element-${node.id}`}>{person?.jobTitle}</div>;
		}
		if (nodeType == "personAvatar") {
			return (
				<img
					id={`element-${node.id}`}
					src="https://comboblocks.com/server/wp-content/uploads/2024/09/team-member-6.jpg"
				/>
			);
		}
		if (nodeType == "personCompanyName") {
			return <div id={`element-${node.id}`}>{person?.company?.name}</div>;
		}
		if (nodeType == "text") {
			return <div id={`element-${node.id}`}>{node.content}</div>;
		}
		if (nodeType == "personCompanyLogo") {
			return (
				<img
					id={`element-${node.id}`}
					src="https://cdn4.iconfinder.com/data/icons/logos-and-brands/512/30_Atlassian_logo_logos-256.png"
					alt=""
				/>
			);
		}
		if (nodeType == "personCompanyWebsite") {
			return (
				<a id={`element-${node.id}`} href={person?.company?.website}>
					{person?.company?.websiteLabel}
				</a>
			);
		}
	};

	const TreeNode = ({ node, itemData }) => {
		var nodeType = node.type;

		if (nodeType == "root" || nodeType == "container") {
			return (
				<div id={`element-${node.id}`}>
					{node.children && (
						<>
							{node.children.map((child) => (
								<TreeNode key={child?.id} node={child} itemData={itemData} />
							))}
						</>
					)}
				</div>
			);
		} else {
			return <GenerateNodeHtml node={node} itemData={itemData} />;
		}
	};

	const Tree = ({ loopLayout, itemData }) => {
		return (
			<div>
				{loopLayout.map((node) => (
					<TreeNode key={node.id} node={node} itemData={itemData} />
				))}
			</div>
		);
	};

	return (
		<div className="px-10 py-10">
			<div id={`team-${id}`} className={`${wrapper?.options?.class} `}>
				<div className={`items ${itemsWrap?.options?.class} `}>
					{items?.map((item, loopIndex) => {
						return (
							<div
								key={loopIndex}
								className={`${itemWrap?.options?.class} item`}>
								<Tree loopLayout={loopLayout} itemData={item} />
							</div>
						);
					})}
				</div>

				{teamData.globalOptions.itemSource == "posts" && (
					<div class="pagination ">
						<a class="prev item" href="#1">
							<span class="previous "></span>Previous
						</a>
						<a class="item" href="#1">
							1
						</a>
						<span aria-current="page" class="item current">
							2
						</span>
						<a class="item" href="#3">
							3
						</a>
						<a class="item" href="#4">
							4
						</a>
						<span class="item dots">…</span>
						<a class="item" href="#6">
							6
						</a>
						<a class="next item" href="#3">
							<span class="next "></span>Next
						</a>
					</div>
				)}
			</div>
		</div>
	);
}

class PreviewTestimonialGrid extends Component {
	constructor(props) {
		super(props);
		this.state = { showWarning: true };
		this.handleToggleClick = this.handleToggleClick.bind(this);
	}

	handleToggleClick() {
		this.setState((state) => ({
			showWarning: !state.showWarning,
		}));
	}

	render() {
		var {
			postData,
			id,
			isLoading,
			onChange,
			pleaseUpdate,
			onUpdate,
			addNotifications,
			setHelp,
		} = this.props;

		return (
			<Html
				isLoading={isLoading}
				postData={postData}
				id={id}
				onUpdate={onUpdate}
				pleaseUpdate={pleaseUpdate}
				onChange={onChange}
				addNotifications={addNotifications}
				setHelp={setHelp}
				warn={this.state.showWarning}
			/>
		);
	}
}

export default PreviewTestimonialGrid;
