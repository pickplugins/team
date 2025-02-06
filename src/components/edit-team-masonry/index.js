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
