const { Component, RawHTML, useState, useEffect } = wp.element;
import apiFetch from "@wordpress/api-fetch";
import { Popover, Spinner } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { Icon, close, cog, addCard, helpFilled, help } from "@wordpress/icons";

import { Fragment } from "react";
import PGinputSelect from "../input-select";
import PGinputText from "../input-text";
import { Splide, SplideTrack } from "@splidejs/react-splide";

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
	var [loopLayout, setloopLayout] = useState(teamData.loopLayout);

	var [wrapper, setwrapper] = useState(teamData.wrapper);
	var [items, setitems] = useState(teamData.items);

	var [navsWrap, setnavsWrap] = useState(teamData?.navsWrap);
	var [navItem, setnavItem] = useState(teamData?.navItem);



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
		setloopLayout(teamData.loopLayout);
		setitems(teamData.items);
		setnavsWrap(teamData.navsWrap);
		setnavItem(teamData.navItem);

	}, [teamData]);





	useEffect(() => {
		setpleaseUpdateX(pleaseUpdate);
	}, [pleaseUpdate]);









	function unescapeHTML(str) {
		const map = {
			'&amp;': '&',
			'&lt;': '<',
			'&gt;': '>',
			'&quot;': '"',
			'&#039;': "'"
		};
		return str.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function (match) {
			return map[match];
		});
	}

	var loopLayout = teamData.loopLayout

	var itemWrap = teamData?.itemWrap;
	var sliderOptions = teamData?.sliderOptions;
	var prev = teamData?.prev;
	var next = teamData?.next;
	var prevIcon = teamData?.prevIcon;
	var nextIcon = teamData?.nextIcon;

	const [prevIconHtml, setPrevIconHtml] = useState("");
	const [nextIconHtml, setNextIconHtml] = useState("");

	useEffect(() => {
		var iconSrc = nextIcon?.options?.iconSrc;
		var iconHtml = `<span class="${iconSrc}"></span>`;
		setNextIconHtml(iconHtml);
	}, [nextIcon?.options]);
	useEffect(() => {
		var iconSrc = prevIcon?.options?.iconSrc;
		var iconHtml = `<span class="${iconSrc}"></span>`;
		setPrevIconHtml(iconHtml);
	}, [prevIcon?.options]);




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

			)
		}
		if (nodeType == "title") {
			return (
				<div id={`element-${node.id}`}>{itemData?.title}</div>
			)
		}
		if (nodeType == "date") {
			return (
				<div id={`element-${node.id}`}>{itemData.date}</div>
			)
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
			)
		}
		if (nodeType == "personName") {
			return (
				<div id={`element-${node.id}`}>{itemData?.personName}</div>
			)
		}
		if (nodeType == "personJobTitle") {
			return (
				<div id={`element-${node.id}`}>{itemData?.personJobTitle}</div>
			)
		}
		if (nodeType == "personAvatar") {
			return (
				<img id={`element-${node.id}`} src={itemData?.personAvatar?.srcUrl} />
			)
		}
		if (nodeType == "personCompanyName") {
			return (
				<div id={`element-${node.id}`}>{itemData?.companyName}</div>
			)
		}
		if (nodeType == "text") {
			return <div id={`element-${node.id}`}>{node.content}</div>;
		}
		if (nodeType == "personCompanyLogo") {
			return (
				<img
					id={`element-${node.id}`}
					src={itemData?.companyLogo.srcUrl}
					alt=""
				/>
			);
		}
		if (nodeType == "personCompanyWebsite") {
			return (
				<a id={`element-${node.id}`} href={itemData?.companyWebsite}>
					{itemData?.companyName}
				</a>
			);
		}




	}

	const TreeNode = ({ node, itemData }) => {

		var nodeType = node.type;



		if (nodeType == 'root' || nodeType == 'container') {
			return (

				<div id={`element-${node.id}`}>

					{node.children && (
						<>
							{node.children.map(child => (
								<TreeNode key={child?.id} node={child} itemData={itemData} />
							))}
						</>
					)}
				</div>

			)
		} else {
			return (
				<GenerateNodeHtml node={node} itemData={itemData} />
			)
		}


	};

	const Tree = ({ loopLayout, itemData }) => {
		return (
			<div>
				{loopLayout.map(node => (
					<TreeNode key={node.id} node={node} itemData={itemData} />
				))}
			</div>
		);
	};


	return (
		<div className="px-10 py-10">


			<div id={`team-${id}`} className={`${wrapper?.options?.class} `}>



				<div className={`my-5 ${wrapper?.options?.class} `}>
					<Splide hasTrack={false} options={sliderOptions}>
						<SplideTrack className={"items"}>

							{items?.map((item, loopIndex) => {
								return (
									<div key={loopIndex} className={`${itemWrap?.options?.class} splide__slide item`}>

										<Tree loopLayout={loopLayout} itemData={item} />

									</div>
								);
							})}



						</SplideTrack>
						<div className="splide__arrows">
							<div className="prev nav-item splide__arrow splide__arrow--prev">
								{prevIcon?.options.position == "before" && (
									<span
										className="icon"
										dangerouslySetInnerHTML={{ __html: prevIconHtml }}
									/>
								)}
								{prev?.options.text.length > 0 && (
									<span> {prev.options.text} </span>
								)}
								{prevIcon?.options.position == "after" && (
									<span
										className="icon"
										dangerouslySetInnerHTML={{ __html: prevIconHtml }}
									/>
								)}
							</div>
							<div className="next nav-item splide__arrow splide__arrow--next">
								{nextIcon?.options.position == "before" && (
									<span
										className="icon"
										dangerouslySetInnerHTML={{ __html: nextIconHtml }}
									/>
								)}
								{next?.options.text.length > 0 && (
									<span> {next.options.text} </span>
								)}
								{nextIcon?.options.position == "after" && (
									<span
										className="icon"
										dangerouslySetInnerHTML={{ __html: nextIconHtml }}
									/>
								)}
							</div>
						</div>
						<ul className="splide__pagination "></ul>
					</Splide>
				</div>
			</div>
		</div>
	);
}

class PreviewTestimonialCarousel extends Component {
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

export default PreviewTestimonialCarousel;
