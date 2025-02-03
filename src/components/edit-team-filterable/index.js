const { Component, RawHTML, useState, useEffect } = wp.element;
import apiFetch from "@wordpress/api-fetch";
import { store as coreStore } from "@wordpress/core-data";
import { useSelect } from "@wordpress/data";
import { __ } from "@wordpress/i18n";
import { ReactSortable } from "react-sortablejs";

import { MediaUpload, RichText } from "@wordpress/block-editor";
import {
	Button,
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

	var [teamData, setteamData] = useState(postData.post_content); // Using the hook.

	var [globalOptions, setglobalOptions] = useState(teamData.globalOptions); // Using the hook.

	var [itemQueryArgs, setitemQueryArgs] = useState(teamData.itemQueryArgs); // Using the hook.

	var [wrapper, setwrapper] = useState(teamData.wrapper); // Using the hook.
	var [items, setitems] = useState(teamData.items); // Using the hook.
	var [content, setcontent] = useState(teamData.content);
	var [accOptions, setaccOptions] = useState(teamData.accOptions);

	var [itemsWrap, setitemsWrap] = useState(teamData.itemsWrap);
	var [item, setitem] = useState(teamData.item);
	var [paginationWrap, setpaginationWrap] = useState(
		teamData.paginationWrap
	);
	var [paginationItem, setpaginationItem] = useState(
		teamData.paginationItem
	);
	var [paginationItemActive, setpaginationItemActive] = useState(
		teamData.paginationItemActive
	);
	var [labelCounter, setlabelCounter] = useState(teamData.labelCounter);
	var [labelIcon, setlabelIcon] = useState(teamData.labelIcon);
	var [icon, seticon] = useState(teamData.icon);
	var [iconToggle, seticonToggle] = useState(teamData.iconToggle);

	var [prev, setprev] = useState(teamData?.prev);
	var [prevIcon, setprevIcon] = useState(teamData?.prevIcon);
	var [next, setnext] = useState(teamData?.next);
	var [nextIcon, setnextIcon] = useState(teamData?.nextIcon);
	var [sliderOptions, setsliderOptions] = useState(
		teamData?.sliderOptions
	);
	var [isBusy, setIsBusy] = useState(false);
	const [filterableTerms, setFilterableTerms] = useState([]);

	var [sliderOptionsRes, setsliderOptionsRes] = useState(
		teamData?.sliderOptionsRes
	);

	var [filterable, setfilterable] = useState(teamData.filterable);
	var [activeFilter, setactiveFilter] = useState(teamData.activeFilter);
	var [filterGroupWrap, setfilterGroupWrap] = useState(
		teamData.filterGroupWrap
	);
	var [filterGroup, setfilterGroup] = useState(teamData.filterGroup);

	var [topWrap, settopWrap] = useState(teamData.topWrap);
	var [navsWrap, setnavsWrap] = useState(teamData?.navsWrap);
	var [navItem, setnavItem] = useState(teamData?.navItem);
	var [activeNavItem, setactiveNavItem] = useState(
		teamData?.activeNavItem
	);
	var [navLabel, setnavLabel] = useState(teamData?.navLabel);
	var [panelWrap, setpanelWrap] = useState(teamData?.panelWrap);
	var [panelWrapActive, setpanelWrapActive] = useState(
		teamData?.panelWrapActive
	);

	var [styleObj, setstyleObj] = useState({}); // Using the hook.
	const [taxonomiesObjects, setTaxonomiesObjects] = useState([]);
	var [customerData, setcustomerData] = useState(props.customerData);
	var [datePicker, setdatePicker] = useState(9999999);

	var [isProFeature, setisProFeature] = useState(true);

	const gapValue = accOptions?.gap || "0px";
	const [number, setNumber] = useState(parseInt(gapValue));
	const [unit, setUnit] = useState(gapValue.replace(number, ""));
	const [itemActive, setitemActive] = useState(99999);
	const [AIautoUpdate, setAIautoUpdate] = useState(false);
	var [AIWriter, setAIWriter] = useState(false); // Using the hook.
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
		apiFetch({
			path: "/team/v2/post_type_objects",
			method: "POST",
			data: { postTypes: [] },
		}).then((res) => {
			var taxonomies = [];
			res.map((item) => {
				taxonomies.push({ label: item.label, value: item.id });
			});
			setTaxonomiesObjects(taxonomies);
		});
	}, []);

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
		teamDataX.accOptions = accOptions;
		setteamData(teamDataX);
	}, [accOptions]);

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
		teamDataX.filterable = filterable;
		setteamData(teamDataX);
	}, [filterable]);

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
		teamDataX.activeNavItem = activeNavItem;
		setteamData(teamDataX);
	}, [activeNavItem]);

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.navLabel = navLabel;
		setteamData(teamDataX);
	}, [navLabel]);

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.panelWrap = panelWrap;
		setteamData(teamDataX);
	}, [panelWrap]);

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.content = content;
		setteamData(teamDataX);
	}, [content]);

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.labelCounter = labelCounter;
		setteamData(teamDataX);
	}, [labelCounter]);

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.labelIcon = labelIcon;
		setteamData(teamDataX);
	}, [labelIcon]);

	// useEffect(() => {
	// 	var teamDataX = { ...teamData };
	// 	teamDataX.icon = icon;
	// 	setteamData(teamDataX);
	// }, [icon]);

	// useEffect(() => {
	// 	var teamDataX = { ...teamData };
	// 	teamDataX.iconToggle = iconToggle;
	// 	setteamData(teamDataX);
	// }, [iconToggle]);

	useEffect(() => {
		setteamData((prevData) => ({
			...prevData,
			icon,
			iconToggle,
		}));
	}, [icon, iconToggle]);

	const updateIconOptions = (icon, itemSrc) => ({
		...icon,
		options: {
			...icon.options,
			iconSrc: itemSrc,
		},
	});

	const handleClick = (item) => {
		seticon((prevIcon) => updateIconOptions(prevIcon, item.icon));
		seticonToggle((prevIconToggle) =>
			updateIconOptions(prevIconToggle, item.toggle)
		);
	};

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.topWrap = topWrap;
		setteamData(teamDataX);
	}, [topWrap]);

	var RemoveSliderArg = function ({ index }) {
		return (
			<span
				className="cursor-pointer hover:bg-red-500 hover:text-white "
				onClick={(ev) => {
					var sliderOptionsX = { ...accOptions };
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
	var termQueryArgs = {
		taxonomy: {
			value: "category",

			id: "taxonomy",
			label: __("Taxonomy", "team"),
			description: "Select Taxonomy to Query",
			longDescription:
				"Taxonomy name, or array of taxonomy names, to which results should be limited.",
		},
		orderby: {
			value: "name",

			id: "orderby",
			label: "Order By",
			description: "Search keyword, ex: hello",
		},
		order: {
			value: "ASC",

			id: "order",
			label: "Order",
			description: "Whether to order terms in ascending or descending order.",
		},
		hide_empty: {
			value: true,

			id: "hide_empty",
			label: "Hide Empty",
			description: "Accepts true or false value.",
			longDescription:
				"Whether to hide terms not assigned to any posts. Accepts 1|true or 0|false.",
		},
		number: {
			value: false,

			id: "number",
			label: "Number",
			description: "Accepts 0 (all) or any positive number.",
			longDescription:
				"Maximum number of terms to return. Accepts ''|0 (all) or any positive number. Default ''|0 (all). Note that $number may not return accurate results when coupled with $object_ids.",
		},
		include: {
			value: "category",

			id: "include",
			//isPro: true,
			label: "Include",
			description: "Comma-separated string of term IDs to include.",
			longDescription:
				"Array or comma/space-separated string of term IDs to include. Default empty array.",
			placeholder: "Comma-separated string of term IDs to include.",
		},
		exclude: {
			value: "",

			id: "exclude",
			//isPro: true,
			label: "Exclude",
			description: "Comma-separated string of term IDs to exclude.",
			longDescription:
				"Array or comma/space-separated string of term IDs to exclude. If $include is non-empty, $exclude is ignored. Default empty array.",
			placeholder: "Comma-separated string of term IDs to exclude.",
		},
		child_of: {
			value: "",

			id: "child_of",
			//isPro: true,
			label: "Child of",
			description: "Term ID to retrieve child terms of.",
			longDescription:
				"Term ID to retrieve child terms of. If multiple taxonomies are passed, $child_of is ignored. Default 0.",
		},
		parent: {
			value: "",

			id: "parent",
			//isPro: true,
			label: "Parent",
			description:
				"Add {ID} to add Parent term ID to retrieve direct-child terms of.",
			longDescription: "Parent term ID to retrieve direct-child terms of.",
		},
		meta_key: {
			value: "",

			id: "meta_key",
			//isPro: true,
			label: "Meta key",
			description: "Comma-separated keys to return term(s) for.",
			longDescription: "Meta key or keys to filter by.",
		},
		meta_value: {
			value: "",

			id: "meta_value",
			//isPro: true,
			label: "Meta value",
			description: "Comma-separated keys to return term(s) for.",
			longDescription: "Meta value or values to filter by.",
		},
	};

	const handleDelete = (id) => {
		// Filter out the item with the specified id
		const updatedItems = Object.fromEntries(
			Object.entries(itemQueryArgs).filter(([key, item]) => item.id !== id)
		);
		setitemQueryArgs(updatedItems);
	};

	const updateTermQueryArgs = (newVal, index) => {
		var itemQueryArgsX = [...itemQueryArgs];
		itemQueryArgsX[index].value = newVal;
		setitemQueryArgs(itemQueryArgsX);
	};

	var itemSources = {
		manual: { label: "Manual", value: "manual" },
		posts: {
			label: "Posts",
			value: "posts",
			isPro: customerData.isPro ? false : true,
		},
		// terms: {
		// 	label: "Terms",
		// 	value: "terms",
		// 	isPro: customerData.isPro ? false : true,
		// },
	};

	function generate3Digit() {
		return Math.floor(100 + Math.random() * 900);
	}

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

	return (
		<div className="">
			<div
				className="hidden"
				onClick={() => {
					var str = `{
				"wrapper":${JSON.stringify(wrapper)},
				"navItem":${JSON.stringify(navItem)},
				"activeNavItem":${JSON.stringify(activeNavItem)},
				"labelCounter":${JSON.stringify(labelCounter)},
				"labelIcon":${JSON.stringify(labelIcon)},
				"icon":${JSON.stringify(icon)},
				"iconToggle":${JSON.stringify(iconToggle)},
				"navLabel":${JSON.stringify(navLabel)},
				"panelWrap":${JSON.stringify(panelWrap)},
				"topWrap":${JSON.stringify(topWrap)},
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
					<div>{`"activeNavItem":${JSON.stringify(activeNavItem)}`},</div>
					<div>{`"labelCounter":${JSON.stringify(labelCounter)}`},</div>
					<div>{`"labelIcon":${JSON.stringify(labelIcon)}`},</div>
					<div>{`"icon":${JSON.stringify(icon)}`},</div>
					<div>{`"iconToggle":${JSON.stringify(iconToggle)}`},</div>
					<div>{`"navLabel":${JSON.stringify(navLabel)}`},</div>
					<div>{`"panelWrap":${JSON.stringify(panelWrap)}`},</div>
					<div>{`"panelWrapActive":${JSON.stringify(panelWrapActive)}`},</div>
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
								{globalOptions?.itemSource == "terms" && (
									<>
										<span
											className="cursor-pointer"
											title="Click to know more"
											onClick={() => {
												setHelp({
													id: "addTermQuery",
													enable: true,
												});
											}}>
											<Icon icon={help} />
										</span>
										<PGDropdown
											position="bottom right"
											variant="secondary"
											buttonTitle={"Add Query"}
											options={termQueryArgs}
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
								{globalOptions?.itemSource == "easyTestimonial" && (
									<>
										<span
											className="cursor-pointer"
											title="Click to know more"
											onClick={() => {
												setHelp({
													id: "addTermQuery",
													enable: true,
												});
											}}>
											<Icon icon={help} />
										</span>
										<PGDropdown
											position="bottom right"
											variant="secondary"
											buttonTitle={"Add Query"}
											options={easyTestimonialQueryArgs}
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
																			labelIcon: {
																				options: {
																					library: "fontAwesome",
																					srcType: "class",
																					iconSrc: "",
																				},
																				styles: {},
																			},
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
																			labelIcon: {
																				options: {
																					library: "fontAwesome",
																					srcType: "class",
																					iconSrc: "",
																				},
																				styles: {},
																			},
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
																			labelIcon: {
																				options: {
																					library: "fontAwesome",
																					srcType: "class",
																					iconSrc: "",
																				},
																				styles: {},
																			},
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
						{globalOptions?.itemSource == "terms" && (
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
											{item.id == "taxonomy" && (
												<div className="flex items-center justify-between flex-1">
													<label htmlFor="">Taxonomy</label>
													<PGinputSelect
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														val={item.value}
														options={taxonomiesObjects}
														multiple={true}
														onChange={(newVal) => {
															var itemQueryArgsX = { ...itemQueryArgs };
															itemQueryArgsX[index].value = newVal;
															setitemQueryArgs(itemQueryArgsX);

															//updatePostQueryArgs(newVal, item.id);
														}}
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
															updateTermQueryArgs(newVal, item.id);
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
											{item.id == "number" && (
												<div
													className={
														item.id == "number"
															? "flex items-center justify-between flex-1"
															: "hidden"
													}>
													<label htmlFor="">Number</label>
													<PGinputNumber
														label=""
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														value={item.value}
														onChange={(newVal) => {
															updateTermQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
											{item.id == "include" && (
												<div
													className={
														item.id == "include"
															? "flex items-center justify-between flex-1"
															: "hidden"
													}>
													<label htmlFor="">Include</label>
													<PGinputText
														label=""
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														value={item.value}
														onChange={(newVal) => {
															updateTermQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
											{item.id == "exclude" && (
												<div
													className={
														item.id == "exclude"
															? "flex items-center justify-between flex-1"
															: "hidden"
													}>
													<label htmlFor="">Exclude</label>
													<PGinputText
														label=""
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														value={item.value}
														onChange={(newVal) => {
															updateTermQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
											{item.id == "child_of" && (
												<div
													className={
														item.id == "child_of"
															? "flex items-center justify-between flex-1"
															: "hidden"
													}>
													<label htmlFor="">Child Of</label>
													<PGinputText
														label=""
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														value={item.value}
														onChange={(newVal) => {
															updateTermQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
											{item.id == "parent" && (
												<div
													className={
														item.id == "parent"
															? "flex items-center justify-between flex-1"
															: "hidden"
													}>
													<label htmlFor="">Parent</label>
													<PGinputText
														label=""
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														value={item.value}
														onChange={(newVal) => {
															updateTermQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
											{item.id == "meta_key" && (
												<div
													className={
														item.id == "meta_key"
															? "flex items-center justify-between flex-1"
															: "hidden"
													}>
													<label htmlFor="">Meta Key</label>
													<PGinputText
														label=""
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														value={item.value}
														onChange={(newVal) => {
															updateTermQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
											{item.id == "meta_value" && (
												<div
													className={
														item.id == "meta_value"
															? "flex items-center justify-between flex-1"
															: "hidden"
													}>
													<label htmlFor="">Meta Value</label>
													<PGinputText
														label=""
														className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[200px]"
														value={item.value}
														onChange={(newVal) => {
															updateTermQueryArgs(newVal, item.id);
														}}
													/>
												</div>
											)}
											{item.id == "hide_empty" && (
												<div
													className={
														item.id == "hide_empty"
															? "flex items-center justify-between flex-1"
															: "hidden"
													}>
													<label htmlFor="">Hide Empty</label>
													<InputToggle
														value={item?.value}
														onChange={() => {
															const newValue = !itemQueryArgs[index].value;
															updateTermQueryArgs(newValue, index);
														}}
													/>
												</div>
											)}
										</div>
									);
								})}
							</div>
						)}

						{globalOptions?.itemSource == "easyTestimonial" && (
							<div>
								{Object.entries(itemQueryArgs)?.map((prams) => {
									var index = prams[0];
									var item = prams[1];

									return (
										<div key={index} className="my-4">
											{item.id == "postId" && (
												<div className={`flex items-center justify-between`}>
													<label htmlFor="">FAQ Group ID</label>
													<InputControl
														value={item.value}
														type="number"
														onChange={(newVal) => {
															updateTermQueryArgs(newVal, item.id);
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

															{/* <div className="mb-3">
																<PanelRow>
																	<label
																		htmlFor=""
																		className="font-medium text-slate-900 ">
																		{__("Label Icon", "team")}
																	</label>
																	<PGIconPicker
																		library={item?.labelIcon?.options?.library}
																		srcType={item?.labelIcon?.options?.srcType}
																		iconSrc={item?.labelIcon?.options?.iconSrc}
																		onChange={(arg) => {
																			if (isProFeature) {
																				addNotifications({
																					title: "Opps its pro!",
																					content:
																						"This feature only avilable in premium version",
																					type: "error",
																				});
																				return;
																			}

																			setitems((prevItems) => {
																				const updatedItems = [...prevItems];
																				updatedItems[index] = {
																					...updatedItems[index],
																					labelIcon: {
																						...updatedItems[index].labelIcon,
																						options: {
																							...updatedItems[index]?.labelIcon
																								?.options,
																							srcType: arg.srcType,
																							library: arg.library,
																							iconSrc: arg.iconSrc,
																						},
																					},
																				};
																				return updatedItems;
																			});
																		}}
																	/>
																</PanelRow>

																<div className="w-full">
																	<div className="mb-2">Slug</div>
																	<div className="flex items-center gap-2">
																		<PGinputText
																			className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-full "
																			label=""
																			value={item?.headerLabelSlug}
																			onChange={(newVal) => {
																				if (isProFeature) {
																					addNotifications({
																						title: "Opps its pro!",
																						content:
																							"This feature only avilable in premium version",
																						type: "error",
																					});
																					return;
																				}

																				setitems((prevItems) => {
																					const updatedItems = [...prevItems];
																					updatedItems[index] = {
																						...updatedItems[index],
																						headerLabelSlug: newVal,
																					};
																					return updatedItems;
																				});
																			}}
																		/>

																		<div
																			title="Generate from Label"
																			className="cursor-pointer rounded-sm bg-gray-700 hover:bg-gray-600 hover:text-white px-1 py-1"
																			onClick={(ev) => {
																				var slug = item?.headerLabelText
																					.toLowerCase()
																					.replaceAll(" ", "-");

																				setitems((prevItems) => {
																					const updatedItems = [...prevItems];
																					updatedItems[index] = {
																						...updatedItems[index],
																						headerLabelSlug: slug,
																					};
																					return updatedItems;
																				});
																			}}>
																			<Icon fill={"#fff"} icon={update} />
																		</div>
																	</div>
																</div>
															</div> */}
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
					{/* // */}
					<PanelBody
						className="font-medium text-slate-900 "
						title={__("Filterable", "post-grid")}
						initialOpen={false}>
						<div>
							<Button
								variant="secondary"
								className="mb-2 pg-font flex gap-2 justify-center mx-auto cursor-pointer py-2 px-4 capitalize  !bg-gray-700 !text-white font-medium !rounded hover:bg-gray-600 hover:text-white focus:outline-none focus:bg-gray-600"
								onClick={(ev) => {
									var filters = filterable.options.filters.concat({
										groupTitle: "",
										type: "",
										logic: "",
										showPostCount: "",
										items: [],
									});
									var options = { ...filterable.options, filters: filters };
									setfilterable({ ...filterable, options: options });
								}}>
								{__("Add Filter Group", "post-grid")}
							</Button>
							<div className="flex items-center justify-center gap-3 mb-4 ">
								<div
									className="pg-font cursor-pointer py-1 px-2 flex items-center gap-1 capitalize tracking-wide bg-gray-700 text-white font-medium rounded hover:bg-gray-600 hover:text-white focus:outline-none focus:bg-gray-700 "
									onClick={() => {
										open;
										copyData(filterable.options.filters);
									}}>
									<Icon icon={copy} className="fill-white " size={14} />
									{__("Copy", "post-grid")}
								</div>
								<div
									className="pg-font cursor-pointer py-1 px-2 flex items-center gap-1 capitalize tracking-wide bg-gray-700 text-white font-medium rounded hover:bg-gray-600 hover:text-white focus:outline-none focus:bg-gray-700 "
									onClick={() => {
										open;
										pasteData();
									}}>
									<Icon icon={pages} className="fill-white " size={14} />
									{__("Paste", "post-grid")}
								</div>
							</div>

							{filterable.options.filters.map((x, i) => {
								return (
									<PanelBody
										title={
											<>
												<span
													onClick={(ev) => {
														filterable.options.filters.splice(i, 1);
														var options = {
															...filterable.options,
															filters: filterable.options.filters,
														};
														setfilterable({ ...filterable, options: options });
													}}
													className="hover:bg-red-500 bg-red-400 py-1 px-[10px] text-lg leading-normal cursor-pointer mr-2 ">
													{/* <span className="dashicon  dashicons-no-alt"></span>{" "}
												{__("Delete Group", "post-grid")} */}
													&times;
												</span>
												{x.groupTitle ? x.groupTitle : "Filter Group " + i}
											</>
										}
										initialOpen={false}>
										<PanelRow>
											<label htmlFor="" className="font-medium text-slate-900 ">
												{__("Group Title", "post-grid")}
											</label>
											<InputControl
												value={x.groupTitle}
												onChange={(newVal) => {
													filterable.options.filters[i].groupTitle = newVal;
													var options = {
														...filterable.options,
														filters: filterable.options.filters,
													};
													setfilterable({ ...filterable, options: options });
												}}
											/>
										</PanelRow>
										<PanelRow>
											<label htmlFor="" className="font-medium text-slate-900 ">
												{__("Group Type", "post-grid")}
											</label>
											<SelectControl
												value={x.type}
												options={[
													{ value: "inline", label: "Inline" },
													{ value: "dropdown", label: "Dropdown" },
													{ value: "radio", label: "Radio" },
													{ value: "checkbox", label: "Checkbox" },
												]}
												onChange={(newVal) => {
													filterable.options.filters[i].type = newVal;
													var options = {
														...filterable.options,
														filters: filterable.options.filters,
													};
													setfilterable({ ...filterable, options: options });
												}}
											/>
										</PanelRow>
										<PanelRow>
											<label htmlFor="" className="font-medium text-slate-900 ">
												{__("Data Logic", "post-grid")}
											</label>
											<SelectControl
												value={x.logic}
												options={[
													{ value: "or", label: "OR" },
													{ value: "and", label: "AND" },
												]}
												onChange={(newVal) => {
													filterable.options.filters[i].logic = newVal;
													var options = {
														...filterable.options,
														filters: filterable.options.filters,
													};
													setfilterable({ ...filterable, options: options });
												}}
											/>
										</PanelRow>
										<PanelRow>
											<label htmlFor="" className="font-medium text-slate-900 ">
												{__("Show Post Count", "post-grid")}
											</label>
											<SelectControl
												value={x.showPostCount}
												options={[
													{ value: "no", label: "No" },
													{ value: "yes", label: "Yes" },
												]}
												onChange={(newVal) => {
													filterable.options.filters[i].showPostCount = newVal;
													var options = {
														...filterable.options,
														filters: filterable.options.filters,
													};
													setfilterable({ ...filterable, options: options });
												}}
											/>
										</PanelRow>
										<label
											for=""
											className="font-medium text-slate-900 my-3 font-bold">
											{__("Search Terms", "post-grid")}
										</label>
										<p>
											{
												("To add custom filter please use following format and hit Enter",
													"post-grid")
											}
										</p>
										<code>Filter Name|filter-slug|15</code>
										<InputControl
											autoComplete="off"
											className="my-3"
											placeholder="Search Categories or terms"
											value=""
											onKeyPress={(ev) => {
												if (ev.key === "Enter") {
													var filterParts = ev.target.value.split("|");
													var ss = filterable.options.filters[i].items.concat({
														id: 0,
														slug: filterParts[1],
														title: filterParts[0],
														count: filterParts[2],
													});
													filterable.options.filters[i].items = ss;
													var options = {
														...filterable.options,
														filters: filterable.options.filters,
													};
													setfilterable({ ...filterable, options: options });
												}
											}}
											onChange={(newVal) => {
												clearTimeout(debounce);
												debounce = setTimeout(() => {
													if (newVal.length > 0) {
														fetchPostTypeTerms(newVal);
													}
												}, 2000);
											}}
										/>
										{x.items.length == 0 && (
											<div className="my-1">
												{__("No terms added.", "post-grid")}
											</div>
										)}
										{x.items.map((y, j) => {
											return (
												<div className="py-2 my-1 border-b border-gray-400 flex justify-between">
													<div>{y.title}</div>
													<div>
														<span
															onClick={(ev) => {
																var options = {
																	...activeFilter.options,
																	slug:
																		activeFilter.options.slug == y.slug
																			? ""
																			: y.slug,
																};
																setAttributes({
																	activeFilter: {
																		...activeFilter,
																		options: options,
																	},
																});
															}}
															className={[
																activeFilter.options.slug == y.slug
																	? "bg-gray-700 hover:bg-gray-600 cursor-pointer p-1   text-white  text-sm"
																	: "bg-gray-400 cursor-pointer p-1   text-white  text-sm",
															]}>
															<span className="dashicons dashicons-yes-alt"></span>
														</span>
														<span
															onClick={(ev) => {
																filterable.options.filters[i].items.splice(
																	j,
																	1
																);
																var options = {
																	...filterable.options,
																	filters: filterable.options.filters,
																};
																setAttributes({
																	filterable: {
																		...filterable,
																		options: options,
																	},
																});
															}}
															className="cursor-pointer p-1  text-white bg-red-600 text-sm">
															<span className="dashicon dashicons dashicons-no-alt"></span>
														</span>
													</div>
												</div>
											);
										})}
										{/* {filterableTerms.length == 0 && (
                          <div className='bg-gray-200 p-2 mt-2'>No Terms Found</div>
                        )} */}
										{isBusy && (
											<div className="border-b border-gray-400 my-2 pb-1 bg-gray-200 p-2">
												<Spinner />
											</div>
										)}
										{filterableTerms.length > 0 && (
											<div className="bg-gray-200 p-2 mt-2">
												{filterableTerms.map((x) => {
													return (
														<div
															title="Click Add terms"
															className="border-b border-gray-400 my-2 pb-1 cursor-pointer"
															onClick={(ev) => {
																if (x.slug) {
																	var ss = filterable.options.filters[
																		i
																	].items.concat({
																		id: x.term_id,
																		slug: x.slug,
																		title: x.name,
																		count: x.count,
																	});
																	filterable.options.filters[i].items = ss;
																	var options = {
																		...filterable.options,
																		filters: filterable.options.filters,
																	};
																	setAttributes({
																		filterable: {
																			...filterable,
																			options: options,
																		},
																	});
																}
															}}>
															{x.name} ({x.count})
														</div>
													);
												})}
											</div>
										)}
									</PanelBody>
								);
							})}
						</div>
						<pre className="w-full">{JSON.stringify(filterable.options)}</pre>
						<PanelRow>
							<label htmlFor="" className="font-medium text-slate-900 ">
								{__("Enable Multifilter", "post-grid")}{" "}
							</label>
							<SelectControl
								label=""
								value={filterable.options.multifilter}
								options={[
									{ label: __("True", "post-grid"), value: true },
									{ label: "False", value: false },
								]}
								onChange={(newVal) => {
									var options = {
										...filterable.options,
										multifilter: newVal,
									};
									setfilterable({ ...filterable, options: options });
								}}
							/>
						</PanelRow>
						<PanelRow>
							<label htmlFor="" className="font-medium text-slate-900 ">
								{__("Enable Filter Toggle", "post-grid")}{" "}
							</label>
							<SelectControl
								label=""
								value={filterable.options.filterToggle}
								options={[
									{ label: "Yes", value: "yes" },
									{ label: "no", value: "no" },
								]}
								onChange={(newVal) => {
									var options = {
										...filterable.options,
										filterToggle: newVal,
									};
									setfilterable({ ...filterable, options: options },
									);
								}}
							/>
						</PanelRow>
						{filterable.options.multifilter && (
							<>
								<PanelRow>
									<label htmlFor="" className="font-medium text-slate-900 ">
										{__("Logic Within Group", "post-grid")}{" "}
									</label>
									<SelectControl
										label=""
										value={filterable.options.logicWithinGroup}
										options={[
											{ label: "OR", value: "or" },
											{ label: "AND", value: "and" },
										]}
										onChange={(newVal) => {
											var options = {
												...filterable.options,
												logicWithinGroup: newVal,
											};
											setfilterable({ ...filterable, options: options },
											);
										}}
									/>
								</PanelRow>
								<PanelRow>
									<label htmlFor="" className="font-medium text-slate-900 ">
										{__("Logic Between Groups", "post-grid")}{" "}
									</label>
									<SelectControl
										label=""
										value={filterable.options.logicBetweenGroups}
										options={[
											{ label: "OR", value: "or" },
											{ label: "AND", value: "and" },
										]}
										onChange={(newVal) => {
											var options = {
												...filterable.options,
												logicBetweenGroups: newVal,
											};
											setfilterable({ ...filterable, options: options });
										}}
									/>
								</PanelRow>
							</>
						)}
						<PanelRow>
							<label htmlFor="" className="font-medium text-slate-900 ">
								{__("Show Sort Filter", "post-grid")}{" "}
							</label>
							<SelectControl
								label=""
								value={filterable.options.showSort}
								options={[
									{ label: "No", value: "no" },
									{ label: "Yes", value: "yes" },
								]}
								onChange={(newVal) => {
									var options = { ...filterable.options, showSort: newVal };
									setfilterable({ ...filterable, options: options });
								}}
							/>
						</PanelRow>
						<PanelRow>
							<label htmlFor="" className="font-medium text-slate-900 ">
								{__("Show Random Filter", "post-grid")}{" "}
							</label>
							<SelectControl
								label=""
								value={filterable.options.showRandom}
								options={[
									{ label: "No", value: "no" },
									{ label: "Yes", value: "yes" },
								]}
								onChange={(newVal) => {
									var options = { ...filterable.options, showRandom: newVal };
									setfilterable({ ...filterable, options: options });
								}}
							/>
						</PanelRow>
						<PanelRow>
							<label htmlFor="" className="font-medium text-slate-900 ">
								{__("Show Clear Filter", "post-grid")}{" "}
							</label>
							<SelectControl
								label=""
								value={filterable.options.showClear}
								options={[
									{ label: "No", value: "no" },
									{ label: "Yes", value: "yes" },
								]}
								onChange={(newVal) => {
									var options = { ...filterable.options, showClear: newVal };
									setfilterable({ ...filterable, options: options });
								}}
							/>
						</PanelRow>
						<PanelRow>
							<label htmlFor="" className="font-medium text-slate-900 ">
								{__("Show All Filter", "post-grid")}{" "}
							</label>
							<SelectControl
								label=""
								value={filterable.options.showAll}
								options={[
									{ label: "No", value: "no" },
									{ label: "Yes", value: "yes" },
								]}
								onChange={(newVal) => {
									var options = { ...filterable.options, showAll: newVal };
									setfilterable({ ...filterable, options: options });
								}}
							/>
						</PanelRow>
						<PanelRow>
							<label>{__("Items Per Page", "post-grid")}</label>
							<InputControl
								type="number"
								value={
									filterable.options.perPage != undefined
										? filterable.options.perPage
										: 6
								}
								onChange={(newVal) => {
									var options = { ...filterable.options, perPage: newVal };
									setfilterable({ ...filterable, options: options });
								}}
							/>
						</PanelRow>
					</PanelBody>
					<PanelBody
						className="font-medium text-slate-900 "
						title={__("Filter", "post-grid")}
						initialOpen={false}>
						{/* <PGtabs
							activeTab="styles"
							orientation="horizontal"
							activeClass="active-tab"
							onSelect={(tabName) => {}}
							tabs={[
								{
									name: "styles",
									title: "Styles",
									icon: pencil,
									className: "tab-style",
								},
								{
									name: "css",
									title: "CSS Library",
									icon: cloud,
									className: "tab-css",
								},
							]}>
							<PGtab name="styles"> */}
						{/* <PGStyles
									obj={filterable}
									onChange={onChangeStyleFilterable}
									onAdd={onAddStyleFilterable}
									onRemove={onRemoveStyleFilterable}
									onReset={onResetFilterable}
									onBulkAdd={onBulkAddFilterable}
								/> */}
						<PGStyles
							obj={filterable}
							onChange={(sudoScource, newVal, attr) =>
								onChangeStyle(
									sudoScource,
									newVal,
									attr,
									filterable,
									setfilterable
								)
							}
							onAdd={(sudoScource, key) =>
								onAddStyle(sudoScource, key, filterable, setfilterable)
							}
							onRemove={(sudoScource, key) =>
								onRemoveStyle(sudoScource, key, filterable, setfilterable)
							}
							onReset={(sudoSources) =>
								onResetStyle(sudoSources, filterable, setfilterable)
							}
							onBulkAdd={(sudoSource, cssObj) =>
								onBulkAddStyle(sudoSource, cssObj, filterable, setfilterable)
							}
						/>
						{/* </PGtab> */}
						{/* <PGtab name="css">
								<PGCssLibrary
									blockId={blockId}
									obj={filterable}
									onChange={onPickCssLibraryFilterable}
								/>
							</PGtab> */}
						{/* </PGtabs> */}
					</PanelBody>
					<PanelBody
						className="font-medium text-slate-900 "
						title={__("Active Filter", "post-grid")}
						initialOpen={false}>
						{/* <PGtabs
							activeTab="styles"
							orientation="horizontal"
							activeClass="active-tab"
							onSelect={(tabName) => {}}
							tabs={[
								{
									name: "styles",
									title: "Styles",
									icon: pencil,
									className: "tab-style",
								},
								{
									name: "css",
									title: "CSS Library",
									icon: cloud,
									className: "tab-css",
								},
							]}>
							<PGtab name="styles"> */}
						{/* <PGStyles
							obj={activeFilter}
							onChange={onChangeStyleActiveFilter}
							onAdd={onAddStyleActiveFilter}
							onRemove={onRemoveStyleActiveFilter}
							onReset={onResetActiveFilter}
							onBulkAdd={onBulkAddActiveFilter}
						/> */}
						<PGStyles
							obj={activeFilter}
							onChange={(sudoScource, newVal, attr) =>
								onChangeStyle(
									sudoScource,
									newVal,
									attr,
									activeFilter,
									setactiveFilter
								)
							}
							onAdd={(sudoScource, key) =>
								onAddStyle(sudoScource, key, activeFilter, setactiveFilter)
							}
							onRemove={(sudoScource, key) =>
								onRemoveStyle(sudoScource, key, activeFilter, setactiveFilter)
							}
							onReset={(sudoSources) =>
								onResetStyle(sudoSources, activeFilter, setactiveFilter)
							}
							onBulkAdd={(sudoSource, cssObj) =>
								onBulkAddStyle(
									sudoSource,
									cssObj,
									activeFilter,
									setactiveFilter
								)
							}
						/>
						{/* </PGtab>
							<PGtab name="css">
								<PGCssLibrary
									blockId={blockId}
									obj={activeFilter}
									onChange={onPickCssLibraryActiveFilter}
								/>
							</PGtab>
						</PGtabs> */}
					</PanelBody>
					<PanelBody
						className="font-medium text-slate-900 "
						title={__("Filter Group", "post-grid")}
						initialOpen={false}>
						{/* <PGtabs
							activeTab="styles"
							orientation="horizontal"
							activeClass="active-tab"
							onSelect={(tabName) => {}}
							tabs={[
								{
									name: "styles",
									title: "Styles",
									icon: pencil,
									className: "tab-style",
								},
								{
									name: "css",
									title: "CSS Library",
									icon: cloud,
									className: "tab-css",
								},
							]}>
							<PGtab name="styles"> */}
						{/* <PGStyles
							obj={filterGroup}
							onChange={onChangeStyleFilterGroup}
							onAdd={onAddStyleFilterGroup}
							onRemove={onRemoveStyleFilterGroup}
							onReset={onResetFilterGroup}
							onBulkAdd={onBulkAddFilterGroup}
						/> */}
						<PGStyles
							obj={filterGroup}
							onChange={(sudoScource, newVal, attr) =>
								onChangeStyle(
									sudoScource,
									newVal,
									attr,
									filterGroup,
									setfilterGroup
								)
							}
							onAdd={(sudoScource, key) =>
								onAddStyle(sudoScource, key, filterGroup, setfilterGroup)
							}
							onRemove={(sudoScource, key) =>
								onRemoveStyle(sudoScource, key, filterGroup, setfilterGroup)
							}
							onReset={(sudoSources) =>
								onResetStyle(sudoSources, filterGroup, setfilterGroup)
							}
							onBulkAdd={(sudoSource, cssObj) =>
								onBulkAddStyle(sudoSource, cssObj, filterGroup, setfilterGroup)
							}
						/>
						{/* </PGtab>
							<PGtab name="css">
								<PGCssLibrary
									blockId={blockId}
									obj={filterGroup}
									onChange={onPickCssLibraryFilterGroup}
								/>
							</PGtab>
						</PGtabs> */}
					</PanelBody>
					<PanelBody
						className="font-medium text-slate-900 "
						title={__("Filter Group Wrap", "post-grid")}
						initialOpen={false}>
						{/* <PGtabs
							activeTab="styles"
							orientation="horizontal"
							activeClass="active-tab"
							onSelect={(tabName) => {}}
							tabs={[
								{
									name: "styles",
									title: "Styles",
									icon: pencil,
									className: "tab-style",
								},
								{
									name: "css",
									title: "CSS Library",
									icon: cloud,
									className: "tab-css",
								},
							]}>
							<PGtab name="styles"> */}
						{/* <PGStyles
							obj={filterGroupWrap}
							onChange={onChangeStyleFilterGroupWrap}
							onAdd={onAddStyleFilterGroupWrap}
							onRemove={onRemoveStyleFilterGroupWrap}
							onReset={onResetFilterGroupWrap}
							onBulkAdd={onBulkAddFilterGroupWrap}
						/> */}
						<PGStyles
							obj={filterGroupWrap}
							onChange={(sudoScource, newVal, attr) =>
								onChangeStyle(
									sudoScource,
									newVal,
									attr,
									filterGroupWrap,
									setfilterGroupWrap
								)
							}
							onAdd={(sudoScource, key) =>
								onAddStyle(
									sudoScource,
									key,
									filterGroupWrap,
									setfilterGroupWrap
								)
							}
							onRemove={(sudoScource, key) =>
								onRemoveStyle(
									sudoScource,
									key,
									filterGroupWrap,
									setfilterGroupWrap
								)
							}
							onReset={(sudoSources) =>
								onResetStyle(sudoSources, filterGroupWrap, setfilterGroupWrap)
							}
							onBulkAdd={(sudoSource, cssObj) =>
								onBulkAddStyle(
									sudoSource,
									cssObj,
									filterGroupWrap,
									setfilterGroupWrap
								)
							}
						/>
						{/* </PGtab>
							<PGtab name="css">
								<PGCssLibrary
									blockId={blockId}
									obj={filterGroup}
									onChange={onPickCssLibraryFilterGroupWrap}
								/>
							</PGtab>
						</PGtabs> */}
					</PanelBody>
					{/* // */}

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
										value={item?.options?.class}
										className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
										onChange={(newVal) => {
											var optionsX = {
												...item,
												options: {
													...item?.options,
													class: newVal,
												},
											};
											setitem(optionsX);
										}}
									/>
								</div>
							</PGtab>
							<PGtab name="styles">
								<PGStyles
									obj={item}
									onChange={(sudoScource, newVal, attr) =>
										onChangeStyle(sudoScource, newVal, attr, item, setitem)
									}
									onAdd={(sudoScource, key) =>
										onAddStyle(sudoScource, key, item, setitem)
									}
									onRemove={(sudoScource, key) =>
										onRemoveStyle(sudoScource, key, item, setitem)
									}
									onReset={(sudoSources) =>
										onResetStyle(sudoSources, item, setitem)
									}
									onBulkAdd={(sudoSource, cssObj) =>
										onBulkAddStyle(sudoSource, cssObj, item, setitem)
									}
								/>
							</PGtab>
						</PGtabs>
					</PanelBody>

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
										onResetStyle(sudoSources, paginationWrap, setpaginationWrap)
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
										onResetStyle(sudoSources, paginationItem, setpaginationItem)
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



					<PanelBody title="Navs & Labels" initialOpen={false}>
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
							title="Nav Item"
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
												setnavsWrap(optionsX);
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
							title="Active Nav Item"
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
											value={activeNavItem?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
											onChange={(newVal) => {
												var optionsX = {
													...activeNavItem,
													options: {
														...activeNavItem?.options,
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
										obj={activeNavItem}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(
												sudoScource,
												newVal,
												attr,
												activeNavItem,
												setactiveNavItem
											)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(
												sudoScource,
												key,
												activeNavItem,
												setactiveNavItem
											)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(
												sudoScource,
												key,
												activeNavItem,
												setactiveNavItem
											)
										}
										onReset={(sudoSources) =>
											onResetStyle(sudoSources, activeNavItem, setactiveNavItem)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(
												sudoSource,
												cssObj,
												activeNavItem,
												setactiveNavItem
											)
										}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>

						<PanelBody
							className="font-medium text-slate-900 "
							title="Nav Label"
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
											value={navLabel?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
											onChange={(newVal) => {
												var optionsX = {
													...navLabel,
													options: {
														...navLabel?.options,
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
										obj={navLabel}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(
												sudoScource,
												newVal,
												attr,
												navLabel,
												setnavLabel
											)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(sudoScource, key, navLabel, setnavLabel)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(sudoScource, key, navLabel, setnavLabel)
										}
										onReset={(sudoSources) =>
											onResetStyle(sudoSources, navLabel, setnavLabel)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(sudoSource, cssObj, navLabel, setnavLabel)
										}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>
						<PanelBody
							className="font-medium text-slate-900 "
							// title="Label Icon"
							opened={isProFeature ? false : null}
							title={
								<span className="flex justify-between w-full gap-2">
									<span>{__("Label Icon", "team")}</span>
									{isProFeature ? (
										<span
											className="bg-amber-500 px-2 py-1  no-underline rounded-sm  cursor-pointer text-white "
											onClick={(ev) => {
												window.open(
													"https://comboblocks.com/pricing/",
													"_blank"
												);
											}}>
											{__("Pro", "team")}
										</span>
									) : (
										""
									)}
								</span>
							}
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
									<PanelRow>
										<label htmlFor="" className="font-medium text-slate-900 ">
											{__("Choose Label Icon", "team")}
										</label>
										<PGIconPicker
											library={labelIcon?.options?.library}
											srcType={labelIcon?.options?.srcType}
											iconSrc={labelIcon?.options?.iconSrc}
											onChange={(arg) => {
												var labelIconX = { ...labelIcon };

												var optionsX = {
													...labelIconX.options,
													srcType: arg.srcType,
													library: arg.library,
													iconSrc: arg.iconSrc,
												};

												labelIconX.options = optionsX;
												setlabelIcon(labelIconX);
											}}
										/>
									</PanelRow>

									<PanelRow>
										<label htmlFor="" className="font-medium text-slate-900 ">
											{__("Icon position", "team")}
										</label>
										<SelectControl
											label=""
											value={labelIcon?.options?.position}
											options={[
												{
													label: __("Choose Position", "team"),
													value: "",
												},
												{
													label: __("Before Label", "team"),
													value: "beforeLabel",
												},
												{
													label: __("After Label", "team"),
													value: "afterLabel",
												},
												{
													label: __("Before Label Text", "team"),
													value: "beforeLabelText",
												},
												{
													label: __("After Label Text", "team"),
													value: "afterLabelText",
												},
											]}
											onChange={(newVal) => {
												var labelIconX = { ...labelIcon };

												var optionsX = {
													...labelIconX.options,
													position: newVal,
												};

												labelIconX.options = optionsX;
												setlabelIcon(labelIconX);
											}}
										/>
									</PanelRow>
									<div className="flex  my-5  justify-between items-center">
										<label className="" htmlFor="">
											{__("Class", "team")}
										</label>
										<PGinputText
											value={labelIcon?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid max-w-[400px]"
											onChange={(newVal) => {
												var optionsX = {
													...labelIcon,
													options: {
														...labelIcon?.options,
														class: newVal,
													},
												};
												setlabelIcon(optionsX);
											}}
										/>
									</div>
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={labelIcon}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(
												sudoScource,
												newVal,
												attr,
												labelIcon,
												setlabelIcon
											)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(sudoScource, key, labelIcon, setlabelIcon)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(sudoScource, key, labelIcon, setlabelIcon)
										}
										onReset={(sudoSources) =>
											onResetStyle(sudoSources, labelIcon, setlabelIcon)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(
												sudoSource,
												cssObj,
												labelIcon,
												setlabelIcon
											)
										}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>
						<PanelBody
							className="font-medium text-slate-900 "
							// title="Label Counter"
							opened={isProFeature ? false : null}
							title={
								<span className="flex justify-between w-full gap-2">
									<span>{__("Label Counter", "team")}</span>
									{isProFeature ? (
										<span
											className="bg-amber-500 px-2 py-1  no-underline rounded-sm  cursor-pointer text-white "
											onClick={(ev) => {
												window.open(
													"https://comboblocks.com/pricing/",
													"_blank"
												);
											}}>
											{__("Pro", "team")}
										</span>
									) : (
										""
									)}{" "}
								</span>
							}
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
									<PanelRow>
										<label htmlFor="" className="font-medium text-slate-900 ">
											{__("Counter position", "team")}
										</label>
										<SelectControl
											label=""
											value={labelCounter?.options?.position}
											options={[
												{
													label: __("Choose Position", "team"),
													value: "",
												},
												{ label: __("Left", "team"), value: "left" },
												{ label: __("Right", "team"), value: "right" },
												{
													label: __("Before Label Text", "team"),
													value: "beforeLabelText",
												},
												{
													label: __("After Label Text", "team"),
													value: "afterLabelText",
												},
											]}
											onChange={(newVal) => {
												var labelCounterX = { ...labelCounter };

												var optionsX = {
													...labelCounterX.options,
													position: newVal,
												};

												labelCounterX.options = optionsX;
												setlabelCounter(labelCounterX);
											}}
										/>
									</PanelRow>
									<div className="flex  my-5  justify-between items-center">
										<label className="" htmlFor="">
											{__("Class", "team")}
										</label>
										<PGinputText
											value={labelCounter?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
											onChange={(newVal) => {
												var optionsX = {
													...labelCounter,
													options: {
														...labelCounter?.options,
														class: newVal,
													},
												};
												setlabelCounter(optionsX);
											}}
										/>
									</div>
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={labelCounter}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(
												sudoScource,
												newVal,
												attr,
												labelCounter,
												setlabelCounter
											)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(
												sudoScource,
												key,
												labelCounter,
												setlabelCounter
											)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(
												sudoScource,
												key,
												labelCounter,
												setlabelCounter
											)
										}
										onReset={(sudoSources) =>
											onResetStyle(sudoSources, labelCounter, setlabelCounter)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(
												sudoSource,
												cssObj,
												labelCounter,
												setlabelCounter
											)
										}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>
					</PanelBody>

					<PanelBody title="Panels" initialOpen={false}>
						<PanelBody
							className="font-medium text-slate-900 "
							title="Panel Wrap"
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
											value={panelWrap?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
											onChange={(newVal) => {
												var optionsX = {
													...panelWrap,
													options: {
														...panelWrap?.options,
														class: newVal,
													},
												};
												setpanelWrap(optionsX);
											}}
										/>
									</div>
									<PanelRow>
										<label htmlFor="" className="flex gap-2 items-center">
											Autoembed
											<span
												className="cursor-pointer"
												title="Click to know more"
												onClick={() => {
													setHelp({
														id: "autoembedSetting",
														enable: true,
													});
												}}>
												<Icon icon={help} />
											</span>
										</label>
										<InputToggle
											value={panelWrap?.options?.autoembed}
											onChange={(newVal) => {
												var optionsX = {
													...panelWrap,
													options: {
														...panelWrap?.options,
														autoembed: newVal,
													},
												};
												setpanelWrap(optionsX);
											}}
										/>
									</PanelRow>

									<PanelRow>
										<label htmlFor="" className="flex gap-2 items-center">
											Shortcodes
											<span
												className="cursor-pointer"
												title="Click to know more"
												onClick={() => {
													setHelp({
														id: "shortcodesSetting",
														enable: true,
													});
												}}>
												<Icon icon={help} />
											</span>
										</label>

										<InputToggle
											value={panelWrap?.options?.shortcodes}
											onChange={(newVal) => {
												var optionsX = {
													...panelWrap,
													options: {
														...panelWrap?.options,
														shortcodes: newVal,
													},
												};
												setpanelWrap(optionsX);
											}}
										/>
									</PanelRow>
									<PanelRow>
										<label htmlFor="" className="flex gap-2 items-center">
											wpautop
											<span
												className="cursor-pointer"
												title="Click to know more"
												onClick={() => {
													setHelp({
														id: "wpautopSetting",
														enable: true,
													});
												}}>
												<Icon icon={help} />
											</span>
										</label>

										<InputToggle
											value={panelWrap?.options?.wpautop}
											onChange={(newVal) => {
												var optionsX = {
													...panelWrap,
													options: {
														...panelWrap?.options,
														wpautop: newVal,
													},
												};
												setpanelWrap(optionsX);
											}}
										/>
									</PanelRow>

									<PanelRow>
										<label htmlFor="" className="flex gap-2 items-center">
											In Animation
										</label>

										<PGDropdown
											position="bottom right"
											variant="secondary"
											buttonTitle={
												popupEntranceAnimateBasic[
													panelWrap?.options?.inAnimation
												] == undefined
													? __("Choose", "team")
													: popupEntranceAnimateBasic[
														panelWrap?.options?.inAnimation
													].label
											}
											options={popupEntranceAnimateBasic}
											onChange={(newVal) => {
												if (isProFeature) {
													addNotifications({
														title: "Opps its pro!",
														panelWrap:
															"This feature only avilable in premium version",
														type: "error",
													});
													return;
												}

												var optionsX = {
													...panelWrap,
													options: {
														...panelWrap?.options,
														inAnimation: newVal.value,
													},
												};
												setpanelWrap(optionsX);
											}}
											values=""></PGDropdown>
									</PanelRow>
									<PanelRow>
										<label htmlFor="" className="flex gap-2 items-center">
											Out Animation
										</label>

										<PGDropdown
											position="bottom right"
											variant="secondary"
											buttonTitle={
												popupCloseAnimateBasic[
													panelWrap?.options?.outAnimation
												] == undefined
													? __("Choose", "team")
													: popupCloseAnimateBasic[
														panelWrap?.options?.outAnimation
													].label
											}
											options={popupCloseAnimateBasic}
											onChange={(newVal) => {
												if (isProFeature) {
													addNotifications({
														title: "Opps its pro!",
														panelWrap:
															"This feature only avilable in premium version",
														type: "error",
													});
													return;
												}

												var optionsX = {
													...panelWrap,
													options: {
														...panelWrap?.options,
														outAnimation: newVal.value,
													},
												};
												setpanelWrap(optionsX);
											}}
											values=""></PGDropdown>
									</PanelRow>

									<div className="flex  my-5  justify-between items-center">
										<label className="" htmlFor="">
											{__("Animation duration", "team")}
										</label>
										<PGinputText
											value={panelWrap?.options?.animationDuration}
											placeholder={"1000"}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid max-w-[400px]"
											onChange={(newVal) => {
												var optionsX = {
													...panelWrap,
													options: {
														...panelWrap?.options,
														animationDuration: newVal,
													},
												};
												setpanelWrap(optionsX);
											}}
										/>
									</div>
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={panelWrap}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(
												sudoScource,
												newVal,
												attr,
												panelWrap,
												setpanelWrap
											)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(sudoScource, key, panelWrap, setpanelWrap)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(sudoScource, key, panelWrap, setpanelWrap)
										}
										onReset={(sudoSources) =>
											onResetStyle(sudoSources, panelWrap, setpanelWrap)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(
												sudoSource,
												cssObj,
												panelWrap,
												setpanelWrap
											)
										}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>
						<PanelBody
							className="font-medium text-slate-900 "
							title="Panel Wrap Active"
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
											value={panelWrapActive?.options?.class}
											className="!py-1 px-2 !border-2 !border-[#8c8f94] !border-solid w-[210px]"
											onChange={(newVal) => {
												var optionsX = {
													...panelWrapActive,
													options: {
														...panelWrapActive?.options,
														class: newVal,
													},
												};
												setpanelWrapActive(optionsX);
											}}
										/>
									</div>
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={panelWrapActive}
										onChange={(sudoScource, newVal, attr) =>
											onChangeStyle(
												sudoScource,
												newVal,
												attr,
												panelWrapActive,
												setpanelWrapActive
											)
										}
										onAdd={(sudoScource, key) =>
											onAddStyle(
												sudoScource,
												key,
												panelWrapActive,
												setpanelWrapActive
											)
										}
										onRemove={(sudoScource, key) =>
											onRemoveStyle(
												sudoScource,
												key,
												panelWrapActive,
												setpanelWrapActive
											)
										}
										onReset={(sudoSources) =>
											onResetStyle(
												sudoSources,
												panelWrapActive,
												setpanelWrapActive
											)
										}
										onBulkAdd={(sudoSource, cssObj) =>
											onBulkAddStyle(
												sudoSource,
												cssObj,
												panelWrapActive,
												setpanelWrapActive
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

class EditTestimonialFilterable extends Component {
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

export default EditTestimonialFilterable;
