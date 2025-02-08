import { MediaUpload, RichText } from "@wordpress/block-editor";
import {
	DateTimePicker,
	Icon,
	PanelBody,
	Popover,
} from "@wordpress/components";
import { store as coreStore } from "@wordpress/core-data";
import { useSelect } from "@wordpress/data";
import { __ } from "@wordpress/i18n";
import {
	addCard,
	calendar,
	close,
	copy,
	help,
	menu,
	page,
	starEmpty,
	starFilled,
} from "@wordpress/icons";
import React, { useState } from "react";
import { ReactSortable } from "react-sortablejs";
import PGDropdown from "../dropdown";
import PGinputSelect from "../input-select";
import PGinputText from "../input-text";
import WPEditor from "../input-wp-editor";

// const TestimonialItems = ({
// 	items,
// 	setitems,
// 	globalOptions,
// 	setglobalOptions,
// 	customerData,
// 	setHelp,
// 	itemQueryArgs,
// 	setitemQueryArgs,
// 	addNotifications,
// }) => {
	const TestimonialItems = ({
		itemsState,
		globalOptionsState,
		itemQueryState,
		customerData,
		setHelp,
		addNotifications,
	}) => {
		const { items, setitems } = itemsState;
		const { globalOptions, setglobalOptions } = globalOptionsState;
		const { itemQueryArgs, setitemQueryArgs } = itemQueryState;
		const [itemActive, setitemActive] = useState(999);
		var [datePicker, setdatePicker] = useState(9999999);
		function generate3Digit() {
			return Math.floor(100 + Math.random() * 900);
		}

		var [AIWriter, setAIWriter] = useState(false); // Using the hook.
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
		const updatePostQueryArgs = (newVal, key) => {
			setitemQueryArgs((prevState) => ({
				...prevState,
				[key]: {
					...prevState[key],
					value: newVal,
				},
			}));
		};

		const updateTermQueryArgs = (newVal, index) => {
			var itemQueryArgsX = [...itemQueryArgs];
			itemQueryArgsX[index].value = newVal;
			setitemQueryArgs(itemQueryArgsX);
		};

		const handleDelete = (id) => {
			// Filter out the item with the specified id
			const updatedItems = Object.fromEntries(
				Object.entries(itemQueryArgs).filter(([key, item]) => item.id !== id)
			);
			setitemQueryArgs(updatedItems);
		};
		var formattedPrompt =
			"Respond only with question answer as json array and no other text. Do not include any explanations, introductions, or concluding remarks.";
		var postTypes = [];
		const postTypesData = useSelect(
			(select) => select(coreStore).getPostTypes({ per_page: -1 }),
			[]
		);
		postTypesData !== null &&
			postTypesData.map((x) => {
				postTypes.push({ value: x.slug, label: x.name });
			});
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

		var itemSources = {
			manual: { label: "Manual", value: "manual" },
			posts: {
				label: "Posts",
				value: "posts",
				isPro: customerData.isPro ? false : true,
			},
		};

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
		var videoType = {
			choose: { label: "Choose", value: "" },
			youtube: { label: "YouTube", value: "youtube" },
		};

		return (
			<div>
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
												} catch (error) {}
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
														.catch((err) => {});
												} catch (error) {}
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
												videoUrl: "",
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
															label: __("None", "testimonial"),
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
														{
															label: "NOT BETWEEN",
															value: "NOT BETWEEN",
														},
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
															label: __("None", "testimonial"),
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
																		setdatePicker(
																			datePicker == index ? 9999999 : index
																		);
																	}}>
																	<Icon icon={calendar} fill="#fff" size="20" />
																</span>

																{datePicker == index && (
																	<Popover position="bottom right">
																		<div className="p-2 rounded-md">
																			<DateTimePicker
																				currentDate={item?.date}
																				onChange={(newDate) => {
																					const timestamp = newDate;
																					const date = timestamp.split("T")[0];
																					setitems((prevItems) => {
																						const updatedItems = [...prevItems];
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
																		videoType[item?.videoType] == undefined
																			? __("Choose", "testimonial")
																			: videoType[item?.videoType].label
																	}
																	options={videoType}
																	onChange={(newVal) => {
																		setitems((prevItems) => {
																			const updatedItems = [...prevItems];
																			updatedItems[index] = {
																				...updatedItems[index],
																				videoType: newVal.value,
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
																	value={item?.videoUrl}
																	onChange={(newVal) => {
																		setitems((prevItems) => {
																			const updatedItems = [...prevItems];
																			updatedItems[index] = {
																				...updatedItems[index],
																				videoUrl: newVal,
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
																	value={item?.personName}
																	onChange={(newVal) => {
																		setitems((prevItems) => {
																			const updatedItems = [...prevItems];
																			updatedItems[index] = {
																				...updatedItems[index],
																				personName: newVal,
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
																	value={item?.personJobTitle}
																	onChange={(newVal) => {
																		setitems((prevItems) => {
																			const updatedItems = [...prevItems];
																			updatedItems[index] = {
																				...updatedItems[index],
																				personJobTitle: newVal,
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
																			personAvatar: {
																				id: media.id,
																				srcUrl: media.url,
																			},
																		};
																		return updatedItems;
																	});
																}}
																onClose={() => {}}
																allowedTypes={["image"]}
																value={item?.person.avatar?.id}
																render={({ open }) => {
																	return (
																		<div className="flex flex-col items-center gap-2">
																			{item?.personAvatar?.srcUrl && (
																				<img
																					src={item?.personAvatar?.srcUrl}
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
																								personAvatar: {
																									id: "",
																									srcUrl: "",
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
																	value={item?.companyName}
																	onChange={(newVal) => {
																		setitems((prevItems) => {
																			const updatedItems = [...prevItems];
																			updatedItems[index] = {
																				...updatedItems[index],
																				companyName: newVal,
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
																	value={item?.companyWebsite}
																	onChange={(newVal) => {
																		setitems((prevItems) => {
																			const updatedItems = [...prevItems];
																			updatedItems[index] = {
																				...updatedItems[index],
																				companyWebsite: newVal,
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
																			companyLogo: {
																				id: media.id,
																				srcUrl: media.url,
																			},
																		};
																		return updatedItems;
																	});
																}}
																onClose={() => {}}
																allowedTypes={["image"]}
																value={item?.companyLogo?.id}
																render={({ open }) => {
																	return (
																		<div className="flex flex-col items-center gap-2">
																			{item?.companyLogo?.srcUrl && (
																				<img
																					src={item?.companyLogo?.srcUrl}
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
																								companyLogo: {
																									id: "",
																									srcUrl: "",
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
					)}
				</PanelBody>
			</div>
		);
	};

export default TestimonialItems;
