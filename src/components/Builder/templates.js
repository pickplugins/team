
const { Component, RawHTML, useState, useEffect } = wp.element;
import { RichText } from '@wordpress/block-editor'
import { __ } from "@wordpress/i18n";

import {
	Icon, settings, cloud, plus, post, close,
	help as helpIcon,
} from "@wordpress/icons";
import { ReactSortable } from "react-sortablejs";
import {
	PanelBody,
	RangeControl,
	Button,
	ButtonGroup,
	Panel,
	PanelRow,
	Dropdown,
	DropdownMenu,
	SelectControl,
	ColorPicker,
	ColorPalette,
	ToolsPanelItem,
	ComboboxControl,
	Spinner,
	ToggleControl,
	CustomSelectControl,
	Popover,
	__experimentalInputControl as InputControl,
} from "@wordpress/components";
import apiFetch from "@wordpress/api-fetch";
import { Splide, SplideTrack } from "@splidejs/react-splide";
import PGinputText from "../input-text";

import PGDropdown from '../../components/dropdown'


var myStore = wp.data.select("postgrid-shop");

function Html(props) {

	if (!props.warn) {
		return null;
	}

	var addNotifications = props.addNotifications;


	if (!props?.postData?.post_content?.globalOptions?.viewType) {
		addNotifications({
			title: "Opps item missing",
			content: "Please select post first.",
			type: "error",
		});
		return null;
	}



	var onChange = props.onChange;
	var setHelp = props.setHelp;

	var [postData, setpostData] = useState(props.postData); // Using the hook.
	var [teamData, setteamData] = useState(postData.post_content); // Using the hook.
	var [isLoading, setisLoading] = useState(false); // Using the hook.
	var [isProFeature, setisProFeature] = useState(true);
	var [customerData, setcustomerData] = useState(props.customerData);


	var [templates, settemplates] = useState([]); // Using the hook.
	const [queryLayouts, setqueryLayouts] = useState({
		keyword: "",
		price: "",
		viewType: postData.post_content.globalOptions.viewType == undefined ? "teamGrid" : postData.post_content.globalOptions.viewType,
		page: 1,
	});



	useEffect(() => {
		if (customerData.isPro) {
			setisProFeature(false);
		}
	}, [props.customerData]);

	useEffect(() => {
		setisLoading(true);
		var requestData = {
			keyword: queryLayouts.keyword,
			page: queryLayouts.page,
			price: queryLayouts.price,
			viewType: queryLayouts.viewType,
		};
		requestData = JSON.stringify(requestData);
		fetch(
			"https://pickplugins.com/demo/team/wp-json/team/v2/get_posts_team",
			// "http://localhost/wordpress/wp-json/team/v2/get_posts_team",
			{
				method: "POST",
				headers: {
					"Content-Type": "application/json;charset=utf-8",
				},
				body: requestData,
			}
		)
			.then((response) => {
				if (response.ok && response.status < 400) {
					response.json().then((data) => {

						var posts = data.posts;

						var postsX = [];


						posts.map(item => {

							postsX.push({

								label: item.post_title,
								thumb: item.thumb,
								isPro: item?.is_pro == "yes" ? true : false,
								data: item.post_content
							})

							settemplates(postsX);

						})
						setisLoading(false);


					});
				}
			})
			.catch((_error) => {
				//this.saveAsStatus = 'error';
				// handle the error
			});


	}, []);





	return (
		<div className="">
			<div className="p-3">
				<p className="flex items-center gap-2">
					How templates work.
					<span
						className="cursor-pointer"
						title="Click to know more"
						onClick={() => {
							setHelp({
								id: "teamTemplatesHelp",
								enable: true,
							});
						}}>
						<Icon icon={helpIcon} />
					</span>
				</p>

				<div className="my-4  items-center hidden gap-3">
					<PGinputText
						value={queryLayouts.keyword}
						placeholder={"Search..."}
						className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
						onChange={(newVal) => {
							var queryLayoutsX = { ...queryLayouts };
							queryLayoutsX.keyword = newVal;
							setqueryLayouts(queryLayoutsX);

						}}
					/>
					<SelectControl
						label=""
						value={queryLayouts.price}
						options={[
							{
								label: __("Free/Pro", "team"),
								value: "",
							},
							{ label: __("Free", "team"), value: "free" },
							{ label: __("Pro", "team"), value: "pro" },

						]}
						onChange={(newVal) => {
							var queryLayoutsX = { ...queryLayouts };
							queryLayoutsX.keyword = newVal;
							setqueryLayouts(queryLayoutsX);
						}}
					/>


				</div>

				{isLoading && (
					<div className='text-center py-3'><Spinner /></div>
				)}







				<>
					{templates.map((preset, index) => {
						return (
							<div
								className="my-5 bg-slate-400 hover:bg-slate-500 p-3 rounded-sm cursor-pointer"
								title="Click To Apply"
								key={index}
								onClick={(ev) => {

									if (preset.isPro) {

										if (isProFeature) {
											addNotifications({
												title: "Opps its pro!",
												content: "This feature only avilable in premium version",
												type: "error",
											});
											return;

										}

									}

									addNotifications({
										title: "Preset Applied",
										content: "WOW, Your team just got new look!",
										type: "success",
									});


									var data = preset.data;
									data = JSON.parse(data);


									var presetClean = {};

									Object.entries(data).map((item) => {
										var itemIndex = item[0];
										var itemArg = item[1];


										if (itemArg.options != undefined) {
											delete itemArg.options;
										}
										if (teamData[itemIndex]) {
											delete teamData[itemIndex]?.styles;
											delete teamData[itemIndex]?.hover;
											delete teamData[itemIndex]?.after;
											delete teamData[itemIndex]?.before;
											delete teamData[itemIndex]?.active;
											delete teamData[itemIndex]?.focus;
											delete teamData[itemIndex]?.target;
											delete teamData[itemIndex]?.visited;
										}

										if (itemIndex == 'loopLayout') {

											presetClean[itemIndex] = itemArg;
										} else {

											presetClean[itemIndex] = {
												...teamData[itemIndex],
												...itemArg,
											};
										}




									});


									var teamDataX = {

										...teamData,
										...presetClean,

									};



									onChange(teamDataX);

									addNotifications({
										title: "Preset Applied",
										content: "WOW, Your team just got new look!",
										type: "success",
									});
								}}>
								<img className="w-full" src={preset.thumb} alt="" />
								<div className="mt-3 flex justify-between  items-center">
									<span className="text-lg  text-white ">{preset.label}</span>

									{preset.isPro && (

										<>

											{isProFeature && (
												<span
													className="bg-amber-500 px-2 py-1  no-underline rounded-sm  cursor-pointer text-white "
												>
													{__("Pro", "team")}
												</span>
											)}
										</>

									)}





								</div>
							</div>
						);
					})}
				</>








			</div>

		</div>
	);
}

class Templates extends Component {
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
		var { postData, onChange, customerData, addNotifications, setHelp } = this.props;

		return (
			<Html
				postData={postData}
				onChange={onChange}
				customerData={customerData}
				addNotifications={addNotifications}
				setHelp={setHelp}

				warn={this.state.showWarning}
			/>
		);
	}
}

export default Templates;
