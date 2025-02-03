const { Component, useEffect } = wp.element;
import {
	__experimentalInputControl as InputControl,
	PanelRow,
	SelectControl,
	ToggleControl,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { brush, columns } from "@wordpress/icons";
import React, { useState } from "react";
import { ReactSortable } from "react-sortablejs";

import PGtabs from "../../components/tabs";

import PGtab from "../../components/tab";
import PGDropdown from "../dropdown";
import PGStyles from "../styles";
import TreeView from "./TreeView";

const sortableOptions = {
	animation: 150,
	fallbackOnBody: true,
	swapThreshold: 0.65,
	group: "nested",
};

const parentSortableOptions = {
	animation: 150,
	fallbackOnBody: true,
	swapThreshold: 0.65,
	group: "parent-group", // Unique group for parent
};

const childSortableOptions = {
	animation: 150, // Keep desired shared options
	fallbackOnBody: true,
	dragoverBubble: true,
	swapThreshold: 0.65,
	group: "child-group", // Different group from parent
};

const elementTemplates = {
	title: {
		type: "title",
		label: "Title",
		content: "Dummy Title",
		options: {},
		styles: {},
	},
	content: {
		type: "content",
		label: "Content",
		content:
			"Combo Blocks has completely revolutionized the way our team collaboratings. Its seamless integration and flexible features make managing projects so much easier. We've significantly reduced time spent on coordination, allowing us to focus more on creativity.",
		options: {},
		styles: {},
	},
	date: {
		type: "date",
		label: "Date",
		content: "12/09/2025",
		options: { format: "" },
		styles: {},
	},
	tags: {
		type: "tags",
		label: "Tags",
		content: "Dummy tags",
		options: { separator: ", " },
		styles: {},
	},

	personName: {
		type: "personName",
		label: "Person Name",
		content: "Emma Wallace",
		options: {},
		styles: {},
	},
	personJobTitle: {
		type: "personJobTitle",
		label: "Person Job Title",
		content: "Creative Director",
		options: {},
		styles: {},
	},
	personAvatar: {
		type: "personAvatar",
		label: "Person Avatar",
		content: "",
		options: { thumbnailSize: "full" },
		styles: {
			width: {
				Desktop: "100px",
			},
			height: {
				Desktop: "auto",
			},
		},
	},
	personCompanyName: {
		type: "personCompanyName",
		label: "Company Name",
		content: "Creative  Studio LLC",
		options: {},
		styles: {},
	},
	personCompanyWebsite: {
		type: "personCompanyWebsite",
		label: "Company Website",
		content: "https://createllc.com",
		options: { linkTo: true, target: "_blank" },
		styles: {},
	},
	personCompanyLogo: {
		type: "personCompanyLogo",
		label: "Company Logo",
		content: "",
		options: { thumbnailSize: "full" },
		styles: {
			width: {
				Desktop: "100px",
			},
			height: {
				Desktop: "auto",
			},
		},
	},

	text: {
		type: "text",
		label: "Text",
		content: "New Text Element",
		options: {},
		styles: {},
		label: "Text Block",
	},
	container: {
		type: "container",
		label: "Container",
		content: "New Container",
		children: [],
		options: {},
		styles: {},
	},
	// root: {
	// 	type: "root",
	// 	label: "Root",
	// 	content: "New root",
	// 	children: [],
	// 	styles: {},
	// },
};

function BlockWrapper({
	block,
	handleBlockUpdate,
	onTemplateDrop,
	draggedTemplate,
	setCurretnElement,
	setactiveTab,
}) {
	return (
		<>
			{/* {block.type != "root" && block.type != "container" && (
				<div
					id={`element-${block.id}`}
					className={`${block.type}`}
					onClick={(ev) => {
						setCurretnElement(block.id);
						setactiveTab("edit");
					}}>
					{block.content} - {block.id}
				</div>
			)} */}

			{block.type == "content" && (
				<div
					id={`element-${block.id}`}
					className={`${block.type}`}
					onClick={(ev) => {
						setCurretnElement(block.id);
					}}>
					{block.content}
				</div>
			)}
			{block.type == "title" && (
				<div
					id={`element-${block.id}`}
					className={`${block.type}`}
					onClick={(ev) => {
						setCurretnElement(block.id);
					}}>
					{block.content}
				</div>
			)}
			{block.type == "date" && (
				<div
					id={`element-${block.id}`}
					className={`${block.type}`}
					onClick={(ev) => {
						setCurretnElement(block.id);
					}}>
					{block.content}
				</div>
			)}
			{block.type == "rating" && (
				<div
					id={`element-${block.id}`}
					className={`${block.type}`}
					onClick={(ev) => {
						setCurretnElement(block.id);
					}}>
					<span className=" inline-block fas fa-star"></span>
					<span className=" inline-block fas fa-star"></span>
					<span className=" inline-block fas fa-star"></span>
					<span className=" inline-block fas fa-star"></span>
					<span className=" inline-block fas fa-star"></span>
				</div>
			)}
			{block.type == "personName" && (
				<div
					id={`element-${block.id}`}
					className={`${block.type}`}
					onClick={(ev) => {
						setCurretnElement(block.id);
					}}>
					{block.content}
				</div>
			)}
			{block.type == "personJobTitle" && (
				<div
					id={`element-${block.id}`}
					className={`${block.type}`}
					onClick={(ev) => {
						setCurretnElement(block.id);
					}}>
					{block.content}
				</div>
			)}
			{block.type == "personCompanyWebsite" && (
				<div
					id={`element-${block.id}`}
					className={`${block.type}`}
					onClick={(ev) => {
						setCurretnElement(block.id);
					}}>
					{block.content}
				</div>
			)}
			{block.type == "personCompanyName" && (
				<div
					id={`element-${block.id}`}
					className={`${block.type}`}
					onClick={(ev) => {
						setCurretnElement(block.id);
					}}>
					{block.content}
				</div>
			)}
			{block.type == "text" && (
				<div
					id={`element-${block.id}`}
					className={`${block.type}`}
					onClick={(ev) => {
						setCurretnElement(block.id);
					}}>
					{block.content}
				</div>
			)}
			{block.type == "personAvatar" && (
				<img
					id={`element-${block.id}`}
					className={`${block.type}`}
					src="https://comboblocks.com/server/wp-content/uploads/2024/09/team-member-6.jpg"
					onClick={(ev) => {
						setCurretnElement(block.id);
					}}
				/>
			)}
			{block.type == "personCompanyLogo" && (
				<img
					id={`element-${block.id}`}
					className={`${block.type}`}
					src="https://cdn4.iconfinder.com/data/icons/logos-and-brands/512/30_Atlassian_logo_logos-256.png"
					onClick={(ev) => {
						setCurretnElement(block.id);
					}}
				/>
			)}

			{block.type === "container" && (
				<Container
					block={block}
					handleBlockUpdate={handleBlockUpdate}
					onTemplateDrop={onTemplateDrop}
					draggedTemplate={draggedTemplate}
					setCurretnElement={setCurretnElement}
					setactiveTab={setactiveTab}
				/>
			)}

			{block.type === "root" && (
				<Root
					block={block}
					handleBlockUpdate={handleBlockUpdate}
					onTemplateDrop={onTemplateDrop}
					draggedTemplate={draggedTemplate}
					setCurretnElement={setCurretnElement}
					setactiveTab={setactiveTab}
				/>
			)}
		</>
	);
}

function Container({
	block,
	handleBlockUpdate,
	onTemplateDrop,
	draggedTemplate,
	setCurretnElement,
	setactiveTab,
}) {
	const handleDrop = (e) => {
		e.preventDefault();
		e.stopPropagation();

		if (draggedTemplate) {
			onTemplateDrop(draggedTemplate, block.id);
		}
	};

	return (
		<template
			style={{ display: "block" }}
			onDragOver={(e) => e.preventDefault()}
			onDrop={handleDrop}>
			{block.children.length == 0 && (
				<div className="text-center text-xl">+</div>
			)}

			<ReactSortable
				list={block.children || []}
				setList={(newState) => handleBlockUpdate(newState, block.id)}
				{...childSortableOptions}
				// Directly map child elements to avoid extra div
				id={`element-${block.id}`}
				className="container ">
				{block.children?.map((child) => (
					<BlockWrapper
						key={child.id}
						block={child}
						handleBlockUpdate={handleBlockUpdate}
						onTemplateDrop={onTemplateDrop}
						draggedTemplate={draggedTemplate}
						setCurretnElement={setCurretnElement}
						setactiveTab={setactiveTab}
					/>
				))}
			</ReactSortable>
		</template>
	);
}

function Root({
	block,
	handleBlockUpdate,
	onTemplateDrop,
	draggedTemplate,
	setCurretnElement,
	setactiveTab,
}) {
	const handleDrop = (e) => {
		e.preventDefault();
		e.stopPropagation();

		if (draggedTemplate) {
			onTemplateDrop(draggedTemplate, block.id);
		}
	};

	return (
		<template
			style={{ display: "block" }}
			className=""
			onDragOver={(e) => e.preventDefault()}
			onDrop={handleDrop}>
			{block.children.length == 0 && (
				<div className="text-center text-xl">+</div>
			)}
			<ReactSortable
				list={block.children || []}
				setList={(newState) => handleBlockUpdate(newState, block.id)}
				{...childSortableOptions}
				// Directly map child elements to avoid extra div
				className="root border border-dashed border-gray-400"
				id={`element-${block.id}`}>
				{block.children?.map((child) => (
					<BlockWrapper
						key={child.id}
						block={child}
						handleBlockUpdate={handleBlockUpdate}
						onTemplateDrop={onTemplateDrop}
						draggedTemplate={draggedTemplate}
						setCurretnElement={setCurretnElement}
						setactiveTab={setactiveTab}
					/>
				))}
			</ReactSortable>
		</template>
	);
}

const TreeNode = ({ node, setselectedElementId }) => {
	const [collapsed, setCollapsed] = useState(true); // Initially collapsed

	const handleToggle = () => {
		setCollapsed((prev) => !prev); // Toggle the collapsed state
	};
	// const handlesetactiveTab = (id) => {
	// 	setactiveTab(id); // Toggle the collapsed state
	// };

	return (
		<div
			style={{
				marginLeft: "5px",
				borderLeft: "1px solid #ccc",
				paddingLeft: "5px",
			}}>
			<div
				className="cursor-pointer p-1 hover:bg-slate-400"
				onClick={(ev) => {
					setselectedElementId(node.id);
				}}>
				{/* Toggle button */}
				{node.children && node.children.length > 0 && (
					<button
						onClick={handleToggle}
						className="cursor-pointer bg-slate-500 px-2 py-1"
						aria-label={collapsed ? "Expand" : "Collapse"}>
						{collapsed ? "+" : "-"}
					</button>
				)}
				{node.type} | #{node.id}
			</div>
			{/* Render children only if not collapsed */}
			{!collapsed && node.children && (
				<div>
					{node.children.map((child) => (
						<TreeNode
							key={child.id}
							node={child}
							setselectedElementId={setselectedElementId}
						/>
					))}
				</div>
			)}
		</div>
	);
};

const Tree = ({ data, setselectedElementId }) => {
	return (
		<div>
			{data.map((node) => (
				<TreeNode
					key={node.id}
					node={node}
					setselectedElementId={setselectedElementId}
				/>
			))}
		</div>
	);
};

export default function LayoutGenerator({ onChange, layouts, postData }) {
	var [postId, setpostId] = useState(postData.ID); // Using the hook.

	var defaultBlocks = [
		{
			id: 1,
			type: "root",
			children: [
				{
					id: 2,
					type: "container",
					children: [
						{
							id: "3",
							type: "title",
							label: "Title",
							content: "Dummy Title",
							options: { linkTo: "" },
							styles: {},
						},
						{
							id: "4",
							type: "content",
							label: "Content",
							content:
								"Combo Blocks has completely revolutionized the way our team collaboratings. Its seamless integration and flexible features make managing projects so much easier. We've significantly reduced time spent on coordination, allowing us to focus more on creativity.",
							options: {},
							styles: {},
						},
						{
							id: "5",
							type: "date",
							label: "date",
							content: "Dummy date",
							options: { format: "" },
							styles: {},
						},
						{
							id: "6",
							type: "rating",
							label: "rating",
							content: "Dummy rating",
							options: { type: "star", defaultValue: 5, source: "" },
							styles: {},
						},
						{
							id: "7",
							type: "personName",
							label: "Person Name",
							content: "Emma Wallace",
							options: {},
							styles: {},
						},
						{
							id: "8",
							type: "personJobTitle",
							label: "Person Job Title",
							content: "Creative Director",
							options: {},
							styles: {},
						},
					],
					parent_id: 1,
					styles: {},
				},
			],
			parent_id: null,
			styles: {},
		},
	];

	const [blocks, setBlocks] = useState(
		layouts.length == 0 ? defaultBlocks : layouts
	);
	const [activeTab, setactiveTab] = useState("elements");

	useEffect(() => {
		onChange(blocks);
	}, [blocks]);

	const [selectedElement, setselectedElement] = useState(null);
	const [selectedElementId, setselectedElementId] = useState(null);
	const [draggedTemplate, setDraggedTemplate] = useState(null);

	console.log(selectedElement);

	useEffect(() => {
		const traverse = (items) => {
			const result = [];

			for (const item of items) {
				if (item.id === selectedElementId) {
					//removedItem = { ...selectedElement }; // Found the item, don't include it
					result.push(selectedElement);
				} else {
					const newItem = { ...item };
					if (newItem.children) {
						newItem.children = traverse(newItem.children);
					}
					result.push(newItem);
				}
			}

			return result;
		};

		const newBlocks = traverse(blocks);

		onChange(newBlocks);
		setBlocks(newBlocks);
	}, [selectedElement]);

	const setCurretnElement = (id = null) => {
		setselectedElementId(id);
		findSelectedElement(blocks, id);
		setactiveTab("edit");
	};

	const generatingUniqueId = () => {
		const ids = [];
		const collectIds = (items) => {
			items.forEach((item) => {
				ids.push(item.id);
				if (item.children) collectIds(item.children);
			});
		};
		collectIds(blocks);
		return ids.length > 0 ? Math.max(...ids) + 1 : 1;
	};

	const handleTemplateAdd = (template, parentId = null) => {
		const newItem = {
			id: generatingUniqueId(),
			type: template.type,
			content: template.content,
			parent_id: parentId,
			options: template.options,
			styles: template.styles,
			children: template.children ? [] : undefined,
		};

		setBlocks((prev) => {
			const addToParent = (items) =>
				items.map((item) => {
					if (item.id === parentId) {
						return {
							...item,
							children: [...(item.children || []), newItem],
						};
					}
					if (item.children) {
						return {
							...item,
							children: addToParent(item.children),
						};
					}
					return item;
				});

			return parentId === null ? [...prev, newItem] : addToParent(prev);
		});
	};

	const findAndRemoveItem = (blocks, id) => {
		let removedItem = null;

		const traverse = (items) => {
			const result = [];

			for (const item of items) {
				if (item.id === id) {
					removedItem = { ...item }; // Found the item, don't include it
				} else {
					const newItem = { ...item };
					if (newItem.children) {
						newItem.children = traverse(newItem.children);
					}
					result.push(newItem);
				}
			}

			return result;
		};

		const newBlocks = traverse(blocks);
		return { newBlocks, removedItem };
	};
	const findSelectedElement = (blocks, id) => {
		let removedItem = null;

		const traverse = (items) => {
			const result = [];

			for (const item of items) {
				if (item.id === id) {
					removedItem = { ...item }; // Found the item, don't include it
					setselectedElement(removedItem);
				} else {
					const newItem = { ...item };
					if (newItem.children) {
						newItem.children = traverse(newItem.children);
					}
					result.push(newItem);
				}
			}

			return result;
		};

		traverse(blocks);
	};

	const handleBlockUpdate = (updatedList, parentId = null) => {
		setBlocks((prevBlocks) => {
			let newBlocks = [...prevBlocks];

			updatedList = updatedList.map((item) => {
				// If the item exists elsewhere in the tree, remove it first
				const searchResult = findAndRemoveItem(newBlocks, item.id);

				// if (searchResult.removedItem) {
				// 	newBlocks = searchResult.newBlocks;
				// 	// Preserve the original item's properties while updating parent_id
				// 	return {
				// 		...searchResult.removedItem,
				// 		parent_id: parentId,
				// 	};
				// }

				// If the item wasn't found elsewhere, it's new to this location
				return {
					...item,
					parent_id: parentId,
				};
			});

			// If this is a top-level update, return the new list
			if (parentId === null) {
				return updatedList;
			}

			// Otherwise, find the parent container and update its children
			const updateChildren = (blocks) => {
				return blocks.map((block) => {
					if (block.id === parentId) {
						return { ...block, children: updatedList };
					}
					if (block.children) {
						return {
							...block,
							children: updateChildren(block.children),
						};
					}
					return block;
				});
			};

			return updateChildren(newBlocks);
		});
	};

	var breakPointX = "Desktop";
	var myStore = wp.data.select("postgrid-shop");

	function onChangeStyle(sudoScource, newVal, attr, propertyType, setProperty) {
		var path = [sudoScource, attr, breakPointX];
		let obj = { ...propertyType };
		const object = myStore.updatePropertyDeep(obj, path, newVal);

		console.log(object);
		console.log(setProperty);

		setProperty(object);
	}

	function onAddStyle(sudoScource, key, propertyType, setProperty) {
		var path = [sudoScource, key, breakPointX];
		let obj = { ...propertyType };
		const object = myStore.addPropertyDeep(obj, path, "");
		console.log(object);
		console.log(setProperty);

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

	var dateFormats = {
		"Y-M-d": { label: "2022-Feb-25", value: "Y-M-d" },
		"Y-m-d": { label: "2022-05-25", value: "Y-m-d" },
		"d-m-y": { label: "25-05-2022", value: "d-m-y" },
		"d/m/y": { label: "25/05/2022", value: "d/m/y" },
		"y-m-d": { label: "2022-05-25", value: "y-m-d" },
		"y/m/d": { label: "2022/05/25", value: "y/m/d" },
		"D M y": { label: "Sun Feb 2022", value: "D M y" },
		"D M d, y": { label: "Sun Feb 11, 2022", value: "D M d, y" },
		"M D d, y": { label: "Feb Sun 11, 2022", value: "M D d, y" },
		"M d, y": { label: "Feb 11, 2022", value: "M d, y" },
		"F d, y": { label: "February 11, 2022", value: "F d, y" },
		"d M y": { label: "25 Feb 2022", value: "d M y" },
	};
	var ratingType = {
		none: { label: "Choose", value: "" },
		star: { label: "Star", value: "star" },
	};

	var thumbSize = {
		full: {
			label: "Full",
			value: "full",
			height: "",
			width: "",
			crop: false,
		},
		thumbnail: {
			label: "thumbnail(150*150)",
			value: "thumbnail",
			height: 150,
			width: 150,
		},
		medium: {
			label: "medium(300*300)",
			value: "medium",
			height: 300,
			width: 300,
		},
		medium_large: {
			label: "medium large(768*0)",
			value: "medium_large",
			height: 0,
			width: 768,
		},
		large: {
			label: "large(1024*1024)",
			value: "large",
			height: 1024,
			width: 1024,
		},
		"1536x1536": {
			label: "1536x1536(1536*1536)",
			value: "1536x1536",
			height: 1536,
			width: 1536,
		},
		"2048x2048": {
			label: "2048x2048(2048*2048)",
			value: "2048x2048",
			height: 2048,
			width: 2048,
		},
		woocommerce_archive_thumbnail: {
			label: "woocommerce archive thumbnail(500*500)",
			value: "woocommerce_archive_thumbnail",
			height: 500,
			width: 500,
		},
		woocommerce_thumbnail: {
			label: "woocommerce thumbnail(300*300)",
			value: "woocommerce_thumbnail",
			height: 300,
			width: 300,
		},
		woocommerce_single: {
			label: "woocommerce single(600*0)",
			value: "woocommerce_single",
			height: 0,
			width: 600,
		},
		woocommerce_gallery_thumbnail: {
			label: "woocommerce gallery thumbnail(100*100)",
			value: "woocommerce_gallery_thumbnail",
			height: 100,
			width: 100,
		},
	};

	const handleChange = (type, value) => {
		setselectedElement({
			...selectedElement,
			options: {
				...selectedElement.options,
				[type]: value,
			},
		});
	};

	return (
		<div className="flex gap-3 bg-gray-100">
			<div className="w-[400px]">
				<PGtabs
					activeTab={activeTab}
					orientation=""
					stickyNavs={true}
					contentClass=" bg-white w-full"
					navItemClass="bg-gray-200 px-5 py-3 gap-2 grow "
					navItemLabelClass="flex-col "
					navItemSelectedClass="!bg-white"
					activeClass="active-tab"
					onSelect={(tab) => {
						setactiveTab(tab.name);
					}}
					tabs={[
						{
							name: "elements",
							title: "Elements",
							icon: columns,
							className: "elements",
						},
						{
							name: "edit",
							title: "Edit",
							icon: brush,
							className: "edit",
						},
					]}>
					<PGtab name="elements">
						<div className=" flex gap-2  p-4 flex-wrap">
							{Object.entries(elementTemplates).map((args) => {
								var index = args[0];
								var template = args[1];

								return (
									<div
										key={template.id}
										className="bg-slate-400 px-2 py-1 rounded-sm cursor-move  hover:bg-slate-500"
										draggable
										onDragStart={() => setDraggedTemplate(template)}
										onDragEnd={() => setDraggedTemplate(null)}>
										<span>{template.label}</span>
									</div>
								);
							})}
						</div>
					</PGtab>
					<PGtab name="edit">
						<div className="p-3">
							{selectedElement != null && (
								<div className="py-3">
									You are editing:{" "}
									<strong>
										{selectedElement != null
											? elementTemplates[selectedElement.type]?.label
											: ""}
									</strong>
								</div>
							)}
							{selectedElement != null && (
								<PanelRow>
									<label htmlFor="" className="font-medium text-slate-900 ">
										{__("Class", "post-grid")}
									</label>
									<InputControl
										value={selectedElement?.options?.class}
										onChange={(newVal) => {
											handleChange("class", newVal);
										}}
									/>
								</PanelRow>
							)}
							{/* {selectedElement?.options && (
								<>{JSON.stringify(selectedElement)}</>
							)}
							{selectedElement?.title && (
								<>{JSON.stringify(selectedElement?.title)}</>
							)} */}
							{selectedElement?.type == "date" && (
								<>
									<PanelRow className="mb-4">
										<label htmlFor="" className="font-medium text-slate-900 ">
											{__("Date Format", "post-grid")}
										</label>
										<PGDropdown
											position="bottom right"
											variant="secondary"
											options={dateFormats}
											// buttonTitle="Choose"
											buttonTitle={
												dateFormats[selectedElement.options.dateFormat] !=
													undefined
													? dateFormats[selectedElement.options.dateFormat]
														.label
													: __("Choose", "post-grid")
											}
											onChange={(option) => {
												handleChange("format", option.value);
											}}
											values={""}></PGDropdown>
									</PanelRow>
								</>
							)}
							{selectedElement?.type == "tags" && (
								<>
									<PanelRow>
										<label htmlFor="" className="font-medium text-slate-900 ">
											{__("Separator Text", "post-grid")}
										</label>
										<InputControl
											value={selectedElement.options.separator}
											onChange={(newVal) => {
												handleChange("separator", newVal);
											}}
										/>
									</PanelRow>
								</>
							)}
							{selectedElement?.type == "rating" && (
								<>
									<PanelRow className="mb-4">
										<label htmlFor="" className="font-medium text-slate-900 ">
											{__("Type", "post-grid")}
										</label>
										<PGDropdown
											position="bottom right"
											variant="secondary"
											options={ratingType}
											// buttonTitle="Choose"
											buttonTitle={
												ratingType[selectedElement.options.type] != undefined
													? ratingType[selectedElement.options.type].label
													: __("Choose", "post-grid")
											}
											onChange={(option) => {
												handleChange("type", option.value);
											}}
											values={""}></PGDropdown>
									</PanelRow>
									<PanelRow>
										<label htmlFor="" className="font-medium text-slate-900 ">
											{__("Default Value", "post-grid")}
										</label>
										<InputControl
											value={selectedElement.options.defaultValue}
											onChange={(newVal) => {
												handleChange("defaultValue", newVal);
											}}
										/>
									</PanelRow>
									<PanelRow>
										<label htmlFor="" className="font-medium text-slate-900 ">
											{__("Source", "post-grid")}
										</label>
										<InputControl
											value={selectedElement.options.source}
											onChange={(newVal) => {
												handleChange("defaultValue", source);
											}}
										/>
									</PanelRow>
								</>
							)}
							{selectedElement?.type == "personAvatar" && (
								<>
									<PanelRow className="mb-4">
										<label htmlFor="" className="font-medium text-slate-900 ">
											{__("Thumb Size", "post-grid")}
										</label>
										<PGDropdown
											position="bottom right"
											variant="secondary"
											options={thumbSize}
											// buttonTitle="Choose"
											buttonTitle={
												thumbSize[selectedElement.options.thumbnailSize] !=
													undefined
													? thumbSize[selectedElement.options.thumbnailSize]
														.label
													: __("Choose", "post-grid")
											}
											onChange={(option) => {
												handleChange("thumbnailSize", option.value);
											}}
											values={""}></PGDropdown>
									</PanelRow>
								</>
							)}
							{selectedElement?.type == "personCompanyLogo" && (
								<>
									<PanelRow className="mb-4">
										<label htmlFor="" className="font-medium text-slate-900 ">
											{__("Thumb Size", "post-grid")}
										</label>
										<PGDropdown
											position="bottom right"
											variant="secondary"
											options={thumbSize}
											// buttonTitle="Choose"
											buttonTitle={
												thumbSize[selectedElement.options.thumbnailSize] !=
													undefined
													? thumbSize[selectedElement.options.thumbnailSize]
														.label
													: __("Choose", "post-grid")
											}
											onChange={(option) => {
												handleChange("thumbnailSize", option.value);
											}}
											values={""}></PGDropdown>
									</PanelRow>
								</>
							)}
							{selectedElement?.type == "personCompanyWebsite" && (
								<>
									<PanelRow className="mb-4">
										<label htmlFor="" className="font-medium text-slate-900 ">
											{__("Link To", "post-grid")}
										</label>
										<ToggleControl
											label="Link To?"
											help={
												selectedElement.options.linkTo
													? "Srcset Enabled"
													: "Srcset Disabled."
											}
											checked={selectedElement.options.linkTo ? true : false}
											onChange={(e) => {
												handleChange("linkTo", !selectedElement.options.linkTo);
											}}
										/>
									</PanelRow>
									<PanelRow>
										<label htmlFor="" className="font-medium text-slate-900 ">
											{__("Link Target", "post-grid")}
										</label>
										<SelectControl
											label=""
											value={selectedElement.options.target}
											options={[
												{ label: __("Choose...", "post-grid"), value: "" },
												{ label: "_self", value: "_self" },
												{ label: "_blank", value: "_blank" },
												{ label: "_parent", value: "_parent" },
												{ label: "_top", value: "_top" },
											]}
											onChange={(newVal) => {
												handleChange("target", newVal);
											}}
										/>
									</PanelRow>
								</>
							)}

							{selectedElement?.styles && (
								<PGStyles
									obj={selectedElement}
									onChange={(sudoScource, newVal, attr) =>
										onChangeStyle(
											sudoScource,
											newVal,
											attr,
											selectedElement,
											setselectedElement
										)
									}
									onAdd={(sudoScource, key) =>
										onAddStyle(
											sudoScource,
											key,
											selectedElement,
											setselectedElement
										)
									}
									onRemove={(sudoScource, key) =>
										onRemoveStyle(
											sudoScource,
											key,
											selectedElement,
											setselectedElement
										)
									}
									onReset={(sudoSources) =>
										onResetStyle(
											sudoSources,
											selectedElement,
											setselectedElement
										)
									}
									onBulkAdd={(sudoSource, cssObj) =>
										onBulkAddStyle(
											sudoSource,
											cssObj,
											selectedElement,
											setselectedElement
										)
									}
								/>
							)}
						</div>
					</PGtab>
				</PGtabs>
			</div>

			<div className="flex-1 justify-between max-w-[450px] w-full min-h-full ">
				<div className="flex items-center justify-between bg-slate-400 px-3 py-3">
					<div className="text-[20px] font-bold">Preview</div>
				</div>

				<div id={`team-${postId}`} className="p-3 overflow-hidden">
					<ReactSortable
						list={blocks}
						setList={handleBlockUpdate}
						{...parentSortableOptions}>
						{blocks.map((block) => (
							<BlockWrapper
								key={block.id}
								block={block}
								handleBlockUpdate={handleBlockUpdate}
								onTemplateDrop={handleTemplateAdd}
								draggedTemplate={draggedTemplate}
								setCurretnElement={setCurretnElement}
								setactiveTab={setactiveTab}
							/>
						))}
					</ReactSortable>
				</div>
			</div>
			<div className="w-[300px]">
				<div className="border border-solid">
					<TreeView
						blocks={blocks}
						setBlocks={setBlocks}
						selected={selectedElementId}
						setSelected={setCurretnElement}
					/>
				</div>
			</div>
		</div>
	);
}
