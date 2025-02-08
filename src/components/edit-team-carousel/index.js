const { Component, RawHTML, useState, useEffect } = wp.element;
import apiFetch from "@wordpress/api-fetch";
import { store as coreStore } from "@wordpress/core-data";
import { useSelect } from "@wordpress/data";
import { __ } from "@wordpress/i18n";
import { ReactSortable } from "react-sortablejs";

import { MediaUpload, RichText } from "@wordpress/block-editor";
import {
	DateTimePicker,
	Icon,
	__experimentalInputControl as InputControl,
	PanelBody,
	PanelRow,
	Popover,
	SelectControl,
} from "@wordpress/components";
import {
	addCard,
	brush,
	calendar,
	close,
	copy,
	help,
	menu,
	page,
	pages,
	settings,
	starEmpty,
	starFilled,
	styles,
} from "@wordpress/icons";
import breakPoints from "../../breakpoints";
import { popupEntranceAnimateBasic } from "../../inAnimation";
import { popupCloseAnimateBasic } from "../../outAnimation";
import PGDropdown from "../dropdown";
import PGIconPicker from "../icon-picker";
import PGinputSelect from "../input-select";
import PGinputText from "../input-text";
import InputToggle from "../input-toggle";
import WPEditor from "../input-wp-editor";

import PGcssOpenaiPrompts from "../openai-prompts";
import PGStyles from "../styles";
import PGtab from "../tab";
import PGtabs from "../tabs";
import IconToggle from "../icon-toggle";
import LayoutGenerator from "../LayoutGenerator";
import TestimonialItems from "../items";

var myStore = wp.data.select("postgrid-shop");

function Html(props) {
	if (!props.warn) {
		return null;
	}

	var onChange = props.onChange;
	var addNotifications = props.addNotifications;
	var setHelp = props.setHelp;

	var postData = props.postData;

	if (postData.post_content == null) {
		return (
			<div className="p-3 my-5 bg-orange-400">
				Please choose an team first.
			</div>
		);
	}

	var breakPointX = "Desktop";

	var [teamData, setteamData] = useState(postData.post_content);
	var [globalOptions, setglobalOptions] = useState(teamData.globalOptions);

	var [itemQueryArgs, setitemQueryArgs] = useState(teamData.itemQueryArgs);
	var [loopLayout, setloopLayout] = useState(teamData.loopLayout);

	var [wrapper, setwrapper] = useState(teamData.wrapper);
	var [items, setitems] = useState(teamData.items);

	var [itemsWrap, setitemsWrap] = useState(teamData.itemsWrap);
	var [itemWrap, setitemWrap] = useState(teamData.itemWrap);
	var [paginationWrap, setpaginationWrap] = useState(teamData.paginationWrap);
	var [paginationItem, setpaginationItem] = useState(teamData.paginationItem);
	var [paginationItemActive, setpaginationItemActive] = useState(teamData.paginationItemActive);

	var [prev, setprev] = useState(teamData?.prev);
	var [prevIcon, setprevIcon] = useState(teamData?.prevIcon);
	var [next, setnext] = useState(teamData?.next);
	var [nextIcon, setnextIcon] = useState(teamData?.nextIcon);
	var [sliderOptions, setsliderOptions] = useState(teamData?.sliderOptions);
	var [sliderOptionsRes, setsliderOptionsRes] = useState(teamData?.sliderOptionsRes);

	var [navsWrap, setnavsWrap] = useState(teamData?.navsWrap);
	var [navItem, setnavItem] = useState(teamData?.navItem);


	var [styleObj, setstyleObj] = useState({});
	var [customerData, setcustomerData] = useState(props.customerData);
	var [datePicker, setdatePicker] = useState(9999999);

	var [isProFeature, setisProFeature] = useState(true);
	var [editLayouts, seteditLayouts] = useState(false);

	const gapValue = sliderOptions?.gap || "0px";
	const [number, setNumber] = useState(parseInt(gapValue));
	const [unit, setUnit] = useState(gapValue.replace(number, ""));
	const [itemActive, setitemActive] = useState(99999);
	const [AIautoUpdate, setAIautoUpdate] = useState(false);
	var [AIWriter, setAIWriter] = useState(false);
	var formattedPrompt =
		"Respond only with question answer as json array and no other text. Do not include any explanations, introductions, or concluding remarks.";

	var breakPointList = [{ label: "Select..", icon: "", value: "" }];
	for (var x in breakPoints) {
		var breakPointItem = breakPoints[x];
		breakPointList.push({
			label: breakPointItem.name,
			icon: breakPointItem.icon,
			value: breakPointItem.id,
		});
	}

	var postTypes = [];
	const postTypesData = useSelect(
		(select) => select(coreStore).getPostTypes({ per_page: -1 }),
		[]
	);
	postTypesData !== null &&
		postTypesData.map((x) => {
			postTypes.push({ value: x.slug, label: x.name });
		});



	useEffect(() => {
		if (customerData.isPro) {
			setisProFeature(false);
		}
	}, [props.customerData]);

	useEffect(() => {
		onChange(teamData);
	}, [teamData]);

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.globalOptions = globalOptions;
		setteamData(teamDataX);
	}, [globalOptions]);

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.sliderOptions = sliderOptions;
		setteamData(teamDataX);
	}, [sliderOptions]);

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.items = items;
		setteamData(teamDataX);
	}, [items]);

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.wrapper = wrapper;
		setteamData(teamDataX);
	}, [wrapper]);

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.navsWrap = navsWrap;
		setteamData(teamDataX);
	}, [navsWrap]);

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.navItem = navItem;
		setteamData(teamDataX);
	}, [navItem]);


	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.loopLayout = loopLayout;
		setteamData(teamDataX);
	}, [loopLayout]);


	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.itemsWrap = itemsWrap;
		setteamData(teamDataX);
	}, [itemsWrap]);
	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.itemWrap = itemWrap;
		setteamData(teamDataX);
	}, [itemWrap]);
	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.next = next;
		setteamData(teamDataX);
	}, [next]);
	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.nextIcon = nextIcon;
		setteamData(teamDataX);
	}, [nextIcon]);
	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.prev = prev;
		setteamData(teamDataX);
	}, [prev]);
	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.prevIcon = prevIcon;
		setteamData(teamDataX);
	}, [prevIcon]);
	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.paginationItem = paginationItem;
		setteamData(teamDataX);
	}, [paginationItem]);
	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.paginationWrap = paginationWrap;
		setteamData(teamDataX);
	}, [paginationWrap]);
	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.paginationItemActive = paginationItemActive;
		setteamData(teamDataX);
	}, [paginationItemActive]);





	var RemoveSliderArg = function ({ index }) {
		return (
			<span
				className="cursor-pointer hover:bg-red-500 hover:text-white "
				onClick={(ev) => {
					var sliderOptionsX = { ...sliderOptions };
					delete sliderOptionsX[index];
					setaccOptions(sliderOptionsX);
				}}>
				<Icon icon={close} />
			</span>
		);
	};

	const ALLOWED_MEDIA_TYPES = ["image"];

	var videoType = {
		choose: { label: "Choose", value: "" },
		youtube: { label: "YouTube", value: "youtube" },
	};

	function onChangeStyle(sudoScource, newVal, attr, propertyType, setProperty) {
		var path = [sudoScource, attr, breakPointX];
		let obj = { ...propertyType };
		const object = myStore.updatePropertyDeep(obj, path, newVal);
		setProperty(object);
	}

	function onAddStyle(sudoScource, key, propertyType, setProperty) {
		var path = [sudoScource, key, breakPointX];
		let obj = { ...propertyType };
		const object = myStore.addPropertyDeep(obj, path, "");
		setProperty(object);
	}

	function onResetStyle(sudoSources, propertyType, setProperty) {
		let obj = Object.assign({}, propertyType);
		Object.entries(sudoSources).map((args) => {
			var sudoScource = args[0];
			if (obj[sudoScource] == undefined) {
			} else {
				obj[sudoScource] = {};
				// var elementSelector = myStore.getElementSelector(
				// 	sudoScource,
				// 	contentSelector // Replace this selector if needed
				// );
			}
		});
		setProperty(obj);
	}

	function onRemoveStyle(sudoScource, key, propertyType, setProperty) {
		let obj = { ...propertyType };
		var object = myStore.deletePropertyDeep(obj, [
			sudoScource,
			key,
			breakPointX,
		]);
		var isEmpty =
			Object.entries(object[sudoScource][key]).length === 0 ? true : false;
		var objectX = isEmpty
			? myStore.deletePropertyDeep(object, [sudoScource, key])
			: object;
		setProperty(objectX);
	}

	function onBulkAddStyle(sudoSource, cssObj, propertyType, setProperty) {
		let obj = { ...propertyType };
		obj[sudoSource] = cssObj;
		setProperty(obj);
	}

	var accOptionsArgs = {
		autoplay: { label: "Auto play", value: 1 },
	};
	var postQueryArgs = {
		postType: {
			value: ["post"],

			id: "postType",
			label: "Post types",
			description: "Select Post Types to Query",
		},
		s: {
			value: "",

			id: "s",
			label: "Keyword",
			description: "Search keyword, ex: hello",
		},
		postStatus: {
			value: [],

			id: "postStatus",
			label: "Post status",
			description: "Query post by post status",
		},
		order: {
			value: "",

			id: "order",
			label: "Order",
			description: "Post query order",
		},
		orderby: {
			value: [],

			id: "orderby",
			label: "Orderby",
			description: "Post query orderby",
		},
		metaKey: {
			value: "",

			id: "metaKey",
			label: "Meta fields key",
			description: "Post query by meta fields key",
		},
		metaValue: {
			value: "",

			id: "metaValue",
			label: "Meta Value",
			description: "Post query by custom field value",
		},
		metaValueNum: {
			value: "",

			id: "metaValueNum",
			label: "Meta Value Num",
			description: "Post query by custom field value for number types",
		},
		metaCompare: {
			value: "",

			id: "metaCompare",
			label: "Meta Compare",
			description: "Meta query compare",
		},
	};
	const updatePostQueryArgs = (newVal, index) => {
		var itemQueryArgsX = [...itemQueryArgs];
		itemQueryArgsX[index].value = newVal;
		setitemQueryArgs(itemQueryArgsX);
	};

	const paginationTypes = {
		none: { label: __("None", "post-grid"), value: "none" },
		normal: { label: __("Normal Pagination", "post-grid"), value: "normal" },
		ajax: {
			label: __("Ajax Pagination", "post-grid"),
			value: "ajax",
			isPro: true,
		},
		next_previous: {
			label: __("Next-Previous", "post-grid"),
			value: "next_previous",
			isPro: true,
		},
		loadmore: {
			label: __("Load More", "post-grid"),
			value: "loadmore",
			isPro: true,
		},
		infinite: {
			label: __("Infinite Load", "post-grid"),
			value: "infinite",
			isPro: true,
		},
		filterable: { label: __("Filterable", "post-grid"), value: "filterable" },
	};


	var sliderOptionsArgs = {
		autoplay: { label: "Auto play", value: 1 },
		interval: { label: "Interval", value: "500" },
		pauseOnHover: { label: "Pause On Hover", value: 1 },
		pauseOnFocus: { label: "Pause On Focus", value: 1 },
		lazyLoad: { label: "Lazy Load", value: 1 },
		preloadPages: { label: "Preload Pages", value: 1 },
		keyboard: { label: "Keyboard", value: 1 },
		wheel: { label: "Wheel", value: 1 },
		releaseWheel: { label: "Release Wheel", value: 1 },
		direction: { label: "Direction", value: "ltr" },
		cover: { label: "Cover", value: 0 },
		rewind: { label: "Rewind", value: 0 },
		speed: { label: "Speed", value: 400 },
		rewindSpeed: { label: "Rewind Speed", value: 400 },
		rewindByDrag: { label: "Rewind By Drag", value: 0 },
		type: { label: "Slider Type", value: "slide" },
		width: { label: "Width", value: "" },
		height: { label: "Height", value: "" },
		fixedWidth: { label: "Fixed Width", value: "" },
		fixedHeight: { label: "Fixed Height", value: "" },
		heightRatio: { label: "Height Ratio", value: "" },
		autoWidth: { label: "Auto Width", value: 0 },
		autoHeight: { label: "Auto Height", value: 0 },
		start: { label: "Start", value: 0 },
		perPage: { label: "Per Page", value: 3 },
		perMove: { label: "Per Move", value: 3 },
		focus: { label: "Focus", value: "center" },
		gap: { label: "Gap", value: "1em", unit: "em", number: "1" },
		padding: { label: "Padding", value: "" },
		arrows: { label: "Arrows", value: 1 },
		pagination: { label: "Pagination", value: 1 },
		//easing: { label: 'Easing', value: 'cubic-bezier(0.25, 1, 0.5, 1)' },
		paginationKeyboard: { label: "Pagination Keyboard", value: 1 },
		paginationDirection: {
			label: "Pagination Direction",
			value: "paginationDirectltrion",
		},
		drag: { label: "Drag", value: 1 },
		noDrag: { label: "No Drag", value: "input, textarea, .rich-text" },
		snap: { label: "Snap", value: 1 },
		mediaQuery: { label: "Media Query", value: "max" },
	};

	var itemSources = {
		manual: { label: "Manual", value: "manual" },
		posts: {
			label: "Posts",
			value: "posts",
			isPro: customerData.isPro ? false : true,
		},

	};

	var sliderOptionsArgsRes = {
		rewind: { label: "Rewind", value: 0 },
		speed: { label: "Speed", value: 400 },
		rewindSpeed: { label: "Rewind Speed", value: 400 },
		rewindByDrag: { label: "Rewind By Drag", value: 0 },
		width: { label: "Width", value: "" },
		height: { label: "Height", value: "" },
		fixedWidth: { label: "Fixed Width", value: "" },
		fixedHeight: { label: "Fixed Height", value: "" },
		heightRatio: { label: "Height Ratio", value: "" },
		perPage: { label: "Per Page", value: 3 },
		perMove: { label: "Per Move", value: 3 },
		focus: { label: "Focus", value: "center" },
		gap: { label: "Gap", value: "1em", unit: "em", number: "1" },
		padding: { label: "Padding", value: "" },
		arrows: { label: "Arrows", value: 1 },
		pagination: { label: "Pagination", value: 1 },
		paginationKeyboard: { label: "Pagination Keyboard", value: 1 },
		paginationDirection: {
			label: "Pagination Direction",
			value: "paginationDirectltrion",
		},
		drag: { label: "Drag", value: 1 },
		snap: { label: "Snap", value: 1 },
		keyboard: { label: "Keyboard", value: 1 },
		direction: { label: "Direction", value: "ltr" },
		easing: { label: "Easing", value: "cubic-bezier(0.25, 1, 0.5, 1)" },
	};

	var RemoveSliderArgRes = function ({ index }) {
		return (
			<span
				className="cursor-pointer hover:bg-red-500 hover:text-white "
				onClick={(ev) => {
					var sliderOptionsResX = { ...sliderOptionsRes };
					delete sliderOptionsResX[index];
					setAttributes({ sliderOptionsRes: sliderOptionsResX });
				}}>
				<Icon icon={close} />
			</span>
		);
	};

	function generate3Digit() {
		return Math.floor(100 + Math.random() * 900);
	}
	const handleDelete = (id) => {
		// Filter out the item with the specified id
		const updatedItems = Object.fromEntries(
			Object.entries(itemQueryArgs).filter(([key, item]) => item.id !== id)
		);
		setitemQueryArgs(updatedItems);
	};

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

	function escapeHTML(str) {
		const map = {
			"&": "&amp;",
			"<": "&lt;",
			">": "&gt;",
			'"': "&quot;",
			"'": "&#039;",
		};
		return str.replace(/[&<>"']/g, function (match) {
			return map[match];
		});
	}

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

	function onChangeBreakPoint(x, _index) {
		var asdsdsd = wp.data.dispatch("postgrid-shop").setBreakPoint(x.value);
		asdsdsd.then((res) => {
			setBreakPointX(res.breakpoint);
			myStore.generateBlockCss(blockCssY.items, blockId);
		});
		const { getPreviewDeviceType } = select("core/editor");
		const gutenbergDeviceType = getPreviewDeviceType;
	}

	function onChangeLayouts(loopLayout) {
		var teamDataX = { ...teamData };
		teamDataX.loopLayout = loopLayout;
		setteamData(teamDataX);

		setloopLayout(loopLayout)
	}

	return (
		<div className="">
			<div
				className="hidden"
				onClick={() => {
					var str = `{
						${JSON.stringify(teamData)},
				"wrapper":${JSON.stringify(wrapper)},
				"navItem":${JSON.stringify(navItem)},
				}`;

					copyData(str);

					addNotifications({
						title: "Copied to clipboard!",
						content:
							"Use the shortcode in page or post conent where you want to display.",
						type: "success",
					});
				}}>
				<div className="p-3">
					<div>{`{`}</div>
					<div>{`"items":${JSON.stringify(items)}`},</div>
					<div>{`"wrapper":${JSON.stringify(wrapper)}`},</div>
					<div>{`"navsWrap":${JSON.stringify(navsWrap)}`},</div>
					<div>{`"navItem":${JSON.stringify(navItem)}`},</div>
					<div>{`}`}</div>
				</div>
			</div>

			{props.postData.post_content != null && (
				<>
					<TestimonialItems
						itemsState={{ items, setitems }}
						globalOptionsState={{ globalOptions, setglobalOptions }}
						itemQueryState={{ itemQueryArgs, setitemQueryArgs }}
						customerData={customerData}
						setHelp={setHelp}
						addNotifications={addNotifications}
					/>
					<PanelBody
						className="font-medium text-slate-900 "
						title="Team Settings"
						initialOpen={false}>
						<div className="py-3">
							<PanelRow>
								<label htmlFor="" className="flex gap-2 items-center">
									Lazyload{" "}
									<span
										className="cursor-pointer"
										title="Click to know more"
										onClick={() => {
											setHelp({
												id: "lazyloadSetting",
												enable: true,
											});
										}}>
										<Icon icon={help} />
									</span>
								</label>
								<InputToggle
									value={globalOptions?.lazyLoad}
									onChange={(newVal) => {
										var globalOptionsX = { ...globalOptions };
										globalOptionsX.lazyLoad = newVal;
										setglobalOptions(globalOptionsX);
									}}
								/>
								{/* <SelectControl
									className="w-[140px]"
									label=""
									value={globalOptions?.lazyLoad}
									options={[
										{ label: __("True", "team"), value: 1 },
										{ label: __("False", "team"), value: 0 },
									]}
									onChange={(newVal) => {
										// var globalOptionsX = { ...globalOptions };
										// globalOptionsX.lazyLoad = newVal;
										// setglobalOptions(globalOptionsX);

										var globalOptionsX = { ...globalOptions };
										globalOptionsX.lazyLoad = newVal;
										setglobalOptions(globalOptionsX);
									}}
								/> */}
							</PanelRow>
						</div>
					</PanelBody>
					<PanelBody
						className="font-medium text-slate-900 "
						title={__("Slider Options", "post-grid")}
						initialOpen={false}>
						<PGtabs
							activeTab="normal"
							orientation="horizontal"
							activeClass="active-tab"
							onSelect={(tabName) => {}}
							tabs={[
								{
									name: "normal",
									title: "Normal",
									icon: settings,
									className: "tab-normal",
								},
								{
									name: "responsive",
									title: "Responsive",
									icon: styles,
									className: "tab-responsive",
								},
							]}>
							<PGtab name="normal">
								<PanelRow className="my-3">
									<label>{__("Slider Options", "post-grid")}</label>
									<PGDropdown
										position="bottom right"
										variant="secondary"
										buttonTitle={"Choose"}
										options={sliderOptionsArgs}
										onChange={(option, index) => {
											var sliderOptionsX = { ...sliderOptions };
											sliderOptionsX[index] = option.value;
											setsliderOptions(sliderOptionsX);
										}}
										values=""></PGDropdown>
								</PanelRow>
								<div className="flex mb-4 gap-4 mb-3">
									<button
										onClick={() => {
											copyData(sliderOptions);
										}}
										className="pg-font flex gap-2 justify-center  cursor-pointer py-2 px-4 capitalize  !bg-gray-700 !text-white font-medium !rounded hover:bg-gray-600 hover:text-white focus:outline-none focus:bg-gray-600">
										<Icon icon={copy} className="fill-white " size={14} />
										{__("Copy", "post-grid")}
									</button>
									<button
										onClick={() => {
											pasteData();
										}}
										className="pg-font flex gap-2 justify-center  cursor-pointer py-2 px-4 capitalize  !bg-gray-700 !text-white font-medium !rounded hover:bg-gray-600 hover:text-white focus:outline-none focus:bg-gray-600">
										<Icon icon={pages} className="fill-white " size={14} />
										{__("Paste", "post-grid")}
									</button>
								</div>
								{Object.entries(sliderOptions).map((item, index) => {
									var id = item[0];
									var value = item[1];
									return (
										<div key={index}>
											{id == "autoplay" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Autoplay?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "rewind" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Rewind?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "type" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Slider Type?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: "Slide", value: "slide" },
															{ label: "Loop", value: "loop" },
															{ label: "Fade", value: "fade" },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "interval" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Interval?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														type="number"
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "speed" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Speed?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														type="number"
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "rewindSpeed" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Rewind Speed?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														type="number"
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "start" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Start?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														type="number"
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "perPage" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Per Page?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														type="number"
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "perMove" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Per Move?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														type="number"
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "gap" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Gap?", "post-grid")}</span>
													</div>
													<div className="flex items-center gap-1 ">
														<input
															type="number"
															value={number}
															className="w-[100px]"
															onChange={(e) => {
																const newNumber = e.target.value;
																setNumber(newNumber);
																var sliderOptionsX = { ...sliderOptions };
																sliderOptionsX[id] = `${newNumber}${unit}`;
																setsliderOptions(sliderOptionsX);
															}}
														/>
														<select
															value={unit}
															onChange={(e) => {
																const newUnit = e.target.value;
																setUnit(newUnit);
																var sliderOptionsX = { ...sliderOptions };
																sliderOptionsX[id] = `${number}${newUnit}`;
																setsliderOptions(sliderOptionsX);
															}}>
															<option value="px">px</option>
															<option value="em">em</option>
															<option value="rem">rem</option>
															<option value="%">%</option>
														</select>
													</div>
												</PanelRow>
											)}
											{id == "padding" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Padding?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "focus" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Focus?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "width" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Width?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "height" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Height?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "fixedWidth" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Fixed Width?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "fixedHeight" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Fixed Height?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "heightRatio" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Height Ratio?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "easing" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Easing?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "pauseOnHover" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Pause On Hover?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "pauseOnFocus" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Pause On Focus?", "post-grid")}</span>
													</div>
													<label for="" className="font-medium text-slate-900 ">
														?
													</label>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "rewindByDrag" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Rewind By Drag?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "autoWidth" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Auto Width?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "autoHeight" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Auto Height?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "arrows" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Navigation?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "pagination" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Pagination?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "paginationKeyboard" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>
															{__("Pagination Keyboard?", "post-grid")}
														</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "drag" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Drag?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "snap" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Snap?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "noDrag" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("noDrag?", "post-grid")}</span>
													</div>
													<InputControl
														value={value}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "paginationDirection" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>
															{__("Pagination Direction?", "post-grid")}
														</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: "ltr", value: "ltr" },
															{ label: "rtl", value: "rtl" },
															{ label: "ttb", value: "ttb" },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "direction" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Direction?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: "ltr", value: "ltr" },
															{ label: "rtl", value: "rtl" },
															{ label: "ttb", value: "ttb" },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "lazyLoad" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("LazyLoad?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
															{
																label: __("Nearby", "post-grid"),
																value: "nearby",
															},
															{
																label: __("Sequential", "post-grid"),
																value: "sequential",
															},
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "keyboard" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Keyboard?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
															{
																label: __("Global", "post-grid"),
																value: "global",
															},
															{
																label: __("Focused", "post-grid"),
																value: "focused",
															},
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "mediaQuery" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Media Query?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: "min", value: "min" },
															{ label: "max", value: "max" },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "wheel" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Wheel?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
											{id == "cover" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArg index={id} />
														<span>{__("Cover?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={value}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsX = { ...sliderOptions };
															sliderOptionsX[id] = newVal;
															setsliderOptions(sliderOptionsX);
														}}
													/>
												</PanelRow>
											)}
										</div>
									);
								})}
							</PGtab>
							<PGtab name="responsive">
								<PanelRow className="my-3">
									<label>{__("Slider Options", "post-grid")}</label>
									<PGDropdown
										position="bottom right"
										variant="secondary"
										buttonTitle={"Choose"}
										options={sliderOptionsArgsRes}
										onChange={(option, index) => {
											var sliderOptionsResX = { ...sliderOptionsRes };
											if (sliderOptionsResX[index] == undefined) {
												sliderOptionsResX[index] = {};
											}
											if (sliderOptionsResX[index][breakPointX] == undefined) {
												sliderOptionsResX[index][breakPointX] = option.value;
											}
											setsliderOptionsRes(sliderOptionsResX);
										}}
										values=""></PGDropdown>
									<IconToggle
										position="bottom"
										variant="secondary"
										iconList={breakPointList}
										buttonTitle="Break Point Switch"
										onChange={onChangeBreakPoint}
										activeIcon={breakPoints[breakPointX].icon}
										value={breakPointX}
									/>
								</PanelRow>
								{Object.entries(sliderOptionsRes).map((item, index) => {
									var id = item[0];
									var value = item[1];
									return (
										<div key={index}>
											{id == "autoplay" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Autoplay?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "rewind" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Rewind?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "interval" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Interval?", "post-grid")}</span>
													</div>
													<InputControl
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														type="number"
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "speed" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Speed?", "post-grid")}</span>
													</div>
													<InputControl
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														type="number"
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "rewindSpeed" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Rewind Speed?", "post-grid")}</span>
													</div>
													<InputControl
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														type="number"
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "start" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Start?", "post-grid")}</span>
													</div>
													<InputControl
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														type="number"
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "perPage" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{"Per Page?"}</span>
													</div>
													<InputControl
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														type="number"
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "perMove" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Per Move?", "post-grid")}</span>
													</div>
													<InputControl
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														type="number"
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "gap" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Gap?", "post-grid")}</span>
													</div>
													<InputControl
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "padding" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Padding?", "post-grid")}</span>
													</div>
													<InputControl
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "focus" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Focus?", "post-grid")}</span>
													</div>
													<InputControl
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "width" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Width?", "post-grid")}</span>
													</div>
													<InputControl
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "height" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Height?", "post-grid")}</span>
													</div>
													<InputControl
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "fixedWidth" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Fixed Width?", "post-grid")}</span>
													</div>
													<InputControl
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "fixedHeight" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Fixed Height?", "post-grid")}</span>
													</div>
													<InputControl
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "heightRatio" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Height Ratio?", "post-grid")}</span>
													</div>
													<InputControl
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "pauseOnHover" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Pause On Hover?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "pauseOnFocus" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Pause On Focus?", "post-grid")}</span>
													</div>
													<label for="" className="font-medium text-slate-900 ">
														?
													</label>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "rewindByDrag" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Rewind By Drag?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "autoWidth" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Auto Width?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "autoHeight" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Auto Height?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "arrows" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Navigation?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "pagination" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Pagination?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "paginationKeyboard" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>
															{__("Pagination Keyboard?", "post-grid")}
														</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "drag" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Drag?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "snap" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Snap?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "noDrag" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("No Drag?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "paginationDirection" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>
															{__("Pagination Direction?", "post-grid")}
														</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: "ltr", value: "ltr" },
															{ label: "rtl", value: "rtl" },
															{ label: "ttb", value: "ttb" },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "direction" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Direction?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: "ltr", value: "ltr" },
															{ label: "rtl", value: "rtl" },
															{ label: "ttb", value: "ttb" },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "lazyLoad" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("LazyLoad?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
															{
																label: __("Nearby", "post-grid"),
																value: "nearby",
															},
															{
																label: __("Sequential", "post-grid"),
																value: "sequential",
															},
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "keyboard" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Keyboard?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
															{
																label: __("Global", "post-grid"),
																value: "global",
															},
															{
																label: __("Focused", "post-grid"),
																value: "focused",
															},
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "mediaQuery" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Media Query?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: "min", value: "min" },
															{ label: "max", value: "max" },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "wheel" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Wheel?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
											{id == "cover" && (
												<PanelRow>
													<div className="flex items-center">
														<RemoveSliderArgRes index={id} />
														<span>{__("Cover?", "post-grid")}</span>
													</div>
													<SelectControl
														label=""
														value={
															value[breakPointX] == undefined
																? ""
																: value[breakPointX]
														}
														options={[
															{ label: __("True", "post-grid"), value: 1 },
															{ label: __("False", "post-grid"), value: 0 },
														]}
														onChange={(newVal) => {
															var sliderOptionsResX = { ...sliderOptionsRes };
															if (
																sliderOptionsResX[id][breakPointX] == undefined
															) {
																sliderOptionsResX[id][breakPointX] = "";
															}
															sliderOptionsResX[id][breakPointX] = newVal;
															setsliderOptionsRes(sliderOptionsResX);
														}}
													/>
												</PanelRow>
											)}
										</div>
									);
								})}
							</PGtab>
						</PGtabs>
					</PanelBody>
					<PanelBody
						className="font-medium text-slate-900 "
						title="Layouts"
						initialOpen={false}>
						<div className="flex items-center justify-between">
							<div
								className="bg-slate-700 inline-block text-white px-5 py-2 rounded-sm cursor-pointer hover:bg-slate-600"
								onClick={(ev) => {
									seteditLayouts(!editLayouts);
								}}>
								Customize Layouts
							</div>
							<div
								className="bg-slate-700 text-white px-5 py-2 rounded-sm cursor-pointer hover:bg-slate-600 flex items-center gap-1"
								onClick={() => {
									navigator.clipboard
										.writeText(JSON.stringify(teamData.loopLayout))
										.then(() => {
											addNotifications({
												title: "Copied to clipboard!",
												content: "Layout Copied!",
												type: "success",
											});
										});
								}}>
								<Icon icon={copy} size={14} fill="#fff" />
								Copy
							</div>
							<div
								className="bg-slate-700 text-white px-5 py-2 rounded-sm cursor-pointer hover:bg-slate-600 flex items-center gap-1"
								onClick={async () => {
									try {
										var data = await navigator.clipboard.readText().then(() => {
											addNotifications({
												title: "Layout Pasted!",
												content: "Layout paste successful.",
												type: "success",
											});
										});
										data = JSON.parse(data);
										onChangeLayouts(data);
									} catch (e) {
										console.log(e);
									}
								}}>
								<Icon icon={page} size={14} fill="#fff" />
								Paste
							</div>

							{editLayouts && (
								<Popover position="bottom right">
									<div className="w-[1200px] p-3">
										<LayoutGenerator
											postData={postData}
											onChange={onChangeLayouts}
											layouts={teamData.loopLayout}
										/>
									</div>
								</Popover>
							)}
						</div>
					</PanelBody>
					<PanelBody
						className="font-medium text-slate-900 "
						title="Wrapper"
						initialOpen={false}>
						<PGtabs
							activeTab="options"
							orientation="horizontal"
							activeClass="active-tab"
							onSelect={(tabName) => {}}
							tabs={[
								{
									name: "options",
									title: "Options",
									icon: settings,
									className: "tab-settings",
								},
								{
									name: "styles",
									title: "Styles",
									icon: brush,
									className: "tab-style",
								},
							]}>
							<PGtab name="options">
								<div className="flex  my-5  justify-between items-center">
									<label className="" htmlFor="">
										{__("Class", "team")}
									</label>
									<PGinputText
										value={wrapper?.options?.class}
										className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
										onChange={(newVal) => {
											var optionsX = {
												...wrapper,
												options: {
													...wrapper?.options,
													class: newVal,
												},
											};
											setwrapper(optionsX);
										}}
									/>
								</div>
							</PGtab>
							<PGtab name="styles">
								<PGStyles
									obj={wrapper}
									onChange={(sudoScource, newVal, attr) =>
										onChangeStyle(
											sudoScource,
											newVal,
											attr,
											wrapper,
											setwrapper
										)
									}
									onAdd={(sudoScource, key) =>
										onAddStyle(sudoScource, key, wrapper, setwrapper)
									}
									onRemove={(sudoScource, key) =>
										onRemoveStyle(sudoScource, key, wrapper, setwrapper)
									}
									onReset={(sudoSources) =>
										onResetStyle(sudoSources, wrapper, setwrapper)
									}
									onBulkAdd={(sudoSource, cssObj) =>
										onBulkAddStyle(sudoSource, cssObj, wrapper, setwrapper)
									}
								/>
							</PGtab>
						</PGtabs>
					</PanelBody>

					<PanelBody
						className="font-medium text-slate-900 "
						title="Items Wrap"
						initialOpen={false}>
						<PGtabs
							activeTab="options"
							orientation="horizontal"
							activeClass="active-tab"
							onSelect={(tabName) => {}}
							tabs={[
								{
									name: "options",
									title: "Options",
									icon: settings,
									className: "tab-settings",
								},
								{
									name: "styles",
									title: "Styles",
									icon: brush,
									className: "tab-style",
								},
							]}>
							<PGtab name="options">
								<div className="flex  my-5  justify-between items-center">
									<label className="" htmlFor="">
										{__("Class", "team")}
									</label>
									<PGinputText
										value={itemsWrap?.options?.class}
										className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
										onChange={(newVal) => {
											var optionsX = {
												...itemsWrap,
												options: {
													...itemsWrap?.options,
													class: newVal,
												},
											};
											setitemsWrap(optionsX);
										}}
									/>
								</div>
							</PGtab>
							<PGtab name="styles">
								<PGStyles
									obj={itemsWrap}
									onChange={(sudoScource, newVal, attr) =>
										onChangeStyle(
											sudoScource,
											newVal,
											attr,
											itemsWrap,
											setitemsWrap
										)
									}
									onAdd={(sudoScource, key) =>
										onAddStyle(sudoScource, key, itemsWrap, setitemsWrap)
									}
									onRemove={(sudoScource, key) =>
										onRemoveStyle(sudoScource, key, itemsWrap, setitemsWrap)
									}
									onReset={(sudoSources) =>
										onResetStyle(sudoSources, itemsWrap, setitemsWrap)
									}
									onBulkAdd={(sudoSource, cssObj) =>
										onBulkAddStyle(sudoSource, cssObj, itemsWrap, setitemsWrap)
									}
								/>
							</PGtab>
						</PGtabs>
					</PanelBody>

					<PanelBody
						className="font-medium text-slate-900 "
						title="Item"
						initialOpen={false}>
						<PGtabs
							activeTab="options"
							orientation="horizontal"
							activeClass="active-tab"
							onSelect={(tabName) => {}}
							tabs={[
								{
									name: "options",
									title: "Options",
									icon: settings,
									className: "tab-settings",
								},
								{
									name: "styles",
									title: "Styles",
									icon: brush,
									className: "tab-style",
								},
							]}>
							<PGtab name="options">
								<div className="flex  my-5  justify-between items-center">
									<label className="" htmlFor="">
										{__("Class", "team")}
									</label>
									<PGinputText
										value={itemWrap?.options?.class}
										className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
										onChange={(newVal) => {
											var optionsX = {
												...itemWrap,
												options: {
													...itemWrap?.options,
													class: newVal,
												},
											};
											setitemWrap(optionsX);
										}}
									/>
								</div>
							</PGtab>
							<PGtab name="styles">
								<PGStyles
									obj={itemWrap}
									onChange={(sudoScource, newVal, attr) =>
										onChangeStyle(
											sudoScource,
											newVal,
											attr,
											itemWrap,
											setitemWrap
										)
									}
									onAdd={(sudoScource, key) =>
										onAddStyle(sudoScource, key, itemWrap, setitemWrap)
									}
									onRemove={(sudoScource, key) =>
										onRemoveStyle(sudoScource, key, itemWrap, setitemWrap)
									}
									onReset={(sudoSources) =>
										onResetStyle(sudoSources, itemWrap, setitemWrap)
									}
									onBulkAdd={(sudoSource, cssObj) =>
										onBulkAddStyle(sudoSource, cssObj, itemWrap, setitemWrap)
									}
								/>
							</PGtab>
						</PGtabs>
					</PanelBody>

					<PanelBody
						className="font-medium text-slate-900 "
						title="Navigation/Arrows"
						initialOpen={false}>
						<PanelBody
							className="font-medium text-slate-900 "
							title="Navs Wrap"
							initialOpen={false}>
							<PGtabs
								activeTab="options"
								orientation="horizontal"
								activeClass="active-tab"
								onSelect={(tabName) => {}}
								tabs={[
									{
										name: "options",
										title: "Options",
										icon: settings,
										className: "tab-settings",
									},
									{
										name: "styles",
										title: "Styles",
										icon: brush,
										className: "tab-style",
									},
								]}>
								<PGtab name="options">
									<div className="flex  my-5  justify-between items-center">
										<label className="" htmlFor="">
											{__("Class", "team")}
										</label>
										<PGinputText
											value={navsWrap?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
											onChange={(newVal) => {
												var optionsX = {
													...navsWrap,
													options: {
														...navsWrap?.options,
														class: newVal,
													},
												};
												setnavsWrap(optionsX);
											}}
										/>
									</div>
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={navsWrap}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(
												sudoScource,
												newVal,
												attr,
												navsWrap,
												setnavsWrap
											)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(sudoScource, key, navsWrap, setnavsWrap)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(sudoScource, key, navsWrap, setnavsWrap)
										}
										onReset={(sudoSources) =>
											onResetStyle(sudoSources, navsWrap, setnavsWrap)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(sudoSource, cssObj, navsWrap, setnavsWrap)
										}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>
						<PanelBody
							className="font-medium text-slate-900 "
							title="Navs Item"
							initialOpen={false}>
							<PGtabs
								activeTab="options"
								orientation="horizontal"
								activeClass="active-tab"
								onSelect={(tabName) => {}}
								tabs={[
									{
										name: "options",
										title: "Options",
										icon: settings,
										className: "tab-settings",
									},
									{
										name: "styles",
										title: "Styles",
										icon: brush,
										className: "tab-style",
									},
								]}>
								<PGtab name="options">
									<div className="flex  my-5  justify-between items-center">
										<label className="" htmlFor="">
											{__("Class", "team")}
										</label>
										<PGinputText
											value={navItem?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
											onChange={(newVal) => {
												var optionsX = {
													...navItem,
													options: {
														...navItem?.options,
														class: newVal,
													},
												};
												setnavItem(optionsX);
											}}
										/>
									</div>
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={navItem}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(
												sudoScource,
												newVal,
												attr,
												navItem,
												setnavItem
											)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(sudoScource, key, navItem, setnavItem)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(sudoScource, key, navItem, setnavItem)
										}
										onReset={(sudoSources) =>
											onResetStyle(sudoSources, navItem, setnavItem)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(sudoSource, cssObj, navItem, setnavItem)
										}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>

						<PanelBody
							className="font-medium text-slate-900 "
							title="Prev"
							initialOpen={false}>
							<PGtabs
								activeTab="options"
								orientation="horizontal"
								activeClass="active-tab"
								onSelect={(tabName) => {}}
								tabs={[
									{
										name: "options",
										title: "Options",
										icon: settings,
										className: "tab-settings",
									},
									{
										name: "styles",
										title: "Styles",
										icon: brush,
										className: "tab-style",
									},
								]}>
								<PGtab name="options">
									<div className="flex  my-5  justify-between items-center">
										<label className="" htmlFor="">
											{__("Class", "team")}
										</label>
										<PGinputText
											value={prev?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
											onChange={(newVal) => {
												var optionsX = {
													...prev,
													options: {
														...prev?.options,
														class: newVal,
													},
												};
												setprev(optionsX);
											}}
										/>
									</div>
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={prev}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(sudoScource, newVal, attr, prev, setprev)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(sudoScource, key, prev, setprev)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(sudoScource, key, prev, setprev)
										}
										onReset={(sudoSources) =>
											onResetStyle(sudoSources, prev, setprev)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(sudoSource, cssObj, prev, setprev)
										}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>

						<PanelBody
							className="font-medium text-slate-900 "
							title="Prev Icon"
							initialOpen={false}>
							<PGtabs
								activeTab="options"
								orientation="horizontal"
								activeClass="active-tab"
								onSelect={(tabName) => {}}
								tabs={[
									{
										name: "options",
										title: "Options",
										icon: settings,
										className: "tab-settings",
									},
									{
										name: "styles",
										title: "Styles",
										icon: brush,
										className: "tab-style",
									},
								]}>
								<PGtab name="options">
									<div className="flex  my-5  justify-between items-center">
										<label className="" htmlFor="">
											{__("Class", "team")}
										</label>
										<PGinputText
											value={prevIcon?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
											onChange={(newVal) => {
												var optionsX = {
													...prevIcon,
													options: {
														...prevIcon?.options,
														class: newVal,
													},
												};
												setprevIcon(optionsX);
											}}
										/>
									</div>
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={prevIcon}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(
												sudoScource,
												newVal,
												attr,
												prevIcon,
												setprevIcon
											)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(sudoScource, key, prevIcon, setprevIcon)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(sudoScource, key, prevIcon, setprevIcon)
										}
										onReset={(sudoSources) =>
											onResetStyle(sudoSources, prevIcon, setprevIcon)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(sudoSource, cssObj, prevIcon, setprevIcon)
										}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>

						<PanelBody
							className="font-medium text-slate-900 "
							title="Next"
							initialOpen={false}>
							<PGtabs
								activeTab="options"
								orientation="horizontal"
								activeClass="active-tab"
								onSelect={(tabName) => {}}
								tabs={[
									{
										name: "options",
										title: "Options",
										icon: settings,
										className: "tab-settings",
									},
									{
										name: "styles",
										title: "Styles",
										icon: brush,
										className: "tab-style",
									},
								]}>
								<PGtab name="options">
									<div className="flex  my-5  justify-between items-center">
										<label className="" htmlFor="">
											{__("Class", "team")}
										</label>
										<PGinputText
											value={next?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
											onChange={(newVal) => {
												var optionsX = {
													...next,
													options: {
														...next?.options,
														class: newVal,
													},
												};
												setnext(optionsX);
											}}
										/>
									</div>
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={next}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(sudoScource, newVal, attr, next, setnext)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(sudoScource, key, next, setnext)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(sudoScource, key, next, setnext)
										}
										onReset={(sudoSources) =>
											onResetStyle(sudoSources, next, setnext)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(sudoSource, cssObj, next, setnext)
										}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>

						<PanelBody
							className="font-medium text-slate-900 "
							title="Next Icon"
							initialOpen={false}>
							<PGtabs
								activeTab="options"
								orientation="horizontal"
								activeClass="active-tab"
								onSelect={(tabName) => {}}
								tabs={[
									{
										name: "options",
										title: "Options",
										icon: settings,
										className: "tab-settings",
									},
									{
										name: "styles",
										title: "Styles",
										icon: brush,
										className: "tab-style",
									},
								]}>
								<PGtab name="options">
									<div className="flex  my-5  justify-between items-center">
										<label className="" htmlFor="">
											{__("Class", "team")}
										</label>
										<PGinputText
											value={nextIcon?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
											onChange={(newVal) => {
												var optionsX = {
													...nextIcon,
													options: {
														...nextIcon?.options,
														class: newVal,
													},
												};
												setnextIcon(optionsX);
											}}
										/>
									</div>
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={nextIcon}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(
												sudoScource,
												newVal,
												attr,
												nextIcon,
												setnextIcon
											)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(sudoScource, key, nextIcon, setnextIcon)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(sudoScource, key, nextIcon, setnextIcon)
										}
										onReset={(sudoSources) =>
											onResetStyle(sudoSources, nextIcon, setnextIcon)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(sudoSource, cssObj, nextIcon, setnextIcon)
										}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>
					</PanelBody>

					<PanelBody
						className="font-medium text-slate-900 "
						title="Pagination/Dots"
						initialOpen={false}>
						<PanelBody
							className="font-medium text-slate-900 "
							title="Pagination Wrap"
							initialOpen={false}>
							<PGtabs
								activeTab="options"
								orientation="horizontal"
								activeClass="active-tab"
								onSelect={(tabName) => {}}
								tabs={[
									{
										name: "options",
										title: "Options",
										icon: settings,
										className: "tab-settings",
									},
									{
										name: "styles",
										title: "Styles",
										icon: brush,
										className: "tab-style",
									},
								]}>
								<PGtab name="options">
									<PanelRow className="mb-4">
										<label htmlFor="">
											{__("Pagination Type", "post-grid")}
										</label>
										<PGDropdown
											position="bottom right"
											variant="secondary"
											options={paginationTypes}
											buttonTitle={
												paginationTypes[paginationWrap.options.type] !=
												undefined
													? paginationTypes[paginationWrap.options.type].label
													: __("Choose", "post-grid")
											}
											onChange={(arg, index) => {
												var optionsX = {
													...paginationWrap,
													options: {
														...paginationWrap?.options,
														type: arg.value,
													},
												};
												setpaginationWrap(optionsX);
											}}
											values={""}></PGDropdown>
									</PanelRow>
									<div className="flex  my-5  justify-between items-center">
										<label className="" htmlFor="">
											{__("Class", "team")}
										</label>
										<PGinputText
											value={paginationWrap?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
											onChange={(newVal) => {
												var optionsX = {
													...paginationWrap,
													options: {
														...paginationWrap?.options,
														class: newVal,
													},
												};
												setpaginationWrap(optionsX);
											}}
										/>
									</div>
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={paginationWrap}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(
												sudoScource,
												newVal,
												attr,
												paginationWrap,
												setpaginationWrap
											)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(
												sudoScource,
												key,
												paginationWrap,
												setpaginationWrap
											)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(
												sudoScource,
												key,
												paginationWrap,
												setpaginationWrap
											)
										}
										onReset={(sudoSources) =>
											onResetStyle(
												sudoSources,
												paginationWrap,
												setpaginationWrap
											)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(
												sudoSource,
												cssObj,
												paginationWrap,
												setpaginationWrap
											)
										}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>

						<PanelBody
							className="font-medium text-slate-900 "
							title="Pagination Item"
							initialOpen={false}>
							<PGtabs
								activeTab="options"
								orientation="horizontal"
								activeClass="active-tab"
								onSelect={(tabName) => {}}
								tabs={[
									{
										name: "options",
										title: "Options",
										icon: settings,
										className: "tab-settings",
									},
									{
										name: "styles",
										title: "Styles",
										icon: brush,
										className: "tab-style",
									},
								]}>
								<PGtab name="options">
									<div className="flex  my-5  justify-between items-center">
										<label className="" htmlFor="">
											{__("Class", "team")}
										</label>
										<PGinputText
											value={paginationItem?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
											onChange={(newVal) => {
												var optionsX = {
													...paginationItem,
													options: {
														...paginationItem?.options,
														class: newVal,
													},
												};
												setpaginationItem(optionsX);
											}}
										/>
									</div>
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={paginationItem}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(
												sudoScource,
												newVal,
												attr,
												paginationItem,
												setpaginationItem
											)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(
												sudoScource,
												key,
												paginationItem,
												setpaginationItem
											)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(
												sudoScource,
												key,
												paginationItem,
												setpaginationItem
											)
										}
										onReset={(sudoSources) =>
											onResetStyle(
												sudoSources,
												paginationItem,
												setpaginationItem
											)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(
												sudoSource,
												cssObj,
												paginationItem,
												setpaginationItem
											)
										}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>

						<PanelBody
							className="font-medium text-slate-900 "
							title="pagination Item Active"
							initialOpen={false}>
							<PGtabs
								activeTab="options"
								orientation="horizontal"
								activeClass="active-tab"
								onSelect={(tabName) => {}}
								tabs={[
									{
										name: "options",
										title: "Options",
										icon: settings,
										className: "tab-settings",
									},
									{
										name: "styles",
										title: "Styles",
										icon: brush,
										className: "tab-style",
									},
								]}>
								<PGtab name="options">
									<div className="flex  my-5  justify-between items-center">
										<label className="" htmlFor="">
											{__("Class", "team")}
										</label>
										<PGinputText
											value={paginationItemActive?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
											onChange={(newVal) => {
												var optionsX = {
													...paginationItemActive,
													options: {
														...paginationItemActive?.options,
														class: newVal,
													},
												};
												setpaginationItemActive(optionsX);
											}}
										/>
									</div>
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={paginationItemActive}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(
												sudoScource,
												newVal,
												attr,
												paginationItemActive,
												setpaginationItemActive
											)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(
												sudoScource,
												key,
												paginationItemActive,
												setpaginationItemActive
											)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(
												sudoScource,
												key,
												paginationItemActive,
												setpaginationItemActive
											)
										}
										onReset={(sudoSources) =>
											onResetStyle(
												sudoSources,
												paginationItemActive,
												setpaginationItemActive
											)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(
												sudoSource,
												cssObj,
												paginationItemActive,
												setpaginationItemActive
											)
										}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>
					</PanelBody>
				</>
			)}
		</div>
	);
}

class EditTestimonialCarousel extends Component {
	constructor(props) {
		super(props);
		this.state = { showWarning: true, isLoaded: false };
		this.handleToggleClick = this.handleToggleClick.bind(this);
	}

	handleToggleClick() {
		this.setState((state) => ({
			showWarning: !state.showWarning,
		}));
	}

	render() {
		var { onChange, postData, customerData, addNotifications, setHelp } =
			this.props;

		return (
			<Html
				onChange={onChange}
				addNotifications={addNotifications}
				postData={postData}
				customerData={customerData}
				setHelp={setHelp}
				warn={this.state.showWarning}
				isLoaded={this.state.isLoaded}
			/>
		);
	}
}

export default EditTestimonialCarousel;
