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
					<PanelBody
						className="font-medium text-slate-900 "
						title="Items"
						initialOpen={true}>
						<div className="my-4 flex items-center justify-between ">
							<div className=" flex items-center  gap-2">
								<PGDropdown
									position="bottom right"
									variant="secondary"
									buttonTitle={
										globalOptions?.itemSource == undefined
											? "Item Source"
											: itemSources[globalOptions?.itemSource]?.label
									}
									options={itemSources}
									onChange={(option, index) => {
										var globalOptionsX = { ...globalOptions };
										globalOptionsX.itemSource = option.value;
										setglobalOptions(globalOptionsX);
									}}
									values=""></PGDropdown>
							</div>

							<div className="flex items-center  gap-2">
								{globalOptions?.itemSource == "posts" && (
									<>
										<span
											className="cursor-pointer"
											title="Click to know more"
											onClick={() => {
												setHelp({
													id: "addPostQuery",
													enable: true,
												});
											}}>
											<Icon icon={help} />
										</span>
										<PGDropdown
											position="bottom right"
											variant="secondary"
											buttonTitle={"Add Query"}
											options={postQueryArgs}
											onChange={(option, index) => {
												var itemQueryArgsX = { ...itemQueryArgs };
												itemQueryArgsX[option.id] = {
													id: option.id,
													value: option.value,
												};
												setitemQueryArgs(itemQueryArgsX);
											}}
											values=""></PGDropdown>
									</>
								)}

								{globalOptions?.itemSource == "manual" && (
									<>
										<div className="flex items-center gap-2">
											<span
												className="flex items-center gap-2 bg-slate-700 text-white px-3 py-2 rounded-sm cursor-pointer hover:bg-slate-600"
												title="Click to paste"
												onClick={async () => {
													try {
														// Read text from clipboard
														const clipboardText =
															await navigator.clipboard.readText();

														// Parse the JSON string back to an object
														const pastedItems = JSON.parse(clipboardText);

														// Here you need to handle the pasted items
														// For example, if you have a state setter:
														setitems(pastedItems);

														addNotifications({
															title: "Items Pasted",
															content: "You just pasted items, Now go to edit.",
															type: "success",
														});
													} catch (error) { }
												}}>
												<Icon icon={page} fill="#fff" size="20" />
											</span>
											<span
												className="flex items-center gap-2 bg-slate-700 text-white px-3 py-2 rounded-sm cursor-pointer hover:bg-slate-600"
												title="Click to copy"
												onClick={() => {
													try {
														const itemsString = JSON.stringify(items, null, 2);

														navigator.clipboard
															.writeText(itemsString)
															.then(() => {
																addNotifications({
																	title: "Items Copied",
																	content:
																		"You just copied items, Now go to edit.",
																	type: "success",
																});
															})
															.catch((err) => { });
													} catch (error) { }
												}}>
												<Icon icon={copy} fill="#fff" size="20" />
											</span>
										</div>
										<div
											className="flex items-center gap-2 bg-slate-700 text-white px-3 py-2 rounded-sm cursor-pointer hover:bg-slate-600"
											onClick={(ev) => {
												var itemsX = [...items];

												itemsX.push({
													isActive: false,
													person: {
														name: "",
														avatar: { id: "", srcUrl: "" },
														jobTitle: "",
														comapny: { name: "", website: "", logoUrl: "" },
													},
													rating: 5,
													date: "11/01/2025",
													videoUrl: { type: "", link: "" },
													title: "What is Lorem Ipsum?",

													content:
														"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
													tags: [],
												});
												setitems(itemsX);

												addNotifications({
													title: "Item Added",
													content: "You just added an item, Now go to edit.",
													type: "success",
												});
											}}>
											<Icon icon={addCard} fill="#fff" size="20" />
										</div>
										<div className=" tracking-wide ">
											<div
												className="py-2 px-4 cursor-pointer  capitalize bg-gray-700 text-white font-medium rounded hover:bg-gray-600 focus:outline-none focus:bg-gray-600"
												onClick={(ev) => {
													ev.preventDefault();
													ev.stopPropagation();

													if (isProFeature) {
														addNotifications({
															title: "Opps its pro!",
															content:
																"This feature only avilable in premium version",
															type: "error",
														});
														return;
													}

													setAIWriter(!AIWriter);
												}}>
												AI
											</div>
											{AIWriter && (
												<Popover position="bottom right">
													<div className="w-[800px] p-3 relative">
														<span
															className="cursor-pointer px-1 bg-red-500 hover:bg-red-700 hover:text-white absolute top-0 right-0"
															onClick={(ev) => {
																ev.preventDefault();
																ev.stopPropagation();
																setAIWriter(!AIWriter);
															}}>
															<Icon fill={"#fff"} icon={close} />
														</span>

														<PGcssOpenaiPrompts
															value={""}
															formattedPrompt={formattedPrompt}
															promptsAgs={{
																action: "write",
																aiModel: "gpt-4-turbo",
																objective: "generateFAQ",
															}}
															autoUpdate={AIautoUpdate}
															onResponseLoaded={(value, autoUpdate) => {
																// if (autoUpdate) {
																// 	var options = { ...text.options, content: value };
																// 	setAttributes({ text: { ...text, options: options } });
																// }
															}}
															clickHandle={(value, action) => {
																var valueObj = JSON.parse(value);

																if (action == "prepend") {
																	var itemsX = [...items];

																	var faqX = [];

																	valueObj.map((item) => {
																		var answer = item.answer;
																		var question = item.question;

																		faqX.push({
																			active: 0,
																			hideOnSchema: 0,
																			headerLabelText: question,
																			headerLabelSlug: "",

																			headerLabelToggledText: "",
																			contentText: answer,
																		});
																	});

																	setitems([...faqX, ...itemsX]);

																	addNotifications({
																		title: "Items append",
																		content:
																			"Items append, You can customize now.",
																		type: "success",
																	});
																}
																if (action == "append") {
																	var itemsX = [...items];

																	var faqX = [];

																	valueObj.map((item) => {
																		var answer = item.answer;
																		var question = item.question;

																		faqX.push({
																			active: 0,
																			hideOnSchema: 0,
																			headerLabelText: question,
																			headerLabelSlug: "",

																			headerLabelToggledText: "",
																			contentText: answer,
																		});
																	});

																	setitems([...itemsX, ...faqX]);

																	addNotifications({
																		title: "Items Append",
																		content:
																			"Items append, You can customize now.",
																		type: "success",
																	});
																}
																if (action == "replace") {
																	var itemsX = [...items];

																	var faqX = [];

																	valueObj.map((item) => {
																		var answer = item.answer;
																		var question = item.question;

																		faqX.push({
																			active: 0,
																			hideOnSchema: 0,
																			headerLabelText: question,
																			headerLabelSlug: "",
																			headerLabelToggledText: "",
																			contentText: answer,
																		});
																	});

																	setitems(faqX);

																	addNotifications({
																		title: "Items Added",
																		content:
																			"You just added an item, Now go to edit.",
																		type: "success",
																	});
																}

																//setAttributes({ itemsX: { ...itemsX, items: itemx } });
															}}
														/>
													</div>
												</Popover>
											)}
										</div>
									</>
								)}
							</div>
						</div>
						{globalOptions?.itemSource == "posts" && (
							<div>
								{Object.entries(itemQueryArgs)?.map((prams) => {
									var index = prams[0];
									var item = prams[1];

									return (
										<div key={index} className="my-4 flex gap-2 items-center">
											<span
												className="cursor-pointer px-1 bg-red-500 hover:bg-red-700 hover:text-white"
												onClick={() => handleDelete(item.id)}>
												<Icon fill={"#fff"} icon={close} size="20" />
											</span>
											{item.id == "postType" && (
												<div className="flex items-center justify-between flex-1">
													<label htmlFor="">Post Type</label>
													<PGinputSelect
														val={item.value}
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														options={postTypes}
														multiple={true}
														onChange={(newVal) => {
															updatePostQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
											{item.id == "postStatus" && (
												<div
													className={
														item.id == "postStatus"
															? "flex items-center justify-between flex-1"
															: "hidden"
													}>
													<label htmlFor="">Post Status</label>
													<PGinputSelect
														val={item.value}
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														options={[
															{ label: "Publish", value: "publish" },
															{ label: "Pending", value: "pending" },
															{ label: "Draft", value: "draft" },
															{ label: "Auto draft", value: "auto-draft" },
															{ label: "Future", value: "future" },
															{ label: "Private", value: "private" },
															{ label: "Inherit", value: "inherit" },
															{ label: "Trash", value: "trash" },
															{ label: "Any", value: "any" },
														]}
														multiple={true}
														onChange={(newVal) => {
															updatePostQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
											{item.id == "order" && (
												<div
													className={
														item.id == "order"
															? "flex items-center justify-between flex-1"
															: "hidden"
													}>
													<label htmlFor="">Order</label>
													<PGinputSelect
														label=""
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														val={item.value}
														options={[
															{ label: "Ascending", value: "ASC" },
															{ label: "Descending", value: "DESC" },
														]}
														multiple={false}
														onChange={(newVal) =>
															updatePostQueryArgs(newVal, index)
														}
													/>
												</div>
											)}
											{item.id == "orderby" && (
												<div
													className={
														item.id == "orderby"
															? "flex items-center justify-between flex-1"
															: "hidden"
													}>
													<label htmlFor="">Order By</label>
													<PGinputSelect
														val={item.value}
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														options={[
															{
																label: __("None", "team"),
																value: "none",
															},
															{ label: "ID", value: "ID" },
															{ label: "Author", value: "author" },
															{ label: "Title", value: "title" },
															{ label: "Name", value: "name" },
															{ label: "Type", value: "type" },
															{ label: "Date", value: "date" },
															{ label: "Modified", value: "modified" },
															{ label: "Parent", value: "parent" },
															{ label: "Random", value: "rand" },
															{
																label: "Comment Count",
																value: "comment_count",
															},
															{ label: "Relevance", value: "relevance" },
															{ label: "Menu Order", value: "menu_order" },
															{
																label: "Meta Value(String)",
																value: "meta_value",
															},
															{
																label: "Meta Value(Number)",
																value: "meta_value_num",
															},
															{ label: "post__in", value: "post__in" },
															{
																label: "post_name__in",
																value: "post_name__in",
															},
															{
																label: "post_parent__in",
																value: "post_parent__in",
															},
														]}
														multiple={true}
														onChange={(newVal) => {
															updatePostQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
											{item.id == "metaKey" && (
												<div className="flex items-center justify-between flex-1">
													<label htmlFor="">Meta Key</label>
													<PGinputText
														label=""
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														value={item.value}
														onChange={(newVal) => {
															updatePostQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
											{item.id == "metaValue" && (
												<div className="flex items-center justify-between flex-1">
													<label htmlFor="">Meta Value</label>
													<PGinputText
														label=""
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														value={item.value}
														onChange={(newVal) => {
															updatePostQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
											{item.id == "metaValueNum" && (
												<div className="flex items-center justify-between flex-1">
													<label htmlFor="">Meta Value Number</label>
													<PGinputText
														label=""
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														value={item.value}
														onChange={(newVal) => {
															updatePostQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
											{item.id == "s" && (
												<div className="flex items-center justify-between flex-1">
													<label htmlFor="">Keyword</label>
													<PGinputText
														label=""
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														value={item.value}
														onChange={(newVal) => {
															updatePostQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
											{item.id == "metaCompare" && (
												<div
													className={
														item.id == "metaCompare"
															? "flex items-center justify-between flex-1"
															: "hidden"
													}>
													<label htmlFor="">Meta Compare</label>
													<PGinputSelect
														val={item.value}
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														options={[
															{ label: "=", value: "=" },
															{ label: "!=", value: "!=" },
															{ label: ">", value: ">" },
															{ label: ">=", value: ">=" },
															{ label: "<", value: "<" },
															{ label: "<=", value: "<=" },
															{ label: "LIKE", value: "LIKE" },
															{ label: "NOT LIKE", value: "NOT LIKE" },
															{ label: "IN", value: "IN" },
															{ label: "NOT IN", value: "NOT IN" },
															{ label: "BETWEEN", value: "BETWEEN" },
															{ label: "NOT BETWEEN", value: "NOT BETWEEN" },
															{ label: "NOT EXISTS", value: "NOT EXISTS" },
															{ label: "REGEXP", value: "REGEXP" },
															{ label: "NOT REGEXP", value: "NOT REGEXP" },
															{ label: "RLIKE", value: "RLIKE" },
														]}
														onChange={(newVal) => {
															updatePostQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
										</div>
									);
								})}
							</div>
						)}

						{globalOptions?.itemSource == "manual" && (
							<div>
								<ReactSortable
									list={items}
									handle={".handle"}
									setList={(itemsSorted) => {
										setTimeout(() => {
											setitems(itemsSorted);
										}, 200);

										addNotifications({
											title: "Items Sorted",
											content: "You just sorted items",
											type: "success",
										});
									}}>
									{items?.map((item, index) => {
										return (
											<>
												<div className="" key={index}>
													<div
														className="bg-slate-300 flex justify-between items-center p-3 py-2 my-2 cursor-pointer hover:bg-slate-400"
														onClick={(ev) => {
															setitemActive(index == itemActive ? 999 : index);
														}}>
														<div>{item?.title}</div>
														<div className="flex items-center gap-2">
															<span className="handle  cursor-pointer bg-gray-700 hover:bg-gray-600 hover:text-white px-1 py-1">
																<Icon size="20" fill={"#fff"} icon={menu} />
															</span>
															<span
																className="cursor-pointer bg-gray-700 hover:bg-gray-600 hover:text-white px-1 py-1"
																onClick={(ev) => {
																	ev.stopPropagation();

																	var itemsX = [...items];
																	var itemToDup = { ...itemsX[index] };
																	itemsX.splice(index + 1, 0, itemToDup);
																	setitems(itemsX);

																	addNotifications({
																		title: "Item Duplicated",
																		content: "You just duplicate an item",
																		type: "success",
																	});
																}}>
																<Icon size="20" fill={"#fff"} icon={copy} />
															</span>
															<span
																className="cursor-pointer bg-red-700 hover:bg-red-600 hover:text-white px-1 py-1"
																onClick={(ev) => {
																	ev.stopPropagation();
																	var itemsX = [...items];
																	itemsX.splice(index, 1);
																	setitems(itemsX);

																	addNotifications({
																		title: "Item Removed",
																		content: "You just removed an item",
																		type: "success",
																	});
																}}>
																<Icon size="20" fill={"#fff"} icon={close} />
															</span>
														</div>
													</div>

													{itemActive == index && (
														<div className="py-2 w-full">
															<div className="mb-3">
																<RichText
																	placeholder="Write Header Text..."
																	className="bg-slate-100 p-3 "
																	tagName={"div"}
																	value={item?.title}
																	onChange={(content) => {
																		setitems((prevItems) => {
																			// 																			console.log(item?.headerLabelSlug)

																			// if(!item?.headerLabelSlugLock){

																			// }

																			const updatedItems = [...prevItems];
																			updatedItems[index] = {
																				...updatedItems[index],
																				title: content,
																			};
																			return updatedItems;
																		});
																	}}
																/>
															</div>
															<div className="mb-3">
																<WPEditor
																	placeholder="Write Header Text..."
																	editorId={`content-${index}-${generate3Digit()}`}
																	className={`bg-slate-100 p-3 min-h-24 w-full`}
																	value={unescapeHTML(item?.content)}
																	onChange={(content) => {
																		content = content.replace(/[\r\n]+/g, "");
																		content = escapeHTML(content);

																		//var content = JSON.stringify(content);
																		console.log(content);
																		setitems((prevItems) => {
																			const updatedItems = [...prevItems];
																			updatedItems[index] = {
																				...updatedItems[index],
																				content: content,
																			};
																			return updatedItems;
																		});
																	}}
																/>
															</div>

															<div className="mb-3 space-y-3">
																<div className="w-full flex justify-between items-center">
																	<div className="mb-2">Date</div>
																	<div className="flex items-center gap-2">
																		<span
																			className="flex items-center gap-2 bg-slate-700 text-white px-3 py-2 rounded-sm cursor-pointer hover:bg-slate-600"
																			title="Date Picker"
																			onClick={() => {
																				setdatePicker(index);
																			}}>
																			<Icon
																				icon={calendar}
																				fill="#fff"
																				size="20"
																			/>
																		</span>

																		{/* <PGDatePicker
																			value={item?.date}
																			onChange={
																				(newVal) => console.log(newVal)
																				//setDate(newVal)
																			}
																		/> */}
																		{datePicker == index && (
																			<Popover position="bottom right">
																				<div className="p-2 rounded-md">
																					<DateTimePicker
																						currentDate={item?.date}
																						onChange={(newDate) => {
																							const timestamp = newDate;
																							const date =
																								timestamp.split("T")[0];
																							setitems((prevItems) => {
																								const updatedItems = [
																									...prevItems,
																								];
																								updatedItems[index] = {
																									...updatedItems[index],
																									date: date,
																								};
																								return updatedItems;
																							});
																						}}
																						is12Hour={true}
																					/>
																				</div>
																			</Popover>
																		)}
																	</div>
																</div>
																<div className="w-full flex justify-between items-center">
																	<div className="mb-2">Rating</div>
																	<div className="flex items-center gap-2">
																		{[1, 2, 3, 4, 5].map((star) => (
																			<span
																				className="size-5"
																				key={star}
																				onClick={() => {
																					setitems((prevItems) => {
																						const updatedItems = [...prevItems];
																						updatedItems[index] = {
																							...updatedItems[index],
																							rating: star,
																						};
																						return updatedItems;
																					});
																				}}>
																				<Icon
																					icon={
																						star > item?.rating
																							? starEmpty
																							: starFilled
																					}
																					fill="gold"
																					size="24"
																				/>
																			</span>
																		))}
																	</div>
																</div>
																<div className="w-full flex justify-between items-center">
																	<div className="mb-2">Video Type</div>
																	<div className="flex items-center gap-2">
																		<PGDropdown
																			position="bottom right"
																			variant="secondary"
																			buttonTitle={
																				videoType[item?.videoUrl.type] ==
																					undefined
																					? __("Choose", "team")
																					: videoType[item?.videoUrl.type].label
																			}
																			options={videoType}
																			onChange={(newVal) => {
																				setitems((prevItems) => {
																					const updatedItems = [...prevItems];
																					updatedItems[index] = {
																						...updatedItems[index],
																						videoUrl: {
																							...updatedItems[index].videoUrl,
																							type: newVal.value,
																						},
																					};
																					return updatedItems;
																				});
																			}}
																			values=""></PGDropdown>
																	</div>
																</div>
																<div className="w-full flex justify-between items-center">
																	<div className="mb-2">Video Url</div>
																	<div className="flex items-center gap-2">
																		<PGinputText
																			className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-full "
																			label=""
																			value={item?.videoUrl.link}
																			onChange={(newVal) => {
																				// if (isProFeature) {
																				// 	addNotifications({
																				// 		title: "Opps its pro!",
																				// 		content:
																				// 			"This feature only avilable in premium version",
																				// 		type: "error",
																				// 	});
																				// 	return;
																				// }
																				setitems((prevItems) => {
																					const updatedItems = [...prevItems];
																					updatedItems[index] = {
																						...updatedItems[index],
																						videoUrl: {
																							...updatedItems[index].videoUrl,
																							link: newVal,
																						},
																					};
																					return updatedItems;
																				});
																			}}
																		/>
																	</div>
																</div>
																<div className="w-full flex justify-between items-center">
																	<div className="">Person Name</div>
																	<div className="flex items-center gap-2">
																		<PGinputText
																			className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-full "
																			label=""
																			value={item?.person.name}
																			onChange={(newVal) => {
																				setitems((prevItems) => {
																					const updatedItems = [...prevItems];
																					updatedItems[index] = {
																						...updatedItems[index],
																						person: {
																							...updatedItems[index].person,
																							name: newVal,
																						},
																					};
																					return updatedItems;
																				});
																			}}
																		/>
																	</div>
																</div>
																<div className="w-full flex justify-between items-center">
																	<div className="">Job Title</div>
																	<div className="flex items-center gap-2">
																		<PGinputText
																			className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-full "
																			label=""
																			value={item?.person.jobTitle}
																			onChange={(newVal) => {
																				setitems((prevItems) => {
																					const updatedItems = [...prevItems];
																					updatedItems[index] = {
																						...updatedItems[index],
																						person: {
																							...updatedItems[index].person,
																							jobTitle: newVal,
																						},
																					};
																					return updatedItems;
																				});
																			}}
																		/>
																	</div>
																</div>
																<div className="flex my-5 justify-between items-center ">
																	<label className="w-[400px]" htmlFor="">
																		{__("Avatar", "user-verification")}
																	</label>
																	<MediaUpload
																		onSelect={(media) => {
																			setitems((prevItems) => {
																				const updatedItems = [...prevItems];
																				updatedItems[index] = {
																					...updatedItems[index],
																					person: {
																						...updatedItems[index].person,
																						avatar: {
																							id: media.id,
																							srcUrl: media.url,
																						},
																					},
																				};
																				return updatedItems;
																			});
																		}}
																		onClose={() => { }}
																		allowedTypes={ALLOWED_MEDIA_TYPES}
																		value={item?.person.avatar.id}
																		render={({ open }) => {
																			return (
																				<div className="flex flex-col items-center gap-2">
																					{item?.person.avatar.srcUrl && (
																						<img
																							src={item?.person.avatar.srcUrl}
																							alt=""
																							className="cursor-pointer rounded-md max-w-[160px] max-h-[160px] object-contain border border-solid border-gray-300 p-1"
																							onClick={() => {
																								open();
																							}}
																						/>
																					)}
																					<div className="flex items-center gap-2">
																						<button
																							onClick={open}
																							className="no-underline px-4 py-2 rounded-sm bg-gray-700 hover:bg-gray-700 text-white  whitespace-nowrap  hover:text-white">
																							Open Media Library
																						</button>
																						<button
																							onClick={() => {
																								setitems((prevItems) => {
																									const updatedItems = [
																										...prevItems,
																									];
																									updatedItems[index] = {
																										...updatedItems[index],
																										person: {
																											...updatedItems[index]
																												.person,
																											avatar: {
																												id: "",
																												srcUrl: "",
																											},
																										},
																									};
																									return updatedItems;
																								});
																							}}
																							className="no-underline size-[38px] flex items-center justify-center text-[30px] rounded-sm !border !bg-transparent !border-solid !border-gray-700 hover:!border-red-700 text-gray-700   hover:text-red-700"
																							title="Clear Logo">
																							&times;
																						</button>
																					</div>
																				</div>
																			);
																		}}></MediaUpload>
																</div>
																<div className="w-full flex justify-between items-center">
																	<div className="">Company Name</div>
																	<div className="flex items-center gap-2">
																		<PGinputText
																			className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-full "
																			label=""
																			value={item?.person.company.name}
																			onChange={(newVal) => {
																				setitems((prevItems) => {
																					const updatedItems = [...prevItems];
																					updatedItems[index] = {
																						...updatedItems[index],
																						person: {
																							...updatedItems[index].person,
																							company: {
																								...updatedItems[index].person
																									.company,
																								name: newVal,
																							},
																						},
																					};
																					return updatedItems;
																				});
																			}}
																		/>
																	</div>
																</div>
																<div className="w-full flex justify-between items-center">
																	<div className="">Company Website</div>
																	<div className="flex items-center gap-2">
																		<PGinputText
																			className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-full "
																			label=""
																			value={item?.person.company.website}
																			onChange={(newVal) => {
																				setitems((prevItems) => {
																					const updatedItems = [...prevItems];
																					updatedItems[index] = {
																						...updatedItems[index],
																						person: {
																							...updatedItems[index].person,
																							company: {
																								...updatedItems[index].person
																									.company,
																								website: newVal,
																							},
																						},
																					};
																					return updatedItems;
																				});
																			}}
																		/>
																	</div>
																</div>
																<div className="flex my-5 justify-between items-center ">
																	<label className="w-[400px]" htmlFor="">
																		{__("Company logo", "user-verification")}
																	</label>
																	<MediaUpload
																		onSelect={(media) => {
																			setitems((prevItems) => {
																				const updatedItems = [...prevItems];
																				updatedItems[index] = {
																					...updatedItems[index],
																					person: {
																						...updatedItems[index].person,
																						company: {
																							...updatedItems[index].person
																								.company,
																							logoUrl: {
																								id: media.id,
																								srcUrl: media.url,
																							},
																						},
																					},
																				};
																				return updatedItems;
																			});
																		}}
																		onClose={() => { }}
																		allowedTypes={ALLOWED_MEDIA_TYPES}
																		value={item?.person.company.logoUrl.id}
																		render={({ open }) => {
																			return (
																				<div className="flex flex-col items-center gap-2">
																					{item?.person.company.logoUrl
																						.srcUrl && (
																							<img
																								src={
																									item?.person.company.logoUrl
																										.srcUrl
																								}
																								alt=""
																								className="cursor-pointer rounded-md max-w-[160px] max-h-[160px] object-contain border border-solid border-gray-300 p-1"
																								onClick={() => {
																									open();
																								}}
																							/>
																						)}
																					<div className="flex items-center gap-2">
																						<button
																							onClick={open}
																							className="no-underline px-4 py-2 rounded-sm bg-gray-700 hover:bg-gray-700 text-white  whitespace-nowrap  hover:text-white">
																							Open Media Library
																						</button>
																						<button
																							onClick={() => {
																								setitems((prevItems) => {
																									const updatedItems = [
																										...prevItems,
																									];
																									updatedItems[index] = {
																										...updatedItems[index],
																										person: {
																											...updatedItems[index]
																												.person,
																											company: {
																												...updatedItems[index]
																													.person.company,
																												logoUrl: {
																													id: "",
																													srcUrl: "",
																												},
																											},
																										},
																									};
																									return updatedItems;
																								});
																							}}
																							className="no-underline size-[38px] flex items-center justify-center text-[30px] rounded-sm !border !bg-transparent !border-solid !border-gray-700 hover:!border-red-700 text-gray-700   hover:text-red-700"
																							title="Clear Logo">
																							&times;
																						</button>
																					</div>
																				</div>
																			);
																		}}></MediaUpload>
																</div>
																{/* // */}
															</div>
														</div>
													)}
												</div>
											</>
										);
									})}
								</ReactSortable>
							</div>
						)}
					</PanelBody>
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
							onSelect={(tabName) => { }}
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
												content:
													"Layout Copied!",
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
												content:
													"Layout paste successful.",
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
							onSelect={(tabName) => { }}
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
							onSelect={(tabName) => { }}
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
							onSelect={(tabName) => { }}
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
								onSelect={(tabName) => { }}
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
								onSelect={(tabName) => { }}
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
								onSelect={(tabName) => { }}
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
								onSelect={(tabName) => { }}
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
								onSelect={(tabName) => { }}
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
								onSelect={(tabName) => { }}
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
								onSelect={(tabName) => { }}
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
												paginationTypes[paginationWrap.options.type] != undefined
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
								onSelect={(tabName) => { }}
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
								onSelect={(tabName) => { }}
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
