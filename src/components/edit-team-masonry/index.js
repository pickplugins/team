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
	ToggleControl,
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
	settings,
	starEmpty,
	starFilled,
	styles,
} from "@wordpress/icons";
import breakPoints from "../../breakpoints";
import PGDropdown from "../dropdown";
import PGinputSelect from "../input-select";
import PGinputText from "../input-text";
import InputToggle from "../input-toggle";
import WPEditor from "../input-wp-editor";

import LayoutGenerator from "../LayoutGenerator";
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
	var [itemWrap, setitemWrap] = useState(teamData.itemWrap);
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

	var [masonryOptions, setmasonryOptions] = useState(
		teamData.masonryOptions
	);

	var [prev, setprev] = useState(teamData?.prev);
	var [prevIcon, setprevIcon] = useState(teamData?.prevIcon);
	var [next, setnext] = useState(teamData?.next);
	var [nextIcon, setnextIcon] = useState(teamData?.nextIcon);
	var [sliderOptions, setsliderOptions] = useState(
		teamData?.sliderOptions
	);
	var [sliderOptionsRes, setsliderOptionsRes] = useState(
		teamData?.sliderOptionsRes
	);

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
	var [editLayouts, seteditLayouts] = useState(false); // Using the hook.
	var [loopLayout, setloopLayout] = useState(teamData.loopLayout); // Using the hook.

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
		teamDataX.masonryOptions = masonryOptions;
		setteamData(teamDataX);
	}, [masonryOptions]);

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.paginationWrap = paginationWrap;
		setteamData(teamDataX);
	}, [paginationWrap]);

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.paginationItem = paginationItem;
		setteamData(teamDataX);
	}, [paginationItem]);

	useEffect(() => {
		var teamDataX = { ...teamData };
		teamDataX.paginationItemActive = paginationItemActive;
		setteamData(teamDataX);
	}, [paginationItemActive]);

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

	var RemoveMasonryArg = function ({ index }) {
		return (
			<span
				className="cursor-pointer hover:bg-red-500 hover:text-white "
				onClick={(ev) => {
					var masonryOptionsX = { ...masonryOptions };
					delete masonryOptionsX[index];
					setmasonryOptions(masonryOptionsX);
				}}>
				<Icon icon={close} />
			</span>
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

	const updateTermQueryArgs = (newVal, index) => {
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

	useEffect(() => {
		var numberOfColumns = masonryOptions.numberOfColumns;
		var gutter =
			parseInt(masonryOptions.gutter) * (parseInt(numberOfColumns) - 1);
		var clac = "calc((100% - " + gutter + "px)/" + numberOfColumns + ")";
		var itemWrapX = {
			...itemWrap,
			styles: { ...itemWrap.styles, width: { Desktop: clac } },
		};
		setitemWrap(itemWrapX);
		// onChangeStyleItem("styles", clac, "width");
	}, [masonryOptions.numberOfColumns]);
	useEffect(() => {
		var gutter = parseInt(masonryOptions.gutter);
		var itemWrapX = {
			...itemWrap,
			styles: { ...itemWrap.styles, marginBottom: { Desktop: `${gutter}px` } },
		};
		setitemWrap(itemWrapX);
		// onChangeStyleItem("styles", clac, "width");
	}, [masonryOptions.gutter]);

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

	const handleDelete = (id) => {
		// Filter out the item with the specified id
		const updatedItems = Object.fromEntries(
			Object.entries(itemQueryArgs).filter(([key, item]) => item.id !== id)
		);
		setitemQueryArgs(updatedItems);
	};

	var masonryOptionsArgs = {
		numberOfColumns: { label: "Number Of Columns", value: 3 },
		gutter: { label: "Gutter", value: 15 },
		itemSelector: { label: "Item Selector", value: ".pg-masonry-wrap-item" },
		columnWidth: { label: "Column Width", value: ".pg-masonry-wrap-item" },
		percentPosition: { label: "Percent Position", value: true },
		horizontalOrder: { label: "Horizontal Order", value: true },
		stamp: { label: "Stamp", value: ".stamp" },
		fitWidth: { label: "Fit Width", value: true },
		originLeft: { label: "Origin Left", value: true },
		originTop: { label: "Origin Top", value: true },
		stagger: { label: "Stagger", value: 30 },
		resize: { label: "Resize", value: true },
	};

	function onChangeLayouts(loopLayout) {
		var teamDataX = { ...teamData };
		teamDataX.loopLayout = loopLayout;
		setteamData(teamDataX);

		setloopLayout(loopLayout);
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
																				videoType[item?.videoUrl?.type] ==
																					undefined
																					? __("Choose", "team")
																					: videoType[item?.videoUrl?.type]
																						.label
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
																			value={item?.videoUrl?.link}
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
																			value={item?.person?.name}
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
																			value={item?.person?.jobTitle}
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
																					{item?.person?.avatar?.srcUrl && (
																						<img
																							src={item?.person?.avatar?.srcUrl}
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
																			value={item?.person?.company?.name}
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
																			value={item?.person?.company?.website}
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
																		value={item?.person?.company?.logoUrl?.id}
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
						title={__("Masonry", "post-grid")}
						initialOpen={true}>
						<PanelRow className="my-3">
							<PGDropdown
								position="bottom right"
								variant="secondary"
								buttonTitle={"Choose"}
								options={masonryOptionsArgs}
								// onChange={(option, index) => {
								// 	var masonryOptionsX = { ...masonryOptions };
								// 	masonryOptionsX[index] = option.value;
								// 	setAttributes({ masonryOptions: masonryOptionsX });
								// }}
								onChange={(newVal, index) => {
									var masonryOptionsX = { ...masonryOptions };
									masonryOptionsX[index] = newVal.value;
									setmasonryOptions(masonryOptionsX);
								}}
								values=""></PGDropdown>
						</PanelRow>
						{JSON.stringify(masonryOptions)}
						{Object.entries(masonryOptions).map((item, index) => {
							var id = item[0];
							var value = item[1];
							return (
								<div key={index}>
									{id == "itemSelector" && (
										<PanelRow>
											<div className="flex items-center">
												<RemoveMasonryArg index={id} />
												<label
													htmlFor=""
													className="font-medium text-slate-900 ">
													Item Selector
												</label>
											</div>
											<InputControl
												value={masonryOptions.itemSelector}
												onChange={(newVal) => {
													setmasonryOptions({
														...masonryOptions,
														itemSelector: newVal,
													});
												}}
											/>
										</PanelRow>
									)}
									{id == "gutter" && (
										<PanelRow>
											<div className="flex items-center">
												<RemoveMasonryArg index={id} />
												<label
													htmlFor=""
													className="font-medium text-slate-900 ">
													Gutter
												</label>
											</div>
											<InputControl
												type="number"
												value={masonryOptions.gutter}
												onChange={(newVal) => {
													setmasonryOptions({
														...masonryOptions,
														gutter: parseInt(newVal),
													});
													// onChangeStyleItem(
													// 	"styles",
													// 	parseInt(newVal) + "px",
													// 	"marginBottom"
													// );
												}}
											/>
										</PanelRow>
									)}
									{id == "columnWidth" && (
										<PanelRow>
											<div className="flex items-center">
												<RemoveMasonryArg index={id} />
												<label
													htmlFor=""
													className="font-medium text-slate-900 ">
													Column width
												</label>
											</div>
											<InputControl
												value={masonryOptions.columnWidth}
												onChange={(newVal) => {
													setmasonryOptions({
														...masonryOptions,
														columnWidth: newVal,
													});
												}}
											/>
										</PanelRow>
									)}
									{id == "numberOfColumns" && (
										<PanelRow>
											<div className="flex items-center">
												<RemoveMasonryArg index={id} />
												<label
													htmlFor=""
													className="font-medium text-slate-900 ">
													Number Of Columns
												</label>
											</div>
											<InputControl
												type="number"
												value={masonryOptions.numberOfColumns}
												onChange={(newVal) => {
													setmasonryOptions({
														...masonryOptions,
														numberOfColumns: parseInt(newVal),
													});
												}}
											/>
										</PanelRow>
									)}
									{id == "horizontalOrder" && (
										<PanelRow>
											<div className="flex items-center">
												<RemoveMasonryArg index={id} />
												<ToggleControl
													label="Horizontal Order?"
													help={
														masonryOptions.horizontalOrder
															? "Horizontal Order Enabled"
															: "Horizontal Order Disabled"
													}
													checked={masonryOptions.horizontalOrder}
													onChange={(newHorizontalOrder) => {
														const updatedMasonryOptions = {
															...masonryOptions,
															horizontalOrder: newHorizontalOrder,
														};
														setmasonryOptions(updatedMasonryOptions);
													}}
												/>
											</div>
										</PanelRow>
									)}
									{id == "percentPosition" && (
										<PanelRow>
											<div className="flex items-center">
												<RemoveMasonryArg index={id} />
												<ToggleControl
													label="Percent Position?"
													help={
														masonryOptions.percentPosition
															? "Percent Position Enabled"
															: "Percent Position Disabled"
													}
													checked={masonryOptions.percentPosition}
													onChange={(newPercentPosition) => {
														const updatedMasonryOptions = {
															...masonryOptions,
															percentPosition: newPercentPosition,
														};
														setmasonryOptions(updatedMasonryOptions);
													}}
												/>
											</div>
										</PanelRow>
									)}
									{id == "stamp" && (
										<PanelRow>
											<div className="flex items-center">
												<RemoveMasonryArg index={id} />
												<label
													htmlFor=""
													className="font-medium text-slate-900 ">
													Stamp
												</label>
											</div>
										</PanelRow>
									)}
									{id == "fitWidth" && (
										<PanelRow>
											<div className="flex items-center">
												<RemoveMasonryArg index={id} />
												<ToggleControl
													label="Fit Width?"
													help={
														masonryOptions.fitWidth
															? "Fit Width Enabled"
															: "Fit Width Disabled."
													}
													checked={masonryOptions.fitWidth}
													onChange={(fitWidth) => {
														const updatedMasonryOptions = {
															...masonryOptions,
															fitWidth: fitWidth,
														};
														setmasonryOptions(updatedMasonryOptions);
													}}
												/>
											</div>
										</PanelRow>
									)}
									{id == "originLeft" && (
										<PanelRow>
											<div className="flex items-center">
												<RemoveMasonryArg index={id} />
												<ToggleControl
													label="Origin Left?"
													help={
														masonryOptions.originLeft
															? "Origin Left Enabled"
															: "Origin Left Disabled."
													}
													checked={masonryOptions.originLeft}
													onChange={(originLeft) => {
														const updatedMasonryOptions = {
															...masonryOptions,
															originLeft: originLeft,
														};
														setmasonryOptions(updatedMasonryOptions);
													}}
												/>
											</div>
										</PanelRow>
									)}
									{id == "originTop" && (
										<PanelRow>
											<div className="flex items-center">
												<RemoveMasonryArg index={id} />
												<ToggleControl
													label="Origin Top?"
													help={
														masonryOptions.originTop
															? "Origin Top Enabled"
															: "Origin Top Disabled."
													}
													checked={masonryOptions.originTop}
													onChange={(originTop) => {
														const updatedMasonryOptions = {
															...masonryOptions,
															originTop: originTop,
														};
														setmasonryOptions(updatedMasonryOptions);
													}}
												/>
											</div>
										</PanelRow>
									)}
									{id == "stagger" && (
										<PanelRow>
											<div className="flex items-center">
												<RemoveMasonryArg index={id} />
												<ToggleControl
													label="Stagger?"
													help={
														masonryOptions.stagger
															? "Stagger Enabled"
															: "Stagger Disabled."
													}
													checked={masonryOptions.stagger}
													onChange={(stagger) => {
														const updatedMasonryOptions = {
															...masonryOptions,
															stagger: stagger,
														};
														setmasonryOptions(updatedMasonryOptions);
													}}
												/>
											</div>
										</PanelRow>
									)}
									{id == "resize" && (
										<PanelRow>
											<div className="flex items-center">
												<RemoveMasonryArg index={id} />
												<ToggleControl
													label="Resize?"
													help={
														masonryOptions.resize
															? "Resize Enabled"
															: "Resize Disabled."
													}
													checked={masonryOptions.resize}
													onChange={(resize) => {
														const updatedMasonryOptions = {
															...masonryOptions,
															resize: resize,
														};
														setmasonryOptions(updatedMasonryOptions);
													}}
												/>
											</div>
										</PanelRow>
									)}
								</div>
							);
						})}
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
									<label htmlFor="">{__("Pagination Type", "post-grid")}</label>
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
				</>
			)}
		</div>
	);
}

class EditTestimonialMasonry extends Component {
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

export default EditTestimonialMasonry;
