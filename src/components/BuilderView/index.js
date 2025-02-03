const { Component, RawHTML, useState, useEffect } = wp.element;
import apiFetch from "@wordpress/api-fetch";
import { Popover, Spinner } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { Icon, close, cog, addCard, helpFilled, help, caution, seen } from "@wordpress/icons";

import { Fragment } from "react";
import PGinputSelect from "../input-select";
import PGinputText from "../input-text";
import PreviewTestimonialGrid from "./preview-team-grid";
import PreviewTestimonialCarousel from "./preview-team-carousel";
import PreviewTestimonialMasonry from "./preview-team-masonry";

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
	var [items, setitems] = useState(teamData.items);
	var [content, setcontent] = useState(teamData.content);
	var [accOptions, setaccOptions] = useState(teamData.accOptions);
	var [header, setheader] = useState(teamData.header);
	var [headerActive, setheaderActive] = useState(teamData.headerActive);
	var [headerLabel, setheaderLabel] = useState(teamData.headerLabel);
	var [labelCounter, setlabelCounter] = useState(teamData.labelCounter);
	var [labelIcon, setlabelIcon] = useState(teamData.labelIcon);
	var [icon, seticon] = useState(teamData.icon);
	var [iconToggle, seticonToggle] = useState(teamData.iconToggle);
	var [searchInput, setsearchInput] = useState(teamData.searchInput);
	var [expandCollapseAll, setexpandCollapseAll] = useState(teamData.expandCollapseAll);


	const [toggled, setToggled] = useState(false);
	const [labelIconHtml, setlabelIconHtml] = useState("");

	const [iconHtml, seticonHtml] = useState("");
	const [iconToggleHtml, seticonToggleHtml] = useState("");
	const [iconExpandAllHtml, seticonExpandAllHtml] = useState("");
	const [iconCollapseAllHtml, seticonCollapseAllHtml] = useState("");



	const copyData = (data) => {
		navigator.clipboard
			.writeText(data)
			.then(() => {
				addNotifications({
					title: "Copied to clipboard!",
					content:
						"Use the shortcode in page or post content where you want to display.",
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
		setitems(teamData.items);
		setcontent(teamData.content);
		setaccOptions(teamData.accOptions);
		setheader(teamData.header);
		setheaderActive(teamData.headerActive);
		setheaderLabel(teamData.headerLabel);
		setlabelCounter(teamData.labelCounter);
		setlabelIcon(teamData.labelIcon);
		seticon(teamData.icon);
		seticonToggle(teamData.iconToggle);
		setsearchInput(teamData.searchInput);
		setexpandCollapseAll(teamData.expandCollapseAll);

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
		var iconSrc = iconToggle?.options?.iconSrc;
		var iconHtml = `<span class="${iconSrc}"></span>`;
		seticonToggleHtml(iconHtml);
	}, [iconToggle?.options]);

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


	useEffect(() => {

		var expandAllIconSrc = expandCollapseAll?.options?.expandAllIcon?.iconSrc;
		var collapseAllIconSrc = expandCollapseAll?.options?.collapseAllIcon?.iconSrc;

		var expandIconHtml = `<span class="${expandAllIconSrc}"></span>`;
		seticonExpandAllHtml(expandIconHtml);

		var collapseIconHtml = `<span class="${collapseAllIconSrc}"></span>`;
		seticonCollapseAllHtml(collapseIconHtml);



	}, [expandCollapseAll?.options]);


	var [active, setactive] = useState(9999);

	return (
		<div className="ml-5">
			<div className="flex items-center justify-between align-middle bg-white p-5  mb-5">
				<div className="flex items-center gap-5">
					<div className="text-xl">
						{postData?.post_title && (
							<>You are editing: {postData.post_title}</>
						)}
					</div>

					{/* <a className="bg-slate-700  text-white hover:text-white px-5 py-1 rounded-sm cursor-pointer hover:bg-slate-600 flex items-center gap-2"> <Icon icon={seen} fill={"#fff"} /> Preview</a> */}
				</div>

				<div className="flex items-center align-middle gap-3">
					<div className="flex items-center align-middle gap-2">
						<span
							className="cursor-pointer"
							title="Click to know more"
							onClick={() => {
								setHelp({
									id: "useShortcodes",
									enable: true,
								});
							}}>
							<Icon icon={help} />
						</span>
						<input
							type="text"
							className="w-72 !bg-slate-200 !rounded-none !border-2 !border-solid border-slate-400 text-sm !py-1 !px-2 font-mono"
							value={`[team_builder id="${id}"]`}
							onClick={() => {
								var str = `[team_builder id="${id}"]`;

								copyData(str);
							}}
						/>
					</div>

					{pleaseUpdateX && (
						<div
							className="bg-slate-700 text-white px-5 py-2 rounded-sm cursor-pointer hover:bg-slate-600"
							onClick={(ev) => {
								onUpdate(true);
							}}>
							Save
						</div>
					)}
				</div>
			</div>





			{globalOptions?.viewType == "teamGrid" && (
				<PreviewTestimonialGrid
					isLoading={isLoading}
					postData={postData}
					id={id}
					onUpdate={onUpdate}
					pleaseUpdate={pleaseUpdate}
					onChange={onChange}
					addNotifications={addNotifications}
					setHelp={setHelp}
				/>
			)}
			{globalOptions?.viewType == "teamSlider" && (
				<PreviewTestimonialCarousel
					isLoading={isLoading}
					postData={postData}
					id={id}
					onUpdate={onUpdate}
					pleaseUpdate={pleaseUpdate}
					onChange={onChange}
					addNotifications={addNotifications}
					setHelp={setHelp}
				/>
			)}
			{globalOptions?.viewType == "teamMasonry" && (
				<PreviewTestimonialMasonry
					isLoading={isLoading}
					postData={postData}
					id={id}
					onUpdate={onUpdate}
					pleaseUpdate={pleaseUpdate}
					onChange={onChange}
					addNotifications={addNotifications}
					setHelp={setHelp}
				/>
			)}








		</div>
	);
}

class BuilderView extends Component {
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

export default BuilderView;
